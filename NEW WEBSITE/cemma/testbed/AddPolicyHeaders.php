<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");
if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//header('Location: login.php');
}
include (DOCUMENT_ROOT.'tpl/header.php');

include_once("includes/instrument_action.php");

	$addPolicyHeader =  $_GET['addPolicyHeader'];
 
	if($addPolicyHeader == 'true'){		
	 	
		// this needs to be changed to include from an external file
		$updateFlag = 0;
 	 	session_start();
		 include_once('constants.php');
		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

		$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
		$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");
 	
	 $vars = $_POST['element'];
	 $policy_header  = $_POST['policy_header']; 
 	 $policy_header_id = -1;
	 $policy_header_type_ind  = $_POST['policy_header_type_ind']; 
 	 
	if (!$connection)
		 {
 			 die('Could not connect: ' . mysql_error($connection));
		 } 
	else{
		 $sql="";
		 $sql="insert into POLICY_HDR(  policy_header , policy_header_type_bullet  )
		 		 values('".addslashes($policy_header)."', $policy_header_type_ind ) ";
 		 mysql_query($sql) or die(mysql_error());
		 // NEED to validate if this header already exists
		 // take a flag here .. and check this flag if true while inserting in details.
		  $sql="select policy_header_id from POLICY_HDR where policy_header ='".addslashes($policy_header)."' ";

		  $result = mysql_query($sql) ;
  			while($row = mysql_fetch_array($result)){
	  			 $policy_header_id = $row['policy_header_id'];
	  		}
 		}	 
	 
  	foreach ($vars as $id => $vals)
    {
    // $vars[id] outputs the ID number
    // $vars[vals] is the array containing the type and value
   
  		if (!$connection)
		 {
 			 die('Could not connect: ' . mysql_error($connection));
		 }
  		 foreach($vals as $key => $value)
         {		
		 	if($value!=""){
 			 $sql="";
			 $sql="insert into POLICY_DETAIL( policy_header_id , policy_detail_value )
			  values('$policy_header_id',' ". addslashes($value) ."') ";
 			 mysql_query($sql) or die(mysql_error());
			 $updateFlag = 1;
			}
       	 }
     }
	 $dateToday = date('Y-m-d H:i:s');
	 $sql="update POLICY_LAST_MODIFY set LAST_MODIFY_DT='$dateToday' ";
 	 mysql_query($sql) or die(mysql_error());
	mysql_close();
	session_write_close(); 
		if($updateFlag==1){
		?>
		<script type="text/javascript">
			alert(" New details for Policy <? $_POST['policy_header'] ?> Added Successfully ");
		</script>
        <? 
		} else { ?>
     		<script type="text/javascript">
				alert(" Unknown Error occurred .. Policy details have not been updated !");
			</script>
		 <? } 
		}
 ?>
		 

<script type="text/javascript">
function addPolicyDetails()
{
	   var e = document.getElementById("policy_header_type");
 	   var policy_header_type = e.options[e.selectedIndex].value;
	   document.getElementById("policy_header_type_ind").value = policy_header_type;
   	  //	alert("Value set as : "+document.getElementById("policy_header_type_ind").value);
	   document.addPolicyForm.submit;
 }
</script>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td class="body" valign="top" align="center">
    <?	include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
    <table border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td class="body_resize"><table border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td>
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td class="t-top"><div class="title2">Add new Policy Header & Detail</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
 				<form id="addPolicyHeaderForm" name="addPolicyHeaderForm" method="POST"
                 action="AddPolicyHeaders.php?addPolicyHeader=true">
                            <table class="content" align="center" width="650" border = "0">
                          <tr class="Trow">
                    	<td ><b>Policy Header: </b> </td>
                           	<td>
                                <textarea cols="40" rows="2" name="policy_header" id="policy_header"></textarea> 
                                <select id="policy_header_type" name="policy_header_type" >
                                	<option value="1">Bullet Points</option>
                                    <option value="0">Paragraphs</option>
                                </select>
                              </td>
                          </tr>
					 		<tr class="Trow">
                              <td >Policy Detail:  </td>
                              <td><textarea cols="40" rows="2" name="element[input][1]" id="policy_detail_1"></textarea></td>
                            </tr>
							<tr class="Trow">
                              <td >Policy Detail:  </td>
                              <td><textarea cols="40" rows="2" name="element[input][2]" id="policy_detail_2"></textarea></td>
                            </tr>
                            <tr class="Trow">
                              <td  >Policy Detail:  </td>
                              <td><textarea cols="40" rows="2" name="element[input][3]" id="policy_detail_3"></textarea></td>
                            </tr>
                            <tr class="Trow">
                              <td >Policy Detail:  </td>
                              <td><textarea cols="40" rows="2" name="element[input][4]" id="policy_detail_4"></textarea></td>
                            </tr>
                            <tr class="Trow">
                              <td >Policy Detail:  </td>
                              <td><textarea cols="40" rows="2" name="element[input][5]" id="policy_detail_5"></textarea></td>
                            </tr>
                           </table>
                           	  <input type="hidden" id="policy_header_type_ind" name="policy_header_type_ind" />
                             <input type="submit" name="submit" value="Add Policy Details" onclick="addPolicyDetails()">
 					</form>
                        </td>
                    </tr>
                    <tr>
                      <td class="t-bot2"><a href = "UploadPolicy.php">Update Policies Page</a></td>
                    </tr>
                 </table>
               </td>
             </tr>
           </table>
         </td>
       </tr>
    </table>
 
 </script>
 