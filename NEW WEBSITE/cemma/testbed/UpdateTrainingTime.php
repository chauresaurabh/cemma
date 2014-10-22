<form id="myForm" name="myForm" action="UpdateTrainingTime.php" style="11px/1.6em Tahoma,Geneva,sans-serif">

<input type="hidden" name="submitForm" value="true" />

 <input type="hidden" name="userEmailId" value="<?= $_GET['email'] ?>" />
 <input type="hidden" name="username" value="<?= $_GET['username'] ?>" />
 <input type="hidden" name="personLoggedIn" value="<?= $_GET['personLoggedIn'] ?>" /> 
  Enter Total Training Hours :  <input type="text" name="totalTrainingHrs" />
 <input type="submit"  value="Add Training Time"  />
   
   <select id="instrument_name" name="instrument_name" style="font-weight:normal" ></select>
   
   
    <?
						  		include_once('constants.php');
					 
					 		    $submitForm = $_GET['submitForm'];
								$username = $_GET['username'];
								$totalTrainingHrs = $_GET['totalTrainingHrs'];
								
								$userEmailId = $_GET['userEmailId'];

								$instrumentNo = $_GET['instrument_name'];
									
								$personLoggedIn = $_GET['personLoggedIn'];
						   		if( $submitForm=='true'){
								$date = date('Y-m-d H:i:s');
						 include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
					$sql3 = "UPDATE instr_group SET TotalTrainingHrs = '$totalTrainingHrs', 
					UsedTrainingHrs='$totalTrainingHrs' , personLoggedIn = '$personLoggedIn' , requested_date='$date' WHERE Email = '$userEmailId' AND InstrNo=".$instrumentNo;
 			 		mysql_query($sql3) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
 				//echo $sql3;
  					echo "<center>Training Hours : ".$totalTrainingHrs ." successfully updated for User : ". $username ."</center>";
		
 								}
	 ?>
     
 </form>
   
   <script type="text/javascript">
   
 <?
 	
	$dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";
	$emailId = $_GET['email'];
	
	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
	
	// FOR INSTRUMENTS
	$sql2 = "select InstrumentNo, InstrumentName from instrument, instr_group where InstrumentNo=InstrNo and Email='".$emailId."'order by InstrumentNo";
	 
	$result2 = mysql_query($sql2);
	//$value = mysql_num_rows($result);
	$j=1;
 	 ?>
document.getElementById("instrument_name").options[0]=new Option("<? echo "-- Select Instrument to Add Training Hours --" ?>");
document.getElementById("instrument_name").options[0].value=0;

	<?
	while($row2=mysql_fetch_array($result2)){?>
	//bug here .. because if a policy is deleted completely .. then a blank row in drop down will be created
 document.getElementById("instrument_name").options[<? echo $j?>] = new Option("<? echo $row2['InstrumentName']?>");
 document.getElementById("instrument_name").options[<? echo $j?>].value = "<? echo $row2['InstrumentNo']?>";
 	<?	
		$j+=1;
	}
 	
?>
</script>

     