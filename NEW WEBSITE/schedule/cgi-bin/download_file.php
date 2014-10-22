<?php
$name=$_REQUEST['username'];
$path="$name";
 echo "Downloadaa: ";
  echo "<br>";
if(is_dir($path))
{
    $openHandle=opendir($path);
	$i=0;
    while(false !== ($file = readdir($openHandle)))
    {
          if ($file != "." && $file != ".."&&strpos($file,".")) {
		echo "<a href='$path/$file'>".$file."</a>";
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