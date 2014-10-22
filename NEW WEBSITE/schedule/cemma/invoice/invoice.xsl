 <xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
 <xsl:template match="/">
<html>
	<head>
	
		<title>
			CEMMA - Center for Electron Microscopy and Microanalysis
		</title>
	</head>
	<body background="white">
		<table cellspacing="0" cellpadding="10" border="0">
			<tr>
				<td align="right">
					<FORM>
						<table cellspacing="0" cellpadding="10" border="0">
						<tr>
							<td>
								<INPUT type="button" value="Back" onClick="history.back()"/>
							</td>	
							<td>
								<INPUT type="button" value="Print" onClick="window.print()"/>
							</td>
						</tr>
						</table>
					</FORM>
				</td>
			</tr>
			<tr>
				<td>
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tr>
							<td valign="top">
								<img src="http://www.cemma-usc.net/cemma/invoice/images/usc-logo.gif" />
							</td>
							<td width="40">
							</td>
							<td valign="top">
								<table cellspacing="0" cellpadding="0" border="0" width="100%">
									<tr>
										<td height="5">
										</td>
									</tr>
									<tr>
										<td colspan="3">
											
											<H2><font color="#990000">Center for Electron Microscopy and Microanalysis</font></H2>
											<font color="#990000">University of Sountern California<br/>CEM 200, CA 90089-0101<br/>(213)740-1990, Fax (213)821-0458</font>
										</td>
									</tr>
									<tr>
										<td height="10">
										</td>
									</tr>
									<tr>
										<td valign="center" width="600">
											<table cellspacing="0" cellpadding="0" border="0" width="100%">
												<tr>
													<td height="5" bgcolor="#990000">
													</td>
												</tr>
											</table>
										</td>				
										<td height="5" valign="bottom">
											<font color="#990000" size="4"> &#160;&#160;<b><i>INVOICE</i></b>&#160;&#160;</font>
										</td>
										<td valign="center" width="100">
											<table cellspacing="0" cellpadding="0" border="0" width="100%">
												<tr>
													<td height="5"  bgcolor="#990000">
													</td>
												</tr>
											</table>
										</td>	
									</tr>

								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
			
			<tr>
			
			<td>
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="60%">
							
							<fieldset> 
								<legend> Customer</legend>
									<table cellpadding="0" cellspacing="0" border="0">
									<tr>
									<td height="150" width="600">
									<table cellpadding="0" cellspacing="10" border="0">
										<tr>
											<td>
												<b>Name</b>
											</td>
											<td colspan="5">
												<div id="name"><xsl:value-of select="invoice/header/name"/></div>
											</td>
										</tr>
										<tr>
											<td>
												<b>Address</b>
											</td>
											<td colspan="5">
												<div id="address"><xsl:value-of select="invoice/header/address"/></div>
											</td>
										</tr>
										<tr>
											<td>
												<b>City</b>
											</td>
											<td width="150">
												<div id="city"><xsl:value-of select="invoice/header/city"/></div>
											</td>
											<td>
												<b>State</b>
											</td>
											<td width="150">
												<div id="state"><xsl:value-of select="invoice/header/state"/></div>
											</td>
											<td>
												<b>Zip</b>
											</td>
											<td width="150">
												<div id="city"><xsl:value-of select="invoice/header/zip"/></div>
											</td>

										</tr>
										<tr>
											<td>
												<b>Phone</b>
											</td>
											<td>
												<div id="phone"><xsl:value-of select="invoice/header/phone"/></div>
											</td>
											<td>
												<b>Fax</b>
											</td>
											<td colspan="3">
												<div id="fax"><xsl:value-of select="invoice/header/fax"/></div>
											</td>
										</tr>
									</table>
									</td>
									</tr>
									</table>
							
							</fieldset>
							
						</td>
						<td width="10%">
							&#160;
						</td>
						<td align="right" width="30%">
							<fieldset>
								<table cellpadding="0" cellspacing="0" border="0">
									<tr>
									<td height="155">
								<table cellpadding="5" cellspacing="5" border="0">
									<tr>
										<td>
											<b>Invoice Date</b>
										</td>
										<td width="150">
											<div id="date"><xsl:value-of select="invoice/header/date"/></div>
										</td>
									</tr>
									<tr>
										<td>
											<b>PO / Req #</b>
										</td>
										<td width="150">
											<div id="req"><xsl:value-of select="invoice/header/poreq"/></div>
										</td>
									</tr>

								</table>
								</td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height="20">
					
				</td>
			</tr>
			<tr>
				<td width="100%">
					<table border="1" width="100%">
						<tr>
							<td width="10%" height="20" align="center">
								<b>Qt.</b>
							</td>
							<td width="10%" align="center">
								<b>Date</b>
							</td>
							<td width="40%" align="center">
								<b>Description</b>
							</td>
							<td width="20%" align="center">
								<b>Unit Price</b>
							</td>
							<td width="20%" align="center">
								<b>TOTAL</b>
							</td>
						</tr>
						<xsl:for-each select="invoice/data/entry">
						<tr>
							<td width="10%">
								<xsl:value-of select="quantity"/>
							</td>
							<td width="10%">
								<xsl:value-of select="date"/>
							</td>
							<td width="40%">
								<xsl:value-of select="machine"/>, <xsl:value-of select="operator"/> &#160;Operator
							</td>
							<td width="20%">
								<xsl:value-of select="price"/> 
							</td>
							<td width="20%">
								<xsl:value-of select="total"/> 
							</td>
						</tr>
						</xsl:for-each>
					</table>
				</td>
			</tr>
			<tr>
				<td><center><font size="4"><b>Total = $<xsl:value-of select="invoice/grandtotal"/></b></font></center></td>
			</tr>
			<tr>
				<td height="20"></td>
			</tr>
			<tr>
				<td bgcolor="#990000" height="1"/>
			</tr>
			<tr>
				<td align="center">
					
					<font color="#990000">
						<br/><br/>Please return a Requisition or Checck for the total shown above to:<br/><br/>
						Attn: John Curulli
						<br/>University of Southern California
						<br/>Univeristy Park
						<br/>CEM 200, MC 0101
						<br/>Los Angeles, CA 90089-0101
						<br/>Checks should be payable to:
						<br/>University of Southern California		
					</font>
				</td>
			</tr>
		</table>
	<noscript/>
	</body>

</html>
</xsl:template>
  </xsl:stylesheet>