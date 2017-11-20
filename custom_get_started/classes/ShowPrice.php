<?php
/**
 *
 * Flag to show the price based on ip_deny_view_price, ip_allow_view_price
 * and country_deny_view_price tables
 *
 * To use ShowPrice::Show() 
 * returns boolean
 *
 * @author		Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
 *
 * 2010-07-21   Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
 *  -   Add the 1and1 proxy server
 * 2010-07-22   Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
 *  -   make sure ip is a positive number
 * 2011-05-02   Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
 *  -   added ip address of the new iweb server
 * 2011-05-05   Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
 *  -   updated ip address of the new iweb server
 */

class ShowPrice {
    public static function Show() {
        global $db;
        $VALID_PROXY = Array('69.164.206.86', '74.208.147.28', '184.107.196.58');
        if (!isset($db)) {  //test if $db is already set
            include_once('conf/zend_smarty_conf.php');
        }
        
        
        

        //hard coding the ip address of our proxy
        $ip = $_SERVER['REMOTE_ADDR'];
        $ip = trim($ip, "::ffff:");     //remove IPV6
        if (in_array($ip, $VALID_PROXY)) {
            return True;
        }

        //get ip address, check also if the user is using proxy
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $ip = trim($ip, "::ffff:");     //remove IPV6

        $ip_long = sprintf('%u', ip2long($ip));

        //check ip_deny_view_price table
        $sql = $db->select()
                ->from('ip_deny_view_price')
                ->where('ip = ?', $ip_long);
        $ip_deny = $db->fetchOne($sql);

        if ($ip_deny) {
            return False;
        }

        //check if its on ip_allow_view_price
        $sql = $db->select()
                ->from('ip_allow_view_price')
                ->where('ip = ?', $ip_long);
        $ip_allow = $db->fetchOne($sql);

        if ($ip_allow) {
            return True;
        }

        //get country of the ip
        $sql = $db->select()
                ->from('ip', Array())
                ->joinNatural('cc', 'cc')
                ->where('? BETWEEN start and end', $ip_long);
        $cc = $db->fetchOne($sql);

        //ip address not found, return false
        if (!$cc) {
            return False;
        }


        //final check on the country_deny_view_price table
        $sql = $db->select()
                ->from('country_deny_view_price', 'cc')
                ->where('cc = ?', $cc);
        $deny = $db->fetchOne($sql);

        if ($deny) {
            return False;
        }

        return True;
    }
}



?>
