<?
	include_once('../constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	
?>
<?	include (DOCUMENT_ROOT.'tpl/header.php'); ?>
<?=$class?>|<?=$ClassLevel?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">   
		<tr>
			<td class="body" valign="top" align="center">
				<table border="0" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td class="body_resize">
							<table border="0" cellpadding="0" cellspacing="0" align="center">
								<tr>
									<td class="left" valign="top">
										<? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?> 
									</td>
									<td class="right">
										<table cellpadding="0" cellspacing="0" border="0" width="693px">
											<tr>
												<td>
													<div id="calback"> 
														<div id="calendar"></div>  
													</div>
												</td>
											</tr>
										</table>
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
  
	</td></tr>
</table>
   
<? include (DOCUMENT_ROOT.'tpl/footer.php'); ?>