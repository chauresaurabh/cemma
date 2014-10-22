var xmlDoc1;
var nam;
var hwin;
var client_name;


function display_invoice (item1)
{

	var num1 = item1.parentNode.parentNode.cells[1].innerHTML;
	document.getElementById("number").value = num1;
	document.getElementById("form1").submit();
}

function getDates(n)
{
	var d;
	d = parseDate(n);
	if (d)
		return formatDate(d,'M/d/y');
	else 
		return n;
}	





function showFields()
{
	document.getElementById("edit_amount").innerHTML = "Enter amount: <input type=\"text\" name=\"dat\" id=\"amount\" size=\"15\" onkeypress=\"return amount_change(event)\" onchange=\"this.value=extractAmount(this.value)\">     Add:<input type=\"radio\" name=\"add\" id=\"add\" value=\"add\" checked=\"checked\"> Deduct: <input type=\"radio\" name=\"add\" id=\"deduct\" value=\"deduct\"><input type=\"button\" value=\"Submit\" name=\"Submit\" onclick=\"javascript:edit_balance()\">"
}




function parseNames()
{
	root = xmlDoc1.documentElement;
	var i;
	var j;
	var k;
	var cnt=0;
	for (i=0;i<root.childNodes.length;i++)
	{
		if(root.childNodes[i].nodeType==1)
		{
			for (j=0;j<root.childNodes[i].childNodes.length;j++)
			{
				if (root.childNodes[i].childNodes[j].nodeType==1)
				{
					var sel=document.getElementById("field");
					//alert(all_machines[i]);
					sel.options[cnt++]=new Option(root.childNodes[i].childNodes[j].childNodes[0].nodeValue,root.childNodes[i].childNodes[j].childNodes[0].nodeValue);
				}
			}
		}
	
	}

}


function onload1()
{
	
					if (window.ActiveXObject)
					{
						xmlDoc1 = new ActiveXObject("Microsoft.XMLDOM");
						xmlDoc1.async = false;
						xmlDoc1.load("cgi-bin/perl/names.pl");
						
						if (xmlDoc1.parseError.errorCode == 0)
						{
							parseNames();
							
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
							
							loaded = xmlDoc1.load("cgi-bin/perl/names.pl");
							
				
							if (loaded)
							{
								parseNames();
								
							}
							else
								alert('Error in XML file');
						}
						else
						{
							alert('Your browser cannot handle this script');
						}
					
				

}


function amount_change(e)
{
	var k;
	document.all ? k = e.keyCode : k = e.which;
	return (!isNaN(String.fromCharCode(k)) || String.fromCharCode(k)=="." || k==8 || k==46 || k==0);
}

function extractAmount(str)
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




function submitted(nam)
{
	//document.getElementById("form1").submit();
	var root;
	var found = false;
	var req = false;// = GXmlHttp.create();
//alert("hello0");
	client_name = nam;
	//alert(nam);
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
			//alert("hello1");
			
			document.getElementById("nam").innerHTML = "<h3>Name:   " + nam +"</h3>";
			//document.getElementById("edit_amount").innerHTML = "<a href=\"javascript: showFields()\">Edit Balance</a>";
			var valuestosend = "name=" + encodeURI(document.getElementById("field").value);
			var url="cgi-bin/perl/search.pl";
			//url = url + "?" + valuestosend;
			req.open("POST", url, true);
			req.setRequestHeader("Connection", "Close");
			req.setRequestHeader("Content-type","application/x-www-formurlencoded");
			//req.setRequestHeader("Method", "POST" + url + "HTTP/1.1");
			var amount_due = 0;

			var innerhtml;
		
			req.onreadystatechange = function() 
			{
  				if (req.readyState == 4 && req.status == 200) 
				{
					var xmlDoc = req.responseXML;
					//alert("hello2");
					var root = xmlDoc.documentElement;
					var num = 1;
					//alert(req.responseText);
					
					innerhtml = "<H3>Invoice details</H3><table cellpadding=\"5\" cellspacing=\"0\" border=\"2\" width=\"100%\"><tr><td><b>Sr. No.</b></td><td><b>Invoice Number</b></td><td><b>PO/Req #</b></td><td><b>Date</b></td><td><b>Amount Due</b></td><td><b>Amount Paid</b></td><td><b>Status</b></td><td><b>Pay</b></td><td><b>View</b></td></tr>";
					var amount_paid = 0;
					for (i=0;i<root.childNodes.length ;i++ )
					{
						
						if (root.childNodes[i].nodeType == 1)
						{
							if (root.childNodes[i].nodeName=="entry")
							{
							innerhtml += "<tr><td>"+num+"</td>";
							num++;
							for (j=0;j<root.childNodes[i].childNodes.length ;j++ )
							{
							
								if (root.childNodes[i].childNodes[j].nodeType == 1)
								{
									//alert(root.childNodes[i].childNodes[j].nodeName);
									if (root.childNodes[i].childNodes[j].nodeName == "number" || root.childNodes[i].childNodes[j].nodeName == "poreq" || root.childNodes[i].childNodes[j].nodeName == "date" || root.childNodes[i].childNodes[j].nodeName == "total" || root.childNodes[i].childNodes[j].nodeName == "amountpaid")
									{
										
										if (root.childNodes[i].childNodes[j].nodeName == "amountpaid")
										{
											found=true;
											innerhtml += "<td>" + root.childNodes[i].childNodes[j].childNodes[0].nodeValue  +"</td>";
											amount_paid = root.childNodes[i].childNodes[j].childNodes[0].nodeValue;
										}else
										if (root.childNodes[i].childNodes[j].nodeName == "date")
										{
											innerhtml += "<td>" + getDates(root.childNodes[i].childNodes[j].childNodes[0].nodeValue) + "</td>";
										}
										else
										
										if (root.childNodes[i].childNodes[j].nodeName == "poreq")
										{
											try
											{
											if(root.childNodes[i].childNodes[j].childNodes[0].nodeValue.lastIndexOf('HASH',0)==-1)
											
											innerhtml += "<td>" + getDates(root.childNodes[i].childNodes[j].childNodes[0].nodeValue) + "</td>";
											else
											innerhtml += "<td>-</td>";
											}
											catch(ex){innerhtml += "<td>-</td>";}
										}
										else
										{
											if (root.childNodes[i].childNodes[j].nodeName == "total")
											{
												amount_due = parseFloat(root.childNodes[i].childNodes[j].childNodes[0].nodeValue);
											}
											innerhtml += "<td>" + root.childNodes[i].childNodes[j].childNodes[0].nodeValue + "</td>";
											
											
										}
										
										
									}
								}
							}
							
							var col="green";
							var paid="Not Paid";
							if ((amount_due -  amount_paid).toFixed(2) > 0)
							{
								col="maroon";
								paid="Not Paid";
								innerhtml +="<td><font color=\"" + col + "\">" + paid + "</font></td><td><a href=\"#\" onclick=\"return change_amount_paid('" + nam + "',this);\">pay</a></td>";
								
							}
							else
							{ 
								col="green";
								paid="Paid";
								innerhtml +="<td><font color=\"" + col + "\">" + paid + "</font></td><td>&nbsp;</td>";
							}
							innerhtml +="<td><a href=\"#\" onclick=\"return display_invoice(this);\">view</a></td>";
							innerhtml += "</tr>";
						}
					
					else
					{
						//alert(root.childNodes[i].nodeName);
						
						for (m=0;m<root.childNodes[i].childNodes.length;m++)
						{
							//alert("hello2");
							if (root.childNodes[i].childNodes[m].nodeType == 1)
							{
								//alert("hello3");
								
								
								amount_paid = parseFloat(root.childNodes[i].childNodes[m].childNodes[0].nodeValue);
							}
						}
					}
					
					}
					}	innerhtml+="</table>";
					
					
					
					if (found)
					document.getElementById("tab").innerHTML = innerhtml;
					else
					document.getElementById("tab").innerHTML = "<b>No Invoices</b>";
				}
				
			}
			req.send(valuestosend);

		}
		else
		{
			alert("error");
		}

}		
	function change_amount_paid(nam,row)
{
	//document.getElementById("form1").submit();
	var root;
	var row_num = row.parentNode.parentNode.rowIndex;
	var found = false;
	var req = false;// = GXmlHttp.create();
	//alert(row_num);
	//alert(nam);
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
			//alert("hello1");
			//nam = document.getElementById("field").value;
			//document.getElementById("nam").innerHTML = "<h3>Name:   " + nam +"</h3>";
			//document.getElementById("edit_amount").innerHTML = "<a href=\"javascript: showFields()\">Edit Balance</a>";
			var valuestosend = "name=" + encodeURI(document.getElementById("field").value);
			var url="cgi-bin/perl/search.pl";
			//url = url + "?" + valuestosend;
			req.open("POST", url, true);
			req.setRequestHeader("Connection", "Close");
			req.setRequestHeader("Content-type","application/x-www-formurlencoded");
			//req.setRequestHeader("Method", "POST" + url + "HTTP/1.1");
			var amount_due = 0;

			var innerhtml;
		
			req.onreadystatechange = function() 
			{
  				if (req.readyState == 4 && req.status == 200) 
				{
					hwin = window.open("","Assignment","height=300,width=380");
					var number1 = 0;
					var xmlDoc = req.responseXML;
					//alert(req.responseText);
					//alert("hello2");
					var poreq;
					var root = xmlDoc.documentElement;
					hwin.document.write("<table cellpadding=\"0\" cellspacing=\"15\" border=\"0\">");
					
					var inv_num;
					for (i=0;i<root.childNodes.length ;i++ )
					{
						
						if (root.childNodes[i].nodeType == 1)
						{
							if (root.childNodes[i].nodeName=="entry")
							{
								number1++;
								//alert(number1);
								if (number1==row_num)
								{
									for (j=0;j<root.childNodes[i].childNodes.length ;j++ )
									{
								
										if (root.childNodes[i].childNodes[j].nodeType == 1)
										{
											//alert(root.childNodes[i].childNodes[j].nodeName);
											//alert(root.childNodes[i].childNodes[j].childNodes[0].nodeValue);
											if (root.childNodes[i].childNodes[j].nodeName == "number" || root.childNodes[i].childNodes[j].nodeName == "poreq" || root.childNodes[i].childNodes[j].nodeName == "name" || root.childNodes[i].childNodes[j].nodeName == "date" || root.childNodes[i].childNodes[j].nodeName == "total")
											{
												hwin.document.write("<tr>");
												hwin.document.write("<td>");
												if (root.childNodes[i].childNodes[j].nodeName == "number")
												{
													hwin.document.write("<b>Invoice Number:</b></td><td>" + root.childNodes[i].childNodes[j].childNodes[0].nodeValue );
													inv_num =  root.childNodes[i].childNodes[j].childNodes[0].nodeValue;
												}
												else
												if (root.childNodes[i].childNodes[j].nodeName == "name")
												{
													hwin.document.write("<b>Name:</b></td><td>" + root.childNodes[i].childNodes[j].childNodes[0].nodeValue );
												}
												else
												if (root.childNodes[i].childNodes[j].nodeName == "date")
												{
													hwin.document.write("<b>Date:</b></td><td>" + getDates(root.childNodes[i].childNodes[j].childNodes[0].nodeValue) );
												}
												else
												if (root.childNodes[i].childNodes[j].nodeName == "poreq")
												{
													if (root.childNodes[i].childNodes[j].childNodes[0].nodeValue.lastIndexOf('HASH',0)==-1)
													hwin.document.write("</tr><tr><td><b>PO/REQ:</b></td><td><input type=\"text\" value=\"" +  root.childNodes[i].childNodes[j].childNodes[0].nodeValue + "\" id=\"prq\"></td></tr>" );
													else
													(root.childNodes[i].childNodes[j].childNodes[0].nodeValue.lastIndexOf('HASH',0)==-1)
													hwin.document.write("</tr><tr><td><b>PO/REQ:</b></td><td><input type=\"text\" value=\"\" id=\"prq\"></td></tr>" );
												}
												else
												if (root.childNodes[i].childNodes[j].nodeName == "total")
												{
													hwin.document.write("<b>Amount Due:</b></td><td>" + root.childNodes[i].childNodes[j].childNodes[0].nodeValue );
													
													
													hwin.document.write("</tr><tr><td><b>Amount Paid:</b></td><td><input type=\"text\" value=\"" + root.childNodes[i].childNodes[j].childNodes[0].nodeValue + "\" id=\"amount\"></td></tr><tr><td colspan=\"2\" align=\"center\"><input type=\"button\" value=\"Submit\" onclick=\"return opener.submit_amount('" + inv_num + "','" + client_name + "');\"" );
												}
												
												
												hwin.document.write("</td>");
												hwin.document.write("</tr>");
											}
										}
									}
								}
							}
					
						}
					}
					
					hwin.document.write("</table>");
					
					
					
					
					
					
					
					
				}	
			}
			req.send(valuestosend);

		}
		else
		{
			alert("error");
		}
	}
	
function submit_amount (inv_num,nam)
{
	var root;
	var found = false;
	var req = false;// = GXmlHttp.create();
	//alert(hwin.document.getElementById("prq").value);
	//alert(amount);
//alert("hello0");
	//alert(hwin.document.getElementById("amount").value);
	if (hwin.document.getElementById("amount").length== 0 || parseFloat(hwin.document.getElementById("amount").value) < 0)
	{
		alert("Please enter and amount");
		hwin.focus();
		return;
	}
	else
	{
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
			//alert("hello1");
			//alert(hwin.document.getElementById("prq").value);
			var valuestosend = "number=" + encodeURI(inv_num) + "&amount=" + encodeURI(hwin.document.getElementById("amount").value) + "&poreq=" + encodeURI(hwin.document.getElementById("prq").value);
			var url="cgi-bin/perl/edit_balance.pl";
			//url = url + "?" + valuestosend;
			req.open("POST", url, true);
			req.setRequestHeader("Connection", "Close");
			req.setRequestHeader("Content-type","application/x-www-formurlencoded");
			//req.setRequestHeader("Method", "POST" + url + "HTTP/1.1");
			
		
			req.onreadystatechange = function() 
			{
  				if (req.readyState == 4 && req.status == 200) 
				{
					//alert(nam);
					submitted(nam);
					hwin.close();
					//alert(req.responseText);
					alert("Amount updated");
					//submitted();
				}
		else
		{
			//alert("error");
		}
}
req.send(valuestosend);
}
}
}	
	