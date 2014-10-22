<html>
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
        document.getElementById("canvasimg").style.display = "none";
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
		// document.getElementById("canvasimg").style.border = "2px solid";
    	// document.getElementById("canvasimg").src = req.responseText;
   		// document.getElementById("canvasimg").style.display = "inline"; 
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
<body onLoad="init()">
	
    <form method="post" >
    <p style="position:absolute;top:4%;left:10%"> Please sign here </p>
    <canvas id="can" name="can" width="200" height="100" style="position:absolute;top:10%;left:10%;border:2px solid;"></canvas>
    <!-- <div style="position:absolute;top:22%;left:45%;width:15px;height:15px;background:white;border:2px solid;" id="white" onClick="color(this)"></div> -->
    <img id="canvasimg" style="position:absolute;top:10%;left:52%;" style="display:none;">
    <input type="button" value="save" id="btn" size="30" onClick="save()" style="position:absolute;top:30%;left:10%;">
    <input type="button" value="clear" id="clr" size="23" onClick="erase()" style="position:absolute;top:30%;left:15%;">
    </form>
</body>
</html>