<?php

//include_once(DOCUMENT_ROOT."includes/database.php");
require_once(DOCUMENT_ROOT."includes/tableHandler.class.php");
include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
class userDAO extends TableHandler{

	function userDAO(){
			
			$this->table = "user";
			$this->id = "UserName";
			$this->fields = array
			(
				'UserName',
				'Class',
				'Email',
				'Name', 
				'FirstName', 
				'LastName',
				'Telephone', 
				'Dept',
				'Advisor',
				'Position',
				'GradYear',
				'GradTerm',
				'MailingListOpt',
				'ActiveUser',
				'FieldofInterest',
				'LastStatusUpdate',
				'ResponseEmail',
				'Comments',
				'MemberSince',
				'LastEmailSentOn'
			
			);
			
	}

	function getRoleID($username){

		$roleID = 0;
		$sql = "select UserName from user where UserName = '$username'";
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
		$sql = "select Name from user where Role_ID = 1 and Manager_ID = ".$managerId." and UName= '".$loginName."'";
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
			return "Dept";
			break;
			
			case 3: 
			return "Advisor";
			break;
			
			case 4:
			return "Position";
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
	
	function searchUsers($pagenum, $pageSize = 20, $orderby = '',$order = '', $dept='*', $advisor='*', $position='*', $approvedIns){
		$whereBy = " WHERE ";
		if($dept[0] != '*') {
			$whereBy.="Dept IN (";
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
		if($advisor[0] != '*') {
			$whereBy.="Advisor IN (";
			if(count($advisor)>1) {
				for($i=0;$i<count($advisor)-1;$i++) {
					$whereBy.="'".$advisor[$i]."',";
				}
				$whereBy.="'".$advisor[count($advisor)-1]."'";
			} else {
				$whereBy.="'".$advisor[0]."'";
			}
			$whereBy.=")";
		}
		if($position[0] != '*') {
			$whereBy.="Position IN (";
			if(count($position)>1) {
				for($i=0;$i<count($position)-1;$i++) {
					$whereBy.="'".$position[$i]."',";
				}
				$whereBy.="'".$position[count($position)-1]."'";
			} else {
				$whereBy.="'".$position[0]."'";
			}
			$whereBy.=")";
		}
		if(strcmp( $whereBy," WHERE ") == 0) {
			$whereBy.=" user.Email ";
		} else {
			$whereBy.=" AND user.Email ";
		}
		$whereBy.="IN (SELECT instr_group.Email FROM instr_group WHERE user.Email = instr_group.Email";
			if($approvedIns!='*') {
				$whereBy.=" AND InstrNo = '$approvedIns'";
			}
		$whereBy.=")";	
			/*if(count($approvedIns)>1) {
				for($i=0;$i<count($approvedIns)-1;$i++) {
					$whereBy.=$approvedIns[$i].",";
				}
				$whereBy.=$approvedIns[count($approvedIns)-1].")";
			} else {
				$whereBy.=$approvedIns[0].")";
			}*/
		$this->getList($pageSize, $orderby, $order, $whereBy, $pagenum);
	}
}
?>