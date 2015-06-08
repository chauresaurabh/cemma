
<?php 

require_once('../constants.php');
require_once(DOCUMENT_ROOT."includes/viewComponent.php");
require_once(DOCUMENT_ROOT."DAO/viewComponentDAO.php");
require_once(DOCUMENT_ROOT."DAO/viewDefinitionHeaderDAO.php");
require_once(DOCUMENT_ROOT."DAO/customerDAO.php");
require_once(DOCUMENT_ROOT."Objects/customer.php");
require_once(DOCUMENT_ROOT."includes/buildViewComponent.class.php");


	foreach ($_POST as $field=>$value) {
	$$field = $value;
	//echo $field."=>".$value;
	
	}
	
	if(isset($removeRecord) && $removeRecord == 1){
		$rm = new $daoClassName();
		$rm->remove($recordId);
		echo "Customer has been removed successfully";
			
	}
	
	else if(!isset($maxResults) || !isset($sortColumn) || !isset($sortOrder)){
		echo "Error occurred";
	}
	
	else{
	
		if($searchFlag){
		
		$searchFieldsArr = explode('<@>', $searchFields);
		$searchFieldsArray = array(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		foreach($searchFieldsArr as $searchField){
			list($key,$value) = explode('==', $searchField);
			//print_r($keyValuePair);
			$searchFieldsArray[$key] = $value;
		}
		
		
		$buildViewComponent = new BuildViewComponent($viewComponentId, $sortOrder, $sortColumn, $maxResults, NULL, $firstResult, NULL, $daoClassName, $searchFieldsArray);
		}
		else{
		$buildViewComponent = new BuildViewComponent($viewComponentId, $sortOrder, $sortColumn, $maxResults, NULL, $firstResult, NULL, $daoClassName, NULL);
		}
		
		$buildViewComponent->writeDataCells();
		echo $buildViewComponent->output;
	
	
	
		/*$rs = new $daoClassName();
		$pageNum = (($firstResult - 1)/$maxResults) + 1;
		$totalRecords = $rs->getTotalRecords();
		$lastResult = $firstResult + $maxResults - 1;
		$rs->getList($maxResults,$sortColumn,$sortOrder,'',$pageNum);
		while ($row = $rs->fetchObject()) {
			$objectCollection[] = $row;
		}
		
		$totalRecords = $rs->getTotalRecords();
		
		$token = "<@>";
		$viewComponentDao = new ViewComponentDAO();
		$viewComponentDao->getSingleRecord($this->viewComponentId);
		$viewComponent = $viewComponentDao->fetchSingleObject();
		
		$viewComponent->objectCollection = $objectCollection;
		
		$viewDefinitionHeaderDAO = new ViewDefinitionHeaderDAO();
		$headers = $viewDefinitionHeaderDAO->getHeadersforComponent($viewComponentId);
		$actionName = $viewComponent->ActionName;
		
		$nav = '';
		$showPrev = FALSE;
		$showNext = FALSE;
		$actionName = $viewComponent->actionName;
		
		//$actionName = 'customer';
		
		echo "First Result is $this->firstResult";
				
		if ($firstResult > 1){
			$showPrev = TRUE;
		}
		
		$last = sizeof($viewComponent->objectCollection) + $firstResult;
		if($last < $totalRecords){
			$showNext = TRUE;
		}
		
		// Start building pager
		
		$nav.='<div class="pagerArea">';
		$nav .= '<span id = "pagerCounterShowing">Showing ';
		$nav .= '<span id = "pagerCounterFirst">'.firstResult.'-';
		$nav .= '<span id = "pagerCounterLast">'.$lastResult;
		$nav .= '<span id = "pagerCounterTotal"> of '.$this->totalRecords. '&nbsp;&nbsp;&nbsp;';
		
		if($showPrev == TRUE){
			 $nav .= '<span id = "pagerFirst"><a href = \'javascript:vc_first("'.$actionName.'", '.$viewComponent->ViewComponentId.')\'>First</a> | </span>';
			 $nav .= '<span id = "pagerPrev"><a href = \'javascript:vc_prev("'.$actionName.'", '.$viewComponent->ViewComponentId.')\'>Prev</a> | </span>';  
		}
		
		else{
			 $nav .= '<span id = "pagerFirst">First | </span>';  
			 $nav .= '<span id = "pagerPrev">Prev | </span>';      
		}
		
		if ($showNext == TRUE){      
		
			$nav .= '<span id = "pagerNext"><a href = \'javascript:vc_next("'.$actionName.'", '.$viewComponent->ViewComponentId.')\'>Next</a> | </span>';
			$nav .= '<span id = "pagerLast"><a href = \'javascript:vc_last("'.$actionName.'", '.$viewComponent->ViewComponentId.')\'>Last</a> | </span>';  
		}

		else{

			$nav .= 'Next | ';
			$nav .= 'Last | ';   

		}
			
	   	$nav .= '<a href = "javascript:vc_Search("'.$actionName.'", '.$viewComponent->ViewComponentId.') onclick = "document.getElementById(\'searchRow\').style.display = \'\'")>Search</a>';  
		$nav.= '</div>';
		
		$rowCount = sizeof($objectCollection);
		$noResultsFound = "No Results Found";
		
		// Start building the string to return
		
		$vcString = sizeof($headers);
		$vcString .= $token.$rowCount;
		$vcString .= $token.$maxResults;
		$vcString .= $token.$firstResult;
		
		if(sizeof($objectCollection) > 0){
			$vcString .= $token.$last;
			$vcString .= $token.$totalRecords;
			$vcString .= $token.$nav;
		
		}
		else{
			$vcString .= $noResultsFound;
		}
		
		$vcString .= $token.$totalRecords;
		$vcString .= $token.$actionName;
		
		$vcString .= $token.'0'; // cell Total
				
		// Data Cells
		
		$rowNumber = 0;
		$columnNumber = 0;
		$useAltRowStyle = true;
		$rowStyle = $viewComponent->Row_Style;
		$p_Key = $viewComponent->P_Key;
		
		foreach($objectCollection as $rowObject){
		
			foreach($headers as $header){
				$dataCellID = 'dataCell_ID'.$viewComponent->viewComponentId.'_R'.$rowNumber.'_C'.$columnNumber;
				$cellValue = BuildViewComponent::getCellValue($viewComponentId, $rowObject, $header->Column_Id, $header->Is_Link, $header->Date_Pattern + $header->Time_Pattern, $rowNumber);
				$vcString.=$token;
				$vcString.='<td id="'.$dataCellID.'" name = "'.$dataCellID.'" style = "'.$cellStyle.'" align = "center">';
				$vcString.=$cellValue;
				$vcString.='</td>';
				$columnNumber++;
			}
			
			if($viewComponent->Display_Remove){
				$vcString.='<td id = "removeColumn_ID'.$viewComponent->viewComponentId.'_R'.$rowNumber.'" align = "center" width = "'.$this->REMOVE_COL_WIDTH.'px">';
				$vcString.='<a href="javascript:doAction(3,'.$rowObject->$p_Key.')">';
				$vcString.='<img src="images/trash_icon.gif" alt="Remove" width="10" border="0" />';
				$vcString.='</a></td>';
			}		

			$vcString.='</tr>';
							
			$rowNumber++;
			$columnNumber = 0;
			
			if($useAltRowStyle){
				$rowStyle = $viewComponent->Alt_Row_Style;
				$useAltRowStyle = false;
			}
			else{
				$rowStyle = $viewComponent->Row_Style;
				$useAltRowStyle = true;
			}
			
		}*/
			
	}
	
	echo $vcString;
	
	/*foreach($objectCollection as $rowObject){
		//echo $rowObject->Name;
	}*/

?>