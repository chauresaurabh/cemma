<? include_once("includes/database.php"); ?>

<?

if(!isset($_SESSION))
		session_start();
		
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
$i=0;


// For viewing Invoices
if(isset($_GET['invoice'])){
	$sort = sortquery($sorttable); // Finding out sort attribute
	$order = orderquery($ordertable); //Ascending or Descending
	$sql = "SELECT * FROM Customer_data WHERE Date between '$fromdate' and '$todate' and Name = '$name' and Generated = '0' and Manager_ID = ".$mid." order by Date";
	if($pagenum!=0){
		$result = mysql_query($sql);
		$rows = mysql_num_rows($result);
		$page_rows = 10;
		$last = ceil($rows/$page_rows); 
		$max = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
		$sql = "SELECT * FROM Customer_data WHERE Date between '$fromdate' and '$todate' and Name = '$name' and Generated = '0' and Manager_ID = ".$mid." order by Date $max";
	}
}
else
{
	// For viewing records
	
	$sort = sortquery($sorttable); // Finding out sort attribute
	$order = orderquery($ordertable); //Ascending or Descending
	$sql = "SELECT * FROM Customer_data WHERE Date between '$fromdate' and '$todate' and Name = '$name' and Manager_ID = ".$mid." order by ".$sort." ".$order; 
	
	if($pagenum!=0){ // If View all is not selected
		$result = mysql_query($sql); 
		$rows = mysql_num_rows($result);
		$page_rows = 10; // Number of records per page
		$last = ceil($rows/$page_rows); 
		$max = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows; // Limit Query
		$sql = "SELECT * FROM Customer_data WHERE Date between '$fromdate' and '$todate' and Name = '$name' and Manager_ID = ".$mid." order by ".$sort." ".$order." ".$max;

	}
}
$result = mysql_query($sql);
?>

    <table width="900" border="0" cellpadding="5" cellspacing="0">
        <tr>
        	<td class="t-toprecs">
            <div class="title">Records for <? echo $name ?> between <? echo $frommonth ?> / <? echo $fromyear ?> and <? echo $tomonth ?> / <? echo $toyear ?></div>
            <div class="details">
			
			<?
			//Logic for Previous, First, Next, Last and View All links
			if($pagenum != 0){
				if((($pagenum-1)*$page_rows + $page_rows) < $rows)
					echo  'Showing Records '.(($pagenum-1)*$page_rows + 1). ' to '.(($pagenum-1)*$page_rows + $page_rows).' of '.$rows;
				else
					echo 'Showing Records '.(($pagenum-1)*$page_rows + 1). ' to '.$rows.' of '.$rows;
			
			}
			else{
				echo 'Showing Records 1 to '.mysql_num_rows($result).' of '.mysql_num_rows($result);
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
                $nav.= '<a href = "javascript:showRecords(1,'.$sorttable.",".$ordertable.')">First</a> | ';
                if($pagenum!=0){
                   $previous = $pagenum-1;
                    $nav.= '<a href = "javascript:showRecords('.$previous.",".$sorttable.",".$ordertable.')">Prev</a> | ';
                }
            } 
            
            //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
            
            if ($pagenum == $last) {
			
			$nav.= 'Next | Last | ';
			
			
            } 
            else {
                if($pagenum!=0){
                    $next = $pagenum+1;
                    $nav.= '<a href = "javascript:showRecords('.$next.",".$sorttable.",".$ordertable.')">Next</a> | ';
                    $nav.= '<a href = "javascript:showRecords('.$last.",".$sorttable.",".$ordertable.')">Last</a> | ';
                }
            } 
            
            $nav.= '<a href = "javascript:showRecords(0,'.$sorttable.",".$ordertable.')">View All</a>';
			
		 echo $nav ." &nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  ";

            
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
        


<table class="content" align="center" width="100%">
    <tr bgcolor="#f4f4f4" align="center" class="Ttitle">
        <td onClick = "javascript:showRecords(<?php echo $pagenum?>, 1, <?php echo $ordertable?>)" style="cursor:pointer">Date</td>
        <td onClick = "javascript:showRecords(<?php echo $pagenum?>, 2, <?php echo $ordertable?>)" style="cursor:pointer">Quantity </td>
    
		<td onClick = "javascript:showRecords(<?php echo $pagenum?>, 3, <?php echo $ordertable?>)" style="cursor:pointer">Instrument</td>
        <td onClick = "javascript:showRecords(<?php echo $pagenum?>, 4, <?php echo $ordertable?>)" style="cursor:pointer">Operator</td>
        <td width="60" onClick = "javascript:showRecords(<?php echo $pagenum?>, 5, <?php echo $ordertable?> )" style="cursor:pointer">With Operator?</td>
        <td onClick = "javascript:showRecords(<?php echo $pagenum?>, 6, <?php echo $ordertable?>)" style="cursor:pointer">Total</td>
        <?php if(!isset($_GET['invoice'])){ ?>
        <td onClick = "javascript:showRecords(<?php echo $pagenum?>, 7, <?php echo $ordertable?>)" style="cursor:pointer">Invoice No</td>
        <?php } ?>
        <td>&nbsp;Edit&nbsp;</td>
        <? if(isset($_GET['invoice'])){ ?>
        <td>&nbsp;Select&nbsp;&nbsp;</td>
        <? } ?>
        <td>Remove</td>
    </tr>
<?
if(mysql_num_rows($result)== 0){
?>
    <tr class="Trow">
        <td colspan = 9><div align="center">No Records Found</div></td>
    </tr>
    <?
}
else
{
	
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
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
		
		
		echo '<tr align = "center">';
		
		
		?>
			<td><? echo "$var_month/$var_day/$var_year"; ?></td>
				<td><? echo $row['Qty']; ?></td>
				<td bgcolor="#0066FF"><? echo $row['Machine']; ?></td>
				<td><? echo $row['Operator']; ?></td>
				<td><? echo $withoperator; ?> </td>
				<td><?php 
			if ($row['DiscountFlag'] == 1)
				echo "<i>".$row['Total']."</i>";
			else
			 echo $row['Total'];
		
			?>
				</td>
				<?
			$i++;
			?>
				<?php 
			if(!isset($_GET['invoice'])){
				if($row['Generated'] == 1){
					
					$Gdate_array = explode("-",$row['Gdate']);
					$Gyear  = $Gdate_array[0];
					$Gmonth = $Gdate_array[1];
		
					if($Gmonth>6) $Gyear = $Gyear+1;
					
					$invoiceno = $row['invoiceno'];
							
			?>
				<td><a href ="view_invoice2.php?invoiceno=<? echo $row['invoiceno'] ?>&Gdate=<? echo $row['Gdate'] ?>&name=<? echo $row['Name']; ?>&pagenum=1"  target="_blank">MO <?php echo substr($Gyear,2,2). '/' .$invoiceno; ?></a></td>
				<?php 
				}
				else{
					echo '<td>-</td>';
				}		 
			}		
			?>
				<td><a href = 'editRecord.php?id=<? echo $row['Number'] ?>'><img src = "images/edit_icon.png" alt = "Edit" width="13" height="13" border = "0"></a></td>
				<?php if(isset($_GET['invoice'])){ ?>
				<td><input type="checkbox" checked="checked" id = "checkbox[<? echo $i-1 ?>]" name = "checkbox[<? echo $i-1 ?>]"></td>
				<?php } ?>
				<td><a href = 'javascript:removeRecord("<? echo $row['Number'] ?>")'><img src = "images/trash_icon.gif" border = "0" alt = "Remove"></a></td>
			</tr>
			<?
	}
}
mysql_close($connection);
?>
				</table>
			</td>
 		</tr>




		<tr>
            <td class="t-bot2"><div id = "record-bot">
			<?php if(isset($_GET['record'])) echo '<a href = "add_record.php?id='.$customerid.'">New Record</a>' ?>
			<div></td>
        </tr>
    </table>



<?php 

function sortquery($sorttable){

	switch($sorttable){
	
		case 1:
			return "Date";
		break;
	
		case 2:
			return "Qty";
		break;
		
		case 3: 
			return "Machine";
		break;
		
		case 4:
			return "Operator";
		break;
		
		case 5:
			return "WithOperator";
		break;
		
		case 6:
			return "Total";
		break;
		
		case 7:
			return "invoiceno";
		break;		
	}
} 

function orderquery($ordertable){
	if($ordertable == 0)
		return "";
	else
		return "Desc";
}
?>