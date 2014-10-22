<?php
include_once ('constants.php');
include_once (DOCUMENT_ROOT."includes/checklogin.php");
include_once (DOCUMENT_ROOT."includes/checkadmin.php");
include (DOCUMENT_ROOT.'tpl/header.php');

define("L_LANG", "el_GR");
?>
<link href="css/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="scripts/calendar.js"></script>
<script type="text/javascript" src="scripts/calendar-en.js"></script>
<script type="text/javascript" src="scripts/date.js"></script>
<script type = "text/javascript">
var calendar = null;
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
	
	function fetchEvents() {
		var xmlHttp = checkajax();
		
		var fromDate = document.getElementById("fromDate").value;
		var toDate = document.getElementById("toDate").value;
		   xmlHttp.onreadystatechange=function() {
			
				if(xmlHttp.readyState==4) {
					document.getElementById("records").innerHTML=xmlHttp.responseText;
				}
		   }

			xmlHttp.open("GET","fetchCalendarEvents.php?fromDateIns="+fromDate+"&toDateIns="+toDate ,true);
			xmlHttp.send(null);
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
						<table width="100%" border="0" cellpadding="5" cellspacing="0">
							<tr>
								<td class="t-top">
								<div class="title2">
									Manage Calendar
								</div></td>
							</tr>
							<tr>
								<td class="t-mid">
								<br />
								<br />
                                <div style="padding-left:30px;font-weight:bold">
									<label>Find Events</label>
									<br>
										<table border = "0" width="90%">
											<tr class = "Trow">
												<td width="20%">Events Between:</td>
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
											<tr>
												<td colspan = "2" align = "left">
												<input type="button" name="submitButton" value="Find Events" style="cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;border:0" onclick="fetchEvents()" />
												</td>
											</tr>
						</table>
						
                        
                        
                        
                        
                        <table border="0" cellpadding="0" cellspacing="0" align="left"><tr>
                       <td>
                           
                            <table width="500" border="0" cellpadding="5" cellspacing="0"> 
                                <tr valign="top"> 
                                    <td width="100%"> 
                                        <div align="center" class="err" id="error" style="display:none">Error Detected</div>
                                    </td>
                                </tr> 
                            </table>
                            
                            <table width="600" border="0" cellpadding="5" cellspacing="0">
                                <tr><td style="background:#CCC;width:500px;height: 13px; padding: 14px 15px 12px 12px; vertical-align: top;">
                                </td></tr>
                                <tr><td style="border-collapse:collapse; border-color:#ccd5cc; border-style:solid; border-width:1pt" >
                                <div class="printcontent2" id="div2">
                                <table align="center" cellpadding="0" cellspacing="0" style="table-layout:fixed;font-family: Lucida Grande,Lucida Sans Unicode,Verdana; font-size: 12px;" width = "100%">
                                    <col width="30px"/>
                                    <col width="100px"/>
                                    <col width="100px"/>
                                    <col width="100px"/>
                                    <col width="20px"/>
                                    <col width="30px"/>
                                    
                                    <tbody id="records">
                                      <tr bgcolor="#F4F4F4" align="center" style="color: #333333; font-family: "trebuchet MS",Arial; font-size: 12px; font-weight: bold; height: 40px;">
                                        <td>Id</td>
                                        <td>Description</td>
                                        <td>Start Time</td>
                                        <td>End Time</td>
                                        <td class="dont1">Edit</td>
                                        <td class="dont1">Delete</td>
            						</tr>
                                        <tr align="center">
                                            <td colspan = "6">No Records Found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </td>
                            </tr>
                            <tr>
                                <td style="background: #CCC;
                                font-family: Lucida Grande,Lucida Sans Unicode,Verdana;
                                font-size: 12px;
                                height: 20px;
                                padding: 15px 25px 0 0;
                                text-align: right;
                                vertical-align: top;
                                width: 800px;">
                                     <a href = "addFullDayEvent"><u>New Event</u></a>
                                </td>
                            </tr>
                        </table>
                        </td></tr></table>
                      <div class="clr"></div>
                        </td></tr></table>
                
                        
                        
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

<?
include ('tpl/footer.php');
 ?> 