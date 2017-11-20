<?php
//  2011-11-10  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Initial Hack
require('../conf/zend_smarty_conf.php');


class ClientJSONRedirect {
    function __construct() {
        global $db;
        $client_id = $_SESSION['client_id'];
        if (($client_id == "") || ($client_id == Null)) {
            throw new Exception('Please Login PHP');
        }
        $this->client_id = $client_id;

        //get clients timezone
        $sql = $db->select()
                ->from(Array('t' => 'timezone_lookup'), 'timezone')
                ->join(Array('l' => 'leads'), 'l.timezone_id = t.id')
                ->where('l.id = ?', $client_id);
        $tz = $db->fetchOne($sql);
        if ($tz == Null) {
            $this->client_tz = 'Australia/Sydney';
        }
        else {
            $this->client_tz = $tz;
        }

        //get clients email
        $sql = $db->select()
                ->from('leads', 'email')
                ->where('id = ?', $client_id);
        $this->client_email = $db->fetchOne($sql);
    }


    /*
    returns a random string for django consumption
    */
    public function check_php_session() {
        global $db;

        $now = new Zend_Date();

        $random_string_exists = True;
        while ($random_string_exists) {
            $random_string = $this->rand_str();
            $data = array(
                'random_string' => $random_string,
                'date_created' => $now->toString("yyyy-MM-dd HH:mm:ss"),
                'session_data' => sprintf('client_id=%s', $this->client_id),
                'redirect' => 'from ClientJSONRedirectService.php django redirect',
            );

            try {
                $db->insert('django_session_transfer', $data);
                $random_string_exists = False;
            }
            catch (Exception $e) {
                $random_string_exists = True;
            }
        }

        return $random_string;

    }

    private function rand_str($length = 45, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
        // Length of character list
        $chars_length = strlen($chars);

        // Start our string
        $string = $chars{rand(0, $chars_length)};
       
        // Generate random string
        for ($i = 1; $i < $length; $i++) {
            // Grab a random character from our list
            $r = $chars{rand(0, $chars_length)};
            $string = $string . $r;
        }
       
        // Return the string
        return $string;
    }
}

$server = new Zend_Json_Server();
$method = $server->getRequest()->getMethod();
$server->setClass('ClientJSONRedirect');
$server->handle();
?>
