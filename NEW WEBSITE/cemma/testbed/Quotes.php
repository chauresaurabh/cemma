<script type="text/javascript">
document.title = "Create Quotes";
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
                </td>
                <td>
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td class="t-top"><div class="title2">Create Quotes</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
   	<form id="addQuoteForm" name="addQuoteForm" method="POST" onsubmit="return viewQuote()" action="loadQuoteData.php">

                           <table class="content" align="center" width="650" border = "0">
                          <tr class="Trow">
                          	<td colspan="2"><center><select id="customer_type" name="customer_type" style="font-weight:normal" onchange="testDrop()"></select></center></td>
                          </tr>
					 	<!-- These should be dynamically loaded dropdowns -->
                         <tr class="Trow">
                         <td colspan="2">
                      		 <div id="instrumentarea">
                    	 <select id="instrument_name1" name="instrument_name1" style="font-weight:normal" ></select> 
                          	Enter Quantity : <input type="text" value="1" name="quantity1" id="quantity1" size="2"/>
                            <input type="radio" name="radio1" value="With_Operator" checked="checked"/>With Operator 
                            <input type="radio" name="radio1" value="Without_Operator" />Without Operator 
                   			  </div>
                          	</td>
                       </tr>    
							<tr class="Trow">
<td><div id="policy_details_area"><b></b></div></td>
                            </tr>
                            	<tr class="Trow">
                               <td>   
  									 <input type="submit" value="View Quote"  >
  								</td>
                                <td>   
  									 <input type="button" value="Add New Record" onclick="addNewRecord()" >
  								</td>
                            </tr>
                           </table>
                           <input type="hidden" id="listcount" name="listcount" />
                           <input type="hidden" id="customer_name" name="customer_name" />
                           
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
document.getElementById("customer_type").options[0]=new Option("<? echo "-- Select Customer to create a Quote --" ?>");
document.getElementById("customer_type").options[0].value=0;

	<?
	while($row=mysql_fetch_array($result)){?>
	//bug here .. because if a policy is deleted completely .. then a blank row in drop down will be created
		document.getElementById("customer_type").options[<? echo $i?>] = new Option("<? echo $row['Name']?>");
		document.getElementById("customer_type").options[<? echo $i?>].value = "<? echo $row['Type']?>";
 	<?	
	$i+=1;
	}
	
	// FOR INSTRUMENTS
	$sql2 = "select InstrumentNo, InstrumentName from instrument where DisplayOnPricingPage=1 order by InstrumentNo";
	$result2 = mysql_query($sql2);
	//$value = mysql_num_rows($result);
	$j=1;
 	?>
document.getElementById("instrument_name1").options[0]=new Option("<? echo "-- Select Instrument --" ?>");
document.getElementById("instrument_name1").options[0].value=0;

	<?
	while($row2=mysql_fetch_array($result2)){?>
	//bug here .. because if a policy is deleted completely .. then a blank row in drop down will be created
 document.getElementById("instrument_name1").options[<? echo $j?>] = new Option("<? echo $row2['InstrumentName']?>");
 document.getElementById("instrument_name1").options[<? echo $j?>].value = "<? echo $row2['InstrumentNo']?>";
 	<?	
		$j+=1;
	}
 	
	mysql_close();
?>
</script>
 

<script type="text/javascript">
var ctr = 1;
function addNewRecord(){
		ctr=ctr+1;
 	  var e = document.getElementById("instrument_name1");

 	//	var customer_type = e.options[e.selectedIndex].value;
		//var customer_name = e.options[e.selectedIndex].text;
 	var list = document.createElement("select");
	 list.setAttribute("name", "instrument_name"+ctr);
	 list.setAttribute("id", "instrument_name"+ctr);

   for (var i=0; i<e.length; i++){
	    var option123 = document.createElement("option");
		option123.text = e.options[i].text;
		option123.value = e.options[i].value;
		list.add(option123, null); //Standard
  }
	//
  
 	var br = document.createElement("br");

	 var foo = document.getElementById("instrumentarea");
	 foo.appendChild(br);

	 var radio1 = document.createElement("input");
 
    //Assign different attributes to the element.
    radio1.setAttribute("type", "radio");
    radio1.setAttribute("value", "With_Operator");
    radio1.setAttribute("name", "radio"+ctr);
    radio1.setAttribute("id", "radio"+ctr);
	radio1.setAttribute('checked', 'checked');
	
	 var radio2 = document.createElement("input");
 
    radio2.setAttribute("type", "radio");
    radio2.setAttribute("value", "Without_Operator");
    radio2.setAttribute("name", "radio"+ctr);
    radio2.setAttribute("id", "radio2");

	var t1=document.createTextNode("With Operator");
	var t2=document.createTextNode("Without Operator");
	var t3=document.createTextNode(" Enter Quantity : ");

    var qtyTextbox = document.createElement("input");
 	qtyTextbox.setAttribute("type", "text");
    qtyTextbox.setAttribute("value", "1");
    qtyTextbox.setAttribute("size", "2");
    qtyTextbox.setAttribute("name", "quantity"+ctr);
    qtyTextbox.setAttribute("id", "quantity"+ctr);
	
     foo.appendChild(list);
	 foo.appendChild(t3);
 	 foo.appendChild(qtyTextbox);
	 foo.appendChild (document.createTextNode(" "));
	 
     foo.appendChild(radio1);
	 foo.appendChild(t1);
	 foo.appendChild (document.createTextNode(" "));

     foo.appendChild(radio2);
	 foo.appendChild(t2);
  }
  
  function viewQuote(){
	  	var flag = 0;
	 	var e = document.getElementById("customer_type");
 		 var customer_type = e.options[e.selectedIndex].value;
		//var customer_name = e.options[e.selectedIndex].text;
  		if(customer_type==0){
			alert('Please select Customer !');
			return false;
		}
			 
		for(i=1;i<=ctr;i++){
			var p = document.getElementById("instrument_name"+i);
		 	var value = p.options[p.selectedIndex].value;
  			if(value==0){
				flag = 1;
				break; 
			}
  		}
		if(flag == 1){
			alert('Please select an Instrument');
			return false;
 		}
 			// list.setAttribute("name", "instrument_name"+ctr);
	
			
		var customer_name = document.getElementById("customer_name");
		customer_name.value = e.options[e.selectedIndex].text;
		
		var listcount = document.getElementById("listcount");
		listcount.value = ctr; 
		
 		//document.addQuoteForm.submit();
		
   }
   
  
</script>

<script type="text/javascript">

var req;
  
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
		 
</script>
 