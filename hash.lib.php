<?php
/*

include_once("hash.lib.php") ;
 $zig_hash = new zig_hash ;
 $hash_email = $zig_hash->hash("hash","encrypt",$fetch['email']) ;

*/
class zig_hash
{
	function hash($parameters,$arg1='',$arg2='',$arg3='')
	{
		
		$type = is_array($parameters) ? $parameters['type'] : $arg1 ;
		$string = is_array($parameters) ? $parameters['string'] : $arg2 ;
		$url = is_array($parameters) ? $parameters['url'] : $arg3 ;
		
		switch($type)
		{
			case 'encrypt' :
				$boo_result['value'] = $this->hash_encrypt($string) ;
				break ;
				
			case 'decrypt' :
				$boo_result['value'] = $this->hash_decrypt($string) ;
				break ;
				
			case 'url_encode' :
				$boo_result['value'] = $this->hash_url_encode($string,$url) ;
				break ;
			
			case 'url_decode' :
				$boo_result['value'] = $this->hash_url_decode($string,$url) ;
				break ;
				
			case 'vars_encode' :
				$boo_result['value'] = $this->hash_vars_encode($string) ;
				break ;
				
			case 'vars_decode' :
				$boo_result['value'] = $this->hash_vars_decode($string) ;
				break ;
		}
		
		return $boo_result ;
		
	}

	function hash_url_encode($string,$url='')
	{
		$string = $this->hash_encrypt($string) ;
		$url = $url."?".$string ;
		return $url ;
	}

	function hash_url_decode($string='',$url='')
	{
		if($string<>"")
		{
			$string = $this->hash_decrypt($string) ;
		}
		elseif($url<>"")
		{
			$url = $split("?",$url) ;
			$string = $url[1] ;
		}
		return $string ;
	}
	
	function hash_encrypt($string)
	{
		$blowfish = $this->get_blowfish() ;
//		$blowfish = $GLOBALS['zig']['default']['blowfish'] ;
		$blowfish_coded = base64_encode($blowfish) ;
		$string = strrev($string) ;
		$string = base64_encode($string) ;
		$string = $blowfish.$string.$blowfish_coded ;
		$string = base64_encode($string) ;
		return $string ;
	}
	
	function hash_decrypt($string)
	{
		$blowfish = $this->get_blowfish() ;
//		$blowfish = $GLOBALS['zig']['default']['blowfish'] ;
		$blowfish_coded = base64_encode($blowfish) ;
		$string = base64_decode($string) ;
		$string = str_replace($blowfish,"",$string) ;
		$string = str_replace($blowfish_coded,"",$string) ;
		$string = base64_decode($string) ;
		$string = strrev($string) ;
		return $string ;
	}

	function hash_vars_encode($vars)
	{
		if(is_array($vars))
		{
			foreach($vars as $key => $value)
			{
				$vars_string = $vars_string ? $vars_string."," : '' ;
				$vars_string.= $key."=".$value ;
			}
			$vars = $vars_string ;
		}
		$vars_result = $this->hash_encrypt($vars) ;
		return $vars_result ;
	}

	function hash_vars_decode($vars)
	{
		$vars = $this->hash_decrypt($vars) ;
		if(strpos($vars,","))
		{
			$stripped_vars = explode(",",$vars) ;
		}
		
		if(is_array($stripped_vars))
		{
			foreach($stripped_vars as $value)
			{
				$stripped = explode("=",$value) ;
				$vars_result[$stripped[0]] = $stripped[1] ;
			}
		}
		else if(strpos($vars,"="))
		{
			$stripped_vars = explode("=",$vars) ;
			$vars_result[$stripped_vars[0]] = $stripped_vars[1] ;
		}
		else
		{
			$vars_result = $vars ;
		}
		return $vars_result ;
	}
	
	function get_blowfish()
	{
		$blowfish = "ryanGwapo";
		return $blowfish ;
	}
	
	
}

?>