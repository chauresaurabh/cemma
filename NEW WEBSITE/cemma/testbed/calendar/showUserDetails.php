<?php
include_once("php/dbconfig.php");
include_once("php/functions.php");
function getUserDetails($user_name){
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "select Name, Email, Advisor, Telephone from `user` where `UserName` = '" . $user_name."'";
    $handle = mysql_query($sql);
    //echo $sql;
    $row = mysql_fetch_object($handle);
	}catch(Exception $e){
  }
  return $row;
}
if($_GET["user_name"]){
  $event = getUserDetails($_GET["user_name"]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
  <head>    
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">    
    <title>User Details</title>    
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
    
    <script src="src/Plugins/jquery.alert.js" type="text/javascript"></script>    
    <script src="src/Plugins/jquery.ifrmdailog.js" defer="defer" type="text/javascript"></script>
    <script src="src/Plugins/wdCalendar_lang_US.js" type="text/javascript"></script>    
    <script src="src/Plugins/jquery.calendar.js" type="text/javascript"></script>  
     
  </head>
  <body>    
    <div>      
                       
      <div style="clear: both">         
      </div>        
      <div class="infocontainer">            
        <table class="fform" id="fmEdit">
        <tr>
          <label>                    
            <td>
                Name :              
            </td>
            <td>
            <span disabled="disabled" MaxLength="200" class="required safe" id="Name" name="Name" > <?php echo $event->Name ?> </span>
            </td>
          </label>
          </tr>
          <tr>
          <label>                    
            <td>
                Advisor :              
            </td>
            <td>
            <span disabled="disabled" MaxLength="200" class="required safe" id="Advisor" name="Advisor"> <?php echo $event->Advisor ?> </span>
            </td>
          </label>
          </tr>
          <tr>
          <label>                    
            <td>
                Phone :              
            </td>
            <td>
            <span disabled="disabled" MaxLength="200" class="required safe" id="phone" name="phone"> <?php echo $event->Telephone ?> </span>
            </td>
          </label>
          </tr>   
        </table>
      </div>         
    </div>
  </body>
</html>