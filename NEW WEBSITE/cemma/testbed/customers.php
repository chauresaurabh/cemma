<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/database.php");
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//	header('Location: login.php');
	}
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
	include_once(DOCUMENT_ROOT."includes/buildViewComponent.class.php");
	
 ?>
 
    <script type="text/javascript">
		var daoClassName = "CustomerDAO";	
	</script>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">   
		<tr>
			<td class="body" valign="top" align="center">
				<table border="0" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td class="body_resize">
							<table border="0" cellpadding="0" cellspacing="0" align="left">
								<tr>
									<td class="left" valign="top">
										<? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?> 
									</td>
									<td>
										<h2 class = "Our"><img src = "images/h2_servises.gif" style="margin-right:10px; vertical-align:middle">Manage Customers</h2>

		<!-- <input type="hidden" name = "o" id = "o" value = "<?=$_POST['o']?>">
		<input type = "hidden" name="orderby" id = "orderby" value = "<?=$_POST['orderby']?>"> -->
		
										<? //Check if user has asked to remove a record
											$msg = '';
											if(isset($_GET['action']) && $_GET['action'] == 3){
												$rm = new CustomerDAO();
												$rm->remove($_GET['id']);
												$msg = "Customer has been removed successfully";
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
        
		<!-- <table width="100%" border="0" cellpadding="5" cellspacing="0">
             <tr><td class="t-top"> -->
			
			
						
										<? 
										//Getting Customer Details
										//mysql_close($connection);
										//include_once(DOCUMENT_ROOT."includes/database.php");
										#$rs1 = new CustomerDAO();
										#$rs1->getList(10,$_POST['orderby'],$_POST['o']);
										
										/**************/
										$rs = new CustomerDAO();
										$rs->getList(10,'Name',0);
										while ($row = $rs->fetchObject()) {
											#if($row['Activated']==1)
											
												$objectCollection[] = $row;
											
										}

										$buildViewComponent = new BuildViewComponent(1, 'asc', 'Name', 10, $objectCollection, $rs->getStartRecord(),$rs->getTotalRecords(),'','');
										$buildViewComponent->displayComponent($buildViewComponent->viewComponent);
										echo '<div id = "objectTable">';
										echo $buildViewComponent->output;
										echo '</div>';
										
										/*****************/
										$currentRowNum = $rs->getStartRecord()*1; 
										?>
						
										<form action = "customers.php" method="post" name="customer" id="customer">
									
											<input type="hidden" id = "firstResult" value="1" />
											<input type="hidden" id = "sortOrder" value="asc" />
											<input type="hidden" id = "sortColumn" value="Name" />
											<input type="hidden" id = "searchFlag" value="0" />        
											<input type="hidden" id = "maxResults" value="10" />
											<input type="hidden" id = "totalRecords" value="<?=$rs->getTotalRecords();?>" />
			<?
			/*
			
            <div class="details"><?=$rs->getRecordsBar()?></div>
			
            <div class="pagin"><?=$rs->getPageNav()?></div>
			
			</div>
            </td>
			 
			</tr>
            <tr>
			<td class="t-mid">


              <table align="center" cellpadding="0" cellspacing="0" border="0" class="Tcontent">
                <tbody>
                  <tr bgcolor="#F4F4F4" align="center" class="Ttitle">
                    <td width="30" >No</td>
                    <td width="145" onclick="javascript:doAction(1, 1)">Name</td>
                    <td width="90"  onclick="javascript:doAction(1, 2)">Username</td>
                    <td width="145" onclick="javascript:doAction(1, 3)">Email</td>
                    <td width="70" onclick="javascript:doAction(1, 4)">Activated</td>
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
  				   $useAltRowStyle = true;
				   $dataCellStyle = 'Trow';
				   				  
				   while ($row = $rs->fetchArray()){
				   
				   ?>     

				  <tr  class="<?=$dataCellStyle?>">
                    <td align="center" valign="top"><?=$currentRowNum?></td>
                    <td align="center" valign="top"><?=$row['Name']?></td>
                    <td align="center" valign="top"><?=$row['Uname']?></td>
                    <td align="center" valign="top"><?=$row['EmailId']?></td>
                    <td align="center" valign="top"><?=$row['Activated']==1?'Yes':'No'?></td>
                    
                    <td>
						<a href="javascript:doAction(2,<?=$row['Customer_ID']?>)">
						<img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0" class="tableimg" />
						</a>	
					</td>
					
                    <td>
						<a href="javascript:doAction(3,<?=$row['Customer_ID']?>)">
						<!--	<img src="images/trash_icon.gif" alt="Remove" width="10" border="0" /> -->
						</a>
						
					</td>
                  </tr>
				  
				  	<? 
						$currentRowNum++;
						if($useAltRowStyle){
							$dataCellStyle = 'TrowAlt';
							$useAltRowStyle = false;
						}
						else{
							$dataCellStyle = 'Trow';
							$useAltRowStyle = true;
						}

					}

					}
				*/	 
			?>
										</form>
									</td>
								</tr>
							</table>
							<div class="clr"></div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

<? include ('tpl/footer.php'); ?>
   

