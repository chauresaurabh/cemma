<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");
if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//header('Location: login.php');
}
include (DOCUMENT_ROOT.'tpl/header.php');

include_once("includes/instrument_action.php");

 
 $isAddData = $_GET['submit'];
 if($isAddData==1) {
    session_start();
	$dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
  	 
	 $staffname = $_POST['name'];  
	 $email = $_POST['email'];
  	 $phonenumber = $_POST['phonenumber'];
   	 $designation = $_POST['designation'];
   
   	 $fileName = $_FILES["uploadFile"]["name"];
   
   if ($_FILES["uploadFile"]["error"] > 0)
	  {
		  echo "<b>No Image selected</b>";
  	  }
	else
	  {
 			  if ( !move_uploaded_file($_FILES["uploadFile"]["tmp_name"], "staffmembers/".$fileName ) )
			  {
				  	echo "<b>Error Copying Image </b>";
			  }
	  }
			
	 $sql="";
	 if($fileName==''){
			 		 	 $imagelocation = "staffmembers/nophoto.jpg";	  
 	  $sql = "insert into PROFESSIONAL_STAFF (name, email, phonenumber, designation, image) VALUES ('$staffname','$email', '$phonenumber', '$designation' ,'$imagelocation');";
	 }else{
		 	 $imagelocation = "staffmembers/".$fileName;	
 	  $sql = "insert into PROFESSIONAL_STAFF (name, email, phonenumber, designation, image) VALUES ('$staffname','$email', '$phonenumber', '$designation' ,'$imagelocation');";

	 }
	 $result = mysql_query($sql);
	 
	 $numRows =  mysql_affected_rows();
	$outputStr="";
	 
	if($numRows > 0)
	{
		 $outputStr = " <b>Record Added Successfully !</b>";
 	}else{
	 	$outputStr = "<b>Error inserting record in database!$fileName</b>";
	}
	echo $outputStr;
  
  
 mysql_close();
session_write_close();
 }

?>
 
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td class="body" valign="top" align="center">
    <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
    <table border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td class="body_resize"><table border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                
                <td>
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td class="t-top"><div class="title2">Add New Staff Member</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
 
                           <table class="content" align="center" width="650" border = "0">
                         
                          	<tr>
                             <td>
                             	<div id="manualsDisplayArea"></div>

                            	</td>
                            </tr>
                            
                            <tr class="Trow">
                               <td>  
                               <form action="AddStaffMember.php?submit=1" method="post" enctype="multipart/form-data" > 
  									 Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  	<input type="text" id="name" name="name" size="35"/> <br /><br />
   									 Designation   &nbsp;&nbsp;&nbsp;&nbsp;  <input type="text" id="designation" name="designation" size="35" /> <br /><br />
   									 Email   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	 <input type="text" id="email" name="email" size="35"/> <br /><br />
									 Phone Number   <input type="text" id="phonenumber" name="phonenumber" size="35"/> <br /><br />
                                     Image     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<input type="file" id="uploadFile" name="uploadFile" accept="image/*">
                                      <br /><br />  <input type="submit" value="Submit"  >
                                     </form>
   								</td>
                
                            </tr>
                            
                             	<tr class="Trow">
                               <td>   
 
  									
  								</td>
                
                            </tr>
                           </table>
                        </td>
                    </tr>
                    <tr>
                      <td class="t-bot2"></td>
                    </tr>
                 </table>
               </td>
             </tr>
           </table>
         </td>
       </tr>
    </table>
 
<script type="text/javascript">
 
 
 function createNewMember(){
	   var staffname = document.getElementById("name").value;
 	   var phonenumber = document.getElementById("phonenumber").value;
	    var email = document.getElementById("email").value;
		 var designation = document.getElementById("designation").value;
		    
  			if (window.XMLHttpRequest) {
						try {
							req = new XMLHttpRequest();
						} catch (e) {
							req = false;
						}
					} else if (window.ActiveXObject) {
						try {
							req = new ActiveXObject("Msxml2.XMLHTTP");
						} catch (e) {
							try {
								req = new ActiveXObject("Microsoft.XMLHTTP");
							} catch (e) {
								req = false;
							}
						}
					}
					if (req) {
   						req.onreadystatechange = showStaffDataUpdate;
						req.open("GET", "createStaffMember.php?staffname="+staffname+"&designation="+designation+"&email="+email+"&phonenumber="+phonenumber, true);
						req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("");
 					} else {
						alert("Please enable Javascript");
					}
		}
		
		function showStaffDataUpdate(){
			 
					if (req.readyState == 4 && req.status == 200) {    
					 var doc = eval("(" + req.responseText + ")");     																 						 alert( doc.recordupdated);
					}
 	 
 }
 
		 
</script>
 