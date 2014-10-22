<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//	header('Location: login.php');
	}
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
                
        <h2 class = "Our"><img src = "images/h2_servises.gif" style="margin-right:10px; vertical-align:middle">Cancel</h2>
		

		<form action = "" method="post" name="myForm">
		<input type="hidden" name = "o" id = "o" value = "<?=$_POST['o']?>">
		<input type = "hidden" name="orderby" id = "orderby" value = "<?=$_POST['orderby']?>">
		
		<? //Check if user has asked to remove a record
			
			$msg = '';
			if(isset($_GET['action']) && $_GET['action'] == 3){
				$rm = new userDAO();
				$rm->remove($_GET['id']);
				$msg = "Instrument has been removed successfully";
			}
			

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
$date=date("Y-m-d");

  $newdate = strtotime ( 'last monday' , strtotime ( $date ) ) ;
	$newdate = date ( 'Y-m-d' , $newdate );
$today=$newdate;
$todaydate=date("Y-m-d");

?>
<table border=1>
<tr>
You have signed up: (from <?echo date("m/d/Y"); ?>) </h3><div align="center"><center>

</tr>
<tr>
</tr>
<tr class= "Trow">
    	<td width="250"><b>Instrument name</b></td>
    	<td width="110"><b>Date</b></td>
    	<td width="130"><b>Time</b></td>
    	<td width="100"><b>Cancel</b></td>

</tr>

<?


$login=$_SESSION['login'];
	include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
	$sql13 = "select InstrumentName, Date, Slot from schedule where UsedBy = '$login' and Date>='$todaydate'";
	$values=mysql_query($sql13) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	while($row = mysql_fetch_array($values))
	{
		if ($row['Slot'] == 1)
		{
			$timeslot= "8 am - 9 am\n";
		}
		else if ($row['Slot'] == 2)
		{
			$timeslot= "9 am - 10 am\n";
		}
		else if ($row['Slot'] == 3)
		{
			$timeslot= "10 am - 11 am\n";
		}
		else if ($row['Slot'] == 4)
		{
			$timeslot= "11 am - 12 pm\n";
		}
		else if ($row['Slot'] == 5)
		{
			$timeslot= "1 pm - 2 pm\n";
		}
		else if ($row['Slot'] == 6)
		{
			$timeslot= "2 pm - 3 pm\n";
		}
		else if ($row['Slot'] == 7)
		{
			$timeslot= "3 pm - 4 pm\n";
		}
		else if ($row['Slot'] == 8)
		{
			$timeslot= "4 pm - 5 pm\n";
		}
		else if ($row['Slot'] == 9)
		{
			$timeslot= "5 pm - 7 pm\n";
		}
		else if ($row['Slot'] == 10)
		{
			$timeslot= "7 pm - 9 pm\n";
		}
		else
		{
			$timeslot= "9 pm - 8 am\n";
		}


		echo "<tr>";
echo "<td>".$row['InstrumentName']."</td><td>".$row['Date']."</td><td>".$timeslot."</td>";
echo "<td>";
echo "<a href='DeleteSchedule.php?instrname=".$row['InstrumentName']."&login=".$login."&Date=".$row['Date']."&Slot=".$row['Slot']."'>Cancel</a></td>";
echo "</tr>";
	}

?>
</tr>
</table>
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

   
   

