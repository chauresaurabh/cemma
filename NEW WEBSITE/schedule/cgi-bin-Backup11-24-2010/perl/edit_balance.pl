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
    
	if($name eq "number")
	{
 		$number = $value;
	}	
	elsif($name eq "amount")
	{
 		$amount = $value;
	}
	elsif($name eq "poreq")
	{
 		$poreq = $value;
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


   

$query = "UPDATE invoice SET amount_paid=$amount WHERE invoice_number='$number'";
#print "<output>$query</output>";
$sth = $dbh->prepare($query);

$sth->execute();

$query = "UPDATE invoice SET PO_REQ='$poreq' WHERE invoice_number='$number'";
#print "<output>$query</output>";
$sth = $dbh->prepare($query);

$sth->execute();


$sth->finish();
$dbh->disconnect();
