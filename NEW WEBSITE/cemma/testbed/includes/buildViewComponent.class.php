<?php 
include_once(DOCUMENT_ROOT."includes/viewComponent.php");
include_once(DOCUMENT_ROOT."DAO/viewComponentDAO.php");
include_once(DOCUMENT_ROOT."DAO/viewDefinitionHeaderDAO.php");
include_once(DOCUMENT_ROOT."Objects/customer.php");
require_once(DOCUMENT_ROOT."DAO/customerDAO.php");
//include_once("database.php");
//include_once(DOCUMENT_ROOT."Objects/userobject.php");
//require_once(DOCUMENT_ROOT."DAO/UserDAO.php");

$instcount='';
$instr_groupcount='';

class BuildViewComponent{

	var $viewComponentId;
	var $sortOrder;
	var $sortColumn;
	var $maxResults;
	var $firstResult;
	var $totalRecords;
	var $actionName;
	var $REMOVE_COL_WIDTH = 55;
	var $ROW_NUM_WIDTH = 30;
	var $output = '';
	var $headerWidths;
	var $viewComponent;
	var $headers;
	var $colspan;
	var $searchFieldsArray;
	
	function BuildViewComponent($viewComponentId, $sortOrder, $sortColumn, $maxResults, $objectCollection, $firstRecord, $totalRecords, $daoClassName = '', $searchFieldsArray){
	
	$this->viewComponentId = $viewComponentId;
	$this->sortOrder = $sortOrder;
	$this->sortColumn = $sortColumn;
	$this->maxResults = $maxResults;
	$this->firstResult = $firstRecord;
	if($this->firstResult == NULL || $this->firstResult == '')	$this->firstResult = 1;
	$this->totalRecords = $totalRecords;
	$this->searchFieldsArray = $searchFieldsArray;
	
	
	
	if($objectCollection == NULL){
	
		$rs = new $daoClassName();
	//	$rs = new CustomerDAO();
		$pageNum = (($this->firstResult - 1)/$this->maxResults) + 1;
		if($pageNum < 1) $pageNum = 1;
		if($searchFieldsArray != NULL){
			$where = $rs->getSearchCriteria($searchFieldsArray);
			$rs->getList($maxResults,$sortColumn,$sortOrder,$where,$pageNum);
		}
		else{
			$rs->getList($maxResults,$sortColumn,$sortOrder,'',$pageNum);
		}
		$this->totalRecords = $rs->getTotalRecords();
		$lastResult = $this->firstResult + $this->maxResults - 1;
		while ($row = $rs->fetchObject()) {
			$objectCollection[] = $row;
		}
		
		$this->output.= $this->totalRecords.'^|^';

	}
	
	$viewComponentDao = new ViewComponentDAO();
	$viewComponentDao->getSingleRecord($this->viewComponentId);
	$viewComponent = $viewComponentDao->fetchSingleObject();
	
	if($viewComponent == NULL){
		echo ("Error occured while building the Component");
		exit();
	}
	
	$viewComponent->objectCollection = $objectCollection;
	
	$this->viewComponent = $viewComponent;
	//echo "check#3<br>";
	$viewDefinitionHeaderDAO = new ViewDefinitionHeaderDAO();
	#echo "check#4<br>";	
	$this->headers = $viewDefinitionHeaderDAO->getHeadersforComponent($viewComponent->ViewComponentId);
	#echo "check#5<br>";	
	$this->colspan = sizeof($this->headers) + 1;
	$this->actionName = $viewComponent->ActionName;
		
	if($viewComponent->Display_Remove) $this->colspan++;
		
	if($viewComponent->Display_Num_Rows) $this->colspan++;
	
	$headerWidthTotal = $viewComponent->Table_Width;
		
	if($viewComponent->Display_Remove) $headerWidthTotal -= $REMOVE_COL_WIDTH;
	
	if($viewComponent->Display_Num_Rows) $headerWidthTotal -= $ROW_NUM_WIDTH;
	
	$cellWidth = 0;
	$headerWidthsItr = 0;
	$cellCounter = 0;
	
	$cellWidthMultiple = 0.0;
	$headerCount = sizeof($this->headers);
	$headerIndex = 0;
	
	foreach ($this->headers as $header){
		
	$cellWidthMultiple = $header->Width / 100.0;
	$cellWidth = (int) ($headerWidthTotal* $cellWidthMultiple);
	
	$this->headerWidths[$headerWidthsItr++] = $cellWidth;
	
	}
		
	
	//$this->displayComponent($viewComponent);
			
	}
	
	function displayComponent($viewComponent){

		$colspan = $this->colspan;
		$headers = $this->headers;	
		
		//$this->writeTableTag($viewComponent);
		
		//Write Table Tag
		$EmailAlllistSelected=1;
		$this->output.='<table width='.$viewComponent->Table_Width.' border='.$viewComponent->Border.' cellpadding='.$viewComponent->Cellpadding; 
		$this->output.=' cellspacing='.$viewComponent->Cellspacing.'>';
		
		//Write Title
		
		$this->output.= '<tr><td class="'.$viewComponent->TitleStyle.'">';
		$this->output.= '<div class="title">'.$viewComponent->TitleText.'</div>';
		$this->output.= '<div class="details">'.$this->writeRecordsBar().'</div> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';


		// try 
		
		include_once("database.php");
		$sql23 = "SELECT EmailId FROM Customer";
		$values1=mysql_query($sql23) or die("An error has ocured in query14: " .mysql_error (). ":" .mysql_errno ()); 
		//$row33 = mysql_fetch_array($values1); 
		$totalemailcountcustomer=0;

	
		while($row23 = mysql_fetch_array($values1))
		{
			if ($row23['EmailId']!=NULL)
			{
				$emaillist1[$totalemailcountcustomer]=$row23['EmailId'];
				$totalemailcountcustomer++; 
			}	
		}

		$dbhost="db948.perfora.net";
		$dbname="db210021972";
		$dbusername="dbo210021972";
		$dbpass="XhYpxT5v";

		$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
		$SelectedDB = mysql_select_db($dbname) or die ("Error in DBbb");

		//retrieve instrument name, number list
		
		$sql13 = "SELECT InstrumentName, InstrumentNo FROM instrument";
		$values=mysql_query($sql13) or die("An error has ocured in query11: " .mysql_error (). ":" .mysql_errno ()); 
		//$row33 = mysql_fetch_array($values); 
		$instcount=0;


		while($row33 = mysql_fetch_array($values))
		{
		
			$instlist[$instcount]=$row33['InstrumentName'];
			$instnolist[$instcount]=$row33['InstrumentNo'];

			$instcount++;
		
		}

		//retrieve instrument number, emailid list from instr_group


		$sql13 = "SELECT Email, InstrNo FROM instr_group";
		$values=mysql_query($sql13) or die("An error has ocured in query11: " .mysql_error (). ":" .mysql_errno ()); 
		//$row33 = mysql_fetch_array($values); 
		


		while($row33 = mysql_fetch_array($values))
		{
		
			$instr_groupNolist[$instr_groupcount]=$row33['InstrNo'];
			$instr_groupEmaillist[$instr_groupcount]=$row33['Email'];


		//echo $instr_groupNolist[$instr_groupcount].", ";
		//echo $instr_groupEmaillist[$instr_groupcount]." | ";
	//	echo "\n";
			$instr_groupcount++;
		
		}

// retrieve email id's
//$name1='Ameya';
	$sql13 = "SELECT Email FROM user";
	$values=mysql_query($sql13) or die("An error has ocured in query12: " .mysql_error (). ":" .mysql_errno ()); 
	//$row33 = mysql_fetch_array($values); 
	$totalemailcountuser=0;


	while($row33 = mysql_fetch_array($values))
	{
	if ($row33['Email']!=NULL && strstr($row33['Email'], '@'))
		{
		$emaillist2[$totalemailcountuser]=$row33['Email'];
	//echo "$i ".$emailid;
//	echo "\n";
		$totalemailcountuser++;
		}
	}
	$jj=0;
	
	
	/* 9/3
	$this->output.= "<a href='mailto:";
		while($jj<=$totalemailcountcustomer) //$totalemailcount
	{
	if ($jj==$totalemailcountcustomer)
		{

	$this->output.= $emaillist1[$jj].", ";
		}
	else
		{
	$this->output.= $emaillist1[$jj].", ";
		}
//	echo "\n";
	$jj++;
	}
	$jj=0;
	while($jj<=$totalemailcountuser) //$totalemailcount
	{
	if ($jj==$totalemailcountuser)
		{

	$this->output.= $emaillist2[$jj];
		}
	else
		{
	$this->output.= $emaillist2[$jj].", ";
		}
//	echo "\n";
	$jj++;
	}


$this->output.= "?cc=athompso@usc.edu,curulli@usc.edu'>Email All &nbsp;</a>";
*/

//echo "j".$jj;
  //  mysql_close($connection);
// try end


$this->output.= "<a href='javascript: EmailAll()'>Email All &nbsp;</a>";
$this->output.= "<a href='javascript: inst()'>Email Instrument List &nbsp;</a>";
$this->output.= "<select id='instlist' class='hide'>";
$jj=0;
while($jj<=$instcount)
		{
$this->output.= "<option>";
$this->output.= $instlist[$jj];
$this->output.= "</option>";
$jj++;
		}
		$this->output.= "</select> ";


			
		
		$this->output.= '</td></tr>';

		
		//mysql_close($connection);
		// Write Headers
		
		$this->output.= '<tr><td class="t-mid">';
		$this->output.='<table border="'.$viewComponent->Border.'" cellpadding="'.$viewComponent->Cellpadding; 
		$this->output.='" cellspacing="'.$viewComponent->Cellspacing.'" class = "Tcontent">';	
		$this->output.='<tr bgcolor="'.$viewComponent->HeaderBGColor.'" class="'.$viewComponent->Header_Row_Class.'">';
		
		
		
		if($viewComponent->Display_Num_Rows){
			$this->output.='<td id = "numColumn" name = "numColumn" align = "center" width='.$this->ROW_NUM_WIDTH.'px>No</td>';
		}
		
		$headerWidthsItr = 0;
		
		foreach ($headers as $header){
		
			$cellWidth = $this->headerWidths[$headerWidthsItr++];
			
			// Add javscript for sorting 
			
			$sortJavaScript = 'javascript:vc_sort("'.$header->Sort_Column_Name.'", "'.$viewComponent->ActionName.'", "'.$this->viewComponentId.'", "'.$header->Ignore_Case_For_Sort.'")';
			
			if($viewComponent->Column_Sort && $header->Is_Sortable){
				$sortTag = '<a href = \''. $sortJavaScript. '\' class = "'.$viewComponent->Header_Link_Class.'">';
			}
			else{
				$sortTag = '';
			}
			
			$this->output.= '<td name = "'.$header->Sort_Column_Name.'" id = "'.$header->Sort_Column_Name.'" width = "'.$cellWidth.'px" "';
			$this->output.= 'align = "'.$header->Align.'" "';
			if($header->Header_Class != NULL || $header->Header_Class != ''){
				$this->output.='class = "'.$header->Header_Class.'" "';
			}
			$this->output .= '>';
			$this->output .= $sortTag;
			
			$this->output.=$header->Header_Text;
			$this->output .= '</a>';
			
			if($header->Is_Sortable && $this->sortColumn == $header->Sort_Column_Name){
				if($this->sortOrder != NULL || $this->sortOrder == 'desc'){
					$this->output.= '<span id = "SortOrderDesc_'.$header->Sort_Column_Name.'" style = "visibility:hidden;display:none">';
					$this->output.='<img src = "images/downArrow.gif" /></span>';
					$this->output.= '<span id = "SortOrderAsc_'.$header->Sort_Column_Name.'">';
					$this->output.='<img src = "images/upArrow.gif" /></span>';
				}
				else{
					$this->output.= '<span id = "SortOrderAsc_'.$header->Sort_Column_Name.'" style = "visibility:hidden;display:none">';
					$this->output.='<img src = "images/upArrow.gif" /></span>';
					$this->output.= '<span id = "SortOrderDesc_'.$header->Sort_Column_Name.'">';
					$this->output.='<img src = "images/downArrow.gif" /></span>';
				}
		
			}
			else if($header->Is_Sortable){
					$this->output.= '<span id = "SortOrderDesc_'.$header->Sort_Column_Name.'" style = "visibility:hidden;display:none">';
					$this->output.='<img src = "images/downArrow.gif" /></span>';
					$this->output.= '<span id = "SortOrderAsc_'.$header->Sort_Column_Name.'" style = "visibility:hidden;display:none">';
					$this->output.='<img src = "images/upArrow.gif" /></span>';
			
			}
			
			$this->output.='</td>';
			
			$cellCounter++;
			$headerIndex++;
			
			
		}
		
		if($viewComponent->Display_Remove){
			$this->output.='<td id = "removeColumn" name = "removeColumn" align = "center" width = "'.$this->REMOVE_COL_WIDTH.'px">Remove</td>';
		}		
		
		$this->output.='</tr>';
		$this->output.= '<tr>';
		$this->output.='<td id = "objectListTable" name = "objectListTable" colspan = "'.$colspan.'">';
		
		
		$this->writeDataCells();
		
		$this->output.='</td></tr>';

		$this->output.= '</table></td></tr>';
		$this->output.= '<tr><td class="t-bot2"><a href="editCustomer.php?id=&submit_mode=add">New Customer</a>&nbsp;&nbsp;</td>';
        $this->output.='</tr></table>';


		
	}
	
	function writeDataCells(){
		
		/* Write Data Cells */
		
		$colspan = $this->colspan;
		
		$viewComponent = $this->viewComponent;
		$headers = $this->headers;
		$this->output .= '<table width = "100%" cellpadding='.$viewComponent->Cellpadding.' cellspacing='.$viewComponent->Cellspacing.'>';
		
		if($viewComponent->objectCollection == NULL){
			$this->output.='<tr align="center"><td colspan = "'.$colspan.'">No Records Found</td></tr>';
		}
		
		else{
		
			$rowNumber = 0;
			$columnNumber = 0;
			$useAltRowStyle = true;
		    $rowStyle = $viewComponent->Row_Style;
			$p_Key = $viewComponent->P_Key;
			
			foreach($viewComponent->objectCollection as $rowObject){
			
				$this->output.='<tr align="center" class = "'.$rowStyle.'" id = "dataRow_ID'.$viewComponent->viewComponentId.'_R'.$rowNumber.'">';
			
				
				if($viewComponent->Display_Num_Rows){
					

					$firstNumber = ($rowNumber + $this->firstResult);
					$this->output.='<td id = "numColumn_ID_R'.$rowNumber.'" width = "'.$this->ROW_NUM_WIDTH.'px">'.$firstNumber.'</td>';
				}
				
				foreach($headers as $header){
					$dataCellID = 'dataCell_ID'.$viewComponent->viewComponentId.'_R'.$rowNumber.'_C'.$columnNumber;
					$cellValue = $this->getCellValue($viewComponentId, $rowObject, $header->Column_Id, $header->Is_Link, $header->Date_Pattern + $header->Time_Pattern, $rowNumber);
					$this->output.='<td id="'.$dataCellID.'" name = "'.$dataCellID.'" style = "'.$cellStyle.'" align = "center" width = "'.$this->headerWidths[$columnNumber].'px">';
					$this->output.=$cellValue;
					$this->output.='</td>';
					$columnNumber++;
				}
				
				if($viewComponent->Display_Remove){
					$this->output.='<td id = "removeColumn_ID'.$viewComponent->viewComponentId.'_R'.$rowNumber.'" align = "center" width = "'.$this->REMOVE_COL_WIDTH.'px">';
					$this->output.='<a href=\'javascript:vc_removeRecord('.$rowObject->$p_Key.', "'.$this->actionName.'", '.$this->viewComponentId.')\'>';
					$this->output.='<img src="images/trash_icon.gif" alt="Remove" width="10" border="0" />';
					$this->output.='</a></td>';
				}		

				$this->output.='</tr>';
								
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
				
			}
		
		}
		
		// Write Search Row
		$this->output.='<tr id = "searchRow" name = "searchRow" class = "searchRowClass" style = "display:none">';
		if($viewComponent->Display_Num_Rows){
			$this->output.='<td id = "numColumn_ID'.$viewComponent->viewComponentId.'_R"></td>';
		}
		
		$headerWidthsItr = 0;
		$searchFieldNumber = 0;
		
		foreach($headers as $header){
		
		$searchCellWidth = $this->headerWidths[$headerWidthsItr++] - 40;
			
			if($header->Is_Searchable){
			
				$dataCellID = 'searchCell_ID'.$viewComponent->viewComponentId.'_C'.$columnNumber;
				$searchCellValue = $this->getSearchCellValue($this->searchFieldsArray, $header->Column_Id);
				$this->output.='<td id="'.$dataCellID.'" name = "'.$dataCellID.'" style = "'.$cellStyle.'" align = "center" width = "'.$searchCellWidth.'px">';
				$this->output.='<input type = "text" id = "searchFieldId'.$header->Column_Id.'" class = "inputTextField" style = "width:'.$searchCellWidth.'px; border:1px dashed gray; text-align:center" value = "'.$searchCellValue.'" onkeypress="return performSearch(event, \''.$this->actionName.'\', '.$this->viewComponentId.')"><div>';
				$this->output.='</td>';
				$columnNumber++;
			}
			
			else{
			
					$dataCellID = 'searchCell_ID'.$viewComponent->viewComponentId.'_C'.$columnNumber;
					$this->output.='<td id="'.$dataCellID.'" name = "'.$dataCellID.'" style = "'.$cellStyle.'" align = "center">';
					$this->output.='</td>';
					$columnNumber++;
			
			}
			

			$searchFieldNumber++;
		}
		
		if($viewComponent->Display_Remove){
			$this->output.='<td id = "removeColumn_ID'.$viewComponent->viewComponentId.'_R align = "center" width = "'.$this->REMOVE_COL_WIDTH.'">';
			$this->output.='</td>';
		}		
	
		$this->output.='</tr>';

		/// Page Navigation
		
		
		$this->output.='<tr id = "pageNavRow_ID'.$viewComponent->viewComponentId.'" name = "pageNavRow_ID'.$viewComponent->viewComponentId.'" class = "paginationRow">';
		$this->output.='<td colspan = "'.$colspan.'">';
		//$this->output.= $this->writePageNav($viewComponent);
		$this->output.='</td></tr></table>';
				
		//$this->writeTitle($viewComponent, $colspan, $removeColumn);
	
	}
	
	
	function writeTableTag($viewComponent){
	
		
		//echo $this->output;
	
	}
	
	function writeTitle($viewComponent, $colspan, $removeColumn){
	
//	        <tr><td class="t-mid">
	
	}
	
	function getCellValue($viewComponentId, $rowObject, $Column_Id, $Is_Link, $DateTimePattern, $rowNumber){
		#echo $viewComponentId." / ".$rowObject." / ".$Column_Id." / ".$Is_Link." / ".$DateTimePattern." / ".$rowNumber."<BR>";
		
		switch($viewComponentId){
		
			default:
				$returnString = Customer::getCellValue($rowObject, $Column_Id, $Is_Link,  $DateTimePattern, $rowNumber);
				return $returnString;
				
		}
		
	}
	
	function dropDownMenu(){
	
		$nav = "";
	 
		$nav.='<td class = "rightAlign" width = "20%">';
		
		$searchFunction = 'vc_maxResults("'.$this->actionName.'", '.$this->viewComponentId.')';
		if($this->viewComponent->Display_Search){
			$searchFunction = 'vc_maxResultsWithSearch("'.$this->actionName.'", '.$this->viewComponentId.')';
		} 
		
		
		$nav.= '<select id = "maxResultsDropDown" name = "maxResultsDropDown" class = "dropDownSelect" onchange = \''.$searchFunction.'\'>';
		$nav.='<option value = "-1">Select...</option>';
		if($this->maxResults == 10){
			$nav.= '<option value = "10" selected = "selected">10 Results</option>';
			$nav.= '<option value = "20">20 Results</option>';
			$nav.= '<option value = "30">30 Results</option>';
			$nav.= '<option value = "50">50 Results</option>';
			$nav.= '<option value = "100">100 Results</option>';
			$nav.= '<option value = "200">200 Results</option>';
		}
		else if($this->maxResults == 20){
		
			$nav.= '<option value = "10">10 Results</option>';
			$nav.= '<option value = "20" selected = "selected">20 Results</option>';
			$nav.= '<option value = "30">30 Results</option>';
			$nav.= '<option value = "50">50 Results</option>';
			$nav.= '<option value = "100">100 Results</option>';
			$nav.= '<option value = "200">200 Results</option>';
		
		}
		else if($this->maxResults == 30){
		
			$nav.= '<option value = "10">10 Results</option>';
			$nav.= '<option value = "20">20 Results</option>';
			$nav.= '<option value = "30" selected = "selected">30 Results</option>';
			$nav.= '<option value = "50">50 Results</option>';
			$nav.= '<option value = "100">100 Results</option>';
			$nav.= '<option value = "200">200 Results</option>';
		
		}
		else if($this->maxResults == 50){
		
			$nav.= '<option value = "10">10 Results</option>';
			$nav.= '<option value = "20">20 Results</option>';
			$nav.= '<option value = "30">30 Results</option>';
			$nav.= '<option value = "50" selected = "selected">50 Results</option>';
			$nav.= '<option value = "100">100 Results</option>';
			$nav.= '<option value = "200">200 Results</option>';
		
		}
		else if($this->maxResults == 100){
		
			$nav.= '<option value = "10">10 Results</option>';
			$nav.= '<option value = "20">20 Results</option>';
			$nav.= '<option value = "30">30 Results</option>';
			$nav.= '<option value = "50">50 Results</option>';
			$nav.= '<option value = "100" selected = "selected">100 Results</option>';
			$nav.= '<option value = "200">200 Results</option>';
		
		}
		else if($this->maxResults == 200){
		
			$nav.= '<option value = "10">10 Results</option>';
			$nav.= '<option value = "20">20 Results</option>';
			$nav.= '<option value = "30">30 Results</option>';
			$nav.= '<option value = "50">50 Results</option>';
			$nav.= '<option value = "100">100 Results</option>';
			$nav.= '<option value = "200" selected = "selected">200 Results</option>';
		
		}
		$nav.= '</select></td>';
		return $nav;

	 
	 }

	
	function writePageNav($viewComponent){
	
		$nav = '';
		$showPrev = FALSE;
		$showNext = FALSE;
		$actionName = $this->actionName;
		
		$actionName = 'customer';
		
		if ($this->firstResult > 1){
			$showPrev = TRUE;
		}
		
		$total = sizeof($viewComponent->objectCollection);
		$lastResult = $this->firstResult + $total - 1;
		if($lastResult < $this->totalRecords){
			$showNext = TRUE;
		}
		
		// Start building pager
		
		$nav.='<table cellspacing = "0" cellpadding = "0" width = "100%" border = "0">';
		$nav.='<tr>';
		
		$nav.='<td class="pagerArea" width = "80%">';
		$nav .= '<span id = "pagerCounterShowing">Showing </span>';
		$nav .= '<span id = "pagerCounterProcessing" style = "display:none;color:red;">Processing... </span>';
		$nav .= '<span id = "pagerCounterFirst">'.$this->firstResult.'-</span>';
		$nav .= '<span id = "pagerCounterLast">'.$lastResult.'</span>';
		$nav .= '<span id = "pagerCounterTotal"> of '.$this->totalRecords. '&nbsp;&nbsp;&nbsp;</span>';
		
		
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
			
	   	$nav .= '<span id = "pagerSearch"><a href = \'javascript:vc_showSearch("'.$actionName.'", '.$viewComponent->ViewComponentId.')\'>Search</a></span>';  
		$nav .= '<span id = "cancelSearch" style = "display:none"><a href = \'javascript:vc_hideSearch("'.$actionName.'", '.$viewComponent->ViewComponentId.')\'>Cancel Search</a></span>';  
		$nav.= $this->dropDownMenu();
		$nav.= '</td>';
		
		$nav.= '</table>';
		      
		
	   return $nav;      
	 }
	 
	 function getSearchCellValue($searchFieldsArray, $column_Id){
	 
		 $searchCellValue = '';
		 if($searchFieldsArray[$column_Id] != NULL){
		 
		 	$searchCellValue =  $searchFieldsArray[$column_Id];
			 
		 }
		 
		 return $searchCellValue;
		 	 
	 }
	 
	 function writeRecordsBar(){
	 
	 	$bar = "Showing Results";
		return $bar;
	 }
	
}
?>

<script type="text/javascript">
var counter=0;
function inst()
{
<? $EmailAlllistSelected=0;?>
counter++; 
document.getElementById("instlist").style.visibility="visible";
if (counter>1)
{
	sel();
}
}

function sel()
{

var no=document.getElementById("instlist");
var InstSelected=no.options[no.selectedIndex].text;
//document.getElementById("EmailAlllistSelected").value="<?=$EmailAlllistSelected=0?>";
//alert ("lo"+InstSelected);


window.open ('Email.php?all=2&inst='+InstSelected, 'newwindow', config='height=400,width=490, scrollbars=1, menubar=no,location=no, directories=no, status=no');
}

function EmailAll()
{
<? $EmailAlllistSelected=1;?>

window.open ('Email.php?all=1', 'newwindow', config='height=400,width=490,toolbar=no, scrollbars=1, menubar=no,location=no, directories=no, status=no');
}
</script>