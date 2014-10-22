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
//   alert("in f");
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
					//document.getElementById("temp").innerHTML = "busy error";

				if(xmlHttp.readyState==4) {
					//document.getElementById("temp").innerHTML =xmlhttp.responseText;
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
echo "<html><body style='margin-top: 0px; margin-left: 0px; margin-right: 0px;'><form name='myForm' id='myForm' method='post' action='EmailInstrStatus.php?submit=yes&emailtypee=1'>";
//echo "in all".$_GET['emailtype'];
// try 
	$sql23 = "SELECT Name , FirstName, LastName, EmailId,MailingListCust FROM Customer ORDER BY Name";
	$values1=mysql_query($sql23) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	//$row33 = mysql_fetch_array($values1); 
	$totalemailcountcustomer=0;
//	echo "zx";
	//echo "hhhhhppppp";

	echo "<h2 class = 'Our'> Email Instrument Status</h2>";

echo "<p><font color='#FF0000'>Note: Names in Red have opted out of the mailing list</font><br>";
	echo "<font color='#FF0000'>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Emails without '@', '.' are not listed</font></p>";
	echo "<input type='hidden' id='Emailclicked' name='Emailclicked' />";
	echo "<input type='hidden' id='all' name='all' />";
	echo "<br><table border='1' cellspacing='0'";
	echo "<tr>";
	echo "<td>";

	echo "<br>To<br><input type='text' size='50' name='tocc' value='curulli@usc.edu'/><br>"; 
	#echo "<br>CC<br><input type='text' size='50' name='cc' value='athompso@usc.edu'/><br>"; 
	echo "<br>CC<br><input type='text' size='50' name='cc' value=''/><br>"; 
	echo "<br>Subject<br><input type='text' size='50' name='subj' value='CEMMA Instrument Status'/><br><br>"; 
	echo "Body<br><TEXTAREA NAME='bod' COLS=40 ROWS=6 wrap='physical'>The Status of the Instruments is as follows:</TEXTAREA><br><br>";
	
	echo "<center><input type='submit' name='submit' value='Send' align='center'/></center>";
	echo "<input type='hidden' id='Subjectt' name='Subjectt' value='none' />";
	echo "<input type='hidden' id='Body' name='Bodyy' />";
	echo "</td></tr>";
	echo "</table> <br> <br>";

	echo "<input type='hidden' name = 'emailtypee' value='1'>";
	
	echo "<div style='float:left;valign:top; margin-top:0; text-align:top;'>";
	echo "<table width='100%' cellspacing='0' border='1'>";// style='padding-top:0; margin-top:0;' align='top'>";
	echo "<tr><td><b>No.</b></td><td><b>Name</b></td> <td><b>Opt in </b></td> <td><input type='checkbox' name='AllSelected'   id='AllSelected' value='AllSelected'  onClick='selectall()' checked/><b>All&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Email</b></td></tr>";


	while($row23 = mysql_fetch_array($values1))
	{
	if ($row23['EmailId']!=NULL && strstr($row23['EmailId'],'@') && strstr($row23['EmailId'], '.'))
		{
	$emaillist1[$totalemailcountcustomer]=$row23['EmailId'];
	$namelist1[$totalemailcountcustomer]=$row23['Name'];
	$fullname[$totalemailcountcustomer]=$row23['FirstName']." ".$row23['LastName'];
 
	$disabled=$row23['MailingListCust'];
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



	$count=$totalemailcountcustomer+1;
	echo "<tr><td>$count</td><td><font color='$color'>$fullname[$totalemailcountcustomer]</font></td>";

	echo "<td><font color='black'><input type='checkbox' name='emailoptin[]' id='emailoptin' onClick='showUser()' value='".$emaillist1[$totalemailcountcustomer]."'/></font></td>";

	echo "<td><font color='$color'><input type='checkbox' name='email[]'   id='email' value='".$emaillist1[$totalemailcountcustomer]."' ".$disabled." checked/>&nbsp;".$emaillist1[$totalemailcountcustomer]."</font></td></tr>"; // zzzzz <br>";
	$totalemailcountcustomer++; 
		}	
//	echo ", ".$emaillist1[$totalemailcountcustomer]."<br>";
//	echo "\n";
	
	}

include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
// email id's from user
	$sql13 = "SELECT FirstName, LastName, Email, MailingListOpt FROM user where ActiveUser='active' OR ActiveUser IS NULL ORDER BY FirstName";
	$values=mysql_query($sql13) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	//$row33 = mysql_fetch_array($values); 
	$totalemailcountuser=0;

$oldcount=$count;
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
		$count=$totalemailcountuser+1+$oldcount;
	echo "<tr><td>$count</td><td><font color='$color'>$firstnamelist2[$totalemailcountuser] $lastnamelist2[$totalemailcountuser]</font></td>";
	echo "<td><font color='black'><input type='checkbox' name='emailoptin[]' id='emailoptin' onClick='showUser()' value='".$emaillist2[$totalemailcountuser]."'/></font></td>";

	echo "<td>";
//	echo "<font color='$color'><input type='checkbox' name='enableemail[]' id='enableemail' value='".$emaillist2[$totalemailcountuser]."' ".$disabled."/>&nbsp;</font>";
	echo "<font color='$color'><input type='checkbox' name='email[]' id='email' value='".$emaillist2[$totalemailcountuser].":".$fullname[$totalemailcountuser]."' ".$disabled." checked/>&nbsp;".$emaillist2[$totalemailcountuser]."</font></td>";
	
	echo "</tr>"; //zzzz <br>";
//	echo "\n";
		$totalemailcountuser++;
		}
	}

	//echo "<tr><td colspan=2>&nbsp;</td></tr>";
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

//  echo "subb-->".$subj;
//  echo "bodyy-->".$bodyy;
	echo "<h2 class = 'Our'> Email Instrument Status</h2>";

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
	
	#print "Content-Type: text/html";

// create Instrument-Status table to attach to message
$dbhost="db1661.perfora.net";
$dbname="db260244667";
$dbusername="dbo260244667";
$dbpass="curu11i";

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
$SelectedDB = mysql_select_db($dbname) or die ("Error in DBbb");


// email id's from user
	$sql13 = "select InstrumentNo, InstrumentName, Availablity,Comment, DisplayOnStatusPage  from instrument";


	$values=mysql_query($sql13) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	//$row33 = mysql_fetch_array($values); 
	$totalemailcountuser=0;
	$instrdata="<br/></br><table border='1' cellspacing='0' cellpadding='0' ><tr><td> Instrument name</td><td> Availability</td><td> Comments</td></tr> ";
	
	//$message = $message."\n\n"."InstrumentName - Availablity - Comment";
	while($row33 = mysql_fetch_array($values))
	{
	
		$InstrumentNo[$totalemailcountuser]=$row33['InstrumentNo'];
		$InstrumentName[$totalemailcountuser]=$row33['InstrumentName'];
		$Availablity[$totalemailcountuser]=$row33['Availablity'];
		$Comment[$totalemailcountuser]=$row33['Comment'];
		$DisplayOnStatusPage[$totalemailcountuser]=$row33['DisplayOnStatusPage'];
		if($row33['Availablity']==1)
			$available='Yes';
		else
			$available='No';

		if($row33['DisplayOnStatusPage']!='No')
		{
	$instrdata = $instrdata."<tr><td> ".$row33['InstrumentName']."</td><td> ".$available." </td><td> ".$row33['Comment']."</td></tr>";
		}
		//	echo "<br/>";
		$totalemailcountuser++;
	}
	$instrdata .="</table><br/><br/>";

// create Instrument- Status table end

//$message = $message."\n\n  <table border=2><tr><td>1</td><td>2</td></tr></table>";

	//echo "ccc ".$copyy." \n";
//	$from = "cemma@usc.edu";
//	$headers  = 'MIME-Version: 1.0' . "\r\n";
	//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//	$headers .= "From: $from";

$headers = 'From: cemma@usc.edu' . "\r\n". 'MIME-Version: 1.0'	. "\r\n" ."Content-type: text/html; charset=iso-8859-1";



    for($i=0; $i < $N; $i++)
    {
	$j=$i+1;
   	$emailandname=explode(":",$emailss[$i]);
	$emails[$i]=$emailandname[0];
	$names[$i]=$emailandname[1];
    echo "$j. ".$names[$i]."- ".$emails[$i]. "<br> ";

	$to = $emails[$i];
 
 	$message = "Hello ". $names[$i]. ",<br><br>". $bodyy."<br>";

 	$message = $message.$instrdata;
	
	$message = $message."<br><br>Center for Electron Microscopy and Microanalysis<br><br>
	<span style='color:#980F07;'>University of Southern California</span><br>814 Bloom Walk<br>CEM Building<br>Los Angeles, CA 90089-1010
	<br>Tel:   &nbsp;&nbsp;213.740.1990<br>Fax: 213.821.0458";

 	$message = $message."<br><br>You are receiving this e-mail because you have an active account with the Center for Electron Microscopy and Microanalysis (CEMMA). To opt out of the group Mailing list, Please <a href='http://cemma-usc.net/cemma/testbed/EmailOptOut.php?email=".$emails[$i]."&first=true'>Click Here </a>";
	//$message = $message."\n\nThe Status of the Instruments is as follows: ";
	
	$message = $message."<br><br>Note: This is an auto generated mail. Please do not reply.";
	
	$message = stripslashes($message);
	
	mail($to,$subject,$message,$headers);
    }
	
	// Email to copied persons
	$subject2="Email Sent: ".$subject;
	$messagetocc="Instruments Status have been mailed.\n\n";
	if( $N==1)
	$messagetocc=$messagetocc."Email has been sent to $N user: \n";
	if( $N>1)
	$messagetocc=$messagetocc."Emails have been sent to $N users: \n";
	$from2 = "cemma@usc.edu";//."\r\n"."CC: $copyy";
	$headers2= "From: $from2";
	$headers2 .= "\r\nCc: $copyy";
	$headers2 .=  "\r\n". 'MIME-Version: 1.0'	. "\r\n" ."Content-type: text/html; charset=iso-8859-1";

//	$to = "amaypatil01@gmail.com";
//	$to = "amaypatil01@gmail.com";
//$to='koolamay_99@yahoo.com';
  	$to='curulli@usc.edu'; 

	for($j=0; $j < $N; $j++)
	    {	$k=$j+1;
			$messagetocc=$messagetocc.$k.". ".$names[$j]."- ".$emails[$j]." \n";
		}
	$messagetocc=$messagetocc."\nThe Message is as follows: \n";
	$messagetocc = $messagetocc."\nSubject: ".$subject;
	$messagetocc = $messagetocc."\n".$bodyy;
	$messagetocc = $messagetocc."\n".$instrdata;
	$messagetocc = $messagetocc."\n\nNote: This is an auto generated mail. Please do not reply.";
	
	$messagetocc = stripslashes($messagetocc);
	
	mail($tocc,$subject2,$messagetocc,$headers2);
    

  }

echo "<script type='text/javascript'>setTimeout('delayer()', 5000); function delayer(){
   window.location='EmailInstrStatus.php';
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