<?php
//  -   get parameters 
//  id  :   based on personal.userid
//  w   :   requested width
//  h   :   requested height
//  if both w and h is given, image is padded with white bacgkround to prevent image distortion
//  example http://www.remotestaff.com.au/portal/tools/staff_image.php?w=128&id=69
include('../conf/zend_smarty_conf.php');
include('../lib/SimpleImage.php');


$id = $_GET['id'];
$width = $_GET['w'];
$height = $_GET['h'];

if ($id == '') {
    die('missing id');
}

if ($width != '') {
    $width = intval($width);
    if ($width == 0) {
        die('width value invalid.');
    }
    if ($width > 640) {
        die('width value too big');
    }
}

if ($height != '') {
    $height = intval($height);
    if ($height == 0) {
        die('height value invalid.');
    }
    if ($height > 640) {
        die('height value too big');
    }
}

//get the image from the screenshot table
$sql = $db->select()
        ->from('personal', 'image')
        ->where('userid = ?', $id);
$image_str = $db->fetchOne($sql);

if ($image_str == False) {
    die('id not found!');
}

$file_name_with_path = sprintf('../%s', $image_str);
header("Content-type: image/jpeg");
$image = new SimpleImage();
if (file_exists($file_name_with_path)) {
    $image->load($file_name_with_path);
}
else {
    $image->load("../uploads/pics/no_pic.png");
}

//only width is given
if ($width != '' and $height == '') {
    $image->resizeToWidth($width);
    $image->output();
}

//only height is given
if ($width == '' and $height != '') {
    $image->resizeToHeight($height);
    $image->output();
}

//width and height is given, pad image
if ($width != '' and $height != '') {
    $image->resizeToHeight($height);
    $width_resized = $image->getWidth();

    if ($width_resized > $width) {
        $image->resizeToWidth($width);
    }

    //create a blank image
    $image_copy = imagecreatetruecolor($width, $height);
    
    //set bacgkround color
    $bg1 = imagecolorallocate($image_copy, 255, 255, 255);
    imagefill($image_copy, 0, 0, $bg1);

    //copy image
    if ($height == $image->getHeight()) {
        $y = 0;
        $x = ($width - $image->getWidth()) / 2;
    }
    else {
        $x = 0;
        $y = ($height - $image->getHeight()) / 2;
    }
    imagecopy($image_copy, $image->image, $x, $y, 0, 0, 
        $image->getWidth(), $image->getHeight());

    //output the image
    imagejpeg($image_copy);
}

?>
