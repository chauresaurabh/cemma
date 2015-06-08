
<? 	

	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include_once(DOCUMENT_ROOT."phpmail/PHPMailerAutoload.php");
	
	$emailtype=$_GET['all'];			
	$instsel=$_GET['inst'];	
	$emailgroup=$_GET['emailgroup'];
	
	//echo "inst-".$instsel;
	//echo "type-".$emailtype;
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

function selectEmailGroup(){
	
 	var emailgroup = document.getElementById("emailgroup");
  	
          var SelBranchVal = "";
         var x = 0;
	
         for (x=0;x<emailgroup.length;x++)
         {
             if (emailgroup[x].selected)
            {
             //alert(InvForm.SelBranch[x].value);
            	 SelBranchVal = SelBranchVal + "&usertype[]=" + emailgroup[x].value;

            }
         }
	
	var getString =   "http://cemma-usc.net/cemma/testbed/Email.php?all=1"+SelBranchVal;
	window.location.href = getString;
}
</script>

<?

//------------Email All list -------

$usertype = $_GET['usertype'];
if( isset($usertype)){
foreach ($usertype as $selectedOption) {
 
  switch ($selectedOption) {
    case 0:
        $selval0 ="selected";
         break;
    case 1:
        $selval1 ="selected";
        break;
    case 2:
        $selval2 ="selected";
        break;
	 case 3:
         $selval3 ="selected"; 
        break;
	 case 4:
         $selval4 ="selected";
        break;
	 case 5:
         $selval5 ="selected"; 
        break;
	 case 6:
         $selval6 ="selected";
        break;
	  case 7:
         $selval7 ="selected";
        break;
	}
 }
}
//$countt=0;
if ($emailtype==1 || $_GET['emailtypee']==1)
{
if($_GET['submit']!='yes' )
{
	echo "<html><body style='margin-top: 0px; margin-left: 0px; margin-right: 0px;'><form name='myForm' id='myForm' method='post' enctype='multipart/form-data' action='Email.php?submit=yes&emailtypee=1'>";

	echo "<h2 class = 'Our'> Email All</h2>";
  	
	echo " <select id='emailgroup' name='emaillist[]' multiple='multiple'>
		 
 		  <option value='0' $selval0 >All Customers & Users</option>
		  <option value='1' $selval1>Users-All</option>
		  <option value='2' $selval2>Users-Life Science</option>
		  <option value='3' $selval3>Users-Physical Science</option>
		  <option value='4' $selval4>Customer-All</option>
		  <option value='5' $selval5>Customer-USC Campus</option>
		  <option value='6' $selval6>Customer-Off Campus</option>
		  <option value='7' $selval7>Customer-Industry</option>
		</select> 
		
		<br/>
		
		<input type='button' value='Load Users' onclick='selectEmailGroup();' />";

	echo "<input type='hidden' id='Emailclicked' name='Emailclicked' />";
	echo "<input type='hidden' id='all' name='all' />";
	echo "<table border='1' cellspacing='0'";
	echo "<tr>";
	echo "<td>";
	
 
	echo "<br>CC 1<br><input type='text' size='50' name='tocc' value='curulli@usc.edu'/><br>"; 
	#echo "<br>CC 2<br><input type='text' size='50' name='cc' value='athompso@usc.edu'/><br>"; 
	echo "<br>CC 2<br><input type='text' size='50' name='cc' value=''/><br>"; 
	echo "<br>Subject<br><input type='text' size='50' name='subj' value='Center for Electron Microscopy and Microanalysis'/><br><br>"; 
	
	echo " <label for='file'>Attach file:</label><br>
<input type='file' name='file' id='file'><br> ";

	echo "Body<br><TEXTAREA NAME='bod' COLS=40 ROWS=6 wrap='physical'></TEXTAREA><br><br>";
	
	echo "<center><input type='submit' name='submit' value='Send' align='center'/></center>";
	echo "<input type='hidden' id='Subjectt' name='Subjectt' value='none' />";
	echo "<input type='hidden' id='Body' name='Bodyy' />";
	echo "</td></tr>";
	echo "</table> <br><br>";
	
	$customerSql = "";
	$customerPrint = "";
	 
	if(  !isset($usertype) || in_array( 0 , $usertype)  || in_array( 4 , $usertype)  ){
		$customerSql = "SELECT FirstName, LastName , Name, EmailId,MailingListCust FROM Customer ORDER BY LastName";
		$customerPrint = "All Customers";
	}else if(  in_array( 5 , $usertype) && in_array( 6 , $usertype) && in_array( 7 , $usertype)  ){ 
		$customerSql = "SELECT FirstName, LastName , Name, EmailId,MailingListCust FROM Customer where ( Type='On-Campus' or Type='Off-Campus' or Type='Industry' )  ORDER BY LastName";
		$customerPrint = 'On-Campus, Off-Campus & Industry';
		}else if(  in_array( 5 , $usertype) && in_array( 6 , $usertype)  ){ 
		$customerSql = "SELECT FirstName, LastName , Name, EmailId,MailingListCust FROM Customer where ( Type='On-Campus' or Type='Off-Campus' ) ORDER BY LastName";
		$customerPrint = 'On-Campus, Off-Campus ';
 	}else if(   in_array( 5 , $usertype) && in_array( 7 , $usertype)  ){ 
		$customerSql = "SELECT FirstName, LastName , Name, EmailId,MailingListCust FROM Customer where ( Type='On-Campus'  or Type='Industry' ) ORDER BY LastName";
		$customerPrint = 'On-Campus & Industry';
	}else if(  in_array( 6 , $usertype) && in_array( 7 , $usertype)  ){ 
		$customerSql = "SELECT FirstName, LastName , Name, EmailId,MailingListCust FROM Customer where ( Type='Off-Campus'  or Type='Industry' ) ORDER BY LastName";
		$customerPrint = 'Off-Campus & Industry';
 	} else if(  in_array( 5 , $usertype)   ){ 
		$customerSql = "SELECT FirstName, LastName , Name, EmailId,MailingListCust FROM Customer where Type='On-Campus'  ORDER BY LastName";
		$customerPrint = 'On-Campus';
 	}else if( in_array( 6 , $usertype)  ){
		$customerSql = "SELECT FirstName, LastName , Name, EmailId,MailingListCust FROM Customer where Type='Off-Campus'  ORDER BY LastName";
		$customerPrint = 'Off-Campus';		 
 	}else if( in_array( 7 , $usertype)  ){
		$customerSql = "SELECT FirstName, LastName , Name, EmailId,MailingListCust FROM Customer where Type='Industry'  ORDER BY LastName";
		$customerPrint = 'Industry';	
  	}else{
		$customerSql = "SELECT FirstName, LastName , Name, EmailId,MailingListCust FROM Customer where Type='test' ";
	}
	
 
 $values1=mysql_query($customerSql) or die("An error has occurred in customerSql: " .mysql_error (). ":" .mysql_errno ()); 

	$totalemailcountcustomer=0;

	echo "<input type='hidden' name = 'emailtypee' value='1'>";
	echo "<input type='hidden' name = 'temp' id = 'temp' value='1'>";
	
	echo " <font color='#FF0000'>Note: Names in Red have opted out of the mailing list</font> <br>";

	echo "<div style='float:left;valign:top; margin-top:0; text-align:top;'>";
	echo "<table width='100%' cellspacing='0' border='1'>";// style='padding-top:0; margin-top:0;' align='top'>";
//	echo "<tr><td colspan='3'>Users</td></tr>";
	echo "<tr><td><b>No. </b></td><td><b>Name</b></td> <td><b>Opt in </b></td> <td><input type='checkbox' name='AllSelected'   id='AllSelected' value='AllSelected'  onClick='selectall()' checked/><b>All&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Email</b></td></tr>";
	
	echo "<tr><td colspan=4><font color='blue'><b><center>Customer List : $customerPrint </center></b></font></td></tr>";
	
	while($row23 = mysql_fetch_array($values1))
	{
		if ($row23['EmailId']!=NULL && strstr($row23['EmailId'],'@') && strstr($row23['EmailId'], '.'))
		{
			$emaillist1[$totalemailcountcustomer]=$row23['EmailId'];
			$namelist1[$totalemailcountcustomer]=$row23['Name'];

			$firstnamelist23[$totalemailcountcustomer]=$row23['FirstName'];
			$lastnamelist23[$totalemailcountcustomer]=$row23['LastName'];
			$fullnamelist23[$totalemailcountcustomer]=$firstnamelist23[$totalemailcountcustomer]." ".
			$lastnamelist23[$totalemailcountcustomer];
		
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
			$count=$totalemailcountcustomer+1;
			echo "<tr><td>$count</td><td><font color='$color'>$fullnamelist23[$totalemailcountcustomer]</font></td>";
			echo "<td><center><font color='black'><input type='checkbox' name='emailoptin[]' id='emailoptin' onClick='showUser()' value='".$emaillist1[$totalemailcountcustomer]."'/></font></center></td>";

			echo "<td><font color='$color'><input type='checkbox' name='email[]'   id='email' value='".$emaillist1[$totalemailcountcustomer].":".$fullnamelist23[$totalemailcountcustomer]."' ".$disabled." checked/>&nbsp;".$emaillist1[$totalemailcountcustomer]."</font></td></tr>"; // zzzzz <br>";

			echo "<input type='hidden' name='names[]' id='names' value='".$namelist1[$totalemailcountcustomer]."'/>";
			$totalemailcountcustomer++; 
		}
//	echo ", ".$emaillist1[$totalemailcountcustomer]."<br>";
//	echo "\n";
	
	}


		 include_once('constants.php');
		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DBbb");
	
	$userSql = "";
	$userPrint = "";
	if(  !isset($usertype) || in_array( 0 , $usertype)  || in_array( 1 , $usertype)   ){
		$userSql = "SELECT FirstName, LastName, Email, MailingListOpt FROM user where (ActiveUser='active' OR ActiveUser 	IS NULL)  ORDER BY FirstName";
		$userPrint = "All Users";
	}else if(   in_array( 2 , $usertype)  && in_array( 3 , $usertype)  ){
		$userSql = "SELECT FirstName, LastName, Email, MailingListOpt FROM user where (ActiveUser='active' OR ActiveUser 	IS NULL)  ORDER BY FirstName";
		$userPrint = "Life Science & Physical Science";
	}else if( in_array( 2 , $usertype)  ){
		$userSql = "SELECT FirstName, LastName, Email, MailingListOpt FROM user where (ActiveUser='active' OR ActiveUser 	IS NULL) and FieldofInterest ='Life Science' ORDER BY FirstName";
				$userPrint = "Life Science";
 	}else if( in_array( 3 , $usertype)  ){
		 $userSql = "SELECT FirstName, LastName, Email, MailingListOpt FROM user where (ActiveUser='active' OR ActiveUser 	IS NULL) and FieldofInterest='Physical Science' ORDER BY FirstName";
		 $userPrint = "Physical Science";
	}else{
	 	$userSql = "SELECT FirstName, LastName, Email, MailingListOpt FROM user where FirstName ='testinguseremail'";
	}
// email id's from user
	 	echo "<tr><td colspan=4><font color='blue'><b><center>User List : $userPrint </center></b></font></td></tr>";
	
	$values=mysql_query($userSql) or die("An error has occurred in userSql: " .mysql_error (). ":" .mysql_errno ()); 
	 
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
				$disabled='';
				$color='#FF0000';
			}
			else
			{
				$disabled='';
				$color='black';
			}
		
			$count=$totalemailcountuser+1+$oldcount;
			echo "<tr><td>$count</td><td><font color='$color'>$firstnamelist2[$totalemailcountuser] $lastnamelist2[$totalemailcountuser]</font></td>";
			echo "<td><center><font color='black'><input type='checkbox' name='emailoptin[]' id='emailoptin' onClick='showUser()' value='".$emaillist2[$totalemailcountuser]."'/></font></center></td>";
			echo "<td>";
			echo "<font color='$color'><input type='checkbox' name='email[]' id='email' value='".$emaillist2[$totalemailcountuser].":".$fullname[$totalemailcountuser]."' ".$disabled." checked/>&nbsp;".$emaillist2[$totalemailcountuser]."</font></td>";

			echo "<input type='hidden' name='names[]' id='names' value='".$fullname[$totalemailcountuser]."'/>";
	
			echo "</tr>";
			$totalemailcountuser++;
		}
		else
		{
			echo "<tr><td>-</td><td>".$row33['FirstName']." ".$row33['LastName']."</td>";
			echo "<td>-</td>";
			echo "<td>".$row33['Email']."</td>";
			echo "</tr>";
		}
	}
	echo "</table></div>";
	
	echo "</form></body></html>";
	}
else //after clicking on email button
{

////// EMAIL MODULE STARTS ///////////////

//$allowedExts = array("pdf",	"PDF" ,"tiff", "TIFF","jpg","JPG","doc","docx","ppt","pptx","bmp","BMP"); // include all file types 
$extension = end(explode(".", $_FILES["file"]["name"]));
$fileName = $_FILES["file"]["name"];
  
 $fileUploaded = false;

  //if(in_array($extension, $allowedExts)){
	if ($_FILES["file"]["error"] > 0)
	  {
	 	 echo "Error : ";
 	  }
	else
	  {
 			  if ( move_uploaded_file($_FILES["file"]["tmp_name"], DOCUMENT_ROOT."emailattachments/".$fileName ) )
			   {  
			  	echo "<br/><b>File '$fileName' attached successfully</b>". "<br>"; // need to style this information
 			   }else{
 			 	 echo "<br/><b>Could not save file.</b>". "<br>"; // need to style this information
			  }
	  }
	  
	 // exit;
// }

//////////////////// EMAIL ATTACHMENT MODULE ENDS 
 
  $emailss = $_POST['email']; //checkboxes
 // $names = $_POST['names'];
 // $emails=explo.de(":",$emails);
  $subj=$_POST['subj'];
  $bodyy = $_POST['bod'];
  $copyy = $_POST['cc'];
  $tocc=$_POST['tocc'];

//  echo "subb-->".$subj;
//  echo "bodyy-->".$bodyy;
echo "<h2 class = 'Our'> Email All</h2>";

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

	$to="";
	$mail = new PHPMailer;
    for($i=0; $i < $N; $i++)
    {
	$j=$i+1;
	$emailandname=explode(":",$emailss[$i]);
	$emails[$i]=$emailandname[0];
	$names[$i]=$emailandname[1];
    echo "$j. ".$names[$i]."- ".$emails[$i]. "<br> ";
	 $to = $emails[$i];
	//$to ="chaure@usc.edu";
	
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
	
	$message = $message ." To unsubscribe from this e-mail communications, click &nbsp;<a href='http://cemma-usc.net/cemma/testbed/UpdateStatus.php?email=$to&first=true'>Unsubscribe</a>";
	
	$message = $message."<br><br>Note: This is an auto generated mail. Please do not reply.";
 
  	$message = stripslashes($message);
	
	// mail($to,$subject,$message,$headers);
 	    
		 
		$mail->From = 'cemma@usc.edu';
		$mail->FromName = 'CEMMA';
		
		 
		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		$mail->addAttachment(DOCUMENT_ROOT."emailattachments/".$fileName);         // Add attachments
		$mail->isHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = $subject;
		$mail->Body    = $message ;
		$mail->AltBody = $message ;
		$mail->addAddress($to, $to);   
		
		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} 
	
	 
	}
	// Email to copied persons
	$subject2="Emails Sent-".$subject;
	if( $N==1)
	$messagetocc="Email has been sent to the following $N user: <br>";
	if( $N>1)
	$messagetocc="Emails have been sent to following $N users: <br>";
	$from2 = "cemma@usc.edu";//."\r\n"."CC: $copyy";

	$headers2 .= "From: $from2";
	$headers2 .= "\r\nCc: $copyy";
	$headers2 .=  "\r\n". 'MIME-Version: 1.0'	. "\r\n" ."Content-type: text/html; charset=iso-8859-1";
 
	for($j=0; $j < $N; $j++)
	    {	$k=$j+1;
			$messagetocc=$messagetocc.$k.". ".$names[$j]."- ".$emails[$j]." <br>";
		}
	$messagetocc=$messagetocc."<br>The Message is as follows: <br>";
	$messagetocc = $messagetocc."<br>Subject: ".$subject;
		$bodyy = str_replace(' ', '&nbsp;', $bodyy);

	$messagetocc = $messagetocc."<br>".nl2br($bodyy);
	$messagetocc = $messagetocc."<br><br><br>Note: This is an auto generated mail. Please do not reply.";
	
	  	$messagetocc = stripslashes($messagetocc);


	mail($tocc,$subject2,$messagetocc,$headers2);
    

  }

  
echo "<script type='text/javascript'>setTimeout('delayer()', 5000); function delayer(){
   window.location='Email.php?all=1';
}</script>";

}
}
/*------------Email Instruments list -------*/

if($emailtype==2 || $_GET['emailtypee']==2)
{
if($_GET['submit']!='yes' )
{
 
 	echo "<form name='myForm' id='myForm' method='post' enctype='multipart/form-data'  action='Email.php?submit=yes&inst=$instsel&emailtypee=2&emailgroup=$emailgroup'>";
	echo "<h2 class = 'Our'> Email Instrument List</h2>";
	 
//SELECT INSTRUMENT START
		
	include_once(DOCUMENT_ROOT."includes/database.php");
	//retrieve instrument name, number list
	$sql13 = "SELECT InstrumentName, InstrumentNo FROM instrument";
	$values=mysql_query($sql13) or die("An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
		//$row33 = mysql_fetch_array($values); 
		$instcount=0;
	while($row33 = mysql_fetch_array($values))
	{
		$instlist[$instcount]=$row33['InstrumentName'];
		$instnolist[$instcount]=$row33['InstrumentNo'];
	 
		$instcount++;
	}
	$jj=0;
	$selectedinstr = $_GET['inst'];
	
	echo "Select Instrument: <select id='instlist' >";
	while($jj<$instcount)
	{
		if (  $jj == 0 ){
			$checked='selected';
			echo "<option ".$checked." >";
		echo "--Please select an Instrument--";
		echo "</option>";
		$checked='';
		if($selectedinstr ==  $instlist[$jj] ){
			$checked='selected';
		}
		echo "<option ".$checked." >";
		echo $instlist[$jj];
		echo "</option>";
		}
		else{
			$checked='';
		 if($selectedinstr ==  $instlist[$jj] ){
			$checked='selected';
		}
		echo "<option ".$checked." >";
		echo $instlist[$jj];
		echo "</option>";
		}
		$jj++;
	}
	echo "</select>";
	

   
  switch ($emailgroup) {
    case 0:
        $selval0 ="selected";
         break;
    case 1:
        $selval1 ="selected";
        break;
    case 2:
        $selval2 ="selected";
        break;
	 case 3:
         $selval3 ="selected"; 
        break;
	 case 4:
         $selval4 ="selected";
        break;
 	}
	
	echo "  <select id='emailgroup' name='emailgroup' >
		 
		  <option value='0' $selval0>Select Users</option>
 		  <option value='1' $selval1>All Users</option>
		  <option value='2' $selval2>Life Science</option>
		  <option value='3' $selval3>Physical Science</option>
		  <option value='4' $selval4>Both Life Science & Physical Science</option>
 		</select>  ";
?>
		
		<input type="button" name="go" id="go" onClick="javascript:instclicked()" value="Load Users" >
		
	<script type="text/javascript">
			function instclicked()
	{
		
	var instrindex = document.getElementById('instlist').selectedIndex;
	if(instrindex==0){
		alert('Please Select Instrument Name');	
		return;
	}
	var instr=document.getElementById('instlist').options[instrindex].value;
	
	var emailindex = document.getElementById('emailgroup').selectedIndex;
	if(emailindex==0){
		alert('Please Select List of Users');	
		return;
	}
	var emailgroup=document.getElementById('emailgroup').options[emailindex].value;
 	
 	var url="Email.php?all=2&inst="+instr+"&emailgroup="+emailgroup;
	//alert(url);
	window.location =url;
	}
			
		</script>
		<br/>
<!-- SELECT INSTRUMENT END	-->
<?
 
 	 include_once('constants.php');
		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
$SelectedDB = mysql_select_db($dbname) or die ("Error in DBbb");
 
//retrieve instrument name, number list
 
	$sql13 = "SELECT InstrumentName, InstrumentNo FROM instrument where InstrumentName='$instsel'";
	$values=mysql_query($sql13) or die("An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
	 
	$instcount=0;
 
	while($row33 = mysql_fetch_array($values))
	{
	
		$instlist[$instcount]=$row33['InstrumentName'];
		$instnolist[$instcount]=$row33['InstrumentNo'];
		$instcount++;
	}

	//retrieve instrument number, emailid list from instr_group
 
	$sql13 = "SELECT Email, InstrNo FROM instr_group where InstrNo='$instnolist[0]'";
	$values=mysql_query($sql13) or die("An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
	 
	while($row33 = mysql_fetch_array($values))
	{
	
		$instr_groupNolist[$instr_groupcount]=$row33['InstrNo'];
		$instr_groupEmaillist[$instr_groupcount]=$row33['Email'];
 
		$instr_groupcount++;
	
	}

 	echo "<br><table id='email_list' style='display:none;' width='100%' cellspacing='0' border='1'>";
	 
	echo "<tr><td><b>No. </b></td><td><b>Name</b></td> <td><b>Opt in </b></td> <td><input type='checkbox' name='AllSelected'   id='AllSelected' value='AllSelected'  onClick='selectall()' checked/><b>All&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Email</b></td></tr>";

	if ($instcount==0)
	{
		echo "<tr><td colspan =4><center><b>No Records Found</center></b></td></tr>";
	}
 
 	$displayString="";
	if($emailgroup==1){
				$sql13 = "SELECT FirstName, LastName, Email, MailingListOpt, ActiveUser FROM user where ActiveUser='active' and Email like '%@%' and Email IN (SELECT Email FROM instr_group where InstrNo='$instnolist[0]') ORDER BY FirstName";	
				$displayString="All Users";
	}
  	else if($emailgroup==2){
				$sql13 = "SELECT FirstName, LastName, Email, MailingListOpt, ActiveUser FROM user where ActiveUser='active' and Email like '%@%' and Email IN (SELECT Email FROM instr_group where InstrNo='$instnolist[0]') and FieldofInterest='Life Science' ORDER BY FirstName";
				$displayString="Life Science Users";
	}else if($emailgroup==3){
				$sql13 = "SELECT FirstName, LastName, Email, MailingListOpt, ActiveUser FROM user where ActiveUser='active' and Email like '%@%' and Email IN (SELECT Email FROM instr_group where InstrNo='$instnolist[0]') and FieldofInterest='Physical Science' ORDER BY FirstName";
				$displayString="Physical Science Users";
	}else if($emailgroup==4){
		$sql13 = "SELECT FirstName, LastName, Email, MailingListOpt, ActiveUser FROM user where ActiveUser='active' and Email like '%@%' and Email IN (SELECT Email FROM instr_group where InstrNo='$instnolist[0]') and FieldofInterest='Life Science,Physical Science' ORDER BY FirstName";
		$displayString="Life Science & Physical Science Users";
	}
 	
 	$values=mysql_query($sql13) or die("An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
 	$totalemailcountuser=0;

 	while($row33 = mysql_fetch_array($values))
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
	echo "<td><center><font color='black'><input type='checkbox' name='emailoptin[]' id='emailoptin' onClick='showUser()' value='".$emaillist2[$totalemailcountuser]."'/></font></center></td>";

	echo "<td><font color='$color'><input type='checkbox' name='email[]' id='email' value='".$emaillist2[$totalemailcountuser].":".$fullname[$totalemailcountuser]."' ".$disabled." checked/>&nbsp;".$emaillist2[$totalemailcountuser]."</font></td></tr>";//<br>";
 		$totalemailcountuser++;
  
	}

	echo "</table>";
	echo "<p id='note' style='display:none;'><font color='#FF0000'>Note: Names in Red have opted out of the mailing list</font><br></p>";
 
 	echo "<input type='hidden' id='Emailclicked' name='Emailclicked' />";
	echo "<input type='hidden' id='all' name='all' />";
	
	echo "<br><table id='email_form' style='display:none;' border='1' cellspacing='0'";
	echo "<tr>";
	echo "<td>";

	echo "<br>To<br><input type='text' size='50' name='tocc' value='curulli@usc.edu'/><br>"; 
 	echo "<br>CC<br><input type='text' size='50' name='cc' value=''/><br>"; 
	echo "<br>Subject<br><input type='text' size='30' name='subj' value='$instsel'/><br>"; 
	
	echo "<br> <label for='file'>Attach file:</label>
<input type='file' name='file' id='file'><br> ";

	echo "Body<br><TEXTAREA NAME='bod' COLS=40 ROWS=6 wrap='physical'></TEXTAREA><br><br>";
	
	echo "<center><input type='submit' name='submit' value='Send' align='center'/></center>";
 	echo "<input type='hidden' id='Subjectt' name='Subjectt' value='none' />";
	echo "<input type='hidden' id='Body' name='Bodyy' />";
	echo "</td></tr>";
	echo "</table>";
	echo "</form>";
	}
else //after clicking on email button
{
  
$fileName = $_FILES["file"]["name"];
 echo "Filename is : ".$fileName; 
 $fileUploaded = false;

  //if(in_array($extension, $allowedExts)){
	if ($_FILES["file"]["error"] > 0)
	  {
	 	 echo "Error : ";
 	  }
	else
	  {
 			  if ( move_uploaded_file($_FILES["file"]["tmp_name"], DOCUMENT_ROOT."emailattachments/".$fileName ) )
			   {  
			  	echo "<br/><b>File '$fileName' attached successfully</b>". "<br>"; // need to style this information
 			   }else{
 			 	 echo "<br/><b>Could not save file.</b>". "<br>"; // need to style this information
			  }
	  }
 
// EMAIL INSTRUMENT MODULE ENDS

  $emailss = $_POST['email']; //checkboxes
  $emailsoptin = $_POST['emailoptin'];
  $subj=$_POST['subj'];
  $bodyy = $_POST['bod'];
  $copyy = $_POST['cc'];
  $tocc=$_POST['tocc'];
 
 	echo "<h2 class = 'Our'> Email Instrument List</h2>";

   echo "<br>Page will Reload after 5 seconds..."."<br><br>";

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
 
$headers = 'From: cemma@usc.edu' . "\r\n". 'MIME-Version: 1.0'	. "\r\n" ."Content-type: text/html; charset=iso-8859-1";

    for($i=0; $i < $N; $i++)
    {
	
	$j=$i+1;
	$subject = "".$subj;
	$emailandname=explode(":",$emailss[$i]);
	$emails[$i]=$emailandname[0];
	$names[$i]=$emailandname[1];
    echo "$j. ".$names[$i].": ".$emails[$i]."<br> ";
 
    //echo("$j. ".$emails[$i] . "<br> ");

	$to = $emails[$i];
 
	$bodyy = str_replace(' ', '&nbsp;', $bodyy);

$message = "Hello ". $names[$i]. ",<br><br>".nl2br($bodyy)."<br><br>Center for Electron Microscopy and Microanalysis<br><br>
	<span style='color:#980F07;'>University of Southern California</span><br>814 Bloom Walk<br>CEM Building<br>Los Angeles, CA 90089-1010
	<br>Tel:   &nbsp;&nbsp;213.740.1990<br>Fax: 213.821.0458";

 	$message = $message."<br><br>You are receiving this e-mail because you have an active account with the Center for Electron Microscopy and Microanalysis (CEMMA). To Unsubscribe from this e-mail communications, click <a href='http://cemma-usc.net/cemma/testbed/EmailOptOut.php?email=curulli@usc.edu&first=true'>Unsubscribe</a>";
	$message = $message."<br><br>Note: This is an auto generated mail. Please do not reply.";
	
		$mail = new PHPMailer;
		$mail->From = 'cemma@usc.edu';
		$mail->FromName = 'CEMMA';
		
		 
		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		$mail->addAttachment(DOCUMENT_ROOT."emailattachments/".$fileName);         // Add attachments
		$mail->isHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = $subject;
		$mail->Body    = $message ;
		$mail->AltBody = $message ;
		$mail->addAddress($to, $to);   
		
		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} 
		
	//mail($to,$subject,$message,$headers);
    }
 
	$subject2=$instsel.' Group Email: '.$subj;
	 
	$from2 = "cemma@usc.edu";//."\r\n"."CC: $copyy";
	$headers2= "From: $from2";
	$headers2 .= "\r\nCc: $copyy";
	$headers2 .= "\r\n". 'MIME-Version: 1.0'	. "\r\n" ."Content-type: text/html; charset=iso-8859-1";

	$messagetocc='"'.$instsel.'" Group Email:';
	if( $N==1)
		$messagetocc=$messagetocc."<br><br>Email has been sent to $N user: <br>";
	if( $N>1)
		$messagetocc=$messagetocc."<br><br>Emails have been sent to $N users: <br>";
	 
	for($j=0; $j < $N; $j++)
	    {	$k=$j+1;
			
			$messagetocc=$messagetocc.$k.". ".$names[$j]."- ".$emails[$j]." <br>";

		}
		
 	$bodyy = str_replace(' ', '&nbsp;', $bodyy);

	$messagetocc=$messagetocc."<br>The Message is as follows: <br>";
	$messagetocc = $messagetocc."Subject: ".$subj;
	$messagetocc = $messagetocc."<br>".nl2br($bodyy);
	$messagetocc = $messagetocc."<br><br>Note: This is an auto generated mail. Please do not reply.";
	mail($tocc,$subject2,$messagetocc,$headers2);
     

  }
echo "<script type='text/javascript'>setTimeout('delayer()', 5000); function delayer(){
   window.location='Email.php?all=2&inst=$instsel&emailgroup=$emailgroup'; }</script>";

}


}
?>
<? //echo "pop".$count; ?>

  <script type='text/javascript'>
  var AllSelected=1;
 // selectall();
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

  function selectnone()
  {
	var totalcount=0;
	totalcount="<?=$count?>";
	//alert('all '+totalcount);
	var i=0;
	for(i=0;i<totalcount;i++)
	{
		document.myForm.email[i].checked=false;
	}
  }
  
  <? if($instsel!='') {
		echo 'document.getElementById("email_list").style.display="inline";';
		echo 'document.getElementById("note").style.display="block";';
		echo 'document.getElementById("email_form").style.display="inline";';
	} else {
		echo 'document.getElementById("email_list").style.display="none";';
		echo 'document.getElementById("note").style.display="none";';
		echo 'document.getElementById("email_form").style.display="none";';
	}
?>
</script>

 <? include (DOCUMENT_ROOT.'EndCode.php'); ?> 