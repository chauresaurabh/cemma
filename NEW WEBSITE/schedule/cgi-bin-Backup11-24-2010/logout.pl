#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;

$sid=param("SID");
if($sid){
    my $s = new CGI::kSession(lifetime=>900, path=>"../../var/session/",id=>param("SID"));
    $s->unset(); # unregister all variables
    $s->destroy(); # delete session with this ID
    $url = "../index.php";
    print "Location: $url\n\n";
    exit;
}
