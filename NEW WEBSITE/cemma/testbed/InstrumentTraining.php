<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//	header('Location: login.php');
	}
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/instrument_action.php");
	include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

	$deleteRequest = $_GET['delete'];			
	if($deleteRequest==1)
	{
		$userName = $_GET['userName'];	
		$instrNo = $_GET['instrNo'];	
 		 
		$sql = "DELETE from INSTRUMENT_REQUEST_STATUS where UserName='$userName' and InstrNo='$instrNo'";
		mysql_query($sql) or die("An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
		
	}
	
 ?>
 
     <table border="0" cellpadding="0" cellspacing="0" width="100%">   
	
	<tr><td class="body" valign="top" align="center">
    <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="left"><tr><td class="left" valign="top">
		</td>
      
       <td>
                
        <h2 class = "Our"> Training Requests</h2>
		

		<form action = "instruments.php" method="post" name="myForm">
		<input type="hidden" name = "o" id = "o" value = "<?=$_POST['o']?>">
		<input type = "hidden" name="orderby" id = "orderby" value = "<?=$_POST['orderby']?>">
		
		<? //Check if- user has asked to remove a record
			
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
		<table width="99%" border="0" cellpadding="2" cellspacing="0" >
		<tbody>
            <tr>
			<td class="t-top">	
						
			<? 
			//Getting Instrument Details
			
			//$rs = new userDAO();
			//$rs->getList(10,$_POST['orderby'],$_POST['o']);
			//$currentRowNum = $rs->getStartRecord()*1; 

			include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
			$sql13 = "SELECT UserName, Email, InstrNo, InstrumentName, DATE_FORMAT(requested_date, '%m-%d-%Y') as requested_date from INSTRUMENT_REQUEST_STATUS";
			$values=mysql_query($sql13) or die("An error has occurred in query1: " .mysql_error (). ":" .mysql_errno ()); 
			
			?>     
						
            <div class="title">Training Requested for below Instruments</div>
            <!-- <div class="details"><?#$rs->getRecordsBar()?></div>
            <div class="pagin"><?#$rs->getPageNav()?></div>
			-->
			</div>
            </td></tr>
            <tr><td class="t-mid">

              <table cellpadding="0" cellspacing="0" border="0" class="Tcontent">
                <tbody>
                  <tr bgcolor="#F4F4F4" align="center" class="Ttitle">
                    <td width="30" >No</td>
                    <td width="200">User Name</td>
                    <td width="100">Email</td>
                    <td width="250">Instrument Name</td>
                    <td width="35">Date</td>
					<td width="75">Approve Request</td>
                    <td width="75">Delete Request</td>
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
 					  // echo "god ".$temp;
	?>

<?if ($currentRowNum%2==0) {?>
				  <tr  class="TrowAlt" id="datarow<? echo $currentRowNum; ?>">

				  <? } else { ?>
				   <tr  class="Trow" id="datarow<? echo $currentRowNum; ?>">
				   <? }?> 
                    <td align="center" valign="top"><?=$currentRowNum?></td>
                    <td align="center" valign="top"><?=$row['UserName']?></td>
                    <td align="center" valign="top"><?=$row['Email']?></td>
             
					<td align="center" valign="top">
					
						<?=$row['InstrumentName']?>
					</td> 

					<td align="center" valign="top">
 						<?=$row['requested_date']?>
					</td> 
                    
					<td align="center" valign="top">
 							<a href="ApproveInstrument.php?userName=<?=$row['UserName']?>&email=<?=$row['Email']?>&instrNo=<?=$row['InstrNo']?>&instrName=<?=$row['InstrumentName']?>">
							<img src="images/approve_instrument.JPG" alt="Remove" width="30" height="20" border="0" />
						</a>
					</td>
                    
                    <td align="center" valign="top">
                    	<!-- delete request onclick are you sure etc .. php request send -->
 	<!--			<a href="InstrumentTraining.php?userName=<?=$row['UserName']?>&instrNo=<?=$row['InstrNo']?>&delete=1"> -->
		<a href="#" onclick="confirmDelete('<?php echo $row['UserName'] ?>', '<?php echo $row['InstrNo'] ?>' )"> 

							<img src="images/close.png" alt="Remove" width="20" height="20" border="0" />
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
 				</td>
            </tr>
		</tbody>
        </table>

</td>

<td>
<table >
<tr >
<div id="txtHint" style="background-color:white; position: fixed; top: 130px; right: 15px; color=#666666" BGCOLOR='#FF00FF'></div>
<!--
<div id="UserDetails" style="background-color:white; position: fixed; top: 300px; right: 55px; color=#666666" BGCOLOR='#FF00FF'><b><u>Hover over Usernames to display details here</u></b></div> -->
</table>

		</form>
        
      </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>
  
</td></tr></table>

<script language='javascript'>
function confirmDelete( userName, instrNo )
{
	var value = confirm('Are you sure you want to delete request ?');
	if(value == true )
	{
		window.location = "InstrumentTraining.php?userName="+userName+"&instrNo="+instrNo+"&delete=1";
	}
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
</script>
   <? include ('tpl/footer.php'); ?>
   

