<?php
/* fb_oauth_cb - 2013-06-20
  facebook login callback
*/
include '../conf/zend_smarty_conf.php';
include_once('../lib/users_class.php');
Users::$dbase = $db;

$code = isset($_GET['code']) ? $_GET['code'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';

//$rs_site = TEST ? 'http://'.$_SERVER['HTTP_HOST'] : 'https://remotestaff.com.au';
$rs_site = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
						? "https://". $_SERVER['HTTP_HOST'] : "http://". $_SERVER['HTTP_HOST'];
//$rs_site = 'http://'.$_SERVER['HTTP_HOST'];

include_once('./views/header.php');
echo '<div class="main-container" style="width:85%">';
echo '<p class="lastNode">Remote Staff Test</p><br/>';

if( !$error && $code ) {
    $url_access_token = "https://graph.facebook.com/oauth/access_token?"
        ."client_id=120769391467061"
        ."&redirect_uri=".urlencode($rs_site."/portal/skills_test/fb_oauth_cb.php")
        ."&client_secret=682b9530e4e98b1ae3da57deb41ee3dd"
        ."&code=$code";
    
    /*$response = file_get_contents($url_access_token);
    if( $response === FALSE ) {
        echo '<div class="centeralign">';
        echo '<div class="error">Failed to open stream (access_token)</div>';
        echo '</div>';
    }*/
    
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_access_token);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    parse_str($response, $result);

    // check access token
    if( !empty($result['access_token']) ) {
        $access_token = $result['access_token'];
        
        $url_megraph = "https://graph.facebook.com/me?access_token=". $access_token;
        $user_data = json_decode(file_get_contents($url_megraph));
            
        $diff_user = new Users( array($user_data->email, 'jobseeker', 0) );
        
        if( !$diff_user->user_exists ) {
            
            $create_date = date("Y-m-d H:i:s");
    
            $diff_user->user_create('personal',
                            array('fname'=>$user_data->first_name, 'lname'=>$user_data->last_name,
                                  'email'=>$user_data->email, 'gender'=>$user_data->gender, 'facebook_id'=>$user_data->id,
                                  'datecreated'=>$create_date, 'dateupdated'=>$create_date) );
            
            if( !$diff_user->error ) {
                $diff_user = new Users( array($user_data->email, 'jobseeker', 0) );
            }
            
        } else {
            if( $diff_user->facebook_id() != $user_data->id ) $diff_user->facebook_id($user_data->id);
        }
                
        // force login
        $diff_user->login($user_data->email, '', $user_data->id);
                
        if( !$diff_user->error ) {
            echo "<script type='text/javascript'>";
            echo "window.location.href='/portal/skills_test/';";
            echo "</script>";
            exit;
        } else {
            echo '<div class="centeralign">';
            echo '<div class="error">Failed to login via facebook, use the Remotestaff account instead.</div>';
            echo '</div>';
        }

        
    } else {
        $data = json_decode($response);
        echo '<div class="centeralign">';
        echo '<div class="error">'.$data->error->{'message'}.'</div>';
        echo '</div>';
    }
} else {
    
    
    $error_desc = $_GET['error_description'];
    $error_reason = $_GET['error_reason'];
?>
    
    <p><?php echo $error_reason;?></p>
        <div class="centeralign">
                <div class="error"><?php echo $error_desc;?></div>
        </div>
    
<?php
}
echo '<div id="footer_divider"></div>';
echo '</div>';
include_once('./views/footer.php');
?>