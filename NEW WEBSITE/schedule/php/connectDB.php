<?php
//connecting and printing some stuff

$username="dbo260244667";
$password="curu11i";  //remember php is stripped out of html files
$database="db260244667"; //before leaving the server machine 

// CEMMA Database
/*
$username="dbo210021972";
$password="XhYpxT5v";  //remember php is stripped out of html files
$database="db210021972"; //before leaving the server machine 
*/

// define that client supports the multiple statements
define('CLIENT_MULTI_STATEMENTS',65536);
// define that client supports multiple results
define('CLIENT_MULTI_RESULTS',131072);
// the values of these defines I've found in the sourcecode of MySQL5: mysql_com.h
// Attention: these values can be changed in other distributions of mysql

// Connect the database with the flags
$link = mysql_connect("db1661.perfora.net",$username,$password,null,CLIENT_MULTI_RESULTS|CLIENT_MULTI_STATEMENTS) or die('<br>ERR: could not connect to mySQL database:' . mysql());  //connect to SQL
// CEMMA Database
//$link = mysql_connect("db948.perfora.net",$username,$password,null,CLIENT_MULTI_RESULTS|CLIENT_MULTI_STATEMENTS) or die('<br>ERR: could not connect to mySQL database:' . mysql());  //connect to SQL


//select database
mysql_select_db($database) or die( "Unable to select database '$database'");
?>