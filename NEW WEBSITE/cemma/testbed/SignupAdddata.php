<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	//if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
//		$van=1;
//	$date=date("Y-m-j");
//	$newdate = strtotime ( 'last monday' , strtotime ( $date ) ) ;
//	$newdate = date ( 'Y-m-j' , $newdate );
//echo "new-".
		//header('Location: SignupTable.php?weekselected='.$newdate.'&instrumentselected='.$_POST['instrumentselected']);
		header('Location: Signup.php');
	
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/instrument_action.php")
 ?>
 
     <table border="0" cellpadding="0" cellspacing="0" width="100%">   
	
	<tr><td class="body" valign="top" align="center">
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="left"><tr><td class="left" valign="top">
		

         <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?> 
		 
      	</td>
      
       <td>
                
        <h2 class = "Our"><img src = "images/h2_servises.gif" style="margin-right:10px; vertical-align:middle">Instrument has been reserved successfully</h2>
		

		<form action = "SignupTable.php" method="post" name="myForm">
		<input type="hidden" name = "o" id = "o" value = "<?=$_POST['o']?>">
		<input type = "hidden" name="orderby" id = "orderby" value = "<?=$_POST['orderby']?>">
		
		<? //Check if user has asked to remove a record
			/*
			$msg = '';
			if(isset($_GET['action']) && $_GET['action'] == 3){
				$rm = new userDAO();
				$rm->remove($_GET['id']);
				$msg = "Instrument has been removed successfully";
			}
			
*/
		?>
			
		
		<table width="100%" border="0" cellpadding="5" cellspacing="0"> 
                    <tr valign="top"> 
                      <td width="100%"> 
						<div align="center" class="err" id="error" style="display:none">Error Detected</div>
						<? if($msg != '')
							echo '<div align="center" class="alert" style="font-size:13; id="error1">'.$msg.'</div>';
						?>
						<div id = "div1" style="display:none"><p>&nbsp;</p></div>
					</td>
				</tr> 
        </table>


<?



$login=$_SESSION['login'] ;
$instr_name=$_POST['instrumentselected'];
$date=date("Y-m-j");
//echo "date-".$date;
$count=count($_POST['slots']);
//echo "count-".$count;


for($i=0;$i<$count;$i++)
{
	$pieces = explode("_", $_POST['slots'][$i]);
$slot=$pieces[0]; // piece1
$dateselected=$pieces[1];
	//echo "slot-".$slot.",".$dateselected."<br>";

	include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
	 $query ="insert into schedule (InstrumentNo, InstrumentName, Date, Slot, Status, UsedBy) values('0', '$instr_name', '$dateselected', '$slot', '1', '$login')";
	 mysql_query($query) or die( "An error has occurred in query1: "); 
}




?>
 
		</form>
		
        
      </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>
  
</td></tr></table>

<script language='javascript'>
function wopen(url, name, w, h)
{
// Fudge factors for window decoration space.
 // In my tests these work well on all platforms & browsers.
//w += 32;
//h += 96;
/*
 var win = window.open(url,
  name,
  'width=' + w + ', height=' + h + ', ' +
   'toolbar=no, scrollbars=1, menubar=no,location=no, directories=no, status=no'');
 win.resizeTo(w, h);
 win.focus()*/

 window.open ('EmailInstrStatus.php', 'newwindow', config='height=400,width=490, scrollbars=1, menubar=no,location=no, directories=no, status=no');
}
</script>
   <? include ('tpl/footer.php'); ?>

   
   

