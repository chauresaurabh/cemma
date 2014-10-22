<?
function substring_finder($a)
{

//echo $a[0];

$count=1;
$j=0;
echo "len-".count($a)." ";

for( $i=0;$i<$a;$i++)
{
	
$count++;
echo "c-".$count;
$j=$a[$j];

if( $a[$j]<0)
	return $count;

}


}
$a[10];
$a[0]=1;
$a[1]=4;
$a[2]=5;
$a[3]=6;
$a[4]=2;
$a[5]=3;
$a[6]=-1;
$a[7]=-1;
//echo "no.".chr(97);
$index=substring_finder($a);
echo "final ---".$index;

?>