<?php

include_once(DOCUMENT_ROOT."includes/database.php");
require_once(DOCUMENT_ROOT."includes/tableHandler.class.php");

class EnrolledPaymentsDAO extends TableHandler{

	function EnrolledPaymentsDAO(){
			
			$this->table = "Enrolled_Payment_Types";
			$this->id = "Enrolled_Payment_ID";
			$this->fields = array
			(
				'Customer_ID',
				'Payment_Type_ID',
				'Last_Mod_Date'
			);
			
	}
	
	function retrieveByCustomerID($customerID){
	   
  	   $query = "SELECT * from ".$this->table." where Customer_ID=".$customerID;
	  	  
	   $this->result = mysql_query($query);
	   $objectCollection = NULL;
	   
	   while ($row = mysql_fetch_object($this->result)) {
				$objectCollection[] = $row;
       }
	   
	   return $objectCollection;
	}
	
}