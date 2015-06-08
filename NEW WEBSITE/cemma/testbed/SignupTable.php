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
                
        <h2 class = "Our"><img src = "images/h2_servises.gif" style="margin-right:10px; vertical-align:middle">Sign Up</h2>
		

		<form action = "SignupAdddata.php" method="post" name="myForm">
<input type="hidden" name = "instrumentselected" id = "instrumentselected" value = "<?=$_POST['instrumentselected']?>">		
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

<table>

</table>
<?


//echo "instrumentselected".$_POST['instrumentselected'];
//echo "weekselected".$_POST['weekselected'];


?>

	<h4> Instrument: <? echo $_POST['instrumentselected']; ?></h4>

	<div align="center">
  	<center>
  	Sign up limit, 4 hrs. of peak time and <span style="background-color: #C0C0C0">8 hrs. of off-peak time</span> in advance

 <table border="3" cellpadding="3" cellspacing="3">
 <tr>

<td>Timeslot</td>
<? $newdate=$_POST['weekselected'];
$firstdate=$_POST['weekselected'];
$datetitle=$_POST['weekselected'];
//echo " wwee-".$_POST['weekselected'];
$k=0;
$newdate=strtotime ( '+0 day' , strtotime ( $newdate ) ) ; 
$newdate = date ( 'Y-m-d' , $newdate );
$datetitle=strtotime ( '+0 day' , strtotime ( $datetitle ) ) ; 
$datetitle = date ( 'M d l' , $datetitle );
$dates[$k++]=$newdate;
$instr_name=$_POST['instrumentselected'];
?>

<td><?echo $datetitle; ?></td>
<?

for($i=0;$i<6;$i++)
{
	$newdate=strtotime ( '+1 day' , strtotime ( $newdate ) ) ; 
	$newdate = date ( 'Y-m-j' , $newdate );

	$datetitle=strtotime ( '+1 day' , strtotime ( $datetitle ) ) ; 
	$datetitle = date ( 'M d l' , $datetitle );

	$dates[$k++]=$newdate;
?>	<td><?echo $datetitle;?></td>
<?
	$lastdate=$newdate;
}
?>
 </tr>
<?
//echo "X-".$newdate;
//echo "X-".$lastdate;

	for ($i = 1; $i <= 11; $i++)
	{
		
		echo "<tr>";	
		echo "<td width=\"120\">";	
		if ($i == 1)
		{
			echo "8 am - 9 am\n";
		}
		else if ($i == 2)
		{
			echo "9 am - 10 am\n";
		}
		else if ($i == 3)
		{
			echo "10 am - 11 am\n";
		}
		else if ($i == 4)
		{
			echo "11 am - 12 pm\n";
		}
		else if ($i == 5)
		{
			echo "1 pm - 2 pm\n";
		}
		else if ($i == 6)
		{
			echo "2 pm - 3 pm\n";
		}
		else if ($i == 7)
		{
			echo "3 pm - 4 pm\n";
		}
		else if ($i == 8)
		{
			echo "4 pm - 5 pm\n";
		}
		else if ($i == 9)
		{
			echo "5 pm - 7 pm\n";
		}
		else if ($i == 10)
		{
			echo "7 pm - 9 pm\n";
		}
		else
		{
			echo "9 pm - 8 am\n";
		}
		echo "</td>\n";

		# query the date with the specified slot
	include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
	$sql13 = "select Date, UsedBy from schedule where InstrumentName = '$instr_name' and Slot = '$i' and Date >= '$firstdate' and Date < '$lastdate' order by Date";
	$values=mysql_query($sql13) or die("An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 

	$count = 0;
		$k=0;
		while($row = mysql_fetch_array($values))
		{
			$datesigned[$count]=$row['Date'];
			$usedby[$count]=$row['UsedBy'];
			
			$count++;

		}
		$j=0;
		for($k=0;$k<7;$k++)
		{	
		//	echo "<br/> ZZZZZZZZZZ".$dates[$k]."----".$datesigned[$j];
			if($dates[$k]==$datesigned[$j] && $j<$count)
			{
				//echo "PPPPP-->".$datesigned[$j];
//echo "".$i."-".$usedby[$count]."-".$datesigned[$count]."--".$dates[$i]."<br>";
			echo "<td>";
			echo $usedby[$j];
			
			if ($_SESSION['ClassLevel']==1 || $_SESSION['ClassLevel']==2)
				{
				echo "<br/><a href='ReserveInstrument.php?instr=$instr_name&usedby=$usedby[$j]&slot=$i&datesigned=$datesigned[$j]'>Reserve</a>";
				}

			echo "</td>";
			$j++;

			
			}
			else
			{	
				$slotname = $i."_".$dates[$k];

				//echo "<td><input type='checkbox' name='$slotname' value='on'></td>";	
				echo "<td><input type='checkbox' name='slots[]' value='$slotname'></td>";	
			}
			
			
		}
		
		if ($i == 4)
		{
			# for slot : 12 pm to 1 pm
			echo "<tr>\n";
			echo "	   <td width =\"120\" bgcolor=\"#808080\">\n";
			echo "12 pm - 1 pm </td>";			
			echo "	   <td bgcolor=\"#808080\" colspan=\"7\"><p align=\"center\">\n";
			echo "THIS PERIOD IS RESERVED ON A FIRST COME FIRST SERVE BASIS. THE MORNING USER CAN CONTINUE IF NO ONE ARRIVES TO USE THE INSTRUMENT.</p>\n";
			echo "    </td>\n";
			#echo "	   <td width=\"120\" bgcolor=\"#C0C0C0\">&nbsp;</td>";
			#echo "	   <td width=\"120\" bgcolor=\"#C0C0C0\">&nbsp;</td>";			
			echo "</tr>";		
		}
		
			echo "</tr>\n";
			
	}
	?>

</table>

<input value="Continue" type="submit" align="center"><input value=" Reset " type="reset">
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

   
   

