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
    	<table border="0" cellpadding="0" cellspacing="0" align="center"><tr>
      
       <td>
                
        <h2 class = "Our"> Manage Instruments</h2>
		

		<form action = "instruments.php" method="post" name="myForm">
		<input type="hidden" name = "o" id = "o" value = "<?=$_POST['o']?>">
		<input type = "hidden" name="orderby" id = "orderby" value = "<?=$_POST['orderby']?>">
		
		<? //Check if user has asked to remove a record
			
			$msg = '';
			if(isset($_GET['action']) && $_GET['action'] == 3){
				$rm = new InstrumentDAO();
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
        
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr> <td class="t-top">
		<!--	{width:573px; height:43px; vertical-align:top; background:url(../images/table-top-bg.gif) no-repeat top left; padding:14px 15px 12px 12px; 
			
			<td width=100% height=43px; BACKGROUND="images/table-top-bg-11.gif">
			-->
						
			<? 
			//Getting Instrument Details
//			include_once("olddatabase.php");
			$rs = new InstrumentDAO();
			$rs->getList(50,$_POST['orderby'],$_POST['o']);
			$currentRowNum = $rs->getStartRecord()*1; 
			?>     
						
            <div class="title">Instrument Details</div>
            <div class="details"><?=$rs->getRecordsBar()?></div>
            <div class="pagin"><?=$rs->getPageNav()?> <? echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ?> </div>
			
			</div>
            </td></tr>
            <tr><td class="t-mid">

              <table cellpadding="0" cellspacing="0" border="0" class="Tcontent">
                <tbody>
                  <tr bgcolor="#F4F4F4" align="center" class="Ttitle">
                    <td width="30" >No</td>
                    <td width="200" onClick="javascript:doAction(1, 1)">Name</td>
                    <td width="200"  onclick="javascript:doAction(1, 2)">Comment</td>
					<td width="200"  onclick="javascript:doAction(1, 2)">Service Category</td>
                    <td width="50" onClick="javascript:doAction(1, 3)">Availability</td>
                    <td width="40">Edit</td>
					<!-- <td width="40">Email</td>-->
                    <? if($_SESSION['ClassLevel']==1) {?>
                    <td width="55">Delete</td>
                    <? } ?>
                  </tr>
				  
				  <?php
				  
				  // If there are no records
				  
				  if($rs->getTotalRecords() == 0){
				  
				  ?>

				  <tr align="center">
				   		<td colspan = "7">No Records Found</td>
				  </tr>

				  <?php
				  }
				  
				  else{
				  
				  // There are some records
				  
				   while ($row = $rs->fetchArray()){ ?>     

				  <tr  class="Trow">
                    <td align="center" valign="top"><?=$currentRowNum?></td>
                    <td align="center" valign="top"><?=$row['InstrumentName']?></td>
                    <td align="center" valign="top"><?=$row['Comment']?></td>
					<td align="center" valign="top"><?=$row['Type']?>
			<!-- Type-->
					</td>
                    <td align="center" valign="top"><?=$row['Availablity']==1 ? 'Yes':'No'?></td>
                    
                    <td align="center" valign="top">
						<!--<a href="javascript:doAction(2,<?=$row['InstrumentNo']?>)">
						<img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0" class="tableimg" />
						</a>	-->
						<a href="modify_instrument.php?id=<?=$row['InstrumentName']?>">
						<img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0" class="tableimg" />
						</a>
					</td>
                        
					<? if($_SESSION['ClassLevel']==1) {?>
                    <td align="center" valign="top">
						<a href="javascript:doAction(3,<?=$row['InstrumentNo']?>)">
							<img src="images/trash_icon.gif" alt="Remove" width="10" border="0" />
						</a>
					</td>
                    <? } ?>
			
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
					<? if($_SESSION['ClassLevel']==1) {?>
                    <a href="EmailInstrStatus.php" target="popup" onClick="wopen('EmailInstrStatus.php', 'popup', 500, 400); return false;"> 
						Email All-Instruments Status</a>&nbsp;&nbsp;
					 <a href="add_instrument.php?id=&submit_mode=add">New Instrument</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     
                      <? } ?>
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
   

