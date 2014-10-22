 
<script type="text/javascript">
function goBack()
  {
  window.history.back()
  }
  
function printpage()
{
		 var printButton = document.getElementById("printbutton");
		 var backButton = document.getElementById("backbutton");

         printButton.style.visibility = 'hidden';
	 	 backButton.style.visibility = 'hidden';

         window.print();
         printButton.style.visibility = 'visible'; 
		 backButton.style.visibility = 'visible';
}
</script>
 
<?
//need to check this again .. because the form is resubmitted on clicking Update .. 
// so maybe add a new parameter say submit update = true
session_start();
	$dbhost="db1661.perfora.net";
	$dbname="db260244667";
	$dbusername="dbo260244667";
	$dbpass="curu11i";

	$month = date('m');
	$year = date('y');
	$day = date('d');
	if($month >= 7 ){
		$year = $year + 1;
	}
	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
 	
	if( $month==7 && $day >=1 ){
			$sql= "update QUOTE_SEQUENCE set quote_number=100";
	}else{
			$sql= "update QUOTE_SEQUENCE set quote_number=quote_number+1";
	 }
	mysql_query($sql) or die("Error in Connection");
  	$sql="select quote_number from QUOTE_SEQUENCE";
	 $result = mysql_query($sql);
	 $quoteNum=0;
	 while($row=mysql_fetch_array($result)){ 
	 	 $quoteNum = $row['quote_number'];
	 }
    $headerInfo = $headerInfo . "<div style='width: 800px'> <p style='margin-left:80%'> Number : $year/ $quoteNum"."Q </p>  </div> ".

	$headerInfo = $headerInfo. "<img src='logo.jpg' width=400, height=100>";
	 $headerInfo = $headerInfo. "<span style='margin-left:8%'><img src='cemmalogo_quote.jpg'></span> <br><br>";
	 $headerInfo = $headerInfo. "<span style='margin-left:1%'><img src='quote.jpg'></span>";
 
	 echo $headerInfo;
		 
	  $count = $_POST['listcount'];
	  $customer_name = $_POST['customer_name'];
	  $sql=" select * from Customer where Name='". $customer_name ."'";
	  $result = mysql_query($sql);
 	
	$total = 0;
	$dateToday = date('M j, Y');
	 
  	while($row=mysql_fetch_array($result)){ 
$str = $str." <br><br>
		 <table> <tr><td>
	<fieldset style='width:790px;border-radius: 8px;'>
    <legend> <b>Customer</b> </legend>".
	//" <b>Name</b> ".
	" ". "&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;".  $row['FirstName']."&nbsp;". $row['LastName']. 
	"<span style='margin-left:60%'>$dateToday </span>"."<br>";
	
     //" <b>Address</b> ".
	if($row['Address1']!=''){
		$str = $str. "   &nbsp; &nbsp;&nbsp;  &nbsp; ".  $row['Address1'].          "&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;                 &nbsp;&nbsp;&nbsp;&nbsp;
	 &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	  "."<br>";
	}
	 
    //" <b>City</b> ".
	$str = $str."  &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; ". $row['City'].", ".$row['State'].", ".$row['Zip']. " &nbsp; &nbsp;&nbsp;       				              &nbsp;&nbsp;  &nbsp;&nbsp; &nbsp;&nbsp;  &nbsp;".
	 //" <b>State</b> ".
	// "  &nbsp;&nbsp;  ". $row['State']. "&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;               &nbsp;   &nbsp;". 
	//" <b>Zip</b> ".
	//" &nbsp; &nbsp;  ".$row['Zip']. "&nbsp; &nbsp;&nbsp; &nbsp; <br>".
	//" <b>Phone</b> ".
	" <br>&nbsp; &nbsp;  &nbsp;  &nbsp;&nbsp;".	$row['Phone']. "&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; ".
	//" <b>Fax</b> ".
	 "  &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	 &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    ". " </fieldset></td>".
	
	//"	<td>	Date :    &nbsp; &nbsp; $dateToday    &nbsp; <br><br> </td>".

 /*  	<td>
		<fieldset style='width:250px;border-radius: 8px;'>
		Date :    &nbsp; &nbsp; $dateToday    &nbsp; <br><br>
		  <br><br> 
	</fieldset>
	</td>
	*/
	"
	</table>";
  
	}
 
	 $sql="";
	for($i=1;$i<=$count;$i++){
			$radio = "radio".$i;
			$instrument_name="instrument_name".$i;
 
 			$column1 = "`".$_POST['customer_type']."_". $_POST[ $radio ]."` as price ";
			$sql = $sql. "SELECT machine_name,cemma_unit, ".$column1." from rates where InstrumentNo = ". $_POST[$instrument_name];
			if($i!=$count){
					$sql = $sql. " union ";
				}
 	} 
	 //echo $sql;
	$str = $str. "<br><br><table border='1' cellpadding='5px' cellspacing='5px' style='border-collapse: collapse; ' >";
	$str = $str. "<tr>
		<th>Quantity</th> <th>Description</th>	<th>Unit Price</th>	<th>Unit</th> <th>TOTAL</th>	
 	</tr>";
		$result = mysql_query($sql);
		$j=1;
 	while($row=mysql_fetch_array($result)){ 
	$quantity = "quantity".$j;
	$totalItem = $row['price'] * $_POST[$quantity];
	$str = $str. "<tr>
				<td align='center'>". $_POST[$quantity]. "</td>"."
				<td width='540px'>". $row['machine_name']. "</td>"."
				<td align='center'>". $row['price']. "</td>". "
			    <td align='center'>". $row['cemma_unit']. "</td>"."
				<td align='center'>". $totalItem . "</td>"."
			</tr> ";
			
		$total = $total + $totalItem ;
		$j = $j + 1;
		//echo $row['machine_name']." --- " . $row['price'];
		  $str = $str. "<br>";
	}
 
 	 $str = $str. "</table>";
	 $str = $str. "<br>";

	 $str = $str. "<div style='margin-left:700px'><b>Total : " .$total ."</b></div> <br> <br>";
	 	
	 $str = $str . "<br/><br/>
	 <div>". 
			" <div style='margin-left:275px'>Center for Electron Microscopy and Microanalysis<br><br></div> 
 			<div style='margin-left:325px'>University of Southern California</div> 
			<div style='margin-left:350px'>University Park Campus</div>  
			<div style='margin-left:300px'>814 Bloom Walk, CEM Building, MC 0101</div>  
			<div style='margin-left:325px'>Los Angeles, California 90089-0101</div> 
			<div style='margin-left:365px'> &nbsp;&nbsp;&nbsp; (213)-740-1990</div> 
			<div style='margin-left:365px'>Fax : (213)-821-0458</div> 
			<div style='margin-left:365px'>&nbsp;&nbsp;&nbsp;cemma@usc.edu</div> 

 	</div>  ";
	
	 $str = $str . "<br/><b><center><span style='text-align:center;font-weight:700;font-size:15px;'>".
	"<input type='button' id='backbutton' value='Back' onclick='goBack()'>
	 <input type='button' id='printbutton' value='Print this page' onclick='printpage()'> <br/></span></center> ";
	
	
	echo $str;
mysql_close();
session_write_close();
?> 
 