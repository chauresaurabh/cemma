function editRecord(number, invoiceno, Gdate){

var xmlHttp = checkajax();
   
   xmlHttp.onreadystatechange=function() {
	
		   if(xmlHttp.readyState!=4)
			document.getElementById("error1").innerHTML = "<img src = images/busy.gif>";

       if(xmlHttp.readyState==4) {

   	   document.getElementById("error1").innerHTML = "&nbsp;";
	   document.getElementById("div3").innerHTML = '<div id="add"></div><form id="form2" name = "form2"><input type = "hidden" name = "invoiceno" value ="' + invoiceno + '" ><input type = "hidden" name = "Gdate" value = "' + Gdate + '" ><input type = "hidden" name = "number" value = "' + number + '"><div id="add2"></div></form>';
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


form2 = '<table width="380" class = "content" align="center" style="border:thin, #993300"><tr class="table1bg"><td width = "180">Select the Date: </td><td width="250"><select id="month" name="month" style="font-weight:normal"></select><select style="font-weight:normal" id ="date" name ="date"></select><select id="year" name="year" style="font-weight:normal; width=20mm "></select>';

/*form2+='<input type="text" name="date" id="date" readonly="readonly" size = "10" />';
form2+= "<img src = 'images/calendar.gif' height='20' width = '20' id='date_calendar' value='calendar' style='cursor:pointer'/></td></tr>";
*/

form2 += '<tr><td>Customer Name: </td><td><input type = "text" readOnly = "" id = "name" name = "name" value = "' + CustomerName + '"></td></tr>';
form2 += '<tr class="table1bg"><td>Machine Name: </td><td><select id= "MachineName" name="MachineName" style="font-weight:normal; width:39mm"></td></tr>';


<?

$sql1 = "SELECT machine_name FROM rates";
$result1 = mysql_query($sql1);

?>
form2+='</select>';

form2+='<tr><td>Operator&nbsp;&nbsp;</td><td><div id="divop"><select id="OperatorName" name="OperatorName" style="font-weight:normal; width:39mm" onChange ="checkOther()"></select></div></td></tr>';
form2+='<tr class="table1bg"><td>If Other, please enter here</td><td><input type="text" class="box" size="20" name="otheroperator" id = "otheroperator" disabled="disabled"></td></tr>';

form2+='</td></tr>';
form2+='<tr><td>Quantity&nbsp;&nbsp;</td><td><input type="text" id="qty" name="qty" value = ' + qty + '></td></tr>';
form2+='<tr class="table1bg"><td>Select the Type &nbsp;&nbsp;</td><td><select id="type" name="type" onChange = "checkType()" style="font-weight:normal; width:39mm"></select></td></tr>';

form2+= '<tr><td>Operator</td><td><input type = "radio" name = "woperator" id= "woperator" value = "1"> With Operator <input type = "radio" name = "woperator" id= "woperator" value = "0"> Without Operator</td></tr>';
form2+='<br><tr><td colspan = "2" align = "center"><input type = "button" value = "Edit Record" onClick = "changeRecord()";></td></table>';



document.getElementById("add2").innerHTML = form2;
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
document.form2.woperator[0].checked = true;
else if(withoperator == 0)
document.form2.woperator[1].checked = true;

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
