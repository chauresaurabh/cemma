<?php

include_once(DOCUMENT_ROOT."includes/database.php");
require_once(DOCUMENT_ROOT."includes/tableHandler.class.php");

class PaymentTypesDAO extends TableHandler{

	function PaymentTypesDAO(){
			
			$this->table = "Payment_Types";
			$this->id = "Payment_Type_ID";
			$this->fields = array
			(
				'Description',
				'Last_Mod_Date'
			);
			
	}
	
}