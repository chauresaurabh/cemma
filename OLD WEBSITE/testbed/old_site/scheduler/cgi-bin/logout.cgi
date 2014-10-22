#!/usr/usc/bin/perl -w
use CGI qw/:standard/;
use CGI::kSession;
#my $cgi=new CGI;
#print $cgi->header;
$sid=param("SID");
if($sid){
    my $s = new CGI::kSession(lifetime=>900, path=>"/var/local/www/unsupported-00/curulli/session/",id=>param("SID"));
    $s->unset(); # unregister all variables
    $s->destroy(); # delete session with this ID
    $url = "../index_alt.html";
    print "Location: $url\n\n";
    exit;
}
