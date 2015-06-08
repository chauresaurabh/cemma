<script type="text/javascript">
function printpage()
{
		 var printButton = document.getElementById("printbutton");
         printButton.style.visibility = 'hidden';
         window.print()
         printButton.style.visibility = 'visible'; 
}
</script>

<?
//need to check this again .. because the form is resubmitted on clicking Update .. 
// so maybe add a new parameter say submit update = true
session_start();
	 include_once('constants.php');
		include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
		
		$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
		$SelectedDB = mysql_select_db($dbname) or die ("Error in Old DB");
	
	$firstName="";
	$lastName="";
	$signature="";
		if($_GET['loaduser']=='false'){
			$firstName= $_GET['firstname'];
			$lastName= $_GET['lastname'];	
		}
	 	else{
			 $sql = "SELECT FirstName , LastName , signature FROM user where UserName='".$_GET['username']."'";
  			$result = mysql_query($sql) or die("query_error");
			$row = mysql_fetch_array($result);
			$firstName = $row['FirstName'];
			$lastName = $row['LastName'];
			
			$signature = $row['signature'];
			
		}
	$sql = "select DATE_FORMAT(LAST_MODIFY_DT,'%d-%b-%y') AS last_modify_dt from POLICY_LAST_MODIFY ";
    $result = mysql_query($sql) or die("query_error");
	$row = mysql_fetch_array($result);
	 
  $hdrarray = array();
  
  	$str = "";
	if($_GET['imgdefault']=='true'){
		$headerInfo = "<img src='logo.jpg' width=400, height=100>";
		$headerInfo = $headerInfo. "<span style='margin-left:10%'><img src='cemmalogo_policy.jpg'></span>";
	}
 	else {
	$headerInfo = "<img src='../docs/logo.jpg'>";
  $headerInfo = $headerInfo. "<span style='margin-left:5%'><img src='../docs/cemmalogo_policy.jpg'></span><br/><br/>";
 	}
	 
	
	$headerInfo = $headerInfo . "<br/><br/><b><center><span style='text-align:center;font-weight:700;font-size:15px;'>".
	"The following outlines the policy and procedures for all researchers <br> using the Center for Electron Microscopy & Microanalysis (CEMMA). </b> <br/></span></center> ";
		
	$headerInfo = $headerInfo . "<br/><b><center><span style='text-align:center;font-weight:700;font-size:15px;'>".
	"****Please note that these policies are subject to change****</b> <br/></span></center> ";
	
 	$headerInfo = $headerInfo . "<b><center><span style='text-align:center;font-weight:700;font-size:15px;'>".
	"Last Updated : ".$row['last_modify_dt'] ."</b> <br/></span></center> ";
 		
	$str = $str . $headerInfo;

	$str = $str . "<dl style='font-size:15px'>";
	$flag = 0;
	$dateToday = date('d-M-Y');

	
	$sql = "select hdr.policy_header_id , hdr.policy_header_type_bullet, hdr.policy_header ,  dtl.policy_detail_value
	 from  POLICY_HDR hdr, POLICY_DETAIL dtl where hdr.policy_header_id = dtl.policy_header_id order by hdr.policy_header_id";

    $result = mysql_query($sql);

 while($row = mysql_fetch_array($result))
   {
	   if(!in_array($row['policy_header_id'], $hdrarray)) {
		   	array_push($hdrarray, $row['policy_header_id'] );
			if ($flag > 0) {
				$str = $str  ." </dd> </ul> ";
			}
			if($row['policy_header_type_bullet'] == 1) {
				$str = $str  ." <dt> <b><u>". $row['policy_header'] ." : </u></b></dt>";
				$str = $str ." <dd> <ul>";
				$str = $str ." <li> ".  stripslashes( $row['policy_detail_value'] ) ." </li> ";
			} else {
				$str = $str  ." <br/> <dt> <b><u>". $row['policy_header'] ." : </u></b></dt>";
			    $str = $str ." <p> ".  stripslashes($row['policy_detail_value']) ." </p> ";
			}
 	   } else{
		      if($row['policy_header_type_bullet'] == 1) {
				 $str = $str ." <li> ".  $row['policy_detail_value'] ." </li> ";
			 }else{
				 $str = $str ." <p> ".  stripslashes( $row['policy_detail_value'] ) ." </p> ";		 
			}
 		}
		$flag = 1;
	 	
   	}
	$str = $str ."</dl> ";
  	 if($signature=="") {
	 	    $str = $str . "<br/><br/><br/> ______________________________________";
	 }else {
     $str = $str . "<br/><br/><br/> <img src='$signature' /> ";
	 $str = $str . "<br/> ______________________________________";
	}
  $str = $str . " <br/> <div> <font  style='font-size:15px'> User : </font> ". $firstName ." ". $lastName;
   $str = $str . "<span style='margin-left:60%' > <font style='font-size:15px'> Date : ". $dateToday ."  </font></span></div>  ";
  $str = $str . " <font style='font-size:15px'> Advisor Name : </font> ". $_GET['advisor'];
  
  	 $str = $str . "<br/><b><center><span style='text-align:center;font-weight:700;font-size:15px;'>".
	"<input type='button' id='printbutton' value='Print this page' onclick='printpage()'> <br/></span></center> ";
    
 echo $str;
mysql_close();
session_write_close();
?> 
 