<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CEMMA</title>
<meta http-equiv="imagetoolbar" content="no" /> 
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/usclogo.css" rel="stylesheet" type="text/css"/>
<? if(getfilename()=='administration.php' || getfilename()=='schedule_event.php'){?>
	<link href="calendar/css/dailog.css" rel="stylesheet" type="text/css" />
    <link href="calendar/css/calendar.css" rel="stylesheet" type="text/css" /> 
    <link href="calendar/css/dp.css" rel="stylesheet" type="text/css" />   
    <link href="calendar/css/alert.css" rel="stylesheet" type="text/css" /> 
    <link href="calendar/css/main.css" rel="stylesheet" type="text/css" />
    
    <script src="calendar/src/jquery.js" type="text/javascript"></script>  
    <script type="text/javascript">
		   var createEvent;
		   <? if(getfilename()=='schedule_event.php'){?>
		   		createEvent = 1;
			<? } else {?>
				createEvent = 0;
			<? }?>
    </script>
    <script src="calendar/src/Plugins/Common.js" type="text/javascript"></script>    
    <script src="calendar/src/Plugins/datepicker_lang_US.js" type="text/javascript"></script>     
    <script src="calendar/src/Plugins/jquery.datepicker.js" type="text/javascript"></script>

    <script src="calendar/src/Plugins/jquery.alert.js" type="text/javascript"></script>    
    <script src="calendar/src/Plugins/jquery.ifrmdailog.js" defer="defer" type="text/javascript"></script>
    <script src="calendar/src/Plugins/wdCalendar_lang_US.js" type="text/javascript"></script>    
    <script src="calendar/src/Plugins/jquery.calendar.js" type="text/javascript"></script>   
    <script type="text/javascript">
	
		function sendWeeklymail(startdate, enddate, ins) {
			var eurl="EmailCustomers.php?week=true&start="+startdate+"&end="+enddate+"&instrument="+ins;   
			OpenModelWindow(eurl,{ width: 600, height: 300, caption:"Mail Customers",onclose:function(){
			   alert("Email messages sent to today's customers");
			}});
		}
        $(document).ready(function() {
  			  
           var view="week";
		    var DATA_FEED_URL = "calendar/php/datafeed.php";
			var op = {
					view: view,
					theme:3,
					showday: new Date(),
					EditCmdhandler:Edit,
					DeleteCmdhandler:Delete,
					ViewCmdhandler:View,    
					onWeekOrMonthToDay:wtd,
					onBeforeRequestData: cal_beforerequest,
					onAfterRequestData: cal_afterrequest,
					onRequestDataError: cal_onerror, 
					autoload:true,
					url: DATA_FEED_URL + "?method=list",  
					quickAddUrl: DATA_FEED_URL + "?method=add", 
					quickUpdateUrl: DATA_FEED_URL + "?method=update",
					quickDeleteUrl: DATA_FEED_URL + "?method=remove"
					<? if(getfilename()=='administration.php'){?>
					,
					readonly:true
					<? }?>
				};
            var $dv = $("#calhead");
            var _MH = document.documentElement.clientHeight;
            var dvH = $dv.height() + 2;
            op.height = _MH - dvH;
            op.eventItems =[];

            var p = $("#gridcontainer").bcalendar(op).BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
            $("#caltoolbar").noSelect();
            
            $("#hdtxtshow").datepicker({ picker: "#txtdatetimeshow", showtarget: $("#txtdatetimeshow"),
            onReturn:function(r){                          
                            var p = $("#gridcontainer").gotoDate(r).BcalGetOp();
                            if (p && p.datestrshow) {
                                $("#txtdatetimeshow").text(p.datestrshow);
                            }
                     } 
            });
            function cal_beforerequest(type)
            {
                var t="Loading data...";
                switch(type)
                {
                    case 1:
                        t="Loading data...";
                        break;
                    case 2:                      
                    case 3:  
                    case 4:    
                        t="The request is being processed ...";                                   
                        break;
                }
                $("#errorpannel").hide();
                $("#loadingpannel").html(t).show();    
            }
            function cal_afterrequest(type)
            {
                switch(type)
                {
                    case 1:
                        $("#loadingpannel").hide();
                        break;
                    case 2:
                    case 3:
					break;
                    case 4:
                        $("#loadingpannel").html("Success!");
                        window.setTimeout(function(){ $("#loadingpannel").hide();},2000);
                    break;
                }
               $("#gridcontainer").reload();
            }
            function cal_onerror(type,data)
            {
				alert(data.Msg);
				$("#errorpannel").html(data.Msg);
                $("#errorpannel").show();
            }
            function Edit(data)
            {
               var eurl="calendar/edit.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";   
                if(data)
                {
                    var url = StrFormat(eurl,data);
					url=url+"&instrument="+$("#InstrName").val();
					
                    OpenModelWindow(url,{ width: 600, height: 180, caption:"Manage  The Calendar",onclose:function(){
                       $("#gridcontainer").reload();
                    }});
                }
            }    
            function View(data)
            {
                /*var str = "";
                $.each(data, function(i, item){
                    str += "[" + i + "]: " + item + "\n";
                });*/
				<? /*cemma changes*/
				if($_SESSION['ClassLevel'] < 4){?>
					var url="calendar/showUserDetails.php?user_name="+data[1];
					
					OpenModelWindow(url,{width:400, height:150, caption: "User Details", onclose:function(){
					}});
				<? }?>
            }    
            function Delete(data,callback)
            {           
                
                $.alerts.okButton="Ok";  
                $.alerts.cancelButton="Cancel";  
                hiConfirm("Are You Sure to Delete this Event", 'Confirm',function(r){ r && callback(0);});           
            }
            function wtd(p)
            {
               if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $("#showdaybtn").addClass("fcurrent");
            }
            //to show day view
            $("#showdaybtn").click(function(e) {
                //document.location.href="#day";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("day").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            //to show week view
            $("#showweekbtn").click(function(e) {
                //document.location.href="#week";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("week").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }

            });
            //to show month view
            $("#showmonthbtn").click(function(e) {
                //document.location.href="#month";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("month").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            
            $("#showreflashbtn").click(function(e){
                $("#gridcontainer").reload();
            });
            
			$("#InstrName").change(function(e) {
				//alert('instrument changed');
				$("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
				$(this).addClass("fcurrent");
                var p = $("#gridcontainer").loadCalendarEvents($("#InstrName").val()).BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
				if($("#InstrName").val()=="Akashi 002B - TEM"){
					changeCalBackGround($('.akashi').css('background-color'));
				} else if($("#InstrName").val()=="DeltaVision OMX") {
					changeCalBackGround($('.delta').css('background-color'));
				} else if($("#InstrName").val()=="JEOL 100CX - TEM") {
					changeCalBackGround($('.jeol-100cx').css('background-color'));
				} else if($("#InstrName").val()=="JEOL JEM-2100F") {
					changeCalBackGround($('.jeol-2100').css('background-color'));
				} else if($("#InstrName").val()=="JEOL JIB-4500 - FIB SEM") {
					changeCalBackGround($('.jeol-4500').css('background-color'));
				} else if($("#InstrName").val()=="JEOL JSM-6610 - SEM") {
					changeCalBackGround($('.jeol-6610').css('background-color'));
				} else if($("#InstrName").val()=="JEOL JSM-7001 - SEM") {
					changeCalBackGround($('.jeol-7001').css('background-color'));
				} else if($("#InstrName").val()=="Tousimis 815 - Critical Point Dryer") {
					changeCalBackGround($('.tousimis').css('background-color'));
				} else if($("#InstrName").val()=="Ultramicrotomes") {
					changeCalBackGround($('.ultramicrotomes').css('background-color'));
				} else if($("#InstrName").val()=="Kratos AXIS Ultra") {
					changeCalBackGround($('.kratos').css('background-color'));
				} else {
					changeCalBackGround('#c3d9ff');
				}
            });
			
			function changehiddeninstrument(instrumentname){
			
					   	alert(' inside change instrument '+instrumentname); 
				//setTimeout(function(){ }, 2000);
 				$("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
				$(this).addClass("fcurrent");
                var p = $("#gridcontainer").loadCalendarEvents(instrumentname).BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
				if($("#InstrName").val()=="Akashi 002B - TEM"){
					changeCalBackGround($('.akashi').css('background-color'));
				} else if($("#InstrName").val()=="DeltaVision OMX") {
					changeCalBackGround($('.delta').css('background-color'));
				} else if($("#InstrName").val()=="JEOL 100CX - TEM") {
					changeCalBackGround($('.jeol-100cx').css('background-color'));
				} else if($("#InstrName").val()=="JEOL JEM-2100F") {
					changeCalBackGround($('.jeol-2100').css('background-color'));
				} else if($("#InstrName").val()=="JEOL JIB-4500 - FIB SEM") {
					changeCalBackGround($('.jeol-4500').css('background-color'));
				} else if($("#InstrName").val()=="JEOL JSM-6610 - SEM") {
					changeCalBackGround($('.jeol-6610').css('background-color'));
				} else if($("#InstrName").val()=="JEOL JSM-7001 - SEM") {
					changeCalBackGround($('.jeol-7001').css('background-color'));
				} else if($("#InstrName").val()=="Tousimis 815 - Critical Point Dryer") {
					changeCalBackGround($('.tousimis').css('background-color'));
				} else if($("#InstrName").val()=="Ultramicrotomes") {
					changeCalBackGround($('.ultramicrotomes').css('background-color'));
				} else if($("#InstrName").val()=="Kratos AXIS Ultra") {
					changeCalBackGround($('.kratos').css('background-color'));
				} else {
					changeCalBackGround('#c3d9ff');
				}
 			}
			function changeCalBackGround(color){
				document.getElementById("insDropdown").style.display="none";
				document.getElementById("dvCalMain").style.background=color;
				document.getElementById("gridcontainer").style.background=color;
				$('.printborder').css('border-left', '9px solid '+color);
				$('.chromeColor').css('background', color);
				$('.chromeColor').css('border-color', color);
				$('.ctoolbar').css('background', color);
				$('.cHead').css('background', color);
			}
            //Add a new event
/*            $("#faddbtn").click(function(e) {
                var url ="edit.php";
                OpenModelWindow(url,{ width: 500, height: 400, caption: "Create New Calendar"});
            });
*/            //go to today
            $("#showtodaybtn").click(function(e) {
                var p = $("#gridcontainer").gotoDate().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }


            });
            //previous date range
            $("#sfprevbtn").click(function(e) {
                var p = $("#gridcontainer").previousRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }

            });
            //next date range
            $("#sfnextbtn").click(function(e) {
                var p = $("#gridcontainer").nextRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
           
		   var hiddeninstrumentname =  $("#hiddeninstrumentname").val();  
			if (typeof(hiddeninstrumentname) != 'undefined' && hiddeninstrumentname != null && hiddeninstrumentname!=''){
 					changehiddeninstrument(hiddeninstrumentname);
			}
        });
    </script>    

<? }
/*if(getfilename()=='administration.php')
	echo '<link rel=\'stylesheet\' type=\'text/css\' href=\'php_calendar/calendar_style.css\' /><script type=\'text/javascript\' src="php_calendar/calendar.js"></script>';
else if(getfilename()=='schedule.php') {

	echo '<link rel="stylesheet" type="text/css" href="css/supercali.css">';
	if ($_REQUEST["size"] == "small") echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/small.css\">\n";
	if ($css) echo $css;
	echo '<script language="JavaScript" src="js/CalendarPopup.js"></script>';
	echo '<script language="JavaScript">document.write(getCalendarStyles());</script>';
	echo '<script language="JavaScript" src="js/ColorPicker2.js"></script>';
	echo '<script language="JavaScript" src="js/miscfunctions.js"></script>';
	if ($javascript) echo $javascript;
}*/
?>
<!--<script type="text/javascript" src="scripts/menuScript.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/easySlider1.5.js"></script>
<script type="text/javascript" src="js/js_utils.js"></script>
<script type="text/javascript">
// <![CDATA[
/*$(document).ready(function(){	
	$("#slider").easySlider({
		controlsBefore:	'<p id="controls">',
		controlsAfter:	'</p>',
		auto: true, 
		continuous: true
	});	
});*/
// ]]>
</script>
-->



</head>

<?
/*if(getfilename()=='administration.php')
	echo '<body onLoad=\'navigate("","")\'>';
else
	echo '<body>';
	*/
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td class="main">
	<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td class="header" align="center">
		<table border="0" cellpadding="0" cellspacing="0">
        	<tr>
                <td bgcolor="#000000" id="usclogo">
                	<a target="_blank" id="anchorlogo" href="http://www.usc.edu/"> University of Southern California
                    </a>
                </td>
            </tr>
            <tr>
                <td height="100" align="center">
                      <span style="font-size:40px;  ">Center for Electron Microscopy and Microanalysis</span>
                </td>
            </tr>
			<tr>
				<td class="block_header">
					<!--<div class="logo"><a href="index.html"><img src="images/logo.png"  height="124" border="0" alt="logo" /></a></div>
					<div class="search">
						<form id="form1" name="form1" method="post" action="">
							<label>
								<input name="q" type="text" class="keywords" id="textfield" maxlength="50" />
								<input name="b" type="image" src="images/search.gif" class="button" />
							</label>
						</form>
					</div>-->
					<div style="width:100%" class="clr"></div>
						<div class="association">
                        	<a target="_blank" href="http://viterbi.usc.edu/"><img width="120" style="margin:2px" src="../testbed/images/viterbi.gif.png" height="40px"></a>&nbsp;
                        	<a target="_blank" border="0" href="http://www.usc.edu/schools/college/"><img width="120" style="margin:2px" src="../testbed/images/Dornsife_Logo.jpg" height="40px"></a>
                        </div>
						
						<!--<div class="menu">
							<ul>
								<li><a href="index.php">Home</a></li>                                   
								<li><a href="index.php">About Us</a></li>
								<li><a href="index.php">Services</a></li>
								<li><a href="login.php">Login</a></li>
								<li><a href="logout.php">Logout</a></li>
								<li><a href="index.php">Contact Us</a></li>
							</ul>
						</div>-->
					</div>
					<div class="clr"></div>
                    
				</td>
			</tr>
		</table></td></tr>
	</table>
  
  
  
<?
//echo "pop-".$_SESSION['login'];
function getfilename()
{
	$x= explode("/",$_SERVER['SCRIPT_NAME']);
	$f=count($x)-1;
	return $x[$f];
}
?>    

<!-- Dependency -->
<script src="http://yui.yahooapis.com/2.8.0r4/build/yahoo/yahoo-min.js"></script>
 
<!-- Used for Custom Events and event listener bindings -->
<script src="http://yui.yahooapis.com/2.8.0r4/build/event/event-min.js"></script>
 
<!-- Source file -->
<!--
	If you require only basic HTTP transaction support, use the
	connection_core.js file.
-->
<script src="http://yui.yahooapis.com/2.8.0r4/build/connection/connection_core-min.js"></script>
 
<!--
	Use the full connection.js if you require the following features:
	- Form serialization.
	- File Upload using the iframe transport.
	- Cross-domain(XDR) transactions.
-->
<script src="http://yui.yahooapis.com/2.8.0r4/build/connection/connection-min.js"></script>

<script src="js/viewComponent.js" type="text/javascript"></script>