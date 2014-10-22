<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
	
	
	if(isset($_POST['description'])){

		$description =  $_POST['description'];
		$starttime = $_POST['starttime']." 09:00:00";
		$endtime = $_POST['starttime']." 16:30:00";
		$sql = "INSERT INTO schedule_calendar(IsAllDayEvent, instrument, subject, description, starttime, endtime, color, emailid) VALUES (1, 'none', 'John', '$description', '$starttime', '$endtime', 20, 'curulli@usc.edu')";
		mysql_query($sql) or die("Error in Adding Instrument!");
		?><script>alert("Added new event successfully.");</script><?
	}
	
?>
<link href="css/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="scripts/calendar.js"></script>
<script type="text/javascript" src="scripts/calendar-en.js"></script>
<script type="text/javascript" src="scripts/date.js"></script>
<script>
var calendar = null;
</script>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="body" valign="top" align="center">
        <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
        <table border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td class="body_resize"><table border="0" cellpadding="0" cellspacing="0" align="left">
                            <tr>
                                <td><table width="100%" border="0" cellpadding="5" cellspacing="0">
                                        <tr valign="top">
                                            <td width="100%">
                                                <div align="center" class="alert" style="font-size:13;" id="alert"></div></td>
                                        </tr>
                                    </table>
                                    <table width="100%" border="0" cellpadding="5" cellspacing="0">
                                        <tr>
                                            <td class="t-top"><h2 class="Our">Add Full Day Event</h2></td>
                                        </tr>
                                        <tr>
                                            <td class="t-mid"><br />
                                                <br />
                                                <form id="myform" name="myform" method="post" action="addFullDayEvent.php">
                                                    <table width="450" class="content" align="center" style="border: thin, #993300">
                                                
														<tr class= "Trow">
														<td><div align="center" class="alert" style="font-size:13;display:none" id="alert"></div></td>
														</tr>
														<tr class= "Trow" >
                                                            <td>Enter Description:</td>
                                                            <td><input type="text" class="text" size="4" name="description" id="description" value="">
															</td>
	                                                   </tr>
                                                       
                                                       <tr>
															<td>
                                                	Date
													 <td>
                                                        <input type="text" name="starttime" id="starttime" readonly="readonly" size = "10" value = ""/>
														<img src = "images/calendar.gif" height="20" width = "20" id="date_calendar1" value="calendar" onClick="showCalendar('starttime', 'y/mm/dd')" style="cursor:pointer" />
                                                    </td>
                                                        </tr>
                                                    </table>
                                        </tr>
                                        <tr>
                                            <td class="t-bot2"><input type="submit" value="Add Event"/>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="manageCalendar.php">Return</a></td>
                                        </form>

                                        </tr>
                                    </table></td>
                            </tr>
                        </table>
                        <div class="clr"></div></td>
                </tr>
            </table></td>
    </tr>
</table>
</td>
</tr>
</table>

<? include ('tpl/footer.php'); ?>