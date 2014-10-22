#!/usr/bin/perl
#use CGI::Carp qw(fatalsToBrowser);

use LWP::Simple;
use DBI;

$request_method = $ENV{'REQUEST_METHOD'};
$size_of_form_info=$ENV{'CONTENT_LENGTH'};

read(STDIN, $buffer, $size_of_form_info);

print "Content-type: text/xml\n\n";
@nvpairs = split(/&/, $buffer);
foreach $pair (@nvpairs) {
   ($name, $value) = split(/=/, $pair);
   $value =~ tr/+/ /;
   $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    
	if($name eq "name")
	{
 		$nam = $value;
	}	
	
}
#for each pair, extract name and value

$value =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;


$db="db220007334";
$host="db1157.perfora.net";
$userid="dbo220007334";
$passwd="XhYpxT5v";
$connectionInfo="dbi:mysql:$db;$host";




# make connection to database
$dbh = DBI->connect($connectionInfo,$userid,$passwd);


   

$query = "insert into balance values ('$nam',0)";

$sth = $dbh->prepare($query);

$sth->execute();


$sth->finish();
$dbh->disconnect();
