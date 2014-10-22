
<?

		include(DOCUMENT_ROOT."includes/DatabaseOld.php");
		$sql11 = "SELECT UserName,LastName,Email, FirstName,FieldofInterest FROM user where ActiveUser='active' OR ActiveUser IS NULL ORDER BY FirstName";
		$result11 = mysql_query($sql11,$connection);
		$num_rows = mysql_num_rows($result11);
//		$_SESSION['currentusers']= $num_rows;
		$currentuserscount= $num_rows;

		$sql11 = 'SELECT UserName,LastName,Email, FirstName,FieldofInterest,TransferredToUsers FROM UsersInQuery where TransferredToUsers IS NULL OR TransferredToUsers = 0 ORDER BY FirstName';
		$result11 = mysql_query($sql11,$connection);
		$num_rows = mysql_num_rows($result11);
//		$_SESSION['newrequests']= $num_rows;
		$newrequestscount= $num_rows;

		$sql11 = "SELECT UserName,LastName,Email, FirstName,FieldofInterest FROM user where ActiveUser='inactive' ORDER BY FirstName";
		$result11 = mysql_query($sql11,$connection);
		$num_rows = mysql_num_rows($result11);
//		$_SESSION['archived']= $num_rows;
		$archivedcount= $num_rows;
		$glob=1;
		/*end  */

		?>