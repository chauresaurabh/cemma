<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	if($class==4){
		header('Location: login.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
  <head>    
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">    
    <title>Mail to Today's Customer</title>    
    <link href="calendar/css/main.css" rel="stylesheet" type="text/css" />       
    <link href="calendar/css/dp.css" rel="stylesheet" />    
    <link href="calendar/css/dropdown.css" rel="stylesheet" />    
    <link href="calendar/css/colorselect.css" rel="stylesheet" />
    
    <script src="calendar/src/jquery.js" type="text/javascript"></script>    
    <script src="calendar/src/Plugins/Common.js" type="text/javascript"></script>        
    <script src="calendar/src/Plugins/jquery.form.js" type="text/javascript"></script>     
    <script src="calendar/src/Plugins/jquery.validate.js" type="text/javascript"></script>     
    <script src="calendar/src/Plugins/jquery.dropdown.js" type="text/javascript"></script>
    <script type="text/javascript">
	function validateForm() {
		if(null== document.getElementById('to').value || document.getElementById('to').value=="") {
			alert("Recipient cannot be blank");
			return false;
		}
		if(null== document.getElementById('Subject').value || document.getElementById('Subject').value=="") {
			alert("Subject cannot be blank");
			return false;
		}
		if(null== document.getElementById('Message').value || document.getElementById('Message').value=="") {
			alert("Message cannot be blank");
			return false;
		}
	}
	</script>
  </head>
  <body>    
    <div>      
          
   	  <div style="clear: both">         
      </div>
      <div class="infocontainer">
      <form action="EmailCustomersTheMail.php?send=true" class="fform" id="fmEdit" method="post" onsubmit="return validateForm()">  
      <div class="toolBotton">  
      	<input type="submit" value="Send" class="imgbtn" />         
        <!--<a id="Savebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Save"  title="Send the mail">Send(<u>S</u>)
          </span>          
        </a>-->
      </div>           
        <label>                    
            <span>From:
            </span>
            <input readonly MaxLength="200" class="required safe" id="from" name="from" style="width:85%;" type="text" value="cemma@usc.edu" />                     
          </label>
          <label>
          <span>To:</span>
          <?
		  	include_once(DOCUMENT_ROOT."includes/database.php");
			$week = $_GET['week'];
			$sql = "";
			if(NULL!=$week && $week=='true'){
				$startdate = $_GET['start'];
				$enddate = $_GET['end'];
				$sql = "SELECT distinct subject FROM schedule_calendar WHERE STR_TO_DATE(starttime, '%Y-%m-%d') between STR_TO_DATE('$startdate', '%m/%d/%Y') AND STR_TO_DATE('$enddate', '%m/%d/%Y')";
			} else {
				$date = $_GET['start'];
				$sql = "SELECT distinct subject FROM schedule_calendar WHERE STR_TO_DATE(starttime, '%Y-%m-%d') = STR_TO_DATE('$date', '%m/%d/%Y')";
			}
			$ins = $_GET['instrument']=='none'?'':' AND Instrument = \''.$_GET['instrument'].'\'';
			$sql .= $ins;
			
			$result = mysql_query($sql) OR die(mysql_error());
			
			$username="";
			$i=0;
			$emailIds = "";
			while($row = mysql_fetch_array($result)){
				$username = $row[0];
				$sql = "select email from user where username = '".$username."'";
				$userResult = mysql_query($sql);
				$email = mysql_fetch_array($userResult);
				$emailIds.=$email[0]."; ";
				$i+=1;
			}
			?>
          <input class="required safe" id="to" name="to" style="width:85%" type="text" value="<?=$emailIds?>"/>
          </label>
          <label>                    
            <span>Subject:
            </span>                    
            <input MaxLength="200" class="required safe" id="Subject" name="Subject" style="width:95%;" type="text" value="" />
          </label>                 
          <label>          
            <span> Message: </span>                    
            <textarea cols="20" id="Message" class="required safe" name="Message" rows="2" style="width:95%; height:70px"></textarea>
            </label>
       </form>
      </div>         
    </div>
  </body>
</html>