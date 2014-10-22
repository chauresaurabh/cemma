 
<?
 session_start();
	$dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";

	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
  	 $instrumentName = $_GET['instrumentName'];  

	 $sql = "SELECT * from PROFESSIONAL_STAFF where name='".$instrumentName."'";
	 $result = mysql_query($sql);
	$numRows =  mysql_affected_rows();
	$outputStr="";
	if($numRows > 0)
	{
		$outputStr="[ ";
			while($row=mysql_fetch_array($result)){ 
		$outputStr = $outputStr.
		  " {'name':'".$row['name']."',
		    'email': '".$row['email']."',
			'phonenumber': '".$row['phonenumber']."',
			'image': '".$row['image']."',
			'designation': '".$row['designation']."'
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
 