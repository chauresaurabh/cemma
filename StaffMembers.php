<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");
if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//header('Location: login.php');
}
include (DOCUMENT_ROOT.'tpl/header.php');

include_once("includes/instrument_action.php");

 
 $updateFlag = $_GET['submit'];
 if( $updateFlag == 1 ){
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
    
	 $prevname = $_POST['prevname'];
	
    	 $fileName = $_FILES["uploadFile"]["name"];
   
   if ($_FILES["uploadFile"]["error"] > 0)
	  {
		  echo "Error Uploading Image ";
  	  }
	else
	  {
 			  if ( !move_uploaded_file($_FILES["uploadFile"]["tmp_name"], "staffmembers/".$fileName ) )
			  {
				  	echo "Error Copying Image ";
			  }
	  }
	  
	  $imagelocation = "staffmembers/".$fileName;	  
	  
	  $sql="";
	  if($fileName==''){
		 $sql = "update PROFESSIONAL_STAFF set name='$staffname', email='$email', phonenumber='$phonenumber', designation='$designation'  where name='".$prevname."'";
	  }else{
	 	$sql = "update PROFESSIONAL_STAFF set name='$staffname', email='$email', phonenumber='$phonenumber', designation='$designation' , image='$imagelocation' where name='".$prevname."'";
 	  }
	 $result = mysql_query($sql);
	 
	 $numRows =  mysql_affected_rows();
	$outputStr="";
	
	if($numRows > 0)
	{
		 $outputStr = "Record Updated Successfully !";
 	}else{
	 	$outputStr = "Record not found!";
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
                      <td class="t-top"><div class="title2">Manage Staff Member</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
 
                           <table class="content" align="center" width="650" border = "0">
                          <tr class="Trow">
          <td ><center><select id="instrument_name" name="instrument_name" style="font-weight:normal" onchange="showManuals()" ></select></center></td>
                          </tr>
                          	<tr>
                             <td>
                             	<div id="manualsDisplayArea"></div>

                            	</td>
                            </tr>
                            
                            <tr class="Trow">
                               <td>   
                            <form action="StaffMembers.php?submit=1" method="post" enctype="multipart/form-data" >  
  									 Name : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  	<input type="text" id="name" name="name" size="35"/> <br /><br />
   									 Designation : &nbsp;&nbsp;&nbsp;&nbsp;  <input type="text" id="designation" name="designation" size="35" /> <br /><br />
   									 Email :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	 <input type="text" id="email" name="email" size="35"/> <br /><br />
									 Phone Number : <input type="text" id="phonenumber" name="phonenumber" size="35"/> <br /><br />
                                     Upload Image : <input type="file" id="uploadFile" name="uploadFile" />
                                      <div id="imagearea" name="imagearea"></div>
                                      <br /><br />
                                      <input type="hidden" name="prevname" id="prevname"/>
                                 <input type="submit" value="Update Data"> 

  								 <input type="button" value="Add Staff Member" onClick="addStaffMember()"  >
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
<?
 	
	 $dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
	
	// FOR INSTRUMENTS
	$sql2 = "select name from PROFESSIONAL_STAFF";
	$result2 = mysql_query($sql2);
	//$value = mysql_num_rows($result);
	$j=1;
 	?>
document.getElementById("instrument_name").options[0]=new Option("<? echo "-- Select Cemma Staff Member --" ?>");
document.getElementById("instrument_name").options[0].value=0;

	<?
	while($row2=mysql_fetch_array($result2)){?>
	//bug here .. because if a policy is deleted completely .. then a blank row in drop down will be created
 document.getElementById("instrument_name").options[<? echo $j?>] = new Option("<? echo $row2['name']?>");
 document.getElementById("instrument_name").options[<? echo $j?>].value = "<? echo $row2['name']?>";
 	<?	
		$j+=1;
	}
 	
	mysql_close();
?>
</script>
  

<script type="text/javascript">
 
 
 function addNewManual(){
	 
	   var e = document.getElementById("instrument_name");
 	   var instrumentNo = e.options[e.selectedIndex].value;
	   
	 	 var foo = document.getElementById("manualsDisplayArea");
		 foo.innerHTML = "<form action='ManualUploader.php' method='post'  enctype='multipart/form-data'> " 
 			 			  + "    Manual Name :  " 
						   + "    <input type='text'  name='manualName' />  " 
						 + "    <input type='hidden' id='hiddenInstrumentNo' name='hiddenInstrumentNo' value='"+instrumentNo+"' />  " 
	  + " <input type='hidden' id='updateValue' name='updateValue' value='false' />  " 

						 + "    <input type='file' name='file' id='file'>  " 
 					     +"    <input type='submit' value='Upload New Manual' />  " 
 						 +"    </form>";
 

	 
	 }
    var req;
	var username;
	var advisor;
	instrumentName=""
	 
	 function addStaffMember(){
		 	window.location="http://cemma-usc.net/cemma/testbed/AddStaffMember.php";
	 }
	 
	  function updateData(){
 		
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
						req.open("GET", "updateStaffData.php?staffname="+staffname+"&designation="+designation+"&email="+email+"&phonenumber="+phonenumber, true);
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
	 function showManuals(){
 		
 	   var e = document.getElementById("instrument_name");
 	     instrumentName = e.options[e.selectedIndex].value;
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
   						req.onreadystatechange = showStaffData;
						req.open("GET", "loadStaffData.php?instrumentName="+instrumentName, true);
						req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("");
 					} else {
						alert("Please enable Javascript");
					}
		}
	function showStaffData(){
			if (req.readyState == 4 && req.status == 200) {         																 
				 var doc = eval("(" + req.responseText + ")");
  				 if(doc.notfound){
					 alert(' Cemma Staff Member not found');
				 }else{
 
 					 document.getElementById("name").value = doc[0].name;
					 document.getElementById("email").value = doc[0].email;
					 document.getElementById("phonenumber").value = doc[0].phonenumber;
					 document.getElementById("designation").value = doc[0].designation;					 					
 				   	 document.getElementById("prevname").value = doc[0].name;

 					 document.getElementById("imagearea").innerHTML = "Current Image : <a target='_blank' href='"+doc[0].image+"'>"+doc[0].image.substring(13)+"</a>";
				}
  	 	
		}
	}
		 
</script>
 