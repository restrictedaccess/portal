<?php
/**
 * Base class of Recruitment Related Development
 *
 *  @version 0.1 - Initial commit of Portal class
 */
require_once dirname(__FILE__)."/Curl.php";
abstract class Portal{
	protected $db;
	protected $smarty;
	protected $curl;
	public function __construct($db){
		$this->db = $db;
		$this->smarty = new Smarty();
		$this->checkAuth();
		$this->init();
		$this->setAdmin();

		$this->curl = new Curl();
		$ch = $this->curl->curl;

		curl_setopt( $ch, CURLOPT_HEADER, false );

		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );

		curl_setopt( $ch, CURLOPT_AUTOREFERER, true );

		curl_setopt( $ch, CURLOPT_VERBOSE, true );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );

		curl_setopt( $ch, CURLOPT_FAILONERROR, false );

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );

        /**
         * Injected by Josef balisalisa
         */
        try{

            global $base_api_url;

            $curl = $this->curl;


            $to_redirect = $curl->get($base_api_url . '/candidates/get-default-resume-settings-value?settings_for=redirect_to_new_jobseeker_v2');
            $to_redirect = json_decode($to_redirect, true);
            $will_redirect = $to_redirect["value"];

            if($will_redirect){
                $this->smarty->assign("will_redirect_to_new_jobseeker_v2", $will_redirect);
            }
        } catch(Exception $e){

        }


	}
	private function init(){
		if($_SESSION['admin_id']!="" or $_SESSION['agent_no']!="" or $_SESSION['client_id']!="" or $_SESSION['userid']!="" ){
			$hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $_SESSION['emailaddr'] ), 2, 17 );
			$this->smarty->assign("hash_code", $hash_code);
		}
		$this->smarty->assign("session_email", $_SESSION["emailaddr"]);
		$path =  explode('portal/', $_SERVER['REQUEST_URI']);
		$help_path = $path[count($path)-1];
		$this->smarty->assign("help_path", $help_path);
		$this->smarty->assign("admin_status", $_SESSION["status"]);
	}
	protected function checkAuth(){
		if(!isset($_SESSION['agent_no'])){
			if (!isset($_SESSION["admin_id"])){
				header("location:/portal/index.php");
			}
		}else{
			$_SESSION['status'] = "BusinessDeveloper";
		}
		if (!isset($_SESSION["agent_no"])){
			if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL"){
				echo "This page is for HR usage only.";
				exit;
			}
		}

	}
	public abstract function render();
	protected function setAdmin(){
		$db = $this->db;
		if ($_SESSION["status"]=="BusinessDeveloper"){
			$admin_id  = $_SESSION["agent_no"];
			$admin = $db->fetchRow($db->select()->from("agent", array("fname AS admin_fname", "lname AS admin_lname", "agent_no AS admin_id", "status"))->where("agent_no = ?", $admin_id));
			$this->smarty->assign("admin", $admin);

		}else{
			$admin_id  = $_SESSION["admin_id"];
			$admin = $db->fetchRow($db->select()->from("admin", array("admin_fname", "admin_lname", "admin_id", "status", "userid"))->where("admin_id = ?", $admin_id));
			$this->smarty->assign("admin", $admin);

		}
	}

	protected function getAPIURL(){
		global $base_api_url;
		return $base_api_url;

	}

	protected function getSlimURL(){
		global $base_slim_url;
		return $base_slim_url;
	}

	public function getRecruiters(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname 	 
			FROM `admin`
			where (status='HR')   AND admin_id <> 161  
		AND status <> 'REMOVED'  ORDER by admin_fname";
		return $db->fetchAll($select);
	}

    public function generateToken() {
        $today = new DateTime();
        $token = sha1("remotestaff".$today->getTimestamp().$_SERVER["REQUEST_URI"].rand(1,100));
        $db = $this -> db;
        $data = array(
            'token' => $token,
            'date_created' => $today->format("Y-m-d h:i:s"),
            'status' => 1,
        );
        $db->insert('auth_tokens', $data);
        return $token;
    }


}
