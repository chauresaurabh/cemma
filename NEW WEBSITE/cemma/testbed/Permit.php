<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");
if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//header('Location: login.php');
}
include (DOCUMENT_ROOT.'tpl/header.php');

include_once("includes/instrument_action.php");

	$submit =  $_GET['submit'];
	
	if($submit=='true'){		
			 include_once('constants.php');
		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
		
		
		$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
		$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");

		$title = $_POST['title'];
		$para1 = $_POST['para1'];
		$para2 = $_POST['para2'];
		$instrumentName = $_POST['instruments'];
		
		$sql = "select title from permit_forms where instrument_name = '".$instrumentName."'";
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result)>0){
			$sql = "update permit_forms set title = '$title', para1 = '$para1', para2 = '$para2' where instrument_name='$instrumentName'";
			mysql_query($sql) or die(mysql_error());
		} else {
		
			$sql = "insert into permit_forms(instrument_name, title, para1, para2) values('$instrumentName','$title', '$para1', '$para2')";
			mysql_query($sql) or die(mysql_error());
		}
		?>
		<script type="text/javascript">
			alert("Permit uploaded successfully");
		</script>
		<?
	
	}

?>

<script type="text/javascript">
function submitclicked()
{
	document.myForm.submit();
}
</script>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td class="body" valign="top" align="center">
    <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
    <table border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td class="body_resize"><table border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                
                <td>
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td class="t-top"><div class="title2">Upload Permit</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid"><br />
                        <br />
                        <form id="myForm" name="myForm" method="post" action="Permit.php?submit=true">
                          <table class="content" align="center" width="450" border = "0">
                          <tr class="Trow">
                          	<td colspan="2"><center><select id="instruments" name="instruments" style="font-weight:normal" onchange="loadPermit()"></select></center></td>
                          </tr>
							<tr class="Trow">
                              <td width = "40%">Title: </td>
                              <td><input type="text" size="100" style="width:300px" id="title" name="title" class="text"  value=""></td>
                            </tr>
							<tr class="Trow">
                              <td width = "40%">Para1:  </td>
                              <td><textarea cols="40" rows="10" name="para1" id="para1"></textarea></td>
                            </tr>
							<tr class="Trow">
                              <td width = "40%">Para2:  </td>
                              <td><textarea cols="40" rows="10" name="para2" id="para2"></textarea></td>
                            </tr>
                           </table>
                         </form>
                      </td>
                    </tr>
                    <tr>
                      <td class="t-bot2"><a href = "javascript:submitclicked()">Submit</a></td>
                    </tr>
                 </table>
               </td>
             </tr>
           </table>
         </td>
       </tr>
    </table>
<script type="text/javascript">
<? 
$dbhost="db948.perfora.net";
		$dbname="db210021972";
		$dbusername="dbo210021972";
		$dbpass="XhYpxT5v";
		
		$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connectionnn");
		$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");
/*		
$sql="select * from permit_forms";
	$result = mysql_query($sql);
	echo mysql_error();
	if($row=mysql_fetch_array($result)){ ?>
		document.getElementById('para1').innerHTML = '<? echo $row['para1'];?>';
		document.getElementById('para2').innerHTML = '<? echo $row['para2'];?>';
		document.getElementById('title').value =  '<? echo $row['title'];?>';<?
	}
	*/
	$sql = "select InstrumentName from instrument";
	$result = mysql_query($sql);
	$i=0;
	while($row=mysql_fetch_array($result)){?>
		document.getElementById("instruments").options[<? echo $i?>] = new Option("<? echo $row['InstrumentName']?>");
<?	
	$i+=1;
	}
	mysql_close();
?>
var req;
	
function loadPermit(){
	var e = document.getElementById("instruments");
	var strUser = e.options[e.selectedIndex].text;
			if (window.XMLHttpRequest) {
						try {
							req = new XMLHttpRequest();
						} catch (e) {
							req = false;
						}
					} else if (window.ActiveXObject) {
						try {
							req = new ActiveXObject("Msxml2.XMLHTTP");
						} catch (e) {
							try {
								req = new ActiveXObject("Microsoft.XMLHTTP");
							} catch (e) {
								req = false;
							}
						}
					}
					if (req) {
						req.onreadystatechange = showPermitData;
						req.open("GET", "showPermit.php?instrNum="+strUser, true);
						req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("");
					} else {
						alert("Please enable Javascript");
					}
		}
			function showPermitData(){
		if (req.readyState == 4 && req.status == 200) {
			var doc = eval("(" + req.responseText + ")");
			if(doc.notfound){
				document.getElementById('para1').innerHTML = "";
				document.getElementById('para2').innerHTML = "";
				document.getElementById('title').value =  "";
			} else {
				document.getElementById('para1').innerHTML = doc.para1;
				document.getElementById('para2').innerHTML = doc.para2;
				document.getElementById('title').value =  doc.title;
			}
		}
	}

</script>