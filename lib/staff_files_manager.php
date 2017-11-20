<?php
//  - 2011-02-24  Roy Pepito <roy.pepito@remotestaff.com.au>
//  - Object for retrieving, adding, deleting and updating staff files

class staff_files_manager 
{
  //START: construction
    function __construct($path, $userid) 
  {
  	global $db;
    include($path.'conf/zend_smarty_conf.php');
    $this->path = $path;
        $this->userid = $userid;
        $this->db = $db;
    $this->photos_location = 'uploads/pics/'; 
    $this->voice_location = 'uploads/voice/'; 
    $this->resume_location = 'applicants_files/';
    $this->applicants_files = 'applicants_files/';
    }
  //ENDED: construction


  //START: staff photo
    //start: add photo
    public function add_photo($tmpName, $img, $imgsize, $imgtype) 
    {
      $uploadDir = $this->photos_location; 
      if($img <> '')
      {
        if($imgtype=="image/pjpeg") 
        { 
          $imgtype=".jpg"; 
        } 
        elseif($imgtype=="image/jpeg") 
        { 
          $imgtype=".jpg"; 
        } 
        elseif($imgtype=="image/gif") 
        { 
          $imgtype=".gif"; 
        } 
        elseif($imgtype=="image/png") 
        { 
          $imgtype=".png"; 
        } 
        else 
        { 
          $transaction_status = false;
          $img = '';
        } 
      }
      if ($img <> '')
      {
        $result = move_uploaded_file($tmpName, $this->path.$this->photos_location.$this->userid.$imgtype); 
        if (!$result) 
        { 
          $transaction_status = false;
          //$where = "userid = ".$this->userid;  
          //$this->db->delete('users', $where);
        } 
        else 
        { 
          $transaction_status = true;
          $image=$uploadDir.$this->userid.$imgtype;
          
          $data = array('image' => $image);
          $where = "userid = ".$this->userid;
          $this->db->update('personal' , $data , $where);
        } 
      }
      else
      {
        $transaction_status = false;
      }
      return $transaction_status;
    }
    //ended: add photo
    
    //start: retrieve photo medium
    public function retrieve_photo() 
    {
      $sql=$this->db->select()
        ->from('personal', array("image"))
        ->where('userid = ?', $this->userid);
      $voice = $this->db->fetchRow($sql);
      $image = $voice['image'];
      if (!empty($image))
      {
        $filename = $this->path.$image;
		if (TEST){
			 $filename = "http://devs.remotestaff.com.au/portal/".$image;
		} else if(STAGING){
            $filename = "http://staging.remotestaff.com.au/portal/".$image;
        }else{
			 $filename = "https://remotestaff.com.au/portal/".$image;
		}
		
		$file_headers = @file_exists($filename);
//		if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
		if($file_headers) {
			$exists = false;
		}
		else {
			$exists = true;
		}
        if($exists) 
        {
          $staff_photo = "<img border=0 src='$filename' width=100 height=100>";
        }
        else 
        {
          $staff_photo = "<img border=0 src='/portal/images/Client.png' width=100 height=100>";
        }
      }
      else
      {
        $staff_photo = "<img border=0 src='/portal/images/Client.png' width=100 height=100>";
      }
      return $staff_photo;
    }
    //ended: retrieve photo medium
    
    //start: retrieve photo small
    public function retrieve_photo_small() 
    {
      $sql=$this->db->select()
        ->from('personal', array("image"))
        ->where('userid = ?', $this->userid);
      $voice = $this->db->fetchRow($sql);      
      $image = $voice['image'];      
      if ($image <> '')
      {
        $filename = $this->path.$image;
        if(file_exists($filename)) 
        {
          $staff_photo = "<img border=0 src='$filename' width=40 height=40>";
        }
        else 
        {
          $staff_photo = "<img border=0 src='".$this->path."images/Client.jpg' width=40 height=40>";
        }
      }
      else
      {
        $staff_photo = "<img border=0 src='".$this->path."images/Client.png' width=40 height=40>";
      }
      return $staff_photo;
    }
    //ended: retrieve photo  small  
    
    //start: delete photo
    public function delete_photo() 
    {
    }
    //ended: ended photo
  //ENDED: staff photo


  //START: staff voice file
    //start: add voice file
    public function add_voice_file($tmpName, $sound, $soundsize, $soundtype) 
    {
      $uploadDir = $this->path.$this->voice_location; 
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
          $result= move_uploaded_file($tmpName, $uploadDir.$this->userid.$soundtype); 
          if (!$result) 
          { 
            $transaction_status = false;
          } 
          else 
          {
            $voice_path = $this->voice_location.$this->userid.$soundtype;
            $data = array('voice_path' => $voice_path);
            $where = "userid = ".$this->userid;
            $this->db->update('personal' , $data , $where);          
          } 
        }
      }
      return $transaction_status;
    }  
    //ended: add voice file
    
    //start: retrieve voice file
    public function retrieve_voice_file() 
    {
      $sql=$this->db->select()
        ->from('personal', array("voice_path"))
        ->where('userid = ?', $this->userid);
      $voice = $this->db->fetchRow($sql);      
      $voice_path = $voice['voice_path'];
      if ($voice_path <> "") 
      { 
		  $voice_path = $voice['voice_path'];
		  if ($voice_path <> "") 
		  { 
			//$voice_file_type = substr(strrchr($this->path.$voice_path,'.'),1);
			$voice_file_type = strtolower(str_replace(".", "", strrchr($this->path.$voice_path, "."))); //2012-10-30 @mike
			
			if($voice_file_type == "mp3")
			{
				$voice_file = "
				<object type=\"application/x-shockwave-flash\" data=\"../../audio_player/player_mp3_maxi.swf\" width=\"128\" height=\"28\">
				<param name=\"movie\" value=\"../../audio_player/player_mp3_maxi.swf\" />
				<param name=\"FlashVars\" value=\"mp3=".$this->path.$voice_path."\" />
				</object><br /><a href=\"".$this->path.$voice_path."\">Download</a>";
			} elseif($voice_file_type == "flv") { // 2012-10-30 @mike
			  $voice_file = "
				<object type=\"application/x-shockwave-flash\" data=\"../../audio_player/player_flv_maxi.swf\" width=\"128\" height=\"28\">
				<param name=\"movie\" value=\"../../audio_player/player_flv_maxi.swf\" />
				<param name=\"allowScriptAccess\" value=\"always\" />
				<param name=\"FlashVars\" value=\"flv=".$voice_path."\" />
				</object><br /><a href=\"".$voice_path."\">Download</a>";
			  
			} else
			{
				//$voice_file = "<embed width=\"128\" height=\"28\" src=\"".$this->path.$voice_path."\" controls=\"controls\" autostart=\"false\">
				//</embed><br /><a href=\"".$this->path.$voice_path."\">Download</a>";
				$voice_file = "<a href=\"".$this->path.$voice_path."\">Download</a>";
			}
		  }
			return $voice_file;	  
      }      
    }
    //ended: retrieve voice file
    
    //start: remove voice file
    public function delete_voice_file()
    {
      $sql=$this->db->select()
        ->from('personal', array("voice_path"))
        ->where('userid = ?', $this->userid);
      $voice = $this->db->fetchRow($sql);      
      $voice_path = $voice['voice_path'];      
      unlink($this->path.$voice_path);
      $data = array('voice_path' => '');
      $where = "userid = ".$this->userid;
      $this->db->update('personal' , $data , $where);   
    }
    //ended: remove voice file
  //ENDED: staff voice file
  
  
  //START: staff resume
    //start: add resume
    public function add_resume($tmpName, $resume) 
    {
      $uploadDir = $this->path.$this->resume_location; 
      if(basename($resume) <> NULL || basename($resume) <> "")
      {
        $file_description = "Resume";
        $date_created = date("Y-m-d");
        $name = $this->userid."_".basename($resume);
        
        $name = str_replace(" ", "_", $name);
        $name = str_replace("'", "", $name);
        $name = str_replace("-", "_", $name);
        $name = str_replace("php", "php.txt", $name);
        
        $file = $uploadDir.$this->userid."_".basename($resume);
        $file = str_replace(" ", "_", $file);
        $file = str_replace("'", "", $file);
        $file = str_replace("-", "_", $file);        
        $file = str_replace("php", "php.txt", $file);
        if (move_uploaded_file($tmpName,$file)) 
        {
          $transaction_status = true;
          $data= array(
            'userid' => $this->userid,
            'file_description' => $file_description ,
            'name' => $name, 
            'date_created' => $date_created
          );
          $this->db->insert('tb_applicant_files', $data);  
        
          $filename_ = $uploadDir.$this->userid."_".basename($resume);
          $filename_ = str_replace(" ", "_", $filename_);
          $filename_ = str_replace("'", "", $filename_);
          $filename_ = str_replace("-", "_", $filename_);  
          $filename_ = str_replace("php", "php.txt", $filename_);                
          $file_p = pathinfo($filename_);
          extract(pathinfo($filename_));
          chmod($filename_, 0777);
        }
        else
        {
          $transaction_status = false;
        }
      }
      else
      {
        $transaction_status = false;
      }
      return $transaction_status;
    }  
    //ended: add resume
    
    //start: retrieve resume
    public function retrieve_resume() 
    {
    }
    //ended: retrieve resume
    
    //start: delete resume
    public function delete_resume() 
    {
    }
    //ended: delete resume
  //ENDED: staff resume
  
  
  //START: staff other files
    //start: add other files
    public function add_other_files($tmpName, $other_file, $file_description) 
    {
      $uploadDir = $this->path.$this->applicants_files; 
      if(basename($other_file) <> NULL || basename($other_file) <> "")
      {
        
        $file_description = $file_description;
        $date_created = date("Y-m-d");
        $name = $this->userid."_".basename($other_file);
        
        $name = str_replace(" ", "_", $name);
        $name = str_replace("'", "", $name);
        $name = str_replace("-", "_", $name);
        $name = str_replace("php", "php.txt", $name);
        
        $file = $uploadDir.$this->userid."_".basename($other_file);
        $file = str_replace(" ", "_", $file);
        $file = str_replace("'", "", $file);
        $file = str_replace("-", "_", $file);        
        $file = str_replace("php", "php.txt", $file);
        if (move_uploaded_file($tmpName,$file)) 
        {
          $transaction_status = true;
          $data= array(
            'userid' => $this->userid,
            'file_description' => $file_description ,
            'name' => $name, 
            'date_created' => $date_created
          );
          $this->db->insert('tb_applicant_files', $data);  
        
          $filename_ = $uploadDir.$this->userid."_".basename($resume);
          $filename_ = str_replace(" ", "_", $filename_);
          $filename_ = str_replace("'", "", $filename_);
          $filename_ = str_replace("-", "_", $filename_);  
          $filename_ = str_replace("php", "php.txt", $filename_);                
          $file_p = pathinfo($filename_);
          extract(pathinfo($filename_));
          chmod($filename_, 0777);
        }
        else
        {
          $transaction_status = false;
        }
        
      }
      else
      {
        $transaction_status = false;
      }
      return $transaction_status;
    }  
    //ended: add other files
    
    //start: retrieve other files
    public function retrieve_other_files() 
    {
    }
    //ended: retrieve other files
    
    //start: delete other files
    public function delete_other_files() 
    {
    }
    //ended: delete other files
  //ENDED: staff other files  
}
?>
