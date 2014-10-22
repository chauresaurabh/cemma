<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
	
	if(isset($_POST['CustomerName']))
	{
		include_once("util.php");
		$name = $_POST['CustomerName'];
		$machine = $_POST['MachineName'];
		$fulldate = split('[/]',$_POST['date']);
		$month = $fulldate[0];
		$date = $fulldate[1];
		$year = $fulldate[2];
		$operator = $_POST['Operator'];
		$newOperator = $_POST['newOperator'];
		$woperator= $_POST['woperator'];
		$qty= $_POST['qty'];
		$type = $_POST['type'];
		$fromdate = "$year-$month-01";
		$todate = "$year-$month-31";
		$invoiceno = $_POST['invoiceno'];
		//echo "invno=".$invoice;
		$mid = $_SESSION['mid'];
		$actualUnitPrice = $_POST['actualUnitPrice'];
		$unitPrice = $_POST['unit'];
		$total = $_POST['total'];
		$overriddenFlag = $_POST['overriddenFlag'];
		
		#echo "OVERRIDDEN FLAG = ".$overriddenFlag;
		
		if($overriddenFlag == 1){
			$actualUnitPrice = $unitPrice;
		}
		
		
		$films = array();
		#$films = array("Film - EM Film TEM");
		
		$insert_date = $year."-".$month."-".$date;
				
		if($newOperator == "1"){
			$sql = "INSERT into operators (Manager_ID, customer, operator) values ('$mid', '$name','$operator')";
			mysql_query($sql) or die("An error has occured, please try again later");
		}
		
		if($woperator == 1){
			$string = "With_Operator";
			$showstring = "Yes";
		}
		else{
			$string = "Without_Operator";
			$showstring = "No";
		}
		
		$final = $type."_".$string;
		#echo $type.'@@';
		$sql = "INSERT INTO Customer_data (Name, Machine, Qty, Date, Operator, Type, WithOperator, Unit, Total, Manager_ID, OverriddenFlag, Gdate)
				VALUES ('$name', '$machine', '$qty', '$insert_date', '$operator', '$type', '$woperator', '$actualUnitPrice', '$total', '$mid',
				'$overriddenFlag', curdate())";
				
		#echo $sql;
		
		mysql_query($sql) or die( "An error has ocured: " .mysql_error (). ":" .mysql_errno ());
		
		updateFurtherDiscounts($fromdate, $todate, $name, $machine, $films);
		
		$sql = "select Total from Customer_data where invoiceno = '$invoiceno' AND Gdate = '$Gdate' AND Manager_ID = '$mid'";
		//echo $sql;
		$result = mysql_query($sql) or die ("Error in Total");
		$edit_total = 0;
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$edit_total += $row['Total'];
		}
		$sql = "UPDATE Invoice SET Total = '$edit_total' WHERE invoiceno = '$invoiceno' AND Gdate = '$Gdate'";
		//echo $sql;
		mysql_query($sql) or die ("Error in Updating Total");

		$msg = "Record has been added successfully";
		
	}
?>
<link href="css/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="scripts/calendar.js"></script>
<script type="text/javascript" src="scripts/calendar-en.js"></script>
<script type="text/javascript">
<!--
var calendar = null;
var oldLink = null;
//-->
</script>
<script type="text/javascript" src="scripts/date.js"></script>
<script type="text/javascript">

function addRecord(){

	if(!confirm("Are you sure you want to Add the Record?"))  return;
	
	// Getting form Values
	var theform = document.myform;
	var CustomerName = theform.CustomerName.value;
	var OperatorName = theform.OperatorName.value;
	var MachineName = theform.MachineName.value;
	var fulldate = theform.date.value.split("/");
	var month = fulldate[0];
	var date= fulldate[1];
	var year = fulldate[2];
	var qty = theform.qty.value;
	var type = theform.type.value;

	theform.newOperator.value = 0;
	
	if (theform.woperator[0].checked)
		woperator = 1;
	else
		woperator = 0;
	
	if(OperatorName == "Other"){
		theform.Operator.value = theform.otheroperator.value;
		theform.newOperator.value = 1;
	}
	else{
		theform.Operator.value = theform.OperatorName.value
	}
	
	var error = "";
	// Error Checking
	if(CustomerName == "-1"){
		error = "Please select the Customer";
	}
	else if(MachineName == "-1"){
		error += "Please select the Instrument";
	}
	else if(OperatorName == "-1"){
		error += "Please select the Operator";
	}
	else if(OperatorName == ""){
		error += "Please specify the Operator";
	}
	else if(!checkDigits(qty)){
		error += "Invalid Quantity";
	}

	
	if(error!=""){
		document.getElementById("error").innerHTML = error;
		showRow("error");
		return false;
	}	
	else{
		document.myform.submit();
	}
}

function showRow(id){
	document.getElementById(id).style.display = "";
}

function hideRow(id){
	document.getElementById(id).style.display = "none";

}

function checkajax() {
   var xmlHttp;
   try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
     } catch (e) {
        // Internet Explorer
        try {
          xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
       } catch (e) {
          try {
               xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
               alert("Your browser does not support AJAX!");
               return false;
            }
       }
     }
   
   return xmlHttp;
}
//This function is called on page load.
function fillData(){
	i=0;
	j=0;
	k=0;
	document.getElementById("MachineName").options[i++] = new Option("Select the Instrument", "-1");
	document.getElementById("MachineName").options[i-1].disabled = 'disabled';

	document.getElementById("CustomerName").options[j++] = new Option("Select the Customer", "-1");
	document.getElementById("CustomerName").options[j-1].disabled = 'disabled';

	document.getElementById("OperatorName").options[k++] = new Option("Select the Operator", "-1");
	document.getElementById("OperatorName").options[k-1].disabled = 'disabled';
	// Filling Instrument Box
	<?
	//include_once('olddatabase.php');
	$sql = "SELECT InstrumentName FROM instrument order by InstrumentName";
	$result = mysql_query($sql);
	
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
	?>
	document.getElementById("MachineName").options[i++] = new Option("<? echo $row['InstrumentName']; ?>", "<? echo $row['InstrumentName']; ?>");
	// Filling Customer Box
	<?
	}
	$sql = "SELECT Name FROM Customer order by Name";
	$result = mysql_query($sql);
	$count=0;
	
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$custdroplist[$count++]=$row['Name'];
	?>
	document.getElementById("CustomerName").options[j++] = new Option("<? echo $row['Name']; ?>", "<? echo $row['Name']; ?>");
	
	<?
	}
	?>
<? //fill advisors from user table
	/*$dbhost="db948.perfora.net";
	$dbname="db210021972";
	$dbusername="dbo210021972";
	$dbpass="XhYpxT5v"; */
	$dbhost="db1661.perfora.net";
$dbname="db260244667";
$dbusername="dbo260244667";
$dbpass="curu11i";

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DBbb");


	$sql = "SELECT distinct Advisor FROM user order by Advisor";
	$result = mysql_query($sql);
	?>
	document.getElementById("CustomerName").options[j++] = new Option("Select from Advisors", "-1");
	document.getElementById("CustomerName").options[j-1].disabled = 'disabled';
	<?
		$count=0;
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$count++;
		if($row['Advisor']!='')
		{
			$match=0;
			for ($kk=0;$kk<$count ;$kk++ )
			{
				if ($row['Advisor']==$custdroplist[$kk])
				{$match=1;
				}
			}
			if ($match!=1) //dont display dupliacte entries ie entries from tables customer=user;
			{
			
	?>
			document.getElementById("CustomerName").options[j++] = new Option("<? echo $row['Advisor']; ?>", "<? echo $row['Advisor']; ?>");
	
	<?
			}
		}
	}
	?>
		

	// Filling Type Box
	/*
	document.getElementById("type").options[0] = new Option("USC Campus Users","On-Campus")
	document.getElementById("type").options[1] = new Option("Off Campus Academic","Off-Campus")
	document.getElementById("type").options[2] = new Option("Commercial-Industry", "Commercial")
	*/
}


function loadOperator(){
	var theform = document.myform;
	var CustomerName = theform.CustomerName.value;
	var xmlHttp = checkajax();
   
	xmlHttp.onreadystatechange=function() {
		if(xmlHttp.readyState!=4)
			document.getElementById("error").innerHTML = "<img src = images/busy.gif>";
	   
		if(xmlHttp.readyState==4) {
			document.getElementById("error").innerHTML = "&nbsp;";
			document.getElementById("divop").innerHTML = xmlHttp.responseText;
		}
	}   

	xmlHttp.open("GET","loadOperator.php?CustomerName="+CustomerName ,true);
    xmlHttp.send(null);   
}

function loadType() {
	var CustomerName = document.myform.CustomerName.value;
	var xmlHttp = checkajax();
	xmlHttp.onreadystatechange=function() {
		if(xmlHttp.readyState!=4)
			document.getElementById("error").innerHTML = "<img src = images/busy.gif>";
	   
		if(xmlHttp.readyState==4) {
			
			document.getElementById("error").innerHTML = "&nbsp;";
			var res = xmlHttp.responseText.split('|');
			//alert(xmlHttp.responseText);
			if(res[0]=="OK") {
				document.getElementById("edit_type").innerHTML = "<a href='editCustomer.php?id="+res[1]+"'>Go to edit</a>";
				if(res[2]=="On-Campus") {
					document.getElementById("type_alt").value = "USC Campus Users";
					document.getElementById("type").value = "On-Campus";
				}
				else if(res[2]=="Off-Campus") {
					document.getElementById("type_alt").value = "Off Campus Academic";
					document.getElementById("type").value = "Off-Campus";
				}
				else if(res[2]=="Industry") {
					document.getElementById("type_alt").value = "Industry";
					document.getElementById("type").value = "Industry";
				}
				else {
					document.getElementById("type_alt").value = "Unexpected Error! (#1)";
					document.getElementById("type").value = "";
				}
			}
			else {
				document.getElementById("type").value = "Unexpected Error! (#2)";
			}
			
			
			
			//alert(CustomerName+"|"+"php/loadType.php?name="+CustomerName+"|"+xmlHttp.responseText);
		}
	}   

	xmlHttp.open("GET","php/loadType.php?name="+CustomerName ,true);
    xmlHttp.send(null);   
	
}

function checkOther()
{
	if(document.getElementById("OperatorName").value == "Other")
		document.getElementById("otheroperator").disabled = false;
	else{
		document.getElementById("otheroperator").value = "";
		document.getElementById("otheroperator").disabled = true;
	
	}
}

function checkType()
{
	if(document.getElementById("type").selectedIndex == 2){
		window.document.getElementById("myform").woperator[1].disabled = true;
		window.document.getElementById("myform").woperator[0].checked = true;
	}
	else
		window.document.getElementById("myform").woperator[1].disabled = false;
}

function checkDigits(string){
	digitRegex = /^\d+(\.\d+)?$/;
	if( !string.match( digitRegex ) ) {
	  return false;
	}
	return true;
}

function getCustomerList(type)
{
	var xmlHttp = checkajax();
	xmlHttp.onreadystatechange=function() {
		if(xmlHttp.readyState==4 && xmlHttp.status==200) {
			document.getElementById("CustomerName").innerHTML = xmlHttp.responseText;
		}
	}
	xmlHttp.open("GET","php/getCustomerList.php?type="+type ,true);
	xmlHttp.send(null);
}
getCustomerList('curr');
</script>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
    
    <td class="body" valign="top" align="center">
    <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
    <table border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
        
        <td class="body_resize">
        
        <table border="0" cellpadding="0" cellspacing="0" align="left">
            <tr>
            
            <td>
            
            <table width="100%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td class="t-top"><div class="title2">Add Record</div></td>
                </tr>
                <tr>
                
                <td class="t-mid">
                
                <br />
                <br />
                <form id = "myform" name="myform" method="post">
                    <table width="75%" align="center">
					<input type="hidden" name="Operator" id="Operator">
					<input type="hidden" name="newOperator" id="newOperator">
   					<input type="hidden" name="actualUnitPrice" id="actualUnitPrice">
                    
						<tr valign="top">

							<td width="100%" colspan="2"><div align="center" class="err" id="error" style="display:none"></div>
							
							<? if($msg != '')
								echo '<div align="center" class="alert" style="font-size:13; id="error1">'.$msg.'</div>';
							?></td>
						</tr>
						
						<tr class="Trow">
                            <td width="45%" rowspan='2'>Customer Name: *</td>
                            <td width="55%">
								<select id= "CustomerName" name="CustomerName" style="width:40mm" onChange = "loadOperator(); loadType();";>
                                </select>
							</td>
                        </tr>
						<tr>
							<td>
								<input type="radio" name="customer_type" id="curr_customer" checked=true onclick="getCustomerList('curr')">Current 
								<input type="radio" name="customer_type" id="arch_customer" onclick="getCustomerList('arch')">Archived
							</td>
						</tr>
                        <tr class="Trow">
                            <td>Instrument: *</td>
                            <td><select id= "MachineName" name="MachineName" style="font-weight:normal; width:40mm" onchange="retrieveUnitPrice();">
                                </select></td>
                        </tr>
                        <tr class="Trow">
                            <td>Operator: *</td>
                            <td><div id = "divop">
                                    <select id="OperatorName" name="OperatorName" style="font-weight:normal; width:40mm" onChange ="checkOther()">
                                    </select>
                                </div></td>
                        </tr>
                        <tr class="Trow">
                            <td>If Other, please enter here</td>
                            <td><input type="text" class="box" size="20" name="otheroperator" id = "otheroperator" disabled="disabled"></td>
                        </tr>
                        <tr class="Trow">
                            <td>Date: *</td>
                            <td><input type="text" name="date" id="date" readonly="readonly" size = "10" onfocus = "retrieveUnitPrice()" />
                                <img src = "images/calendar.gif" height="20" width = "20" id="date_calendar" value="calendar" onClick="showCalendar('date', 'mm/dd/y'); retrieveUnitPrice();" style="cursor:pointer" /> </td>
                        </tr>
                        <tr class="Trow">
                            <td>Quantity: *</td>
                            <td><input type="text" class="box" size="20" name="qty" id = "qty" onchange="retrieveUnitPrice();"></td>
                        </tr>
                        <tr class="Trow">
                        
                        <tr class="Trow">
                            <td>Unit Price *</td>
                            <td><input type="text" class="box" size="4" name="unit" id = "unit" onchange="updateTotal();" readonly="readonly">
                            <input type="checkbox" name = "overriddenFlag" id="overriddenFlag" onchange="toggleUnitField(this.id); retrieveUnitPrice();" style="margin-left:3px;" value="1"/>Override
                            </td>
                        </tr>
                        
                        <tr class="Trow" style="font-size:10px;height:10px;display:none;font-style:italic" id = "discountRow">
                            <td></td>
                            <td>Qualifies for Discount</td>
                        </tr>
                        
                        <tr class="Trow">
                            <td>Total *</td>
                            <td><input type="text" class="box" size="20" name="total" id = "total" readonly="readonly" style="background-color:#F5F5F5"></td>
                        </tr>
                        
                        <!--
                        <tr class="Trow">
							<td>Type: *</td>
							<td><select id="type" name="type" style="font-weight:normal; width:40mm;" onChange = "checkType(); retrieveUnitPrice();"></select>
							</td>
                        </tr>
						-->
						
						<tr class="Trow">
							<td>Type: *</td>
							<td>
								<input type="text" class="box" size="20" id = "type_alt" readonly="readonly" style="background-color:#F5F5F5;color:blue;">
								<input type="hidden" name="type" id = "type" onChange = "checkType(); retrieveUnitPrice();">
								<span id="edit_type"></span>
							</td>
                        </tr>
						
                        <tr class="Trow">
                        <td>With Cemma Operator: *</td>
                        <td>
                        <input type = "radio" name = "woperator" id= "woperator" value = "1" onchange="retrieveUnitPrice()">Yes
                        <input type = "radio" name = "woperator" id= "woperator" value = "0" checked = "checked" onchange= "retrieveUnitPrice()">No
                        </td>
                        </tr>
                        <tr class="Trow">
                        	<td colspan="2">&nbsp;</td>                      
                        </tr>                       
                    </table>
                </form>
                </tr>
                
                <tr>
                    <td class="t-bot2"><a onclick="addRecord();" style="cursor: pointer; background: url(&quot;images/mini/action_go.gif&quot;) no-repeat scroll left center transparent; color: rgb(153, 102, 0); font-size: 11px; font-weight: bold; padding-left: 20px; text-decoration: none;">Add Record</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_records.php">Return</a></td>
                </tr>
            </table>
            </td>
            
            </tr>
            
        </table>
        <div class="clr"></div>
        </td>
        
        </tr>
        
    </table>
    </td>
    
    </tr>
    
</table>
</td>
</tr>
</table>
<script type="text/javascript">
fillData();

function retrieveUnitPrice(){

	var formName = "myform";
	var id1 = "MachineName";
	var id2 = "type";
	var id3 = "woperator";
	var id4 = "CustomerName";
	var id5 = "date";
	var id6 = "unit";
	var id7 = "overriddenFlag";
	var id8 = "discountRow";
	
	var overriddenFlag = document.forms[formName].elements[id7].checked
	
	if(overriddenFlag == true) {
		updateTotal();
		return;
	}

	var actionType = <?= ACTION_TYPE_RETRIEVE_UNIT_PRICE ?>;
	var instrumentName = document.forms[formName].elements[id1].value;
	var type = document.forms[formName].elements[id2].value;
	var customerName = document.forms[formName].elements[id4].value;
	if(customerName == <?= DEFAULT_SELECT_TYPE_INT ?>) customerName = "";
	var date = document.forms[formName].elements[id5].value;
	
	var woperatorRadioBox = document.forms[formName].elements[id3];
	var woperator = "";
	for(var i = 0; i < woperatorRadioBox.length; i++){
		if(woperatorRadioBox[i].checked == true){
			woperator = woperatorRadioBox[i].value;
		}
	}
	
	
	var url = "ajax/util.ajax.php";
	var getString = "instrumentName=" + instrumentName + "&type=" + type + "&woperator=" + woperator + "&customerName=" + customerName +
	 				"&date=" + date + "&actionType="  + actionType;
	//alert(getString);
	var callback = {
	success:
		function(o) {
			//alert(o.responseText);
			var fieldData = o.responseText.split("^|^");
			//alert(fieldData[0]);
			//alert(fieldData[1]);
			
			updateUnitPriceField(fieldData[0], fieldData[1]);
			
			
		},
	failure:
		function(o) {
		alert("AJAX doesn't work"); //FAILURE
		},
	}
	
	var transaction = YAHOO.util.Connect.asyncRequest("POST", url, callback, getString);

}

function updateTotal(){

	var formName = "myform";
	var id1 = "qty";
	var id2 = "unit";
	var id3 = "total";
	
	var qty = document.forms[formName].elements[id1].value;
	var unitPrice = document.forms[formName].elements[id2].value;
	
	if(qty != "" && unitPrice != ""){
		var total = qty*unitPrice;
		document.forms[formName].elements[id3].value = total;
	}
	else{
		document.forms[formName].elements[id3].value = "";
	}

}

function updateUnitPriceField(unitPrice, discountFlag){
	var formName = "myform";
	var id1 = "unit";
	var id2 = "discountRow";
	var id3 = "actualUnitPrice";
	
	document.forms[formName].elements[id3].value = unitPrice;
	if(discountFlag == 1){
		unitPrice = unitPrice/2;
		showRow(id2);
	}
	else {
		hideRow(id2);
	}
	
	document.forms[formName].elements[id1].value = unitPrice;
	updateTotal();

}

function toggleUnitField(checkBoxId){
//alert(checkBoxId);
	var formName = "myform";
	var id1 = "unit";
	if(document.forms[formName].elements[checkBoxId].checked == true){
		document.forms[formName].elements[id1].removeAttribute('readonly');
		addClass(document.forms[formName].elements[id1],"highlightTextField");
	}
	else{
		document.forms[formName].elements[id1].setAttribute('readonly', 'readonly');
		removeClass(document.forms[formName].elements[id1],"highlightTextField");
	}
	
}


</script>
<? include ('tpl/footer.php'); ?>
