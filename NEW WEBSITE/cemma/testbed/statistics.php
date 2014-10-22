<?php
include_once ('constants.php');
include_once (DOCUMENT_ROOT."includes/checklogin.php");
include_once (DOCUMENT_ROOT."includes/checkadmin.php");
include (DOCUMENT_ROOT.'tpl/header.php');
include_once (DOCUMENT_ROOT."includes/action.php");

define("L_LANG", "el_GR");
$mydate = isset($_POST["date1"]) ? $_POST["date1"] : "";
?>
<link href="css/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="scripts/calendar.js"></script>
<script type="text/javascript" src="scripts/calendar-en.js"></script>
<script type = "text/javascript">
  
var calendar = null;
/*array = new Array(2);
array[0] = 0;
array[1] = 0;
array[2]=2;*/

	function validateSearchCustomers() {
		if (document.getElementById("form_cust").elements["cust_department[]"].selectedIndex == -1) {
		  	alert("Please select an option from departments.");
			return false;
		}
		if (document.getElementById("form_cust").elements["school[]"].selectedIndex == -1) {
		  	alert("Please select an option from schools.");
			return false;
		}
		if (document.getElementById("form_cust").elements["custType[]"].selectedIndex == -1) {
		  	alert("Please select an option from customer types.");
			return false;
		}
		return true;
	}
	function validateSearchRecords(){
		if (document.getElementById("form1").elements["MachineName[]"].selectedIndex == -1) {
		  	alert("Please select an Instrument.");
			return false;
		}
  		if (document.getElementById("fromDate").value == '') {
		  	alert("Please select an From Date.");
			return false;
		}
		if (document.getElementById("toDate").value == '') {
		  	alert("Please select To Date.");
			return false;
		}
		return true;	
	}
	function validateSearchUsers() {
		if (document.getElementById("form_users").elements["department[]"].selectedIndex == -1) {
		  	alert("Please select an option from departments.");
			return false;
		}
		if (document.getElementById("form_users").elements["adviser[]"].selectedIndex == -1) {
		  	alert("Please select an option from adviser.");
			return false;
		}
		if (document.getElementById("form_users").elements["position[]"].selectedIndex == -1) {
		  	alert("Please select an option from position.");
			return false;
		}
		return true;
	}

	function check_button(id) {
			if(id==3) {
				initUserTab();
				initDepartments("users");
				initAdvisers();
				initPositions();
			} else if(id==4) {
				initSchools();
				initDepartments("customers");
				initCustType();
			}
			<? if($_SESSION['ClassLevel'] ==1  ||  $_SESSION['ClassLevel'] ==2 ){ ?>
			for( i = 0; i < 5; i++) {
				if(i != id) {
					document.getElementById("showContent" + i).style.display = "none";
					<!-- document.getElementById("showImg" + i).src = "images/plus.gif";	 -->
					
					document.getElementById("label" + i).style.display = "none";
 //					array[i] = 0;
				} else if(i==id){
					<!-- 	document.getElementById("showImg" + id).src = "images/minus.gif";	-->
						document.getElementById("showContent" + id).style.display = "";

 						document.getElementById("label" + i).style.display = "";
 				}
			}
			<? } else if($_SESSION['ClassLevel'] != 4 ){ ?>
				for( i = 0; i < 5; i++) {
					if(i!=1) {
						if(i != id) {
							document.getElementById("showContent" + i).style.display = "none";
							document.getElementById("showImg" + i).src = "images/plus.gif";
		//					array[i] = 0;
						} else if(i==id){
								document.getElementById("showImg" + id).src = "images/minus.gif";
								document.getElementById("showContent" + id).style.display = "";
						}
					}
				}
			<? }?>
//			array[id] = 1;

		/*} else {
			document.getElementById("showContent" + id).style.display = "none";
			document.getElementById("showImg" + id).src = "images/plus.gif";
			array[id] = 0;
		}*/
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
</script>

<script type="text/javascript" src="scripts/date.js"></script>


<script type = "text/javascript">
	function initSchools() {
		document.getElementById("school").options[0] = new Option("All Schools", "*");
		var count=0;
		<?
		$sql = "SELECT SchoolNo, SchoolName FROM Schools ORDER BY SchoolName";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		?>
			count++;
			document.getElementById("school").options[count] = new Option("<? echo $row['SchoolName'];?>", "<? echo $row['SchoolNo'];?>");	
		<?
		}
		?>
	}
	function initCustType(){
		document.getElementById("custType").options[0] = new Option("All Types", "*");
		document.getElementById("custType").options[1] = new Option("USC Campus Users", "On-Campus");
		document.getElementById("custType").options[2] = new Option("Off Campus Academic", "Off-Campus");
		document.getElementById("custType").options[3] = new Option("Industry", "Industry");
	}
	
	function initDepartments(queryType) {
		if(queryType == "users") {
			document.getElementById("department").options[0] = new Option("All Departments", "*");
		}
		else
			document.getElementById("cust_department").options[0] = new Option("All Departments", "*");
		var count=0;
		<?
		$sql = "SELECT DISTINCT dept FROM user WHERE dept!='' ORDER BY dept";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		?>
			count++;
			if(queryType == "users")
				document.getElementById("department").options[count] = new Option("<? echo $row['dept'];?>", "<? echo $row['dept'];?>");
			else
				document.getElementById("cust_department").options[count] = new Option("<? echo $row['dept'];?>", "<? echo $row['dept'];?>");
			<?
		}
		?>
	}
	
	function initAdvisers() {
		document.getElementById("adviser").options[0] = new Option("All Advisers", "*");
		var count=0;
		<?
		$sql = "SELECT DISTINCT advisor FROM user WHERE advisor!='' ORDER BY advisor";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		?>
			count++;
			document.getElementById("adviser").options[count] = new Option("<? echo $row['advisor'];?>", "<? echo $row['advisor'];?>");<?
		}
		?>
	}
	
	function initPositions() {
		document.getElementById("position").options[0] = new Option("All Positions", "*");
		document.getElementById("position").options[1] = new Option("Undergraduate Student", "US");
		document.getElementById("position").options[2] = new Option("Graduate Student", "GS");
		document.getElementById("position").options[3] = new Option("Post Doctor", "PD");
		document.getElementById("position").options[4] = new Option("Principal Investigator", "PI");
	}
	
	function initUserTab(){
			document.getElementById("ApprovedInstrument").options[0] = new Option("All Instruments", "*");
	//document.getElementById("MachineName").options[0].disabled = 'disabled';

		var count = 0;<?php
		$sql = "SELECT InstrumentNo, InstrumentName FROM instrument order by InstrumentName";
		$result = mysql_query($sql);
	
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
		?>
		count++;
		document.getElementById("ApprovedInstrument").options[count] = new Option("<? echo $row['InstrumentName'];?>", "<? echo $row['InstrumentNo'];?>");<?
		}
		?>
		
	}

	function initLogsTab(){
			document.getElementById("Instrument").options[0] = new Option("All Instruments", "-1");
	//document.getElementById("MachineName").options[0].disabled = 'disabled';

		var count = 0;<?php
		$sql = "SELECT InstrumentName FROM instrument order by InstrumentName";
		$result = mysql_query($sql);
	
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
		?>
		count++;
		document.getElementById("Instrument").options[count] = new Option("<? echo $row['InstrumentName'];?>", "<? echo $row['InstrumentName'];?>");<?
	}
		?>
		
	}
		function initRecordsTab(){
	document.getElementById("MachineName").options[0] = new Option("All Instruments", "-1");
	//document.getElementById("MachineName").options[0].disabled = 'disabled';

	var count = 0;<?php
	$sql = "SELECT InstrumentName FROM instrument order by InstrumentName";
	$result = mysql_query($sql);

	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
	?>
	count++;
	document.getElementById("MachineName").options[count] = new Option("<? echo $row['InstrumentName'];?>", "<? echo $row['InstrumentName'];?>");<?
}
	?>

	/*document.getElementById("OperatorName").options[0] = new Option("All Operators","-1");
	//document.getElementById("OperatorName").options[0].disabled = 'disabled';

	document.getElementById("type").options[0] = new Option("All Types","-1")
	document.getElementById("type").options[1] = new Option("USC Campus Users","On-Campus")
	document.getElementById("type").options[2] = new Option("Off Campus Academic","Off-Campus")
	document.getElementById("type").options[3] = new Option("Commerical-Industry", "Commerical")
*/
	}

	function initInvoicesTab(){

	}

		function loadOperator() {

			var theform = document.form1;
			var CustomerName = document.getElementById("CustomerName_Record").value;
 			
			var result="";
			var select = document.getElementById("CustomerName_Record");
 			
			document.getElementById("customerindex").value = select.selectedIndex;
			 	 
 			  var options = select && select.options;
			  var opt;
			
			  for (var i=0, iLen=options.length; i<iLen; i++) {
				opt = options[i];
			
				if (opt.selected) {
					result+=opt.value+";";
				}
			  }
			  
			var xmlHttp = checkajax();

			xmlHttp.onreadystatechange = function() {

				if(xmlHttp.readyState == 4) {
					//document.getElementById("error1").innerHTML = "&nbsp;";
					document.getElementById("divop").innerHTML = xmlHttp.responseText;
					document.getElementById("OperatorName").style.width = "50mm";
				}

			}

			xmlHttp.open("GET", "loadOperator.php?CustomerName=" + result, true);
			xmlHttp.send(null);

		}

		function checkOther() {

		}
		
		 
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
							<tr valign="top">
								<td width="100%"><div align="center" class="err" id="error" style="display:none"></div><div align="center" class="alert" style="font-size:13;display:none" id="alert"></div></td>
							</tr>
						</table>
						<script type = "text/javascript">
							
						</script>
						<table width="100%" border="0" cellpadding="5" cellspacing="0">
							<tr>
								<td class="t-top">
								<div class="title2">
									Statistics
								</div></td>
							</tr>
							<tr>
								<td class="t-mid">
								<br />
								<br />
                                <div style="padding-left:30px;font-weight:bold">
								<!--	<img id = "showImg0" src = "images/plus.gif" style="vertical-align:middle;cursor:pointer;padding:0px 15px 0px 5px" onClick = "check_button(0)" > -->
									<label id= "label0" >Find Records</label>
								</div>
								<div id = "showContent0" align = "center" style = "display:none; padding:10px 5px 10px 0">
									<br>
									<form id="form1" name ="form1" action = "searchRecords.php?id=<? echo $_GET['id'] ?>" method = "POST" onsubmit="return validateSearchRecords()">
										<table border = "0" width="90%">
											<tr class = "Trow">
												<td width="20%">Records Between:</td>
												<td width="100%">
                                                <table>
                                                <tr>
                                                	<td>
                                                	<input type="text" name="fromDate" id="fromDate" readonly="readonly" size = "10" value = ""/>
											<img src = "images/calendar.gif" height="20" width = "20" id="date_calendar" value="calendar" onClick="showCalendar('fromDate', 'y/mm/dd')" style="cursor:pointer" />
                                                     </td>
                                                     <td>
                                                        - &nbsp
                                                     </td>
                                                     <td>
                                                        <input type="text" name="toDate" id="toDate" readonly="readonly" size = "10" value = ""/>
											<img src = "images/calendar.gif" height="20" width = "20" id="date_calendar1" value="calendar" onClick="showCalendar('toDate', 'y/mm/dd')" style="cursor:pointer" />
                                                    </td>
                                                    </tr>
                                                    </table>
                                                </td>
											</tr>
											<tr class = "Trow">
												<td>Instrument Name</td>
												<td><select multiple="multiple" id= "MachineName" name="MachineName[]" style="font-weight:normal; width:50mm"></select></td>
											</tr>
											<tr class = "Trow">
												<td>Customer</td>
												<td width="250">
												<div>
													<select id= "CustomerName_Record" name="CustomerName[]" style="font-weight:normal; width:50mm" onChange = "loadOperator()";></select>
                                                    <input type="hidden" id="customerindex" name="customerindex" />
												</div>
												<div>
													<input type="radio" name="customer_type" id="curr_customer_record" checked=true onclick="getCustomerList_Record('curr')">
													Current
													<input type="radio" name="customer_type" id="arch_customer_record" onclick="getCustomerList_Record('arch')">
													Archived
												</div></td>
											</tr>
											
											<tr class = "Trow">
												<td>User</td>
												<td>
												<div id = "divop">
													<select multiple id="OperatorName" name="OperatorName[]" style="font-weight:normal; width:50mm">
                                                      <option selected="" value="-1">All Operators</option>
                                                    </select>
												</div></td>
											</tr>
											<tr class = "Trow">
												<td>Quantity</td>
												<td>
												<input type="text" size = "4" name = "minQty" id = "minQty">
												to
												<input type="text" size = "4" name = "maxQty" id = "maxQty">
												</td>
											</tr>
											<tr class = "Trow">
												<td>Total</td>
												<td>
												<input type="text" size = "4" name = "minTotal" id = "minTotal">
												to
												<input type="text" size = "4" name = "maxTotal" id = "maxTotal">
												</td>
											</tr>
											
											<tr class = "Trow">
												<td>Type:</td>
												<td><div>
												<input id="customers_type1" type="checkbox" name="customers_type1" value="On-Campus" checked="checked">
												USC Campus Users
												
												<input id="customers_type2" type="checkbox" name="customers_type2" value="Off-Campus" checked="checked">
												Off Campus Users
												
                                                <input id="customers_type3" type="checkbox" name="customers_type3" value="Industry" checked="checked">
												Industry Users
												<br>
											</div></td>
											</tr>
											<tr class = "Trow">
												<td>Cemma Operator:</td>
												<td>
												<input type = "radio" name = "woperator" id= "woperator" value = "-1" checked = "checked">
												Don't Care
												<input type = "radio" name = "woperator" id= "woperator" value = "1">
												Yes
												<input type = "radio" name = "woperator" id= "woperator" value = "0">
												No </td>
											</tr>
											<tr class = "Trow">
												<td>Invoice Generated?</td>
												<td>
												<input type = "radio" name = "generated" id= "generated" value = "-1" checked = "checked">
												Don't Care
												<input type = "radio" name = "generated" id= "generated" value = "1" >
												Yes
												<input type = "radio" name = "generated" id= "generated" value = "0" >
												No </td>
											<tr class = "Trow">
												<td colspan = "2">&nbsp;</td>
											</tr>
											<tr>
												<td colspan = "2" align = "center">
												<input type="submit" name="submitButton" value="Find Records" style="cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;border:0" />
												</td>
											</tr>
									</form>
						</table>
						<script type = "text/javascript">
							initRecordsTab();

						</script> </div>
						<br>
                        <? if( $_SESSION['ClassLevel'] ==1 || $_SESSION['ClassLevel'] ==2 ){ ?>
						<div style="padding-left:30px;font-weight:bold">
							<!-- <img id ="showImg1" src="images/plus.gif" style="vertical-align:middle;cursor:pointer;padding:0px 15px 0px 5px" onClick ="check_button(1)" > -->
							<label id= "label1" >Find Invoices</label>
						</div>
						<br>
						<div id = "showContent1" align = "center" style = "display:none; padding:10px 5px 10px 0">
							<form id="form2" name ="form2" action = "searchInvoices.php?pageId=1&id=<? echo $_GET['id'] ?>" method = "post">
								<table border = "0" width="90%">
									<tr class = "Trow">
										<td>Invoice No: </td>
										<td width="80%">
										<input type="text" size = "2" name = "invoiceYear" id = "invoiceYear">
										/
										<input type="text" size = "2" name = "invoiceNo" id = "invoiceNo">
										</td>
									</tr>
									<tr class = "Trow">
										<td>Invoices Between: </td>
										<td>
                                        <table>
                                          <tr>
                                          	<td>
                                        	<input type="text" name="fromDateInv" id="fromDateInv" readonly="readonly" size = "10" value = ""/>
											<img src = "images/calendar.gif" height="20" width = "20" id="date_calendar_inv" value="calendar" onClick="showCalendar('fromDateInv', 'y/mm/dd')" style="cursor:pointer" />
                                             </td>
                                             <td>
                                                - &nbsp;
                                             </td>
                                             <td>
                                                <input type="text" name="toDateInv" id="toDateInv" readonly="readonly" size = "10" value = ""/>
											<img src = "images/calendar.gif" height="20" width = "20" id="date_calendar_inv1" value="calendar" onClick="showCalendar('toDateInv', 'y/mm/dd')" style="cursor:pointer" />
                                            </td>
                                            </tr>
                                            </table>
                                        </td>
									</tr>
									
									<!--
									<tr class = "Trow">
										<td>Search Criteria: </td>
										<td>
											<input type="radio" name="search_criteria" checked=true onclick="">
											Customer
											<input type="radio" name="search_criteria" onclick="">
											School
										</td>
									</tr>
									-->
									
									<tr class = "Trow">
										<td>
											<input type="radio" name="search_criteria" id="SearchCriteria_Customer" checked=true onclick="changeCriteria();">
											Customer:
										</td>
										<td width="250">
										<div id="Customer_Individual">
											<div>
												<select id="CustomerName_Invoice" name="CustomerNameI" onchange="setCustomerTypeField_I();" style="font-weight:normal; width:50mm" onChange = "loadOperator()";></select>
											</div>
											<div>
												<input type="radio" name="customer_type" id="curr_customer_invoice" checked=true onclick="getCustomerList_Invoice('curr')">
												Current
												<input type="radio" name="customer_type" id="arch_customer_invoice" onclick="getCustomerList_Invoice('arch')">
												Archived
											</div>
										</div></td>
									</tr>
									
									<tr class = "Trow">
										<td>
											<input type="radio" name="search_criteria" id="SearchCriteria_School" onclick="changeCriteria();">
											School:
										</td>
										<td>
											<select id="SchoolName_Invoice"  name="SchoolNameI" onchange="getCustomerList_Record_School(this)" style="font-weight:normal; width:50mm">
												<?
													$sql_fs = "SELECT SchoolNo, SchoolName FROM Schools";
													$result_fs=mysql_query($sql_fs) or die( "An error has ocured in query: " .mysql_error (). ":" .mysql_errno ()); 
													while($row_fs = mysql_fetch_array($result_fs))
													{
														echo "<option value='".$row_fs['SchoolNo']."'>";
														echo $row_fs['SchoolName']."</option>";
													}
	
												?>
											</select>
										</td>
									</tr>
									
									<tr class = "Trow">
										<td>Type</td>
										<td width="250">
										<div id="Customer_Group" style="visibility:visible">
											<div>
												<input id="customers_type1" type="checkbox" name="customers_type1" value="On-Campus" checked="checked">
												USC Campus Users
												<br>
												<input id="customers_type2" type="checkbox" name="customers_type2" value="Off-Campus" checked="checked">
												Off Campus Users
												<br>
												<input id="customers_type3"type="checkbox" name="customers_type3" value="Industry" checked="checked">
												Industry Users
												<br>
											</div>
										</div></td>
									</tr>
									<tr class = "Trow">
										<td>Total</td>
										<td>
										<input type="text" size = "4" name = "minTotalI" id = "minTotalI">
										to
										<input type="text" size = "4" name = "maxTotalI" id = "maxTotalI">
										</td>
									</tr>
									<tr class = "Trow">
										<td>Status</td>
										<td>
										<input type = "radio" name = "statusI" id= "statusI" value = "-1" checked = "checked">
										Don't Care
										<input type = "radio" name = "statusI" id= "statusI" value = "Paid" >
										Paid
										<input type = "radio" name = "statusI" id= "statusI" value = "Unpaid" >
										Unpaid </td>
									<tr>
									<tr class = "Trow">
										<td colspan = "2">&nbsp;</td>
									</tr>
									<tr>
										<td colspan = "2" align = "center">
										<input type="submit" name="submitButton" value="Find Invoices" style="cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;border:0" />
										</td>
									</tr>
								</table>
								<input type="hidden" id="searchCriteria" name="searchCriteria" value="customer"></input>
								
							</form>
						</div>
                        <? } ?>
                        <div style="padding-left:30px;font-weight:bold">
                           <!-- <img id = "showImg2" src = "images/plus.gif" style="vertical-align:middle;cursor:pointer;padding:0px 15px 0px 5px" onClick = "check_button(2)" > -->
                            <label  id= "label2" >Instrument Logs</label>
                        </div>
                        <div id = "showContent2" align = "center" style = "display:none; padding:10px 5px 10px 0">
                        <br>
                        <form id="form2" name ="form1" action = "instrument_logs.php?id=<? echo $_GET['id'] ?>" method = "POST">
                            <table border = "0" width="90%">
                            	
                                <tr class = "Trow">
                                    <td>Logs Between:</td>
                                    <td>
                                    <input type="text" name="fromDateIns" id="fromDateIns" readonly="readonly" size = "10" value = ""/>
											<img src = "images/calendar.gif" height="20" width = "20" id="date_calendar_ins" value="calendar" onClick="showCalendar('fromDateIns', 'y/mm/dd')" style="cursor:pointer" />
                                     </td>
                                     <td>
                                        And &nbsp;&nbsp;
                                     </td>
                                     <td>
                                        <input type="text" name="toDateIns" id="toDateIns" readonly="readonly" size = "10" value = ""/>
											<img src = "images/calendar.gif" height="20" width = "20" id="date_calendar_ins1" value="calendar" onClick="showCalendar('toDateIns', 'y/mm/dd')" style="cursor:pointer" />
                                    </td>
                                </tr>
                                <tr class = "Trow">
                                    <td>Instrument Name</td>
                                    <td><select multiple id= "Instrument" name="Instrument[]" style="font-weight:normal; width:50mm"></select></td>
                                </tr>
                                <tr>
                                    <td colspan = "2" align = "center">
                                    <input type="submit" name="submitButton" value="Find Logs" style="cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;border:0" />
                                    </td>
                                </tr>
                             </table>
                             <script type="text/javascript">
							 	initLogsTab();
							 </script>
                         </form>
                        </div>
                        <br/>
                        <div style="padding-left:30px;font-weight:bold">
                          <!--  <img id = "showImg3" src = "images/plus.gif" style="vertical-align:middle;cursor:pointer;padding:0px 15px 0px 5px" onClick = "check_button(3)" > -->
                            <label id= "label3"  >Search Users</label>
                        </div>
                        <div id = "showContent3" align = "center" style = "display:none; padding:10px 5px 10px 0">
                        <br>
                        <form id="form_users" name ="form_users" action = "search_users.php?id=<? echo $_GET['id'] ?>" method = "POST" onsubmit="return validateSearchUsers()">
                            <table border = "0" width="90%">
                            	
                                <tr class = "Trow">
                                    <td>Department:</td>
                                    <td>
                                    	<select multiple id="department" name="department[]" style="font-weight:normal; width:50mm"></select>
                                    </td>
                                </tr>
                                
                                <tr class = "Trow">
                                    <td>Adviser:</td>
                                    <td>
                                    	<select multiple id="adviser" name="adviser[]" style="font-weight:normal; width:50mm"></select>
                                    </td>
                                </tr>
                                
                                <tr class = "Trow">
                                    <td>Position:</td>
                                    <td>
                                    	<select multiple id="position" name="position[]" style="font-weight:normal; width:50mm"></select>
                                    </td>
                                </tr>
                                
                                <tr class = "Trow">
                                    <td>Approved Instrument</td>
                                    <td><select id= "ApprovedInstrument" name="ApprovedInstrument" style="font-weight:normal; width:50mm"></select></td>
                                </tr>
                                <tr>
                                    <td colspan = "2" align = "center">
                                    <input type="submit" name="submitButton" value="Find Users" style="cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;border:0" />
                                    </td>
                                </tr>
                             </table>
                         </form>
                        </div>
                        
                        <br/>
                        <div style="padding-left:30px;font-weight:bold">
                         <!--   <img id = "showImg4" src = "images/plus.gif" style="vertical-align:middle;cursor:pointer;padding:0px 15px 0px 5px" onClick = "check_button(4)" > -->
                            <label id= "label4" >Search Customers</label>
                        </div>
                        <div id = "showContent4" align = "center" style = "display:none; padding:10px 5px 10px 0">
                        <br>
                        <form id="form_cust" name="form_cust" action = "search_customers.php?id=<? echo $_GET['id'] ?>" method = "POST" onsubmit="return validateSearchCustomers()">
                            <table border = "0" width="90%">
                            	
                                <tr class = "Trow">
                                    <td>Department:</td>
                                    <td>
                                    	<select multiple id="cust_department" name="cust_department[]" style="font-weight:normal; width:100mm"></select>
                                    </td>
                                </tr>
                                
                                <tr class = "Trow">
                                    <td>School:</td>
                                    <td>
                                    	<select multiple id="school" name="school[]" style="font-weight:normal; width:100mm"></select>
                                    </td>
                                </tr>
                                
                                <tr class = "Trow">
                                    <td>Customer Type:</td>
                                    <td>
                                    	<select multiple id="custType" name="custType[]" style="font-weight:normal; width:100mm"></select>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td colspan = "2" align = "center">
                                    <input type="submit" name="submitButton" value="Find Customers" style="cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;border:0" />
                                    </td>
                                </tr>
                             </table>
                         </form>
                        </div>
                        
                        </td>
					</tr>
					<tr>
						<td class="t-bot2-800">&nbsp;</td>
					</tr>
				</table></td>
			</tr>
		</table><div class="clr"></div></td>
	</tr>
</table>
</td>

</tr>

</table>
</td>
</tr>
</table>
<script type="text/javascript">

	function changeCriteria()
	{
		if(document.getElementById("SearchCriteria_Customer").checked)
		{
			document.getElementById("CustomerName_Invoice").disabled=false;
			document.getElementById("SchoolName_Invoice").disabled=true;
			document.getElementById("searchCriteria").value="customer";
		}
		else if(document.getElementById("SearchCriteria_School").checked)
		{
			document.getElementById("CustomerName_Invoice").disabled=true;
			document.getElementById("SchoolName_Invoice").disabled=false;
			document.getElementById("searchCriteria").value="school";
		}
	}


	function setCustomerTypeField_I() {
		if(document.getElementById("CustomerName_Invoice").value == -1) {
			document.getElementById("customers_type1").disabled = false;
			document.getElementById("customers_type2").disabled = false;
			document.getElementById("customers_type3").disabled = false;
		} else {
			document.getElementById("customers_type1").disabled = true;
			document.getElementById("customers_type2").disabled = true;
			document.getElementById("customers_type3").disabled = true;
		}
	}

	function setCustomerType(ctype) {
		//alert(ctype);
		if(ctype == 'individual') {
			//alert(document.getElementById("Customer_Individual").style.visibility);
			//document.getElementById("Customer_Individual").style.visibility="visible";
			//document.getElementById("Customer_Group").style.visibility="hidden";
			document.getElementById("customers_type1").disabled = true;
			document.getElementById("customers_type2").disabled = true;
			document.getElementById("customers_type3").disabled = true;

			document.getElementById("CustomerName_Invoice").disabled = false;
			document.getElementById("curr_customer_invoice").disabled = false;
			document.getElementById("arch_customer_invoice").disabled = false;

		} else if( ctype = 'group') {
			//alert(document.getElementById("Customer_Group").style.visibility);
			//document.getElementById("Customer_Individual").style.visibility="hidden";
			//document.getElementById("Customer_Group").style.visibility="visible";
			document.getElementById("customers_type1").disabled = false;
			document.getElementById("customers_type2").disabled = false;
			document.getElementById("customers_type3").disabled = false;

			document.getElementById("CustomerName_Invoice").disabled = true;
			document.getElementById("curr_customer_invoice").disabled = true;
			document.getElementById("arch_customer_invoice").disabled = true;

		}
	}

	function getCustomerList_Record(type) {
		var xmlHttp = checkajax();
		xmlHttp.onreadystatechange = function() {
			if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
				document.getElementById("CustomerName_Record").innerHTML = xmlHttp.responseText;
			}
		}
		xmlHttp.open("GET", "php/getCustomerList.php?type=" + type + "&mode_all=on", true);
		xmlHttp.send(null);
	}
	
	function getCustomerList_Record_School(school) {
		var	type = 'curr';
		if(document.getElementById('curr_customer_record').checked)
		{
			type = 'curr';
		}
		else
		{
			type = 'arch';
		}
		if(school.value=='1')
		{
			getCustomerList_Record(type);
		}
		else
		{
			var xmlHttp = checkajax();
			xmlHttp.onreadystatechange = function() {
				if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
					document.getElementById("CustomerName_Record").innerHTML = xmlHttp.responseText;
				}
			}
			xmlHttp.open("GET", "php/getCustomerList.php?type=" + type + "&school=" + school.value + "&mode_all=on", true);
			xmlHttp.send(null);
		}
	}

	function getCustomerList_Invoice(type) {
		var xmlHttp = checkajax();
		xmlHttp.onreadystatechange = function() {
			if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
				document.getElementById("CustomerName_Invoice").innerHTML = xmlHttp.responseText;
			}
		}
		xmlHttp.open("GET", "php/getCustomerList.php?type=" + type + "&mode_all=on", true);
		xmlHttp.send(null);
	}
	getCustomerList_Record('curr');
			
	changeCriteria();
	getCustomerList_Record('curr');
	getCustomerList_Invoice('curr');

	 
	 var setcustomerindex = '<?php echo $_GET['customerindex'] ;?>';
 
if(setcustomerindex!=''){
  	 // document.getElementById("CustomerName_Record").selectedIndex=setcustomerindex;
	// loadoperator();
 }


	<?	$open=$_GET['open'];
if($open=='record') {
echo "check_button(0);\n";
$fromYear=$_GET['fromyear'];
$toYear=$_GET['toyear'];
$machineName=$_GET['MachineName'];
$customerName=$_GET['CustomerName'];
$operatorName=$_GET['OperatorName'];
$minQty=$_GET['minQty'];
$maxQty=$_GET['maxQty'];
$minTotal=$_GET['minTotal'];
$maxTotal=$_GET['maxTotal'];
$woperator=(int)$_GET['woperator'];
$generated=(int)$_GET['generated'];
$type=$_GET['type'];


#echo 'alert(document.getElementById("frommonth")[0].selected);';
echo 'document.getElementById("fromDate").value = "'.$fromYear.'";';
echo 'document.getElementById("toDate").value = "'.$toYear.'";';

if($minQty!='') {	echo 'document.getElementById("minQty").value='.$minQty.';';
}
if($maxQty!='') {	echo 'document.getElementById("maxQty").value='.$maxQty.';';
}
if($minTotal!='') {	echo 'document.getElementById("minTotal").value='.$minTotal.';';
}
if($maxTotal!='') {	echo 'document.getElementById("maxTotal").value='.$maxTotal.';';
}
#if($customerName!='')	{	echo 'document.getElementById("CustomerName_Record").value='.$maxTotal.';';	}
#echo "alert('".$customerName."');";
if($woperator==0)
	echo 'document.getElementsByName("woperator")[1].checked=true;';
else if($woperator==1)
	echo 'document.getElementsByName("woperator")[2].checked=true;';
else
	echo 'document.getElementsByName("woperator")[0].checked=true;';
if($generated==1)
	echo 'document.getElementsByName("generated")[1].checked=true;';
else if($generated==0)
	echo 'document.getElementsByName("generated")[2].checked=true;';
else
	echo 'document.getElementsByName("generated")[0].checked=true;';
#echo 'document.getElementById("generated")['.$generated.'].checked=true;';
} else if($open=='invoice') {
echo "check_button(1);";
}
	?></script>
<?
include ('tpl/footer.php');
 ?> 
 
 <script type="text/javascript">
 	 var subMenuId =  '<?php echo $_GET['id'] ;?>';
   	 check_button(subMenuId);

 </script>