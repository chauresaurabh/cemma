
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
  <head>    
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">    
    <title>Mail Customer</title>    
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
      <form onsubmit="return validateForm()" action="EmailCustomerTheMail.php?send=true" class="fform" id="fmEdit" method="post">  
      <div class="toolBotton">  
      	<input type="submit" value="Send" class="imgbtn"/>         
        <!--<a id="Savebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Save"  title="Send the mail">Send(<u>S</u>)
          </span>          
        </a>-->
      </div>           
        <label>                    
            <span>From:       
            </span>
            <input readonly MaxLength="200" class="required safe" id="from" name="from" style="width:85%;" type="text" value="cemma@usc.edu" /><br/>
            <span> To: </span>
            <input MaxLength="200" class="required safe" id="to" name="to" style="width:85%;" type="text" value="<? echo $_GET["email"]?>" />
          </label>                 
          <label>                    
            <span>Subject:
            </span>                    
            <input MaxLength="200" id="Subject" name="Subject" style="width:95%;" type="text" value="" />
          </label>                 
          <label>          
            <span> Message: </span>                    
            <textarea cols="20" id="Message" name="Message" rows="2" style="width:95%; height:70px"></textarea>          </label>
       </form>
      </div>         
    </div>
  </body>
</html>