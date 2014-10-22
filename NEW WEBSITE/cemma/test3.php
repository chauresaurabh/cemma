<?PHP
	$minUserLevel = 2; 
	$cfgProgDir = 'phpSecurePages/';
	include($cfgProgDir . "secure.php");
?>

<HTML><HEAD>
<TITLE>Test 3</TITLE>
</HEAD>

<BODY>
<P>This is phpSecurePages test page 3.</P>

<P><A HREF="test.php">Go to test page 1</A><BR>
<A HREF="test2.php">Go to test page 2</A><BR>
<FONT COLOR="Gray">Go to test page 3</FONT></P>
<P><A HREF="index.php">LogOut</A></P>

<P><TABLE>
<TR><TD>login:      </TD><TD><?PHP echo $login ?>    </TD></TR>
<TR><TD>password:   </TD><TD><?PHP echo $password ?> </TD></TR>
<TR><TD>user level: </TD><TD><?PHP echo $userLevel ?></TD></TR>
<TR><TD>ID:         </TD><TD><?PHP echo $ID ?>       </TD></TR>
</TABLE></P>
</BODY></HTML>