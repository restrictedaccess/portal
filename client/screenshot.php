<?php
//2010-07-19 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   initial release to create thumbnails of screenshots clients side

include('../conf/zend_smarty_conf.php');
include('../lib/SimpleImage.php');

$id = $_GET['id'];
$width = $_GET['width'];

//check if we have the client_id session
$client_id = $_SESSION['client_id'];
if (($client_id == "") || ($client_id == Null)) {
    $file_name_with_path = "../client/invalid-missing-screenshot.jpg";
}
else {

    if ($id == '') {
        $file_name_with_path = "../client/invalid-missing-screenshot.jpg";
    }

    if ($width != '') {
        $width = intval($width);
        if ($width == 0) {
            $file_name_with_path = "../client/invalid-missing-screenshot.jpg";
        }
        if ($width > 640) {
            $file_name_with_path = "../client/invalid-missing-screenshot.jpg";
        }
    }

    //get the image from the screenshot table
    $sql = $db->select()
            ->from('screenshots')
            ->where('id = ?', $id)
            ->where('leads_id = ?', $client_id);
    $screenshot = $db->fetchRow($sql);

    if ($screenshot == False) {
        $file_name_with_path = "../client/invalid-missing-screenshot.jpg";
    }
    else {
        $post_time = new DateTime($screenshot['post_time']);
        $userid = $screenshot['userid'];
        $day = $post_time->format('Y-m-d');
        $time = $post_time->format('H-i-s');

        $file_name_with_path = sprintf('%s%s/%s/%s.jpg', SCREENSHOT_PATH, $day, $userid, $time);

        if (! (file_exists($file_name_with_path))) {
            $file_name_with_path = "../client/invalid-missing-screenshot.jpg";
        }
    }

}

header("Content-type: image/jpeg");
$image = new SimpleImage();
$image->load($file_name_with_path);
if ($width != '') {
    $image->resizeToWidth($width);
}
$image->output();
?>
