 


<? 	
	include_once('constants.php');

	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include_once(DOCUMENT_ROOT."DAO/recordDAO.php");
	if($class != 1){
		header('Location: login.php');
	}

	if(!isset($_POST['frommonth'])){
		header('Location: statistics.php?view=1');
	}

	include (DOCUMENT_ROOT.'tpl/header.php');
	include_once(DOCUMENT_ROOT."includes/action.php");
	
	$fromMonth = $_POST['frommonth'];
	$fromYear = $_POST['fromyear'];
	$toMonth = $_POST['tomonth'];
	$toYear = $_POST['toyear'];
	$machineName = $_POST['MachineName'];
	$customerName = $_POST['CustomerName'];
	$operatorName = $_POST['OperatorName'];
	$minQty= $_POST['minQty'];
	$maxQty= $_POST['maxQty'];
	$minTotal = $_POST['minTotal'];
	$maxTotal = $_POST['maxTotal'];
	$woperator= $_POST['woperator'];
	$generated= $_POST['generated'];
	$type = $_POST['type'];
	#$pagenum = $_GET['pageId'];
	$pagenum = $_GET['resultpage'];

	$fromDate = "$fromYear-$fromMonth-01";
	$toDate = "$toYear-$toMonth-31";

	$totalQty = 0;
	$totalAmount = 0;

	?>



<head>
<!-- .printcontent1 { position: absolute; top: 10px; left: 10px; } 
position:absolute;
left:10px;
top:15px;

.printcontent2 * { visibility: visible; }
.printcontent2 { position: absolute; top: 150px; left: 10px; }  

		.dont2 {
visibility: hidden;
}
.dont3{
display:none;
}
.dont4* {
display:none;
}

--><!-- <link rel="stylesheet" href="/css/print1.css" type="text/css" media="print"/> -->
	<style>



	@media print {
		body * { visibility: hidden; }
		.printcontent1 * { visibility: visible; }
		.printcontent1 { position: absolute; top: 40px; left: 225px; } 
		.printcontent2 * { visibility: visible; }
		.printcontent2 {
			position:absolute;
			left:225px;
			top:250px;
	}  
	.dont1 {
		 visibility: hidden;
		 display: none;
	}

	.TrowHidden td {padding:3px 0;font-family:Lucida Grande,Lucida Sans Unicode, Verdana; visibility: hidden; display: none; }
	.TrowHidden td em {font-size:12px; visibility: hidden;  display: none; }
	.TrowHidden td a {font-size:12px; visibility: hidden; display: none;  }
	.TrowHidden td a:hover {font-size:12px; visibility: hidden; display: none;  }

	P.breakhere * {page-break-before: always}
	table {width:500; height:43px; vertical-align:top; background:url(../images/table-top-bg.gif) no-repeat top left;  }
	td
	{
		border: 1px solid black;
		width: 250;
	}
	.page-break * { display:block; page-break-before:always; }
}

	</style>


</head>



<div class="printcontent1">
<div class="hide">	
<?
	echo "<center>Records</center>";
?>

<?
	echo "From: $fromMonth/$fromYear To: $toMonth/$toYear";

	?>

<?
	if($machineName==-1)
		{echo "Machine Name = All Instruments , ";
		}
	else
		{echo "Machine Name  =$machineName , ";
		}
	?>
	<?

	if($customerName==-1)
		{echo "Customer Name = All Customers , ";
		}
	else
		{echo "Customer Name =$customerName , ";
		}
?>

<?

	if($operatorName==-1)
		{echo "Operator Name = Any , ";
		}	else
		{echo "Operator Name =$operatorName , ";
		}

?>

<?

	if($minQty=='')
	{
		echo "Min Qty = NULL , ";
	}
	else
	{
		echo "Min Qty =$minQty , ";
	}


	if($maxQty=='')
		{echo "Max Qty = NULL , ";
		}
	else
		{echo "Max Qty =$maxQty , ";
		}


	if($maxTotal=='')
		{echo "Max Total = NULL , ";
		}
	else
		{echo "Max Total =$maxTotal , ";
		}
	?>

<?

	if($woperator==-1)
		{echo "Woperator = Any , ";
		}
	else
		{echo "Woperator =$woperator , ";
		}

	if($generated==-1)
		{echo "Generated = Any , ";
		}
	else
		{echo "Generated =$generated , ";
		}

	if($type==-1)
		{echo "Type= Any";
		}
	else
		{echo "Type=$type";
		} 


?>
</div>
</div>

  <table border="0" cellpadding="0" cellspacing="0" width="100%">   
	
	<tr><td class="body" valign="top" align="center">
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="left"><tr><td class="left" valign="top">
		
     <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?> 
		

      	</td>
       <td>
                
        <h2 class = "Our"><img src = "images/h2_servises.gif" style="margin-right:10px; vertical-align:middle">Find Records</h2>


<form action = "searchRecords.php" method = "post" name="myForm">
		<?
		foreach ($_POST as $field=>$value) {
			if($field != 'orderby' && $field != 'o')
			{	echo "<input type=\"hidden\" name=\"" . $field . "\" value=\"" . $value . "\" />";
			}
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
			$count1=0;
			//Getting Record Details
			
			$rs = new RecordDAO();
			$rs->searchRecords($pagenum, 50,$_POST['orderby'],$_POST['o'], $fromDate, $toDate, $customerName, $operatorName, $machineName, $minQty, $maxQty, $minTotal, $maxTotal, $woperator, $generated, $type);
			$currentRowNum = $rs->getStartRecord()*1; 
			
			?>     
						
            <div class="title">Record Details</div>
            <div class="details"><?=$rs->getRecordsBar()?>&nbsp;&nbsp;</div>
            <div  class="pagin"> <?=$rs->getPageNav()?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Print All &nbsp;<img src = "images/printer.png" class = "printImg4"
onClick="printpage();" value=" Print  " height = "14" width = "20" style="cursor:pointer"/>&nbsp;&nbsp;Print Total&nbsp;
				<img src = "images/printer.png" class = "printImg4"
onClick="printtotal();" value=" Print2 " height = "14" width = "20" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;
								<a href="javascript:showRecords();"
  height = "14" width = "40" style="cursor:pointer"/>Export</a>
  <onClick="ExportFile();" value=" Print  " height = "14" width = "20" style="cursor:pointer"/>&nbsp;&nbsp;Export Total&nbsp;
</div>
			
			</div>
            </td></tr>
            <tr><td class="t-mid-800">
  <div class="printcontent2" id="div2">
	<table align="center" cellpadding="0" cellspacing="0" border="0" class="Tcontent" width = "100%">
		<tbody>
		 
		  <tr bgcolor="#F4F4F4" align="center" class="Ttitle">
	 
	
			
			<td onclick="javascript:doAction(1, 1)" style="cursor:pointer">Entry</td>
			<td onclick="javascript:doAction(1, 1)" style="cursor:pointer">Date</td>
			<td onclick="javascript:doAction(1, 2)" style="cursor:pointer">Customer</td>
			<td onclick="javascript:doAction(1, 3)" style="cursor:pointer">Quantity</td>
			<td onclick="javascript:doAction(1, 4)" style="cursor:pointer">Instrument</td>
			<td onclick="javascript:doAction(1, 5)" style="cursor:pointer">Operator</td>
			<td width="60" onclick="javascript:doAction(1, 6)" style="cursor:pointer">With Operator?</td>
		    <td onclick="javascript:doAction(1, 7)" style="cursor:pointer">Total</td>


	
	
			<td class="dont1" onclick="javascript:doAction(1, 8)" style="cursor:pointer">Invoice</td>
	
			<td class="dont1">&nbsp;Edit&nbsp;</td>
			<!-- <td class="dont1">Delete</td> -->
			<td class="dont1">Remove</td>
			
	
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

		$count1=$rs->getStartRecord();
		$loopcount=0;
		
			while ($row = $rs->fetchArray()){ 
				$quant[$count1]=$row['Qty'];
				$cost[$count1]=$row['Total']; 
				$loopcount++;
				
				if (($count1 % 30)==0)
				{
				?>     
				<!--<div class="page-break"></div>-->
				<P CLASS="breakhere">
				<?
				}
				?>
				
				<tr class = "Trow" align = "center" style="font-size:12px"	 id="entryrow<?=$count1?>">
				<div  id="entry<?=$count1?>">

				<?
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
					


					<td id="entre<?=$count1?>"><? echo "$count1"; ?></td>
					<td id="entre2<?=$count1?>">&nbsp;<? echo "$var_month/$var_day/$var_year"; ?></td>
					<td id="entre3<?=$count1?>"><? echo $row['Name']; ?></td>
					<td id="entre4<?=$count1?>"><? echo $row['Qty']; ?></td>
					<td id="entre5<?=$count1?>"><? echo $row['Machine']; ?></td>
					<td id="entre6<?=$count1?>"><? echo $row['Operator']; ?></td>
					<td id="entre7<?=$count1?>"><? echo $withoperator; ?> </td>


					<td id="entre8<?=$count1?>">
					<?php 
					if ($row['DiscountFlag'] == 1)
				{	echo "<i>".$row['Total']."</i>";
					
				}
					else
				{ echo $row['Total'];
			
				}
					?>
					</td>
					<?php if($row['Generated'] == 1){ ?>
				<td class="dont1"><a href ="view_invoice2.php?invoiceno=<? echo $row['invoiceno'] ?>&Gdate=<? echo $row['Gdate'] ?>&name=<? echo $row['Name']; ?>&pagenum=1"  target="_blank" class="dont1">MO <?php echo substr($Gyear,2,2). '/' .$invoiceno; ?></a></td>
					<?php 
					} else{
						echo '<td class="dont1">-</td>';
					}	?>
				
					<td class="dont1"><a href = 'editRecord.php?id=<?=$row['Number'];?>' class="dont1"><img src = "images/edit_icon.png" class="dont1" alt = "Edit" width="13" height="13" border = "0"></a></td>
					
					<!--<td class="dont1"><a href = 'javascript:removeRecord("<? echo $row['Number'] ?>")' class="dont1"><img src = "images/trash_icon.gif" border = "0" alt = "Remove" class="dont1"></a></td>
					-->
					<td class="dont1"><input type="checkbox" name="removeitem" id="removeitem" value="<?=$count1?>" onClick="removeitemfromreport()"></td>
</div>
				</tr>
				
				<?
				$currentRowNum++;
				$totalQty = $totalQty + $row['Qty'];
				$totalAmount = $totalAmount + $row['Total'];
				$count1++;
				}
				?>
					
					
				<tr class = "Ttitle" align = "center" style="font-size:12px">'
				  <td id="bottomentry"><? echo $loopcount; ?></td> 
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td id="bottomqty"><? echo number_format($totalQty, 2, '.', ''); ?></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td id="bottomtotal"><? echo number_format($totalAmount, 2, '.', ''); ?></td>
				  <td class="dont1">&nbsp;</td>
				  <td class="dont1">&nbsp;</td> 
				  <td class="dont1">&nbsp;</td> 
				  <td class="dont1">&nbsp;</td> 
				</tr>
		<?php

		} ?>
		</tbody>
	</table>
	</div>
  </td>
	</tr>
	<tr>
		<td class="t-bot2-800">
			<?
				$string = "&frommonth=".$fromMonth;
				$string .= "&fromyear=".$fromYear;
				$string .= "&tomonth=".$toMonth;
				$string .= "&toyear=".$toYear;
				$string .= "&MachineName=".$machineName;
				$string .= "&CustomerName=".$customerName;
				$string .= "&OperatorName=".$operatorName;
				$string .= "&minQty=".$minQty;
				$string .= "&maxQty=".$maxQty;
				$string .= "&minTotal=".$minTotal;
				$string .= "&maxTotal=".$maxTotal;
				$string .= "&woperator=".$woperator;
				$string .= "&generated=".$generated;
				$string .= "&type=".$type;
			?>
			<a href = "statistics.php?open=record<?=$string?>">Return to Query&nbsp&nbsp</a>
		</td>
	
		<!-- 
		<td>
	11/8/2010

<img src = "images/printer.png" class = "printImg"
 onclick="window.open('PrintRecords.php', 
  'windowname2', 
  'width=1000, \
   height=700, \
   directories=no, \
   location=no, \
   menubar=no, \
   resizable=no, \
   scrollbars=1, \
   status=no, \
   toolbar=no'); 
  return false;" value=" Print  " height = "20" width = "20" style="cursor:pointer"/>
-->
<?
// pass variables for printing in Export.php
/*
echo "<input type=\"hidden\" name=\"frommonth1\" value=\"" . $fromMonth . "\" />";
echo "<input type=\"hidden\" name=\"fromyear1\" value=\"" . $fromYear . "\" />";
echo "<input type=\"hidden\" name=\"tomonth1\" value=\"" . $toMonth . "\" />";
echo "<input type=\"hidden\" name=\"toyear1\" value=\"" . $toYear . "\" />";
echo "<input type=\"hidden\" name=\"MachineName1\" value=\"" . $machineName . "\" />";
echo "<input type=\"hidden\" name=\"CustomerName1\" value=\"" . $customerName . "\" />";
echo "<input type=\"hidden\" name=\"OperatorName1\" value=\"" . $operatorName . "\" />";
echo "<input type=\"hidden\" name=\"minQty1\" value=\"" . $minQty . "\" />";
echo "<input type=\"hidden\" name=\"maxQty1\" value=\"" . $maxQty . "\" />";
echo "<input type=\"hidden\" name=\"minTotal1\" value=\"" . $minTotal . "\" />";
echo "<input type=\"hidden\" name=\"maxTotal1\" value=\"" . $maxTotal . "\" />";
echo "<input type=\"hidden\" name=\"woperator1\" value=\"" . $woperator . "\" />";
echo "<input type=\"hidden\" name=\"generated1\" value=\"" . $generated . "\" />";
echo "<input type=\"hidden\" name=\"type1\" value=\"" . $type . "\" />";
//echo "<input type=\"hidden\" name=\"pageId1\" value=\"" . $pagenum . "\" />";
*/


 echo "<a href='export.php?pageId1=1&frommonth1=$fromMonth&fromyear1=$fromYear&tomonth1=$toMonth&toyear1=$toYear&MachineName1=$machineName&CustomerName1=$customerName&OperatorName1=$operatorName&minQty1=$minQty&maxQty1=$maxQty&minTotal1=$minTotal&maxTotal1=$maxTotal&woperator1=$woperator&generated1=$generated&type1=$type'>..</a>";
  ?>
		
	<!--	 a -->
	</tr>
	</table>
	</form>
		
        
      </td></tr></table>
      <div class="clr"></div>
</td></tr></table>

  </td></tr></table>
  
</td></tr></table>
   <? include ('tpl/footer.php'); ?>

<script type = "text/javascript">

function removeitemfromreport()
{

var originalcount="<?=($count1-1)?>";

<?$countofentries=$count1-1 ?>
	//alert(originalcount);



	var temp;
	//var temp2;
	//var temp3;
	var costt = new Array(100);
	var quantt = new Array(100);
	var i=1;
			<? for ( $j=1;$j<=$countofentries;$j++)
		{
?>
		
			costt[i]="<?=$cost[$j]?>";
			quantt[i]="<?=$quant[$j]?>";
		//	alert("|"+quantt[i]+"|"+costt[i]+"|"+i);
			
			
			i++;
<?
		}
		?>
			

			var originalentries="<?=($count1-1)?>";
			var originalqty="<?=$totalQty?>";
			var originaltotal="<?=$totalAmount?>";
			
			var  count=0;
			var temp8=0;

			var tempcost=0;
			var tempqty=0;

			 count=0;
		
	for(i=0;i<=(originalcount-1);i++)
	{
		//temp='removeitem'+i;

		

	
	//alert("i"+temp9);
	//	alert(i);

		if(document.myForm.removeitem[i].checked == true)
		{
			//alert("in");
			temp=document.myForm.removeitem[i].value;
			
			document.getElementById('entre'+(i+1)).style.color = "red";
			
			document.getElementById('entre2'+(i+1)).style.color = "red";
			document.getElementById('entre3'+(i+1)).style.color = "red";
			document.getElementById('entre4'+(i+1)).style.color = "red";
			document.getElementById('entre5'+(i+1)).style.color = "red";
			document.getElementById('entre6'+(i+1)).style.color = "red";
			document.getElementById('entre7'+(i+1)).style.color = "red";
			document.getElementById('entre8'+(i+1)).style.color = "red";

			
			//alert("checked"+temp+"i"+i);
			count++;
			tempqty=parseFloat(quantt[i+1])+parseFloat(tempqty);
			tempcost=parseFloat(costt[i+1])+parseFloat(tempcost);	
				
				
			//alert("values"+quantt[i+1]+"|"+costt[i+1]);
				//qty=qty-temp8;
			
	//	alert("tempqty"+tempqty+"tempcost"+tempcost);
		
		}
		else
		{
			document.getElementById('entre'+(i+1)).style.color = "#666666";
			document.getElementById('entre2'+(i+1)).style.color = "#666666";
			document.getElementById('entre3'+(i+1)).style.color = "#666666";
			document.getElementById('entre4'+(i+1)).style.color = "#666666";
			document.getElementById('entre5'+(i+1)).style.color = "#666666";
			document.getElementById('entre6'+(i+1)).style.color = "#666666";
			document.getElementById('entre7'+(i+1)).style.color = "#666666";
			document.getElementById('entre8'+(i+1)).style.color = "#666666";
		}
	}
var newentrytotal=originalentries-count;
var newqty=originalqty-tempqty;
var newcost=originaltotal-tempcost;
//alert("newentrytotal"+newentrytotal+"newqty"+newqty+"newcost"+newcost);

	document.getElementById("bottomentry").innerHTML =newentrytotal;
	document.getElementById('bottomqty').innerHTML=newqty.toFixed(2);
	document.getElementById('bottomtotal').innerHTML=newcost.toFixed(2);;
		
//alert("end");

		
}
function ExportFile()
{ /**/
	//alert("hi");

var csv_output= "<?=fopen('file.csv', 'a');?>";

var originalcount="<?=($count1-1)?>";
var temp;
	for(i=1;i<=originalcount;i++)
	{
document.getElementById("entryrow"+i).className ="Trow"; // "printcontent2";
//document.getElementById("entryrow"+i).style.display = "block";
document.getElementById("entryrow"+i).style.visibility="visible";
	}
//document.getElementById("diventries").className = "dont1";
//document.getElementById("div2").style.display = "block";
//document.getElementById("div2").style.visibility="visible";

	for(i=0;i<=(originalcount-1);i++)
	{

		//alert(i);

		if(document.myForm.removeitem[i].checked == true)
		{
			
			temp=document.myForm.removeitem[i].value;
			alert("in"+temp);
			//document.getElementById('entre'+(i+1)).style.color = "red";
			document.getElementById("entryrow"+(i+1)).className ="dont1"; // "printcontent2";
			//document.getElementById("entryrow"+i).style.display = "block";
			//document.getElementById("entryrow"+(i+1)).style.visibility="visible";

		}
	}
$list = array
(
,
"Glenn,Quagmire,Oslo,Norway",
);

$file = fopen("contacts.csv","w");

foreach ($list as $line)
  {
  fputcsv($file,split(',',$line));
  }

fclose($file); ?>			
	//alert('hi');
fputcsv(file,fields,seperator,enclosure)


}
function printpage()
{
	//alert("hi");
var originalcount="<?=($count1-1)?>";
var temp;
	for(i=1;i<=originalcount;i++)
	{
document.getElementById("entryrow"+i).className ="Trow"; // "printcontent2";
//document.getElementById("entryrow"+i).style.display = "block";
document.getElementById("entryrow"+i).style.visibility="visible";
	}
//document.getElementById("diventries").className = "dont1";
//document.getElementById("div2").style.display = "block";
//document.getElementById("div2").style.visibility="visible";

	for(i=0;i<=(originalcount-1);i++)
	{

		//alert(i);

		if(document.myForm.removeitem[i].checked == true)
		{
			
			temp=document.myForm.removeitem[i].value;
			alert("in"+temp);
			//document.getElementById('entre'+(i+1)).style.color = "red";
			document.getElementById("entryrow"+(i+1)).className ="dont1"; // "printcontent2";
			//document.getElementById("entryrow"+i).style.display = "block";
			//document.getElementById("entryrow"+(i+1)).style.visibility="visible";

		}
	}
			
	//alert('hi');
window.print();

}
function showRecords()
{
	var originalcount="<?=($count1-1)?>";
	
	for(i=1;i<=originalcount;i++)
	{
		document.getElementById("entryrow"+i).className = 'Trow';

	}

}

function printtotal()
{
var originalcount="<?=($count1-1)?>";
	
	for(i=1;i<=originalcount;i++)
	{
		document.getElementById("entryrow"+i).className = "TrowHidden";

	}

//document.getElementById("diventries").style.display = "none";
//document.getElementById("diventries").style.visibility="hidden";
	//alert('hi');
window.print();
	for(i=1;i<=10;i++)
	{
//document.getElementById("entryrow"+i).className = 'Trow';
	}
//document.getElementById("diventries").style.display = "block";
//document.getElementById("diventries").style.visibility="visible";
//setTimeout("location.reload(true);",10);

}
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
function print1()
{
var answer = confirm  ("Print","yes","no");
if (answer)
alert ("y")
else
alert ("n")


}
</script>