<?php
if(isset($_GET['searchText'])){
	$searchText = $_GET['searchText']; 
}
else
	$searchText = "";
	
//echo "Search is ".$searchText;

$xdoc = new DomDocument;
$xdoc->Load('activities/JohnCurulli123.xml');
$activities = $xdoc->getElementsByTagName('Activities')->item(0);
$xp = new DOMXPath($xdoc);
$query = "Activity[contains(Title, '".$searchText."')]";
 //and Activity/Title[translate($searchText,'AZERTYUIOPQSDFGHJKLMWXCVBN',
//'azertyuiopqsdfghjklmwxcvbn')]"; 


$names = $xp->query($query, $activities);
echo '<p><table class = "content" cellpadding = "5" cellspacing = "5">';

    foreach($names as $name) 
    {

		echo '<tr valign="top"><td><strong>';
    	echo $name->getElementsByTagName('Date')->item(0)->nodeValue . "</strong></td><td>  ";
        echo $name->getElementsByTagName('Title')->item(0)->nodeValue ."</td></tr>";

        
       
	}
	

	echo '</table></p>';

?>