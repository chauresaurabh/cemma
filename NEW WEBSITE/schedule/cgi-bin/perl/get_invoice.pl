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

print "<?xml version=\"1.0\"?>\n<?xml-stylesheet type='text/xsl' href='http://www.cemma-usc.net/schedule/cemma/invoice/invoice.xsl'?>";
   

$query = "select * from invoice where invoice_number='$value'";

$sth = $dbh->prepare($query);

$sth->execute();

$sth->bind_columns(\$invoice_number, \$PO_REQ, \$name1 , \$address, \$city, \$state, \$zip, \$phone, \$fax, \$type, \$date1, \$grandtotal, \$paid);
print "<invoice><header>";
while($sth->fetch()) {
   print "<number>$invoice_number</number><poreq>$PO_REQ</poreq><name>$name1</name><address>$address</address><city>$city</city><state>$state</state><zip>$zip</zip><phone>$phone</phone><fax>$fax</fax><type>$type</type><date>$date1</date><total>$grandtotal</total><amountpaid>$paid</amountpaid>";
}
print "</header><data>";
$query = "select * from invoice_data where invoice_number='$value'";

$sth = $dbh->prepare($query);

$sth->execute();

$sth->bind_columns(\$invoice_number,\$quantity,\$date,\$machine,\$operator,\$withoperator,\$price,\$total);

while($sth->fetch()) {
   #print "<amount><name1>$name2</name1><amountpaid>$amount</amountpaid></amount>";
   print "<entry><quantity>$quantity</quantity><date>$date</date><machine>$machine</machine><operator>$operator</operator><withoperator>$withoperator</withoperator><price>$price</price><total>$total</total></entry>";
}
print "</data>";
print "<grandtotal>$grandtotal</grandtotal>";
print '</invoice>';

$sth->finish();
$dbh->disconnect();
