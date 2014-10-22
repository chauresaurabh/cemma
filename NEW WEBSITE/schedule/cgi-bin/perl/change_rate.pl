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
    
	if($name eq "field1")
	{
 		$field1 = $value;
	}	
	if($name eq "field2")
	{
 		$field2 = $value;
	}	
	if($name eq "field3")
	{
 		$field3 = $value;
	}	
	if($name eq "field4")
	{
 		$field4 = $value;
	}	
	if($name eq "field5")
	{
 		$field5 = $value;
	}	
	if($name eq "field6")
	{
 		$field6 = $value;
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


   

$query = "delete from rates where machine_name='$field1'";

#print "<p>".$query."</p>"
$sth = $dbh->prepare($query);

$sth->execute();



$query = "insert into rates values (NULL,'$field1',$field2,$field3,$field4,$field5,$field6)";
#print "<p>".$query."</p>"
$sth = $dbh->prepare($query);

$sth->execute();

$sth->finish();
$dbh->disconnect();