#!/usr/bin/perl
use CGI::Carp qw(fatalsToBrowser);

use LWP::Simple;
use Data::Dumper;
use XML::Simple;
use CGI qw/:standard/;


#print "Content-type: text/html\n\n";
$filename = './number';

open (temp_file,$filename);
@temp_content=<temp_file>;
close(temp_file);

$number = $temp_content[0];
$number = $number + 1;

#$filename = '> /srv/www/cgi-bin/number';

#open (temp_file,$filename);
#print temp_file $number;
#close(temp_file);
#print "<p>" . $number . "</p>";

#var inv_num = "01/10";

my $now = localtime time;
my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime time;
#print "<p>".substr($year, 1, 2)."/".$number."</p>";

$filename = '../../invoice1.js';

open (temp_file,$filename);
@temp_content1=<temp_file>;
close(temp_file);

$number1 = substr($year, 1, 2) + 1;

$temp_content1[5] = 'var inv_num = "'.$number1.'/'.$number.'"';

$filename = '> ../../invoice.js';
open (temp_file,$filename);
print temp_file @temp_content1;
close(temp_file);

$url = "http://www.cemma-usc.net/schedule/cemma/invoice/page_one.html";
print "Location: $url\n\n";
exit;

