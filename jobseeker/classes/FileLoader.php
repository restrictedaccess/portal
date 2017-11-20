<?php
/**
 * Class responsible for listing file uploads
 *
 * @version 0.2 - Added Mike Lacanilao Record Script
 * @version 0.1 - Initial commit on New jobseeker portal
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/EditProcess.php";

require_once dirname(__FILE__)."/QQFileUploader.php";
require_once dirname(__FILE__)."/../../recruiter/util/HTMLUtil.php";
require_once dirname(__FILE__)."/SimpleImage.php";
require_once dirname(__FILE__)."/../../conf/zend_smarty_conf.php";

class FileLoader extends EditProcess{
	public function listAllUploads($userid, $limit=-1){
		$db = $this->db;
		$sql = $db->select()->from(array("tbf"=>"tb_applicant_files"), array("tbf.*", new Zend_Db_Expr("DATE_FORMAT(tbf.date_created,'%D %b %Y') AS date_uploaded")))->where("tbf.userid = ?", $userid)->where("permission = 'ALL'") -> where("tbf.is_deleted = 0 OR tbf.is_deleted IS NULL");
		if ($limit!=-1){
			$sql->limit(10);
		}
		return $db->fetchAll($sql);
	}
	
	/**
	 * Uploads the picture into the server
	 */
	public function uploadPhoto(){
		$db = $this->db;
		$allowedExtensions = array("jpeg", "png", "jpg", "gif");
		$userid = $_SESSION["userid"];
		$sizeLimit = 5 * 1024 * 1024;
		$uploader = new qqFileUploader($allowedExtensions,$sizeLimit);
		
		$name = $uploader->getName();
		$splitName = explode(".", $name);
		$uploader->handleUpload(getcwd()."/../uploads/pics/");
		$new = "uploads/pics/".$userid.".".$splitName[1];
		if (file_exists(getcwd()."/../uploads/pics/".$name)){
			rename(getcwd()."/../uploads/pics/".$name, getcwd()."/../".$new);
			$db->update("personal", array("image"=>$new), $db->quoteInto("userid = ?", $userid));
			$imageApi = new SimpleImage();
			$imageApi->load(getcwd()."/../".$new);
			if ($imageApi->getWidth()>320){
				$imageApi->resizeToWidth(320);
				$imageApi->save(getcwd()."/../".$new);
			}
			$data = array();
			$this->subtractRemoteReadyScore($userid, 1);
			
//			$db->delete("remote_ready_criteria_entries", "userid = ".$userid." AND remote_ready_criteria_id = 1");
			$data["userid"] = $userid;
			$data["remote_ready_criteria_id"] = 1;
			$data["date_created"] = date("Y-m-d h:i:s");
//			$db->insert("remote_ready_criteria_entries", $data);
			
			global $base_api_url;
			
			file_get_contents($base_api_url . "/mongo-index/sync-candidates-files/?userid=" . $userid);
			return array("success"=>true);
		}else{
			return array("success"=>false);
		}
		
	}
	
	/**
	 * Uploads the voice recording
	 */
	public function uploadVoiceRecording(){
		$db = $this->db;
		$util = new HTMLUtil();
		$allowedExtensions = array("mp3", "wav", "wma");
		$userid = $_SESSION["userid"];
		
		//check if has voice uploaded
		$voice = $db->fetchRow($db->select()->from(array("p"=>"personal"), "voice_path")->where("userid = ?", $userid));
		if ($voice&&$voice["voice_path"]){
			$path = getcwd()."/../uploads/voice/".$userid.".mp3";
			if (file_exists($path)){
				unlink($path);	
			}
		
			$path = getcwd()."/../uploads/voice/".$userid.".MP3";
			if (file_exists($path)){
				unlink($path);	
			}
			$path = getcwd()."/../uploads/voice/".$userid.".Mp3";
			if (file_exists($path)){
				unlink($path);	
			}
			$path = getcwd()."/../uploads/voice/".$userid.".mP3";
			if (file_exists($path)){
				unlink($path);	
			}
			
			
		}
		
		$sizeLimit = 5 * 1024 * 1024;
		$uploader = new qqFileUploader($allowedExtensions,$sizeLimit);
		
		$name = $uploader->getName();
		$splitName = explode(".", $name);
		$uploader->handleUpload(getcwd()."/../uploads/voice/");
		
		$new = "uploads/voice/".$userid.".".$splitName[1];
		
		if (file_exists(getcwd()."/../uploads/voice/".$name)){
			rename(getcwd()."/../uploads/voice/".$name, getcwd()."/../".$new);
			$db->update("personal", array("voice_path"=>$new), $db->quoteInto("userid = ?", $userid));
			$voice_parts = pathinfo($new);
            if (strtolower($voice_parts['extension']) != 'mp3' && (in_array(strtolower($voice_parts['extension']), array("wma", "wav") ))) {		
				$this->convert($userid);	
			}
			$data = array();
			$this->subtractRemoteReadyScore($userid, 2);
			
//			$db->delete("remote_ready_criteria_entries", "userid = ".$userid." AND remote_ready_criteria_id = 2");
			$data["userid"] = $userid;
			$data["remote_ready_criteria_id"] = 2;
			$data["date_created"] = date("Y-m-d h:i:s");
//			$db->insert("remote_ready_criteria_entries", $data);
			
			global $base_api_url;
			
			file_get_contents($base_api_url . "/mongo-index/sync-candidates-files/?userid=" . $userid);
			
			return array("success"=>true);
		}else{
			return array("success"=>false);
		}
		
		
		
		
		
	}
	
	 function convert($userid) {
     	$db = $this->db;
        $sql = $db->select()
                ->from('personal', 'voice_path')
                ->where('userid = ?', $userid);
        $voice_path = $db->fetchOne($sql);

        if ($voice_path == False) {
            return False;
        }
		$voice_path = "../".$voice_path;
		
        if (file_exists($voice_path)) {
            //check file type, extra steps for the wma since debian doesn't support directly converting wma to mp3
            $voice_parts = pathinfo($voice_path);
            if (strtolower($voice_parts['extension']) == 'wma') {
            	
                $output = "../uploads/voice/{$userid}.wav";
				
	            if (file_exists($output)){
	            	unlink($output);
	            }
                $sh = "ffmpeg -i {$voice_path} {$output}";
                $out = shell_exec($sh);
                
                $stat = stat($output);
				
                
                if (!stat) {
                    return 'stat() call failed wav...';
                }
                if ($stat['size'] == 0) {
                    return 'Failed to convert. Filesize is 0 a';
                }
                //delete the wma file
                unlink($voice_path);

                //re-assign $voice_path
                $voice_path = $output;
            }

            //convert using lame
           $output = "../uploads/voice/{$userid}.mp3";
            if (file_exists($output)){
            	unlink($output);
            }
            $sh = sprintf("lame -m m --silent %s %s", $voice_path, $output);
            $out = shell_exec($sh);

            $stat = stat($output);

            if (!stat) {
                return 'stat() call failed for mp3...';
            }
            if ($stat['size'] == 0) {
                return 'Failed to convert. Filesize is 0 b';
            }

            //update voice_path
            $data = Array (
                'voice_path' => "uploads/voice/$userid.mp3",
            );
            $db->update('personal', $data, "userid = $userid");

            //delete the file
            unlink($voice_path);
            return "Ok";
       }
        return False;
    }
	
	
	
	
	/**
	 * Deletes a file, fails if file not owned by logged in user
	 */
	public function deleteFile(){
		$db = $this->db;
		$id = $_GET["id"];
		
		$file = $db->fetchRow($db->select()->from(array("tbf"=>"tb_applicant_files"))->where("id = ?", $id));
		if ($file){
			if ($file["userid"]!=$_SESSION["userid"]){
				return array("success"=>false);
			}
			//$db->delete("tb_applicant_files", $db->quoteInto("id = ?", $id));
			$db->update("tb_applicant_files", array("is_deleted" => 1), $db->quoteInto("id = ?", $id));
            $db->delete("solr_candidates", $db -> quoteInto("userid=?",$_SESSION["userid"]));
			
			global $base_api_url;
			
			file_get_contents($base_api_url . "/solr-index/sync-candidates/");
			
			if (file_exists(getcwd()."/../applicants_files/".$file["name"])){
				unlink(getcwd()."/../applicants_files/".$file["name"]);	
			}
			
			
			file_get_contents($base_api_url . "/mongo-index/sync-candidates-files/?userid=" . $_SESSION["userid"]);
			
			
			return array("success"=>true);
		}else{
			return array("success"=>false);
		}
		
		
		
	}
	
	/**
	 * Uploads the files
	 */
	public function uploadFiles(){
		$db = $this->db;
		$util = new HTMLUtil();
		$allowedExtensions = array("jpg", "jpeg", "png", "gif", "pdf", "doc", "docx", "php", "ppt", "pptx", "xls", "xlsx", "txt", "rb", "py", "html");
		$renameExtensions = array("php", "rb", "py", "html");
		$userid = $_SESSION["userid"];
		$sizeLimit = 5 * 1024 * 1024;
		$uploader = new qqFileUploader($allowedExtensions,$sizeLimit);
		
		$name = $uploader->getName();
		$splitName = explode(".", $name);
		$extension = pathinfo($name, PATHINFO_EXTENSION);
		$baseName = basename($name, ".".$extension);
		
		$uploader->handleUpload(getcwd()."/../applicants_files/");
		
		//check if file is on to be renamed extensions
		if (in_array($baseName, $renameExtensions)){
			$newName = $userid."_{$baseName}_".$extension.".txt";
		}else{
			$newName = $userid."_{$baseName}.".$extension;
		}
		$new = "/applicants_files/".$newName;
		
		if (file_exists(getcwd()."/../applicants_files/".$name)){
			rename(getcwd()."/../applicants_files/".$name, getcwd()."/..".$new);
			$date_created = date("Y-m-d H:i:s");
			$data = array("userid"=>$userid, 
						  "file_description"=>$_GET["type"],
						  "name"=>$newName,
						  "permission"=>"ALL",
						  "date_created"=>$date_created);
			$db->insert("tb_applicant_files", $data);
            $db->delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
						
			global $base_api_url;
			
			file_get_contents($base_api_url . "/solr-index/sync-candidates/");
							
			
			file_get_contents($base_api_url . "/mongo-index/sync-candidates-files/?userid=" . $userid);
			
			
			return array("success"=>true,);
		}else{
			return array("success"=>false, "error"=>"File does not exist");
		}
	}
	
	
	public function render(){
		$db = $this->db;
		$smarty = $this->smarty;
		$smarty->assign("files", $this->listAllUploads($_SESSION["userid"]));
		$this->syncUserInfo();
		
		$user = $this->getUser();
		$voice_path = $user["voice_path"];
		if ($voice_path != "") {
			if( substr($voice_path, 0, 7) == 'uploads' ){
				$smarty->assign("full_path", false);
			}else{
				$smarty->assign("full_path", true);
			}
		}else{
			$smarty->assign("full_path", false);
		}
		$smarty->assign("host", TEST ? 'http://'.$_SERVER['HTTP_HOST'] : 'http://www.remotestaff.com.au'); //force iframe src of vr to use non-https
		$this->setActive("resume_active");
		$this->setActive("file_active");
		$smarty->display("files.tpl");
		
	}
	
	
	/**
	 * Sync Recording
	 */
	public function recordVoice(){
		$db = $this->db;
		$userid = $_SESSION["userid"];
		$voice = "";
		$site = TEST ? 'test' : 'prod';
		if( isset($_POST['action']) && $_POST['action'] == 'upload' ){
			$result = file_get_contents("http://vps01.remotestaff.biz:5080/remote/user_stream.jsp?cid=".$userid."js&site=".$site);
			$result = json_encode($result);
			$result = preg_replace('/[\\\n|\\\"|\[|\]]*/', "", $result);
			//$raw_array = str_replace("\n", "", $raw_array);
			$raw_array = explode(',', $result);
			$audio_loc = count($raw_array)>2 && ($raw_array[2] != 'default') ? $raw_array[2] : 'root';
			if( count($raw_array) > 1 && (int)$raw_array[1] > 0 ) {
				if($audio_loc == 'root') $voice="http://vps01.remotestaff.biz:5080/remote/audio/".$raw_array[0];
				else $voice="http://vps01.remotestaff.biz:5080/remote/audio/$audio_loc/".$raw_array[0];
				$db->update("personal", array("voice_path"=>$voice), $db->quoteInto("userid = ?", $userid));
				file_get_contents("http://vps01.remotestaff.biz:5080/remote/voice_conv_caller.jsp?cid=".$userid."&loc=".$audio_loc);
			}
			$data = array();
//			$db->delete("remote_ready_criteria_entries", "userid = ".$userid." AND remote_ready_criteria_id = 2");
			$data["userid"] = $userid;
			$data["remote_ready_criteria_id"] = 2;
			$data["date_created"] = date("Y-m-d h:i:s");
//			$db->insert("remote_ready_criteria_entries", $data);
			
			
						
			global $base_api_url;
			
			file_get_contents($base_api_url . "/mongo-index/sync-candidates-files/?userid=" . $userid);
			
			
			return array("success"=>true,);
		}else{
			return array("success"=>false);
		}
	}
}

