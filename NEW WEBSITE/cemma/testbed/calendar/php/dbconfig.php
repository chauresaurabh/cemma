<?php
		

class DBConnection{
    private	$connection = null;
	function __construct(){
		if(!isset($_SESSION))
			session_start();
		//check if user is logged in
		if(!$_SESSION['login']){
			header('Location: login.php');
		}
		
		$dbhost="db1661.perfora.net";
		$dbname="db260244667";
		$dbusername="dbo260244667";
		$dbpass="curu11i";
	
		$this->connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
		mysql_select_db($dbname) or die ("Error in DB");
			
		//check if user is the admin
		$class = -1;
		$uname = $_SESSION['login'];
		$sql = "select Role_ID from Customer where Uname = '$uname'";
		$handle = mysql_query($sql);
		if ($row = mysql_fetch_array($handle)) {
			$class = $row["Role_ID"];
		}
		if($class != 1){
			//header('Location: login.php');
		}
		else
		{
			if($ClassLevel == 2)
			{
					header('Location: customers.php');
			}
			else if($ClassLevel == 3 || $ClassLevel == 4)
			{
				header('Location: EditMyAccountUser.php?id='.$_SESSION['login'].'');	
			}
		}
	}
	function getConnection(){
		//we are already connected
		return $this->connection;
	}
	function closeConnection(){
		try{
			mysql_close($this->connection);
		}catch(Exception $e){
		}
	}
}
?>