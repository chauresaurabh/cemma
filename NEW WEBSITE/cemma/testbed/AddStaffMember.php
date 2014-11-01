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
  	 
	 $firstname = $_POST['firstname'];  
	 $lastname = $_POST['lastname'];  
	 $name = $firstname." ".$lastname;
	 
	 $email = $_POST['email'];
  	 $phonenumber = $_POST['phonenumber'];
   	 $designation = $_POST['designation'];
   
   	 $fileName = $_FILES["uploadFile"]["name"];
   	 
	  $stafftype = $_POST['stafftype'];
	  
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
 	  $sql = "insert into PROFESSIONAL_STAFF (name, firstname, lastname, email, phonenumber, designation, image , fulltimestaff) VALUES ('$name','$firstname','$lastname','$email', '$phonenumber', '$designation' ,'$imagelocation', '$stafftype');";
	 }else{
		 	 $imagelocation = "staffmembers/".$fileName;	
 	  $sql = "insert into PROFESSIONAL_STAFF (name, firstname, lastname , email, phonenumber, designation, image , fulltimestaff) VALUES ('$name','$firstname','$lastname','$email', '$phonenumber', '$designation' ,'$imagelocation' , '$stafftype');";

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
  									 First Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  	<input type="text" id="firstname" name="firstname" size="35"/> <br /><br />
                                      Last Name    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  	<input type="text" id="lastname" name="lastname" size="35"/> <br /><br />
   									 Designation   &nbsp;&nbsp;&nbsp;&nbsp;  <input type="text" id="designation" name="designation" size="35" /> <br /><br />
                                       Staff Type : &nbsp;&nbsp;&nbsp;&nbsp;
                                      <input type="radio" name="stafftype" id="fulltimestaff" value="1">Full Time&nbsp;&nbsp;&nbsp;&nbsp;
									  <input type="radio" name="stafftype" id="otherstaff"  value="0">Other Staff <br ><br >
                                      
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
 