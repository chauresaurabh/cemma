<html>
<head>
<meta http-equiv="Content-Type" content="text/html">
<title>CEMMA - Policy</title>
<link rel="stylesheet" href="/dept/CEMMA/css/masc.css" type="text/css">
<link rel="stylesheet" href="/dept/CEMMA/css/usclogo.css" type="text/css">

</head>
<body bgcolor="#eeeeee" onLoad="init()"><center>
<table width="1024px" border="0" cellspacing="0" cellpadding="0" valign="top" style="table-layout:fixed:">
	<tr>
		<td>
			<table class="gold" width="100%" border="0" cellspacing="0" cellpadding="0" valign="top">
				<tr>
					<td colspan="5" id="usclogo" bgcolor="#000000">
                    <a href="http://www.usc.edu/" id="anchorlogo" target="_blank"> </a></td>
				</tr>
				<tr>
				<td align="center" height="100">
						  <span style="font-size:40px;  ">TEST Center for Electron Microscopy and Microanalysis</span>
 						<!--<img src="/dept/CEMMA/images/cemmab.gif" width="200" height="115" align="right">-->
					</td>
				</tr>
				<tr>
					<td valign="bottom" align="right">
						
						<a href="http://cemma-usc.net/cemma/testbed/login.php"><img src="/dept/CEMMA/images/login_black.gif" BORDER=0></a>
						<a href="/dept/CEMMA/account-set-up.htm"><img src="/dept/CEMMA/images/new_user_black.gif" BORDER=0></a>
						<a href="/dept/CEMMA/policy/"><img src="/dept/CEMMA/images/user_policy_black.gif" BORDER=0></a>
						<a href="/dept/CEMMA/instruments/status.html"><img src="/dept/CEMMA/images/instrument_availability.gif" BORDER=0></a>
						<!--<a href="/dept/CEMMA/sign_up.htm">Log In</a>
						<a href="/dept/CEMMA/account-set-up.htm">New User</a>-->
					</td>
				</tr>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" width="180" align="left" class="gold">
												
						<div class="content">
							<center>In Association with:<br>
							<a href="http://viterbi.usc.edu/" target="_blank"><img src="/dept/CEMMA/images/viterbi.gif" width="120" style="margin:2px"></a><br>
							<a href="http://www.usc.edu/schools/college/" border="0" target="_blank"><img src="/dept/CEMMA/images/Dornsife_Logo.jpg" width="120"style="margin:2px"></a>
							</center>
						</div>
						
						<div class="menu-button"><a href="/dept/CEMMA/"><img src="/dept/CEMMA/images/home_180.gif" BORDER=0></a></div>
						<div class="menu-button"><a href="/dept/CEMMA/mission"><img src="/dept/CEMMA/images/mission_statement_180.gif" BORDER=0></a></div>
						<div class="menu-button"><a href="/dept/CEMMA/instruments/"><img src="/dept/CEMMA/images/instruments_180.gif" BORDER=0></a></div>
						<div class="menu-button"><a href="http://cemma-usc.net/cemma/testbed/cemmastaff.php"><img src="/dept/CEMMA/images/professional_staff_180.gif" BORDER=0></a></div>
						<div class="menu-button"><a href="/dept/CEMMA/people_2/"><img src="/dept/CEMMA/images/oversight_committee_180.gif" BORDER=0></a></div>
						<!-- <div class="menu-button"><a href="/dept/CEMMA/policy/"><img src="/dept/CEMMA/images/policy_180.gif" BORDER=0></a></div> -->
						<div class="menu-button"><a href="/dept/CEMMA/location/"><img src="/dept/CEMMA/images/visit_us_180.gif" BORDER=0></a></div>
					</td>

					<td valign="top" class="silver" height="100%">
						<!-- PAGE TITLE -->
 						<div align="center">
 				 
                    <canvas id="can" name="can" width="200" height="100" style="position:absolute;top:20%;left:35%;border:2px solid;"></canvas>
     <input type="button" value="save" id="btn" size="30" onClick="save()"  >
    <input type="button" value="clear" id="clr" size="23" onClick="erase()" >
                              
						</div>
						<!-- END PAGE TITLE -->
						
						<!-- CONTENT -->
                       
							<embed src="./CEMMA_Policy.pdf" width="100%" height="900">
						<!-- END CONTENT -->
                        </div>
                          
 					</td>
 					 
				</tr>
				   
                
				<tr>
					<td class="gold" align="center"></td>

					<td class="silver" height="100%" valign="top">

						<!-- footer  -->
						<center>
						<hr width="100%">

						  <h3> <span class="content-link">
						  <!-- footer  -->
							<a href="/dept/CEMMA/">Home</a> | 
							<a href="/dept/CEMMA/mission/">Mission Statement</a> |
							<a href="/dept/CEMMA/instruments/">Instruments</a> | 
							<a href="http://cemma-usc.net/cemma/testbed/cemmastaff.php">Professional Staff</a> |        
							<a href="/dept/CEMMA/people_2/">Advisery Committee</a> |        
							Policy |        
							<a href="/dept/CEMMA/location/">Visit Us</a>
						  <!-- END FOOTER -->
							</span>
							</h3>
						</center>
					</td>
				</tr>
</table>
</body>

<script type="text/javascript">
var canvas, ctx, flag = false,
    prevX = 0,
    currX = 0,
    prevY = 0,
    currY = 0,
    dot_flag = false;

var x = "black",
    y = 2;

function init() {
    canvas = document.getElementById('can');
    ctx = canvas.getContext("2d");
    w = canvas.width;
    h = canvas.height;

    canvas.addEventListener("mousemove", function (e) {
        findxy('move', e)
    }, false);
    canvas.addEventListener("mousedown", function (e) {
        findxy('down', e)
    }, false);
    canvas.addEventListener("mouseup", function (e) {
        findxy('up', e)
    }, false);
    canvas.addEventListener("mouseout", function (e) {
        findxy('out', e)
    }, false);
}
 
function draw() {
    ctx.beginPath();
    ctx.moveTo(prevX, prevY);
    ctx.lineTo(currX, currY);
    ctx.strokeStyle = x;
    ctx.lineWidth = y;
    ctx.stroke();
    ctx.closePath();
}

function erase() {
    var m = confirm("Clear Signature ? ");
    if (m) {
        ctx.clearRect(0, 0, w, h);
     }
}
var dataURL;
function save() {
      dataURL = canvas.toDataURL();
 	
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
 						req.onreadystatechange = setPolicyData;
						req.open("GET", "saveimage.php?imgdefault="+dataURL, false);
					//	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						req.send("");
					} else {
						alert("Please enable Javascript");
					}
					
    	
}


		function setPolicyData(){
		if (req.readyState == 4 && req.status == 200) {
 			 alert(' Signature Saved');
 			}
		}
		
function findxy(res, e) {
    if (res == 'down') {
        prevX = currX;
        prevY = currY;
        currX = e.clientX - canvas.offsetLeft;
        currY = e.clientY - canvas.offsetTop;

        flag = true;
        dot_flag = true;
        if (dot_flag) {
            ctx.beginPath();
            ctx.fillStyle = x;
            ctx.fillRect(currX, currY, 2, 2);
            ctx.closePath();
            dot_flag = false;
        }
    }
    if (res == 'up' || res == "out") {
        flag = false;
    }
    if (res == 'move') {
        if (flag) {
            prevX = currX;
            prevY = currY;
            currX = e.clientX - canvas.offsetLeft;
            currY = e.clientY - canvas.offsetTop;
            draw();
        }
    }
}
</script>

</html>