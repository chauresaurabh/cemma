#!/usr/bin/perl -w
use CGI::Carp qw(fatalsToBrowser);
use DBI;
use LWP::Simple;
use Data::Dumper;
use XML::Simple;

$request_method = $ENV{'REQUEST_METHOD'};
$size_of_form_info=$ENV{'CONTENT_LENGTH'};

read(STDIN, $buffer, $size_of_form_info);

print "Content-type: text/html\n\n";

#print "<p>" . "hello" . "</p>";
@nvpairs = split(/&/, $buffer);
foreach $pair (@nvpairs) {
   ($name, $value) = split(/=/, $pair);
   $value =~ tr/+/ /;
   $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    
	if($name eq "invoice")
	{
 		$st = $value;
	}	
	if($name eq "page")
	{
 		$page= $value;
	}	
}
#for each pair, extract name and value

$value =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;

$filename = '../../invoice.xml';

open("output", ">$filename");	# Open for output

print output $st;
#print $st;
close(output);

$filename1 = '../../output_invoice.html';

open("output1", ">$filename1");	# Open for output

print output1 $page;
#print $st;
close(output1);



$xml = new XML::Simple (KeyAttr=>[]);
$data = $xml->XMLin($filename);

$filename = './number';

open (temp_file,$filename);
@temp_content=<temp_file>;
close(temp_file);

$number = $temp_content[0];
$number = $number + 1;

$filename = '> ./number';

open (temp_file,$filename);
print temp_file $number;
close(temp_file);
#print "<p>" . $number . "</p>";

		

$db="db220007334";
$host="db1157.perfora.net";
$userid="dbo220007334";
$passwd="XhYpxT5v";
$connectionInfo="dbi:mysql:$db;$host";



# make connection to database
$dbh = DBI->connect($connectionInfo,$userid,$passwd);

$query = "insert into invoice values ('$data->{header}->{number}','$data->{header}->{poreq}','$data->{header}->{name}','$data->{header}->{address}','$data->{header}->{city}','$data->{header}->{state}','$data->{header}->{zip}','$data->{header}->{phone}','$data->{header}->{fax}',$data->{header}->{clienttype},'$data->{header}->{invoicedate}',$data->{grandtotal},'false')";
$sth = $dbh->prepare($query);


#print "<p>".$query."</p>";
$sth->execute();

foreach $e (@{$data->{data}->{entry}})
{
	$query = "insert into invoice_data values ('$data->{header}->{number}',$e->{quantity},'$e->{date}','$e->{machine}','$e->{operator}',$e->{withoperator},$e->{price},$e->{total})";
	$sth = $dbh->prepare($query);
	#print "<p>".$query."</p>";
	$sth->execute();
}
print "<head><script type='text/javascript'>function display_invoice () { var num1 = '$data->{header}->{number}'; document.getElementById('number').value = num1; document.getElementById('form1').submit();	}</script> ";

print "<body><p>" . "Invoice created successfully" . "</p>";
print "<form id='form1' action='invoice_print.pl' method='post'><input id='number' name='number' type='hidden' ></form>";
print "<br><a href='#' onclick='javascript:display_invoice()'>Click here </a>to view the invoice.";
#print "<br><a href='http://127.0.0.1/cemma/invoice/output_invoice.pdf'>Click here </a>to download your invoice.";
print "<br><a href='http://www.cemma-usc.net/schedule/cgi-bin/perl/page.pl'>Click here </a>to create another invoice.</body>";
