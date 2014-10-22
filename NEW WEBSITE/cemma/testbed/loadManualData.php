 
<?
 session_start();
	$dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
  	 $instrumentNo = $_GET['instrumentNo'];  

	 $sql = "SELECT a.* FROM MANUAL a, instrument b where a.instrument_num = b.instrumentNo
	  and a.instrument_num=".$instrumentNo;
	 $result = mysql_query($sql);
	$numRows =  mysql_num_rows($result);
	$outputStr="";
	if($numRows > 0)
	{
		$outputStr="[ ";
			while($row=mysql_fetch_array($result)){ 
		$outputStr = $outputStr.
		  " {'manual_name':'".$row['manual_name']."',
		    'manual_filename': '".$row['manual_filename']."',
			'manual_num': '".$row['manual_num']."'
			}, ";
		}
		$outputStr= $outputStr. " ]";
		
	}else{
	 	$outputStr = "{'notfound':'not found'}";
	}
	echo $outputStr;
  
mysql_close();
session_write_close();
?> 
 