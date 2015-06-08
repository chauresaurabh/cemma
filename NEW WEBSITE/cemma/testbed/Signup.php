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
    <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="left"><tr>
      
       <td>
                
        <h2 class = "Our"><img src = "images/h2_servises.gif" style="margin-right:10px; vertical-align:middle">Sign Up</h2>
		

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

<table>
	<tr class= "Trow">

<?
	include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
	$sql13 = "select InstrumentName from instrument, instr_group, user where user.UserName = '".$_SESSION['login']."' and instr_group.Email=user.Email and instrument.InstrumentNo = instr_group.InstrNo order by InstrumentName";
	$values=mysql_query($sql13) or die("An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
?>			
                                                           <!-- <td>Type:</td> -->
														    <td></td> 
														    <td>Instrument:     </td> 
                                                            <td>
																<select name="instrumentselected" id="instrumentselected">
																<option value="none">--Select One Instrument--</option>
																<?  while($row = mysql_fetch_array($values))
	{
	?>
		<option value="<? echo $row['InstrumentName']; ?>" ><?=$row['InstrumentName']?></option>
<?		
	}
?>
</select>
</td>
</tr>
<tr class= "Trow">
	<? //Calculate Current Weeks

	$dayofweek=date("w");
$dayofweek=$dayofweek-1;
//   echo "ee-".date("W");
  // echo "date-".date("Y-F-j");
  $date=date("Y-m-j");
  //echo "dayofweek".$dayofweek;
   $newdate = strtotime ( 'last monday' , strtotime ( $date ) ) ;
	$newdate = date ( 'Y-m-j' , $newdate );

	  $newdate11 = strtotime ( 'last monday' , strtotime ( $date ) ) ;
	$newdate11 = date ( '-- M d, Y --' , $newdate11 );
$newdate2[0]=$newdate;
$newdate112[0]=$newdate11;
//echo "new-".$newdate."<br>";
$k=0;
for($i=1;$i<12;$i++)
{
	$newdate = strtotime ( '+7 day' , strtotime ( $newdate ) ) ;
	$newdate = date ( 'Y-m-j' , $newdate );
	$newdate2[$i] =$newdate;

	$newdate11 = strtotime ( '+7 day' , strtotime ( $newdate11 ) ) ;
	$newdate11 = date ( '-- M d, Y --' , $newdate11 );
	$newdate112[$i] =$newdate11;
//	echo "new2-".$newdate2[$i]."new-".$newdate."<br>";
	$k++;

}

?>
<td></td> 
<td>Week:        </td> 

   <td>		
   <select name="weekselected">

<?
for($i=0;$i<12;$i++)
{
//	$newdate3 = date ( 'm-d-Y' , $newdate2[$i] );
	?>
<option value="<?echo $newdate2[$i];?>"><? echo $newdate112[$i];?></option>
<?

}
?>
   <!--
   <option value="0">--- Feb 14, 2011 ---</option><option value="7">--- Feb 21, 2011 ---</option><option value="14">--- Feb 28, 2011 ---</option><option value="21">--- Mar 07, 2011 ---</option><option value="28">--- Mar 14, 2011 ---</option><option value="35">--- Mar 21, 2011 ---</option><option value="42">--- Mar 28, 2011 ---</option><option value="49">--- Apr 04, 2011 ---</option><option value="56">--- Apr 11, 2011 ---</option><option value="63">--- Apr 18, 2011 ---</option><option value="70">--- Apr 25, 2011 ---</option><option value="77">--- May 02, 2011 ---</option>
   -->
   </select>
		</td>

</tr>
<tr>
<td></td>
<td>
<input value="Continue" type="submit" align="center"><input value=" Reset " type="reset">

</tr>
</td>
</table>
<?








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

   
   

