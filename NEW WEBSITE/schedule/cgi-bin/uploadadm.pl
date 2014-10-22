#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;
use Date::Business;
require 'enmonth.pl';
require 'enweekday.pl';

$dsn = "DBI:mysql:database=db210021972:host=db948.perfora.net";
$db= DBI->connect($dsn, "dbo210021972", "XhYpxT5v");

my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));
$s->start();
$login=param("login");
$spassword=$s->get("$login");
$sth = $db->prepare("select Passwd from user where UserName = '$login'");
$sth->execute();
$passworddb = $sth->fetchrow_array();
$sth->finish();

if($spassword eq $passworddb)
{
$html=qq{
	<html>
<body>
<center><form action="../upload_file_adm.php?username=$login" method="post" enctype="multipart/form-data">
<label for="file">Upload</label>
<br />
<input type="file" name="file" id="file" style="width:200px;"/> 
<br />
<input type="submit" name="submit" value="Submit" style="width:200px;" />
<br />
</form>
<br />
<br />
<br />
<form action="../download_file_adm.php?username=$login" method="post" enctype="multipart/form-data">
<input type="submit" value="download" style="width:200px;"/>
</form>
		<br />
<br />
<br />
<form action="../manage.php?" method="post" enctype="multipart/form-data">
<input type="submit" value="Manage Users Files" style="width:200px;"/>
</form></center>
</body>
</html>
};
print $html;
}

else
{
	$db->disconnect;
	print "Content-type: text/html\r\n\r\n";
	print "<body onload=\"Javascript:parent.location.replace('../index_alt.html')\">"; 		
	print "</body>";
	exit;
}
$sth->finish;