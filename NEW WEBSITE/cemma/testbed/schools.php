<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//	header('Location: login.php');
	}
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
//	include_once("includes/instrument_action.php")
 ?>
 
     <table border="0" cellpadding="0" cellspacing="0" width="100%">   
	
	<tr><td class="body" valign="top" align="center">
    <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="left"><tr><td class="left" valign="top">
		
      	</td>
      
       <td>
                
        <h2 class = "Our"> Instrument Types</h2>
		

		<form action = "" method="post" name="myForm">
		<input type="hidden" name = "o" id = "o" value = "<?=$_POST['o']?>">
		<input type = "hidden" name="orderby" id = "orderby" value = "<?=$_POST['orderby']?>">
		
		<? //Check if user has asked to remove a record
			/*
			$msg = '';
			if(isset($_GET['action']) && $_GET['action'] == 3){
				$rm = new userDAO();
				$rm->remove($_GET['id']);
				$msg = "Instrument has been removed successfully";
			}
			
*/
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
        
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr><td class="t-top">
					
			<? 
			//Getting Instrument Details
			
			//$rs = new userDAO();
			//$rs->getList(10,$_POST['orderby'],$_POST['o']);
			//$currentRowNum = $rs->getStartRecord()*1; 
//mysql_close($connection);
			//include_once(DOCUMENT_ROOT."includes/database.php");
			$sql13 = "SELECT SchoolNo, SchoolName FROM Schools ORDER BY SchoolNo";
			$values=mysql_query($sql13) or die("An error has occurred in query12: " .mysql_error (). ":" .mysql_errno ()); 
			
			?>     
						
            <div class="title">School Details</div>
            <div class="details"><?#$rs->getRecordsBar()?></div>
            <div class="pagin"><?#$rs->getPageNav()?></div>
			
			</div>
            </td></tr>
            <tr><td class="t-mid">


              <table align="center" cellpadding="0" cellspacing="0" border="0" class="Tcontent">
                <tbody>
                  <tr bgcolor="#F4F4F4" align="center" class="Ttitle">
                    <td width="30" >No</td>
                    <!--<td width="350" >Type ID</td>-->
					<td width="700" >School Name</td>
                    <td width="55">Edit</td>
                   <td width="55">Remove</td> 
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
				?>
				  <tr  class="Trow">
                    <td align="center" valign="top"><?=$currentRowNum?></td>
					<!--<td align="center" valign="top"><?=$row['SchoolNo']?></td>-->
                    <td align="center" valign="top"><?=$row['SchoolName']?></td> 
                    <td align="center" valign="top">
					

						<a href="modify_school.php?id=<?=$row['SchoolNo']?>"> 
						<img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0" class="tableimg" />
						</a>
					</td> 

                    <td align="center" valign="top">
						<a href="RemoveSchool.php?id=<?=$row['SchoolNo']?>"> 
							<img src="images/trash_icon.gif" alt="Remove" width="10" border="0" />
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
					
					 <a href="AddSchool.php?id=&submit_mode=add">New School</a>&nbsp;&nbsp;
				</td>
            </tr>
        </table>
		
		</form>
		
        
      </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>
  
</td></tr></table>

<script language='javascript'>
function wopen(url, name, w, h)
{
// Fudge factors for window decoration space.
 // In my tests these work well on all platforms & browsers.
//w += 32;
//h += 96;
/*
 var win = window.open(url,
  name,
  'width=' + w + ', height=' + h + ', ' +
   'toolbar=no, scrollbars=1, menubar=no,location=no, directories=no, status=no'');
 win.resizeTo(w, h);
 win.focus()*/

 window.open ('EmailInstrStatus.php', 'newwindow', config='height=400,width=490, scrollbars=1, menubar=no,location=no, directories=no, status=no');
}
</script>
   <? include ('tpl/footer.php'); ?>
   

