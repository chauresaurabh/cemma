<?php

include_once(DOCUMENT_ROOT."includes/database.php");
require_once(DOCUMENT_ROOT."includes/tableHandler.class.php");

class RecordDAO extends TableHandler{

	function RecordDAO(){
			
			$this->table = "Customer_data";
			$this->id = "Number";
			$this->fields = array
			(
				'Customer_ID',
				'Manager_ID',
				'Name',
				'Machine',
				'Qty',
				'Date',
				'Operator',
				'Type',
				'WithOperator',
				'Unit',
				'Total',
				'Generated',
				'Gdate',
				'Year',
				'invoiceno',
				'DiscountFlag',
				'DiscountQty',
				'UserCharged',
				'logouttime'
			);
			
	}

	function getOrderBy($id){
	 
		switch($id){
	
			case 1:
			return "Date";
			break;
		
			case 2:
			return "Name";
			break;
			
			case 3: 
			return "Qty";
			break;
			
			case 4:
			return "Machine";
			break;

			case 5:
			return "Operator";
			break;

			case 6:
			return "WithOperator";
			break;
			
			case 7: 
			return "Total";
			break;

			case 8:
			return "Gdate";
			break;

			default:
			return "Date";
			break;
			
	
		}
	}

	function searchRecords($pagenum, $pageSize = 20, $orderby = '',$order = '', $fromDate, $toDate, $customerName, $machineName, $minQty, $maxQty, $minTotal, $maxTotal, $woperator,$operatorName, $generated, $ctype1, $ctype2, $ctype3){

		$where = " WHERE Date between '$fromDate' and '$toDate' ";
	
		if($operatorName[0] != '-1') {
			$where.=" AND Operator IN (";
			if(count($operatorName)>1) {
				for($i=0;$i<count($operatorName)-1;$i++) {
					$where.="'".$operatorName[$i]."',";
				}
				$where.="'".$operatorName[count($operatorName)-1]."'";
			} else {
				$where.="'".$operatorName[0]."'";
			}
			$where.=") ";
		}
		
		if($machineName[0] != '-1') {
			$where.=" AND Machine IN (";
			if(count($machineName)>1) {
				for($i=0;$i<count($machineName)-1;$i++) {
					$where.="'".$machineName[$i]."',";
				}
				$where.="'".$machineName[count($machineName)-1]."'";
			} else {
				$where.="'".$machineName[0]."'";
			}
			$where.=") ";
		}
		
		if($customerName[0] != '-1') {
			$where.=" AND Name IN (";
			if(count($customerName)>1) {
				for($i=0;$i<count($customerName)-1;$i++) {
					$where.="'".$customerName[$i]."',";
				}
				$where.="'".$customerName[count($customerName)-1]."'";
			} else {
				$where.="'".$customerName[0]."'";
			}
			$where.=") ";
		}
		
		/*if($operatorName != '-1' && $operatorName != '')
			$where =$where."and Operator = '$operatorName' ";
	
		if($customerName != '-1' && $customerName != '')
			$where =$where."and Name = '$customerName' ";
	
		if($machineName != '-1' && $machineName != '')
			$where = $where."and Machine = '$machineName' ";*/
	
		if($minQty == '')
			$minQty = 0;
	
		if($maxQty == '')
			$maxQty = 99999999;
	
		$where = $where."and Qty between '$minQty' and '$maxQty' ";
	
		if($minTotal == '')
			$minTotal = 0;
	
		if($maxTotal == '')
			$maxTotal = 999999999;
	
		$where = $where."and Total between '$minTotal' and '$maxTotal' ";
	
		if($woperator != '-1' && $woperator != '')
			$where = $where."and WithOperator = '$woperator' ";
	
		if($generated != '-1' && $generated != '')
			$where = $where."and Generated = '$generated'";
	
		if($ctype1!="" || $ctype2!="" || $ctype3!=""){
			$where = $where." AND ( ";
			if ($ctype1=="On-Campus")
			{
				$where = $where." Type='$ctype1' ";
				if ($ctype2!="" && $ctype3!="")
				{
					$where .= "OR ";
				}
			}
			if ($ctype2=="Off-Campus")
			{
				$where = $where." Type='$ctype2' ";
				if ($ctype3!="")
				{
					$where .= "OR ";
				}
			}
			if ($ctype3=="Industry")
			{
				$where = $where." Type='$ctype3' ";
			}
			$where = $where.")";
		}
			
		$this->getList($pageSize, $orderby, $order, $where, $pagenum);
	
	}
	
	function findRecordsBetweenDates($customerName, $fromDate, $toDate){
	
		if(empty($customerName) || empty($fromDate) || empty($toDate)){
			return null;
		}
		
        $sql = "SELECT * from Customer_data WHERE Name = '$customerName' and Date between '$fromDate' and '$toDate' order by Date";
		$result = mysql_query($sql) or die ("Error in findRecordsBetweenDates in recordDAO");
		$recordList = array();
		while($row = mysql_fetch_object($result)){
			array_push($recordList, $row);
		}
		
		return $recordList;
	
	}
	
	
}
?>