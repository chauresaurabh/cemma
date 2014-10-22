<?php
$allowedExts = array("pdf",	"PDF");
$extension = end(explode(".", $_FILES["file"]["name"]));
$manual=$_POST["manual"];
 
$fileName = $_FILES["file"]["name"];
 if(in_array($extension, $allowedExts)){
	if ($_FILES["file"]["error"] > 0)
	  {
	  echo "Error: " . $_FILES["file"]["error"] . "<br>";
	  }
	else
	  {
		  echo "Upload: " . $_FILES["file"]["name"];
		  if($manual == "7001"){
			  move_uploaded_file($_FILES["file"]["tmp_name"], "../docs/JSM_7001.pdf");
			  echo "<br/>File saved successfully";
		  } else if($manual == "diff"){
			  move_uploaded_file($_FILES["file"]["tmp_name"], "../docs/JEOL_2100F_Diffraction.pdf");
			  echo "<br/>File saved successfully";
		  } else if($manual == "start"){
			  move_uploaded_file($_FILES["file"]["tmp_name"], "../docs/JEOL_2100_TEM_Start_up_and_alignment.pdf");
			  echo "<br/>File saved successfully";
		  } else if($manual == "stem"){
			  move_uploaded_file($_FILES["file"]["tmp_name"], "../docs/JEOL_2100F_STEM.pdf");
			  echo "<br/>File saved successfully";
		  } else if($manual == "tilt"){
			  move_uploaded_file($_FILES["file"]["tmp_name"], "../docs/Single_tilt_Holder.pdf");
			  echo "<br/>File saved successfully";
		  }  else if($manual == "cemmatestmanual"){
			  move_uploaded_file($_FILES["file"]["tmp_name"], "../docs/".$fileName );
			  echo "<br/>File '$fileName' saved successfully";
		  } else {
			  echo "<br/>Could not save file.";
		  }
	  }
} else
  {
  	echo "Invalid file";
 	echo "Name is : ".$manual;
  }
?>