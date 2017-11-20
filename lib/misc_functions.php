<?php
    /* misc_functions.php 1 2010-01-13 mike lacanilao*/
    // 2011-04-15 - recommit
    // 2010-01-14 mike
    //  allowing numeric as first character in password checking
    // 2011-02-28 removed the whitespaces before the <?php tag that cause header warning
	function check_password($password_old, $password, $password_confirm, $check_old = 1) {
       $is_error = '';
       
	  // CHECK FOR EMPTY PASSWORDS
	  if(trim($password) == "" || trim($password_confirm) == "" || ($check_old == 1 && trim($password_old) == "")) { $is_error = 'Password Empty'; }

	  // CHECK FOR OLD PASSWORD MATCH
	  //if($check_old == 1 && crypt($password_old) != $user_password) { $is_error = ''; }
      
	  // MAKE SURE BOTH PASSWORDS ARE IDENTICAL
	  if($password != $password_confirm) { $is_error = 'Your new password did not match with the confirmed password.'; }

	  // MAKE SURE PASSWORD IS LONGER THAN 5 CHARS
	  elseif(trim($password) != "" && strlen($password) < 6) { $is_error = 'Please enter password at least more than 5 characters.'; }

	  // MAKE SURE PASSWORD IS ALPHANUMERIC
	  elseif(!preg_match("/^([a-zA-Z_]+[0-9]+)|([0-9]+[a-zA-Z_]+)/", $password)) { $is_error = 'Your password must contain letters and number/s'; }

       return $is_error;
    
	} // END check_password() METHOD


 // get script parameter passed through GET/POST
    function getVar($var_name, $def_val = '') {
      if(isset($_POST[$var_name])) {
        return $_POST[$var_name];
      }
      else if(isset($_GET[$var_name])) {
        return $_GET[$var_name];
      }
      else if(isset($_SESSION) && isset($_SESSION[$var_name])) {
        return $_SESSION[$var_name];
      }
      return $def_val;
    }
    
    function redirect($str) {
      // redirect so that it does not repeat action on refresh
      header("Location: ".WEB_PATH_ADMIN."index.php?page=$str");
      die();
    }
?>