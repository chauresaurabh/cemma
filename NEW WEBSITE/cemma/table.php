 <? include ('tpl/header.php'); ?>
 
    <table border="0" cellpadding="0" cellspacing="0" width="100%">   
    
    
    <tr><td class="body" valign="top" align="center">
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="left" valign="top">

         <? //include ('tpl/menu-loged-in.php'); ?> 
		 
		 <? //include ('tpl/aboutus.php'); ?>  
         
         <? include ('news.php'); ?>

         
      </td>
      
      <td class="right">
                
        <h2 class="Our">View Records/Invoices</h2>

        <p><strong>Select the Customer name and the period to view the records</strong></p>

    
        <table width="100%" border="0" cellpadding="5" cellspacing="0"> 
                    <tr valign="top"> 
                      <td width="100%"> 
						<div align="center" class="err" id="error">Error Detected</div>
						<div align="center" class="alert" style="font-size:13" id="error1">Hello World !!</div>
						<div align="center">
						<table width="450" class = "content" align="center" style="border:thin, #993300" >
						<form id="form1" name ="form1">
						<tr>
						<td class="lg-txt">Customer Name: *</td>
						<td><select  class="select" id= "CustomerName" name="CustomerName" style="font-weight:normal">

						<option value="Select the Customer">Select the Customer</option>
						<?
						$sql = "SELECT Name FROM Customer order by Name";
						$result = mysql_query($sql);
						while($row = mysql_fetch_array($result, MYSQL_ASSOC))
						{
						?>

						<option value = "<? echo $row['Name']; ?>"><? echo $row['Name']; ?></option>
						<?
						}


						?>
						</select></td></tr>
						<tr>
						<td class="lg-txt">Records Between: *</td>
						<td><select  class="select" id="frommonth" name="frommonth" style="font-weight:normal"></select><select id="fromyear" class="select" name="fromyear" style="font-weight:normal"></select>&nbsp;&nbsp; and &nbsp;&nbsp; <select id="tomonth" class="select" name="tomonth" style="font-weight:normal"></select><select id="toyear" class="select" name="toyear" style="font-weight:normal"></select></td>

						<script type = "text/javascript">
						
						document.getElementById("frommonth").options[0] = new Option("Jan","01");
						document.getElementById("frommonth").options[1] = new Option("Feb","02");
						document.getElementById("frommonth").options[2] = new Option("Mar","03");
						document.getElementById("frommonth").options[3] = new Option("Apr", "04");
						document.getElementById("frommonth").options[4] = new Option("May", "05");
						document.getElementById("frommonth").options[5] = new Option("Jun", "06");
						document.getElementById("frommonth").options[6] = new Option("Jul", "07");
						document.getElementById("frommonth").options[7] = new Option("Aug", "08");
						document.getElementById("frommonth").options[8] = new Option("Sep", "09");
						document.getElementById("frommonth").options[9] = new Option("Oct", "10");
						document.getElementById("frommonth").options[10] = new Option("Nov", "11");
						document.getElementById("frommonth").options[11] = new Option("Dec", "12");
						document.getElementById("fromyear").options[0] = new Option("2007");
						document.getElementById("fromyear").options[1] = new Option("2008");
						document.getElementById("fromyear").options[2] = new Option("2009");
						document.getElementById("fromyear").options[3] = new Option("2010");
						document.getElementById("fromyear").options[4] = new Option("2011");
						document.getElementById("fromyear").options[5] = new Option("2012");
						document.getElementById("fromyear").options[6] = new Option("2013");
						document.getElementById("fromyear").options[7] = new Option("2014");
						document.getElementById("tomonth").options[0] = new Option("Jan", "01");
						document.getElementById("tomonth").options[1] = new Option("Feb", "02");
						document.getElementById("tomonth").options[2] = new Option("Mar", "03");
						document.getElementById("tomonth").options[3] = new Option("Apr", "04");
						document.getElementById("tomonth").options[4] = new Option("May", "05");
						document.getElementById("tomonth").options[5] = new Option("Jun", "06");
						document.getElementById("tomonth").options[6] = new Option("Jul", "07");
						document.getElementById("tomonth").options[7] = new Option("Aug", "08");
						document.getElementById("tomonth").options[8] = new Option("Sep", "09");
						document.getElementById("tomonth").options[9] = new Option("Oct", "10");
						document.getElementById("tomonth").options[10] = new Option("Nov", "11");
						document.getElementById("tomonth").options[11] = new Option("Dec", "12");
						document.getElementById("toyear").options[0] = new Option("2007");
						document.getElementById("toyear").options[1] = new Option("2008");
						document.getElementById("toyear").options[2] = new Option("2009");
						document.getElementById("toyear").options[3] = new Option("2010");
						document.getElementById("toyear").options[4] = new Option("2011");
						document.getElementById("toyear").options[5] = new Option("2012");
						document.getElementById("toyear").options[6] = new Option("2013");
						document.getElementById("toyear").options[7] = new Option("2014");

						</script>



						</tr>
						</table>

						<br>
						<input type="button" name="submit" class="btnVR" value="" onClick = "showRecords(1, 1, 1);" />
						<input type="button" name="submit" class="btnVI" value="" onClick = "showInvoices();" />
						</form>
						</div>
						
			
			
			
			
				<div id = "div1"><p>&nbsp;</p></div></td></tr> 
                  </table>
                  
                  
        
        <table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr><td class="t-top">
            <div class="title">Records for Chongwu Zhou between 01 / 2007 and 01 / 2014</div>
            <div class="details">Showing Records 1 to 10 of 97</div>
            <div class="pagin"><a href="#">First</a>&nbsp;&nbsp;<a href="#">Previous</a>&nbsp;|&nbsp;<a href="#">Next</a>&nbsp;&nbsp;<a href="#">Last</a>&nbsp;&nbsp;<a href="#">View All</a></div>
            </td></tr>
            <tr><td class="t-mid">


              <table align="center" cellpadding="0" cellspacing = "0" border="0" width="100%">
                <tbody style="font-size:11px">
                  <tr bgcolor="#F4F4F4" align="center">
                    <td width="52" onClick="javascript:showRecords(1, 1, 0)">Date</td>
                    <td width="49" onClick="javascript:showRecords(1, 2, 0)">Quantity</td>
                    <td width="106" onClick="javascript:showRecords(1, 3, 0)">Instrument</td>
                    <td width="53" onClick="javascript:showRecords(1, 4, 0)">Operator</td>
                    <td width="60" onClick="javascript:showRecords(1, 5, 0 )">With Operator?</td>
                    <td width="50" onClick="javascript:showRecords(1, 6, 0)">Total</td>
                    <td width="62" onClick="javascript:showRecords(1, 7, 0)">Invoice No</td>
                    <td width="65"> Edit </td>
                    <td width="92">Remove</td>
                  </tr>
                  <tr align="center" height="15px">
                    <td height="15px">07/30/09</td>
                    <td height="15px">5.00</td>
                    <td height="15px">Film - EM Film TEM</td>
                    <td height="15px">Yue Fu</td>
                    <td height="15px">No</td>
                    <td height="15px">10.00</td>
                    <td height="15px"><a href="view_invoice2.php?invoiceno=3&Gdate=2009-08-05&name=Chongwu Zhou&pagenum=1" target="_blank">MO 10/3</a></td>
                    <td style="font-size:9px"><img src="images/edit_icon.png" width="16" hspace="0" vspace="0" border="0" align="absbottom" /></td>
                    <td height="15px" style="font-size:9px"></td>
                  </tr>
                  <tr align="center">
                    <td>07/30/09</td>
                    <td>1.30</td>
                    <td>Philips 420 - TEM</td>
                    <td>Yue Fu</td>
                    <td>Yes</td>
                    <td>91.00</td>
                    <td><a href="view_invoice2.php?invoiceno=3&Gdate=2009-08-05&name=Chongwu Zhou&pagenum=1" target="_blank">MO 10/3</a></td>
                    <td><a href="javascript:editRecord('557','3','2009-08-05')"><img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0"></a></td>
                    <td><a href="javascript:removeRecord('557')"><img src="images/trash_icon.gif" alt="Remove" width="10" border="0"></a></td>
                  </tr>
                  <tr align="center">
                    <td>07/24/09</td>
                    <td>1.00</td>
                    <td>JEOL 7001</td>
                    <td>Akshay</td>
                    <td>No</td>
                    <td><em>22.50</em></td>
                    <td><a href="view_invoice2.php?invoiceno=3&Gdate=2009-08-05&name=Chongwu Zhou&pagenum=1" target="_blank">MO 10/3</a></td>
                    <td><a href="javascript:editRecord('527','3','2009-08-05')"><img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0"></a></td>
                    <td><a href="javascript:removeRecord('527')"><img src="images/trash_icon.gif" alt="Remove" width="10" border="0"></a></td>
                  </tr>
                  <tr align="center">
                    <td>07/24/09</td>
                    <td>1.30</td>
                    <td>Philips 420 - TEM</td>
                    <td>Yue Fu</td>
                    <td>Yes</td>
                    <td>91.00</td>
                    <td><a href="view_invoice2.php?invoiceno=3&Gdate=2009-08-05&name=Chongwu Zhou&pagenum=1" target="_blank">MO 10/3</a></td>
                    <td><a href="javascript:editRecord('556','3','2009-08-05')"><img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0"></a></td>
                    <td><a href="javascript:removeRecord('556')"><img src="images/trash_icon.gif" alt="Remove" width="10" border="0"></a></td>
                  </tr>
                  <tr align="center">
                    <td>07/23/09</td>
                    <td>2.40</td>
                    <td>Philips 420 - TEM</td>
                    <td>Haitian</td>
                    <td>No</td>
                    <td><em>54.00</em></td>
                    <td><a href="view_invoice2.php?invoiceno=3&Gdate=2009-08-05&name=Chongwu Zhou&pagenum=1" target="_blank">MO 10/3</a></td>
                    <td><a href="javascript:editRecord('555','3','2009-08-05')"><img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0"></a></td>
                    <td><a href="javascript:removeRecord('555')"><img src="images/trash_icon.gif" alt="Remove" width="10" border="0"></a></td>
                  </tr>
                  <tr align="center">
                    <td>07/21/09</td>
                    <td>4.00</td>
                    <td>Film - EM Film TEM</td>
                    <td>Haitian</td>
                    <td>No</td>
                    <td>8.00</td>
                    <td><a href="view_invoice2.php?invoiceno=3&Gdate=2009-08-05&name=Chongwu Zhou&pagenum=1" target="_blank">MO 10/3</a></td>
                    <td><a href="javascript:editRecord('554','3','2009-08-05')"><img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0"></a></td>
                    <td><a href="javascript:removeRecord('554')"><img src="images/trash_icon.gif" alt="Remove" width="10" border="0"></a></td>
                  </tr>
                  <tr align="center">
                    <td>07/21/09</td>
                    <td>1.20</td>
                    <td>Philips 420 - TEM</td>
                    <td>Haitian</td>
                    <td>No</td>
                    <td><em>27.00</em></td>
                    <td><a href="view_invoice2.php?invoiceno=3&Gdate=2009-08-05&name=Chongwu Zhou&pagenum=1" target="_blank">MO 10/3</a></td>
                    <td><a href="javascript:editRecord('553','3','2009-08-05')"><img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0"></a></td>
                    <td><a href="javascript:removeRecord('553')"><img src="images/trash_icon.gif" border="0" alt="Remove"></a></td>
                  </tr>
                  <tr align="center">
                    <td>07/21/09</td>
                    <td>1.00</td>
                    <td>JEOL 7001</td>
                    <td>Haitian</td>
                    <td>No</td>
                    <td><em>22.50</em></td>
                    <td><a href="view_invoice2.php?invoiceno=3&Gdate=2009-08-05&name=Chongwu Zhou&pagenum=1" target="_blank">MO 10/3</a></td>
                    <td><a href="javascript:editRecord('522','3','2009-08-05')"><img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0"></a></td>
                    <td><a href="javascript:removeRecord('522')"><img src="images/trash_icon.gif" border="0" alt="Remove"></a></td>
                  </tr>
                  <tr align="center">
                    <td>07/16/09</td>
                    <td>2.00</td>
                    <td>JEOL 7001</td>
                    <td>Haitian</td>
                    <td>No</td>
                    <td><em>45.00</em></td>
                    <td><a href="view_invoice2.php?invoiceno=3&Gdate=2009-08-05&name=Chongwu Zhou&pagenum=1" target="_blank">MO 10/3</a></td>
                    <td><a href="javascript:editRecord('507','3','2009-08-05')"><img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0"></a></td>
                    <td><a href="javascript:removeRecord('507')"><img src="images/trash_icon.gif" border="0" alt="Remove"></a></td>
                  </tr>
                  <tr align="center">
                    <td>07/16/09</td>
                    <td>1.00</td>
                    <td>JEOL 7001</td>
                    <td>Akshay</td>
                    <td>No</td>
                    <td><em>22.50</em></td>
                    <td><a href="view_invoice2.php?invoiceno=3&Gdate=2009-08-05&name=Chongwu Zhou&pagenum=1" target="_blank">MO 10/3</a></td>
                    <td><a href="javascript:editRecord('508','3','2009-08-05')"><img src="images/edit_icon.png" alt="Edit" width="13" height="13" border="0"></a></td>
                    <td><a href="javascript:removeRecord('508')"><img src="images/trash_icon.gif" alt="Remove" width="13" height="13" border="0"></a></td>
                  </tr>
                </tbody>
              </table>
              
              
              
              
            </td>
            </tr>
            <tr><td class="t-bot">
            
            
            </td></tr>
        </table>
        
        
       




      </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>
  
</td></tr></table>
   <? include ('tpl/footer.php'); ?>