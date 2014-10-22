// View Component
function createSearchFieldString(){
	
	var maxSearchfields = 9;
	var searchFieldId;
	var searchFields = "";
	
	for (var i=0; i < maxSearchfields; i++){
		searchFieldId = 'searchFieldId' + i;
		
		if (document.getElementById(searchFieldId) && document.getElementById(searchFieldId).value != ''){
			searchFields += i + "==" + document.getElementById(searchFieldId).value + "<@>";
		}
	}
	
	return searchFields;
}

function vc_removeRecord(recordId, formName, viewComponentId){
	
	var confirmBox = confirm("Are you sure you want to continue?");
	if(confirmBox == true){
		
		var id1 = 'firstResult';
		var id2 = 'sortOrder';
		var id3 = 'sortColumn';
		var id4 = 'searchFlag';
		var id5 = 'maxResults';
			
		var maxResults = document.forms[formName].elements[id5].value
			
		maxResults = maxResults == -1 ? 10 : maxResults;
		
		var firstResult =  document.forms[formName].elements[id1].value;
		var sortOrder = document.forms[formName].elements[id2].value;
		var sortColumn = document.forms[formName].elements[id3].value;
		var searchFlag = 0;
		   
		if (document.forms[formName].elements[id4]) {
				   searchFlag = document.forms[formName].elements[id4].value;
		}
		
		removeAndRefreshList(recordId, viewComponentId, maxResults, firstResult, sortOrder, sortColumn, searchFlag);
	
		
	}
		
}


function vc_search(formName, viewComponentId) {

	/*var showingSpan = 'pagerCounterShowing';
	if (document.getElementById(showingSpan))
    	document.getElementById(showingSpan).innerHTML = 'Processing';*/
		
	var searchFields = createSearchFieldString();

	var id1 = 'firstResult';
	var id2 = 'sortOrder';
	var id3 = 'sortColumn';
	var id4 = 'searchFlag';
	var id5 = 'maxResults';
    
 	var maxResults = document.forms[formName].elements[id5].value;

	maxResults = maxResults == -1 ? 10 : maxResults;

    var sortOrder = document.forms[formName].elements[id2].value;
    var sortColumn = document.forms[formName].elements[id3].value;
   /* var userViewId = parseInt(document.forms[formName].elements[id6].value);
    
    if (isNaN(userViewId)) {
    	userViewId = 0;
    }
    */
    var firstResult = 1;
	document.forms[formName].elements[id4].value = firstResult;
	
	
	searchList(viewComponentId, firstResult, maxResults, sortOrder, sortColumn, searchFields);

}

function performSearch(event, formName, viewComponentId) {

    if (event && event.which == 13){
    	
		vc_search(formName, viewComponentId);
    	return false;
    } else if (event && event.keyCode == 13){
    	vc_search(formName, viewComponentId);
    	return false;
    } else {
      return true;
    }
      
}


function vc_showSearch(formName, viewComponentId) {
	
	var id1 = 'searchRow';
	var id2 = 'pagerSearch';
	var id3 = 'cancelSearch';
	
	document.getElementById(id1).style.display = "";
	
	document.getElementById(id2).style.display = "none";
	document.getElementById(id3).style.display = '';
	
	
	/*document.getElementById("idSearchDetails").style.display = "";

	document.getElementById("idSearchDetails").style.visibility = "visible";
	document.getElementById("idSearch").style.display = "none";
	document.getElementById("idSearch").style.visibility = "hidden";*/
}

function vc_hideSearch(formName, viewComponentId) {
	
	var id1 = 'searchRow';
	var id2 = 'pagerSearch';
	var id3 = 'cancelSearch';
	var id4 = 'searchFlag';
	var id5 = 'firstResult';
	var id6 = 'maxResults';
	var id7 = 'sortOrder';
	var id8 = 'sortColumn';
	
	
	document.getElementById(id1).style.display = "none";
	
	document.getElementById(id2).style.display = "";
	document.getElementById(id3).style.display = 'none';
	
	// Now reset the table
	
    var firstResult = 1;
	var searchFlag = 0;
	var maxResults = document.forms[formName].elements[id6].value;
    var sortOrder = document.forms[formName].elements[id7].value;
	var sortColumn = document.forms[formName].elements[id8].value;
	
	maxResults = maxResults == -1 ? 10 : maxResults;

	document.forms[formName].elements[id4].value = searchFlag; // Setting the searchFlag back to 0
	document.forms[formName].elements[id5].value = firstResult; // Setting the firstResult back to 1
	
	refreshList(viewComponentId, maxResults, firstResult, sortOrder, sortColumn, searchFlag);
	
	
	
	
}

function vc_sort(sortColumn, formName, viewComponentId, ignoreCaseForSort){

	/*var showingSpan = 'pagerCounterShowing';
	if (document.getElementById(showingSpan))
    	document.getElementById(showingSpan).innerHTML = 'Processing';*/
    var id1 = 'firstResult';
	var id2 = 'sortOrder';
	var id3 = 'sortColumn';
	var id4 = 'searchFlag';
	var id5 = 'maxResults';
		
    var id6 = 'SortOrderDesc_' + sortColumn;
    var id7 = 'SortOrderAsc_' + sortColumn;
	
	var maxResults = document.forms[formName].elements[id5].value;

	maxResults = maxResults == -1 ? 10 : maxResults;
    var firstResult = document.forms[formName].elements[id1].value;
    var sortOrder = document.forms[formName].elements[id2].value;
    var searchFlag = 0;
    
    if (document.forms[formName].elements[id4]) {
    	searchFlag = document.forms[formName].elements[id4].value;
    }
    
    //var userViewId = document.forms[formName].elements[id6].value;
    
    if (document.forms[formName].elements[id3].value != ''){
        var id8 = 'SortOrderDesc_' + document.forms[formName].elements[id3].value;
        
        if (document.getElementById(id8)) {
        	document.getElementById(id8).style.visibility = "hidden";
        	document.getElementById(id8).style.display = "none";

        }

    	var id9 = 'SortOrderAsc_' + document.forms[formName].elements[id3].value;
    	
    	if (document.getElementById(id9)) {
    		document.getElementById(id9).style.visibility = "hidden";
        	document.getElementById(id9).style.display = "none";

    	}

		document.forms[formName].elements[id3].value = sortColumn;
    }

	if (document.forms[formName].elements[id2].value == 'desc' || document.forms[formName].elements[id2].value == 'descigc') {
	

		sortOrder = 'asc';

		
		document.forms[formName].elements[id2].value = sortOrder;
		
		document.getElementById(id7).style.visibility = "visible";
       	document.getElementById(id7).style.display = "";

	
	} else if (document.forms[formName].elements[id2].value == 'asc' || document.forms[formName].elements[id2].value == 'ascigc') {
		

		sortOrder = 'desc';
		
		document.forms[formName].elements[id2].value = sortOrder;
		
		document.getElementById(id6).style.visibility = "visible";
       	document.getElementById(id6).style.display = "";

		
	} else {
	
		sortOrder = 'desc';
		

		document.forms[formName].elements[id2].value = sortOrder;
		
		document.getElementById(id6).style.visibility = "visible";
		document.getElementById(id6).style.display = "";

	
	}


	if(searchFlag == 1){
		var searchFields = createSearchFieldString();
		searchList(viewComponentId, firstResult, maxResults, sortOrder, sortColumn, searchFields);
	}
	else{
		refreshList(viewComponentId, maxResults, firstResult, sortOrder, sortColumn, searchFlag);
	}

}


function vc_next(formName, viewComponentId){
	
	var id1 = 'firstResult';
	var id2 = 'sortOrder';
	var id3 = 'sortColumn';
	var id4 = 'searchFlag';
	var id5 = 'maxResults';
		
	var maxResults = document.forms[formName].elements[id5].value
		
	maxResults = maxResults == -1 ? 10 : maxResults;
	
	var firstResult =  document.forms[formName].elements[id1].value;
	
	firstResult = parseInt(firstResult) + parseInt(maxResults);
	document.forms[formName].elements[id1].value = firstResult;
	   
	var sortOrder = document.forms[formName].elements[id2].value;
	var sortColumn = document.forms[formName].elements[id3].value;
	var searchFlag = 0;
	   
	if (document.forms[formName].elements[id4]) {
			   searchFlag = document.forms[formName].elements[id4].value;
	}
		
	if(searchFlag == 1){
		var searchFields = createSearchFieldString();
		searchList(viewComponentId, firstResult, maxResults, sortOrder, sortColumn, searchFields);
	}
	else{
		refreshList(viewComponentId, maxResults, firstResult, sortOrder, sortColumn, searchFlag);
	}

}

function vc_prev(formName, viewComponentId){
	
	var id1 = 'firstResult';
	var id2 = 'sortOrder';
	var id3 = 'sortColumn';
	var id4 = 'searchFlag';
	var id5 = 'maxResults';
		
	var maxResults = document.forms[formName].elements[id5].value
		
	maxResults = maxResults == -1 ? 10 : maxResults;
	
	var firstResult =  document.forms[formName].elements[id1].value;
	
	firstResult = parseInt(firstResult) - parseInt(maxResults);
	document.forms[formName].elements[id1].value = firstResult;
	   
	var sortOrder = document.forms[formName].elements[id2].value;
	var sortColumn = document.forms[formName].elements[id3].value;
	var searchFlag = 0;
	   
	if (document.forms[formName].elements[id4]) {
			   searchFlag = document.forms[formName].elements[id4].value;
	}
	
	
	if(searchFlag == 1){
		var searchFields = createSearchFieldString();
		searchList(viewComponentId, firstResult, maxResults, sortOrder, sortColumn, searchFields);
	}
	else{
		refreshList(viewComponentId, maxResults, firstResult, sortOrder, sortColumn, searchFlag);
	}

}

function vc_last(formName, viewComponentId){
	
	var id1 = 'firstResult';
	var id2 = 'sortOrder';
	var id3 = 'sortColumn';
	var id4 = 'searchFlag';
	var id5 = 'maxResults';
	var id6 = 'totalRecords';
		
	var maxResults = document.forms[formName].elements[id5].value
		
	maxResults = maxResults == -1 ? 10 : maxResults;
	
	var firstResult =  document.forms[formName].elements[id1].value;
	var totalRecords = document.forms[formName].elements[id6].value;
	var totalPages = parseInt(totalRecords/maxResults);
	firstResult = (parseInt(maxResults) *  parseInt(totalPages)) + 1;
	
	document.forms[formName].elements[id1].value = firstResult;
	   
	var sortOrder = document.forms[formName].elements[id2].value;
	var sortColumn = document.forms[formName].elements[id3].value;
	var searchFlag = 0;
	   
	if (document.forms[formName].elements[id4]) {
			   searchFlag = document.forms[formName].elements[id4].value;
	}
	
	
	if(searchFlag == 1){
		var searchFields = createSearchFieldString();
		searchList(viewComponentId, firstResult, maxResults, sortOrder, sortColumn, searchFields);
	}
	else{
		refreshList(viewComponentId, maxResults, firstResult, sortOrder, sortColumn, searchFlag);
	}

}

function vc_first(formName, viewComponentId){
	
	var id1 = 'firstResult';
	var id2 = 'sortOrder';
	var id3 = 'sortColumn';
	var id4 = 'searchFlag';
	var id5 = 'maxResults';
		
	var maxResults = document.forms[formName].elements[id5].value
		
	maxResults = maxResults == -1 ? 10 : maxResults;
	
	var firstResult =  document.forms[formName].elements[id1].value;
	
	firstResult = 1;
	document.forms[formName].elements[id1].value = firstResult;
	   
	var sortOrder = document.forms[formName].elements[id2].value;
	var sortColumn = document.forms[formName].elements[id3].value;
	var searchFlag = 0;
	   
	if (document.forms[formName].elements[id4]) {
			   searchFlag = document.forms[formName].elements[id4].value;
	}
	
	
	if(searchFlag == 1){
		var searchFields = createSearchFieldString();
		searchList(viewComponentId, firstResult, maxResults, sortOrder, sortColumn, searchFields);
	}
	else{
		refreshList(viewComponentId, maxResults, firstResult, sortOrder, sortColumn, searchFlag);
	}

}

function removeAndRefreshList(recordId, viewComponentId, maxResults, firstResult, sortOrder, sortColumn, searchFlag){
	
	var processingSpan = 'pagerCounterProcessing';
	var showingSpan = 'pagerCounterShowing';
	document.getElementById(processingSpan).style.display = "";
	document.getElementById(showingSpan).style.display = "none";
	
	
	var url = "ajax/viewComponent.ajax.php";
	var getString = "viewComponentId=" + viewComponentId + "&removeRecord=1&recordId=" + recordId + "&daoClassName=" + daoClassName;
	
	var callback = {
	success:
		function(o) {
			
			var fieldData = o.responseText.split("^|^");
			var totalRecords = fieldData[0];
			var id1 = totalRecords;
			document.getElementById("totalRecords").value = totalRecords;
		
			if(searchFlag == 1){
				var searchFields = createSearchFieldString();
				searchList(viewComponentId, firstResult, maxResults, sortOrder, sortColumn, searchFields);
			}
			else{
				refreshList(viewComponentId, maxResults, firstResult, sortOrder, sortColumn, searchFlag);
			}
			
			
			
			
			
			
			
			

		},
	failure:
		function(o) {
		alert("AJAX doesn't work"); //FAILURE
		},
	}
	
	var transaction = YAHOO.util.Connect.asyncRequest('POST', url, callback, getString);
	
	

}


function refreshList(viewComponentId, maxResults, firstResult, sortOrder, sortColumn, searchFlag){
	
	var processingSpan = 'pagerCounterProcessing';
	var showingSpan = 'pagerCounterShowing';
	document.getElementById(processingSpan).style.display = "";
	document.getElementById(showingSpan).style.display = "none";
	
	
	
	var url = "ajax/viewComponent.ajax.php";
	var getString = "viewComponentId=" + viewComponentId + "&maxResults=" + maxResults + "&firstResult=" + firstResult + "&sortOrder=" + sortOrder + "&sortColumn=" + sortColumn + "&searchFlag="  + searchFlag + "&daoClassName=" + daoClassName;
	
	var callback = {
	success:
		function(o) {
			
			var fieldData = o.responseText.split("^|^");
			var totalRecords = fieldData[0];
			document.getElementById("totalRecords").value = totalRecords;

			document.getElementById("objectListTable").innerHTML = fieldData[1];
			var id1 = 'searchRow';
			var id2 = 'pagerSearch';
			var id3 = 'cancelSearch';
			var id4 = 'searchFlag';
			var searchFlag = 0;
			if(document.getElementById(id4)){
				searchFlag 	= document.getElementById(id4).value;
			}
			if(searchFlag == 1){
				document.getElementById(id1).style.display = "";
				document.getElementById(id2).style.display = "none";
				document.getElementById(id3).style.display = '';
			}
			
			var processingSpan = 'pagerCounterProcessing';
			var showingSpan = 'pagerCounterShowing';
			document.getElementById(processingSpan).style.display = "none";
			document.getElementById(showingSpan).style.display = "";

		},
	failure:
		function(o) {
		alert("AJAX doesn't work"); //FAILURE
		},
	}
	
	var transaction = YAHOO.util.Connect.asyncRequest('POST', url, callback, getString);
	
	
}



function vc_maxResults(formName, viewComponentId){
	
	var id1 = 'firstResult';
	var id2 = 'sortOrder';
	var id3 = 'sortColumn';
	var id4 = 'searchFlag';
	var id5 = 'maxResults';
		
	var maxResults = document.forms[formName].elements[maxResultsDropDown].value;
		
	if(maxResults == -1){
		alert("Please select a value for the number of results");
		return;
	}
	
	var firstResult =  document.forms[formName].elements[id1].value;
	var sortOrder = document.forms[formName].elements[id2].value;
	var sortColumn = document.forms[formName].elements[id3].value;
	var searchFlag = 0;;
	
	if (document.forms[formName].elements[id4]) {
			   searchFlag = document.forms[formName].elements[id4].value;
	}
	
	document.forms[formName].elements[id5].value = maxResults;

	
	
	
}

function vc_maxResultsWithSearch(formName, viewComponentId){
	
	var id1 = 'firstResult';
	var id2 = 'sortOrder';
	var id3 = 'sortColumn';
	var id4 = 'searchFlag';
	var id5 = 'maxResults';
	var id6 = 'maxResultsDropDown';
		
	var firstResult =  1;
	var sortOrder = document.forms[formName].elements[id2].value;
	var sortColumn = document.forms[formName].elements[id3].value;
	var maxResults = document.getElementById(id6).value;
		
	if(maxResults == -1){
		alert("Please select a value for the number of results");
		return;
	}
	
	var searchFlag = 0;
	
	if (document.forms[formName].elements[id4]) {
			   searchFlag = document.forms[formName].elements[id4].value;
	}

	document.forms[formName].elements[id5].value = maxResults;
	
	if(searchFlag == 1){
		var searchFields = createSearchFieldString();
		searchList(viewComponentId, firstResult, maxResults, sortOrder, sortColumn, searchFields);
	}
	else{
		refreshList(viewComponentId, maxResults, firstResult, sortOrder, sortColumn, searchFlag);
	}
	
	
}


function searchList(viewComponentId, firstResult, maxResults, sortOrder, sortColumn, searchFields){
	
	var processingSpan = 'pagerCounterProcessing';
	var showingSpan = 'pagerCounterShowing';
	document.getElementById(processingSpan).style.display = "";
	document.getElementById(showingSpan).style.display = "none";

	
	var url = "ajax/viewComponent.ajax.php";
	var getString = "viewComponentId=" + viewComponentId + "&firstResult=" + firstResult + "&maxResults=" + maxResults + "&sortOrder=" + sortOrder + "&sortColumn=" + sortColumn + "&searchFlag=1&daoClassName=" + daoClassName + "&searchFields=" + searchFields;
	
	var callback = {
	success:
		function(o) {
			var fieldData = o.responseText.split("^|^");
			var totalRecords = fieldData[0];
			document.getElementById("totalRecords").value = totalRecords;

			document.getElementById("objectListTable").innerHTML = fieldData[1];
			//document.getElementById("searchRow").style.display = "";
			var id1 = 'searchRow';
			var id2 = 'pagerSearch';
			var id3 = 'cancelSearch';
			var id4 = 'searchFlag';
			var searchFlag = 0;
			if(document.getElementById(id4)){
				searchFlag 	= document.getElementById(id4).value;
			}
			if(searchFlag == 1){
				document.getElementById(id1).style.display = "";
				document.getElementById(id2).style.display = "none";
				document.getElementById(id3).style.display = '';
			}
			
			var processingSpan = 'pagerCounterProcessing';
			var showingSpan = 'pagerCounterShowing';
			document.getElementById(processingSpan).style.display = "none";
			document.getElementById(showingSpan).style.display = "";

		},
	failure:
		function(o) {
		alert("AJAX doesn't work"); //FAILURE
		},
	}
	
	var transaction = YAHOO.util.Connect.asyncRequest('POST', url, callback, getString);
	
	
}


var refreshViewComponentTableData = function(data) {

	var fieldData = data.split("<@>");

	var cellCount = fieldData[0];
	var rowCount = fieldData[1];
	var maxRows = fieldData[2];
	var pagerCounterFirst = fieldData[3];
	var firstResultField = 'firstResult';
	
	if (pagerCounterFirst > 0) {
		var pagerCounterLast = fieldData[4];
		var pagerCounterTotal = fieldData[5];
		var pagerPrevious = fieldData[6];
		var pagerNext = fieldData[7];
		var pagerFirst = fieldData[8];
		var pagerLast = fieldData[9];
		var viewComponentID = fieldData[10];
		var message = fieldData[11];
		var totalCount = fieldData[12];
		var formName = fieldData[13];
		var cellTotal = fieldData[14];
		var indexCounter = 15; //The first 14 values are used for the above values
		
		document.forms[formName].elements[firstResultField].value = parseInt(pagerCounterFirst) - 1;
		
	} else {
		var noResults = fieldData[4];
		var viewComponentID = fieldData[5];
		var message = fieldData[6];
		var totalCount = fieldData[7];
		var formName = fieldData[8];
		var cellTotal = fieldData[9];
		var indexCounter = 10; //The first 9 values are used for the above values
		
		document.forms[formName].elements[firstResultField].value = 0;
	}

	var cellID = "";
	var rowID = "";
	var removeRowID = "";
	var removeCellID = "";
	var vcRowNumCellPrefix = "vcRowNumCol_ID_R";
	var vcRowNumCell = "";
	var vcRowNumCellValue = parseInt(pagerCounterFirst);
	var vcwTotalCell2 = "vcwTotalCell2";

	// Draw list out
	
	if (pagerCounterFirst > 0){
		for (var rowCounter = 0; rowCounter < rowCount; rowCounter++) {
		
			// Is the list displaying the rowNumber Column? If so, refresh it
			vcRowNumCell = vcRowNumCellPrefix + rowCounter;

			if (document.getElementById(vcRowNumCell)){
				document.getElementById(vcRowNumCell).innerHTML = vcRowNumCellValue;
				vcRowNumCellValue++;
			}
		
			for (var cellCounter = 0; cellCounter < cellCount; cellCounter++, indexCounter++) {
				cellID = 'dataCell_ID' + viewComponentID + '_R' + rowCounter + '_C' + cellCounter;
				if (document.getElementById(cellID)){
					document.getElementById(cellID).innerHTML = fieldData[indexCounter];
				}
			}
			
			removeCellID = 'removeColumn_ID' + viewComponentID + '_R' + rowCounter;
			if (document.getElementById(removeCellID)){
				document.getElementById(removeCellID).innerHTML = fieldData[indexCounter];
			}
			indexCounter++;
			
			rowID = 'dataRow_ID' + viewComponentID + '_R' + rowCounter;
			document.getElementById(rowID).style.display = '';
			document.getElementById(rowID).style.visibility = "visible";
			
		}
	} else {
		for (var cellCounter = 0; cellCounter < cellCount; cellCounter++, indexCounter++)
			document.getElementById('dataCell_ID' + viewComponentID + '_R0_C' + cellCounter).innerHTML = "&nbsp;";
		removeCellID = '"removeColumn_ID'+viewComponentID+'_R0';
		if (document.getElementById(removeCellID)){
			document.getElementById(removeCellID).innerHTML = "&nbsp;";
		}
		var rowCounter = 0;
		
		/* Display noResultsFound span */
		if (document.getElementById('noResultsFound')){
			document.getElementById('noResultsFound').style.visibility = "visible";
			document.getElementById('noResultsFound').style.display = "";
		}
		
	}

	// Remove old row
	while (rowCounter <= maxRows) {

		rowID = 'dataRow_ID' + viewComponentID + '_R' + rowCounter;
		
		//removeRowID = 'vcRemoveRow_ID' + instanceId + '_R' + rowCounter;
		removeCellID = 'removeColumn_ID' + viewComponentID + '_R' + rowCounter;
		
		for (var cellCounter = 0; cellCounter < cellCount; cellCounter++) {
			cellID = 'dataCell_ID' + viewComponentID + '_R' + rowCounter + '_C' + cellCounter;
			if (document.getElementById(cellID)){
				document.getElementById(cellID).innerHTML = "&nbsp;";
			}
		}
		
		if (document.getElementById(removeCellID)){
			document.getElementById(removeCellID).innerHTML = "&nbsp;";
		}
		
		if (document.getElementById(rowID) && rowCount > 0){
			document.getElementById(rowID).style.display = 'none';
			document.getElementById(rowID).style.visibility = "hidden";
		}
		
		//if (document.getElementById(removeRowID) && rowCount > 0){
		//	document.getElementById(removeRowID).style.display = 'none';
		//}
		
		rowCounter++;
	}
	
	if (totalCount != '-1'){
		document.getElementById('vcwTotalCell2').innerHTML = totalCount;
	}
	
	/* If there are no more results, display 1 blank row */
	
	if (pagerCounterFirst < 1) {
		var rowCounterTemp = 0;
		
		rowID = 'dataRow_ID' + viewComponentID + '_R' + rowCounterTemp;
		removeCellID = 'removeColumn_ID' + viewComponentID + '_R' + rowCounterTemp;
		
		for (var cellCounter = 0; cellCounter < cellCount; cellCounter++) {
			cellID = 'dataCell_ID' + viewComponentID + '_R' + rowCounterTemp + '_C' + cellCounter;
			if (document.getElementById(cellID)){
				document.getElementById(cellID).innerHTML = "&nbsp;";
			}
		}
		
		if (document.getElementById(removeCellID)){
			document.getElementById(removeCellID).innerHTML = "&nbsp;";
		}

		document.getElementById(rowID).style.display = '';
		document.getElementById(rowID).style.visibility = "visible";

	
	}
	
	// Display Message Row if Necessary
	
	/*if (message == '0'){
		document.getElementById('vcwMessageRow').style.visibility = "hidden";
		document.getElementById('vcwMessageRow').style.display = "none";
	} else {
		document.getElementById('vcwMessageCell').innerHTML = message;
		document.getElementById('vcwMessageRow').style.visibility = "visible";
		document.getElementById('vcwMessageRow').style.display = "";

	}
	
	// Update cellTotal if Necessary
	if (document.getElementById('vcwTotalCell2')){
			document.getElementById('vcwTotalCell2').innerHTML = cellTotal;
	}*/

	// Refresh pager
	
	if (pagerCounterFirst > 0){
	
		if (document.getElementById('pagerArea')){
			document.getElementById('pagerArea').style.visibility = "visible";
			document.getElementById('pagerArea').style.display = '';
		}
			
		if (document.getElementById('pagerCounterFirst'))
			document.getElementById('pagerCounterFirst').innerHTML = pagerCounterFirst;
		
		if (document.getElementById('pagerCounterLast'))
			document.getElementById('pagerCounterLast').innerHTML = pagerCounterLast;
	
		if (document.getElementById('pagerCounterTotal'))
			document.getElementById('pagerCounterTotal').innerHTML = pagerCounterTotal;
			
		if (document.getElementById('pagerPrevious'))
			document.getElementById('pagerPrevious').innerHTML = pagerPrevious;
			
		if (document.getElementById('pagerNext'))
			document.getElementById('pagerNext').innerHTML = pagerNext;
	
		if (document.getElementById('pagerFirst'))
			document.getElementById('pagerFirst').innerHTML = pagerFirst;
			
		if (document.getElementById('pagerLast'))
			document.getElementById('pagerLast').innerHTML = pagerLast;
			
		/*if (document.getElementById('noResultsFound'))
			document.getElementById('noResultsFound').innerHTML = '';
			
		var showingSpan = 'pagerCounterShowing';
		if (document.getElementById(showingSpan))
    		document.getElementById(showingSpan).innerHTML = 'Showing';*/
    
	} else {
		/*
		if (document.getElementById('noResultsFound'))
			document.getElementById('noResultsFound').innerHTML = noResults;
			
		if (document.getElementById('pagerArea')){
			document.getElementById('pagerArea').style.visibility = "hidden";
			document.getElementById('pagerArea').style.display = 'none';
		}*/

	}


}
