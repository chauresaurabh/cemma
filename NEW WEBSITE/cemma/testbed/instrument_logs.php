<?
	include_once('constants.php');

	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include_once(DOCUMENT_ROOT."DAO/instrumentLogDAO.php");
	if($class == 4){
		header('Location: login.php');
	}

 	$id =  $_GET['id'];
	if(!isset($_POST['fromDateIns'])){
		header('Location: statistics.php?id=$id');
	}
	
	include (DOCUMENT_ROOT.'tpl/header.php');
	include_once(DOCUMENT_ROOT."includes/action.php");

	$fromDate = isset($_REQUEST["fromDateIns"]) ? $_REQUEST["fromDateIns"] : "";
	$dateArray = explode('/',$fromDate);
	$fromday = 	$dateArray[2];
	$fromMonth = $dateArray[1];
	$fromYear = $dateArray[0];
	
	$toDate = isset($_REQUEST["toDateIns"]) ? $_REQUEST["toDateIns"] : "";
	$dateArray = explode('/',$toDate);
	$today = $dateArray[2];
	$toMonth = $dateArray[1];
	$toYear = $dateArray[0];

	$machineName = $_POST['Instrument'];
	
	$fromDate = "$fromYear:$fromMonth:$fromday";
	$toDate = "$toYear:$toMonth:$today";
	$pagenum = $_GET['resultpage'];
	
 	$orderby = $_POST['orderby'];
	//echo "received " . $orderby;
 ?><head>

<style>
	@media print {
		body * { visibility: hidden; }
		
		P.breakhere * {page-break-before: always}
		table {width:500; height:43px; vertical-align:top;   }
		td
		{
			border: 1px solid black;
			width: 250;
		}
		.page-break * { display:block; page-break-before:always; }
	}
	</style>
</head>

<table border="0" cellpadding="0" cellspacing="0" width="100%">   
	
	<tr><td class="body" valign="top" align="center">
    <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<table border="0" cellpadding="0" cellspacing="0" align="left"><tr>
       <td>
                
        <h2 class = "Our"> Instrument Logs</h2>
        
        <form action = "instrument_logs.php" method = "post" name="myForm">
        <input type = "hidden" name="orderby" id = "orderby" value = "">
        	<?
			foreach ($_POST as $field=>$value) {
				if($field != "Instrument")
					echo "<input type=\"hidden\" name=\"" . $field . "\" value=\"" . $value . "\" />";
			}
			foreach($machineName as $idx=>$val) {
				  $name=htmlentities('Instrument['.$idx.']');
				  $val=htmlentities($val);
				  echo '<input type="hidden" name="'.$name.'" value="'.$val.'">';
			 }
			?>
            <table width="500" border="0" cellpadding="5" cellspacing="5"> 
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
            
            <table width="900" border="0" cellpadding="5" cellspacing="5">
                <tr><td class="t-top-800" >
                
                <?
                $count1=0;
                //Getting Record Details
                
                $rs = new InstrumentLogDAO();
				 
                $rs->searchLogs($pagenum, 50, $fromDate, $toDate, $machineName ,  $_POST['orderby']   );
                $currentRowNum = $rs->getStartRecord()*1; 
                
                ?> 
                <div class="title">Record Details</div>
                <div class="details"><?=$rs->getRecordsBar()?>&nbsp;&nbsp;</div>
                <div  class="pagin"> <?=$rs->getPageNav()?>
                 
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                      <? if($_SESSION['ClassLevel']==1 || $_SESSION['ClassLevel']==2) {?>
                    			<a href="exportInstrLogs.php?exportType=recordsReport"
  height = "14" width = "40" style="cursor:pointer"/>ExportRecords</a>
  					<? }  ?>
                    
                </td></tr>
                <tr><td style="border-collapse:collapse; border-color:#ccd5cc; border-style:solid; border-width:1pt" >
                <div class="printcontent2" id="div2">
                <table align="center" cellpadding="0" cellspacing="0" class="Tcontent" width = "100%"  >
                	<col width="30px"/>
                    <col width="100px"/>
                    <col width="150px"/>
                    <col width="300px"/>
                    <col width="80px"/>
                    <col width="60px"/>
                    
                    <tbody>
                       <tr bgcolor="#F4F4F4" align="center" class="Ttitle">
                        <td style="cursor:pointer">Entry</td>
                        <td onclick="orderByAction(1)" style="cursor:pointer">User</td>
                        <td  >Instrument</td>
                        <td onclick="orderByAction(2)" style="cursor:pointer">Remark</td>
                        <td onclick="orderByAction(3)" style="cursor:pointer">Date</td>
                        <td >Time</td>
                      </tr>
						<?php
                            // If there are no records
                        if($rs->getTotalRecords() == 0){
                        ?>
                        
                        <tr align="center">
                            <td colspan = "6">No Records Found</td>
                        </tr>
                        
                        <?php
                        } else {
                            $count1=$rs->getStartRecord();
                            $loopcount=0;
                            session_start();
							$export = array();
							
                            while ($row = $rs->fetchArray()){
								
								$export[$loopcount] = $row;
                                $loopcount++;
                                if (($count1 % 30)==0) {
                                ?>     
                                    <P CLASS="breakhere">
                                <?
                                }
                                ?>
                                <tr class = "Trow" align = "center" style="font-size:12px;color:#000"	 id="entryrow<?=$count1?>">
                                    <div  id="entry<?=$count1?>">
                                        <td id="entre<?=$count1?>"><? echo "$count1"; ?></td>
                                        <td id="entre3<?=$count1?>"><? echo $row['username']; ?></td>
                                        <td id="entre4<?=$count1?>"><? echo $row['instrument']; ?></td>
                                        <td id="entre5<?=$count1?>" style="overflow: hidden; word-break:break-all;"><? echo $row['remarks']; ?></td>
                                        	 
                                        <td id="entre6<?=$count1?>"><? echo $row['date'];  ?></td>
                                        <td id="entre6<?=$count1?>"><? echo $row['time']; ?></td>
                                    </div>
                                </tr>
                                <?
								$currentRowNum++;
								$count1++;
                            }
							
							$_SESSION["testSbcReport"] = $export;
							
                        }?>
					</tbody>
				</table>
			</div>
            </td>
            </tr>
            <tr>
                <td style="background: #CCC;
    font-family: Lucida Grande,Lucida Sans Unicode,Verdana;
    font-size: 12px;
    height: 49px;
    padding: 15px 25px 0 0;
    text-align: right;
    vertical-align: top;
    width: 800px;">
					<a href = "statistics.php">Return to Query&nbsp&nbsp</a>
				</td>
            </tr>
		</table>
	</form>
		</td></tr></table>
      <div class="clr"></div>
		</td></tr></table>

		</td></tr></table>
  
		</td></tr></table>
   <? include ('tpl/footer.php'); ?>
   
   <script type="text/javascript">
 
		function orderByAction(id){
			 
				switch(id){
					case 1:
						document.forms['myForm'].orderby.value='username';
						break;
					case 2:
						document.forms['myForm'].orderby.value='remarks';					
						break;						
					case 3:
						document.forms['myForm'].orderby.value='date';					
						break;
 				}
 				alert(document.forms['myForm'].orderby.value);
 				document.forms['myForm'].submit();
 			
		}
   	
   </script>