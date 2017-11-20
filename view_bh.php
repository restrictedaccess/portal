<?php
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('display_errors', TRUE);
	session_start();
	
	//$viewfile = isset($_GET['view']) ? $_GET['view'] : 'adminHome.php';
	$url = explode('view=', $_SERVER['QUERY_STRING'], 2);
	$viewfile = $url[1];
		
	$script_path =  explode('portal', $_SERVER['SCRIPT_FILENAME']);
	
	$rootdir = $script_path[0];
	
	include_once $rootdir.'portal/bubblehelp/GrabPage.php';
	
	$cachedir = $rootdir . 'portal/bubblehelp/cache/';
	
	$uid = !empty($_SESSION['admin_id']) ? $_SESSION['admin_id'] : ( !empty($_SESSION['client_id']) ? $_SESSION['client_id'] :
				( !empty($_SESSION['userid']) ? $_SESSION['userid'] : 0) );
		
	if( $uid > 0 ) $cachedir = $cachedir . $uid . '/';
		
	$cont = new GrabPage(false, $cachedir);
	
	//$filename = $this->prepare_filename($current_url); 
	//echo '<h3>Loading '.$viewfile.' - '.$filename.'</h3>';
	//echo '<br/>--'.$viewfile.' - '.session_id();
	//sleep(100);
	//echo "<script language='javascript'>alert('". $_SESSION['bh_login'] ." - ". $_SESSION['emailaddr']."');</script>";
    
	if ($viewfile !== '') {
		$filename = $cont->prepare_filename($viewfile);
		
		$dirpath = explode('/', $viewfile);
		
		$dir_cnt = count($dirpath);
		
		$cachedfile = $cachedir . $filename ;
		
		$curr_dir = basename(__DIR__);
		
		$dir_array = array();
		foreach( $dirpath as $entry ) {
			array_push($dir_array, $entry);
			$dirs = implode('/', $dir_array);
			
			if( (!file_exists($dirs) && $dirs != $curr_dir) || is_file($dirs) ) {
				unset($dir_array[ count($dir_array)-1 ]);
				break;
			}
		}

		//---unset($dirpath[ count($dirpath)-1 ]);
		//---$child_dir = $dirpath[ count($dirpath) - 1];
		$child_dir = $dir_array[ count($dir_array) - 1];

		if( $dir_cnt > 1 && $curr_dir != $child_dir ) {
			
			$viewer_copy = file_get_contents("view_bh.php");

			//$viewer = implode('/', $dirpath) . '/view_bh.php';
			$viewer = implode('/', $dir_array) . '/view_bh.php';

			//if( !file_exists($viewer) ) {
				if (!file_put_contents($viewer, $viewer_copy))
					throw new Exception('Error writing data to viewer file.');
			//}			
			//header('Location: /portal/'.implode('/', $dirpath).'/view_bh.php?view='.$viewfile);
			header('Location: /portal/'.$viewer.'?view='.$viewfile);
			//header('Location: /portal/'.$dirpath[0].'/view_bh.php?view='.$viewfile);
			exit;
		} else {
		
			// check first if theres a location file
			$locfile = $cachedfile.'.loc';
			if( file_exists($locfile) ) {
				$locstr = file_get_contents($locfile);
				
				$filepath = explode('/', $locstr);
				
				$fpath_cnt = count($filepath);
				
				$dir_array = array();
				foreach( $filepath as $entry ) {
					array_push($dir_array, $entry);
					$dirs = implode('/', $dir_array);
					if( (!file_exists($dirs) && $dirs != $curr_dir) || is_file($dirs) ) {
						unset($dir_array[ count($dir_array)-1 ]);
						break;
					}
					
					//$exist_dir = implode('/', $dir_array);
				}
				
				unset($filepath[ count($filepath)-1 ]);
				
				//$child_dir = $filepath[ count($filepath) - 1];
				$child_dir = $dir_array[ count($dir_array) - 1];
				
				$curr_dir = basename(__DIR__);
				
				if( $fpath_cnt > 1 && $curr_dir != $child_dir ) {
					
					//$viewer = $filepath[0] . '/view_bh.php';
					//$viewer = implode('/', $filepath) . '/view_bh.php';
					$viewer = implode('/', $dir_array) . '/view_bh.php';
	
					if( file_exists($viewer) ) {
						header('Location: /portal/'.$viewer.'?view='.$viewfile);
						exit;
					} else {
						$viewer_copy = file_get_contents("view_bh.php");
						
						if (!file_put_contents($viewer, $viewer_copy)) {
							throw new Exception('Error writing data to viewer file.');
						}
						
						header('Location: /portal/'.$viewer.'?view='.$viewfile);
						exit;
					}
				}
			}
			
		}
		

    	if( file_exists($cachedfile) ) {
			ob_start();
			include($cachedfile);
			ob_end_flush();
	    } else {
			//$cont->create_page($filename);
			header('Location: /portal/bubblehelp/bhelp.php?/create_page/&curl='.$viewfile);
			exit;
			
		}
	}