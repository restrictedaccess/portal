<?php
/**
 *
 * Curl Mail Sender
 *
 * @author		Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
 */
class AgentCurlMailSender {
    /**
    *
    * Initialize object
    */
    const CURL_PASSWORD = '143x244y';
    const CURL_FILE = 'curl_mail_receiver.php';
    function __construct() {   
        include('conf.php');
        //initialize database handler
        try {
            $this->dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
            die();
        }

        //grab hosting part
        $agent_no = $_SESSION['agent_no'];
        $query = "select hosting from agent where agent_no = $agent_no";
        $data = $this->dbh->query($query);
        $result = $data->fetch();
        $this->hosting = trim($result['hosting']);
    }

    /**
    *
    * Sends the mail either via curl or via localhosts mail
    *
    */
    function SendMail($emails, $subject, $agent_email, $message) { 
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From: ".$agent_email." \r\n"."Reply-To: ".$agent_email."\r\n";
        if ($this->hosting == '') {
            $email=explode(",",$emails);

            for ($i=0; $i<count($email);$i++)
            {

                $to=$email[$i];
                mail($to, $subject, $message, $headers);
            }
            return "Success!";
        }
        else {
            $this->hosting = rtrim($this->hosting, "/");
            $this->hosting .= "/";
            $ch = curl_init();

            $data = array('emails' => $emails, 'subject' => $subject, 'headers' => $headers, 'message' => $message, 'curl_password' => self::CURL_PASSWORD);

            curl_setopt($ch, CURLOPT_URL, $this->hosting . self::CURL_FILE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $curl_result = curl_exec($ch);
            curl_close($ch);
            return $curl_result;
        }
    }


    function SendMailWithHeaders($emails, $subject, $message, $headers) { 
        if ($this->hosting == '') {
            $email=explode(",",$emails);

            //echo count($email)."<br>";
            for ($i=0; $i<count($email);$i++)
            {

                $to=$email[$i];
                mail($to,$subject, $message, $headers);
            }
            return "Success!";
        }
        else {
            $this->hosting = rtrim($this->hosting, "/");
            $this->hosting .= "/";
            $ch = curl_init();

            $data = array('emails' => $emails, 'subject' => $subject, 'headers' => $headers, 'message' => $message, 'curl_password' => self::CURL_PASSWORD);

            curl_setopt($ch, CURLOPT_URL, $this->hosting . self::CURL_FILE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $curl_result = curl_exec($ch);
            curl_close($ch);
            return $curl_result;
        }
    }
}

?><?php
##~    $curl_mail = new AgentCurlMailSender();
##~    $result = $curl_mail->SendMail('locsunglao@yahoo.com', 'subject test', 'locsunglao@programmer.net', '<b>The </b>quick brown fox jumps over the lazy dog.');
##~    echo $result;
?>
