function hideRow(id){
	//document.getElementById(id).style.visibility = "hidden";
	document.getElementById(id).style.display = "none";
}

function showRow(id){
	
	//document.getElementById(id).style.visibility = "visible";
	document.getElementById(id).style.display = "";
}

function hasClass(ele,cls) {
	return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}

function addClass(ele,cls) {
	if (!this.hasClass(ele,cls)) ele.className += " "+cls;
}

function removeClass(ele,cls) {
	if (hasClass(ele,cls)) {
		var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
		ele.className=ele.className.replace(reg,' ');
	}
}

function confirmBox(){
	
	var confirm = confirm("Are you sure you want to continue?");
	return confirm;
	
}
