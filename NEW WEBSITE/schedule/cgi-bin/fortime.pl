#!/usr/bin/perl
use Time::Local 'timelocal_nocheck';
            # The 365th day of 1999
#            print scalar localtime timelocal_nocheck 0,0,0,365,0,99;
            # The twenty thousandth day since 1970
#            print scalar localtime timelocal_nocheck 0,0,0,20000,0,70;
            # And even the 10,000,000th second since 1999!
#            print scalar localtime timelocal_nocheck 10000000,0,0,1,0,99;
use time::gmtime;            
#            $time = timegm(10000000,0,0,1,0,99);
	
	
use Time::gmtime;
use File::stat;
