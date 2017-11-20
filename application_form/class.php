<?php
class passGen {

    var $size;
    var $password;

// ------------------------------------------------

    function passGen($size=0){
		$this->size = $size;
    }

// ------------------------------------------------

	function password($return_letters=1, $return_numbers=1){

        $letters = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';

        $passString = '';
	    $option = $return_letters . $return_numbers;

       	for($i = 0; $i < $this->size; $i++){
        	switch($option){
            	case '01':
                	$c = $numbers[mt_rand(0, 9)];
                break;
                case '10':
                	$c = $letters[mt_rand(0, 25)];
                break;
                case '11':
                    $j = mt_rand(0, 1);
					$c = ($j == 0 ? $letters[mt_rand(0, 25)] : $numbers[mt_rand(0, 9)]);
                break;
            }
            $this->password[$i] = $c;
            $passString .= $c;
        }
    	return md5($passString);
    }

// ------------------------------------------------

	function images($path, $extension, $preImage='', $width='', $height='', $css=''){
    	$images='';
	    for($i = 0; $i < $this->size; $i++){
        	$images .= '<img';
            if($css != ''){ $images .= ' class="'. $css .'"'; }
            $images .= ' src="'. $path .'/'. $preImage . $this->password[$i] .'.'. $extension .'" width="'. $width .'"  height="'. $height .'" alt="" border=0 align="texttop">';
        }
        return $images;
    }

// ------------------------------------------------

	function verify($input, $rv){
		if(md5($input) == $rv)
		   {
		    return true ; 
		   }
        else 
		   { 
		    return false; 
		   }
    }

// ------------------------------------------------

}
?>