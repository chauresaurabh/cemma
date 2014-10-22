<?php

include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/database.php");
include_once(DOCUMENT_ROOT."DAO/customerDAO.php");
include_once(DOCUMENT_ROOT."DAO/paymentTypesDAO.php");
include_once(DOCUMENT_ROOT."DAO/enrolledPaymentsDAO.php");

class Customer{

	function getCellValue($row, $column_Id, $is_Link,  $dateTimePattern, $rowNumber){
		switch($column_Id){
		
			case 1: // Name
			
				return $row->Name;
				
			case 2: // Username
			
				return $row->Uname;
				
			case 3: //Email 
			
				return $row->EmailId;
				
			case 4: //Activated
			
				return $row->Activated ? "Yes" : "No";
				
			case 5: //Edit 
			
				$returnString = '<a href="editCustomer.php?id='.$row->Customer_ID.'"><img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0" class="tableimg" /></a>';
				
				return $returnString;
			
			default: 
				return "Error";
		

		
		}
		
	}
	
	function getEnrolledPayments($id){
	
		$paymentTypesDao = new PaymentTypesDAO();
		$enrolledPaymentsDao = new EnrolledPaymentsDAO();
		$paymentDescriptionList = $paymentTypesDao->retrieveAll();
		$enrolledPaymentList = NULL;
		if($id != NULL){
			$enrolledPaymentList = $enrolledPaymentsDao->retrieveByCustomerID($id);
		}
		
		$returnString = "<span id = \"paymentTypesSpan\">";
		
		foreach($paymentDescriptionList as $paymentDescription){
		
			$checked = FALSE;
			if($enrolledPaymentList != NULL){
				foreach($enrolledPaymentList as $enrolledPayment){
					if($enrolledPayment->Customer_ID == $id && $enrolledPayment->Payment_Type_ID == $paymentDescription->Payment_Type_ID){
						$checked = TRUE;
					}
				}
			}
			
			if($checked){	 
				$returnString .= '<input type = "checkbox" class = "checkBoxType" id = "paymentType'.$paymentDescription->Payment_Type_ID
								 .'" value = "'.$paymentDescription->Payment_Type_ID .'" checked = "checked">';
			}
			else{
				$returnString .= '<input type = "checkbox" class = "checkBoxType" id = "paymentType'.$paymentDescription->Payment_Type_ID
								.'"	value = "'.$paymentDescription->Payment_Type_ID.'">';
			}
			
			$returnString .= $paymentDescription->Description.'<br/>';
				
		}
		
		$returnString .= "</span>";
		
		return $returnString; 
	}
	
}
?>