<?
include_once ('constants.php');
include_once (DOCUMENT_ROOT . "includes/checklogin.php");
include_once (DOCUMENT_ROOT . "includes/checkadmin.php");
include (DOCUMENT_ROOT . 'tpl/header.php');

include_once ("includes/action.php");
include ("editRecordHelper.php");
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
	function makeChanges(invoiceno, Gdate) {

		var theform = document.form3;
		var PO = theform.PO.value;
		var status = theform.status.value;
		var original_PO = theform.originalPO.value;
		var original_status = theform.originalStatus.value;
		var name = document.myform.CustomerName.value;
		if(original_PO == PO)
			var changedPO = false;
		else
			var changedPO = true;
		if(original_status == status)
			var changedStatus = false;
		else
			var changedStatus = true;

		var xmlHttp = checkajax();

		xmlHttp.onreadystatechange = function() {

			if(xmlHttp.readyState != 4)
				document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

			if(xmlHttp.readyState == 4) {

				document.getElementById("error").innerHTML = "&nbsp;";
				document.getElementById("div1").innerHTML = xmlHttp.responseText;

			}
		}

		xmlHttp.open("GET", "viewinvoices.php?name=" + name + "&Gdate=" + Gdate + "&invoiceno=" + invoiceno + "&PO=" + PO + "&status=" + status + "&changedStatus=" + changedStatus + "&changedPO=" + changedPO + "&change=change", true);
		xmlHttp.send(null);

	}

	function showInvoices(pagenum, sorttable, ordertable) {

		var theform = document.myform;
		var name = theform.CustomerName.value;
		var tomonth = theform.tomonth.value;
		var frommonth = theform.frommonth.value;
		var toyear = theform.toyear.value;
		var fromyear = theform.fromyear.value;

		if(name == "Select the Customer")
			return;

		var xmlHttp = checkajax();

		xmlHttp.onreadystatechange = function() {

			if(xmlHttp.readyState != 4)
				document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

			if(xmlHttp.readyState == 4) {

				document.getElementById("error").innerHTML = "&nbsp;";
				document.getElementById("div1").innerHTML = xmlHttp.responseText;

			}
		}

		xmlHttp.open("GET", "viewinvoices.php?name=" + name + "&tomonth=" + tomonth + "&frommonth=" + frommonth + "&toyear=" + toyear + "&fromyear=" + fromyear + "&pagenum=" + pagenum + "&sorttable=" + sorttable + "&ordertable=" + ordertable + "&submit=submit", true);

		xmlHttp.send(null);

	}

	function showRecords(pagenum, sorttable, ordertable) {

		var theform = document.myform;
		var name = theform.CustomerName.value;
		var tomonth = theform.tomonth.value;
		var frommonth = theform.frommonth.value;
		var toyear = theform.toyear.value;
		var fromyear = theform.fromyear.value;

		if(name == "Select the Customer")
			return;

		var xmlHttp = checkajax();

		xmlHttp.onreadystatechange = function() {

			if(xmlHttp.readyState != 4)
				document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

			if(xmlHttp.readyState == 4) {
				document.getElementById("error").innerHTML = "&nbsp;";
				document.getElementById("div1").innerHTML = xmlHttp.responseText;
			}
		}

		xmlHttp.open("GET", "viewrecords.php?name=" + name + "&tomonth=" + tomonth + "&frommonth=" + frommonth + "&toyear=" + toyear + "&fromyear=" + fromyear + "&pagenum=" + pagenum + "&sorttable=" + sorttable + "&ordertable=" + ordertable + "&record=view", true);
		xmlHttp.send(null);
	}

	function removeRecord(number) {
		var input_box = confirm("Removing this record may change the corresponding Invoice. Are you sure you want to continue? ");
		if(input_box == true) {
			var xmlHttp = checkajax();
			xmlHttp.onreadystatechange = function() {
				if(xmlHttp.readyState != 4)
					document.getElementById("error").innerHTML = "<img src = images/busy.gif>";
				if(xmlHttp.readyState == 4) {
					showRecords(1, 1, 1);
				}
			}

			xmlHttp.open("GET", "removeRecord.php?number=" + number + "&remove=remove", true);
			xmlHttp.send(null);
		}

	}

	function removeInvoice(number) {

		var input_box = confirm("Are you sure you want to remove this Invoice?? ");

		if(input_box == true) {

			var xmlHttp = checkajax();

			xmlHttp.onreadystatechange = function() {

				if(xmlHttp.readyState != 4)
					document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

				if(xmlHttp.readyState == 4) {
					alert(xmlHttp.responseText);
					showInvoices(1, 1, 1);
				}
			}

			xmlHttp.open("GET", "removeInvoice.php?number=" + number + "&remove=remove", true);
			xmlHttp.send(null);
		}

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

	function changeStatus(invoiceno, Gdate, name) {

		var xmlHttp = checkajax();
		xmlHttp.onreadystatechange = function() {
			if(xmlHttp.readyState != 4)
				document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

			if(xmlHttp.readyState == 4) {
				document.getElementById("error").innerHTML = "&nbsp;";
				document.getElementById("div3").innerHTML = xmlHttp.responseText;
			}
		}
		xmlHttp.open("GET", "change_status.php?Gdate=" + Gdate + "&invoiceno=" + invoiceno + "&name=" + name + "&submit=submit", true);
		xmlHttp.send(null);
	}

	function getCustomerList(type) {
		var xmlHttp = checkajax();
		xmlHttp.onreadystatechange = function() {
			if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
				document.getElementById("CustomerName").innerHTML = xmlHttp.responseText;
			}
		}
		xmlHttp.open("GET", "php/getCustomerList.php?type=" + type, true);
		xmlHttp.send(null);
	}

	getCustomerList('curr');

</script>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td class="body" valign="top" align="center">
        <?
			include (DOCUMENT_ROOT . 'tpl/admin-loged-in.php');
		?>
		<table border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td class="body_resize">
				<table border="0" cellpadding="0" cellspacing="0" align="left">
					<tr>
						<td style="vertical-align:top"><h2  class = "Our"> View Records / Invoices</h2>
						<br />
						<form id="myform" name ="myform" method="post">
							<table border='0'>
								<tr class="Trow">
									<td width="180" rowspan='2'>Customer Name: *</td>
									<td width="320"><select id= "CustomerName" name="CustomerName" style="font-weight:normal; width:250px"></select></td>
								</tr>
								<tr>
									<td>
									<input type="radio" name="customer_type" id="curr_customer" checked=true onclick="getCustomerList('curr')">
									Current
									<input type="radio" name="customer_type" id="arch_customer" onclick="getCustomerList('arch')">
									Archived </td>
								</tr>
								<tr class="Trow">
									<td>Records Between: *</td>
									<td><select id="frommonth" name="frommonth" style="font-weight:normal"></select><select id="fromyear" name="fromyear" style="font-weight:normal"></select> &nbsp;&nbsp; and &nbsp;&nbsp; <select id="tomonth" name="tomonth" style="font-weight:normal"></select><select id="toyear" name="toyear" style="font-weight:normal"></select>
									<script type = "text/javascript">
										document.getElementById("frommonth").options[0] = new Option("Jan", "01");
										document.getElementById("frommonth").options[1] = new Option("Feb", "02");
										document.getElementById("frommonth").options[2] = new Option("Mar", "03");
										document.getElementById("frommonth").options[3] = new Option("Apr", "04");
										document.getElementById("frommonth").options[4] = new Option("May", "05");
										document.getElementById("frommonth").options[5] = new Option("Jun", "06");
										document.getElementById("frommonth").options[6] = new Option("Jul", "07");
										document.getElementById("frommonth").options[7] = new Option("Aug", "08");
										document.getElementById("frommonth").options[8] = new Option("Sep", "09");
										document.getElementById("frommonth").options[9] = new Option("Oct", "10");
										document.getElementById("frommonth").options[10] = new Option("Nov", "11");
										document.getElementById("frommonth").options[11] = new Option("Dec", "12");
										document.getElementById("fromyear").options[0] = new Option("2007");
										document.getElementById("fromyear").options[1] = new Option("2008");
										document.getElementById("fromyear").options[2] = new Option("2009");
										document.getElementById("fromyear").options[3] = new Option("2010");
										document.getElementById("fromyear").options[4] = new Option("2011");
										document.getElementById("fromyear").options[5] = new Option("2012");
										document.getElementById("fromyear").options[6] = new Option("2013");
										document.getElementById("fromyear").options[7] = new Option("2014");
										document.getElementById("tomonth").options[0] = new Option("Jan", "01");
										document.getElementById("tomonth").options[1] = new Option("Feb", "02");
										document.getElementById("tomonth").options[2] = new Option("Mar", "03");
										document.getElementById("tomonth").options[3] = new Option("Apr", "04");
										document.getElementById("tomonth").options[4] = new Option("May", "05");
										document.getElementById("tomonth").options[5] = new Option("Jun", "06");
										document.getElementById("tomonth").options[6] = new Option("Jul", "07");
										document.getElementById("tomonth").options[7] = new Option("Aug", "08");
										document.getElementById("tomonth").options[8] = new Option("Sep", "09");
										document.getElementById("tomonth").options[9] = new Option("Oct", "10");
										document.getElementById("tomonth").options[10] = new Option("Nov", "11");
										document.getElementById("tomonth").options[11] = new Option("Dec", "12");
										document.getElementById("toyear").options[0] = new Option("2007");
										document.getElementById("toyear").options[1] = new Option("2008");
										document.getElementById("toyear").options[2] = new Option("2009");
										document.getElementById("toyear").options[3] = new Option("2010");
										document.getElementById("toyear").options[4] = new Option("2011");
										document.getElementById("toyear").options[5] = new Option("2012");
										document.getElementById("toyear").options[6] = new Option("2013");
										document.getElementById("toyear").options[7] = new Option("2014");
										document.getElementById("toyear").options[7].selected = true;

									</script></td>
								</tr>
								<tr>
									<td align="center" colspan="2">
									<br />
									<a style="cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;"  onClick = "showRecords(0, 1, 1);">View Records</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a style="cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;" href="javascript: showInvoices(0, 1, 1);">View Invoices</a></td>
								</tr>
							</table>
							<br>
						</form>
						<table width="100%" border="0" cellpadding="5" cellspacing="0">
							<tr valign="top">
								<td width="100%"><div align="center" class="err" id="error" style="display:none"></div><div align="center" class="alert" style="font-size:13;display:none" id="alert"></div></td>
							</tr>
						</table>
						<div id = "div1">
							&nbsp;
						</div></td>
					</tr>
				</table><div class="clr"></div></td>
			</tr>
		</table></td>
	</tr>
</table>
</td>
</tr>
</table>
<script type = "text/javascript"><? $view = $_GET['view'];?>

	var view = -1;
view = "<?php echo $_GET['view'] ?>
	"

	if(document.myform.CustomerName.value != "Select the Customer"){
	if(view == "0")
	showRecords(1,1,1);
	else if (view == "1")
	showInvoices(1,1,1);
	}
</script>
<?
	include ('tpl/footer.php');
?>