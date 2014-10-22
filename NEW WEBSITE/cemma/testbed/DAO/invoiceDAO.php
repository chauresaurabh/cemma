<?php

include_once(DOCUMENT_ROOT."includes/database.php");
require_once(DOCUMENT_ROOT."includes/tableHandler.class.php");

class InvoiceDAO extends TableHandler{

	function InvoiceDAO(){
			
			$this->table = "Invoice";
			$this->id = "Number";
			$this->fields = array
			(
				'Manager_ID',
				'Gdate',
				'Invoiceno',
				'Year',
				'Name',
				'Fromdate',
				'Todate',
				'Total',
				'PO',
				'Status',
				'Manager_Name',
				'BegBalance',
				'RemBalance'		
			);
			
	}

	function getRoleID($invoicename){

		$roleID = 0;
		$sql = "select Number from Invoice where Name = '$invoicename'";
		$result = mysql_query($sql) or die(mysql_error());

		if(mysql_num_rows($result)>1){
			die("Result is not unique");
		}
		
		else{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
				$roleID = (int)$row['Number'];
			}
			
		}
		
		return $roleID;
		
	}
	
	function getOrderBy($id){
	 
		switch($id){
	
			case 1:
			return "Name";
			break;
		
			case 2:
			return "Fromdate";
			break;
			
			case 3: 
			return "Todate";
			break;
			
			case 4:
			return "Total";
			break;
			
			case 5:
			return "PO";
			break;
			
			case 6:
			return "Status";
			break;
			
			case 7:
			return "Gdate";
			break;

			default:
			return "Gdate";
			break;
			
	
		}
	}

	function searchInvoices($pagenum, $pageSize = 20, $orderby = '',$order = '', $invoiceNo, $year, $fromDate, $toDate, $criteria, $customerName, $minTotal, $maxTotal, $status, $ctype1, $ctype2, $ctype3){

	
		if($invoiceNo != '' && $year != '')
			$whereBy = " WHERE Invoiceno = '$invoiceNo' and Year = '$year'";

		else{
		
			$whereBy = " WHERE Gdate between '$fromDate' and '$toDate' ";
	
			if($customerName != '-1')
			{
				if($criteria=="customer")
				{
					$whereBy =$whereBy."and Invoice.Name = '$customerName' ";	
				}
				else if($criteria=="school")
				{
					$whereBy =$whereBy."and Invoice.Name IN ($customerName) ";
				}
			}
				
			
	
			if($minTotal == '')
				$minTotal = 0;
	
			if($maxTotal == '')
				$maxTotal = 999999999;
	
			$whereBy = $whereBy."and Total between '$minTotal' and '$maxTotal' ";
	
			if($status != '-1')
				$whereBy = $whereBy."and Status = '$status' ";
		}
		
		#ctype1: On-Campus
		#ctype2: Off-Campus
		#ctype3: Commercial
		
		if($ctype1!="" || $ctype2!="" || $ctype3!="")
		{
			$joinBy = "JOIN Customer ON Invoice.Name=Customer.Name";
			$whereBy = $whereBy." AND ( ";
			if ($ctype1=="On-Campus")
			{
				$whereBy = $whereBy."Customer.Type='$ctype1' ";
				if ($ctype2!="" && $ctype3!="")
				{
					$whereBy .= "OR ";
				}
			}
			if ($ctype2=="Off-Campus")
			{
				$whereBy = $whereBy."Customer.Type='$ctype2' ";
				if ($ctype3!="")
				{
					$whereBy .= "OR ";
				}
			}
			if ($ctype3=="Industry")
			{
				$whereBy = $whereBy."Customer.Type='$ctype3' ";
			}
			$whereBy = $whereBy.")";
			
			$whereBy = $joinBy." ".$whereBy;
		}
				
		
		$this->getList($pageSize, $orderby, $order, $whereBy, $pagenum);
	}

	function updateRecords($invoiceno, $Gdate){

		$sql = "UPDATE Customer_data SET Generated = '0', Gdate = '0000-00-00', invoiceno = 0 WHERE invoiceno = '$invoiceno' and Gdate = '$Gdate'";
		mysql_query($sql) or die ("Error in Updating Record");

	}
	
	function remove($id){

	 	$sql = "SELECT * FROM Invoice WHERE ".$this->id."='$id'";
		$result = mysql_query($sql) or die ("Error in Retrieving Invoice");

		while($row = mysql_fetch_array($result, MYSQL_ASSOC)){

		$invoiceno = $row['Invoiceno'];
		$Gdate = $row['Gdate'];

		}

		$query  = "DELETE from ".$this->table." where ".$this->id."='$id'";
		mysql_query($query);
		$this->updateRecords($invoiceno, $Gdate);

	}

}
?>