<?
 
	
  	include_once('constants.php');

	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include_once(DOCUMENT_ROOT."DAO/instrumentLogDAO.php");
	if($class == 4){
		header('Location: login.php');
	}

 	$id =  $_GET['id'];
 
	include (DOCUMENT_ROOT.'tpl/header.php');
	include_once(DOCUMENT_ROOT."includes/action.php");
	
	$fromDate="";
	$toDate="";
	$machineName="";
	$pagenum="";
	$submittype = $_GET['submittype'];
	$orderby="";
	$ascordesc = "";
	if( $submittype!=1){
			$fromDate = isset($_REQUEST["fromDateIns"]) ? $_REQUEST["fromDateIns"] : "";
			$toDate = isset($_REQUEST["toDateIns"]) ? $_REQUEST["toDateIns"] : "";
			$machineName = $_POST['Instrument'];
			$pagenum = $_GET['resultpage'];
			$ascordesc = 0;
	}else{
			$fromDate = $_GET['fromDateIns'];
			$toDate = $_GET['toDateIns'];
			$machineName = $_GET['Instrument'];
			$pagenum = $_GET['resultpage'];
			$orderby = $_GET['orderby'];
			$ascordesc = $_GET['ascordesc'];
  	}
	 
	$dateArray = explode('/',$fromDate);
	$fromday = 	$dateArray[2];
	$fromMonth = $dateArray[1];
	$fromYear = $dateArray[0];
	
	$dateArray = explode('/',$toDate);
	$today = $dateArray[2];
	$toMonth = $dateArray[1];
	$toYear = $dateArray[0];

	
	$fromDate = "$fromYear:$fromMonth:$fromday";
	$toDate = "$toYear:$toMonth:$today";
	
	 
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
    	<table border="0" cellpadding="0" cellspacing="0" align="left" bgcolor="#FFFFFF"><tr>
       <td>
                
        <h2 class = "Our"> Instrument Logs</h2>
        
        <form action = "instrument_logs.php" method = "get" name="staffform">
         <input type="hidden" name="orderby" id="orderby" value="<?=$_GET['orderby']?>"/>
         <input type="hidden" name="fromDateIns" id="fromDateIns" value="<?=$_GET['fromDateIns']?>"/>
         <input type="hidden" name="toDateIns" id="toDateIns" value="<?=$_GET['toDateIns']?>"/>
         <input type="hidden" name="Instrument" id="Instrument" value="<?=$_GET['Instrument']?>"/>
          <input type="hidden" name="resultpage" id="resultpage" value="<?=$_GET['resultpage']?>"/>
          <input type="hidden" name="id" id="id" value="<?=$_GET['id']?>"/>
          <input type="hidden" name="ascordesc" id="ascordesc" value="<?= $ascordesc ?> "/> 
           <input type="hidden" name="submittype" id="submittype" value=""/>
             
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
            <table width="500" border="0" cellpadding="5" cellspacing="5" > 
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
				 
                $rs->searchLogs($pagenum, 50, $fromDate, $toDate, $machineName ,  $orderby , $ascordesc );
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
                        <td onclick="orderByAction(5)" style="cursor:pointer">Instrument</td>
                        <td onclick="orderByAction(2)" style="cursor:pointer">Remark</td>
                        <td onclick="orderByAction(3)" style="cursor:pointer">Date</td>
                        <td onclick="orderByAction(4)" style="cursor:pointer">Time</td>
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
                                <? if($loopcount%2 == 0) {?>
                               	 <tr class = "Trow" align = "center" style="font-size:12px;color:#000" id="entryrow<?=$count1?>">
                                  <? } else {  ?>
                             	 <tr class = "Trow" align = "center" style="font-size:12px;color:#000" bgcolor="#EFEFFF" id="entryrow<?=$count1?>">
								  <? }?>
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
					<a href = "statistics.php?id=2">Return to Query&nbsp&nbsp</a>
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
			 
			 if(id==1){
				 		document.getElementById('orderby').value = "username";
 			 }else if(id==2){
				 	 document.getElementById('orderby').value= "remarks";  
 			 }else if(id==3){
					 document.getElementById('orderby').value= "Date";    	
 			 }else if(id==4){
					 document.getElementById('orderby').value= "time";    	
 			 } else if(id==5){
					 document.getElementById('orderby').value= "instrument";    	
 			 }
			 document.getElementById('ascordesc').value = parseInt(document.getElementById('ascordesc').value) + 1;
			     	 
		  		document.getElementById('submittype').value = 1;
 				document.forms["staffform"].submit();
 		}
		
		 
   </script>