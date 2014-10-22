<?php

include('../constants.php');
include (DOCUMENT_ROOT.'DAO/recordDAO.php'); 
include (DOCUMENT_ROOT.'DAO/instrumentDAO.php'); 

	if(isset($_POST['actionType'])){
		$actionType = $_POST['actionType'];
		
		switch($actionType){
			case ACTION_TYPE_RETRIEVE_UNIT_PRICE:
				
				$customerName = $_POST['customerName'];
				$instrumentName = $_POST['instrumentName'];
				$type = $_POST['type'];
				$woperator = $_POST['woperator'];
				$date = $_POST['date'];
				
				#echo $customerName.'|'.$instrumentName.'|'.$type.'|'.$woperator.'|'.$date;
				if(!empty($customerName) && !empty($instrumentName) && !empty($type) && !empty($date)){
					retrieveUnitPrice($customerName, $instrumentName, $type, $woperator);
				}
				else
					return "empty";
				break;
			
			
			default:
				break;
	
		}
	}
	
	
	
	function retrieveUnitPrice($customerName, $instrumentName, $type, $woperator){
		$fulldate = split('[/]',$_POST['date']);
		$month = $fulldate[0];
		$date = $fulldate[1];
		$year = $fulldate[2];
		
		$fromDate = "$year-$month-01";
		$toDate = "$year-$month-$date";
		
		$instrumentDao = new InstrumentDAO();
		$unit = $instrumentDao->getRates($instrumentName, $type, $woperator);
		$discountFlag = 0;
		
		$recordDao = new RecordDAO();
		$recordList = $recordDao->findRecordsBetweenDates($customerName, $fromDate, $toDate);
		
		$currQty = 0;
		//echo "Total records = ".count($recordList);

		foreach($recordList as $record){
		
			#if(!in_array($record->Machine, FILMS_LIST) && $record->WithOperator == 0){
			if($record->WithOperator == 0){
				$currQty += $record->Qty;	
			}
	
		}
		
		#if($currQty >= 10 && $type == 'On-Campus' && $woperator == 0 && !in_array($instrumentName, FILMS_LIST)){
		if($currQty >= 10 && $type == 'On-Campus' && $woperator == 0){
			$discountFlag = 1;		
		}
		echo $unit."^|^".$discountFlag;
		#echo "100^|^100";
	}


?>