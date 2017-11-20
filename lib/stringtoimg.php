<?php
/*
Filename: stringtoimg.php

Parameters:
        string: the string to print
        font_size (optional): the size of the font from 1-5
        R/G/B (optional): the RGB colors of the font in hex       
*/

header ("Content-type: image/png");

//Get string info
$font_size = isset($_GET['font_size']) ? $_GET['font_size'] : 5;
$string = urldecode(base64_decode($_GET['string']));

//Get the size of the string
$width = imagefontwidth($font_size) * strlen($string);
$height = imagefontheight($font_size);

//Create the image
$img = @imagecreatetruecolor($width, $height)
      or die("Cannot Initialize new GD image stream");

//Make it transparent
imagesavealpha($img, true);
$trans_colour = imagecolorallocatealpha($img, 0, 0, 0, 127);
imagefill($img, 0, 0, $trans_colour);

//Get the text color
$text_color = isset($_GET['R'], $_GET['G'], $_GET['B']) ?
        imagecolorallocate($img, hexdec($_GET['R']), hexdec($_GET['G']), hexdec($_GET['B'])) :
        imagecolorallocate($img, 0, 0, 0);

//Draw the string
imagestring($img, $font_size, 0, 0,  $string, $text_color);

//Output the image
imagepng($img);
imagedestroy($img);
?>