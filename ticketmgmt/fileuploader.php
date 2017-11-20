<?php    /* $Id: uploader.php  $ */
	// ------------------------------------------------------------- //
	//require_once('../conf/zend_smarty_conf.php');
	require_once('../portal/lib/misc_functions.php');
	$upload_path = "../portal/uploads/";
	//error_reporting(E_ALL ^ E_NOTICE);
	ini_set('display_errors', TRUE);
	$userid = getVar("userid");

	$fname = getVar("fname");
	$ids = getVar("ids");
	
	$grpchat = getVar("grpchat");
	
	$upload_path .= "pics/";
	// task to delete file - execute after download complete (12/14/2010) //
	if ($task == 'del') {
		unlink($upload_path . $fname);
		exit(0);
	}
    
	//file_write_log("\t==> STARTING...");
	
    if($_FILES['inpfile']['tmp_name'] != "") {
		$file_ext = strtolower(str_replace(".", "", strrchr($_FILES['inpfile']['name'], ".")));
		
		if ($chat) $file_dest = $upload_path . $_FILES['inpfile']['name'];
		else $file_dest = $upload_path . $userid . "." . $file_ext;
		
		// for some reason sending file with spaces on filename resulted into zero-byte file
		$file_dest = str_replace(" ", "_", $file_dest);
		
		//file_write_log("file dest: ".$_FILES['inpfile']['name'] . " <--> ".$_FILES['inpfile']['tmp_name']);
		
        // this code is outputted to IFRAME (embedded frame)
		// main page is a 'parent'
		echo '<html><head><title>-</title></head><body>';
		echo '<script language="JavaScript" type="text/javascript">'."\n";
		echo 'var parDoc = window.parent;';
    
    
		// TRY MOVING UPLOADED FILE, RETURN ERROR UPON FAILURE
	
        if(!move_uploaded_file($_FILES['inpfile']['tmp_name'], $file_dest)) {
			$is_error = 1;
		} else {
			chmod($file_dest, 0777);
			
			echo 'parDoc.fileUploaded("'. $_FILES['inpfile']['name'] .'", "'.$ids.'",'. $grpchat .');';
			$is_error = 0;
		}
	}	
	
	echo "\n".'</script></body></html>';
	
	//file_write_log("\t\t==> RESULT...".$is_error);

    exit(); // do not go futher
	
	function file_write_log($str) {
		$date_now = date("Y-m-d H:i:s");
		$fh = fopen("upload.log", "a");
		fwrite($fh, "{$date_now} -- {$str}\n");
		fclose($fh);
	}
