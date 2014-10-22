<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	include_once("includes/action.php");
?>
<script type="text/javascript">


function viewMachine(){

var machine = "<?php echo $_GET['id']; ?>"

var xmlHttp = checkajax();
   
   xmlHttp.onreadystatechange=function() {

	   if(xmlHttp.readyState!=4)
			document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

       if(xmlHttp.readyState==4) {
		   document.getElementById("error").innerHTML = "&nbsp";
		   document.getElementById("div1").innerHTML = xmlHttp.responseText;
	   }
   }
	xmlHttp.open("GET","modifyinstrument.php?MachineName="+machine+"&submit=submit1" ,true);
     xmlHttp.send(null);   
}


function modifyInstrument(){

if(!confirm("Are you sure you want to continue?"))  return;

var theform = document.myform_sub;
var instrument_no = theform.instrument_no.value;
var machine_name = theform.machine_name.value

var usc_with_cemma = theform.usc_with_cemma.value;
var cemma_unit = theform.cemma_unit.value
//var usc_with_cemma_unit = theform.usc_with_cemma_unit.value;

var usc_without_cemma = theform.usc_without_cemma.value;
//var usc_without_cemma_unit = theform.usc_without_cemma_unit.value;

var off_with_cemma = theform.off_with_cemma.value;
//var off_with_cemma_unit = theform.off_with_cemma_unit.value;

var off_without_cemma = theform.off_without_cemma.value;
//var off_without_cemma_unit = theform.off_without_cemma_unit.value;

var industry_with_cemma = theform.industry_with_cemma.value
var industry_without_cemma = theform.industry_without_cemma.value
//var commerical_unit = theform.commerical_unit.value

var comments = theform.comments.value;
var error = "&nbsp;";
var availibility = 0;
var DisplayOnStatusPage="Yes";
var InstrumentType=theform.InstrumentType.value
//var displayOnStatusPage=theform.displayOnStatusPage.value;

var trainingRate = theform.trainingRate.value;
var DisplayOnPricingPage = 1;

if (theform.availibility[0].checked)
availibility = 1;
	if (theform.DisplayOnStatusPage[0].checked)
		DisplayOnStatusPage = "Yes";
	else
		DisplayOnStatusPage = "No";
	
	if (theform.DisplayOnPricingPage[0].checked)
		DisplayOnPricingPage = 1;
	else
		DisplayOnPricingPage = 0;


if(machine_name == ""){
	error = "Machine name cannot be left blank";
	document.getElementById("error").innerHTML = error;
	return
}


else if(isNaN(usc_with_cemma) ||  isNaN(usc_without_cemma) || isNaN(off_with_cemma) || isNaN(off_without_cemma) || isNaN(industry_with_cemma) || isNaN(industry_without_cemma)){
	error = "\nInvalid Rates";
	document.getElementById("error").innerHTML = error;
	return
	
}
else if(usc_with_cemma < 0 || usc_without_cemma < 0 || off_with_cemma < 0 || off_without_cemma < 0 || industry_without_cemma < 0 || industry_with_cemma < 0){
	error = "\nInvalid Rates";
	document.getElementById("error").innerHTML = error;
	return
}

else if(usc_with_cemma == "" || usc_without_cemma == "" || off_with_cemma  == "" || off_without_cemma == "" || industry_with_cemma == "" || industry_without_cemma == ""){
	error = "\nInvalid Rates";
	document.getElementById("error").innerHTML = error;
	return
}
var xmlHttp = checkajax();
   
   xmlHttp.onreadystatechange=function() {
      
  if(xmlHttp.readyState!=4)
			document.getElementById("error").innerHTML = "<img src = images/busy.gif>";


	   
  if(xmlHttp.readyState==4) {

				   document.getElementById("error").innerHTML = "&nbsp";
				   document.getElementById("error").innerHTML = "&nbsp";
				   document.getElementById("alert").innerHTML = machine_name + ' has been modified successfully';
				   document.getElementById("alert").style.display = "";
				   viewMachine();
					
				   
   
   }
   }
   
	xmlHttp.open("GET","modifyinstrument.php?machine_name="+machine_name+"&instrument_no="+instrument_no+"&usc_with_cemma="+usc_with_cemma+"&cemma_unit="+cemma_unit+"&usc_without_cemma="+usc_without_cemma+"&off_with_cemma="+off_with_cemma+"&off_without_cemma="+off_without_cemma+"&industry_with_cemma="+industry_with_cemma+"&industry_without_cemma="+industry_without_cemma+"&comments="+comments+"&availibility="+availibility+"&DisplayOnStatusPage="+DisplayOnStatusPage+"&DisplayOnPricingPage="+DisplayOnPricingPage+"&InstrumentType="+InstrumentType+"&trainingRate="+trainingRate+"&submit1=submit1" ,true);
     xmlHttp.send(null);
}


function deleteInstrument(){

var theform = document.myform;
var machine_name = theform.machine_name.value;

var xmlHttp = checkajax();
   
   xmlHttp.onreadystatechange=function() {

	   if(xmlHttp.readyState!=4)
			document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

       if(xmlHttp.readyState==4) {
	   
	   document.getElementById("error").innerHTML = "&nbsp";
	   document.getElementById("div1").innerHTML = '<span align="center" class="left" style="color: #FF6600;">' + xmlHttp.responseText + '</span>';
	   i=0;
	   document.getElementById("MachineName").length = 0;
	   document.getElementById("MachineName").options[i++] = new Option("Select the Machine");

		<?
		$sql = "SELECT machine_name FROM rates";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
		?>
		document.getElementById("MachineName").options[i++] = new Option("<? echo $row['machine_name']; ?>", "<? echo $row['machine_name']; ?>");
		<?
		}
		?>	   
   }
   }
	xmlHttp.open("GET","modifyinstrument.php?MachineName="+machine_name+"&submit2=submit2" ,true);
     xmlHttp.send(null);   
}


function checkajax() {
   var xmlHttp;
   try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
     } catch (e) {
        // Internet Explorer
        try {
          xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
       } catch (e) {
          try {
               xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
               alert("Your browser does not support AJAX!");
               return false;
            }
       }
     }
   
   return xmlHttp;
  }

function showMachine(machine){

var xmlHttp = checkajax();
   
   xmlHttp.onreadystatechange=function() {
       if(xmlHttp.readyState==4) {
	   
	   document.getElementById("div1").innerHTML = xmlHttp.responseText;
	   
   }
   }
	xmlHttp.open("GET","viewinstrument.php?MachineName="+machine ,true);
     xmlHttp.send(null);   
}

</script>
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
                                            <td class="t-top"><div class="title2">Modify Instruments</div></td>
                                        </tr>
										
                                       
										<tr>
                                            <td class="t-mid">
											<table width="100%" border="0" cellpadding="5" cellspacing="0">
												<tr valign="top">
												<td width="100%"><div align="center" class="err" id="error" style="display:none"></div>
													<div align="center" class="alert" style="font-size:13;display:none" id="alert"></div></td>
												</tr>
											</table>
											
											
											<div id="div1">
                                                    <p>&nbsp;</p>
                                                </div></td>
                                        </tr>
                                        <tr>
                                            <td class="t-bot2"><? echo '  <a style="cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;" onClick = "modifyInstrument()"> Modify Instrument</a>&nbsp;&nbsp;<a href = "instruments.php" style="cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;"> Return</a>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   '; ?></td>
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
<script type="text/javascript">
viewMachine();
</script>
<? include ('tpl/footer.php'); ?>
