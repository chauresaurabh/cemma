var xmlDoc;
var xmlDoc1;
var new_machine = false;

function add_machine()
{
	show_details("",0,0,0,0,0);
}

function delete_machine()
{
		var root;
		var found = false;
		var req = false;// = GXmlHttp.create();
//alert("hello0");
		if (!confirm("Are you sure you want to delete the instrument " + document.getElementById("machine_name").value + "?"))
		{
			return;
		}
			if(window.XMLHttpRequest)
			{
				try
				{
					req=new XMLHttpRequest();
					//alert("XMLHttpRequest");
				}
				catch(e)
				{
					req=false;
				}
			}
			else if(window.ActiveXObject)
			{
				try
				{
					req=new ActiveXObject("Msxml2.XMLHTTP");
					//alert("Msxml2.XMLHTTP");
				}
				catch(e)
				{
					try
					{
						req=new ActiveXObject("Microsoft.XMLHTTP");
						//alert("Microsoft.XMLHTTP");
					}
					catch(e)
					{
						req=false;
					}

				}
			}

			if (req)
			{
				//alert(document.getElementById("machine_name").value);
				var valuestosend = "field1=" + encodeURI(document.getElementById("machine_name").value);
				
				
				var url="cgi-bin/perl/delete_machine.pl";
				//if (new_machine)
					//url="http://www.cemma-usc.net/schedule/cgi-bin/perl/new_machine.pl";
				//url = url + "?" + valuestosend;
				req.open("POST", url, true);
				req.setRequestHeader("Connection", "Close");
				req.setRequestHeader("Content-type","application/x-www-formurlencoded");
				//req.setRequestHeader("Method", "POST" + url + "HTTP/1.1");
			
			
				req.onreadystatechange = function() 
				{
					if (req.readyState == 4 && req.status == 200) 
					{
						//alert(req.responseText);
						alert("Instrument " + document.getElementById("machine_name").value + " deleted.");
						onload1();
					}
			else
			{
				//alert("error");
			}
}
req.send(valuestosend);
}

}

function submitted()
{
		var root;
		var found = false;
		var req = false;// = GXmlHttp.create();
//alert("hello0");
		if (document.getElementById("machine_name").value=="")
		{
			alert("Enter name");
			return;
		}
			if(window.XMLHttpRequest)
			{
				try
				{
					req=new XMLHttpRequest();
					//alert("XMLHttpRequest");
				}
				catch(e)
				{
					req=false;
				}
			}
			else if(window.ActiveXObject)
			{
				try
				{
					req=new ActiveXObject("Msxml2.XMLHTTP");
					//alert("Msxml2.XMLHTTP");
				}
				catch(e)
				{
					try
					{
						req=new ActiveXObject("Microsoft.XMLHTTP");
						//alert("Microsoft.XMLHTTP");
					}
					catch(e)
					{
						req=false;
					}

				}
			}

			if (req)
			{
				//alert(document.getElementById("machine_name").value);
				var valuestosend = "field1=" + encodeURI(document.getElementById("machine_name").value);
				valuestosend += "&field2=" + encodeURI(document.getElementById("oncampus_with_operator").value);
				valuestosend += "&field3=" + encodeURI(document.getElementById("oncampus_without_operator").value);
				valuestosend += "&field4=" + encodeURI(document.getElementById("acad_with_operator").value);
				valuestosend += "&field5=" + encodeURI(document.getElementById("acad_without_operator").value);
				valuestosend += "&field6=" + encodeURI(document.getElementById("comm_with_operator").value);
				
				var url="cgi-bin/perl/change_rate.pl";
				//if (new_machine)
					//url="http://www.cemma-usc.net/schedule/cgi-bin/perl/new_machine.pl";
				//url = url + "?" + valuestosend;
				req.open("POST", url, true);
				req.setRequestHeader("Connection", "Close");
				req.setRequestHeader("Content-type","application/x-www-formurlencoded");
				//req.setRequestHeader("Method", "POST" + url + "HTTP/1.1");
			
			
				req.onreadystatechange = function() 
				{
					if (req.readyState == 4 && req.status == 200) 
					{
						//alert(req.responseText);
						alert("Changes Made");
						onload1();
					}
			else
			{
				//alert("error");
			}
}
req.send(valuestosend);
}

}

function rate_change(e)
{
	var k;
	document.all ? k = e.keyCode : k = e.which;
	return (!isNaN(String.fromCharCode(k)) || String.fromCharCode(k)=="." || k==8 || k==46 || k==0);
}

function extractRate(str)
{
	var output = "";
	var ch;
	for (i=0;i<str.length;i++)
	{
		ch=str.charAt(i);
		if(ch=="0" || ch=="1" || ch=="2" || ch=="3" || ch=="4" || ch=="5" || ch=="6" || ch=="7" || ch=="8" || ch=="9" || ch==".") 
		{
			output = output + ch;
		}
	}
	return output;
}

function show_details(machine_name,oncampus_with_operator,oncampus_without_operator, acad_with_operator,acad_without_operator,comm_with_operator)
{
	var innerhtml = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"1\" width=\"100%\"><tr><td colspan=\"5\"><center><b>Instrument Name:</b><input type=\"text\" id=\"machine_name\" value=\"" + machine_name + "\"><br><br><br></td></tr>";
	innerhtml += "<tr><td align=\"center\"><b>Oncampus with Operator</b></td><td align=\"center\"><b>Oncampus without Operator</b></td><td align=\"center\"><b>Academic with Operator</b></td><td align=\"center\"><b>Academic without Operator</b></td><td align=\"center\"><b>Commercial with Operator</b></td>";
	innerhtml += "<tr><td align=\"center\"><input type=\"text\" id=\"oncampus_with_operator\" onkeypress=\"return rate_change(event)\" onchange=\"this.value=extractRate(this.value)\"></td><td align=\"center\"><input type=\"text\" id=\"oncampus_without_operator\" onkeypress=\"return rate_change(event)\" onchange=\"this.value=extractRate(this.value)\"></td><td align=\"center\"><input type=\"text\" id=\"acad_with_operator\" onkeypress=\"return rate_change(event)\" onchange=\"this.value=extractRate(this.value)\"></td><td align=\"center\"><input type=\"text\" id=\"acad_without_operator\" onkeypress=\"return rate_change(event)\" onchange=\"this.value=extractRate(this.value)\"></td><td align=\"center\"><input type=\"text\" id=\"comm_with_operator\" onkeypress=\"return rate_change(event)\" onchange=\"this.value=extractRate(this.value)\"></td></tr></table><br><br><br><center><input type=\"button\" onclick=\"javascript:submitted()\" value=\"Submit\">";
	document.getElementById("details").innerHTML=innerhtml;
	document.getElementById("oncampus_with_operator").value=parseFloat(oncampus_with_operator);
	document.getElementById("oncampus_without_operator").value=parseFloat(oncampus_without_operator);
	document.getElementById("acad_with_operator").value=parseFloat(acad_with_operator);
	document.getElementById("acad_without_operator").value=parseFloat(acad_without_operator);
	document.getElementById("comm_with_operator").value=parseFloat(comm_with_operator);
	
}

function machine_change()
{
	new_machine = false;
	if (window.ActiveXObject)
	{
		xmlDoc1 = new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc1.async = false;
		
		xmlDoc1.load("cgi-bin/perl/rates");
			
		
		if (xmlDoc1.parseError.errorCode == 0)
		{
			rates_parsing();
		}
		else
		{
			var myError = xmlDoc1.parseError;
			hwin = window.open("","Assignment","height=640,width=480");
			hwin.document.write("<H1>XML Parsing Error</H1>");
			hwin.document.write("Error# " + myError.errorCode + "<BR>");
			hwin.document.write("Description: " + myError.reason + "<BR>");
			hwin.document.write("In file: " + myError.url + "<BR>");
			hwin.document.write("Line #: " + myError.line + "<BR>");
			hwin.document.write("Character # in line: " + myError.linepos + "<BR>");
			hwin.document.write("Character # in line: " + myError.filepos + "<BR>");
			hwin.document.write("Source line: <xmp>" + myError.srcText + "</xmp>");
		}
	}
	// code for Mozilla, Firefox, Opera, etc.
	else 
		if (document.implementation && document.implementation.createDocument)
		{
			xmlDoc1 = document.implementation.createDocument("","",null);
			xmlDoc1.async = false;
			var loaded;
	
			loaded = xmlDoc1.load("cgi-bin/perl/rates");
	
			
			if (loaded)
			{
				rates_parsing();
			}
			else
				alert('Error in XML file');
		}
		else
		{
			alert('Your browser cannot handle this script');
		} 

}


function rates_parsing()
{
	var m=document.getElementById("machine_list").value;
	var oncampus_with_operator;
	var oncampus_without_operator;
	var acad_with_operator;
	var acad_without_operator;
	var comm_with_operator;
	var x1=xmlDoc1.documentElement;
	var found=false;
	for (i=0;i<x1.childNodes.length;i++)
	{
		
		if (x1.childNodes[i].nodeType == 1 && x1.childNodes[i].nodeName=="machine")
		{
			
			for(j=0;j<x1.childNodes[i].childNodes.length;j++)
			{
				
				if (x1.childNodes[i].childNodes[j].nodeType == 1 && x1.childNodes[i].childNodes[j].nodeName=="name")
				{
					
					if (x1.childNodes[i].childNodes[j].childNodes[0].nodeValue.replace(/^\s*|\s*$/g,"") == document.getElementById("machine_list").value.replace(/^\s*|\s*$/g,""))
					{
						found=true;
						
					}
					
					
				}
				else
					if (found && x1.childNodes[i].childNodes[j].nodeName=="oncampus_with_operator" )
					{
						oncampus_with_operator=x1.childNodes[i].childNodes[j].childNodes[0].nodeValue;//alert("hello");
						//found=false;
					}
					else
					if (found && x1.childNodes[i].childNodes[j].nodeName=="oncampus_without_operator" )
					{
						oncampus_without_operator=x1.childNodes[i].childNodes[j].childNodes[0].nodeValue;//alert("hello");
						//found=false;
					}
					else
					if (found && x1.childNodes[i].childNodes[j].nodeName=="acad_with_operator" )
					{
						acad_with_operator=x1.childNodes[i].childNodes[j].childNodes[0].nodeValue;//alert("hello");
						//found=false;
					}
					else
					if (found && x1.childNodes[i].childNodes[j].nodeName=="acad_without_operator" )
					{
						acad_without_operator=x1.childNodes[i].childNodes[j].childNodes[0].nodeValue;//alert("hello");
						//found=false;
					}
					else
					if (found && x1.childNodes[i].childNodes[j].nodeName=="comm_with_operator" )
					{
						comm_with_operator=x1.childNodes[i].childNodes[j].childNodes[0].nodeValue;//alert("hello");
						found=false;
					}
			}
		}
	}
	show_details(document.getElementById("machine_list").value,oncampus_with_operator,oncampus_without_operator, acad_with_operator,acad_without_operator,comm_with_operator);
	
}




function onload1()
{
	var machine_count = 0;
	new_machine = false;
	
	document.getElementById("add").innerHTML = "<a href=\"javascript:add_machine()\">Add Instrument</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:delete_machine()\">Delete Instrument</a>"
	var sel=document.getElementById("machine_list")
	
	for (j=0;j<sel.length;sel++)
		sel.remove(j);
	
	if (window.ActiveXObject)
	{
		xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.async = false;
		
		xmlDoc.load("cgi-bin/perl/machines");
			
		
		if (xmlDoc.parseError.errorCode == 0)
		{
			x = xmlDoc.documentElement;
			for (i=0;i<x.childNodes.length;i++)
			{
				if (x.childNodes[i].nodeType == 1 && x.childNodes[i].nodeName=="name")
				{
					var sel=document.getElementById("machine_list");
					//alert(all_machines[i]);
					sel.options[machine_count]=new Option(x.childNodes[i].childNodes[0].nodeValue,x.childNodes[i].childNodes[0].nodeValue);
					machine_count++;
				}
			}
		}
		else
		{
			var myError = xmlDoc.parseError;
			hwin = window.open("","Assignment","height=640,width=480");
			hwin.document.write("<H1>XML Parsing Error</H1>");
			hwin.document.write("Error# " + myError.errorCode + "<BR>");
			hwin.document.write("Description: " + myError.reason + "<BR>");
			hwin.document.write("In file: " + myError.url + "<BR>");
			hwin.document.write("Line #: " + myError.line + "<BR>");
			hwin.document.write("Character # in line: " + myError.linepos + "<BR>");
			hwin.document.write("Character # in line: " + myError.filepos + "<BR>");
			hwin.document.write("Source line: <xmp>" + myError.srcText + "</xmp>");
		}
	}
	// code for Mozilla, Firefox, Opera, etc.
	else 
		if (document.implementation && document.implementation.createDocument)
		{
			xmlDoc = document.implementation.createDocument("","",null);
			xmlDoc.async = false;
			var loaded;
	
			loaded = xmlDoc.load("cgi-bin/perl/machines");
	
			
			if (loaded)
			{
				x = xmlDoc.documentElement;
				for (i=0;i<x.childNodes.length;i++)
				{
					if (x.childNodes[i].nodeType == 1 && x.childNodes[i].nodeName=="name")
					{
						var sel=document.getElementById("machine_list");
					//alert(x.childNodes[i].childNodes[0].nodeValue);
					
					sel.options[machine_count]=new Option(x.childNodes[i].childNodes[0].nodeValue,x.childNodes[i].childNodes[0].nodeValue);
					machine_count++;
					}
				}
			}
			else
				alert('Error in XML file');
		}
		else
		{
			alert('Your browser cannot handle this script');
		}
		machine_change();
}