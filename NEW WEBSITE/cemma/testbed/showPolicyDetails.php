<?
//need to check this again .. because the form is resubmitted on clicking Update .. 
// so maybe add a new parameter say submit update = true
session_start();

include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

		$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
		$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");
		
$policy_header_id = $_GET['policy_header_id'];
		
$sql = "select * from POLICY_DETAIL where policy_header_id = $policy_header_id ";
//echo $sql;
 $result = mysql_query($sql);
   if(mysql_num_rows($result)) {
 $records=0;
 echo " [ ";
while($row = mysql_fetch_array($result))
   {
	 	echo " {
				 'policy_detail_id':'".$row['policy_detail_id']."',
				 'policy_detail_value': '".$row['policy_detail_value']."'
			  } , ";
      }
  }else{
	 echo 'No records exist for the selected header.';
	}
  echo " ] ";

mysql_close();
session_write_close();
?> 
 