<?
$emailss = $_POST['email']; //checkboxes
 // $names = $_POST['names'];
 // $emails=explode(":",$emails);
  $subj=$_POST['subj'];
  $bodyy = $_POST['bod'];
  $copyy = $_POST['cc'];
  $tocc=$_POST['tocc'];
  
//  echo "subb-->".$subj;
//  echo "bodyy-->".$bodyy;
echo "<h2 class = 'Our'><img src = 'images/h2_servises.gif' style='margin-right:10px; vertical-align:middle'>Email All</h2>";

	echo "<br>Page will Reload after 5 seconds..."."<br><br>";

  if(empty($emailss)) 
  {
    echo("You didn't select any Users.");
  } 
  else 
  {
    $N = count($emailss);
	if ($N==1)
	{ echo "Email Sent Successfully";
	echo(" to $N User: <br>");
	}
	if ($N>1)
    {
		echo "Emails Sent Successfully";
	    echo(" to $N Users: <br>");
	}

	$subject = $subj;
	
	//echo "ccc ".$copyy." \n";
	$from = "cemma@usc.edu";
	$strSid = "";
$headers = 'From: cemma@usc.edu' . "\r\n". 'MIME-Version: 1.0'	. "\r\n";
	if($_FILES["file"]["name"] != ""){
		$strSid = md5(uniqid(time()));
		$headers.=" Content-Type: multipart/mixed; boundary=\"".$strSid."\"\n\nThis is a multi-part message in MIME format.\n";  
  		$headers .= "--".$strSid."\n";
	}
	$headers.="Content-type: text/html; charset=iso-8859-1";

    for($i=0; $i < $N; $i++)
    {
	$j=$i+1;
	$emailandname=explode(":",$emailss[$i]);
	$emails[$i]=$emailandname[0];
	$names[$i]=$emailandname[1];
    echo "$j. ".$names[$i]."- ".$emails[$i]. "<br> ";
	$to = $emails[$i];
	//$message = $bodyy;
	//$message = $message."\n\nTo opt out of the group Mailing list, Click here   http://cemma-usc.net/cemma/testbed/EmailOptOut.php?email=".$emails[$i]."&first=true";
	//$message = $message."\nNote: This is an auto generated mail. Please do not reply.";
	//$message = "Hello ".$names[$i]." Your Email ".$emails[$i];
 
 	$bodyy = str_replace(' ', '&nbsp;', $bodyy);

 $message = "Hello ". $names[$i]. ",<br><br>". nl2br($bodyy);
//	$message = $message."\n\n\nTo opt out of the group Mailing list, Click here http://cemma-usc.net/cemma/testbed/EmailOptOut.php?email=".$emails[$i]."&first=true";
	
	$message = $message."<br><br><br>Center for Electron Microscopy and Microanalysis<br><br>
	<span style='color:#980F07;'>University of Southern California</span><br>814 Bloom Walk<br>CEM Building<br>Los Angeles, CA 90089-1010
	<br>Tel:   &nbsp;&nbsp;213.740.1990<br>Fax: 213.821.0458";
	
	$message = $message ."<br><br>You are receiving this e-mail because you have an active account with the Center for Electron Microscopy and Microanalysis (CEMMA).";
	if ($_FILES["file"]["error"] > 0) {
	  $message.= "Error: " . $_FILES["file"]["error"] . "<br>";
	}
	$message = $message ." To unsubscribe from this e-mail communications, click &nbsp;<a href='http://cemma-usc.net/cemma/testbed/UpdateStatus.php?email=curulli@usc.edu&first=true'>Unsubscribe</a>";
	$message.="Filename: ".$_FILES["file"]["name"].$_FILES["file"]["tmp_name"].$_FILES["file"].$POST["file"];
	
	$message = $message."<br><br>Note: This is an auto generated mail. Please do not reply.";
	if($_FILES["file"]["name"] != ""){
		$strFilesName = $_FILES["file"]["name"];  
		$strContent = chunk_split(base64_encode(file_get_contents($strFilesName)));  
		$headers .= "--".$strSid."\n";  
		$headers .= "Content-Type: application/octet-stream; name=\"".$strFilesName."\"\n";  
		$headers .= "Content-Transfer-Encoding: base64\n";  
		$headers .= "Content-Disposition: attachment; filename=\"".$strFilesName."\"\n\n";  
		$headers .= $strContent."\n\n";  
	}
	mail($to,$subject,$message,$headers);
    }
	
	// Email to copied persons
	$subject2="Emails Sent-".$subject;
	if( $N==1)
	$messagetocc="Email has been sent to the following $N user: <br> ";
	if( $N>1)
	$messagetocc="Emails have been sent to following $N users: <br>";
	
	$from2 = "cemma@usc.edu";//."\r\n"."CC: $copyy";

	$headers2 .= "From: $from2";
	$headers2 .= "\r\nCc: $copyy";
	$headers2 .=  "\r\n". 'MIME-Version: 1.0'	. "\r\n" ."Content-type: text/html; charset=iso-8859-1";

//	$to = "amaypatil01@gmail.com";

//$to='koolamay_99@yahoo.com';
  	//$to='curulli@usc.edu'; 

	for($j=0; $j < $N; $j++)
	    {	$k=$j+1;
			$messagetocc=$messagetocc.$k.". ".$names[$j]."- ".$emails[$j]." <br>";
		}
	$messagetocc=$messagetocc."<br>The Message is as follows: <br>";
	$messagetocc = $messagetocc."<br>Subject: ".$subject;
		$bodyy = str_replace(' ', '&nbsp;', $bodyy);

	$messagetocc = $messagetocc."<br>".nl2br($bodyy);
	$messagetocc = $messagetocc."<br><br><br>Note: This is an auto generated mail. Please do not reply.";
	mail($tocc,$subject2,$messagetocc,$headers2);
  }
  echo "<b/>Files";
  foreach($_FILES as $key=>$val) {
	  echo $key." ".$val."<br/>";
  }
?>