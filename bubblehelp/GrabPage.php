<?php
session_start();
class GrabPage {
    
    private $current_url = '';
    private $cachedir = 'cache/';
	private $table = 'bubble_help';
    private static $instance = NULL;
    private $db = NULL;
	//private $admin_allowed = array('ricag@remotestaff.com.au', 'rs.admin2@gmail.com', 'devs@remotestaff.com.au');
    public function get_instance() {
        
    }
    
    public function __construct($access_db = true, $cachedir = '') {
        if ($cachedir !== '') {
			if (!is_dir($cachedir) or !is_writable($cachedir)) {
				throw new Exception('Cache directory must be a valid writeable directory.');	
			}
			$this->cachedir = $cachedir;
		} else {
			$uid = !empty($_SESSION['admin_id']) ? $_SESSION['admin_id'] : ( !empty($_SESSION['client_id']) ? $_SESSION['client_id'] :
				( !empty($_SESSION['userid']) ? $_SESSION['userid'] : 0) );
		
			if( $uid > 0 ) $this->cachedir = $this->cachedir . $uid . '/';
			else {
				header('Location: /portal/');
				exit;
			}
		}

        if( !is_dir($this->cachedir) ) {
            mkdir( $this->cachedir, 0755 );
            $handle = fopen( $this->cachedir ."index.html", 'x+' );
            fclose( $handle );
        }

		if( $access_db && $this->db === null ) {
			include "../conf/zend_smarty_conf.php";
			$this->db = $db;
			//var_dump($this->db);
		}
    }
    
    public function set($fname, $data) {
        
        $file = $this->cachedir . $fname;
		if (!file_exists($file))	{
			//unlink($file);
		//}
		// write data to cache
            if (!file_put_contents($file, $data))
            {
                throw new Exception('Error writing data to cache file.');
            }
        }
        
    }
    
    public function get($fname) {
        $file = glob($this->cachedir . $fname);
        $file = array_shift($file);
		if (!$data = file_get_contents($file))
		{
			throw new Exception('Error reading data from cache file.');
		}
		return $data;
    }
	
	public function admin_get() {
		$result = false;
		
		if( !empty($_SESSION['emailaddr']) ) {
			$query = "SELECT admin_id FROM admin WHERE admin_email='".$_SESSION['emailaddr']."' AND status='FULL-CONTROL'";
			//$query = "SELECT status FROM admin WHERE admin_email='rs.admin2@gmail.com'";
			$result = $this->db->fetchOne($query);
		}
		
		echo json_encode( array('result' => $result) );
		
	}
	
	public function fetch_data() {
		$href = isset($_POST['href']) ? $_POST['href'] : ( $_GET['href'] ? : $_GET['href']);
		
		$query = "SELECT content FROM $this->table WHERE link='$href'";
		
		$result = $this->db->fetchOne($query);

		echo json_encode( array('result' => $result) );
	}
	
	public function set_data($data = array()) {
		$help_content = isset($_POST['help_content']) ? $_POST['help_content'] : $_GET['help_content'];
		$link_id = isset($_POST['link_id']) ? $_POST['link_id'] : $_GET['link_id'];
		$item = isset($_POST['item']) ? $_POST['item'] : $_GET['item'];
		
		if( !empty($_SESSION['emailaddr']) ) {
			$admin_email = $_SESSION['emailaddr'];
		} else {
			/*$url = '/portal/bubblehelp/bh_login.php?curl='.$script_pathname.'&email='.$_SESSION['emailaddr'];
			echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
			echo 'window.parent.bubbletip.redirectLogin("'.$url.'");';
			echo "</script></head><body></body></html>";
			exit;*/
		}
		
		$help_content = trim($help_content);
		
		$result = '';
		
		if( $help_content == "") {
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
            echo 'window.parent.alert("Please fill up the help content box!");';
            echo "</script></head><body></body></html>";
            exit;
        }
		//$help_content = str_replace("\n", " ", $help_content);
		//$help_content = str_replace("\r", " ", $help_content);
		//$help_content = preg_replace('!\s+!', ' ', $help_content);
		$phrases = explode("\n", $help_content);
		$ctr = 0;
		$str_array = array();
		foreach( $phrases as $words ) {
			$words = preg_replace('!\s+!', ' ', $words);
			$line = '';
			if( strlen($words) > 45 ) {
				$strings = explode(" ", $words);
				for( $i=0, $len=count($strings); $i<$len; $i++ ) {
					if( strlen( $line .' '. $strings[$i])  < 45 ) {
						$line = $line .' '. $strings[$i];
					} else {
						$str_array[$ctr++] = $line;
						$line = $strings[$i];
					}
					if( $i == count($strings)-1 ) $str_array[$ctr++] = $line;
				}
				
			} else {
				$str_array[$ctr++] = $words;
			}
			/*$str = trim($str_array[$ctr] .' '. $word);
			if( strlen( trim($str_array[$ctr] .' '. $word) ) > 45 ) {
				$str_array[$ctr] = trim($str_array[$ctr]);
				$ctr++;
			}
			*/
			//$str_array[$ctr] .= ' '. $word;
			
			/*if( strlen( trim($str_array[$ctr] .' '. $word) ) < 46 ) {
				$str_array[$ctr] .= ' '. $word;
			} else {
				$ctr++;
				$str_array[$ctr] .= ' '. $word;
			}*/
			
		}
		
		$help_content = implode("\r\n", $str_array);
		
		try {
			//$help_content = addslashes($help_content);
			
			switch($item) {
				case 'new':
					$data_array = array('content' => $help_content, 'link' => $link_id, 'date_updated' => time(), 'admin_email' => $admin_email);
					$this->db->insert($this->table,  $data_array);
					//$insert = "INSERT INTO ".$this->table. " (admin_email, link, content, date_updated)
					//VALUES ('$admin_email', '$link_id', '$help_content', unix_timestamp())";
					//$this->db->query($insert);
					break;
				case 'update':
					$data_array = array('content' => $help_content, 'date_updated' => time(), 'admin_email' => $admin_email);
					$this->db->update($this->table, $data_array, "link='$link_id'");
					break;
			}
			//$this->db->insert($this->table, $data_array);
		} catch (Exception $e){
			$result = $e->getMessage();
		}
		echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
        echo 'window.parent.bubbletip.createResult("'.$result.'");';
        echo "</script></head><body></body></html>";
        exit;
		//return $this->db->lastInsertId($this->table);	
	}
    
    private function init_replace($fname) {
		$fname = $this->cachedir . $fname;
        $tmpfile = $this->cachedir . 'tempfile';
		
		//if( in_array($_SESSION['emailaddr'], $this->admin_allowed) ) $su = 1;
		//else $su = 0;
        
        $s_body = "<\/body>";
        $r_body = "<script type=\\\"text\/javascript\\\" language=\\\"javascript\\\" src=\\\"\/portal\/bubblehelp\/js\/script.js\\\"><\/script>\\n"
			."<script type=\\\"text\/javascript\\\" language=\\\"javascript\\\" src=\\\"\/portal\/bubblehelp\/js\/pullmenu.js\\\"><\/script>\\n<\/body>";
		
		//$s_head = "<\/head>";
		$s_body_tag = "<body\(.*\)>";
        $r_head = "<link rel=stylesheet type=\\\"text\/css\\\" href=\\\"\/portal\/bubblehelp\/pullmenu.css\\\" \/>\\n<\/head>";
		//$r_head = "<link rel=stylesheet type=\\\"text\/css\\\" src=\\\"bubblehelp\/styles.css\\\" \/>\\n<\/head>";
		
		$submit_find = "<input[^>]*type=\([\'|\\\"]\\\\?\)submit\([\'|\\\"]\\\\?\)";
		$button_find = "<input[^>]*type=\([\'|\\\"]\\\\?\)button\([\'|\\\"]\\\\?\)";
		
		$new_btn = "<input\ type=\\\"button\\\" style=\\\"cursor:pointer\\\" onclick=\\\"alert\('disabled');return false;\\\" onmouseout=\\\"\\\""
		. " oncontextmenu=\\\"return false;\\\"";
		
		$span_find = "<span id=\\\"\([a-zA-Z|0-9|\_|\-]*\)\\\"\(.*\)onclick=\(.*\)>\(.*\)<\/span>";
		
		
		$r_onclick = "onclick=\\\"return bubbletip\.show\(this);\\\" onmouseout=\\\"bubbletip.hide\(\);\\\""
		. " oncontextmenu=\\\"showContextMenu\(this\);return false;\\\"";
		
        //$output = passthru("sed -e 's/$s_body/$r_body/g' -e '/<head>/r styles.css' -e 's/$s_head/$r_head/g' -e 's/alertchat/void/g' -e 's/target=\"_blank\"//g' $fname > $tmpfile");
		//$output = passthru("sed -e 's/$s_body/$r_body/g' -e '/<head>/r styles.css' -e '/<body\(.*\)>/r bdiv.html' -e 's/alertchat/void/g' -e 's/target=\"_blank\"//g' $fname > $tmpfile");
		$output = passthru("sed -e 's/$s_body/$r_body/g' -e '/<head>/r styles.css' -e '/<body\(.*\)>/r bdiv.html' -e 's/alertchat/void/g' "
						   ."-e 's/target=\"_blank\"//g' -e \"s/$button_find/$new_btn/g\" -e \"s/$submit_find/$new_btn/g\" "
						   ."-e 's/<title>\(.*\)<\/title>/<title>\\1 (Help Page)<\/title>/g' "
						   ."-e 's/$span_find/<a\ href=\\\"\\1\\\" $r_onclick>\\4<\/a>/g' $fname > $tmpfile");
        
        $tmpfile2 = $this->cachedir . 'tempfile2';
		
        //$link_find = "a\ href=[\'\|\\\"]\\\?[a-zA-Z|0-9|\.\/\?\_|\=|\ \&\-]*[\'\|\\\"]\\\?";
		$link_find = "a\ href=\([\'|\\\"]\\\\?\)\([a-zA-Z|0-9|\.\,\:\@\;\(\)\'\/\?\_|\=|\ \&\#\-]*\)\([\'|\\\"]\\\\?\)";
		
		//$link_replace = "a\ href=\\\"#\\\"";
		
		//$new_href = "a\ href=\\\"#\\\" onclick=\\\"bubbletip\.show\('Lorem ipsum dolor sit amet, consectetur adipiscing elit. '\);\\\" onmouseout=\\\"bubbletip.hide\(\);\\\"";
		
		
		$new_href_2 = "a\ href=\\\"\\2\\\" style=\\\"cursor:pointer\\\" $r_onclick";
		
		
		//---$output = passthru("sed -e \"s/$link_find/$new_href_2/g\" $tmpfile > $fname");
		
		
		// check the static page if mochikit lib declared
		$out = passthru("grep -i 'mochikit' $tmpfile > dummy", $result);
		
		if( $result ) {
			$output = passthru("sed -e \"s/$link_find/$new_href_2/g\" $tmpfile > $tmpfile2");
			passthru("sed -e 's/<\/head>/<script language=javascript src=\\\"\/portal\/js\/MochiKit\.js\\\"><\/script>\\n<\/head>/g' $tmpfile2 > $fname" );
		} else {
			$output = passthru("sed -e \"s/$link_find/$new_href_2/g\" $tmpfile > $fname");
		}
		
		
		
		 /*sed -e "s/<input[^>]*type=\([\'\"]\\?\)submit\([\'\"]\\?\)/\
							 <input type=\"\button\" style=\"cursor:pointer\"
		 onclick=\"return tooltip\.show\(this);\" onmouseout=\"tooltip.hide\(\);\"
		 oncontextmenu=\"javascript:showContextMenu\(this\);return false;\"/g" adminHome.php.html |more*/

    }
    
    public function create_page($curl = '') {
        //$current_url = isset($_GET['curl']) ? $_GET['curl'] : ($curl ? : 'adminHome.php');
		$url = explode('&curl=', $_SERVER['QUERY_STRING'], 2);
		$current_url = $url[1];
		$current_url = preg_replace('/%27/', '', $current_url);
		
		$filepath = explode('?', $current_url);
		
		if( !empty($filepath[1]) ) {
			$pairval = explode('&', $filepath[1]);
			
			for( $i=0, $cnt=count($pairval); $i < $cnt; $i++) {
				$pairval[$i] = preg_replace_callback("/^(.*)\=(.*)$/", function($match) {
					return $match[1].'='.urlencode($match[2]);
					}, $pairval[$i]);
				}
			
			$qrystring =  implode('&', $pairval);
		}
		//$script_pathname = $filepath[1] ? $filepath[1] .'?'.$filepath[0] : $filepath[0];
		$script_pathname = $qrystring ? $filepath[0] .'?'. $qrystring : $filepath[0];
		$script_pathname = preg_replace('/\s+/', '', $script_pathname);
		$script_pathname = preg_replace('/\,/', '', $script_pathname);
		$script_pathname = preg_replace('/;/', '', $script_pathname);
		$script_pathname = preg_replace('/\)/', '', $script_pathname);
		
		/* 2013-03-21 - this causes page not to load the url with numbers (ex. leads_id=123) */
		//$script_pathname = preg_replace('/(\d+)$/', '', $script_pathname);

		$urlDomain = explode('.', $_SERVER['HTTP_HOST']);
		
		if( in_array('test', $urlDomain) ) {
			$hostname = 'http://test.remotestaff.com.au';
		} else {
			$hostname = 'https://remotestaff.com.au';
		}
		
        $loginUrl = $hostname.'/portal/index.php'; //action from the login form
        
        $remotePageUrl = $hostname.'/portal/'.$script_pathname;//$current_url; ///portal/adminHome.php'; //url of the page you want to save
		
		//get the filename 2-10-12
		$filename = $this->prepare_filename($current_url);
		
		if( !isset($_SESSION['bh_login']) || ($_SESSION['bh_login'] !=  $_SESSION['emailaddr']) ) {
			
			if( isset($_POST['emailaddr']) ) {
				$emailaddr = $_POST['emailaddr'];
				$logintype = $_POST['login_type'];
				
				$loginFields = array('email' => $emailaddr, 'password' => $_POST['password'], 'login_type' => $logintype); //login form field names and values
			
				$login = $this->getUrl($loginUrl, 'post', $loginFields, $emailaddr); //$_SESSION['emailaddr']); //login to the site
				
				// save the session email
				$_SESSION['emailaddr'] = $emailaddr;
				$_SESSION['logintype'] = $logintype;
			} else {
				// remove the existing file if any (2/10/12)
				// reset all cache files (2/4/13)
				$tmpfiles = glob($this->cachedir.'*');// . $filename;
				foreach($tmpfiles as $file){ // iterate files
					if(is_file($file))
						unlink($file); // delete file
				}
					
				//echo "<script language='javascript'>alert('login page!');</script>";
				// show login page
				header('Location: /portal/bubblehelp/bh_login.php?curl='.$script_pathname.'&email='.$_SESSION['emailaddr']);
				exit;
			}
		}
		
        $remotePage = $this->getUrl($remotePageUrl); //get the remote page
        // save the html page
		//2-10-12 $filename = $this->prepare_filename($current_url); //$filepath[ count($filepath)-1 ];// . '.html';
			
		// get only the html content
		$static = explode("<!DOCTYPE", $remotePage);

		// match any redirected url
		if(preg_match('#location: (.*)#', $static[0], $m)) {
			$this->set($filename.'.loc', $m[1]);
		}

        if( !empty($static[1]) ) {
			$this->set($filename, "<!DOCTYPE".$static[1]);
		} else {
			$static = explode("<html>", $remotePage);
			$this->set($filename, "<html>".$static[1]);
		}
		
		// this will do the manipulation of the content
		$this->init_replace($filename);

		// load the page
		header('Location: /portal/view_bh.php?view='.$current_url);
        exit;
        
    }
	
	public function prepare_filename($fname) {
		$querystr = explode('?', $fname);
		
		$fname = preg_replace('/\//', '_fs_', $querystr[0]);
		
		$qrystr = preg_replace('/\s+/', '_sp_', $querystr[1]);
		$qrystr = preg_replace('/\%20/', '_sp_', $qrystr);
		$qrystr = preg_replace('/\&/', '_as_', $qrystr);
		$qrystr = preg_replace('/\=/', '_eq_', $qrystr);
		$qrystr = preg_replace('/\//', '_fs_', $qrystr);
		$qrystr = preg_replace('/_amp_/', '_as_', $qrystr);
		$qrystr = preg_replace('/\,/', '', $qrystr);
		$qrystr = preg_replace('/;/', '', $qrystr);
		$qrystr = preg_replace('/\)/', '', $qrystr);
		return $qrystr ? $qrystr .'_qm_'.$fname : $fname;
	}
    
    private function getUrl($url, $method='', $vars='', $email = '') {
		$cookieFile = "cookies.txt";
		$newcookie = 0;
		if( !file_exists($cookieFile) ) {
			$fh = fopen($cookieFile, "w");
			//fwrite($fh, "");
			fclose($fh);
			$newcookie = 1;
		}
		
        $ch = curl_init();
        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
			
			$_SESSION['bh_login'] = $email;
        }// else {
		//	curl_setopt($ch, CURLOPT_COOKIEJAR, "-");
		//}
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$user_agent = "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.9) Gecko/20121003 Firefox/x.x";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		//curl_setopt($ch, CURL_COOKIEFILE, '');
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
		if( $newcookie ) curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
		else curl_setopt($ch, CURLOPT_COOKIEJAR, "-");
		
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		
		//curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/remotestaff.pem");


        $buffer = curl_exec($ch);
		
        if($buffer == false) {
			echo'Warning : ' . curl_error($ch);
			curl_close($ch);
			return false;
        } else {
			curl_close($ch);
			return $buffer;
		}
	}
	
}

//echo curl_grab_page("http://test.remotestaff.com.au/portal", "http://test.remotestaff.com.au", "email=rs.admin2@gmail.com&password=remote123&login_type=admin", "true",  "null", "false");

?>