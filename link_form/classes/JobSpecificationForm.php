<?php


require_once dirname(__FILE__)."/../../lib/Portal.php";

class JobSpecificationForm extends Portal{
    
    protected $db;
    protected $base_API_url;
	
	
    
    public function __construct($db,$apiurl){
        $this->db = $db;
        $this->base_API_url = $apiurl;
    }
    
    
    public function render(){

        $passGen = new passGen(5);



        if(!isset($_REQUEST['rv2'])&&!isset($_REQUEST['pass3']))
        {
            $rv2 = $passGen->password(0, 1);
            $images = $passGen->images('./font', 'gif', 'f_', '20', '20');


            $db = $this -> db;
            $smarty = new Smarty();

            $timezones_sql = $db -> select()
                -> from('timezone_lookup',array('timezone'));
            $timezones = $db -> fetchCol($timezones_sql);

            $job_cat_sql = $db -> select()
                -> from('job_sub_category',array('singular_name'));

            $job_cat = $db ->fetchCol($job_cat_sql);

            $shift_times = array();
            $shift_times[] = array("value" => "00:00", "label" => "12:00 AM");
            $shift_times[] = array("value" => "00:30", "label" => "12:30 AM");
            for ($i = 1; $i <= 9; $i++) {
                $shift_times[] = array("value" => "0{$i}:00", "label" => "0{$i}:00 AM");
                $shift_times[] = array("value" => "0{$i}:30", "label" => "0{$i}:30 AM");
            }
            for ($i = 10; $i <= 11; $i++) {
                $shift_times[] = array("value" => $i . ":00", "label" => $i . ":00 AM");
                $shift_times[] = array("value" => $i . ":30", "label" => $i . ":30 AM");
            }
            $i = 12;
            $shift_times[] = array("value" => $i . ":00", "label" => $i . ":00 PM");
            $shift_times[] = array("value" => $i . ":30", "label" => $i . ":30 PM");

            for ($i = 1; $i <= 9; $i++) {
                $k = $i + 12;
                $shift_times[] = array("value" => "{$k}:00", "label" => "0{$i}:00 PM");
                $shift_times[] = array("value" => "{$k}:30", "label" => "0{$i}:30 PM");
            }
            for ($i = 10; $i <= 11; $i++) {
                $k = $i + 12;
                $shift_times[] = array("value" => "{$k}:00", "label" => "{$i}:00 PM");
                $shift_times[] = array("value" => "{$k}:30", "label" => "{$i}:30 PM");
            }


            $smarty -> assign("base_api_url", $this->base_API_url);
            $smarty -> assign("url_referer", $_SERVER["HTTP_REFERER"]);
            $smarty -> assign('timezones',$timezones);
            $smarty -> assign('job_cat',$job_cat);
            $smarty -> assign("shift_times", $shift_times);
            $contact_numbers = $this->getRsContactNumbers();
            $contact_numbers_forcall = preg_replace("/[\s-+()]+/", "", $contact_numbers);

            $referer_link = "http://".$_SERVER['HTTP_HOST']."/thankyou.php";
            $is_thankyou_page = false;
            if($_SERVER['HTTP_REFERER'] == $referer_link){
                $is_thankyou_page = true;
            }

            $registered_name = "";

            $registered_email = "";
            $registered_number = "";

            if($_GET['leads_name']){
                $is_thankyou_page = true;
                $registered_name = $_GET['leads_name'];
            }


            if($_GET['leads_email']){
                $is_thankyou_page = true;
                $registered_email = $_GET['leads_email'];
            }

            if($_GET['leads_number']){
                $is_thankyou_page = true;
                $registered_number = $_GET['leads_number'];
            }

            $site = "";
            if(TEST){
                $site = "http://www.devs.remotestaff.com.au/portal/link_form/job_specification_form.php";
            }else{
                $site = "http://www.remotestaff.com.au/portal/link_form/job_specification_form.php";
            }

            $smarty->assign("site", $site);
            $test_footer_links = false;
            if(TEST){
                $test_footer_links = true;
            } else {
                $test_footer_links = false;
            }
            $url= "";
            $blog_link = "";
            if(TEST){
                $url = "http://devs.remotestaff.com.au";
                $blog_link = "http://devs.blog.remotestaff.com.au/";
            }else if(STAGING){
                $url = "http://staging.remotestaff.com.au";
                $blog_link = "http://staging.blog.remotestaff.com.au/";
            }else{
                $url = "http://remotestaff.com.au";
                $blog_link = "http://blog.remotestaff.com.au/";
            }

            $smarty->assign("site", $site);
            $smarty -> assign("url", $url);
            $smarty -> assign("blog_link", $blog_link);
            $smarty -> assign("test_footer_links", $test_footer_links);
            $location_details = $this -> getLocationDetails();

            $contact_numbers_forcall["aus_company_number"] = str_replace("6102", "+612", $contact_numbers_forcall["aus_company_number"]);
            $contact_numbers_forcall["aus_header_number"] = str_replace("6102", "+612", $contact_numbers_forcall["aus_header_number"]);
            $smarty->assign("contact_numbers_forcall", $contact_numbers_forcall);
            $smarty->assign("count_subcon", $count_subcon);
            $smarty->assign("contact_numbers", $contact_numbers);
            $smarty->assign("registered_name", $registered_name);
            $smarty->assign("registered_email", $registered_email);
            $smarty->assign("registered_number", $registered_number);
            $smarty->assign("is_thankyou_page", $is_thankyou_page);
            $smarty->assign("location", $location_details);
            $smarty->assign("auth_token", $this->generateToken());
            $smarty->assign('rv2',$rv2);
            $smarty->assign('images',$images);
            $smarty -> display("job_spec_form.tpl");
        }
        else
        {
            $pass3 = $_REQUEST['pass3'];
            $rv2 = $_REQUEST['rv2'];

            if(!$passGen->verify($pass3, $rv2)) {

                $rv2 = $passGen->password(0, 1);
                $images = $passGen->images('./font', 'gif', 'f_', '30', '40');

                echo "1";
                exit;
            }
            else
            {

                if(isset($_POST) && !empty($_POST)){

                    $curl = new Curl();
                    $base_api_url = $this->getAPIURL();

                    print_r($this->curl);

                    if(!empty($_POST)){

                        $result = $curl->post($base_api_url . "/job-order/save-job-specification-requirement/", $_POST);

                        if($result["success"]){
                            $_SESSION["link_form_success"] = "Job Specification Requirement Saved!";
                        }
                    }

                }
            }
        }


        
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



