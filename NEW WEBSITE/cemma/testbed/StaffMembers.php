<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");
 
include (DOCUMENT_ROOT.'tpl/header.php');

  $updateFlag = $_GET['submit'];
 if( $updateFlag == 1 ){
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
     
	 $stafftype = $_POST['stafftype'];
	 
	 $prevname = $_POST['prevname'];
	
    	 $fileName = $_FILES["uploadFile"]["name"];
   
   if ($_FILES["uploadFile"]["error"] > 0)
	  {
		  echo " <b>No Image selected</b> ";
  	  }
	else
	  {
 			  if ( !move_uploaded_file($_FILES["uploadFile"]["tmp_name"], "staffmembers/".$fileName ) )
			  {
				  	echo "<b>Error Copying Image </b>";
			  }
	  }
	  
	  $imagelocation = "staffmembers/".$fileName;	  
	  
	  $sql="";
	  if($fileName==''){
		 $sql = "update PROFESSIONAL_STAFF set name='$name', firstname='$firstname',lastname='$lastname', email='$email', phonenumber='$phonenumber', designation='$designation', fulltimestaff='$stafftype'  where name='".$prevname."'";
	  }else{
	 	$sql = "update PROFESSIONAL_STAFF set name='$name', firstname='$firstname',lastname='$lastname', email='$email', phonenumber='$phonenumber', designation='$designation' , fulltimestaff='$stafftype' , image='$imagelocation' where name='".$prevname."'";
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
                      <td class="t-top"><div class="title2">Manage Staff Member <span id="spanname"></span></div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
 
                           <table class="content" align="center" width="650" border = "0">
                          <tr class="Trow">
          <td ><center><select id="instrument_name" name="instrument_name" style="font-weight:normal" onchange="loadStaffData()" ></select> 
           <input type="button" value="Add Staff Member" onClick="addStaffMember()"  >
</center></td>
                          </tr>
                          	<tr>
                             <td>
                             	<div id="manualsDisplayArea"></div>

                            	</td>
                            </tr>
                            
                            <tr class="Trow">
                               <td>   
                            <form action="StaffMembers.php?submit=1" name="staffform" id="staffform" method="post" enctype="multipart/form-data" style="visibility:hidden">  
  									First Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   	<input type="text" id="firstname" name="firstname" size="35"/> <br /><br />
                                      Last Name    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 	<input type="text" id="lastname" name="lastname" size="35"/> <br /><br />
   									 Designation : &nbsp;&nbsp;&nbsp;&nbsp;  <input type="text" id="designation" name="designation" size="35" /> <br /><br />
                                     Staff Type : &nbsp;&nbsp;&nbsp;&nbsp;
                                      <input type="radio" name="stafftype" id="fulltimestaff" value="1">Full Time&nbsp;&nbsp;&nbsp;&nbsp;
									  <input type="radio" name="stafftype" id="otherstaff"  value="0">Other Staff <br ><br >

   									 Email :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	 <input type="text" id="email" name="email" size="35"/> <br /><br />
									 Phone Number : <input type="text" id="phonenumber" name="phonenumber" size="35"/> <br /><br />
                                     Upload Image : <input type="file" id="uploadFile" name="uploadFile" />
                                      <div id="imagearea" name="imagearea"></div>
                                      <br /><br />
                                      <input type="hidden" name="prevname" id="prevname"/>
                                 <input type="submit" value="Update Data"> 
                                  
                                 <input type="button" value="Delete Staff Member" onClick="deleteStaffMember()"  >
                                 
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
	$sql2 = "select name from PROFESSIONAL_STAFF order by fulltimestaff desc, lastname asc";
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
  
    var req;
	var username;
	var advisor;
	instrumentName=""
	 
	 function addStaffMember(){
		 	window.location="http://cemma-usc.net/cemma/testbed/AddStaffMember.php";
	 }
	 
	  function deleteStaffMember(){
 		
		var name = document.getElementById("prevname").value
		 
 		if(!confirm("Are you sure you want to delete Staff Member : " + name))
				return;
	   
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
   						req.onreadystatechange = showDeleteStaffDataUpdate;
						req.open("GET", "deleteStaffData.php?name="+name, true);
						req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("");
 					} else {
						alert("Please enable Javascript");
					}
		}
		
		function showDeleteStaffDataUpdate(){
					if (req.readyState == 4 && req.status == 200) {    
					 var doc = eval("(" + req.responseText + ")");     																 						 alert( doc.recordupdated);
						window.location = "http://cemma-usc.net/cemma/testbed/StaffMembers.php";
					}
		}
		
	 
	 
	  function updateData(){
 		
 	   var firstname = document.getElementById("firstname").value;
 	   var lastname = document.getElementById("lastname").value;
	   
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
						req.open("GET", "updateStaffData.php?firstname="+firstname+"&lastname="+lastname+"&designation="+designation+"&email="+email+"&phonenumber="+phonenumber, true);
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
	 function loadStaffData(){
 		
		document.getElementById('staffform').style.visibility="visible";
		 
 	   var e = document.getElementById("instrument_name");
 	    var instrumentName = e.options[e.selectedIndex].value;
	 
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
 
 					 document.getElementById("firstname").value = doc[0].firstname;
					 document.getElementById("lastname").value = doc[0].lastname;
					 
					 document.getElementById("email").value = doc[0].email;
					 document.getElementById("phonenumber").value = doc[0].phonenumber;
					 document.getElementById("designation").value = doc[0].designation;					 					
 				   	 document.getElementById("prevname").value = doc[0].name;

 						 
					if(doc[0].fulltimestaff==1){
					 	 document.getElementById("fulltimestaff").checked=true;
					}else{
						 document.getElementById("otherstaff").checked=true;
					}
 					 document.getElementById("imagearea").innerHTML = "Current Image : <a target='_blank' href='"+doc[0].image+"'>"+doc[0].image.substring(13)+"</a>";
				}
  	 	
		}
	}
		 
</script>
 