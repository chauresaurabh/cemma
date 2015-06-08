<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	
	
//	include_once("includes/action.php");
//	include_once(DOCUMENT_ROOT."Objects/customer.php");

	//include_once("includes/instrument_action.php");
$emailtype=$_GET['all'];			

$instsel=$_GET['inst'];	
	//	echo "inst-".$instsel;
	//echo "type-".$_GET['emailtype'];
$disabled='';


?>
<? include (DOCUMENT_ROOT.'StartCode.php'); ?> 
<script type="text/javascript">
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
 //  alert("in f");
   return xmlHttp;
  }

function showUser()
{
	var i=0;
	var temp;
	var len=document.myForm.emailoptin.length;
		for(i=0;i<=(len-1);i++)
	{
			//alert(i);

		if(document.myForm.emailoptin[i].checked == true)
		{
			//
			temp=document.myForm.emailoptin[i].value;
		//alert("hi"+temp);
		}

	}	

		var xmlHttp = checkajax();
		   
		   xmlHttp.onreadystatechange=function() {
			
				if(xmlHttp.readyState!=4)
					document.getElementById("temp").innerHTML = "busy error";

				if(xmlHttp.readyState==4) {
					document.getElementById("temp").innerHTML =xmlhttp.responseText;
				}
		   }

			xmlHttp.open("GET","ReActivateUser.php?email="+temp,true);
			xmlHttp.send(null);   
	alert("User Re-Activated");

setTimeout("location.reload(true);",10);

}
</script>

<?

//------------Email All list -------

if($_GET['submit']!='yes' )
{
	echo "<html><body style='margin-top: 0px; margin-left: 0px; margin-right: 0px;'><form name='myForm' id='myForm' method='post' action='EmailAnnually.php?submit=yes&emailtypee=1'>";
	
	echo "<h2 class = 'Our'> Email Status Update</h2>";

 	echo "<input type='hidden' id='Emailclicked' name='Emailclicked' />";
	echo "<input type='hidden' id='all' name='all' />";
	echo "<br><table border='1' cellspacing='0'";
	echo "<tr>";
	echo "<td>";
	echo "<br>To<br><input type='text' size='50' name='tocc' value='curulli@usc.edu'/><br>"; 
	#echo "<br>CC<br><input type='text' size='50' name='cc' value='athompso@usc.edu'/><br>"; 
	echo "<br>CC<br><input type='text' size='50' name='cc' value=''/><br>"; 
	echo "<br>Subject<br><input type='text' size='50' name='subj' value='Activate Your CEMMA Account'/><br><br>"; 
	echo "<br>Body<br><TEXTAREA NAME='bod' COLS=40 ROWS=6 wrap='physical'>Please take a moment to review the accuracy of the information in your 'My Account'</TEXTAREA><br><br>";
	
	echo "<center><input type='submit' name='submit' value='Send' align='center'/></center>";
	echo "<input type='hidden' id='Subjectt' name='Subjectt' value='none' />";
	echo "<input type='hidden' id='Body' name='Bodyy' />";
	//$try=1;
	echo "</td></tr>";
	echo "</table><br><br>";
	
	echo "<input type='hidden' name = 'emailtypee' value='1'>";
	echo "<input type='hidden' name = 'temp' id = 'temp' value='1'>";
	
	echo "<div style='float:left;valign:top; margin-top:0; text-align:top;'>";
	
	echo "<font color='#FF0000'>Note: Names in Red have opted out of the mailing list</font><br/> ";

	echo "<table width='100%' cellspacing='0' border='1'>";// style='padding-top:0; margin-top:0;' align='top'>";
	echo "<tr><td><b>No.</b></td><td><b>Name</b></td> <td><b>Opt in </b></td> <td><input type='checkbox' name='AllSelected'   id='AllSelected' value='AllSelected'  onClick='selectall()' checked/><b>All&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Email</b></td></tr>";

	 include_once('constants.php');
		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
$SelectedDB = mysql_select_db($dbname) or die ("Error in DBbb");


// email id's from user
	$sql13 = "SELECT FirstName, LastName, Email, MailingListOpt FROM user where ActiveUser='active' OR ActiveUser IS NULL ORDER BY FirstName";
	$values=mysql_query($sql13) or die("An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
	//$row33 = mysql_fetch_array($values); 
	$totalemailcountuser=0;


	while($row33 = mysql_fetch_array($values))
	{
	if ($row33['Email']!=NULL && strstr($row33['Email'], '@') && strstr($row33['Email'], '.'))
		{
		$emaillist2[$totalemailcountuser]=$row33['Email'];
		$firstnamelist2[$totalemailcountuser]=$row33['FirstName'];
		$lastnamelist2[$totalemailcountuser]=$row33['LastName'];
		$fullname[$totalemailcountuser]=$firstnamelist2[$totalemailcountuser]." ".$lastnamelist2[$totalemailcountuser];
		$disabled=$row33['MailingListOpt'];
		// echo 'dis'.$disabled;
		if ($disabled=='No')
		{
		$disabled='disabled';
		$color='#FF0000';
		}
		else
		{
			$disabled='';
			$color='black';
		}
		$count=$totalemailcountuser+1;
	echo "<tr><td>$count</td><td><font color='$color'>$firstnamelist2[$totalemailcountuser] $lastnamelist2[$totalemailcountuser]</font></td>";

		echo "<td><center><font color='black'><input type='checkbox' name='emailoptin[]' id='emailoptin' onClick='showUser()' value='".$emaillist2[$totalemailcountuser]."'/></font></center></td>";


	echo "<td>";
//	echo "<font color='$color'><input type='checkbox' name='enableemail[]' id='enableemail' value='".$emaillist2[$totalemailcountuser]."' ".$disabled."/>&nbsp;</font>";
	echo "<font color='$color'><input type='checkbox' name='email[]' id='email' value='".$emaillist2[$totalemailcountuser].":".$fullname[$totalemailcountuser]."'  ".$disabled." checked/>&nbsp;".$emaillist2[$totalemailcountuser]."</font></td>";
	
	echo "</tr>"; //zzzz <br>";
//	echo "\n";
		$totalemailcountuser++;
		}
	}

	// "<tr><td colspan=2>&nbsp;</td></tr>";
	echo "</table></div>";
	
	echo "</form></body></html>";
	}
else //after clicking on email button
{

  $emailss = $_POST['email']; //checkboxes
   $subj=$_POST['subj'];
  $bodyy = $_POST['bod'];
  $copyy = $_POST['cc'];
  $tocc=$_POST['tocc'];
  $today = date("Y-n-j"); 

//  echo "subb-->".$subj;
//  echo "bodyy-->".$bodyy;
	echo "<h2 class = 'Our'> Email Status Update</h2>";

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
$headers = 'From: cemma@usc.edu' . "\r\n". 'MIME-Version: 1.0'	. "\r\n" ."Content-type: text/html; charset=iso-8859-1";
	//open connection
		 include_once('constants.php');
		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
$SelectedDB = mysql_select_db($dbname) or die ("Error in DBbb");


    for($i=0; $i < $N; $i++)
    {
	$j=$i+1;
   	$emailandname=explode(":",$emailss[$i]);
	$emails[$i]=$emailandname[0];
	$names[$i]=$emailandname[1];
    echo "$j. ".$names[$i]."- ".$emails[$i]. "<br> ";
	$to = $emails[$i];
	$message="";
	//$message = $bodyy;
	#print "Content-Type: text/html";
	//$message = $message."\nUpdate the status by clicking the following link";
	$message = "Hello ". $names[$i]. ",<br><br>". $bodyy."<br>Update your account status by clicking the following link:<br><a href='http://cemma-usc.net/cemma/testbed/UpdateStatus.php?email=$to&first=true'>Activate&nbsp;Your&nbsp;CEMMA Account</a>";
//	$message = $message."\n\n\nTo opt out of the group Mailing list, Click here http://cemma-usc.net/cemma/testbed/EmailOptOut.php?email=".$emails[$i]."&first=true";
	
	$message = $message."<br><br><br>Center for Electron Microscopy and Microanalysis<br><br>
	<span style='color:#980F07;'>University of Southern California</span><br>814 Bloom Walk<br>CEM Building<br>Los Angeles, CA 90089-1010
	<br>Tel:   &nbsp;&nbsp;213.740.1990<br>Fax: 213.821.0458";

	$message = $message."<br><br>You are receiving this e-mail because you have an active account with the Center for Electron Microscopy and Microanalysis (CEMMA).<br>Note: This is an auto generated mail. Please do not reply.";
	
	//update user
	$sql113 = "UPDATE user SET ResponseEmail='Pending',LastEmailSentOn='$today' where Email = '$to' ";
	mysql_query($sql113) or die ("Error3");
	
	$message =	stripslashes($message);
	
	mail($to,$subject,$message,$headers);
    }
	
	// Email to copied persons
	$subject2="Emails Sent: ".$subject;
	$messagetocc="";
	if( $N==1)
	$messagetocc=$messagetocc."Update Status Email has been sent to $N user: <br><br>";
	if( $N>1)
	$messagetocc=$messagetocc."Update Status Emails have been sent to $N users: <br><br>";
	//$from2 = "cemma@usc.edu";//."\r\n"."CC: $copyy";
	//$headers2= "From: $from2";
	//$headers2 .= "\r\nCc: $copyy";
	//$from = "cemma@usc.edu";
$headers2 = 'From: cemma@usc.edu' . "\r\n". 'MIME-Version: 1.0'	. "\r\n" ."Content-type: text/html; charset=iso-8859-1";

//	$to = "amaypatil01@gmail.com";
	//$to = "amaypatil01@gmail.com";
//$to='koolamay_99@yahoo.com';e
  //	$to='curulli@usc.edu'; 

	for($j=0; $j < $N; $j++)
	    {	$k=$j+1;
			$messagetocc=$messagetocc.$k.". ".$names[$j]."- ".$emails[$j]." \n";
		}
	$messagetocc=$messagetocc."<br><br>The Message is as follows: ";
	$messagetocc = $messagetocc."<br>Subject: ".$subject ."<br>";
	$messagetocc = $messagetocc."Body : ".$bodyy." <Individual links provided to each users>";
 
 	$messagetocc = $messagetocc."<br><br><br>Center for Electron Microscopy and Microanalysis<br><br>
	<span style='color:#980F07;'>University of Southern California</span><br>814 Bloom Walk<br>CEM Building<br>Los Angeles, CA 90089-1010
	<br>Tel:   &nbsp;&nbsp;213.740.1990<br>Fax: 213.821.0458";
  	
	$messagetocc = stripslashes($messagetocc);
	
	mail($tocc,$subject2,$messagetocc,$headers2);
    
  }
  echo "<script type='text/javascript'>setTimeout('delayer()', 5000); function delayer(){
   window.location='EmailAnnually.php';
}</script>";

}



?>
  <script type='text/javascript'>
  var AllSelected=1;
  function selectall()
  {

	var totalcount=0;
	totalcount="<?=$count?>";
	var i=0;
	if (AllSelected==1)
	{
		AllSelected=0;
		for(i=0;i<totalcount;i++)
		{
			document.myForm.email[i].checked=false;
		}

	}
	else
	{
		if (AllSelected==0)
		{
			AllSelected=1;
			for(i=0;i<totalcount;i++)
			{
				document.myForm.email[i].checked=true;
			}
		}
	}
  }
  </script>
<? include (DOCUMENT_ROOT.'EndCode.php'); ?> 
