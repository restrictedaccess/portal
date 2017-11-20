<?php
//2010-05-30 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   initial release to create thumbnails of screenshots

include('../conf/zend_smarty_conf.php');
include('../lib/SimpleImage.php');

$admin_id = $_SESSION['admin_id'];
if ($admin_id == '') {
    die('Not logged in.');
}

$id = $_GET['id'];
$width = $_GET['width'];

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
        ->from('screenshots')
        ->where('id = ?', $id);
$screenshot = $db->fetchRow($sql);

if ($screenshot == False) {
    die('id not found!');
}

$post_time = new DateTime($screenshot['post_time']);
$userid = $screenshot['userid'];
$day = $post_time->format('Y-m-d');
$time = $post_time->format('H-i-s');

$file_name_with_path = sprintf('%s/%s/%s/%s.jpg', SCREENSHOT_PATH, $day, $userid, $time);

if (file_exists($file_name_with_path)) {
    header("Content-type: image/jpeg");
    $image = new SimpleImage();
    $image->load($file_name_with_path);
    if ($width != '') {
        $image->resizeToWidth($width);
    }
    $image->output();
}
else {
    die('image not found');
}
?>
