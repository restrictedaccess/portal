<?php
//  2012-02-25 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   change asort to sort, removed logger
//  2009-01-07 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   fix DST
//  2009-01-06 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   fix toString bug
//  2009-11-11 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Removed logger
//  2009-11-06 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  Initial hack for Time Zone Converter

require('conf/zend_smarty_conf_root.php');

class TimeZoneConverter {

    public function get_time_zones() {
        $all = DateTimeZone::listIdentifiers();

        $i = 0;
        foreach($all as $zone) {
            $zone = explode('/', $zone);
            $zonen[$i]['continent'] = isset($zone[0]) ? $zone[0] : '';
            $zonen[$i]['city'] = isset($zone[1]) ? $zone[1] : '';
            $zonen[$i]['subcity'] = isset($zone[2]) ? $zone[2] : '';
            $i++;
        }

        sort($zonen);

        return $zonen;
    }

    public function convert($tz_ref, $tz_dest, $ref_date) {
            date_default_timezone_set($tz_ref);
            $date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');

            $dest_date = clone $date;
            $dest_date->setTimezone($tz_dest);
            $data = array(
                'ref_date_time' => $date->toString('yyyy-MM-dd hh:mm a'),
                'ref_time_zone' => $date->toString('zzzz'),
                'ref_dst' => $date->toString('I'),
                'dest_date_time' => $dest_date->toString('yyyy-MM-dd hh:mm a'),
                'dest_time_zone' => $dest_date->toString('zzzz'),
                'dest_dst' => $dest_date->toString('I'),
            );

            return $data;
    }
}

$server = new Zend_Json_Server();
$server->setClass('TimeZoneConverter');
$server->handle();
?>
