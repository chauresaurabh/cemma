<?
	if(!isset($_SESSION))
		session_start();
		
	$class=$_GET['class'];
	if($class!=1){
		echo "You are not allowed access to this site";
		exit;
	}
?>
<script type = "text/javascript">
	window.location="http://cemma-usc.net/cemma/testbed/login.php";
	
		var req;
		function showPermit(instrNum){
			if (window.XMLHttpRequest) {
						try {
							req = new XMLHttpRequest();
						} catch (e) {
							req = false;
						}
					} else if (window.ActiveXObject) {
						try {
							req = new ActiveXObject("Msxml2.XMLHTTP");
						} catch (e) {
							try {
								req = new ActiveXObject("Microsoft.XMLHTTP");
							} catch (e) {
								req = false;
							}
						}
					}
					if (req) {
						req.onreadystatechange = showPermitData;
						req.open("POST", "http://cemma-usc.net/cemma/testbed/authentication/authentication.php", true);
						req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("username=John&password=321");
					} else {
						alert("Please enable Javascript");
					}
					<? header('Location: http://cemma-usc.net/cemma/testbed/administration.php');?>
		}
	</script>