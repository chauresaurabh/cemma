<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");
if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//header('Location: login.php');
}
include (DOCUMENT_ROOT.'tpl/header.php');

include_once("includes/instrument_action.php");

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
                      <td class="t-top"><div class="title2">View Policies</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
 
                           <table class="content" align="center" width="650" border = "0">
                          <tr class="Trow">
                          	<td colspan="2"><center><select id="user_name" name="user_name" style="font-weight:normal""></select></center></td>
                          </tr>
					 	<!-- These should be dynamically loaded dropdowns -->
                         		 <tr class="Trow">
                              		 <td>   
  									 	<input type="submit" value="View Policy" onClick="openViewPolicy()" >
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
	 
	$sql = "SELECT UserName, Advisor FROM user where ActiveUser in ('', 'active') order by UserName";
	$result = mysql_query($sql);
	//$value = mysql_num_rows($result);
	$i=1;
 	?>
document.getElementById("user_name").options[0]=new Option("<? echo "-- Select User to view Policy --" ?>");
document.getElementById("user_name").options[0].value=0;

	<?
	while($row=mysql_fetch_array($result)){?>
	//bug here .. because if a policy is deleted completely .. then a blank row in drop down will be created
	 document.getElementById("user_name").options[<? echo $i?>] = new Option("<? echo $row['UserName']?>");
	 document.getElementById("user_name").options[<? echo $i?>].value = "<? echo $row['Advisor']?>";
 	<?	
	$i+=1;
	}
 
  ?>
 
</script>

  
<script type="text/javascript">

var req;
  
	function openViewPolicy(){
  
    var e = document.getElementById("user_name");
 	var username = e.options[e.selectedIndex].text;
   	var advisor = e.options[e.selectedIndex].value;
	  
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
 						req.open("GET", "loadPolicyData.php?imgdefault="+'true'+"&username="+username+"&advisor="+advisor , true);
						
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
		 
</script>
 