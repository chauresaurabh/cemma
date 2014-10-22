<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	if ($class != 1) {
		header('Location: login.php');
	}
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/invoice_action.php");
 ?>
 
  
<?php

	if(isset($_POST['Name'])){
		$rs = new InvoiceDAO();
		$rs->update($_GET['id'],$_POST);
		$msg = "Invoice has been updated successfully";


	}
	else{
		$_SESSION['returnLink'] = $_SERVER['HTTP_REFERER'];
	}
	
?>

  <table border="0" cellpadding="0" cellspacing="0" width="100%">   
	
	<tr><td class="body" valign="top" align="center">
    <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="center"><tr>
      
       <td>
	   
	  
	   
	   <?php
	   
	   $rs = new InvoiceDAO();
	   $rs->getSingleRecord($_GET['id']);
	   while($row = $rs->fetchSingleRecord()){
		   $Gdate_array = explode("-",$row['Gdate']);
			$Gyear  = $Gdate_array[0];
			$Gmonth = $Gdate_array[1];
			
			if($Gmonth>6) $Gyear = $Gyear+1;

		 	   
	   ?>
	   
	   <table width="100%" border="0" cellpadding="5" cellspacing="0"> 
                    <tr valign="top"> 
                      <td width="100%"> 
						<div align="center" class="err" id="error" style="display:none"></div>
						<div align="center" class="alert" style="font-size:13;display:none" id="alert"></div>
					  </td>
				</tr> 
        </table>
	   
	   
       <table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr><td class="t-top">
            <div class="title2">Edit Invoice</div>
            </td></tr>
            <tr><td class="t-mid">

<br /><br />

		<form id="myForm" name="myForm" method="post" action="editInvoice.php?id=<?=$_GET['id']?>">
			<table class="content" align="center" width="450" border = "0">
				<input type="hidden" size="30" name="Manager_ID" class="text"  value="<?=$row['Manager_ID']?>">
				<input type="hidden" size="30" name="Year" class="text"  value="<?=$row['Year']?>">
				<input type="hidden" size="30" name="Invoiceno" class="text"  value="<?=$row['Invoiceno']?>">
				<input type="hidden" name="Fromdate"  class="text" value="<?=$row['Fromdate']?>">
				<input type="hidden" name="Todate"  class="text" value="<?=$row['Todate']?>">
				<input type="hidden" name="Gdate"  class="text" value="<?=$row['Gdate']?>">



				<tr valign="top">
					<td width="100%" colspan="2"><div align="center" class="err" id="error" style="display:none"></div>
						<?php if($msg != '')
								echo '<div align="center" class="alert" style="font-size:13; id="error1">'.$msg.'</div>';
						?>
					</td>
				</tr>
			
				<tr class="Trow">
					<td width = "40%">Customer Name: </td>
					<td><input type="text" size="30" name="Name" readonly="true" class="text"  value="<?=$row['Name']?>"></td>
				</tr>
				
	
				<tr class="Trow">
					<td>Generated Date: </td>
					<td><input type="text" size="30" name="Generateddate" class="text"  value="<? echo "$Gdate_array[1]/$Gdate_array[2]/$Gdate_array[0]";?>"></td>
				</tr>
				
				<tr class="Trow">
					<td>Invoice Number: </td>
					<td><input type="text" size="30"  class="text" name="invoice" readonly = "true" value = "MO  <?  echo substr($Gyear,2,2). '/' .$row['Invoiceno'];  ?>"></td>
				</tr>
				
				<tr class="Trow">
				<td>Total: </td>
					<td><input type="text" size="30"  class="text" name="Total" readonly = "true" value="<?=$row['Total']?>"></td>
				</tr>
				
				<tr class="Trow">
					<td>PO: </td>
					<td><input type="text" size="30"  class="text" name="PO" value="<?=$row['PO']?>"></td>
				</tr>
				
				<tr class="Trow">
					<td>Status: </td>
					<td>
					<?php if($row['Status'] == "Paid"){
					?>
                        <input type = "radio" name = "Status" id= "Status" value = "Paid" checked = "checked">Paid
                        <input type = "radio" name = "Status" id= "Status" value = "Unpaid">Unpaid
					<?
					}	
					else{
					?>
						<input type = "radio" name = "Status" id= "Status" value = "Paid">Paid
                        <input type = "radio" name = "Status" id= "Status" value = "Unpaid" checked = "checked">Unpaid
					<?php }
					?>
                    </td>
				</tr>
				
			</table>
			
			<br /><br />
			
			</form>	
		
        
        </td></tr>
            
            <tr><td class="t-bot2"><a href="javascript: document.myForm.submit();"  onClick = "validate()">Modify</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href = "<?php echo $_SESSION['returnLink']; ?>">Return</a></td>
            </tr>
        </table>

		<? 
		}
		?>
        

</td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>
  
</td></tr></table>
   <? include ('tpl/footer.php'); ?>
   

<script type="text/javascript">

function validate(){

	if(!confirm("Are you sure you want to continue?"))  return;
	
	var theform = document.myForm;
	var name = theform.Name.value;
	
	var error = "";
	
	// Error Checking

	if(name == "")  {
		error += "<br>Required fields cannot be left blank";
	}
	
	if(error!=""){
		document.getElementById("error").innerHTML = "Please correct the following errors<br>" + error;
		showRow("error");
	}
	
	else{
		document.myForm.submit();
	}
	
}

function showRow(id){
	document.getElementById(id).style.display = "";
}

function hideRow(id){
	document.getElementById(id).style.display = "none";

}
</script>