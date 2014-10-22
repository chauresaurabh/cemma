<? 	
	include_once('constants.php');

	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include_once(DOCUMENT_ROOT."DAO/recordDAO.php");

	if($class != 1){
		header('Location: login.php');
	}

 	include_once(DOCUMENT_ROOT."includes/action.php");
	
	$fromMonth = $_GET['frommonth1'];
	$fromYear = $_GET['fromyear1'];
	$toMonth = $_GET['tomonth1'];
	$toYear = $_GET['toyear1'];
	$machineName = $_GET['MachineName1'];
	$customerName = $_GET['CustomerName1'];
	$operatorName = $_GET['OperatorName1'];
	$minQty= $_GET['minQty1'];
	$maxQty= $_GET['maxQty1'];
	$minTotal = $_GET['minTotal1'];
	$maxTotal = $_GET['maxTotal1'];
	$woperator= $_GET['woperator1'];
	$generated= $_GET['generated1'];
	$type = $_GET['type1'];
	$pagenum = $_GET['pageId1'];

echo "&frommonth1=$fromMonth&fromyear1=$fromYear&tomonth1=$toMonth&toyear1=$toYear&MachineName1=$machineName&CustomerName1=$customerName&OperatorName1=$operatorName&minQty1=$minQty&maxQty1=$maxQty&minTotal1=$minTotal&maxTotal1=$maxTotal&woperator1=$woperator&generated1=$generated&type1=$type";

	$fromDate = "$fromYear-$fromMonth-01";
	$toDate = "$toYear-$toMonth-31";

	$totalQty = 0;
	$totalAmount = 0;

?><head><title>Print Records</title>
	<style type="text/css">

	@media print {

		.printImg{
			display:none;

		}
		.paginationRow{
			display:none;
		}
table {width:573px; height:43px; vertical-align:top; background:url(../images/table-top-bg.gif) no-repeat top left; padding:14px 15px 12px 12px; }
td
{
border: 1px solid black;
width: 250;
}

.to_print{

display: block;

}
	}
	
	.break { page-break-before: always; }

	</style> </head>

  
<table border="0" cellpadding="0" cellspacing="0" width="100%">   
	
	<tr><td class="body" valign="top" align="center">
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="left"><tr><td class="left" valign="top">
		
         <?// include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?> 

		 
      	</td>
       <td>
                
     <div class="to_print">  
		<h2 class = "to_print"><img src = "images/h2_servises.gif" style="margin-right:10px; vertical-align:middle">Find Records</h2>
	</div>
		<form action = "searchRecords.php" method = "post" name="myForm">
		<?
		foreach ($_POST as $field=>$value) {
			if($field != 'orderby' && $field != 'o')
				echo "<input type=\"hidden\" name=\"" . $field . "\" value=\"" . $value . "\" />";
		}

		?>

		<input type="hidden" name = "o" id = "o" value = "<?=$_POST['o']?>">
		<input type = "hidden" name="orderby" id = "orderby" value = "<?=$_POST['orderby']?>">
		
		
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

		<table width="810" border="0" cellpadding="5" cellspacing="0">
            <tr><td class="t-top-800">
			
			<?
			//Getting Record Details
			
			$rs = new RecordDAO();
			$rs->searchRecords(10,$_POST['orderby'],$_POST['o'], $fromDate, $toDate, $customerName, $operatorName, $machineName, $minQty, $maxQty, $minTotal, $maxTotal, $woperator, $generated, $type);
			$currentRowNum = $rs->getStartRecord()*1; 
			
			?>     
						
            <div class="title">Record Details</div>
            <div class="details"><?=$rs->getRecordsBar()?></div>
            <div class="pagin"><?=$rs->getPageNav()?></div>
			
			</div>
            </td></tr>
            <tr><td class="t-mid-800">

	<table align="center" cellpadding="0" cellspacing="0" border="0" class="Tcontent" width = "99%">
		<tbody>
	
	<tr bgcolor="#F4F4F4" align="center" class="Ttitle">
			<td onclick="javascript:doAction(1, 1)" style="cursor:pointer">Date</td>
			<td onclick="javascript:doAction(1, 2)" style="cursor:pointer">Customer</td>
			<td onclick="javascript:doAction(1, 3)" style="cursor:pointer">Quantity</td>
			<td onclick="javascript:doAction(1, 4)" style="cursor:pointer">Instrument</td>
			<td onclick="javascript:doAction(1, 5)" style="cursor:pointer">Operator</td>
			<td width="60" onclick="javascript:doAction(1, 6)" style="cursor:pointer">With Operator?</td>
			<td onclick="javascript:doAction(1, 7)" style="cursor:pointer">Total</td>
			<td onclick="javascript:doAction(1, 8)" style="cursor:pointer">Invoice</td>
			<td>&nbsp;Edit&nbsp;</td>
			<td>Remove</td>
		</tr>
	
		<?php

		  // If there are no records
		  if($rs->getTotalRecords() == 0){
		?>

		<tr align="center">
			<td colspan = "10">No Records Found</td>
		</tr>

		<?php
		}
		else{
		//There are some records
			while ($row = $rs->fetchArray()){ ?>     
				<tr class = "Trow" align = "center" style="font-size:12px">
				<?php

				if ($row['WithOperator'] == 1)
					$withoperator = "Yes";
				else 
					$withoperator = "No";

				$date_array = explode("-",$row['Date']);
				$var_year = substr($date_array[0],2,4);
				$var_month = $date_array[1];
				$var_day = $date_array[2];

				$date_array2 = explode("-",$row['Gdate']);
				$var_year2 = substr($date_array2[0],2,4);
				$var_month2 = $date_array2[1];
				$var_day2 = $date_array2[2];
				
				if($row['Generated'] == 1){
			
					$Gdate_array = explode("-",$row['Gdate']);
					$Gyear  = $Gdate_array[0];
					$Gmonth = $Gdate_array[1];

					if($Gmonth>6) $Gyear = $Gyear+1;
					$invoiceno = $row['invoiceno'];
				}

				?>


					<td><? echo "$var_month/$var_day/$var_year"; ?></td>
					<td><? echo $row['Name']; ?></td>
					<td><? echo $row['Qty']; ?></td>
					<td><? echo $row['Machine']; ?></td>
					<td><? echo $row['Operator']; ?></td>
					<td><? echo $withoperator; ?> </td>
					<td>
					<?php 
					if ($row['DiscountFlag'] == 1)
						echo "<i>".$row['Total']."</i>";
					else
					 echo $row['Total'];

					?>
					</td>
					<?php if($row['Generated'] == 1){ ?>
					<td><a href ="view_invoice2.php?invoiceno=<? echo $row['invoiceno'] ?>&Gdate=<? echo $row['Gdate'] ?>&name=<? echo $row['Name']; ?>&pagenum=1"  target="_blank">MO <?php echo substr($Gyear,2,2). '/' .$invoiceno; ?></a></td>
					<?php 
					} else{
						echo '<td>-</td>';
					}	?>
				
					<td><a href = 'editRecord.php?id=<?=$row['Number'];?>'><img src = "images/edit_icon.png" alt = "Edit" width="13" height="13" border = "0"></a></td>
					<td><a href = 'javascript:removeRecord("<? echo $row['Number'] ?>")'><img src = "images/trash_icon.gif" border = "0" alt = "Remove"></a></td>
				</tr>
				<?
				$currentRowNum++;
				$totalQty = $totalQty + $row['Qty'];
				$totalAmount = $totalAmount + $row['Total'];
				}
				?>
				
				<tr class = "Ttitle" align = "center" style="font-size:12px">'
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td><? echo number_format($totalQty, 2, '.', ''); ?></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td><? echo number_format($totalAmount, 2, '.', ''); ?></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td> 
				  <td>&nbsp;</td> 
				</tr>
		<?php
		} ?>
		</tbody>
	</table>
  </td>
	</tr>
	<tr>
		 <td class="t-bot2-800"><a href = "statistics.php">Return to Query&nbsp&nbsp</a></td>
	
		<!-- a -->
		<td>
		 <img src = "images/printer.png" class = "printImg"
onClick="window.print();return false;" value=" Print  " height = "20" width = "20" style="cursor:pointer"/>
		</td> 
		<!-- a -->
	</tr>
	</table>
	</form>
		
        
      </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>
  
</td></tr></table>
   <?// include ('tpl/footer.php'); ?>

<script type = "text/javascript">

function removeRecord(number){

	var input_box = confirm("Removing this record may change the corresponding Invoice. Are you sure you want to continue? ");

	if(input_box == true){

		var xmlHttp = checkajax();
		   
		   xmlHttp.onreadystatechange=function() {
			
				if(xmlHttp.readyState!=4)
					document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

				if(xmlHttp.readyState==4) {
					document.myForm.submit();
				}
		   }

			xmlHttp.open("GET","removeRecord.php?number="+number+"&remove=remove" ,true);
			xmlHttp.send(null);   
	}
}

function checkajax() {
   var xmlHttp;
   try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
     } catch (e) {
        // Internet Explorer
        try {
          xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
       } catch (e) {
          try {
               xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
               alert("Your browser does not support AJAX!");
               return false;
            }
       }
     }
   
   return xmlHttp;
  }

</script>