<?php

include_once(DOCUMENT_ROOT."includes/database.php");
require_once(DOCUMENT_ROOT."includes/tableHandler.class.php");

class CustomerDAO extends TableHandler{

	function CustomerDAO(){
			
			$this->table = "Customer";
			$this->id = "Customer_ID";
			$this->fields = array
			(
				'Name',
				'Type',
				'Address1',
				'Address2',
				'City',
				'State',
				'Zip',
				'Phone',
				'EmailId',
				'Fax',
				'Activated',
				'Manager_ID',
				'Building',
				'MailCode',
				'Department',
				'Zip2',
				'ClassLevel',
				'Room',
				'AddressSelected',
				'LastName',
				'FirstName',
				'Uname',
				'AssistantName1',
				'AssistantEmail1',
				'AssistantPhone1',
				'AssistantName2',
				'AssistantEmail2',
				'AssistantPhone2',
				'School',
				//'AccountNum'
			);
			
	}

	function getRoleID($username){

		$roleID = 0;
		$sql = "select Role_ID from Customer where Uname = '$username'";
		$result = mysql_query($sql) or die(mysql_error());

		if(mysql_num_rows($result)>1){
			die("Result is not unique");
		}
		
		else{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
				$roleID = (int)$row['Role_ID'];
			}
			
		}
		
		return $roleID;
		
	}
	
	function getManagerName($managerId = 0,$loginName=0)
	{
	
		$name = "";
		$sql = "select Name from Customer where Role_ID = 1 and Manager_ID = ".$managerId." and UName= '".$loginName."'";
		$result = mysql_query($sql) or die(mysql_error());
		

		if(mysql_num_rows($result)>1){
			die("Result is not unique");	
		}
		
		else{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
				$name = $row['Name'];
			
			}
			
		}
		
		return $name;
	
	}
	
	function getOrderBy($id){
	 
		switch($id){
	
			case 1:
			return "Name";
			break;
		
			case 2:
			return "Uname";
			break;
			
			case 3: 
			return "EmailId";
			break;
			
			case 4:
			return "Activated";
			break;
			
			case 5:
			return "Department";
			break;
			
			case 6:
			return "School";
			break;
			
			case 7:
			return "Type";
			break;
			
			default:
			return "Name";
			break;
		}
	}
	
	function getSearchCriteria($searchFieldsArray){
	
	$where = 'WHERE ';
	if($searchFieldsArray[1] != NULL)	$where.= 'Name like "%'.$searchFieldsArray[1].'%" AND ';
	if($searchFieldsArray[2] != NULL)	$where.= 'UName like "%'.$searchFieldsArray[2].'%" AND ';
	if($searchFieldsArray[3] != NULL)	$where.= 'EmailId like "%'.$searchFieldsArray[3].'%" AND ';
	
	//remove the last and
	if (strpos($where, ' AND ') !== false) {
		$where = substr($where,0,-4);
	}
	else{ // Where clause is empty so remove 'WHERE'
		$where = '';
	}
	
	return $where;

	}
	
	function getCurrentCustomerList()
	{
		$this->getList(200,'Name',0, "WHERE Activated=1");
	}
	function getArchivedCustomerList()
	{
		$this->getList(200,'Name',0, "WHERE Activated=0");
	}
 	 
	function searchCusts($pagenum, $pageSize = 20, $orderby = '',$order = '', $dept, $school, $custType){
		$whereBy = " WHERE ";
		if($dept[0] != '*') {
			$whereBy.="Department IN (";
			if(count($dept)>1) {
				for($i=0;$i<count($dept)-1;$i++) {
					$whereBy.="'".$dept[$i]."',";
				}
				$whereBy.="'".$dept[count($dept)-1]."'";
			} else {
				$whereBy.="'".$dept[0]."'";
			}
			$whereBy.=")";
		}
		if($school[0] != '*') {
			if(strcmp( $whereBy," WHERE ") == 0) {
				$whereBy.=" school IN (";
			} else {
				$whereBy.=" AND school IN (";
			}
			if(count($school)>1) {
				for($i=0;$i<count($school)-1;$i++) {
					$whereBy.="'".$school[$i]."',";
				}
				$whereBy.="'".$school[count($school)-1]."'";
			} else {
				$whereBy.="'".$school[0]."'";
			}
			$whereBy.=")";
		}
		if($custType[0] != '*') {
			if(strcmp( $whereBy," WHERE ") == 0) {
				$whereBy.=" Type IN (";
			} else {
				$whereBy.=" AND Type IN (";
			}
			if(count($custType)>1) {
				for($i=0;$i<count($custType)-1;$i++) {
					$whereBy.="'".$custType[$i]."',";
				}
				$whereBy.="'".$custType[count($custType)-1]."'";
			} else {
				$whereBy.="'".$custType[0]."'";
			}
			$whereBy.=")";
		}
		if(strcmp( $whereBy," WHERE ") == 0) {
			$whereBy="";
		}
		
		$this->getList($pageSize, $orderby, $order, $whereBy, $pagenum);
	}
	
}
?>