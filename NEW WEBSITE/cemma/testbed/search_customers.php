<?
	include_once('constants.php');

	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include_once(DOCUMENT_ROOT."DAO/customerDAO.php");
	if($class == 4){
		header('Location: login.php');
	}

	include (DOCUMENT_ROOT.'tpl/header.php');
	include_once(DOCUMENT_ROOT."includes/action.php");

	$dept = $_POST['cust_department'];
	$pagenum = $_GET['resultpage'];
	$school = $_POST["school"];
	$custType = $_POST['custType'];
?><head>

<script type = "text/javascript">
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
function removeItemFromExport(recordNum){
	var req = checkajax();
	if(document.getElementById("remove_"+recordNum).checked == true){
			
		   req.onreadystatechange=function() {
			
				if(req.readyState!=4)
					document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

				if(req.readyState==4 && req.status==200) {
					removeitemfromreport(req.responseText);
				}
		   }

			req.open("GET","removeRecordFromCustExport.php?recordNum="+recordNum+"&remove=1" ,true);
			req.send(null);	
	} else {
		   req.onreadystatechange=function() {
			
			if(req.readyState!=4)
				document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

			if(req.readyState==4 && req.status==200) {
				removeitemfromreport(req.responseText);
			}
		}

		req.open("GET","removeRecordFromCustExport.php?recordNum="+recordNum+"&remove=0" ,true);
		req.send(null);	
	}
}

function removeitemfromreport(id) {
	if(document.getElementById("remove_"+id.trim()).checked == true){
		document.getElementById('entre1'+id.trim()).style.color = "red";
		document.getElementById('entre2'+id.trim()).style.color = "red";
		document.getElementById('entre3'+id.trim()).style.color = "red";
		document.getElementById('entre4'+id.trim()).style.color = "red";
	} else {
		document.getElementById('entre1'+id.trim()).style.color = "#666666";
		document.getElementById('entre2'+id.trim()).style.color = "#666666";
		document.getElementById('entre3'+id.trim()).style.color = "#666666";
		document.getElementById('entre4'+id.trim()).style.color = "#666666";
	}
}
</script>

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
                
        <h2 class = "Our">Customers</h2>
        
        <form action = "search_customers.php" method = "post" name="myForm">
        	<?
				foreach($custType as $idx=>$val) {
					  $name=htmlentities('custType['.$idx.']');
					  $val=htmlentities($val);
					  echo '<input type="hidden" name="'.$name.'" value="'.$val.'">';
				 }
				foreach($school as $idx=>$val) {
					  $name=htmlentities('school['.$idx.']');
					  $val=htmlentities($val);
					  echo '<input type="hidden" name="'.$name.'" value="'.$val.'">';
				 }
				 foreach($dept as $idx=>$val) {
					  $name=htmlentities('cust_department['.$idx.']');
					  $val=htmlentities($val);
					  echo '<input type="hidden" name="'.$name.'" value="'.$val.'">';
				 }
			?>
            <? //Check if user has asked to remove a record
			$msg = '';
			if(isset($_GET['action']) && $_GET['action'] == 3){
				$rm = new CustomerDAO();
				$rm->remove($_GET['id']);
				$msg = "Customer has been removed successfully";
			}
			?>
            <input type="hidden" name = "o" id = "o" value = "<?=$_POST['o']?>">
			<input type = "hidden" name="orderby" id = "orderby" value = "<?=$_POST['orderby']?>">
            <table width="500" border="0" cellpadding="5" cellspacing="0"> 
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
            
            <table width="800" border="0" cellpadding="5" cellspacing="0">
                <tr><td class="t-top-800">
                <div class="title">Record Details</div>
                <?
				if(isset($_SESSION['cemma_schools'])) {
					$schools = $_SESSION['cemma_schools'];
				} else {
					$schools = array();
					$sql = "SELECT SchoolNo, SchoolName FROM Schools ORDER BY SchoolName";
					$result = mysql_query($sql);
					while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
						$schools[$row['SchoolNo']] = $row['SchoolName'];
					}
					$_SESSION['cemma_schools'] = $schools;
				}
                $count1=0;
                //Getting Record Details
                
                $rs = new customerDAO();
                $rs->searchCusts($pagenum, 50, $_POST['orderby'], $_POST['o'], $dept, $school, $custType);
                $currentRowNum = $rs->getStartRecord()*1; 
                
                ?> 
                <div class="details"><?=$rs->getRecordsBar()?>&nbsp;&nbsp;</div>
                <div  class="pagin"> <?=$rs->getPageNav()?>
                &nbsp;&nbsp;&nbsp;
				<a href="export.php?exportType=customersReport" height = "14" width = "40" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ExportRecords</a>
                </td></tr>
                <tr><td style="border-collapse:collapse; border-color:#ccd5cc; border-style:solid; border-width:1pt" >
                <div class="printcontent2" id="div2">
                <table align="center" cellpadding="5" cellspacing="0" style="table-layout:fixed;font-family: Lucida Grande,Lucida Sans Unicode,Verdana; font-size: 12px;" width = "100%">
                	<col width="40px"/>
                    <col width="200px"/>
                    <col width="200px"/>
                    <col width="150px"/>
                    <col width="150px"/>
                    <? if($_SESSION['ClassLevel']==1) {?>
					<col width="50px"/>
                    <col width="50px"/>
                    <? } ?>
                    <col width="50px"/>
                                        
                    <tbody>
                       <tr class="Ttitle" bgcolor="#F4F4F4" align="center">
                        <td onclick="javascript:doAction(5, 1, 'myForm')" style="cursor:pointer">Entry</td>
                        <td onclick="javascript:doAction(5, 1, 'myForm')" style="cursor:pointer">Customer</td>
                        <td onclick="javascript:doAction(5, 5, 'myForm')" style="cursor:pointer">Department</td>
                        <td onclick="javascript:doAction(5, 6, 'myForm')" style="cursor:pointer">School</td>
                        <td onclick="javascript:doAction(5, 7, 'myForm')" style="cursor:pointer">Customer Type</td>
                        <? if($_SESSION['ClassLevel']==1) {?>
                        <td class="dont1">&nbsp;Edit&nbsp;</td>
                        <td class="dont1">Delete</td>
                        <? } ?>
                        <td class="dont1">Remove</td>
                      </tr>
						<?php
						$export = array();
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
                            while ($row = $rs->fetchArray()){
                                $loopcount++;
                                if (($count1 % 30)==0) {
                                ?>     
                                    <P CLASS="breakhere">
                                <?
                                }
                                ?>
                                <tr  align = "left" style="font-size:12px"	 id="entryrow<?=$count1?>">
                                    <div  id="entry<?=$count1?>">
                                    	<? $row['School']=$schools[$row['School']];?>
                                        <td id="entre<?=$count1?>"><? echo "$count1"; ?></td>
                                        <td id="entre1<?=$row['Customer_ID']?>"><? echo $row['Name']; ?></td>
                                        <td id="entre2<?=$row['Customer_ID']?>"><? echo $row['Department']; ?></td>
                                        <td id="entre3<?=$row['Customer_ID']?>"><? echo  $row['School']?></td>
                                        <td id="entre4<?=$row['Customer_ID']?>"><? echo $row['Type']; ?></td>
                                        <? if($_SESSION['ClassLevel']==1) {?>
                                        <td class="dont1"><a href = 'editCustomer.php?id=<?=$row['Customer_ID'];?>' class="dont1"><img src = "images/edit_icon.png" class="dont1" alt = "Edit" width="13" height="13" border = "0"></a></td>
					
					<td class="dont1"><a href = 'javascript:doAction(3,"<? echo $row['Customer_ID'] ?>")' class="dont1"><img src = "images/trash_icon.gif" border = "0" alt = "Remove" class="dont1"></a></td>
										<? } ?>
					<td class="dont1"><input id="remove_<?=$row['Customer_ID']?>" type="checkbox" name="removeitem" id="removeitem" value="<?=$count1?>" onClick="removeItemFromExport('<?=$row['Customer_ID']?>');"></td>
                                    </div>
                                </tr>
                                <?
								$currentRowNum++;
								$count1++;
								$export[$row['Customer_ID']]=$row;
                            }
                        }
						$_SESSION["customersReport"] = $export;
						?>
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