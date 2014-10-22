 <? include ('tpl/header.php'); ?>
 
    <table border="0" cellpadding="0" cellspacing="0" width="100%">   
    
    
    <tr><td class="body" valign="top" align="center">
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="left" valign="top">

         <? //include ('tpl/menu-loged-in.php'); ?> 
		 
		 <? //include ('tpl/aboutus.php'); ?>  
         
         <? include ('news.php'); ?>

         
      </td>
      
      <td>
                
                 
        
        <table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr><td class="t-top">
            <div class="title2">Edit Customer</div>
            </td></tr>
            <tr><td class="t-mid">

<br /><br />

            <form id="myForm" name="myForm" method="post" action="editCustomer.php?id=3"> 
			<table class="content" align="center" width="450" border = "0"> 
			
				<tr class = "table1bg"> 
					<td width = "40%">Customer Name: </td> 
					<td><input type="text" size="30" name="Name" class="text" readonly="true" value="Andrea Hodge"></td> 
				</tr> 
				
				<tr> 
					<td>Address1: </td> 
					<td><input type="text" size="30" name="Address1" class="text" value="RTH 503, Mail Code: 1453"></td> 
				</tr> 
				
				<tr> 
					<td>Address2: </td> 
					<td><input type="text" size="30" name="Address2" class="text" value=""></td> 
				</tr> 
				
				<tr> 
					<td>City: </td> 
					<td><input type="text" size="30" name="City" class="text" value="Los Angeles"></td> 
				</tr> 
				<tr> 
					<td>State: </td> 
					<td><input type="text" size="30" name="State" class="text" value="CA"></td> 
				</tr> 
				<tr> 
					<td>Zip: </td> 
					<td><input type="text" size="30" name="Zip" class="text" value="90089"></td> 
				</tr> 
				<tr> 
					<td>Phone: </td> 
					<td><b>(</b>&nbsp;<input class="text2" type="text" maxlength = "3" size = "3" name="Phone1" onKeyup="autotab(this,document.myForm.phone2)" value='213'>&nbsp;<b>)</b>&nbsp;<input class="text2" type="text" maxlength = "3" size = "3" name="Phone2" onKeyup="autotab(this,document.myForm.phone3)"value ='740'>&nbsp;<b>-</b>&nbsp;<input class="text2" type="text" maxlength = "4" size = "4" name="Phone3" value='4225'> 
					<input type="hidden" name = "Phone" class="text"> 
					</td> 
				</tr> 
				<tr> 
					<td>Email-Id: </td> 
					<td><input type="text" class="text" size="30" name="EmailId" value=""></td> 
				</tr> 
				
				<tr> 
					<td>Fax: </td> 
					<td><input type="text"  class="text" size="30" name="Fax" value=""></td> 
				</tr> 
				
				<tr> 
					<td>Activated: </td> 
					<td><input type="text"  class="text" size="30" name="Activated" value="1"></td> 
				</tr> 
				
                <tr> 
					<td></td> 
					<td><br /><input type="submit"  value="" class="btnMC" id="update" name="update" onClick = "validate()"> </td> 
				</tr> 
			</table> 
            
            <br /><br /><br />

			</form> 


              
              
              
              
              
            </td></tr>
            
            <tr><td class="t-bot2"><a href="#">View all</a></td>
            </tr>
        </table>
        
        
       




      </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>
  
</td></tr></table>
   <? include ('tpl/footer.php'); ?>