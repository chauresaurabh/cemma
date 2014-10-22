<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	include_once("includes/action.php");
	include_once(DOCUMENT_ROOT."Objects/customer.php");
	include_once("includes/instrument_action.php");

?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td class="body" valign="top" align="center">
			<table border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td class="body_resize">
						<table border="0" cellpadding="0" cellspacing="0" align="center">
							<tr>
								<td class="left" valign="top">
									<?	include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
								</td>
								<td>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
						
	   
	
				
			
		
	
