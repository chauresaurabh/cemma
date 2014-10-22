<? 

$dbhost="db1661.perfora.net";
$dbname="db260244667";
$dbusername="dbo260244667";
$dbpass="curu11i";

$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");

?>