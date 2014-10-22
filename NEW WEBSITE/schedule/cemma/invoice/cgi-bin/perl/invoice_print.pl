 
#!/usr/bin/perl
#use CGI::Carp qw(fatalsToBrowser);

use LWP::Simple;
use DBI;

$request_method = $ENV{'REQUEST_METHOD'};
$size_of_form_info=$ENV{'CONTENT_LENGTH'};

read(STDIN, $buffer, $size_of_form_info);

#print "Content-type: text/html\n\n";
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


$filename = '../../invoice_print1.js';

open (temp_file,$filename);
@temp_content1=<temp_file>;
close(temp_file);

$number1 = substr($year, 1, 2) + 1;

$temp_content1[5] = 'var inv_num = "'.$st.'"';

$filename = '> ../../invoice_print.js';
open (temp_file,$filename);
print temp_file @temp_content1;
close(temp_file);

$url = "http://www.cemma-usc.net/schedule/cemma/invoice/invoice_print.html";
print "Location: $url\n\n";
exit;