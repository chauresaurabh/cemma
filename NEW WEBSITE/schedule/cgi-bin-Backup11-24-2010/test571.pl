#!/usr/bin/perl
use strict;
use warnings;
print "content-type: text/html \n\n";
my @numbers = (1..10);
my @letters = ("a".."j");
print "length". scalar(@numbers)."\n";
for (my $i=0;$i < scalar(@numbers); $i++) {
if ($i % 2 == 0) {
splice(@numbers, $i, 0, $letters[$i%(scalar(@letters))]);
}
print "$i $numbers[$i]\n";
}

#print "\nlength2". scalar(@numbers);
print "ppp";
for (my $i=0;$i < scalar(@numbers); $i++) {

print "$numbers[$i]\n";
}

print "\n"