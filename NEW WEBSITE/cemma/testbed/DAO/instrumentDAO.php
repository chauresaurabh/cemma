<?php

include_once(DOCUMENT_ROOT."includes/database.php");
require_once(DOCUMENT_ROOT."includes/tableHandler.class.php");

class InstrumentDAO extends TableHandler{

	function InstrumentDAO(){
			
			$this->table = "instrument";
			$this->id = "InstrumentNo";
			$this->fields = array
			(
				'InstrumentName',
				'Comment',
				'Availablity',
				'Type'
			);
			
	}

	function getRoleID($instrumentname){

		$roleID = 0;
		$sql = "select InstrumentNo from instrument where InstrumentName = '$username'";
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
	
	/* Shift the method to ratesDAO as soon as possible */
	
	function getRates($instrumentName, $type, $woperator){
	
		if($woperator == 1) $woperator = "With_Operator";
		else $woperator = "Without_Operator";
		
		$sql = "select * from rates where machine_name = '$instrumentName'";
		
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$unit = $row[$type."_".$woperator];
		}
		
		return $unit;
		
	
	}
	
	
	
	function getOrderBy($id){
	 
		switch($id){
	
			case 1:
			return "InstrumentName";
			break;
		
			case 2:
			return "Comment";
			break;
			
			case 3: 
			return "Availablity";
			break;
					
			default:
			return "InstrumentName";
			break;
			
	
		}
	}
}
?>