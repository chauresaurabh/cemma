<?
include_once ('constants.php');
include_once (DOCUMENT_ROOT . "includes/checklogin.php");
include_once (DOCUMENT_ROOT . "includes/checkadmin.php");
include (DOCUMENT_ROOT . 'tpl/header.php');
include_once (DOCUMENT_ROOT . 'DAO/recordDAO.php');

include_once ("includes/action.php");

$dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";
	$emailId = $_GET['email'];
	
	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
	
$username = $_GET['username'];
$accountnum = 0;
$accountSql="SELECT AccountNum FROM user WHERE ActiveUser='active' AND Name LIKE '".str_replace(" ", "%", $username)."'";
	 
	$accountResult = mysql_query($accountSql);
	
	while($accountrow=mysql_fetch_array($accountResult)) {
			$accountnum = $accountrow['AccountNum'];		
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
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td class="body" valign="top" align="center">
        <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
		<table border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td class="body_resize">
				<table border="0" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td><?php $rs = new RecordDAO();
							$rs -> getSingleRecord($_GET['id']);
							while ($row1 = $rs -> fetchSingleRecord()) {
								$row = $row1;
								$date_array = explode("-", $row['Date']);
								$var_year = $date_array[0];
								$var_month = $date_array[1];
								$var_day = $date_array[2];
								$op = $row['Operator'];
								#echo "####:".$op."<br>";
							}
						?>

						<table width="100%" border="0" cellpadding="5" cellspacing="0">
							<tr valign="top">
								<td width="100%"><div align="center" class="err" id="error" style="display:none"></div></td>
							</tr>
						</table>
						<table width="100%" border="0" cellpadding="5" cellspacing="0">
							<tr>
								<td class="t-top">
								<div class="title2">
									<?php echo(($_GET['submit_mode'] == 'add') ? 'Add ' : 'Edit ');?>Record
								</div></td>
							</tr>
							<tr>
								<td class="t-mid">
								<br />
								<br />
								<form id="myForm" name="myForm" method="post" action="editRecord.php?id=<?=$_GET['id']?>&submit_mode=<?php echo $_GET['submit_mode'];?>">
									<input type="hidden" id="Manager_ID" name="Manager_ID" value="<? echo $_SESSION['mid'] ?>" />
									<input type="hidden" id="number" name="number" value="<?php echo $row['Number'] ?>" />
									<input type="hidden" id="Gdate" name="Gdate" value="<?php echo $row['Gdate'] ?>" />
									<input type="hidden" id="Invoiceno" name="Invoiceno" value="<?php echo $row['invoiceno'] ?>" />
									<div align="center" class="alert" style="font-size:13;display:none" id="alert"></div>
									<table width="75%" align="center">
										<tr class="Trow">
											<td width="45%">Customer Name: *</td>
											<td width="55%">
											 <select id= "CustomersName" name="CustomersName" style="font-weight:normal; width:50mm" onchange="loadNewOperator();"></select>
											</td>
										</tr>
										<tr class="Trow">
											<td>Instrument: *</td>
											<td><select id= "MachineName" name="MachineName" style="font-weight:normal; width:50mm"></select></td>
										</tr>
										<tr class="Trow">
											<td>Operator: *</td>
											<td>
											<div id = "divop">
												<select id="OperatorName" name="OperatorName" style="font-weight:normal; width:50mm" onChange ="checkOther()"></select>
											</div></td>
										</tr>
                                        
 										<tr class="Trow">
											<td>If Other, please enter here</td>
											<td>
											<input type="text" class="box" size="20" name="otheroperator" id = "otheroperator" disabled="disabled">
											</td>
										</tr>
                                        
                                         <tr class="Trow">
											<td>Account Number: </td>
											<td>
											<div id = "divop">
												<input type="text" id="AccountNumber" name="AccountNumber" value="<? echo $accountnum ;?>" />
											</div></td>
										</tr>
                                        
                                        
										<tr class="Trow">
											<td>Date: *</td>
											<td>
											<input type="text" name="date" id="date" readonly="readonly" size = "10" value = "<?php echo $var_month.'/'.$var_day.'/'.$var_year ?>"/>
											<img src = "images/calendar.gif" height="20" width = "20" id="date_calendar" value="calendar" onClick="showCalendar('date', 'mm/dd/y')" style="cursor:pointer" /></td>
										</tr>
                                        
                                        <tr class="Trow">
											<td>Login Time: *</td>
											<td>
											<input type="text" class="box" size="20" name="logintime" id = "logintime" value = "<?php echo $row['Time'] ?>" style="font-weight:normal; width:48mm">
											</td>
										</tr>
                                        	<tr class="Trow">
											<td>Logout Time: *</td>
											<td>
											<input type="text" class="box" size="20" name="logintime" id = "logintime" value = "<?php echo $row['logouttime'] ?>" style="font-weight:normal; width:48mm" >
											</td>
										</tr>
                                        
										<tr class="Trow">
											<td>Quantity: *</td>
											<td>
											<input type="text" class="box" size="20" name="qty" id = "qty" value = "<?php echo $row['Qty'] ?>" style="font-weight:normal; width:48mm" onchange="updateTotal()">
											</td>
										</tr>
										<tr class="Trow">
											<td>Unit Price *</td>
											<td>
											<input type="text" class="box" size="4" name="unit" id = "unit" onchange="updateTotal()" <?php
											if ($row['OverriddenFlag'] == 1) {
											} else
												echo 'readonly="readonly"';
											?>  value = "<?php echo $row['Unit'] ?>">
											<input type="checkbox" name = "overriddenFlag" id="overriddenFlag" onchange="toggleUnitField(this.id)" style="margin-left:3px;" <?php
											if ($row['OverriddenFlag'] == 1)
												echo "checked='checked'";
											?> />
											Override </td>
										</tr>
										<tr class="Trow" style="font-size:10px;height:10px;display:none;font-style:italic" id = "discountRow">
											<td></td>
											<td>Qualifies for Discount</td>
										</tr>
										<tr class="Trow">
											<td>Total *</td>
											<td>
											<input type="text" class="box" size="20" name="total" id = "total" readonly="readonly"  style="background-color:#F5F5F5" value = "<?php echo $row['Total'] ?>">
											</td>
										</tr>
										<tr class="Trow">
											<td>Type: *</td>
											<td><select id="type" name="type" style="font-weight:normal; width:50mm" onChange = "checkType()"></select></td>
										</tr>
								 
                                 	<tr class="Trow">
											<td>With Cemma Operator: *</td>
											<td>
											<input type = "radio" name = "woperator" id= "woperatoryes" value = "1" checked = "checked" onclick="togglecemmastaff();">
											Yes
											<input type = "radio" name = "woperator" id= "woperatorno" value = "0" onclick="togglecemmastaff();">
											No </td>
										</tr>
                                  
                                        <tr class="Trow">
											<td id="cemmastafflabel" >Cemma Staff:</td>
											<td><select id= "CemmaStaff" name="CemmaStaff" style="font-weight:normal; width:50mm"></select></td>
										</tr>
                                        
                                        
										<tr class="Trow">
											<td colspan="2">&nbsp; </td>
										</tr>
									</table>
									<br />
									<br />
								</form></td>
							</tr>
							<tr>
								<td class="t-bot2"><a href="javascript: changeRecord()"><?php echo(($_GET['submit_mode'] == 'add') ? 'Add' : 'Modify');?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                           
                                <a href="#" onclick="closeWindow();return false;">Close</a></td>
							</tr>
						</table></td>
					</tr>
				</table><div class="clr"></div></td>
			</tr>
		</table></td>
	</tr>
</table>
</td>
</tr>
</table>
<script type="text/javascript">
		//updateTotal();


	function togglecemmastaff(){
			 
			if(document.getElementById('woperatoryes').checked)
			{
				document.getElementById('cemmastafflabel').style.visibility='visible';
				document.getElementById('CemmaStaff').style.visibility='visible';
 			}else{
				document.getElementById('cemmastafflabel').style.visibility='hidden';
				document.getElementById('CemmaStaff').style.visibility='hidden';
 			}
			
	}
	
	function retrieveUnitPrice(){
	alert('in ret');
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

	var actionType =<?= ACTION_TYPE_RETRIEVE_UNIT_PRICE
	?>;
	var instrumentName = document.forms[formName].elements[id1].value;
	var type = document.forms[formName].elements[id2].value;
	var customerName = document.forms[formName].elements[id4].value;
	if(customerName == <?= DEFAULT_SELECT_TYPE_INT
	?>) customerName = "";
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

	var callback = {
	success:
	function(o) {
	var fieldData = o.responseText.split("^|^");
	updateUnitPriceField(fieldData[0], fieldData[1]);

	},
	failure:
	function(o) {
	alert("AJAX doesn't work"); //FAILURE
	},
	}

	var transaction = YAHOO.util.Connect.asyncRequest('POST', url, callback, getString);

	}

	function toggleUnitField(checkBoxId){
	//alert(checkBoxId);
	var formName = "myform";
	var id1 = "unit";
	if(document.getElementById("overriddenFlag").checked == true){
	document.getElementById("unit").removeAttribute('readonly');
	addClass(document.getElementById("unit"),"highlightTextField");
	}
	else{
	document.getElementById("unit").setAttribute('readonly', 'readonly');
	removeClass(document.getElementById("unit"),"highlightTextField");
	}

	}

	function updateTotal(){
	var formName = "myform";
	var id1 = "qty";
	var id2 = "unit";
	var id3 = "total";

	//var qty = document.forms[formName].elements[id1].value;
	//var unitPrice = document.forms[formName].elements[id2].value;
	var qty = document.getElementById("qty").value;
	var unitPrice = document.getElementById("unit").value;

	//alert(qty+" "+unitPrice);
	if(qty != "" && unitPrice != ""){
	var total = qty*unitPrice;
	document.getElementById("total").value = total;
	}
	else{
	document.getElementById("total").value = "";
	}

	}

	function loadOperator(){

		var xmlHttp = checkajax();
		xmlHttp.onreadystatechange=function() {
			if(xmlHttp.readyState!=4)
				document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

			if(xmlHttp.readyState==4) {
				document.getElementById("error").innerHTML = "&nbsp;";
				document.getElementById("divop").innerHTML = xmlHttp.responseText;
			}
		}
 		//alert("loadOperator.php?CustomerName=<?php echo $row['Name']?>&OperatorName=<?php echo $row['Operator']?>");
		xmlHttp.open("GET","loadNewOperator.php?CustomerName=<?php echo $row['Name']?>&OperatorName=<?php echo $row['Operator']?>" ,true);
		xmlHttp.send(null);
	}

	function loadNewOperator(){

		var e = document.getElementById("CustomersName");
		var CustomerName = e.options[e.selectedIndex].value;
	
		var xmlHttp = checkajax();
		xmlHttp.onreadystatechange=function() {
			if(xmlHttp.readyState!=4)
				document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

			if(xmlHttp.readyState==4) {
				document.getElementById("error").innerHTML = "&nbsp;";
				document.getElementById("divop").innerHTML = xmlHttp.responseText;
			}
		}
 		xmlHttp.open("GET","loadNewOperator.php?CustomerName="+CustomerName ,true);
		xmlHttp.send(null);
	}
	
	function initializeData(){
		i=0;
		j=0;
		k=0;

		document.getElementById("MachineName").options[i++] = new Option("Select the Instrument", "Default");
		document.getElementById("OperatorName").options[k++] = new Option("Select the Operator", "Default");
		// Filling Instrument Box
		<?
			$sql = "SELECT InstrumentName FROM instrument order by InstrumentName";
			$result = mysql_query($sql);
			
			while($row2 = mysql_fetch_array($result, MYSQL_ASSOC))
			{
		?>

		document.getElementById("MachineName").options[i++] = new Option("<? echo $row2['InstrumentName'];?>", "<? echo $row2['InstrumentName'];?>");
		if(document.getElementById("MachineName").options[i-1].value == "<?php echo $row['Machine'] ?>"){
			document.getElementById("MachineName").options[i-1].selected = true;
		}
		<?
			}
		?>
		
		
			i=0;
		j=0;
		k=0;

		document.getElementById("CustomersName").options[i++] = new Option("Select the Customer", "Default");
 		// Filling Instrument Box
		<?
			$sql = "SELECT Name FROM Customer where Activated=1 order by Name";
			$result = mysql_query($sql);
			
			while($row2 = mysql_fetch_array($result, MYSQL_ASSOC))
			{
		?>

		document.getElementById("CustomersName").options[i++] = new Option("<? echo $row2['Name'];?>", "<? echo $row2['Name'] ;?>");
		if(document.getElementById("CustomersName").options[i-1].value == "<?php echo $row['Name'] ?>"){
 			document.getElementById("CustomersName").options[i-1].selected = true;
		}
		<?
			}
		?>
		
		// Filling Type Box

		document.getElementById("type").options[0] = new Option("USC Campus Users","On-Campus")
		document.getElementById("type").options[1] = new Option("Off Campus Academic","Off-Campus")
		document.getElementById("type").options[2] = new Option("Commerical-Industry", "Industry")
		for(i=0;i<2;i++){
			if(document.getElementById("type").options[i].value == "<?php echo $row['Type'] ?>") {
				document.getElementById("type").options[i].selected = true;
			}
		}

		// Loading Operators
		loadOperator();
		operatorObj = document.getElementById("OperatorName");

		if(<?php echo $row['WithOperator']?>== 1) {
			window.document.getElementById("myForm").woperator[0].checked = true;
			document.getElementById("CemmaStaff").style.visibility="visible";
		}
		else {
			window.document.getElementById("myForm").woperator[1].checked = true;
			document.getElementById("CemmaStaff").style.visibility="hidden";
		}
 
  			i=0;
 			document.getElementById("CemmaStaff").options[i++] = new Option("Select Cemma Staff", "Default");
			
					<?
						$sql = "SELECT Name FROM  user  where UserClass=2 and ActiveUser='active'" ;
						$result = mysql_query($sql);
									
						while($row2 = mysql_fetch_array($result, MYSQL_ASSOC))
						{
					?>
			  document.getElementById("CemmaStaff").options[i++]=new Option("<? echo $row2['Name'];?>", "<? echo $row2['Name'] ;?>");
					if(document.getElementById("CemmaStaff").options[i-1].value == "<?php echo $row['CemmaStaffMember'] ?>"){
						document.getElementById("CemmaStaff").options[i-1].selected = true;
					}
					<?
						}
					?>
	  
 
	}

		function checkOther() {
			if(document.getElementById("OperatorName").value == "Other")
				document.getElementById("otheroperator").disabled = false;
			else {
				document.getElementById("otheroperator").value = "";
				document.getElementById("otheroperator").disabled = true;

			}
		}

		function checkType() {
			/*if(document.getElementById("type").selectedIndex == 2) {
				window.document.getElementById("myForm").woperator[1].disabled = true;
				window.document.getElementById("myForm").woperator[0].checked = true;
			} else
				window.document.getElementById("myForm").woperator[1].disabled = false;*/
		}

		function checkajax() {
			var xmlHttp;
			try {
				// Firefox, Opera 8.0+, Safari
				xmlHttp = new XMLHttpRequest();
			} catch (e) {
				// Internet Explorer
				try {
					xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
					try {
						xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e) {
						alert("Your browser does not support AJAX!");
						return false;
					}
				}
			}

			return xmlHttp;
		}

		function closeWindow(){
 			 window.close();
 		}
		function changeRecord() {

			if(!confirm("Are you sure you want to continue?"))
				return;

			// Getting form Values

			var theform = document.myForm;
			var e = document.getElementById("CustomersName");
			var CustomerName = e.options[e.selectedIndex].value;

			var OperatorName = theform.OperatorName.value;
			var newOperator = 0;
			var MachineName = theform.MachineName.value;
			var date = theform.date.value;
			var qty = theform.qty.value;
			var type = theform.type.value;
			var number = theform.number.value;
			var Gdate = theform.Gdate.value;
			var invoiceno = theform.Invoiceno.value;
			var unit = theform.unit.value;
			var total = theform.total.value;

			var CemmaStaff = "NA";
			
			if( document.getElementById('woperatoryes').checked ){
				 var e2 = document.getElementById("CemmaStaff");
 				 CemmaStaff = e2.options[e2.selectedIndex].value;
 			}
 				
			var accountnumber = theform.AccountNumber.value;

			var overriddenFlag = 0;
			if(theform.overriddenFlag.checked == true)
				overriddenFlag = 1;
			var error = "";

			if(theform.woperator[0].checked)
				woperator = 1;
			else
				woperator = 0;

			if(OperatorName == "Other") {
				OperatorName = theform.otheroperator.value;
				newOperator = 1;
			}

			// Error Checking

			if(OperatorName == "Default") {
				error = "Please select the Operator";
				document.getElementById("error").innerHTML = error
				document.getElementById("error").style.display = "block";
				return
			} else if(OperatorName == "") {
				error = "Please specify the Operator";
				document.getElementById("error").innerHTML = error
				document.getElementById("error").style.display = "block";
				return
			} else if(!checkDigits(qty)) {
				error = "Invalid Quantity";
				document.getElementById("error").innerHTML = error
				document.getElementById("error").style.display = "block";
				return
			} else {
				document.getElementById("error").style.display = "none";
			}

			//Calling AJAX
			var xmlHttp = checkajax();
	 
			xmlHttp.onreadystatechange = function() {
				if(xmlHttp.readyState != 4)
					document.getElementById("error").innerHTML = "<img src = images/busy.gif>";
				if(xmlHttp.readyState == 4) {
					document.getElementById("error").innerHTML = "&nbsp;";
					document.getElementById("error").innerHTML = "&nbsp;";

					// Everything is working fine
					document.getElementById("alert").innerHTML = xmlHttp.responseText;
					document.getElementById("alert").style.display = "";
				}
			}
		 
			xmlHttp.open("GET", "editrecord2.php?CustomerName=" + CustomerName + "&OperatorName=" + OperatorName + "&MachineName=" + MachineName + "&newOperator=" + newOperator + "&Date=" + date + "&qty=" + qty + "&type=" + type + "&woperator=" + woperator + "&Gdate=" + Gdate + "&overriddenFlag=" + overriddenFlag + "&unit=" + unit + "&total=" + total + "&number=" + number + "&invoiceno=" + invoiceno + "&accountnumber=" + accountnumber + "&CemmaStaff=" + CemmaStaff + "&submit=submit", true);
			xmlHttp.send(null);
		}

		function checkDigits(string) {
			digitRegex = /^\d+(\.\d+)?$/;
			if(!string.match(digitRegex)) {
				return false;
			}
			return true;
		}
</script>
<script type="text/javascript">
	initializeData();

</script>
<?
include ('tpl/footer.php');
?>
