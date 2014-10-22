
<?php

ob_start();
$perl = new Perl();
//$perl->require("test.pl");
$out = ob_get_contents();
ob_end_clean();
print "Perl: $out";

?>