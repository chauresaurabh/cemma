#!/usr/bin/perl
#use CGI::Carp qw(fatalsToBrowser);

use LWP::Simple;
use DBI;

$request_method = $ENV{'REQUEST_METHOD'};
$size_of_form_info=$ENV{'CONTENT_LENGTH'};

read(STDIN, $buffer, $size_of_form_info);

print "Content-type: text/xml\n\n";

#for each pair, extract name and value




$db="db220007334";
$host="db1157.perfora.net";
$userid="dbo220007334";
$passwd="XhYpxT5v";
$connectionInfo="dbi:mysql:$db;$host";




# make connection to database
$dbh = DBI->connect($connectionInfo,$userid,$passwd);

print "<?xml version=\"1.0\"?>\n<search>\n";
   

$query = "select distinct name from invoice";

$sth = $dbh->prepare($query);

$sth->execute();

$sth->bind_columns(\$name);

while($sth->fetch()) {
   print "<entry><name>$name</name></entry>";
}

print '</search>';
$sth->finish();
$dbh->disconnect();
