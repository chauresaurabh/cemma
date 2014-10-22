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
                
        <h2 class = "Our"><img src = "images/h2_servises.gif" style="margin-right:10px; vertical-align:middle">Email All</h2>
		

		<form action = "instruments.php" method="post" name="myForm">
	

			
		
	

<table border=1>
<?
$emailtype=$_GET['all'];			

$instsel=$_GET['inst'];	
//echo "inst-".$instsel;
//echo "type-".$emailtype;
$disabled='';
?>
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
		//	alert("hi"+temp);
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

//$countt=0;
if ($emailtype==1 || $_GET['emailtypee']==1)
{
if($_GET['submit']!='yes' )
{
	echo "<html><body style='margin-top: 0px; margin-left: 0px; margin-right: 0px;'><form name='myForm' id='myForm' method='post' action='Email.php?submit=yes&emailtypee=1'>";

	$sql23 = "SELECT Name, EmailId,MailingListCust FROM Customer ORDER BY Name";
	$values1=mysql_query($sql23) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 

	$totalemailcountcustomer=0;

	echo "<input type='hidden' name = 'emailtypee' value='1'>";
	echo "<input type='hidden' name = 'temp' id = 'temp' value='1'>";
	echo "<p><font color='#FF0000'>Note: Names in Red have opted out of the mailing list</font></p>";
	echo "<div style='float:left;valign:top; margin-top:0; text-align:top;'>";
	echo "<table border='1' width='100%' cellspacing='0'>";// style='padding-top:0; margin-top:0;' align='top'>";
	echo "<tr><td><b>No. </b></td><td><b>Name</b></td> <td><b>Opt in </b></td> <td><b> Email</b></td></tr>";
	

	
	while($row23 = mysql_fetch_array($values1))
	{
	if ($row23['EmailId']!=NULL && strstr($row23['EmailId'],'@') && strstr($row23['EmailId'], '.'))
		{
	$emaillist1[$totalemailcountcustomer]=$row23['EmailId'];
	$namelist1[$totalemailcountcustomer]=$row23['Name'];

	$disabled=$row23['MailingListCust'];
	if ($disabled=='No')
	{
		$disabled=''; //make ='disabled' if want to disable it 
		$color='#FF0000';
	}
	else
		{
			$disabled='';
			$color='black';
		}



$count=$totalemailcountcustomer;
	echo "<tr><td>$count</td><td><font color='$color'>$namelist1[$totalemailcountcustomer]</font></td>";
	echo "<td><center><font color='black'><input type='checkbox' name='emailoptin[]' id='emailoptin' onClick='showUser()' value='".$emaillist1[$totalemailcountcustomer]."'/></font></center></td>";

	echo "<td><font color='$color'><input type='checkbox' name='email[]'   id='email' value='".$emaillist1[$totalemailcountcustomer].":".$namelist1[$totalemailcountcustomer]."' ".$disabled."/>&nbsp;".$emaillist1[$totalemailcountcustomer]."</font></td></tr>"; // zzzzz <br>";

	echo "<input type='hidden' name='names[]' id='names' value='".$namelist1[$totalemailcountcustomer]."'/>";
	//echo "jk";
	$totalemailcountcustomer++; 
		}
//	echo ", ".$emaillist1[$totalemailcountcustomer]."<br>";
//	echo "\n";
	
	}
	 include_once('constants.php');
		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
$SelectedDB = mysql_select_db($dbname) or die ("Error in DBbb");


// email id's from user
	$sql13 = "SELECT FirstName, LastName, Email, MailingListOpt FROM user ORDER BY FirstName";
	$values=mysql_query($sql13) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	//$row33 = mysql_fetch_array($values); 
	$totalemailcountuser=0;

	//sort(mysql_fetch_array($values));

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
		$disabled='';
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


	echo "<font color='$color'><input type='checkbox' name='email[]' id='email' value='".$emaillist2[$totalemailcountuser].":".$fullname[$totalemailcountuser]."' ".$disabled."/>&nbsp;".$emaillist2[$totalemailcountuser]."</font></td>";

	echo "<input type='hidden' name='names[]' id='names' value='".$fullname[$totalemailcountuser]."'/>";
	
	echo "</tr>"; //zzzz <br>";
//	echo "\n";
		$totalemailcountuser++;
		}
	}

	echo "<tr><td colspan=2>&nbsp;</td></tr>";
	echo "</table></div>";
	echo "<input type='hidden' id='Emailclicked' name='Emailclicked' />";
	echo "<input type='hidden' id='all' name='all' />";
	echo "<p>To</p><input type='text' size='50' name='tocc' value='curulli@usc.edu'/><br>"; 
	echo "<p>CC</p><input type='text' size='50' name='cc' value='athompso@usc.edu'/><br>"; 
	echo "<br>Subject<br><input type='text' size='50' name='subj' value='EM Center'/><br><br>"; 
	echo "Body<br><TEXTAREA NAME='bod' COLS=40 ROWS=6 wrap='physical'></TEXTAREA><br><br>";
	
	echo "<input type='submit' name='submit' value='Send' align='center'";
	echo "<input type='hidden' id='Subjectt' name='Subjectt' value='none' />";
	echo "<input type='hidden' id='Body' name='Bodyy' />";
	//$try=1;
	echo "</form></body></html>";
	}
else //after clicking on email button
{

  $emailss = $_POST['email']; //checkboxes
 // $names = $_POST['names'];
 // $emails=explode(":",$emails);
  $subj=$_POST['subj'];
  $bodyy = $_POST['bod'];
  $copyy = $_POST['cc'];
  $tocc=$_POST['tocc'];

//  echo "subb-->".$subj;
//  echo "bodyy-->".$bodyy;

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
	$headers = "From: $from";

    for($i=0; $i < $N; $i++)
    {
	$j=$i+1;
	$emailandname=explode(":",$emailss[$i]);
	$emails[$i]=$emailandname[0];
	$names[$i]=$emailandname[1];
    echo "$j. ".$names[$i]."- ".$emails[$i]. "<br> ";
	$to = $emails[$i];
	$message = $bodyy;
	$message = $message."\n\nTo opt out of the group Mailing list, Click here   http://cemma-usc.net/cemma/testbed/EmailOptOut.php?email=".$emails[$i]."&first=true";
	$message = $message."\nNote: This is an auto generated mail. Please do not reply.";

	mail($to,$subject,$message,$headers);
    }
	
	// Email to copied persons
	$subject2="Emails Sent-".$subject;
	if( $N==1)
	$messagetocc="Email has been sent to the following $N user: \n";
	if( $N>1)
	$messagetocc="Emails have been sent to following $N users: \n";
	$from2 = "cemma@usc.edu";//."\r\n"."CC: $copyy";
	$headers2= "From: $from2";
	$headers2 .= "\r\nCc: $copyy";

//	$to = "amaypatil01@gmail.com";

//$to='koolamay_99@yahoo.com';
  	//$to='curulli@usc.edu'; 

	for($j=0; $j < $N; $j++)
	    {	$k=$j+1;
			$messagetocc=$messagetocc.$k.". ".$names[$j]."- ".$emails[$j]." \n";
		}
	$messagetocc=$messagetocc."\nThe Message is as follows: \n";
	$messagetocc = $messagetocc."\nSubject: ".$subject;
	$messagetocc = $messagetocc."\n".$bodyy;
	$messagetocc = $messagetocc."\n\n\nNote: This is an auto generated mail. Please do not reply.";
	mail($tocc,$subject2,$messagetocc,$headers2);
    

  }

}
}
//------------Email Instruments list -------
if($emailtype==2 || $_GET['emailtypee']==2)
{
if($_GET['submit']!='yes' )
{
echo "<form name='myForm' id='myForm' method='post' action='Email.php?submit=yes&inst=$instsel&emailtypee=2'>";
echo "<p><font color='#FF0000'>Note: Names in Red have opted out of the mailing list</font></p>";


//echo "<script type='text/javascript'>var subject=prompt('Enter the Subject',''); var body=prompt('Enter the Body','');";
	 include_once('constants.php');
		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
$SelectedDB = mysql_select_db($dbname) or die ("Error in DBbb");



//retrieve instrument name, number list


	$sql13 = "SELECT InstrumentName, InstrumentNo FROM instrument where InstrumentName='$instsel'";
	$values=mysql_query($sql13) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	//$row33 = mysql_fetch_array($values); 
	$instcount=0;


	while($row33 = mysql_fetch_array($values))
	{
	
		$instlist[$instcount]=$row33['InstrumentName'];
		$instnolist[$instcount]=$row33['InstrumentNo'];


	//echo $instnolist[$instcount].". ".$instlist[$instcount]."<br>";
//	echo "\n";
		$instcount++;
	
	}

	// try 





//retrieve instrument number, emailid list from instr_group


	$sql13 = "SELECT Email, InstrNo FROM instr_group where InstrNo='$instnolist[0]'";
	$values=mysql_query($sql13) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
	//$row33 = mysql_fetch_array($values); 
	


	while($row33 = mysql_fetch_array($values))
	{
	
		$instr_groupNolist[$instr_groupcount]=$row33['InstrNo'];
		$instr_groupEmaillist[$instr_groupcount]=$row33['Email'];


//	echo $instr_groupNolist[$instr_groupcount].". ";
//	echo $instr_groupEmaillist[$instr_groupcount]." <br>";
//	echo "\n";
		$instr_groupcount++;
	
	}

	
	echo "<table><tr><td><b>No. </b></td><td> <b>Name</b></td> <td><b>Opt in </b></td><td><b> Email</b></td></tr>";
	
// 2 email id's from user

	$sql13 = "SELECT FirstName, LastName, Email, MailingListOpt FROM user where Email IN (SELECT Email FROM instr_group where InstrNo='$instnolist[0]') ORDER BY FirstName";
	$values=mysql_query($sql13) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
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
	echo "<td><font color='black'><input type='checkbox' name='emailoptin[]' id='emailoptin' onClick='showUser()' value='".$emaillist2[$totalemailcountuser]."'/></font></td>";

	echo "<td><font color='$color'><input type='checkbox' name='email[]' id='email' value='".$emaillist2[$totalemailcountuser].":".$fullname[$totalemailcountuser]."' ".$disabled."/>&nbsp;".$emaillist2[$totalemailcountuser]."</font></td></tr>";//<br>";
//	echo "\n";
		$totalemailcountuser++;
		}
	}

	echo "</table>";
	echo "<input type='hidden' id='Emailclicked' name='Emailclicked' />";
	echo "<input type='hidden' id='all' name='all' />";
	echo "<p>To</p><input type='text' size='50' name='tocc' value='curulli@usc.edu'/><br>"; 
	echo "CC<br><input type='text' size='50' name='cc' value='athompso@usc.edu'/><br>"; 
	echo "<br>Subject<br><input type='text' size='30' name='subj' value='$instsel'/><br>"; 
	echo "Body<br><TEXTAREA NAME='bod' COLS=40 ROWS=6 wrap='physical'></TEXTAREA><br><br>";
	
	echo "<input type='submit' name='submit' value='Send' align='center'";
	//$try=1;
	echo "<input type='hidden' id='Subjectt' name='Subjectt' value='none' />";
	echo "<input type='hidden' id='Body' name='Bodyy' />";
	echo "</form>";
	}
else //after clicking on email button
{

  $emailss = $_POST['email']; //checkboxes
  $emailsoptin = $_POST['emailoptin'];
  $subj=$_POST['subj'];
  $bodyy = $_POST['bod'];
  $copyy = $_POST['cc'];
  $tocc=$_POST['tocc'];

 // echo "subb-->".$subj;
 // echo "bodyy-->".$bodyy;

  if(empty($emailss)) 
  {
    echo("You did not select any Users.");
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
	    echo " to $N Users: <br>";
	}

	
	
	$from = "cemma@usc.edu";
	$headers = "From: $from";
	$headers .= "\r\nCc: koolamay_99@yahoo.com";

    for($i=0; $i < $N; $i++)
    {
	
	$j=$i+1;
	$subject = "$j. ".$subj;
	$emailandname=explode(":",$emailss[$i]);
	$emails[$i]=$emailandname[0];
	$names[$i]=$emailandname[1];
    echo "$j. ".$names[$i].": ".$emails[$i]."<br> ";


    //echo("$j. ".$emails[$i] . "<br> ");

	$to = $emails[$i];
	$message = $bodyy;
	$message = $message."\n\nTo opt out of the group Mailing list, Click here   http://cemma-usc.net/cemma/testbed/EmailOptOut.php?email=$emails[$i]&first=true";
	$message = $message."\n\nNote: This is an auto generated mail. Please do not reply.";

	mail($to,$subject,$message,$headers);
    }
	
	// Email to copied persons
	//echo "kol".$instsel;

	$subject2=$instsel.' Group Email: '.$subj;
	
	
	

	$from2 = "cemma@usc.edu";//."\r\n"."CC: $copyy";
	$headers2= "From: $from2";
	$headers2 .= "\r\nCc: $copyy";

	$messagetocc='"'.$instsel.'" Group Email:';
	if( $N==1)
		$messagetocc=$messagetocc."\n\nEmail has been sent to $N user: \n";
	if( $N>1)
		$messagetocc=$messagetocc."\n\nEmails have been sent to $N users: \n";
	

//	$to = "amaypatil01@gmail.com";
//$to='koolamay_99@yahoo.com';
  //	$to='curulli@usc.edu';

	for($j=0; $j < $N; $j++)
	    {	$k=$j+1;
			
			$messagetocc=$messagetocc.$k.". ".$names[$j]."- ".$emails[$j]." \n";

		}
	$messagetocc=$messagetocc."\nThe Message is as follows: \n";
	$messagetocc = $messagetocc."Subject: ".$subj;
	$messagetocc = $messagetocc."\n".$bodyy;
	$messagetocc = $messagetocc."\n\nNote: This is an auto generated mail. Please do not reply.";
	mail($tocc,$subject2,$messagetocc,$headers2);
    

  }

}


}
?>


</table>
		</form>
		
        
      </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>
  
</td></tr></table>

<script language='javascript'>

</script>
   <? include ('tpl/footer.php'); ?>

   
   

