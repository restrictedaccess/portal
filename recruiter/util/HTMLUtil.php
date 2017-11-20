<?php
class HTMLUtil{
	public function extractText($document){
		$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[/!]*?[^<>]*?>'si",          // Strip out HTML tags 
                 "'([rn])[s]+'",                // Strip out white space 
                 "'&(quot|#34);'i",                // Replace HTML entities 
                 "'&(amp|#38);'i", 
                 "'&(lt|#60);'i", 
                 "'&(gt|#62);'i", 
                 "'&(nbsp|#160);'i", 
                 "'&(iexcl|#161);'i", 
                 "'&(cent|#162);'i", 
                 "'&(pound|#163);'i", 
                 "'&(copy|#169);'i", 
                 "'&#(d+);'e");                    // evaluate as php 

		$replace = array ("",
			                 "", 
			                 "\1", 
			                 "\"", 
			                 "&", 
			                 "<", 
			                 ">", 
			                 " ", 
		chr(161),
		chr(162),
		chr(163),
		chr(169),
			                 "chr(\1)"); 
			
		$text = preg_replace($search, $replace, $document);
		return $text;
	}

	public function createVoiceFile($tmpName, $sound, $soundsize, $soundtype, $path, $userid){
		global $db;
		$uploadDir = $path."uploads/voice/";
		if($sound <> '')
		{
			$transaction_status = true;
			if($soundtype=="audio/x-ms-wma")
			{
				$soundtype=".wma";
			}
			elseif($soundtype=="audio/wav")
			{
				$soundtype=".wav";
			}
			elseif($soundtype=="audio/mpeg")
			{
				$soundtype=".mp3";
			}
			elseif($soundtype=="application/octet-stream")
			{
				$soundtype=".mp3";
			} else if ($soundtype=="audio/mp3"){
				$soundtype=".mp3";
			}
			else
			{
				$transaction_status = false;
			}

			if($transaction_status)
			{
				$result= move_uploaded_file($tmpName, $uploadDir.$userid.$soundtype);
				if (!$result)
				{
					$transaction_status = false;
				}
				else
				{
					$voice_path = "uploads/voice/".$userid.$soundtype;
					$data = array('voice_path' => $voice_path);
					$where = "userid = ".$userid;
					$db->update('personal' , $data , $where);
					if (($soundtype==".wma")||($soundtype==".wav")){
						$this->convert_to_mp3($userid, $path);
					}
				}
			}
		}
		return $transaction_status;

	}
	
	function convert_to_mp3($userid, $directory) {
        global $db;
        $sql = $db->select()
                ->from('personal', 'voice_path')
                ->where('userid = ?', $userid);
        $voice_path = $db->fetchOne($sql);
        $directory = dirname($directory);
        

        if ($voice_path == False) {
            return False;
        }

        if (file_exists("../".$voice_path)) {
            //check file type, extra steps for the wma since debian doesn't support directly converting wma to mp3
            $voice_parts = pathinfo($voice_path);
         $voice_path = "../".$voice_path;           
            if ((strtolower($voice_parts['extension']) == 'wma')) {
                $output = "../uploads/voice/$userid.wav";
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
            $output = "../uploads/voice/$userid.mp3";
            if (file_exists($output)){
            	unlink($output);
            }
            $sh = "lame -b 192 -h --silent {$voice_path} {$output}";
            //echo $sh;
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
    
    function convert_mp3($userid, $directory){
    	 global $db;
        $sql = $db->select()
                ->from('personal', 'voice_path')
                ->where('userid = ?', $userid);
        $voice_path = $db->fetchOne($sql);
        

        if ($voice_path == False) {
            return False;
        }

        if (file_exists($directory.$voice_path)) {
            //check file type, extra steps for the wma since debian doesn't support directly converting wma to mp3
            $voice_parts = pathinfo($voice_path);
         $voice_path = $directory.$voice_path;           
            if ((strtolower($voice_parts['extension']) == 'wma')) {
                $output = $directory."uploads/voice/$userid.wav";
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
            $output = $directory."uploads/voice/$userid.mp3";
            if (file_exists($output)){
            	unlink($output);
            }
            $sh = "lame -b 192 -h --silent {$voice_path} {$output}";
            //echo $sh;
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
    
    function convert($userid, $directory) {
        global $db;
        $sql = $db->select()
                ->from('personal', 'voice_path')
                ->where('userid = ?', $userid);
        $voice_path = $db->fetchOne($sql);
        $directory = dirname($directory);
        

        if ($voice_path == False) {
            return False;
        }
        
        if (file_exists($voice_path)) {
            //check file type, extra steps for the wma since debian doesn't support directly converting wma to mp3
            $voice_parts = pathinfo($voice_path);
            $voice_path = $voice_path;
            if (strtolower($voice_parts['extension']) == 'wma') {
                $output = "uploads/voice/$userid.wav";
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
            $output = "uploads/voice/$userid.mp3";
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
    
    
}