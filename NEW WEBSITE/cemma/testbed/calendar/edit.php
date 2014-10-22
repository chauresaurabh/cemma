<?php
if(!isset($_SESSION))
	session_start();
include_once('../constants.php');
include_once("php/dbconfig.php");
include_once("php/functions.php");
function getCalendarByRange($id){
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "select * from `schedule_calendar` where `id` = " . $id;
    $handle = mysql_query($sql);
    //echo $sql;
    $row = mysql_fetch_object($handle);
	}catch(Exception $e){
  }
  return $row;
}
if($_GET["id"]){
  $event = getCalendarByRange($_GET["id"]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
  <head>    
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">    
    <title>Calendar Details</title>    
    <link href="css/main.css" rel="stylesheet" type="text/css" />       
    <link href="css/dp.css" rel="stylesheet" />    
    <link href="css/dropdown.css" rel="stylesheet" />    
    <link href="css/colorselect.css" rel="stylesheet" />   
     
    <script src="src/jquery.js" type="text/javascript"></script>    
    <script src="src/Plugins/Common.js" type="text/javascript"></script>        
    <script src="src/Plugins/jquery.form.js" type="text/javascript"></script>     
    <script src="src/Plugins/jquery.validate.js" type="text/javascript"></script>     
    <script src="src/Plugins/datepicker_lang_US.js" type="text/javascript"></script>        
    <script src="src/Plugins/jquery.datepicker.js" type="text/javascript"></script>     
    <script src="src/Plugins/jquery.dropdown.js" type="text/javascript"></script>     
    <script src="src/Plugins/jquery.colorselect.js" type="text/javascript"></script>    
     
    <script type="text/javascript">
        //alert("<? //echo php2JsTime(mySql2PhpTime($_GET['start'])) ?>");
		//alert("<? //echo $event->StartTime ?>");
		if (!DateAdd || typeof (DateDiff) != "function") {
            var DateAdd = function(interval, number, idate) {
                number = parseInt(number);
                var date;
                if (typeof (idate) == "string") {
                    date = idate.split(/\D/);
                    eval("var date = new Date(" + date.join(",") + ")");
                }
                if (typeof (idate) == "object") {
                    date = new Date(idate.toString());
                }
                switch (interval) {
                    case "y": date.setFullYear(date.getFullYear() + number); break;
                    case "m": date.setMonth(date.getMonth() + number); break;
                    case "d": date.setDate(date.getDate() + number); break;
                    case "w": date.setDate(date.getDate() + 7 * number); break;
                    case "h": date.setHours(date.getHours() + number); break;
                    case "n": date.setMinutes(date.getMinutes() + number); break;
                    case "s": date.setSeconds(date.getSeconds() + number); break;
                    case "l": date.setMilliseconds(date.getMilliseconds() + number); break;
                }
                return date;
            }
        }
        function getHM(date)
        {
             var hour =date.getHours();
             var minute= date.getMinutes();
             var ret= (hour>9?hour:"0"+hour)+":"+(minute>9?minute:"0"+minute) ;
             return ret;
        }
        $(document).ready(function() {
            //debugger;
            var DATA_FEED_URL = "php/datafeed.php";
            var arrT = [];
            var tt = "{0}:{1}";
			
			var k=0, j;
			
            for (var i = 0; i < 48;) {
                if(k<12){
					arrT.push({ text: StrFormat(tt, [(k >= 10 ? k : "0" + k), "00am"]) }, { text: StrFormat(tt, [k >= 10 ? k : "0" + k, "30am"]) });
				} else {
					j = k==12?k:k-12;
					arrT.push({ text: StrFormat(tt, [(j >= 10 ? j : "0" + j), "00pm"]) }, { text: StrFormat(tt, [(j >= 10 ? j : "0" + j), "30pm"]) });
				}
				i+=2;
				k++;
            }
            $("#timezone").val(new Date().getTimezoneOffset()/60 * -1);
            $("#stparttime").dropdown({
                dropheight: 80,
                dropwidth:80,
                selectedchange: function() { },
                items: arrT
            });
            $("#etparttime").dropdown({
                dropheight: 80,
                dropwidth:80,
                selectedchange: function() { },
                items: arrT
            });
            /*var check = $("#IsAllDayEvent").click(function(e) {
                if (this.checked) {
                    $("#stparttime").val("00:00").hide();
                    $("#etparttime").val("00:00").hide();
                }
                else {
                    var d = new Date();
                    var p = 60 - d.getMinutes();
                    if (p > 30) p = p - 30;
                    d = DateAdd("n", p, d);
                    $("#stparttime").val(getHM(d)).show();
                    $("#etparttime").val(getHM(DateAdd("h", 1, d))).show();
                }
            });
            if (check[0].checked) {
                $("#stparttime").val("00:00").hide();
                $("#etparttime").val("00:00").hide();
            }*/
            $("#Savebtn").click(function() { $("#fmEdit").submit(); });
            $("#Closebtn").click(function() { CloseModelWindow(); });
            $("#Deletebtn").click(function() {
                 if (confirm("Are you sure to remove this event")) {  
                    var param = [{ "name": "calendarId", value: 8}];                
                    $.post(DATA_FEED_URL + "?method=remove",
                        param,
                        function(data){
                              if (data.IsSuccess) {
                                    alert(data.Msg); 
                                    CloseModelWindow(null,true);                            
                                }
                                else {
                                    alert("Error occurs.\r\n" + data.Msg);
                                }
                        }
                    ,"json");
                }
            });
            
           $("#stpartdate,#etpartdate").datepicker({ picker: "<button class='calpick'></button>"});    
            var cv =$("#colorvalue").val() ;
            if(cv=="")
            {
                cv="-1";
            }
            
			//$("#calendarcolor").colorselect({ title: "Color", index: cv, hiddenid: "colorvalue" });
            //to define parameters of ajaxform
            var options = {
                beforeSubmit: function() {
                    return true;
                },
                dataType: "json",
                success: function(data) {
                    alert(data.Msg);
                    if (data.IsSuccess) {
                        CloseModelWindow(null,true);  
                    }
                }
            };
            $.validator.addMethod("date", function(value, element) {                             
                var arrs = value.split(i18n.datepicker.dateformat.separator);
                var year = arrs[i18n.datepicker.dateformat.year_index];
                var month = arrs[i18n.datepicker.dateformat.month_index];
                var day = arrs[i18n.datepicker.dateformat.day_index];
                var standvalue = [year,month,day].join("-");
                return this.optional(element) || /^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3-9]|1[0-2])[\/\-\.](?:29|30))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3,5,7,8]|1[02])[\/\-\.]31)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:16|[2468][048]|[3579][26])00[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1-9]|1[0-2])[\/\-\.](?:0?[1-9]|1\d|2[0-8]))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?:\d{1,3})?)?$/.test(standvalue);
            }, "Invalid date format");
            /*$.validator.addMethod("time", function(value, element) {
                return this.optional(element) || /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])$/.test(value);
            }, "Invalid time format");*/
            $.validator.addMethod("safe", function(value, element) {
                return this.optional(element) || /^[^$\<\>]+$/.test(value);
            }, "$<> not allowed");
            $("#fmEdit").validate({
                submitHandler: function(form) { $("#fmEdit").ajaxSubmit(options); },
                errorElement: "div",
                errorClass: "cusErrorPanel",
                errorPlacement: function(error, element) {
                    showerror(error, element);
                }
            });
            function showerror(error, target) {
                var pos = target.position();
                var height = target.height();
                var newpos = { left: pos.left, top: pos.top + height + 2 }
                var form = $("#fmEdit");             
                error.appendTo(form).css(newpos);
            }
        });
    </script>      
    <style type="text/css">     
    .calpick     {        
        width:16px;   
        height:16px;     
        border:none;        
        cursor:pointer;        
        background:url("sample-css/cal.gif") no-repeat center 2px;        
        margin-left:-22px;    
    }      
    </style>
  </head>
  <body>    
    <div>      
      <div class="toolBotton">           
        <a id="Savebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Save"  title="Save the calendar">Save(<u>S</u>)
          </span>          
        </a>                           
        <?php //if(isset($event)){ ?>
        <!--<a id="Deletebtn" class="imgbtn" href="javascript:void(0);">                    
          <span class="Delete" title="Cancel the calendar">Delete(<u>D</u>)
          </span>                
        </a>-->             
        <?php //} ?>            
        <a id="Closebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Close" title="Close the window" >Close
          </span></a>            
        </a>        
      </div>                  
      <div style="clear: both">         
      </div>        
      <div class="infocontainer">            
        <form action="php/datafeed.php?instrument=<? echo $_GET['instrument']?>&method=adddetails<?php echo isset($event)?"&id=".$event->Id:""; ?>" class="fform" id="fmEdit" method="post">                 
          <label>                    
            <span>                        *Who:
            </span>                    
            <div id="calendarcolor">
            </div>
            <?
			$unme = (isset($event)?$event->Subject:$_GET['title']);
			if($_SESSION['ClassLevel']<3) {
				include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
				$sql = "SELECT UserName,LastName, FirstName FROM user where ActiveUser='active' OR ActiveUser IS NULL OR ActiveUser ='' ORDER BY UserName";
				$values=mysql_query($sql) or die("An error has ocured in query11: " .mysql_error (). ":" .mysql_errno ());
				?>
				<select id="Subject" name="Subject">
					<?
					while($row = mysql_fetch_array($values)) {
						if($row["UserName"] == $unme){
							?> <option selected="selected" value="<? echo $row["UserName"] ?>"><? echo $row["FirstName"]==''?$row["UserName"]:$row["FirstName"]." ".$row["LastName"]?></option>
						<? } else { ?>
							<option value="<? echo $row["UserName"] ?>"><? echo $row["FirstName"]==''?$row["UserName"]:$row["FirstName"]." ".$row["LastName"]?></option>
					<? 		}
					} ?>
            	</select>
             <? } else { ?>
             		<input type="text" value="<?=$unme?>" readonly="readonly" style="background:#EEEEEE" id="Subject" name="Subject" />
             <? } ?>
            <!--<input readonly MaxLength="200" class="required safe" id="Subject" name="Subject" style="width:85%;" type="text" value="<?php //echo isset($event)?$event->Subject:$_GET['title'] ?>" />                     
            <input id="colorvalue" name="colorvalue" type="hidden" value="<?php //echo isset($event)?$event->Color:"" ?>" />                -->
          </label>                 
          <label>                    
            <span>*Time:
            </span>                    
            <div>
              <?php if(isset($event)){
                  $sarr = explode(" ", php2JsTime(mySql2PhpTime($event->StartTime)));
                  $earr = explode(" ", php2JsTime(mySql2PhpTime($event->EndTime)));
              } else {
				  $sarr = explode(" ", php2JsTime(mySql2PhpTime($_GET['start'])));
                  $earr = explode(" ", php2JsTime(mySql2PhpTime($_GET['end'])));
			  }
			  
			  if($sarr[1]>=12) {
				  //if it's >= 12 then it's pm
				if($sarr[1]>12) {
					$ti = explode(":", $sarr[1]);
					//if it's greater than 12, then need to subtract 12 from it
					$ti[0]-=12;
					if($ti[0]<10){
						$ti[0]="0".$ti[0];
					}
					$sarr[1]=$ti[0].":".$ti[1];
				}
				$sarr[1].="pm";
			  } else {
				  $sarr[1].="am";
			  }
			  
			  if($earr[1]>=12) {
				  //if it's >= 12 then it's pm
				if($earr[1]>12) {
					$ti = explode(":", $earr[1]);
					//if it's greater than 12, then need to subtract 12 from it
					$ti[0]-=12;
					if($ti[0]<10){
						$ti[0]="0".$ti[0];
					}
					$earr[1]=$ti[0].":".$ti[1];
				}
				$earr[1].="pm";
			  } else {
				  $earr[1].="am";
			  }
			  
			  ?>
              <input MaxLength="10" class="required date" id="stpartdate" name="stpartdate" style="padding-left:2px;width:90px;" type="text" value="<?php echo $sarr[0]; ?>" /> &nbsp;&nbsp;
              <input MaxLength="7" class="required time" id="stparttime" name="stparttime" style="width:80px;" type="text" value="<?php echo $sarr[1];
			  
			  ?>" />&nbsp;To                       
              <input MaxLength="10" class="required date" id="etpartdate" name="etpartdate" style="padding-left:2px;width:90px;" type="text" value="<?php echo $earr[0]; ?>" /> &nbsp;&nbsp;                      
              <input MaxLength="7" class="required time" id="etparttime" name="etparttime" style="width:80px;" type="text" value="<?php echo $earr[1]; ?>" />
              <!--&nbsp;&nbsp;
              <label class="checkp"> 
                <input id="IsAllDayEvent" name="IsAllDayEvent" type="checkbox" value="1" <?php if(isset($event)&&$event->IsAllDayEvent!=0) {echo "checked";} ?>/>          All Day Event                      
              </label>-->                    
            </div>                
          </label>                 
          <!--<label>                    
            <span>                        Location:
            </span>                    
            <input MaxLength="200" id="Location" name="Location" style="width:95%;" type="text" value="<?php echo isset($event)?$event->Location:""; ?>" />                 
          </label>                 
          <label>                    
            <span>                        Remark:
            </span>                    
<textarea cols="20" id="Description" name="Description" rows="2" style="width:95%; height:70px">
<?php echo isset($event)?$event->Description:""; ?>
</textarea>                
          </label>-->                
          <input id="timezone" name="timezone" type="hidden" value="" />           
        </form>         
      </div>         
    </div>
  </body>
</html>