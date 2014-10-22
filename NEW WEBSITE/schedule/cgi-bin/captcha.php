<?php
 
session_start();
$Colors =  array (	'0' => '145',
                    '1' => '204',
                    '2' => '177',
                    '3' => '184',
                    '4' => '199',
                    '5' => '255');

$width = 320;
$height = 60;

$a = rand(1, 10);
$b = rand(1, 10);
$c = rand(0,1);

if($c == 0) {
	$_SESSION['captcha'] = $a + $b;
	$captcha = $a . " + " . $b;
} else {
	$_SESSION['captcha'] = $a * $b;
	$captcha = $a . " x " . $b;
}
 
$captcha.=" = ";

$image = imagecreatetruecolor($width, $height);

$white = imagecolorallocate($image, 255, 255, 255);
imagefill($image,10,10,$white);

for ($x=0; $x < $width; $x++)
{
    for ($y=0; $y < $height; $y++)
    {
        $random = mt_rand(0 , 5);
        $temp_color = imagecolorallocate($image, 
        	$Colors["$random"], 
        	$Colors["$random"], $Colors["$random"]);
        imagesetpixel( $image, $x, $y , $temp_color );
    }
}

$random_x = mt_rand(10 , 20);
$random_y = mt_rand(35 , 45);
$random_angle = mt_rand(-10 , 5);
$char_color = imagecolorallocatealpha($image, 0, 0, 0, 85 );

imagettftext($image, 30, $random_angle, $random_x, $random_y, $char_color, "Chanda_Feliz.ttf", $captcha);

//apply wave
$x_period = 10;
$y_period = 12;
$y_amplitude = 5;
$x_amplitude = 5;

$xp = $x_period*rand(1,3);
$k = rand(0,100);
for ($a = 0; $a<$width; $a++)
	imagecopy($image, $image, $a-1, sin($k+$a/$xp)*$x_amplitude, 
		$a, 0, 1, $height);
	
$yp = $y_period*rand(1,2);
$k = rand(0,100);
for ($a = 0; $a<$height; $a++)
	imagecopy($image, $image, sin($k+$a/$yp)*$y_amplitude, 
		$a-1, 0, $a, $width, 1);

for ($i=0; $i<$width; $i++ ) {
	if ($i%10 == 0) {
		imageline ( $image, $i, 0, 
			$i+10, $height, $char_color );
		imageline ( $image, $i, 0, 
			$i-10, $height, $char_color );
	}
}

header("Content-type: image/png");
imagepng($image);
?>