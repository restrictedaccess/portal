<?php
function SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array, $sender=NULL, $reply_to=NULL){
	date_default_timezone_set("Asia/Manila");
	global $couch_dsn;
	//save details in couchdb
	$date_created_array = array(((int)date('Y')), ((int)date('m')), ((int)date('d')), ((int)date('H')), ((int)date('i')), ((int)date('s')));
	
	$couch_client = new couchClient($couch_dsn, 'mailbox');
	$doc = new stdClass();
	$doc->bcc = $bcc_array;
	$doc->cc = $cc_array;
	$doc->created = $date_created_array;
	$doc->from = $from;
	$doc->sender = $sender;
	$doc->reply_to = $reply_to;
	$doc->generated_by = $_SERVER['SCRIPT_FILENAME'];
	$doc->history = $history;
	$doc->html = $html;
	if(!$attachments_array){
	    $doc->sent = false;
	}
	$doc->subject = $subject;
	$doc->text = $text;
	$doc->to = $to_array;
	try {
		$response = $couch_client->storeDoc($doc);
		if($attachments_array){
			StoreAttachmentsInCouchDBMailbox ($response,$attachments_array);
		}
	} catch (Exception $e) {
	   echo "Something weird happened: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
	   exit(1);
	}

}


function StoreAttachmentsInCouchDBMailbox($response,$attachments_array){
	global $couch_dsn;
	$couch_client = new couchClient($couch_dsn, 'mailbox');
	
	foreach($attachments_array as $attachment){
		if($attachment['get_contents']){
			$myImage = $attachment['tmpfname'];
		}else{
			$myImage = file_get_contents($attachment['tmpfname']);
		}
		if($attachment['type']){
			$type = $attachment['type'];
		}else{
			$type = 'application/octet-stream';
		}
		
		
		try {
			$doc = $couch_client->getDoc($response->id);
		    $response = $couch_client->storeAsAttachment($doc,$myImage,$attachment['filename'],$content_type = $type);
		} catch (Exception $e) {
	        echo "Something weird happened. File Attachment error : ".$e->getMessage()." (errcode=".$e->getCode().")\n";
	        exit(1);
	    }	
	}
	
	UpdateCouchDBMailbox($response);
}

function UpdateCouchDBMailbox($response){
	global $couch_dsn;
	$couch_client = new couchClient($couch_dsn, 'mailbox');
	$doc = $couch_client->getDoc($response->id);
	$doc->sent=false;
	$couch_client->storeDoc($doc);
}

?>