<?php
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
		$name=$_REQUEST['username'];
	echo "username: " . $name."<br/>" ;
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
  
	
	
		$path="$name";
		if(is_dir($path))
		{
			if (file_exists("$name/" . $_FILES["file"]["name"]))
			  {
			  echo $_FILES["file"]["name"] . " already exists. ";
			  }
			else
			  {
			  move_uploaded_file($_FILES["file"]["tmp_name"],
			  "$name/" . $_FILES["file"]["name"]);
			  echo "Stored in: " . "$name/" . $_FILES["file"]["name"];
			  }
		}
		else
		{
			mkdir($path);
			if (file_exists("$name/" . $_FILES["file"]["name"]))
			  {
			  echo $_FILES["file"]["name"] . " already exists. ";
			  }
			else
			  {
			  move_uploaded_file($_FILES["file"]["tmp_name"],
			 "$name/" . $_FILES["file"]["name"]);
			  echo "Stored in: " . "$name/" . $_FILES["file"]["name"];
			  }

		}
    } 
?>