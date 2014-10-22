			var row_count=1;
			var x;
			
			

var inv_num = "8/16"			
			
			
			
			
			
			var all_machines = new Array();
			var xmlDoc;
			var xmlDoc1;
			var machine_count=0;
			var oc_selected=1;
			var clicked;

			

			function parseNames()
			{
				root = xmlDoc1.documentElement;
				var i;
				var j;
				var k;
				var cnt=0;
				var sel=document.getElementById("nam");
				sel.options[cnt++]=new Option("Please select a name","Please select a name");
				for (i=0;i<root.childNodes.length;i++)
				{
					if(root.childNodes[i].nodeType==1)
					{
						for (j=0;j<root.childNodes[i].childNodes.length;j++)
						{
							if (root.childNodes[i].childNodes[j].nodeType==1)
							{
								
								//alert(all_machines[i]);
								sel.options[cnt++]=new Option(root.childNodes[i].childNodes[j].childNodes[0].nodeValue,root.childNodes[i].childNodes[j].childNodes[0].nodeValue);
							}
						}
					}
				
				}

			}


			function submitted(nam)
			{
				//document.getElementById("form1").submit();
					var root;
					var req;
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
			
			var valuestosend = "name=" + encodeURI(document.getElementById("nam").value);
			var url="cgi-bin/perl/get_details.pl";
			
			req.open("POST", url, true);
			req.setRequestHeader("Connection", "Close");
			req.setRequestHeader("Content-type","application/x-www-formurlencoded");
			


			req.onreadystatechange = function() 
			{
  				if (req.readyState == 4 && req.status == 200) 
				{
					
					var number1 = 0;
					var xmlDoc = req.responseXML;
					//alert(req.responseText);
					var poreq;
					var root = xmlDoc.documentElement;
					
					
					var inv_num;
					for (i=0;i<root.childNodes.length ;i++ )
					{
						
						if (root.childNodes[i].nodeType == 1)
						{
							if (root.childNodes[i].nodeName=="address")
							{
								
								document.getElementById("addr").value = root.childNodes[i].childNodes[0].nodeValue;
							}
							else
							if (root.childNodes[i].nodeName=="city")
							{
								
								document.getElementById("cit").value = root.childNodes[i].childNodes[0].nodeValue;
							}
							else
							if (root.childNodes[i].nodeName=="state")
							{
								//alert("hello");
								document.getElementById("stat").value = root.childNodes[i].childNodes[0].nodeValue;
							}
							else
							if (root.childNodes[i].nodeName=="phone")
							{
								
								document.getElementById("phon").value = root.childNodes[i].childNodes[0].nodeValue;
							}
							else
							if (root.childNodes[i].nodeName=="fax")
							{
								try {
								if(root.childNodes[i].childNodes[0].nodeValue.lastIndexOf("HASH")==-1)
									document.getElementById("fx").value = root.childNodes[i].childNodes[0].nodeValue;
								else
									document.getElementById("fx").value = "";
								}
								catch(ex) {document.getElementById("fx").value = "";}
							}
							else
							if (root.childNodes[i].nodeName=="zip")
							{
								
								document.getElementById("zp").value = root.childNodes[i].childNodes[0].nodeValue;
							}
					
						}
					}
						
					
					
					
					
					
					
					
				}	
			}
			req.send(valuestosend);

		}
		else
		{
			alert("error");
		}
	}


			function show_names()
			{
				if(clicked==true)
				{
					document.getElementById("name").innerHTML="<input type=\"text\" name=\"nam\" id=\"nam\" size=\"83\"><br><a href=\"javascript:show_names()\">Show Names</a>";
					clicked=false;
					
					document.getElementById("addr").value = "";
					document.getElementById("cit").value = "";
					document.getElementById("stat").value = "";
					document.getElementById("phon").value = "";
					document.getElementById("fx").value = "";
					document.getElementById("zp").value = "";
							
				}
				else
				{
					
					clicked=true;
					document.getElementById("name").innerHTML="<select name=\"nam\" id=\"nam\" onchange=\"javscript: submitted(this.value)\"></select><br><a href=\"javascript:show_names()\">Hide Names</a>";
					
				
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

			}

			function getDates(n)
			{
				
				var d;
				d = parseDate(n,true);
				return formatDate(d,'y/M/d');

			}
			
			function commit()
			{
				document.getElementById("form1").submit();
			}

			function submited()
			{
				var client_name = document.getElementById("nam").value;
				if (client_name == "")
				{
					alert("Please enter the name of the client");
					return;
				}
				var client_address = document.getElementById("addr").value;
				if (client_address == "")
				{
					alert("Please enter the client's address");
					return;
				}
				var client_city = document.getElementById("cit").value;
				if (client_city == "")
				{
					alert("Please enter the client's city");
					return;
				}
				var client_state = document.getElementById("stat").value;
				if (client_state == "")
				{
					alert("Please enter the client's state");
					return;
				}
				var client_zip = document.getElementById("zp").value;
				if (client_zip == "")
				{
					alert("Please enter the client's zip code");
					return;
				}
				var client_phone = document.getElementById("phon").value;
				if (client_phone == "")
				{
					alert("Please enter the client's phone");
					return;
				}
				
				var invoice_date = document.getElementById("dat").value;
				var client_fax = document.getElementById("fx").value;
				var po_req = document.getElementById("rq").value;
				if (invoice_date == "")
				{
					alert("Please enter the invoice date");
					return;
				}
				

				document.getElementById("name").innerHTML = client_name;
				document.getElementById("address").innerHTML = client_address;
				document.getElementById("city").innerHTML = client_city;
				document.getElementById("state").innerHTML = client_state;
				document.getElementById("zip").innerHTML = client_zip;
				document.getElementById("phone").innerHTML = client_phone;
				document.getElementById("fax").innerHTML = client_fax;
				document.getElementById("date").innerHTML = invoice_date;
				document.getElementById("req").innerHTML = po_req;
				document.getElementById("camp").disabled=true;

				var client_type = document.getElementById("camp").value;
				var invoice_xml = "";

				invoice_xml += "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?><invoice><header>";
				invoice_xml +="<number>" + inv_num + "</number>";
				invoice_xml +="<name>" + client_name + "</name>";
				invoice_xml +="<address>" + client_address + "</address>";
				invoice_xml +="<city>" + client_city + "</city>";
				invoice_xml +="<state>" + client_state + "</state>";
				invoice_xml +="<zip>" + client_zip + "</zip>";
				invoice_xml +="<phone>" + client_phone + "</phone>";
				invoice_xml +="<fax>" + client_fax + "</fax>";
				invoice_xml +="<invoicedate>" + getDates(invoice_date) + "</invoicedate>";
				invoice_xml +="<poreq>" + po_req + "</poreq>";
				invoice_xml +="<clienttype>" + client_type + "</clienttype></header><data>";

				
				document.getElementById("add").innerHTML = " ";


				
				var tabl = document.getElementById('inv_table');
				var i;

				for (i=1;i<tabl.rows.length;i++)
				{
					invoice_xml +="<entry><quantity>" + tabl.rows[i].cells[0].firstChild.value + "</quantity>";
					tabl.rows[i].cells[0].innerHTML = tabl.rows[i].cells[0].firstChild.value;
					var dat2 = tabl.rows[i].cells[1].firstChild.value;
					invoice_xml +="<date>" + getDates(tabl.rows[i].cells[1].firstChild.value) + "</date>";
					//alert(tabl.rows[i].cells[1].firstChild.value);
					//alert(invoice_xml);
					tabl.rows[i].cells[1].innerHTML = dat2;
					
					invoice_xml +="<machine>" + tabl.rows[i].cells[2].firstChild.value + "</machine>";
					var temp = tabl.rows[i].cells[2].firstChild.value;
					invoice_xml +="<operator>" + tabl.rows[i].cells[2].firstChild.nextSibling.nextSibling.value + "</operator>";
					tabl.rows[i].cells[2].innerHTML = temp + " , " +  tabl.rows[i].cells[2].firstChild.nextSibling.nextSibling.value + " Operator";
					invoice_xml +="<withoperator>" + tabl.rows[i].cells[3].firstChild.checked + "</withoperator>";
					tabl.rows[i].cells[3].firstChild.disabled = true;
					invoice_xml +="<price>" + tabl.rows[i].cells[4].innerHTML + "</price>";
					invoice_xml +="<total>" + tabl.rows[i].cells[5].innerHTML + "</total></entry>";
					tabl.rows[i].cells[6].firstChild.innerHTML = " ";
				}
				invoice_xml+="<entry></entry>";
				var tabl = document.getElementById('inv_table');
				var total=0.0;
				for (i=1;i<tabl.rows.length;i++)
				{
					
					total = total + parseFloat(tabl.rows[i].cells[5].innerHTML);
					
				}


				invoice_xml +="</data><grandtotal>" + total + "</grandtotal></invoice>";
				//invoice_xml = "<xmp>" + invoice_xml + "</xmp>"
				//var hwin = window.open("new","new");
				//hwin.document.write(invoice_xml);
		
				document.getElementById("submit").innerHTML = "<form id=\"form1\" action=\"cgi-bin/perl/invoice.pl\" method=\"post\"><input id=\"invoice_xml_field\" type=\"hidden\" name=\"invoice\"><input id=\"page\" type=\"hidden\" name=\"page\"><a href=\"#\" onclick=\"return commit();\">Commit</a></form>";
				document.getElementById("invoice_xml_field").value = invoice_xml;
				document.getElementById("page").value = document.getElementById("main_div").innerHTML;
	


			}

			function operator_change(m)
			{
				var n = m.parentNode.parentNode;
				desc_change(n.cells[2].firstChild);
			}
			
			function grand_total()
			{
				var tabl = document.getElementById('inv_table');
				var total=0.0;
				for (i=1;i<tabl.rows.length;i++)
				{
					
					total = total + parseFloat(tabl.rows[i].cells[5].innerHTML);
					
				}
				document.getElementById('grand_total').innerHTML = "<font size=\"5\"><b>TOTAL: $ " + total.toFixed(2) + "</b></font>"
			}
			
			function oc_change(m)
			{
				oc_selected=m.value;
				
				var tabl = document.getElementById('inv_table');
				var i;
				if (oc_selected==3)
				{
					for (i=1;i<tabl.rows.length;i++)
					{
						tabl.rows[i].cells[3].firstChild.checked=true;
						desc_change(tabl.rows[i].cells[2].firstChild);
						tabl.rows[i].cells[3].firstChild.disabled=true;
						
					}
					
				}
				else
				{
					for (i=1;i<tabl.rows.length;i++)
					{
						tabl.rows[i].cells[3].firstChild.checked=false;
						desc_change(tabl.rows[i].cells[2].firstChild);
						tabl.rows[i].cells[3].firstChild.disabled=false;
					}
				
				}
				
				
				
			}
			
			function desc_parsing(m)
			{
				
				var x1 = xmlDoc1.documentElement;
				var found=false;
				var n = m.parentNode.parentNode;
					
				var search = "oncampus";
				var optr = "with-operator";
				
				if (!n.cells[3].firstChild.checked)
				optr="without-operator";
				
				if (oc_selected == 1)
				{
					if (!n.cells[3].firstChild.checked)
						search = "oncampus_without_operator";
					else
						search = "oncampus_with_operator";
				}
				else
					if (oc_selected == 2)
					{
						if (!n.cells[3].firstChild.checked)
							search = "acad_without_operator";
						else
							search = "acad_with_operator";
					}			
					else
						if(oc_selected == 3)
							search="comm_with_operator";
				
					//alert(search);
				var rate = 0;
				for (i=0;i<x1.childNodes.length;i++)
				{
					
					if (x1.childNodes[i].nodeType == 1 && x1.childNodes[i].nodeName=="machine")
					{
						
						for(j=0;j<x1.childNodes[i].childNodes.length;j++)
						{
							
							if (x1.childNodes[i].childNodes[j].nodeType == 1 && x1.childNodes[i].childNodes[j].nodeName=="name")
							{
								
								if (x1.childNodes[i].childNodes[j].childNodes[0].nodeValue.replace(/^\s*|\s*$/g,"") == m.value.replace(/^\s*|\s*$/g,""))
								{
									found=true;
									
								}
								
								
							}
							else
								if (found && x1.childNodes[i].childNodes[j].nodeName==search )
								{
									rate=x1.childNodes[i].childNodes[j].childNodes[0].nodeValue;//alert("hello");
									found=false;
								}
						}
					}
				}
							
				var o = n.cells[4];
				o.innerHTML = rate.toString().replace(/^\s*|\s*$/g,"");
				var totl = parseFloat(n.cells[4].innerHTML * parseFloat(n.cells[0].firstChild.value));
				n.cells[5].innerHTML = totl.toFixed(2) ;
				grand_total();
			}
			
			function desc_change(m)
			{
				//alert("hello");
				if (m.value==0)
				{
					var n = m.parentNode.parentNode;
					var o = n.cells[5];
					o.innerHTML = "0";
					n.cells[4].innerHTML = "0";
				}
				else
				{
					if (window.ActiveXObject)
					{
						xmlDoc1 = new ActiveXObject("Microsoft.XMLDOM");
						xmlDoc1.async = false;
						xmlDoc1.load("cgi-bin/perl/rates");
						
						if (xmlDoc1.parseError.errorCode == 0)
						{
							desc_parsing(m);
							
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
								desc_parsing(m);
								
							}
							else
								alert('Error in XML file');
						}
						else
						{
							alert('Your browser cannot handle this script');
						}
					
				}
			}
			
			function calc_total(m)
			{
				if (true)
				{
					var n = m.parentNode.parentNode;
					var o = n.cells[5];
					var totl = parseFloat(m.value * parseFloat(n.cells[4].innerHTML));
					o.innerHTML = totl.toFixed(2);
					grand_total();
				}
			}
			
			function qty_change(e)
			{
				var k;
				document.all ? k = e.keyCode : k = e.which;
				return (!isNaN(String.fromCharCode(k)) || String.fromCharCode(k)=="." || k==8 || k==46 || k==0);
			}

			function extractNumeric(str)
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
			
			function date_change(e)
			{
				var k;
				document.all ? k = e.keyCode : k = e.which;
				return (!isNaN(String.fromCharCode(k)) || String.fromCharCode(k)=="/"  || k==8 || k==46 || k==0);
			}

			function extractDate(str)
			{
				var output = "";
				var ch;
				for (i=0;i<str.length;i++)
				{
					ch=str.charAt(i);
					if(ch=="0" || ch=="1" || ch=="2" || ch=="3" || ch=="4" || ch=="5" || ch=="6" || ch=="7" || ch=="8" || ch=="9" || ch=="/") 
					{
						output = output + ch;
					}
				}
				return output;
			}
			
			function inv_date_change(e)
			{
				var k;
				document.all ? k = e.keyCode : k = e.which;
				return (!isNaN(String.fromCharCode(k)) || String.fromCharCode(k)=="/"  || k==8 || k==46 || k==0);
			}

			function inv_extractDate(str)
			{
				var output = "";
				var ch;
				for (i=0;i<str.length;i++)
				{
					ch=str.charAt(i);
					if(ch=="0" || ch=="1" || ch=="2" || ch=="3" || ch=="4" || ch=="5" || ch=="6" || ch=="7" || ch=="8" || ch=="9" || ch=="/") 
					{
						output = output + ch;
					}
				}
				return output;
			}

			
			function loadXML()
			{
				document.getElementById("inv_num").innerHTML = "<b>MO " + inv_num + "</b>";
				clicked = false;
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
								all_machines[machine_count] = x.childNodes[i].childNodes[0].nodeValue;
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
									all_machines[machine_count] = x.childNodes[i].childNodes[0].nodeValue;
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
					
					/*document.getElementById("nam").value="Mihir Nabar";
					document.getElementById("addr").value="1144 W 36th Pl";
					document.getElementById("cit").value="Los Angeles";
					document.getElementById("stat").value="CA";
					document.getElementById("zp").value="90007";
					document.getElementById("phon").value="(213)446-1074";
					document.getElementById("dat").value="09/15/2007";*/
					//document.getElementById("rq").value="213322323";
					
					add_entry();
			}
			
			function delete_row(r)
			{
				
				var i=r.parentNode.parentNode.rowIndex
				document.getElementById('inv_table').deleteRow(i)
				row_count--;
				grand_total();
			}
			
			
			function add_entry()
			{
				var x=document.getElementById('inv_table').insertRow(row_count++);
				x.id="row" + (row_count-1);
				
				var a=x.insertCell(0);
				var b=x.insertCell(1);
				var c=x.insertCell(2);
				var d=x.insertCell(3);
				var e=x.insertCell(4);
				var f=x.insertCell(5);
				var g=x.insertCell(6);
				
				


				a.innerHTML="<input value=\"0.0\" size=\"5\" type=\"text\ name=\"qt\" onkeyup=\"return calc_total(this);\" onkeypress=\"return qty_change(event)\" onchange=\"this.value=extractNumeric(this.value)\">";
				b.innerHTML="<input size=\"10\" type=\"text\ name=\"dat\" onkeypress=\"return date_change(event)\" onchange=\"this.value=extractDate(this.value)\">";
				c.innerHTML="<select size=\"1\" onchange=\"return desc_change(this);\" name=\"desc\" id=\"desc" + (row_count-1) + "\"><option value=\"0\">Select One</option></select> &nbsp;,&nbsp; <input size=\"35\" type=\"text\ name=\"optr\"> Operator";
				d.innerHTML="<input type=\"checkbox\" name=\"operator\" id=\"operator\" onclick=\"return operator_change(this);\">";
				e.innerHTML="0";
				f.innerHTML="0.00";
				g.innerHTML="<a href=\"javascript:void\" onclick=\"return delete_row(this);\">Delete</a>";
				//alert("hello");
				for(i=0;i<machine_count;i++)
				{
					var sel=document.getElementById("desc" + (row_count-1));
					//alert(all_machines[i]);
					sel.options[i+1]=new Option(all_machines[i],all_machines[i]);
					
				}
			}