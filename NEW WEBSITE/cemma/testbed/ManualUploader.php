<?php
$allowedExts = array("pdf",	"PDF");
$extension = end(explode(".", $_FILES["file"]["name"]));
$manual=$_POST["manual"];

$hiddenInstrumentNo=$_POST["hiddenInstrumentNo"];
$manualName=$_POST["manualName"];
$fileName = $_FILES["file"]["name"];
$updateValue = $_POST["updateValue"];
$manualNumber = $_POST["manualNumber"];

 
$fileUploaded = false;

 if(in_array($extension, $allowedExts)){
	if ($_FILES["file"]["error"] > 0)
	  {
	 	 echo "Error : " . uploadErrorMessages($_FILES["file"]["error"]);
  	  }
	else
	  {
		  echo "<b>Uploading File : " . $_FILES["file"]["name"] ."</b>". "<br>";
		  
			  if ( move_uploaded_file($_FILES["file"]["tmp_name"], "./manuals/".$fileName ) )
			  {
			  echo "<br/><b>File '$fileName' uploaded successfully</b>". "<br>"; // need to style this information
				$fileUploaded = true;
			  }else{
 			 	 echo "<br/><b>Could not save file.</b>". "<br>"; // need to style this information
			  }
			  
			  if($fileUploaded){
				  // insert or update will be based on some parameter.
				  echo "<b>Linking File with Database</b>". "<br>";  
				  	
				 $dbhost="db1661.perfora.net";
				$dbname="db260244667";
				$dbusername="dbo260244667";
				$dbpass="curu11i";
			
				$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
				$SelectedDB = mysql_select_db($dbname) or die ("Error while linking manual in Database..");
				
				if($updateValue == 'true' ){
 $sql="update MANUAL set manual_name='$manualName' , manual_filename='$fileName' where manual_num = $manualNumber  ";

				}else if($updateValue == 'false' ){ // meaning you need to insert a new value in manual
					 
					$sql="insert into MANUAL(  instrument_num , manual_name , manual_filename  )
							 values($hiddenInstrumentNo, '$manualName', '$fileName' ) ";
				}
				  mysql_query($sql) or die(mysql_error());
			 
			 	echo "<b>Manual Linked with Database ..!!</b>". "<br>";   

				  
				}
 	  }
} else
  {
	   if( $manualName!=""){
		  	 $dbhost="db1661.perfora.net";
				$dbname="db260244667";
				$dbusername="dbo260244667";
				$dbpass="curu11i";
			
				$connection = mysql_connect($dbhost, $dbusername, $dbpass) or die("Error in Connection");
				$SelectedDB = mysql_select_db($dbname) or die ("Error while linking manual in Database..");
				
 		 $sql="update MANUAL set manual_name='$manualName' where manual_num = $manualNumber  ";
		  mysql_query($sql) or die(mysql_error());
 		 echo "<b>Manual Name Updated to '$manualName'..!!</b>". "<br>";   

		}
		else{
  	echo "<b>Invalid file</b>". "<br>";
 	echo "<b>Name is : ".$manual."</b>". "<br>";
		}
  }
  
  
 function uploadErrorMessages($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the allowed size. Please check 'upload_max_filesize' and 'post_max_size            ' directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    } 
	
?>