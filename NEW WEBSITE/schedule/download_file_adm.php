<?php
$name=$_REQUEST['username'];
$path="admUpload/$name";
 echo "Download: ";
  echo "<br>";
if(is_dir($path))
{
    $openHandle=opendir($path);
	$i=0;
    while(false !== ($file = readdir($openHandle)))
    {
          if ($file != "." && $file != ".."&&strpos($file,".")) {
		echo "<a href='$path/$file' download>".$file."</a>";
        echo "<br>";
		$i++;
		}
    }
 if($i==0){echo " Your folder is empty!";}
    closedir($openHandle);
}
else
{
	echo " Your folder is emptyy!";
}
?>