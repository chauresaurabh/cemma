<form id="myForm" name="myForm" action="AddInstruments.php" style="11px/1.6em Tahoma,Geneva,sans-serif">

<input type="hidden" name="submitForm" value="true" />
 <input type="hidden" name="userId" value="<?= $_GET['userId'] ?>" />

<table width=\"250\">

						  <?
						  include_once('constants.php');
						  						 include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

							    $submitForm = $_GET['submitForm'];
								$Email = $_GET['userId'];
						   		if( $submitForm=='true'){
											$permission = $_GET['Permission'];
											$InstrumentName=$_GET['InstrumentName'];
											$countInstrumentName = count($InstrumentName);
										 
				$sql3 = "UPDATE user SET Passwd = '$password', Email='$Email',Class='$adminclass', FirstName='$FirstName', LastName='$LastName',Name = '".$FirstName." ".$LastName."', Telephone='$Telephone', Dept='$Dept', Advisor='$Advisor',GradYear='$GradYear', Position='$position',Prevent='$prevent', FieldofInterest ='$fieldofinteresttosave',UserClass='$UserClass',Comments='$Comments', AccountNum='$AccountNum'  WHERE UserName = '$username'";
		
		#echo $sql3;
		mysql_query($sql3) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 

		$sql123 = "DELETE FROM instr_group WHERE Email='$Email'  ";  
			#echo $permission[$k]."<br>";
			#echo $sql3."<br>";
			mysql_query($sql123) or die( "An error has ocured in query2: " .mysql_error (). ":" .mysql_errno ()); 
		
		echo "<center>You have successfully updated the User</center>";


	 for ($i=0;$i<$countInstrumentName ; $i++)
				{ 
					//echo "pop".$InstrumentName[$i];
					$pieces = explode("_", $InstrumentName[$i]);
					$intruments[$i]=$pieces[0];
					$k=$pieces[1];
		
					//echo " instr-".$intruments[$i];
					$instrno=$intruments[$i];
					$t1="yy".$k;
				$t2="mm".$k;
				$t3="dd".$k;
				//echo " yy-mm-dd ".$_POST[$t1]." ".$_POST[$t2]." ".$_POST[$t3];
				$yy=$_GET[$t1];
				$mm=$_GET[$t2];
				$dd=$_GET[$t3];
				$datetoput=$yy."-".$mm."-".$dd;
 							include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
			$sql3 = "INSERT INTO instr_group (InstrNo,  Email , InstrSigned, Permission) VALUES ('$instrno', '$Email', 		'$datetoput', '$permission[$k]')";  
			#echo $permission[$k]."<br>";
			#echo $sql3."<br>";
			mysql_query($sql3) or die( "An error has ocured in query2: " .mysql_error (). ":" .mysql_errno ()); 

				}
								 echo 'Instrument Updated';
		
								}
						  	include_once('constants.php');
							include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
							    $userId = $_GET['userId'];
 							$sql1 = "select * from instr_group where Email ='".$userId."'";
							$result=mysql_query($sql1) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
 							$i=0;
 							while($row3 = mysql_fetch_array($result))
							{
								$instrnos[$i]=$row3['InstrNo'];
								$instrsigned[$i]=$row3['InstrSigned'];
								$permission[$i] = $row3['Permission'];
							//	echo "N".$instrnos[$i];
							//	echo 'lol';
															echo $instrnos[i];

								$i++;
							}
							include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
							$sql1 = "select InstrumentNo, InstrumentName from instrument";
							$result=mysql_query($sql1) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
 							$no=0;
							while($row2 = mysql_fetch_array($result))
							{
								$checked1='';
								//echo "-";
								for($j=0;$j<$i;$j++)
								{
									if($row2['InstrumentNo']==$instrnos[$j])
									{
										$checked1='checked';
										break;
										
									}
								}	
								//if($checked1=='')
									//continue;	
						?>	
							<tr>
								<td width='180'> <input type="checkbox" name="InstrumentName[]" id="InstrumentName" <? echo $checked1; ?> value="<?=$row2['InstrumentNo']?>_<?=$no?>" <? //echo $row['InstrumentName']; ?> onclick="setInstrDate(this, <?=$no?>);"/>&nbsp; <? echo $row2['InstrumentName']; ?></td>
								<td width='170'>Date: (mm/dd/yyyy)<br>
						<?
								#echo "##".$permission[$j];
								$pieces = explode("-", $instrsigned[$j]);
								$yy=$pieces[0]; //yy
								$mm=$pieces[1]; //mm
								$dd=$pieces[2]; //dd
						?>
						<input type="text" name="mm<?=$no?>" id="mm<?=$no?>"  value="<?=$mm?>" size="2">
						<input type="text" name="dd<?=$no?>" id="dd<?=$no?>" value="<?=$dd?>" size="2">
						<input type="text" name="yy<?=$no?>" id="yy<?=$no?>" value="<?=$yy?>" size="4">
						<select name='Permission[]'>										
						<option <?if($permission[$j]=="Peak") echo "selected='selected'"?> value='Peak'>Peak time only</option>
						<option <?if($permission[$j]=="Off-Peak") echo "selected='selected'"?> value='Off-Peak'>Peak & Off-peak time</option>
									</select>
								</td>
							</tr>
						<?
								$no++;
							}
						?>

	
								 </table>
<input type="submit"  value="Update Instrument"  />
   
                       </form>
                       
<script type="text/javascript">

function setInstrDate(obj, num) {
	var d = new Date();
	var m = d.getMonth();
	m+=1;
	if(m<10)
		m="0"+m;
	var y = d.getFullYear();
	var day = d.getDate();
	if(day<10)
		day="0"+day;
	if (obj.checked == true) {;
		document.getElementById("yy"+num).value = y;
		document.getElementById("mm"+num).value = m;
		document.getElementById("dd"+num).value = day;
	}
	else {
		document.getElementById("yy"+num).value = "";
		document.getElementById("mm"+num).value = "";
		document.getElementById("dd"+num).value = "";
	}
}
</script>