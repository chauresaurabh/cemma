<? include_once("includes/database.php"); ?>
<?

if(!isset($_SESSION))
		session_start();


// For updating status

if(isset($_GET['change'])){

$status = $_GET['status'];
$PO = $_GET['PO'];
$invoiceno = $_GET['invoiceno'];
$Gdate = $_GET['Gdate'];
$changedStatus = $_GET['changedStatus'];
$changedPO = $_GET['changedPO'];

$Gdate_array = explode("-",$Gdate);
$Gyear  = $Gdate_array[0];
$Gmonth = $Gdate_array[1];

if($Gmonth>6) $Gyear = $Gyear+1;

/*if($changedStatus == "true"){
	writeLog($status, "Invoice MO ".substr($Gyear,2,2). '/' .$invoiceno. "- Status changed to ");
}

if($changedPO == "true"){
	writeLog($PO, "Invoice MO ".substr($Gyear,2,2). '/' .$invoiceno." - PO changed to ");
}*/


$sql3 = "UPDATE Invoice SET Status = '$status', PO = '$PO' WHERE Invoiceno = '$invoiceno' and Gdate = '$Gdate'";
mysql_query($sql3) or die ("Error3");

}


$name = $_GET['name'];
$frommonth = $_GET['frommonth'];
$tomonth = $_GET['tomonth'];
$fromyear = $_GET['fromyear'];
$toyear = $_GET['toyear'];
$fromdate = "$fromyear-$frommonth-01";
$todate = "$toyear-$tomonth-31";
$pagenum = $_GET['pagenum'];
$sorttable = $_GET['sorttable'];
$ordertable = $_GET['ordertable'];
$mid = $_SESSION['mid'];
$sort = sortquery($sorttable); // Finding out sort attribute
$order = orderquery($ordertable); //Ascending or Descending
$sql = "SELECT * FROM Invoice where Gdate between '$fromdate' and '$todate' AND Name = '$name' AND Manager_ID = ". $mid. " order by ".$sort." ".$order; 
	if($pagenum!=0){
		$result = mysql_query($sql) or die("Error in Selecting Invoice");
		$rows = mysql_num_rows($result);
		$page_rows = 10;
		$last = ceil($rows/$page_rows); 
		$max = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
		$sql = "SELECT * FROM Invoice where Gdate between '$fromdate' and '$todate' AND Name = '$name' AND Manager_ID = ". $mid. " order by ".$sort." ".$order." ".$max;
	}
$result = mysql_query($sql);
?>
    <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr>
        	<td class="t-top">
            <div class="title">Invoices for <? echo $name ?> between <? echo $frommonth ?> / <? echo $fromyear ?> and <? echo $tomonth ?> / <? echo $toyear ?></div>
            <div class="details">
			
			<?
			//Logic for Previous, First, Next, Last and View All links
			if($pagenum != 0){
				if((($pagenum-1)*$page_rows + $page_rows) < $rows)
					echo  'Showing Invoices '.(($pagenum-1)*$page_rows + 1). ' to '.(($pagenum-1)*$page_rows + $page_rows).' of '.$rows;
				else
					echo 'Showing Invoices '.(($pagenum-1)*$page_rows + 1). ' to '.$rows.' of '.$rows;
			
			}
			else{
				echo 'Showing Invoices 1 to '.mysql_num_rows($result).' of '.mysql_num_rows($result);
			}




			?>
            
            </div>
            <div class="pagin">
			
			<?
			$nav = "";
            if ($pagenum == 1) 
            {
			$nav.= 'First | Prev | ';
			


            } 
            else 
            {
                $nav.= '<a href = "javascript:showInvoices(1,'.$sorttable.",".$ordertable.')">First</a> | ';
                if($pagenum!=0){
                   $previous = $pagenum-1;
                    $nav.= '<a href = "javascript:showInvoices('.$previous.",".$sorttable.",".$ordertable.')">Prev</a> | ';
                }
            } 
            
            //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
            
            if ($pagenum == $last) {
			
			$nav.= 'Next | Last | ';
			
			
            } 
            else {
                if($pagenum!=0){
                    $next = $pagenum+1;
                    $nav.= '<a href = "javascript:showInvoices('.$next.",".$sorttable.",".$ordertable.')">Next</a> | ';
                    $nav.= '<a href = "javascript:showInvoices('.$last.",".$sorttable.",".$ordertable.')">Last</a> | ';
                }
            } 
            
            $nav.= '<a href = "javascript:showInvoices(0,'.$sorttable.",".$ordertable.')">View All</a>';
			

			echo $nav;
            



            // Changing the sort order 
            
            if($ordertable == 0)
                $ordertable = 1;
            else
                $ordertable = 0;
            ?>
			</div>
        	</td>
        </tr>
        
        
        <tr>


            <td class="t-mid">
    <table class = "content" align="center" cellpadding = "4" width="100%">
        <tr bgcolor="#f4f4f4" align="center" class="Ttitle">
            <td width = "60" onClick = "javascript:showInvoices(<?php echo $pagenum?>, 1, <?php echo $ordertable?>)" style="cursor:pointer">Invoice No</td>
            <td width = "70" onClick = "javascript:showInvoices(<?php echo $pagenum?>, 1, <?php echo $ordertable?>)" style="cursor:pointer">Generate Dt</td>
            <td onClick = "javascript:showInvoices(<?php echo $pagenum?>, 2, <?php echo $ordertable?>)" style="cursor:pointer">From Dt</td>
            <td onClick = "javascript:showInvoices(<?php echo $pagenum?>, 3, <?php echo $ordertable?>)" style="cursor:pointer">To Dt</td>
            <td onClick = "javascript:showInvoices(<?php echo $pagenum?>, 4, <?php echo $ordertable?>)" style="cursor:pointer">Total</td>
            <td onClick = "javascript:showInvoices(<?php echo $pagenum?>, 5, <?php echo $ordertable?>)" style="cursor:pointer">PO/Req</td>
            <td onClick = "javascript:showInvoices(<?php echo $pagenum?>, 6, <?php echo $ordertable?>)" style="cursor:pointer">Status</td>
            <td>Remove</td>
        </tr>
        <?
if(mysql_num_rows($result)== 0){
	?>
	<tr class="Trow">
		<td colspan = "9"><div align="center">No Invoices Found</div></td>
	</tr>
	<?
}

while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
$Gdate_array = explode("-",$row['Gdate']);
$Gyear  = $Gdate_array[0];
$Gmonth = $Gdate_array[1];

if($Gmonth>6) $Gyear = $Gyear+1;
?>
        <tr align="center" class = "Trow">
        <?php
		$date_array = explode("-",$row['Gdate']);
		$var_year = $date_array[0];
		$var_month = $date_array[1];
		$var_day = $date_array[2];	
		$var_year = substr($var_year,2,4);
		?>
            <td><a href ="view_invoice2.php?invoiceno=<? echo $row['Invoiceno'] ?>&Gdate=<? echo $row['Gdate'] ?>&name=<? echo $name ?>&pagenum=1"  target="_blank"><? echo 'MO '.substr($Gyear,2,2).'/'.$row['Invoiceno']; ?></a></td>
            <td><? echo "$var_month/$var_day/$var_year"; ?>
            <td><?php 
		$date_array = explode("-",$row['Fromdate']);
		$var_year = $date_array[0];
		$var_month = $date_array[1];
		$var_day = $date_array[2];	
		$var_year = substr($var_year,2,4);
		
		echo "$var_month/$var_day/$var_year"; ?></td>
            <td><?php
		$date_array = explode("-",$row['Todate']);
		$var_year = $date_array[0];
		$var_month = $date_array[1];
		$var_day = $date_array[2];
		$var_year = substr($var_year,2,4);
		
		echo "$var_month/$var_day/$var_year" ;
		
		?>
            </td>
            <td><? echo $row['Total'] ?></td>
            <?php if($row['PO']!= "") { ?>
            <td><a href = 'editInvoice.php?id=<?php echo $row['Number'] ?>'><?php echo $row['PO'] ?></a></td>
            <?php } else { ?>
            <td><a href = 'editInvoice.php?id=<?php echo $row['Number'] ?>'>PO/Req</a></td>
            <?php } ?>
            <td><a href = 'editInvoice.php?id=<?php echo $row['Number'] ?>'><?php echo $row['Status'] ?></a></td>
            <td><a href = 'javascript:removeInvoice("<? echo $row['Number'] ?>")'><img src = "images/trash_icon.gif" border = "0" alt = "Remove"></a></td>
        </tr>
        <?
	}

	mysql_close($connection);
	?>
    </table>
	</td>
 </tr>




		<tr>
            <td class="t-bot2"></td>
        </tr>
    </table>

<?php 

function sortquery($sorttable){

	switch($sorttable){
	


		case 1:
			return "GDate";
		break;
	
		case 2:
			return "Fromdate";
		break;
		
		case 3: 
			return "Todate";
		break;

		case 4: 
			return "Total";
		break;

		case 5: 
			return "PO/Req";
		break;

		case 6: 
			return "Status";
		break;
		
	} 
}

function orderquery($ordertable){
	if($ordertable == 0)
		return "";
	else
		return "Desc";
}

function writeLog($value,$string){

	/*$xdoc = new DomDocument;
	$xdoc->Load('activities/JohnCurulli123.xml');
	$activities_temp = $xdoc->getElementsByTagName('Activities');
	$activities = $activities_temp->item(0);
	$activityElement = $xdoc->createElement('Activity');
	$titleElement = $xdoc->createElement('Title');
	$dateElement = $xdoc->createElement('Date');
	$titleTxt = $xdoc->createTextNode("$string$value");
	$dateTxt = $xdoc->createTextNode(date('F d, H:i'));
	
	$dateElement->appendChild($dateTxt);
	$titleElement->appendChild($titleTxt);
	
	$activityElement->appendChild($titleElement);
	$activityElement->appendChild($dateElement);
	
	$x_temp = $xdoc->getElementsByTagName('Activity'); 
	$x =  $x_temp->item(0);
	$activities -> insertBefore($activityElement, $x);
	
	$test = $xdoc->save('activities/JohnCurulli123.xml');*/
}

?>
