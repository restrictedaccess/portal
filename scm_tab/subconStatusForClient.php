<?php
    //requires $_GET['userid'] and $_SESSION['agent_no'] parameter
    include ('../conf.php');
    require_once('ValidateClientUserLib.php');
    require_once('../time_recording/TimeRecording.php');
    date_default_timezone_set("Asia/Manila");

    /**
     *
     * extends TimeRecording class
     *
     */
    class SubconStatus extends TimeRecording {
        /**
        *
        *   returns a string indicating status of the subcontractor
        */
        function GetStatus() {
            if ($this->buttons['lunch_end']) {
                return "Out to lunch.";
            }
            if ($this->buttons['work_start']) {
                return "Not working.";
            }
            else {
                return "Working.";
            }
        }
    }

    $subcon_status = new SubconStatus($userid);
    $return_data = array('status' => $subcon_status->GetStatus());
    
    $output = json_encode($return_data);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');
    echo $output;
?>
