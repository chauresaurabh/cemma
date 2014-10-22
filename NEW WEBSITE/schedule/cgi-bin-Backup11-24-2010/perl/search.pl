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
 		$st = $value;
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

print "<?xml version=\"1.0\"?>\n<search>\n";
   

$query = "select * from invoice where name='$value'";

$sth = $dbh->prepare($query);

$sth->execute();

$sth->bind_columns(\$invoice_number, \$PO_REQ, \$name1 , \$address, \$city, \$state, \$zip, \$phone, \$fax, \$type, \$date1, \$grandtotal, \$paid);

while($sth->fetch()) {
   print "<entry><number>$invoice_number</number><poreq>$PO_REQ</poreq><name>$name1</name><address>$address</address><city>$city</city><phone>$phone</phone><fax>$fax</fax><type>$type</type><date>$date1</date><total>$grandtotal</total><amountpaid>$paid</amountpaid></entry>";
}
$query = "select * from balance where name='$value'";

$sth = $dbh->prepare($query);

$sth->execute();

$sth->bind_columns(\$name2,\$amount);

while($sth->fetch()) {
   print "<amount><name1>$name2</name1><amountpaid>$amount</amountpaid></amount>";
}

print '</search>';
$sth->finish();
$dbh->disconnect();
