<?php
/*
$to = "amaypatil01@gmail.com";
$subject = "Test mail444";
$cc="koolamay_99@yahoo.com,ameyapat@usc.edu";
$message = "Hello! This is a simple email message.";
$from = "someonelse@example.com";
$headers = "From: $from";
$headers .= "\r\nCc: $cc";
//$headers .= "\r\nCc: koolamay_99@yahoo.com";
mail($to,$subject,$message,$headers);
echo "Mail Sent.";

*/
echo "<form name='myForm' id='myForm' method='post' action='Email.php?submit=yes&emailtypee=1'>";

echo "<input type='hidden' name = 'emailtypee' value='1'><div style='float:left;valign:top; margin-top:0; text-align:top;'><table style='padding-top:0; margin-top:0;' align='top'><tr><td><b>Name</b></td> <td><b> Email</b></td></tr></table>";

echo "</form>";

$test[10];
for($i=0;$i<3;$i++)
{
$types[$i]=$i;
}
for($i=0;$i<3;$i++)
{
echo "types----".$types[$i];
}
?> 