

<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	if($class != 1){
		header('Location: login.php');
	}
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
	include_once(DOCUMENT_ROOT."includes/buildViewComponent.class.php");
	
	
 ?>

 
<table border="0" cellpadding="0" cellspacing="0" width="100%">   
	<tr>
		<td class="body" valign="top" align="center">
		     
			<table border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td class="body_resize">
					
				    	<table border="0" cellpadding="0" cellspacing="0" align="left">
							<tr>
								<td class="left" valign="top">
							         <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?> 
						      	</td>
								<td class="left" valign="top" align="left">
									
										<h2 class = "Our"><img src = "images/h2_servises.gif" style="margin-right:10px; vertical-align:middle">Emails</h2>
									
									
										<br/><br/>
										<a href='javascript: EmailAll()'>Email All</a>
										
										<br/><br/>
										
										<a href='javascript: inst()'>Email Instrument List</a>

										
										<select id='instlist' class='hide' >
<?	
		 include_once('constants.php');
		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DBbb");

	//retrieve instrument name, number list
	$sql13 = "SELECT InstrumentName, InstrumentNo FROM instrument";
	$values=mysql_query($sql13) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	//$row33 = mysql_fetch_array($values); 
	$instcount=0;
	while($row33 = mysql_fetch_array($values))
	{
		$instlist[$instcount]=$row33['InstrumentName'];
		$instnolist[$instcount]=$row33['InstrumentNo'];
		//	echo $instlist[$instcount];
		//	echo "\n";
		$instcount++;
	}
	$jj=0;
	while($jj<=$instcount)
	{
		echo "<option>";
		echo $instlist[$jj];
		echo "</option>";
		$jj++;
	}
?>
										</select>
										<input type="button" name="go" id="go" onClick="javascript: sel()" value="GO"  class="hide">
										<br/>
	<a href='javascript: EmailAllInstrStatus()'>Email All-Instruments Status</a>
	<br/><br/>
	<a href='javascript: EmailAnnually()'>Email Annually to Retain Active Status</a>
									
								</td>
							</tr>
						</table>
						 
					    <div class="clr">
						</div>
					</td>
				</tr>
			</table>
			
		</td>
	</tr>
</table>
  
<script type="text/javascript">
var counter=0;
function inst()
{
<? $EmailAlllistSelected=0;?>
counter++; 
document.getElementById("instlist").style.visibility="visible";
document.getElementById("go").style.visibility="visible";
if (counter>1)
{
	//sel();
}
}


function sel()
{

var no=document.getElementById("instlist");
var InstSelected=no.options[no.selectedIndex].text;
//document.getElementById("EmailAlllistSelected").value="<?=$EmailAlllistSelected=0?>";
//alert ("lo"+InstSelected);


window.open ('Email.php?all=2&inst='+InstSelected, 'newwindow', config='height=400,width=490, scrollbars=1, menubar=no,location=no, directories=no, status=no');
}

function EmailAll() //All=1
{
<? $EmailAlllistSelected=1;?>

window.open ('Email.php?all=1', 'newwindow', config='height=400,width=490,toolbar=no, scrollbars=1, menubar=no,location=no, directories=no, status=no');
}

function EmailAllInstrStatus()
{


window.open ('EmailInstrStatus.php', 'newwindow', config='height=400,width=490,toolbar=no, scrollbars=1, menubar=no,location=no, directories=no, status=no');
}


function EmailAnnually()
{


window.open ('EmailAnnually.php', 'newwindow', config='height=400,width=490,toolbar=no, scrollbars=1, menubar=no,location=no, directories=no, status=no');
}
</script>







</td></tr></table>
   <? include ('tpl/footer.php'); ?>