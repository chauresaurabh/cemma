#!/usr/bin/perl
use lib "/kunden/homepages/40/d209127057/htdocs/schedule/cgi-bin/";
use CGI qw/:standard/;
use CGI::kSession;
use DBI;


 sub sendEmail
 {
 	my ($to, $from, $subject, $message) = @_;
 	my $sendmail = '/usr/lib/sendmail';
 	open(MAIL, "|$sendmail -oi -t");
 		print MAIL "From: $from\n";
 		print MAIL "To: $to\n";
 		print MAIL "Subject: $subject\n\n";
 		print MAIL "$message\n";
 	close(MAIL);
 } 


	print header;

	my $from = "cemma\@usc.edu";

	my $subject = "New User Account Request ";
	my $body = "hi";
	
	my $to = "ameyapat\@usc.edu";
	

	sendEmail($to, $from, $subject, $body);
 



