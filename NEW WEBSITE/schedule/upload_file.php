<?php
 if (($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "application/x-zip-compressed")
|| ($_FILES["file"]["type"] == "application/octet-stream")
|| ($_FILES["file"]["type"] == "application/zip")
|| ($_FILES["file"]["type"] == "application/msword")
|| ($_FILES["file"]["type"] == "application/vnd.ms-excel")
|| ($_FILES["file"]["type"] == "application/vnd.ms-powerpoint")
|| ($_FILES["file"]["type"] == "application/pdf")){
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
  
	
	
		$path="upload/$name";
		if(is_dir($path))
		{
			if (file_exists("upload/$name/" . $_FILES["file"]["name"]))
			  {
			  echo $_FILES["file"]["name"] . " already exists. ";
			  }
			else
			  {
			  move_uploaded_file($_FILES["file"]["tmp_name"],
			  "upload/$name/" . $_FILES["file"]["name"]);
			  echo "Stored in: " . "$name/" . $_FILES["file"]["name"];
			  }
		}
		else
		{
			mkdir($path);
			if (file_exists("upload/$name/" . $_FILES["file"]["name"]))
			  {
			  echo $_FILES["file"]["name"] . " already exists. ";
			  }
			else
			  {
			  move_uploaded_file($_FILES["file"]["tmp_name"],
			 "upload/$name/" . $_FILES["file"]["name"]);
			  echo "Stored in: " . "upload/$name/" . $_FILES["file"]["name"];
			  }

		}
    }
  }
  else
  {
  echo "Invalid file";
  }
?>