<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
 ?>
<?php
	if(isset($_POST['Availablity'])){
		$rs = new InstrumentDAO();
		echo($rs->update($_GET['id'],$_POST));	
		$mode = "Update";
	}
	else{
				
		$rs = new InstrumentDAO();
		$rs->getSingleRecord($_GET['id']);
		while($row1 = $rs->fetchSingleRecord()){
			$row = $row1;
		}
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
                    <tr valign="top">
                      <td width="100%"><div align="center" class="err" id="error" style="display:none"></div>
                        <div align="center" class="alert" style="font-size:13;display:none" id="alert"></div></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td class="t-top"><div class="title2"><?php echo (($_GET['submit_mode'] == 'add') ? 'Add ': 'Edit ');?>Instrument</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
                        <form id="myForm" name="myForm" method="post" action="editInstrument.php?id=<?=$_GET['id']?>">
                          <table class="content" align="center" width="450" border = "0">
                            <tr class = "table1bg">
                              <td width = "40%">Instrument Name: </td>
                              <td><input type="text" size="30" name="InstrumentName" readonly="true" class="text"  value="<?=$row['InstrumentName']?>"></td>
                            </tr>
                            <tr>
                              <td>Comment: </td>
                              <td><input type="text" size="30" name="Comment" class="text"  value="<?=$row['Comment']?>"></td>
                            </tr>
                            <tr>
                              <td>Availablity: </td>
                              <td><input type="text" size="30"  class="text" name="Availablity" value="<?=$row['Availablity']?>"></td>
                            </tr>
                          </table>
                          <br />
                          <br />
                        </form></td>
                    </tr>
                    <tr>
                      <td class="t-bot2"><a href="javascript: document.myForm.submit();"  onClick = "validate()">Modify</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:  history.go(-1);">Cancel</a></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <div class="clr"></div></td>
        </tr>
      </table></td>
  </tr>
</table>
</td>
</tr>
</table>
<? include ('tpl/footer.php'); ?>

<script type="text/javascript">
function validate(){

	if(!confirm("Are you sure you want to continue?"))  return;
	
	var theform = document.myForm;
	var name = theform.InstrumentName.value;
	
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
