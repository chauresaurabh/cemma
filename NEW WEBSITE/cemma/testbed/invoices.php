<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	if($class != 1){
		header('Location: login.php');
	}
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/invoice_action.php")
 ?>
 
     <table border="0" cellpadding="0" cellspacing="0" width="100%">   
	
	<tr><td class="body" valign="top" align="center">
    <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="center"><tr>
      
       <td>
                
        <h2 class="Our">Manage Invoices</h2>
		

		<form action = "invoices.php" method="post" name="myForm">
		<input type="hidden" name = "o" id = "o" value = "<?=$_POST['o']?>">
		<input type = "hidden" name="orderby" id = "orderby" value = "<?=$_POST['orderby']?>">
		
		<? //Check if user has asked to remove a record
			
			$msg = '';
			if(isset($_GET['action']) && $_GET['action'] == 3){
				$rm = new InvoiceDAO();
				$rm->remove($_GET['id']);
				$msg = "Invoice has been removed successfully";
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
            <tr><td class="t-top">
			
			
						
			<? 
			//Getting Invoice Details
			
			$rs = new InvoiceDAO();
			$rs->getList(10,$_POST['orderby'],$_POST['o']);
			$currentRowNum = $rs->getStartRecord()*1; 
			
			?>     
						
            <div class="title">Invoice Details</div>
            <div class="details"><?=$rs->getRecordsBar()?></div>
            <div class="pagin"><?=$rs->getPageNav()?></div>
			
			</div>
            </td></tr>
            <tr><td class="t-mid">


              <table align="center" cellpadding="0" cellspacing="0" border="0" class="Tcontent">
                <tbody>
                  <tr bgcolor="#F4F4F4" align="center" class="Ttitle">
                    <td width="30" >No</td>
                    <td width="175" onClick="javascript:doAction(1, 1)">Name</td>
                    <td width="145" onClick="javascript:doAction(1, 3)">From</td>
					<td width="145" onClick="javascript:doAction(1, 3)">To</td>
					<td width="145" onClick="javascript:doAction(1, 3)">Total</td>
					<td width="145" onClick="javascript:doAction(1, 3)">PO</td>
                    <td width="70" onClick="javascript:doAction(1, 4)">Status</td>
                    <td width="40">Edit</td>
                    <td width="55">Remove</td>
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

				  <tr align="center" class="Trow">
                    <td><?=$currentRowNum?></td>
                    <td align="left"><?=$row['Name']?></td>
                    <td><?=$row['Fromdate']?></td>
                    <td><?=$row['Todate']?></td>
					<td><?=$row['Total']?></td>
					<td><?=$row['PO']?></td>
                    <td><?=$row['Status']?></td>
                    
                    <td>
						<a href="javascript:doAction(2,<?=$row['Number']?>)">
						<img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0" class="tableimg" />
						</a>	
					</td>
					
                    <td>
						<a href="javascript:doAction(3,<?=$row['Number']?>)">
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
            <tr><td class="t-bot">
            
            
            </td></tr>
        </table>
		</form>
		
        
      </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>
  
</td></tr></table>
   <? include ('tpl/footer.php'); ?>
   

