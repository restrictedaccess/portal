<?php
require_once dirname(__FILE__)."/../../lib/Portal.php";

class ThankYou extends Portal{
    protected $db;
    protected $base_API_url;
	
	
    
    public function __construct($db,$apiurl){
        $this->db = $db;
        $this->base_API_url = $apiurl;
    }
    
    
    public function render(){
        $smarty = new Smarty();
        $db = $this -> db;
        $contact_numbers = $this->getRsContactNumbers();       
        $contact_numbers_forcall = preg_replace("/[\s-+()]+/", "", $contact_numbers);
        $contact_numbers_forcall["aus_company_number"] = str_replace("6102", "+612", $contact_numbers_forcall["aus_company_number"]);
        $contact_numbers_forcall["aus_header_number"] = str_replace("6102", "+612", $contact_numbers_forcall["aus_header_number"]);
        $smarty->assign("contact_numbers_forcall", $contact_numbers_forcall);
        $smarty->assign("count_subcon", $count_subcon);    
        $smarty->assign("contact_numbers", $contact_numbers);
        $smarty->assign("staff_job_title", $_SESSION["staff_job_title"]);
        $smarty->assign("number_of_staff", $_SESSION["number_of_staff"]);
        $smarty->assign("years_of_experience", $_SESSION["years_of_experience"]) ;
        
        $smarty -> display("thank_you.tpl");
    }

    private function getRsContactNumbers(){
        $db = $this->db;
        $sql="SELECT * FROM rs_contact_nos r WHERE active='yes';";
        $rs_contact_nos = $db->fetchAll($sql);
        
        $aus_numbers = array();
        foreach($rs_contact_nos as $number){
            if($number['site'] == 'aus'&&$number["type"]=="header number"){
                $aus_numbers[] = $number;
            }
        }
        
        
        foreach($rs_contact_nos as $number){
            if($number['site'] == 'aus' and $number['type'] == 'header number'){
                $aus_header_number .= sprintf('%s<br>', $number['contact_no']);
            }
            if($number['site'] == 'aus' and $number['type'] == 'company number'){
                $aus_company_number .= sprintf('%s<br>', $number['contact_no']);
            }
            if($number['site'] == 'aus' and $number['type'] == 'office number'){
                $aus_office_number .= sprintf('%s<br>', $number['contact_no']);
    
            }
            
            if($number['site'] == 'usa' and $number['type'] == 'company number'){
                $usa_company_number .= sprintf('%s<br>', $number['contact_no']);
            }
            
            if($number['site'] == 'php' and $number['type'] == 'company number'){
                $php_company_number .= sprintf('%s<br>', $number['contact_no']);
            }
            
        }
        $aus_header_number = substr($aus_header_number,0,(strlen($aus_header_number)-4));
        $aus_company_number =substr($aus_company_number,0,(strlen($aus_company_number)-4));
        $aus_office_number = substr($aus_office_number,0,(strlen($aus_office_number)-4));
        $usa_company_number = substr($usa_company_number,0,(strlen($usa_company_number)-4));
        $php_company_number = substr($php_company_number,0,(strlen($php_company_number)-4));
        
        return array(
            'rs_contact_nos' => $rs_contact_nos,
            'aus_numbers' => $aus_numbers,
            'aus_header_number' => $aus_header_number,
            'aus_company_number' => $aus_company_number,
            'aus_office_number' => $aus_office_number,
            'usa_company_number' => $usa_company_number,
            'php_company_number' => $php_company_number
        );
    }


    public function getLocationDetails(){
        $addr = "";
        if ($_SERVER["REMOTE_ADDR"]){
            $addr = $_SERVER["REMOTE_ADDR"];
        }
        //we are on local server
        if (strpos($addr, "192.168")!==False){
            if ($_SERVER["HTTP_X_FORWARDED_FOR"]){
                $addr = $_SERVER["HTTP_X_FORWARDED_FOR"];
            }   
        }
        
        
        return array(
            'location_id' => LOCATION_ID,
            'leads_ip' => $addr,
            'leads_country' => $this->getCCfromIP($addr)            
        );
        
    }
    
    public function getALLfromIP($addr) {
        // this sprintf() wrapper is needed, because the PHP long is signed by default
        $db = $this->db;
        $ipnum = sprintf("%u", ip2long($addr));
        $query = "SELECT cc, cn FROM ip NATURAL JOIN cc WHERE ${ipnum} BETWEEN start AND end";
        $result = $db->fetchRow($query);
        
        return $result;
    }
    
    public function getCCfromIP($addr) {
        $data = $this->getALLfromIP($addr);
        if($data) return $data['cn'];
        return false;
    }

}