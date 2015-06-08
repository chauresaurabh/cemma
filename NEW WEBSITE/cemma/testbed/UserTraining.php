<?
	$username = $_GET['username'];
	$email = $_GET['email'];
	
 	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
							$sql1 = "select InstrumentNo, InstrumentName from instrument";
							$result=mysql_query($sql1) or die( "An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
 							$no=0;
							echo "Request Training for below Instruments<br><br>";
							while($row2 = mysql_fetch_array($result))
							{
								$instrName = $row2['InstrumentName'];
								$instrNo = $row2['InstrumentNo'];
								
 							 echo "<input type='button' value='".$instrName."' onClick='requestTraining(\"$instrNo\", \"$instrName\", \"$username\", \"$email\");'/><br><br> ";
                            }     
                            
 ?>
							
<script type="text/javascript">

function requestTraining(instrNo, instrName, userName, email){
		alert(userName+" has Requested Training for "+ instrName );
		if (window.XMLHttpRequest) {
						try {
							req = new XMLHttpRequest();
						} catch (e) {
							req = false;
						}
					} else if (window.ActiveXObject) {
						try {
							req = new ActiveXObject("Msxml2.XMLHTTP");
						} catch (e) {
							try {
								req = new ActiveXObject("Microsoft.XMLHTTP");
							} catch (e) {
								req = false;
							}
						}
					}
					if (req) {
						req.onreadystatechange = requestedTraining;
						req.open("GET", "requestTraining.php?instrName="+instrName+"&userName="+userName+"&email="+email+"&instrNo="+instrNo, true);
						req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("");
					} else {
						alert("Please enable Javascript");
					}
	}
	function requestedTraining(){
		if (req.readyState == 4 && req.status == 200) {
			alert("Training requested successfully");
		}
	}

</script>