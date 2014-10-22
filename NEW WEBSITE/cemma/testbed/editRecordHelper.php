<script type = "text/javascript">
	
function editRecord(number, invoiceno, Gdate){

var xmlHttp = checkajax();
   
   xmlHttp.onreadystatechange=function() {
	
		   if(xmlHttp.readyState!=4)
			document.getElementById("error").innerHTML = "<img src = images/busy.gif>";

       if(xmlHttp.readyState==4) {

   	   document.getElementById("error").innerHTML = "&nbsp;";
	   document.getElementById("div3").innerHTML = '<div id="add">&nbsp;</div><form id="myform_sub" name="myform_sub"><input type = "hidden" name = "invoiceno" value ="'+invoiceno+'" ><input type = "hidden" name = "Gdate" value = "'+Gdate+'" ><input type = "hidden" name = "number" value = "'+number+'"><div id="add2"></div></form><br />';
	   var nvpairs = xmlHttp.responseText.split("&");
       adddata(nvpairs);
	   

   }
   }



	xmlHttp.open("GET","edit_invoice_data.php?Gdate="+Gdate+"&invoiceno="+invoiceno+"&number="+number+"&submit=submit" ,true);
     xmlHttp.send(null);   


}

function adddata(nvpairs){

var CustomerName = nvpairs[1];
var qty = nvpairs[2];
var machine = nvpairs[3];
var type = nvpairs[4];
var operator = nvpairs[5];
var day = nvpairs[6];
var month = nvpairs[7];
var year = nvpairs[8];
var withoperatortemp = nvpairs[9].split("<");

var withoperator = withoperatortemp[0];


myform = '<table width="380" class = "content" align="center" style="border:thin, #993300"><tr class="table1bg"><td width = "180">Select the Date: </td><td width="250"><select id="month" name="month" style="font-weight:normal"></select><select style="font-weight:normal" id ="date" name ="date"></select><select id="year" name="year" style="font-weight:normal; width=20mm "></select>';

/*myform+='<input type="text" name="date" id="date" readonly="readonly" size = "10" />';
myform+= "<img src = 'images/calendar.gif' height='20' width = '20' id='date_calendar' value='calendar' style='cursor:pointer'/></td></tr>";
*/

myform += '<tr><td>Customer Name: </td><td><input type = "text" readOnly = "" id = "name" name = "name" value = "' + CustomerName + '"></td></tr>';
myform += '<tr class="table1bg"><td>Machine Name: </td><td><select id= "MachineName" name="MachineName" style="font-weight:normal; width:39mm"></td></tr>';


<?

$sql1 = "SELECT machine_name FROM rates";
$result1 = mysql_query($sql1);

?>
myform+='</select>';

myform+='<tr><td>Operator&nbsp;&nbsp;</td><td><div id="divop"><select id="OperatorName" name="OperatorName" style="font-weight:normal; width:39mm" onChange ="checkOther()"></select></div></td></tr>';
myform+='<tr class="table1bg"><td>If Other, please enter here</td><td><input type="text" class="box" size="20" name="otheroperator" id = "otheroperator" disabled="disabled"></td></tr>';

myform+='</td></tr>';
myform+='<tr><td>Quantity&nbsp;&nbsp;</td><td><input type="text" id="qty" name="qty" value = ' + qty + '></td></tr>';
myform+='<tr class="table1bg"><td>Select the Type &nbsp;&nbsp;</td><td><select id="type" name="type" onChange = "checkType()" style="font-weight:normal; width:39mm"></select></td></tr>';

myform+= '<tr><td>Operator</td><td><input type = "radio" name = "woperator" id= "woperator" value = "1"> With Operator <input type = "radio" name = "woperator" id= "woperator" value = "0"> Without Operator</td></tr>';
myform+='<br><tr><td colspan = "2" align = "center"><a style="cursor:pointer;background:transparent url(images/mini/action_go.gif) no-repeat scroll left center;color:#996600;font-size:11px;font-weight:bold;padding-left:20px;text-decoration:none;"  onClick = "changeRecord()">Edit Record </a></td></table>';



document.getElementById("add2").innerHTML = myform;
//document.getElementById("date_calendar").onclick = function(){return showCalendar('date','mm/dd/y')}  


for (i=1;i<=31;i++){
if(i>9)
document.getElementById("date").options[i-1] = new Option(i,i);
else
document.getElementById("date").options[i-1] = new Option("0" + i,"0" + i);
}


i =0;

for(i=1;i<=12;i++){

if(i>9)
document.getElementById("month").options[i-1] = new Option(i,i);
else
document.getElementById("month").options[i-1] = new Option("0" + i,"0" + i);
}

k=0;
for(x=2007; x<=2014; x++){
document.getElementById("year").options[k++] = new Option(x,x);
}

document.getElementById("type").options[0] = new Option("USC Campus Users","On-Campus")
document.getElementById("type").options[1] = new Option("Off Campus Academic","Off-Campus")
document.getElementById("type").options[2] = new Option("Commerical-Industry", "Commerical")


i=0;
<?
while($row = mysql_fetch_array($result1, MYSQL_ASSOC))
{
?>
document.getElementById("MachineName").options[i++] = new Option("<? echo $row['machine_name']; ?>", "<? echo $row['machine_name']; ?>");
if(document.getElementById("MachineName").options[i-1].value == machine)
document.getElementById("MachineName").options[i-1].selected = true;
<?
}
?>

loadOperator(CustomerName, operator);

document.getElementById("date").options[day-1].selected = true;
document.getElementById("month").options[month-1].selected = true;
document.getElementById("year").options[year-2007].selected  = true;

if(type == "On-Campus")
document.getElementById("type").options[0].selected = true;
else if(type == "Off-Campus")
document.getElementById("type").options[1].selected = true;
else if(type == "Commerical")
document.getElementById("type").options[2].selected = true;


if(withoperator == 1)
document.forms['myform'].elements['woperator'][0].checked = true;
else if(withoperator == 0)
document.forms['myform'].elements['woperator'][1].checked = true;

checkType(); // Check if the Commercial is there. If so disable the radio button

}


function calendar(obj){

obj.showCalendar('date', 'mm/dd/y');

}


function checkOther()
{

if(document.getElementById("OperatorName").value == "Other")
	document.getElementById("otheroperator").disabled = false;
else{
	document.getElementById("otheroperator").value = "";
	document.getElementById("otheroperator").disabled = true;

}

}

function checkType()
{
if(document.getElementById("myform").type.selectedIndex == 2){
document.forms['myform'].elements['woperator'][1].disabled = true;
document.forms['myform'].elements['woperator'][0].checked = true;
}

else
document.forms['myform'].elements['woperator'][1].disabled = false;
}


function loadOperator(CustomerName, OperatorName){


var xmlHttp = checkajax();
   
   xmlHttp.onreadystatechange=function() {
      
	   if(xmlHttp.readyState!=4)
			document.getElementById("error").innerHTML = "<img src = images/busy.gif>";
	   
	   
	   if(xmlHttp.readyState==4) {
	   

	   document.getElementById("error").innerHTML = "&nbsp;";
	   document.getElementById("divop").innerHTML = xmlHttp.responseText;
	 }

	   
   }
   
	xmlHttp.open("GET","loadOperator.php?CustomerName="+CustomerName+"&OperatorName="+OperatorName ,true);
     xmlHttp.send(null);   




}

function changeRecord(){

// Getting form Values

var theform = document.invoiceform;
var CustomerName = theform.name.value;
var OperatorName = theform.OperatorName.value;
var newOperator = 0;
var MachineName = theform.MachineName.value;
var date = theform.date.value;
var month= theform.month.value;
var year = theform.year.value;
var qty = theform.qty.value;
var type = theform.type.value;
var number = theform.number.value;
var Gdate = theform.Gdate.value;
var invoiceno = theform.invoiceno.value;

if (theform.woperator[0].checked)
woperator = 1;
else
woperator = 0;

if(OperatorName == "Other"){
	OperatorName = theform.otheroperator.value;
	newOperator = 1;
}

// Error Checking


if(OperatorName == "Default"){
	error = "Please select the Operator";
	document.getElementById("error").innerHTML = error
	return
}

else if(OperatorName == ""){
	error = "Please specify the Operator";
	document.getElementById("error").innerHTML = error
	return
}


else if(month == 2 || month == 4 || month == 6 || month == 9 || month == 11){
	if(date == 31){
	error = "Invalid Date";
	document.getElementById("error").innerHTML = error;
	return;
	}
	else if(date == 30 && month == 2){
	error = "Invalid Date";
	document.getElementById("error").innerHTML = error;
	return;
	}
}



else if(!checkDigits(qty)){
	error = "Invalid Quantity";
	document.getElementById("error").innerHTML = error
	return
}

//Calling AJAX 


var xmlHttp = checkajax();
   
   xmlHttp.onreadystatechange=function() {
      
	   if(xmlHttp.readyState!=4)
			document.getElementById("error").innerHTML = "<img src = images/busy.gif>";
	   
	   
	   if(xmlHttp.readyState==4) {
	   

	   document.getElementById("error").innerHTML = "&nbsp;";
	   document.getElementById("error").innerHTML = "&nbsp;";
	   
	   
		// Everything is working fine
		document.getElementById("div1").innerHTML = xmlHttp.responseText;
		

	   
   }
   }
	xmlHttp.open("GET","editrecord.php?CustomerName="+CustomerName+"&OperatorName="+OperatorName+"&MachineName="+MachineName+"&newOperator="+newOperator+"&date="+date+"&month="+month+"&year="+year+"&qty="+qty+"&type="+type+"&woperator="+woperator+"&Gdate="+Gdate+"&number="+number+"&invoiceno="+invoiceno+"&submit=submit" ,true);
     xmlHttp.send(null);   


}

function checkDigits(string){
	digitRegex = /^\d+(\.\d+)?$/;
	if( !string.match( digitRegex ) ) {
	  return false;
	 }
	 return true;
}


</script>