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
    	<table border="0" cellpadding="0" cellspacing="0" align="left"><tr><td class="left" valign="top">
		</td>
      
       <td>
                
        <h2 class = "Our"> New Requests</h2>
		

		<form action = "instruments.php" method="post" name="myForm">
		<input type="hidden" name = "o" id = "o" value = "<?=$_POST['o']?>">
		<input type = "hidden" name="orderby" id = "orderby" value = "<?=$_POST['orderby']?>">
		
		<? //Check if user has asked to remove a record
			
			$msg = '';
			if(isset($_GET['action']) && $_GET['action'] == 3){
				$rm = new userDAO();
				$rm->remove($_GET['id']);
				$msg = "Instrument has been removed successfully";
			}
			

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
        
<table border="0" width="100%">

<tr>
<td>
		<table width="70%" border="0" cellpadding="5" cellspacing="0" >
		<tbody>
            <tr>
			<td class="t-top">	
						
			<? 
			//Getting Instrument Details
			
			//$rs = new userDAO();
			//$rs->getList(10,$_POST['orderby'],$_POST['o']);
			//$currentRowNum = $rs->getStartRecord()*1; 

			include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
			$sql13 = "SELECT UserName,LastName,Email, FirstName,FieldofInterest,TransferredToUsers, DATE_FORMAT(SubmittedDate, '%m-%d-%Y') as SubmittedDate  FROM UsersInQuery where TransferredToUsers != 1 ORDER BY FirstName";
			 
			$values=mysql_query($sql13) or die("An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ()); 
			
			?>     
						
            <div class="title">User Details</div>
            <div class="details"><?#$rs->getRecordsBar()?></div>
            <div class="pagin"><?#$rs->getPageNav()?></div>
			
			</div>
            </td></tr>
            <tr><td class="t-mid">


              <table align="right" cellpadding="0" cellspacing="0" border="0" class="Tcontent">
                <tbody>
                  <tr bgcolor="#F4F4F4" align="center" class="Ttitle">
                    <td width="30" >No</td>
                    <td width="200" onClick="javascript:doAction(1, 1)">User Name</td>
                    <td width="100" >Request Date</td>
            	     <td width="55">Edit</td>
					<td width="155">Transfer To User</td>

                   <td width="155">Delete Request</td> 
                   </tr>
				  
				  <?php
				  $currentRowNum=1;
				  // If there are no records
				  $temp=0;
				  if($temp==1){
				  
				  ?>

				  <tr align="center">
				   		<td colspan = "7">No Records Found</td>
				  </tr>

				  <?php
				  }
				  
				  else{
				  
				  // There are some records
				  
				   while($row = mysql_fetch_array($values))
	{
					   $temp=$row['UserName'];
					  // echo "god ".$temp;
	?>

<?if ($currentRowNum%2==0) {?>
				  <tr  class="TrowAlt" id="datarow<? echo $currentRowNum; ?>">

				  <? } else { ?>
				   <tr  class="Trow" id="datarow<? echo $currentRowNum; ?>">
				   <? }?> 
                    <td align="center" valign="top"><?=$currentRowNum?></td>
                    <td align="center" valign="top" id="usertd<?echo $currentRowNum; ?>"  onMouseOver="document.getElementById('txtHint').style.display='';document.getElementById('UserDetails').style.display='none'; hover1(<? echo $currentRowNum.",'".$temp."'"; ?>)" onmouseout=" this.style.color='#666666';this.style.border='0'; document.getElementById('txtHint').style.display='none'; document.getElementById('UserDetails').style.display='';"><?=$row['UserName']?></td>
              <!--      <td align="center" valign="top"><?=$row['LastName']?></td>
					<td align="center" valign="top"><?=$row['Email']?>
			
					</td>
                    <td align="center" valign="top"><?=$row['FieldofInterest']?></td>
            -->
					
                    <td align="center" valign="top">
 					 	<?=$row['SubmittedDate']?>  
 					</td> 
                    
                    <td align="center" valign="top">
					
						<a href="EditQueryUsers.php?id=<?=$row['UserName']?>">
						<img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0" class="tableimg" />
						</a>
					</td> 

					<td align="center" valign="top">
				<!--		<a href="TransferToUsers.php?id=<?=$row['UserName']?>"> -->
				<a href="TransferUsersInQueryToUsers.php?id=<?=$row['UserName']?>">
							<img src="images/archive8.png" alt="Remove" width="15" height="15" border="0" />
						</a>
					</td>

                    <td align="center" valign="top">
						<a href="RemoveNewRequests.php?id=<?=$row['UserName']?>">
							<img src="images/trash_icon.gif" alt="Remove" width="10" border="0"  />
						</a>
					</td>
                  </tr>
				  
				  	<? 
					$currentRowNum++;
						}
						
					
					}
					
					 ?>
                  
                </tbody>
              </table>
			  
            </td>
            </tr>
            <tr>
				</td>
            	 <td class="t-bot2">
		<!--	 <a href="add_instrument.php?id=&submit_mode=add">New Instrument</a>&nbsp;&nbsp; -->
				</td>
            </tr>
		</tbody>
        </table>

</td>

<td>
<table >
<tr >
<div id="txtHint" style="background-color:white; position: fixed; top: 130px; right: 15px; color=#666666" BGCOLOR='#FF00FF'></div>
<div id="UserDetails" style="background-color:white; position: fixed; top: 300px; right: 55px; color=#666666" BGCOLOR='#FF00FF'><b><u>Hover over Usernames to display details here</u></b></div>
</table>

		</form>
        
      </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>
  
</td></tr></table>

<script language='javascript'>
function showalert()
{
	alert("Under Construction");
}
function showUser(temp1)
{
//alert("hi2");
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","GetNewRequestDetails.php?username="+temp1,true);
xmlhttp.send();
}

function hover1(no,temp2)
{
//alert("hi");
document.getElementById("usertd"+no).style.color="blue";
document.getElementById("usertd"+no).style.border="thin solid #0000FF"; //0000FF";
document.getElementById("usertd"+no).style.bgColor="thin solid #B3E0FF"; //0000FF";
showUser(temp2);

}

function test()
{
	alert('test');
	return false;
}
</script>
   <? include ('tpl/footer.php'); ?>
   

