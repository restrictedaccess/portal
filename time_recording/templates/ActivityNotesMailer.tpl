<html>
<head>
<title>My Account-Client</title>
</head>
<body>
    <div>Activity Tracker Notes</div>
    <div>{$personal.fname} {$personal.lname}</div>
    <table>
    {section name=i loop=$activity_tracker_notes}
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
            <td>{$activity_tracker_notes[i].checked_in_time}</td>
            <td>{$activity_tracker_notes[i].note|escape|ss}</td>
        </tr>
    {/section}
    </table>
</body>
</html>
