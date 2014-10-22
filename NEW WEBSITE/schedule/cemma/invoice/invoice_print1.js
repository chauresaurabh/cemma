















function getDates(n)
{
	var d;
	d = parseDate(n);
	if (d)
		return formatDate(d,'M/d/y');
	else 
		return n;
}	

/*function print_page()
{
	document.getElementById("print").innerHTML = "";
	document.getElementById("printable_table").width="400";
	window.print();
	//document.getElementById("print").innerHTML = "<FORM><table cellspacing=\"0\" cellpadding=\"10\" border=\"0\"><tr><td><INPUT type=\"button\" value=\"Back\" onClick=\"history.back()\"/></td><td><INPUT type=\"button\" value=\"Print\" onClick=\"javascript:print_page()\"/></td></tr></table></FORM></div>";
}	
*/
function print_page()
{
	//document.getElementById("print").innerHTML = "";
	//document.getElementById("printable_table").width="400";
	hwin = window.open("","Assignment","height=800,width=800");
	hwin.document.write("<body><div id=\"printy\"></div></body>");
	hwin.document.getElementById("printy").innerHTML=document.getElementById("main_div").innerHTML;
	hwin.document.getElementById("print").innerHTML = ""
	hwin.print();
	//document.getElementById("print").innerHTML = "<FORM><table cellspacing=\"0\" cellpadding=\"10\" border=\"0\"><tr><td><INPUT type=\"button\" value=\"Back\" onClick=\"history.back()\"/></td><td><INPUT type=\"button\" value=\"Print\" onClick=\"javascript:print_page()\"/></td></tr></table></FORM></div>";
}	
function get_values()
{
			var root;
		var found = false;
		var req = false;// = GXmlHttp.create();
//alert("hello0");
		
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
				var valuestosend = "number=" + encodeURI(inv_num);
				
				
				var url="cgi-bin/perl/get_invoice.pl";
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
						var xmlDoc = req.responseXML;
						//alert("hello2");
						var root = xmlDoc.documentElement;
						//alert(xmlDoc.documentElement.nodeName);
						for(i=0;i<root.childNodes.length;i++)
						{
							if(root.childNodes[i].nodeType==1)
							{
								
								if(root.childNodes[i].nodeName=="header")
								{
									for(j=0;j<root.childNodes[i].childNodes.length;j++)
									{//alert(root.childNodes[i].nodeName);
										if(root.childNodes[i].childNodes[j].nodeType==1)
										{
											
											if(root.childNodes[i].childNodes[j].nodeName=="number")
											{
												document.getElementById("inv_num").innerHTML = "<b>MO " + root.childNodes[i].childNodes[j].childNodes[0].nodeValue + "</b>";
											}
											else
											if(root.childNodes[i].childNodes[j].nodeName=="name")
											{
												document.getElementById("name").innerHTML =  root.childNodes[i].childNodes[j].childNodes[0].nodeValue ;
											}
											else
											if(root.childNodes[i].childNodes[j].nodeName=="address")
											{
												document.getElementById("address").innerHTML =  root.childNodes[i].childNodes[j].childNodes[0].nodeValue ;
											}
											else
											if(root.childNodes[i].childNodes[j].nodeName=="city")
											{
												document.getElementById("city").innerHTML =  root.childNodes[i].childNodes[j].childNodes[0].nodeValue ;
											}
											if(root.childNodes[i].childNodes[j].nodeName=="state")
											{
												document.getElementById("state").innerHTML =  root.childNodes[i].childNodes[j].childNodes[0].nodeValue ;
											}
											else
											if(root.childNodes[i].childNodes[j].nodeName=="zip")
											{
												document.getElementById("zip").innerHTML =  root.childNodes[i].childNodes[j].childNodes[0].nodeValue ;
											}
											else
											if(root.childNodes[i].childNodes[j].nodeName=="phone")
											{
												document.getElementById("phone").innerHTML =  root.childNodes[i].childNodes[j].childNodes[0].nodeValue ;
											}
											else
											if(root.childNodes[i].childNodes[j].nodeName=="fax")
											{
												try
												{
													if(root.childNodes[i].childNodes[j].childNodes[0].nodeValue.lastIndex("HASH",0)==-1)
													document.getElementById("fax").innerHTML =  root.childNodes[i].childNodes[j].childNodes[0].nodeValue ;
													else
													document.getElementById("fax").innerHTML = "-";
												}
												catch(ex) {document.getElementById("fax").innerHTML = "-";}
											}
											else
											if(root.childNodes[i].childNodes[j].nodeName=="poreq")
											{
												try
												{
													if(root.childNodes[i].childNodes[j].childNodes[0].nodeValue.lastIndex("HASH",0)==-1)
													document.getElementById("req").innerHTML =  root.childNodes[i].childNodes[j].childNodes[0].nodeValue ;
													else
													document.getElementById("req").innerHTML = "-";
												}
												catch(ex) {document.getElementById("req").innerHTML = "-";}
											}
											else
											if(root.childNodes[i].childNodes[j].nodeName=="date")
											{
												document.getElementById("date").innerHTML = getDates(root.childNodes[i].childNodes[j].childNodes[0].nodeValue) ;
											}
											/*else
											if(root.childNodes[i].childNodes[j].nodeName=="type")
											{//alert("hello");
												var ocamp="On-Campus";
												if(root.childNodes[i].childNodes[j].childNodes[0].nodeValue==1)
												ocamp = "On-Campus";
												else if(root.childNodes[i].childNodes[j].childNodes[0].nodeValue==2)
												ocamp = "Off-Campus <br>(Academic)";
												else
												(root.childNodes[i].childNodes[j].childNodes[0].nodeValue==3)
												ocamp = "Off-Campus (Commercial)";
												document.getElementById("oc1").innerHTML = ocamp ;
											}*/
//alert(root.childNodes[i].childNodes[j].nodeName);
											
										}
									}
								}else
								if(root.childNodes[i].nodeName=="data")
								{
									var row_count=1;
									for(j=0;j<root.childNodes[i].childNodes.length;j++)
									{//alert(root.childNodes[i].nodeName);
										if(root.childNodes[i].childNodes[j].nodeType==1)
										{
											if (root.childNodes[i].childNodes[j].nodeName=="entry")
											{
												var x=document.getElementById('inv_table').insertRow(row_count++);
												var machine = "";
												
												var a=x.insertCell(0);
												var b=x.insertCell(1);
												var c=x.insertCell(2);
												var d=x.insertCell(3);
												var e=x.insertCell(4);
												var f=x.insertCell(5);
												var g=x.insertCell(6);
												for(k=0;k<root.childNodes[i].childNodes[j].childNodes.length;k++)
												{
													if(root.childNodes[i].childNodes[j].childNodes[k].nodeType==1)
													{
														
														
														
														if(root.childNodes[i].childNodes[j].childNodes[k].nodeName=="quantity")
														{
															a.innerHTML = root.childNodes[i].childNodes[j].childNodes[k].childNodes[0].nodeValue;
														}
														else
														if(root.childNodes[i].childNodes[j].childNodes[k].nodeName=="date")
														{
															b.innerHTML = getDates(root.childNodes[i].childNodes[j].childNodes[k].childNodes[0].nodeValue);
														}
														else
														if(root.childNodes[i].childNodes[j].childNodes[k].nodeName=="machine")
														{
															machine  += root.childNodes[i].childNodes[j].childNodes[k].childNodes[0].nodeValue;
														}
														else
														if(root.childNodes[i].childNodes[j].childNodes[k].nodeName=="operator")
														{
															try
												{
													if(root.childNodes[i].childNodes[j].childNodes[0].nodeValue.lastIndex("HASH",0)==-1)
													machine += " , " + root.childNodes[i].childNodes[j].childNodes[k].childNodes[0].nodeValue + " Operator";
													
												}
												catch(ex) {}
															
															c.innerHTML = machine;
														}else
														if(root.childNodes[i].childNodes[j].childNodes[k].nodeName=="withoperator")
														{
															if (root.childNodes[i].childNodes[j].childNodes[k].childNodes[0].nodeValue==true)
															d.innerHTML = "Yes";
															else d.innerHTML = "No";
														}else
														if(root.childNodes[i].childNodes[j].childNodes[k].nodeName=="price")
														{
															e.innerHTML = root.childNodes[i].childNodes[j].childNodes[k].childNodes[0].nodeValue;
														}else
														if(root.childNodes[i].childNodes[j].childNodes[k].nodeName=="total")
														{
															f.innerHTML = root.childNodes[i].childNodes[j].childNodes[k].childNodes[0].nodeValue;
														}
													}
												}
											}
											
										}

									}
								}else
								if (root.childNodes[i].nodeName=="grandtotal")
								{
									document.getElementById('grand_total').innerHTML = "<font size=\"5\"><b>TOTAL: $ " + parseFloat(root.childNodes[i].childNodes[0].nodeValue).toFixed(2) + "</b></font>"
								}
							}
						}
						//alert("Changes Made");
						
					}
			else
			{
				//alert("error");
			}
}
req.send(valuestosend);
}


}