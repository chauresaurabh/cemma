<?
	include_once('constants.php');

	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	include_once(DOCUMENT_ROOT."DAO/userDAO.php");
	if($class == 4){
		header('Location: login.php');
	}

	include (DOCUMENT_ROOT.'tpl/header.php');
	include_once(DOCUMENT_ROOT."includes/action.php");

	$dept = $_POST['department'];
	$adviser = $_POST["adviser"];
	$ApprovedInstrument = $_POST['ApprovedInstrument'];
	$position = $_POST["position"];
	$pagenum = $_GET['resultpage'];
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

			req.open("GET","removeRecordFromCustExport.php?exportType=usersReport&recordNum="+recordNum+"&remove=1" ,true);
			req.send(null);	
	} else {
		   req.onreadystatechange=function() {
			
			if(req.readyState!=4)
				document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

			if(req.readyState==4 && req.status==200) {
				removeitemfromreport(req.responseText);
			}
		}

		req.open("GET","removeRecordFromCustExport.php?exportType=usersReport&recordNum="+recordNum+"&remove=0" ,true);
		req.send(null);	
	}
}

function removeitemfromreport(id) {
	if(document.getElementById("remove_"+id.trim()).checked == true){
		document.getElementById('entre1'+id.trim()).style.color = "red";
		document.getElementById('entre2'+id.trim()).style.color = "red";
		document.getElementById('entre3'+id.trim()).style.color = "red";
		document.getElementById('entre4'+id.trim()).style.color = "red";
		document.getElementById('entre5'+id.trim()).style.color = "red";
	} else {
		document.getElementById('entre1'+id.trim()).style.color = "#666666";
		document.getElementById('entre2'+id.trim()).style.color = "#666666";
		document.getElementById('entre3'+id.trim()).style.color = "#666666";
		document.getElementById('entre4'+id.trim()).style.color = "#666666";
		document.getElementById('entre5'+id.trim()).style.color = "#666666";
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
                
        <h2 class = "Our">Users</h2>
        
        <form action = "search_users.php" method = "post" name="myForm">
        	<?
				foreach($dept as $idx=>$val) {
					  $name=htmlentities('department['.$idx.']');
					  $val=htmlentities($val);
					  echo '<input type="hidden" name="'.$name.'" value="'.$val.'">';
				 }
				foreach($adviser as $idx=>$val) {
					  $name=htmlentities('adviser['.$idx.']');
					  $val=htmlentities($val);
					  echo '<input type="hidden" name="'.$name.'" value="'.$val.'">';
				 }
				 foreach($position as $idx=>$val) {
					  $name=htmlentities('position['.$idx.']');
					  $val=htmlentities($val);
					  echo '<input type="hidden" name="'.$name.'" value="'.$val.'">';
				 }
				 if(isset($_SESSION['user_positions'])) {
					$user_positions = $_SESSION['user_positions'];
				} else {
					$user_positions = array();
					$user_positions["US"] = "UnderGraduate Student";
					$user_positions["GS"] = "Graduate Student";
					$user_positions["PD"] = "Post Doctor";
					$user_positions["PI"] = "Principal Investigator";
					
					$_SESSION['cemma_schools'] = $user_positions;
				}
				
				if(isset($_SESSION['user_instruments'])) {
					$user_instruments = $_SESSION['user_instruments'];
				} else {
					$user_instruments = array();
					$sql = "SELECT InstrumentNo, InstrumentName FROM instrument order by InstrumentName";
					$result = mysql_query($sql);
					while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
						$user_instruments[$row['InstrumentNo']] = $row['InstrumentName'];
					}
					
					$_SESSION['user_instruments'] = $user_instruments;
				}
			?>
            <input type="hidden" name = "ApprovedInstrument" id = "ApprovedInstrument" value = "<?=$ApprovedInstrument?>">
			<input type="hidden" name = "o" id = "o" value = "<?=$_POST['o']?>">
			<input type = "hidden" name="orderby" id = "orderby" value = "<?=$_POST['orderby']?>">
            <table width="900" border="0" cellpadding="5" cellspacing="0"> 
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
            
            <table width="900" border="0" cellpadding="5" cellspacing="0">
                <tr><td class="t-top-800">
                		<div class="title">Record Details</div>
                <?
                $count1=0;
                //Getting Record Details
                
                $rs = new userDAO();
                $rs->searchUsers($pagenum, 50, $_POST['orderby'], $_POST['o'], $dept, $adviser, $position, $ApprovedInstrument);
                $currentRowNum = $rs->getStartRecord()*1; 
                
                ?> 
                <div class="details"><?=$rs->getRecordsBar()?>&nbsp;&nbsp;</div>
                <div  class="pagin"> <?=$rs->getPageNav()?>
                &nbsp;&nbsp;&nbsp;
                <a href="export.php?exportType=usersReport" height = "14" width = "40" style="cursor:pointer"/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ExportRecords</a>
                </td></tr>
                <tr><td style="border-collapse:collapse; border-color:#ccd5cc; border-style:solid; border-width:1pt" >
                <div class="printcontent2" id="div2">
                <table align="center" cellpadding="5" cellspacing="0" style="table-layout:fixed;font-family: Lucida Grande,Lucida Sans Unicode,Verdana; font-size: 12px;" width = "100%">
                	<col width="40px"/>
                    <col width="150px"/>
                    <col width="200px"/>
                    <col width="150px"/>
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
                        <td onclick="javascript:doAction(5, 1, 'myForm')" style="cursor:pointer">User</td>
                        <td onclick="javascript:doAction(5, 2, 'myForm')" style="cursor:pointer">Department</td>
                        <td onclick="javascript:doAction(5, 3, 'myForm')" style="cursor:pointer">Adviser</td>
                        <td onclick="javascript:doAction(5, 4, 'myForm')" style="cursor:pointer">Position</td>
                        <td>Approved Instrument</td>
                        <? if($_SESSION['ClassLevel']==1) {?>
                        <td class="dont1">&nbsp;Edit&nbsp;</td>
                        <td class="dont1">Archive</td>
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
                                <tr  align = "center" style="font-size:12px"	 id="entryrow<?=$count1?>">
                                    <div  id="entry<?=$count1?>">
                                    	<?
										$row['Instrument'] = $user_instruments[$ApprovedInstrument];
                                        $row['Position'] = $user_positions[$row['Position']];
										?>
                                        <td id="entre<?=$count1?>"><? echo "$count1"; ?></td>
                                        <td id="entre1<?=$row['UserName'];?>"><? echo $row['UserName']; ?></td>
                                        <td id="entre2<?=$row['UserName']?>"><? echo $row['Dept']; ?></td>
                                        <td id="entre3<?=$row['UserName']?>"><? echo $row['Advisor']; ?></td>
                                        <td id="entre4<?=$row['UserName']?>"><? echo $row['Position']; ?></td>
                                        <td id="entre5<?=$row['UserName']?>"><? echo $row['Instrument'];?></td>
                                        <? if($_SESSION['ClassLevel']==1) {?>
                                        <td class="dont1"><a href = 'EditCurrentUser.php?id=<?=$row['UserName'];?>' class="dont1"><img src = "images/edit_icon.png" class="dont1" alt = "Edit" width="13" height="13" border = "0"></a></td>
					
					<td class="dont1"><a href = 'MakeArchived.php?id=<?=$row['UserName'];?>' class="dont1"><img src = "images/archive8.png" width="13" height="13"  border = "0" alt = "Archive" class="dont1"></a></td>
                    					<? } ?>
					
					<td class="dont1"><input id="remove_<?=$row['UserName']?>" type="checkbox" name="removeitem" id="removeitem" value="<?=$count1?>" onClick="removeItemFromExport('<?=$row['UserName']?>');"></td>
                                    </div>
                                </tr>
                                <?
								$currentRowNum++;
								$count1++;
								$export[$row['UserName']]=$row;
                            }
                        }
						$_SESSION["usersReport"] = $export;
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
					<a href = "statistics.php?id=3">Return to Query&nbsp&nbsp</a>
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