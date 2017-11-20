<?php
//  -   get parameters 
//  id  :   based on personal.userid
//  w   :   requested width
//  example http://www.remotestaff.com.au/portal/tools/staff_image.php?w=128&id=69
//2010-06-02 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   initial release to create thumbnails of staffs picture

include('../conf/zend_smarty_conf.php');
include('../lib/SimpleImage.php');

$id = $_GET['id'];
$width = $_GET['w'];

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

if ($width != '') {
    $image->resizeToWidth($width);
}
$image->output();
?>
