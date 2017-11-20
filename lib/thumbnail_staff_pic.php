<?php
    define ("FILE_PATH", "/home/remotestaff/www.remotestaff.com.au/html/portal/");
    define ("WIDTH", 88);
    $file_name = $_GET['file_name'];
    include('SimpleImage.php');
    header("Content-type: image/jpeg");
    $image = new SimpleImage();
    if ((trim($file_name) == "") or ($file_name == Null)) {
        $image->load(FILE_PATH . "uploads/pics/no_pic.png");
    }
    else {
        $file_name_with_path = FILE_PATH . $file_name;
        
        if (file_exists($file_name_with_path)) {
            $image->load($file_name_with_path);
        }
        else {
            $image->load(FILE_PATH . "uploads/pics/no_pic.png");
        }
    }
    $image->resizeToWidth(WIDTH);
    $image->output();
?>
