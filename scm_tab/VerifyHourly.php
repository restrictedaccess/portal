<?php
    require('../conf/zend_smarty_conf.php');

    $sql = $db->select()
        ->from(array('s' => 'subcontractors'), array('php_monthly','php_daily','php_weekly', 'php_hourly', 'status', 'working_hours'))
        ->join(array('p' => 'personal'), 's.userid = p.userid', array('fname', 'lname'));

    echo "<table border=1>";
    echo "<th>First Name</th><th>Last Name</th><th>Status</th><th>Working Hours</th><th>Monthly</th><th>Daily</th><th>Weekly</th><th>Hourly</th><th>Computed</th>";
    foreach ($db->fetchAll($sql) as $record) {
        if (($record['working_hours'] == Null) || ($record['php_monthly'] == Null)){
            $computed = '';
        }
        else {
            $computed = $record['php_monthly'] * 12 / 52 / 5 / $record['working_hours'];
        }
        echo "<tr>";
        echo "<td>" . $record['fname'] . "</td>";
        echo "<td>" . $record['lname'] . "</td>";
        echo "<td>" . $record['status'] . "</td>";
        echo "<td>" . $record['working_hours'] . "</td>";
        echo "<td>" . $record['php_monthly'] . "</td>";
        echo "<td>" . $record['php_daily'] . "</td>";
        echo "<td>" . $record['php_weekly'] . "</td>";
        echo "<td>" . $record['php_hourly'] . "</td>";
        echo "<td>" . $computed . "</td>";
        echo "</tr>";
    }
    echo "</table>";
?>
