#!/usr/usc/bin/perl -w
use strict;
use CGI qw(:all);
use CGI::Carp qw(fatalsToBrowser);

# Function for sending mail for systems without an MTA
sub send_mail {
	my($to, $from, $subject, @body) =@_;
	
	use Net::SMTP;
	
	my $relay="email.usc.edu";
	my $smtp = Net::SMTP->new($relay);
	die "Could not open connection : $!" if (! defined $smtp);
	
	$smtp->mail($from);
	$smtp->to($to);
	
	$smtp->data();
	$smtp->datasend("To: $to\n");
	$smtp->datasend("From: $from\n");
	$smtp->datasend("Subject: $subject\n");
	$smtp->datasend("\n");
	foreach(@body) {
		$smtp->datasend("$_\n");
	}
	$smtp->dataend();
	$smtp->quit;
}

	print header;
   	print "<body background=\"../_image/valtxtr.gif\">";
   		
	my $return = "curulli\@usc.edu";

	my $subject = "";
	$subject = param("subject");
	my $body = "";
	$body = param("body");
	my $to = "htu\@usc.edu";
	$to = param("to");

	send_mail($to, $return, $subject, $body);

	print "<p>From: $return</p>";
	print "<p>To: $to</p>";
	print "<p>subject: $subject</p>";
	print "<p>body: $body</p>";
	print "<p></p>";
	print "<h3>Mail has been sent successfully.</h3>";

	print "<p></p><p></p><p></p>";
