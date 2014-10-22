<script type="text/javascript">
document.title = "Price List";
</script>
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
                      <td class="t-top"><div class="title2">View Pricing</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
   	<form id="viewPricingForm" name="viewPricingForm" action="loadPricingData.php">

                           <table class="content" align="center" width="650" border = "0">
                          <tr class="Trow">
                     <td><center><select id="customer_type" name="customer_type" style="font-weight:normal"></select><br/>                    	                             <div id="newCustomer" style="visibility:hidden">
                            <br />Customer Name  &nbsp; &nbsp; <input type="text" id="customerName" /> <br /> <br />
                            Customer Address <input type="text" id="customerAddress" /> <br /><br />
                            Phone &nbsp;&nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<input type="text" id="customerPhone" /> <br /><br />
                            Email-Id &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;<input type="text" id="customerEmail" /> <br /><br />

                            <label for="customerTypeLabel">Customer Type </label>
                             <select name="customerTypeLabel" id="customerTypeLabel">
                                  <option value="On-Campus">On-Campus</option>
                                  <option value="Off-Campus">Off-Campus</option>
                                  <option value="Industry">Industry</option>
 							</select> 

							</div>
                            </center>
                        </td>
                           </tr>
                         
 							<tr class="Trow">
<td><div id="policy_details_area"><b></b></div></td>
                            </tr>
                            	<tr> 
                                   <td><div id="pricingDetailsArea"/> </td>
								 </tr>
                            	<tr class="Trow">

                               <td>   
  									 <input type="button" value="View Pricing" onclick="viewPricing()" >
  									 <input type="button" value="New Customer" onclick="makeVisible()" >
  								</td>
                                 
                            </tr>
                           </table>
                            <input type="hidden" id="listcount" name="listcount" />
                            <input type="hidden" id="customer_name" name="customer_name" />
                            <input type="hidden" id="customer_type2" name="customer_type2" />
                            <input type="hidden" id="new_customer" name="new_customer" />
                            <input type="hidden" id="customer_address" name="customer_address" />
                            <input type="hidden" id="customer_email" name="customer_email" />
                            <input type="hidden" id="customer_phone" name="customer_phone" />
                                 
                        </form>   
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
	 
	$sql = "select Name, Type from Customer where Activated=1 order by Name";
	$result = mysql_query($sql);
	//$value = mysql_num_rows($result);
	$i=1;
 	?>
document.getElementById("customer_type").options[0]=new Option("<? echo "-- Select Customer to view Pricing --" ?>");
document.getElementById("customer_type").options[0].value=0;

	<?
	while($row=mysql_fetch_array($result)){?>
	//bug here .. because if a policy is deleted completely .. then a blank row in drop down will be created
		document.getElementById("customer_type").options[<? echo $i?>] = new Option("<? echo $row['Name']?>");
		document.getElementById("customer_type").options[<? echo $i?>].value = "<? echo $row['Type']?>";
 	<?	
	$i+=1;
	}
	
	 	
	mysql_close();
?>
</script>
 

<script type="text/javascript">

	function makeVisible(){
			document.getElementById('newCustomer').style.visibility='visible';
	}
   
  function viewPricing(){
  
 	var e = document.getElementById("customer_type");

 	document.getElementById("customer_address").value  = document.getElementById("customerAddress").value;
 	document.getElementById("customer_phone").value    = document.getElementById("customerPhone").value;
 	document.getElementById("customer_email").value    = document.getElementById("customerEmail").value;

 	document.getElementById("customer_type2").value   = e.options[e.selectedIndex].value;
 	document.getElementById("customer_name").value  =e.options[e.selectedIndex].text;
	document.getElementById("new_customer").value  = "false";
	
	var v = document.getElementById('customerName').value;
	if(v!=null && v!=""){		
 	  e = document.getElementById("customerTypeLabel");
 	  document.getElementById("customer_type2").value = e.options[e.selectedIndex].value;
	  document.getElementById("customer_name").value  = v;
	  document.getElementById("new_customer").value  = "true";
 	}	
	document.getElementById("viewPricingForm").submit();
  }


</script> 