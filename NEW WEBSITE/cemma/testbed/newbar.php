<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");
if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//header('Location: login.php');
}
include (DOCUMENT_ROOT.'tpl/header.php');

include_once("includes/instrument_action.php");

	$updatePolicy =  $_GET['updatePolicy'];
	
	if($updatePolicy == 'true'){		
	 	
		$updateFlag = 0;
 	 	session_start();
		 include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

		$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
		$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");
		
	 $vars = $_POST['element'];
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
			 $sql="";
			 if($value==""){
			 $sql="delete from POLICY_DETAIL where policy_detail_id =".$key .""; 
			 }else{
			 $sql="update POLICY_DETAIL set policy_detail_value='". addslashes($value) ."'  where policy_detail_id =".$key ."";
			 }
  		     mysql_query( $sql );
			 if($updateFlag == 0 ){
				 $updateFlag = 1;
 			 }
      	 }
     }
	 $dateToday = date('Y-m-d H:i:s');
	 $sql="update POLICY_LAST_MODIFY set LAST_MODIFY_DT='$dateToday' ";
 	 mysql_query($sql) or die(mysql_error());
	mysql_close();
	session_write_close(); 
		if($updateFlag!=0){
		?>
		<script type="text/javascript">
			alert("Policy details Updated Successfully");
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
function submitclicked()
{
	document.userform.submit();
}
</script>

 
<table border="0" cellpadding="0" cellspacing="0" width="100%">


  <tr>
    <td class="body" valign="top" >
    <? include ('newheader.php'); ?>
    <table border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td class="body_resize"><table border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                
                <td>
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td class="t-top"><div class="title2">Update Policies</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
                           <table class="content" align="center" width="650" border = "0">
                          <tr class="Trow">
                          	<td colspan="2"><center><select id="policy_header" name="policy_header" style="font-weight:normal" onchange="loadPolicy()"></select></center></td>
                          </tr>
					 
							<tr class="Trow">
                               <td><div id="policy_details_area"><b>Select a policy item from above drop-down to load the policy detail</b></div></td>
                            </tr>
                            	<tr class="Trow">
                               <td> <input type="button" value="Add New Detail" onclick="openAddPolicyDetailsWindow()" >  
									 <input type="button" value="New Header & Details" onclick="openAddPolicyHeadersWindow()" >
 									 <input type="button" value="View Policy" onclick="openViewPolicy()" >
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
		include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
		
		$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
		$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");
 
	$sql = "select * from POLICY_HDR";
	$result = mysql_query($sql);
	$i=1;
 	?>
document.getElementById("policy_header").options[0]=new Option("<? echo "-- Select Policy header to load Policy details --" ?>");
document.getElementById("policy_header").options[0].value=0;

	<?
	while($row=mysql_fetch_array($result)){?>
	//bug here .. because if a policy is deleted completely .. then a blank row in drop down will be created
		document.getElementById("policy_header").options[<? echo $i?>] = new Option("<? echo $row['policy_header']?>");
		document.getElementById("policy_header").options[<? echo $i?>].value = <? echo $row['policy_header_id']?>;
<?	
	$i+=1;
	}
	mysql_close();
?>
var req;
 
	function openAddPolicyDetailsWindow(){
		var win = window.open('AddPolicyDetails.php','',"scrollbars=1");
 		}
	function openAddPolicyHeadersWindow(){
		var win = window.open('AddPolicyHeaders.php','',"scrollbars=1");
 		}	
		
	function openViewPolicy(){
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
 						req.onreadystatechange = setPolicyData;
						req.open("GET", "loadPolicyData.php?imgdefault="+'true', true);
						req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("");
					} else {
						alert("Please enable Javascript");
					}
 		}	
		
		function setPolicyData(){
		if (req.readyState == 4 && req.status == 200) {
				  if(req.responseText == "query_error"){
						// upload a default document and notify user ... that this is default. 
				  }
    			  var policyWindow=window.open('','',"scrollbars=1");
 				  policyWindow.document.write((req.responseText).replace(/\\/g, '')); 
			}
		}
		
		
function loadPolicy(){
    var e = document.getElementById("policy_header");
 	var policy_header_id = e.options[e.selectedIndex].value;
 
//	alert(policy_header_id +" -- " + e.options[policy_header_id].text);
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
						req.onreadystatechange = showPermitData;
						req.open("GET", "showPolicyDetails.php?policy_header_id="+policy_header_id, true);
						req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("");
					} else {
						alert("Please enable Javascript");
					}
		}
			function showPermitData(){
		if (req.readyState == 4 && req.status == 200) {		
   			var array = eval("(" + req.responseText + ")");
  			 var str = '<form id="userform" method="post" action="UploadPolicy.php?updatePolicy=true" >';
  			for(var i=0;i<array.length;i++){
   			 if(array[i].policy_detail_id != null){
       		   str=str + ' <textarea rows="3" cols="75" name="element[input]['+array[i].policy_detail_id+'] "> ' + array[i].policy_detail_value + " </textarea> ";
  			  }
			}
			str = str + ' <br> <br><input type="submit" value="Update Policy" onclick="submitclicked()">';
		 		str=str + ' </form>';
			 str = str + "  Note : <br>";
			str = str + " 1: To Delete Data, Remove entire content from the text box and hit 'Update Policy'<br>";
	 		str = str + " 2: To have bold text, enclose text between &lt;b&gt; and &lt;/b&gt; , eg: &lt;b&gt; This is CEMMA &lt;/b&gt;";

 			 document.getElementById('policy_details_area').innerHTML =  str;
 		}
	}
    
   function updatePolicy(){
 
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
 						req.onreadystatechange = showPermitData2;
						req.open("GET", "updatePolicyDetails.php", true);
						req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("");
					} else {
						alert("Please enable Javascript");
					}
		}
			function showPermitData2(){
 			if (req.readyState == 4 && req.status == 200) {			
  			 document.getElementById('policy_details_area').innerHTML = req.responseText;	 
 			}
		}
  
</script>
 