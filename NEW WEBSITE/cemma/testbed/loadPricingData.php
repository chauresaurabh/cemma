 
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
	//include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");

	$new_customer = $_GET['new_customer'];
	$customer_name= $_GET['customer_name'];
	$customer_address="";
	$customer_phone="";
	$customer_email="";
	$dateToday = date('M j, Y');

 	 $sql="";
  
 			$column1 = "`".$_GET['customer_type2']."_". "With_Operator"."` as priceWithOperator ";
 			$column2 = "`".$_GET['customer_type2']."_". "Without_Operator"."` as priceWithoutOperator ";
		$sql = $sql. "SELECT cemma_unit, machine_name,".$column1.",".$column2." from rates , instrument where   instrument.DisplayOnPricingPage=1 and instrument.InstrumentNo = rates.InstrumentNo  ";
 	
	$sql2="";
	//echo $sql;
	$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
	$SelectedDB = mysql_select_db($dbname) or die ("Error in DB");
 	  if($new_customer=="true"){
 			$customer_address= $_GET['customer_address'];
			$customer_phone= $_GET['customer_phone'];
			$customer_email= $_GET['customer_email'];
 	  }else{
		 	$sql2="select Address1, FirstName, LastName, Phone, EmailId from Customer where Name ='". $_GET['customer_name']."'";
		 	$result = mysql_query($sql2); 
			while($row=mysql_fetch_array($result)){ 
				$customer_address = $row['Address1'];
				$customer_phone = $row['Phone'];
				$customer_email = $row['EmailId'];	
				$customer_name =  $row['FirstName']."&nbsp;".$row['LastName'];
 			}
		}	
 		
 		$result = mysql_query($sql);
		
	$str = "<br><br>
	<div style='margin-left:100px'>
	  <fieldset style='width:490px;border-radius: 8px;'>
    <legend> <b>Customer</b> </legend>".
	//" <b>Name</b>".
	"   ". "&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;".  $customer_name. "<span style='margin-left:40%'>$dateToday </span>"."<br>";
	
     //" <b>Address</b> ".
	 if($customer_address!=''){
		$str = $str ."   &nbsp; &nbsp;&nbsp;  &nbsp; ". $customer_address.  "&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;                 &nbsp;&nbsp;&nbsp;&nbsp;
	 &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	  "."<br>";
	  }
	 
    //" <b>Phone</b>".
	if($customer_phone!=''){
		$str = $str ." &nbsp; &nbsp;&nbsp; &nbsp; ". $customer_phone. " &nbsp; &nbsp;&nbsp;       				              &nbsp;&nbsp;  &nbsp;&nbsp; &nbsp;&nbsp;  &nbsp;";
		}
	 //" <b>Email</b> ".
	 
	$str = $str . " <br>  &nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;". $customer_email ."      &nbsp;   &nbsp; </fieldset></div>";
	 
	$str = $str.	"<br><table border='1' cellpadding='5px' cellspacing='5px' style='border-collapse: collapse; margin-left:100px; '>
					 <tr>
						<th rowspan='2'>Instrument</th>
						<th colspan='2'>". $_GET['customer_type2'] . " Users</th>				
					</tr>";
				$str = $str. "		<tr>	<td>". "<span style='font-size:15px'> W/ CEMMA Operator</span> <br><span style='margin-left:50px'> per hour"."</span></td>"."
						<td>". "<span style='font-size:15px'> W/O CEMMA Operator </span><br><span style='margin-left:50px'> per hour"."</span></td> </tr>";
  	while($row=mysql_fetch_array($result)){ 
	$str = $str . "<tr>";
 	$str = $str. "<td>". $row['machine_name']. "</td>";
	if( $row['cemma_unit']=='Each'){
			$str = $str. "<td > <p style='margin-left:50px'> $ ". $row['priceWithOperator']. " /use </p> </td>";
 			$str = $str. "<td > <p style='margin-left:50px'> $ ". $row['priceWithoutOperator']. " /use </p> </td>";
	}else{
			$str = $str. "<td > <p style='margin-left:50px'> $ ". $row['priceWithOperator']. " </p> </td>";
 			$str = $str. "<td > <p style='margin-left:50px'> $ ". $row['priceWithoutOperator']. " </p> </td>";
	}
	$str = $str . "</tr>";
 	 
	 }
	$str = $str. "</table>";
	
	
 	$headerInfo = $headerInfo. "<img src='logo.jpg' width=400, height=100>";
	 $headerInfo = $headerInfo. "<span style='margin-left:8%'><img src='cemmalogo_pricing.jpg'></span> <br><br>";
	 $headerInfo = $headerInfo. "<span style='margin-left:1%'><img src='quote.jpg'></span>";
 
 	echo $headerInfo;
	
	 $str = $str . "<br/><br/> <div>".
 	 
	" <div style='margin-left:200px'>All Prices Valid : July 1, 2014 - June 30, 2015<br><br></div> 
 			<div style='margin-left:225px'>University of Southern California</div> 
			<div style='margin-left:250px'>University Park Campus</div>  
	 		<div style='margin-left:200px'>814 Bloom Walk, CEM Building, MC 0101</div>  
			<div style='margin-left:225px'>Los Angeles, California 90089-0101</div> 
			<div style='margin-left:265px'> &nbsp;&nbsp;&nbsp; (213)-740-1990</div> 
			<div style='margin-left:265px'>Fax : (213)-821-0458</div> 
			<div style='margin-left:265px'>&nbsp;&nbsp;&nbsp;cemma@usc.edu</div> 

 	</div>  ";
	
	 $str = $str . "<br/><b><center><span style='text-align:center;font-weight:700;font-size:15px;'>".
	"<input type='button' id='backbutton' value='Back' onclick='goBack()'>
	 <input type='button' id='printbutton' value='Print this page' onclick='printpage()'> <br/></span></center> ";
		
	echo $str;
mysql_close();
session_write_close();
?> 
 