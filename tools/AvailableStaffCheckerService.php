<?php
//  2011-07-18 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed "RESUME" file types on applicants file
//  2011-04-18 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   bugfix where the education is not showing due to undefined gpascore
//  2010-12-22 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   add function for automatic loading of user
//  2010-06-09 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   strip down unprintable characters from computer_hardware
//  2010-06-03 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Initial Hack
include_once('../conf/zend_smarty_conf.php');
include_once('../lib/AvailableStaffCheckSum.php');


class LoginAdmin {
    public function login($email, $password) {
        global $db, $logger_admin_login;
        $password = sha1($password);
        $sql = $db->select()
                ->from('admin')
                ->where('admin_email = ?', $email)
                ->where('admin_password = ?', $password);
        $result = $db->fetchAll($sql);
        if (count($result) == 0) {
            $details = sprintf("FAILED %s %s %s'", $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $email);
            $logger_admin_login->info("$details");
            return 'Invalid Login';
        }
        $details = sprintf("LOGIN %s %s %s'", $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $email);
        $logger_admin_login->info("$details");
        $_SESSION['admin_id'] =$result[0]['admin_id']; 
        $_SESSION['status'] =$result[0]['status']; 
        return "OK";
    }
}


class StaffRates {
    public function get_rates() {
        global $db, $logger;    //TODO delete logger
        //get currency_ids
        $currency_ids = Array();
        $currency_codes = Array('AUD', 'GBP', 'USD');
        foreach ($currency_codes as $code) {
            $sql = $db->select()
                    ->from('currency_lookup', 'id')
                    ->where('code = ?', $code);
            $currency_id = $db->fetchOne($sql);
            if (!$currency_id) {
                die("$code on currency_lookup not found!");
            }
            $currency_ids[$code] = $currency_id;
        }

        //get full time products
        $sql = $db->select()
                ->from('products')
                ->where('code like "SR-%"')
                ->where('active = "Y"')
                ->order('code');
        $data = $db->fetchAll($sql);

        //get prices
        $full_time_products = Array();
        foreach($data as $product) {
            $prices = Array();
            foreach($currency_ids as $code => $currency_id) {
                $sql = $db->select()
                        ->from('product_price_history', 'amount')
                        ->where('product_id = ?', $product['id'])
                        ->where('currency_id = ?', $currency_id)
                        ->order('date DESC')
                        ->limit(1);
                $amount = $db->fetchOne($sql);
                $prices[$code] = $amount;
            }
            $full_time_products[$product['id']] = Array(
                'code' => $product['code'],
                'prices' => $prices
            );
        }


        //get part time products
        $sql = $db->select()
                ->from('products')
                ->where('code like "SRPT%"')
                ->where('active = "Y"')
                ->order('code');
        $data = $db->fetchAll($sql);

        //get prices
        $part_time_products = Array();
        foreach($data as $product) {
            $prices = Array();
            foreach($currency_ids as $code => $currency_id) {
                $sql = $db->select()
                        ->from('product_price_history', 'amount')
                        ->where('product_id = ?', $product['id'])
                        ->where('currency_id = ?', $currency_id)
                        ->order('date DESC')
                        ->limit(1);
                $amount = $db->fetchOne($sql);
                $prices[$code] = $amount;
            }
            $part_time_products[$product['id']] = Array(
                'code' => $product['code'],
                'prices' => $prices
            );
        }


        return Array(
            'full_time_products' => $full_time_products,
            'part_time_products' => $part_time_products,
        );
    }
}


class AvailableStaffChecker {
    function __construct() {
        $admin_id = $_SESSION['admin_id'];
        $admin_status = $_SESSION['status'];
        if ($admin_id == "") {
            throw new Exception('Please Login');
        }
        $this->admin_id = $admin_id;
    }


    public function search($keyword, $type) {
        global $db;
        $sql = $db->select()
                ->from('personal', array('userid', 'lname', 'fname', 'email', 'skype_id'));

        switch($type) {
            case 'id':
                $sql->where('userid = ?', $keyword);
                break;
            case 'fname':
                $sql->where('fname like ?', "%$keyword%");
                break;
            case 'lname':
                $sql->where('lname like ?', "%$keyword%");
                break;
            case 'email':
                $sql->where('email like ?', "%$keyword%");
                break;
            case 'skype_id':
                $sql->where('skype_id like ?', "%$keyword%");
                break;
            default:
                return "Unknown search type";
        }
        return $db->fetchAll($sql);
    }

    public function get_staff_details($userid) {
        global $db;
        $this->userid = $userid;
        $sql = $db->select()
                ->from('personal')
                ->where('userid = ?', $userid);
        $personal = $db->fetchRow($sql);

        $picture_md5 = new AvailableStaffCheckSum($userid, $db, 'picture', '');
        $picture_md5->portal_path = '../';  //variable to locate path

        $fname_md5 = new AvailableStaffCheckSum($userid, $db, 'personal', 'fname');
        $voice_md5 = new AvailableStaffCheckSum($userid, $db, 'voice', '');
        $voice_md5->portal_path = '../';

        try {
            $date_of_birth = new DateTime(sprintf('%s-%s-%s', $personal['byear'], $personal['bmonth'], $personal['bday']));
        }
        catch (Exception $e) {
            $date_of_birth = new DateTime();
        }
                
        $voice_path = $personal['voice_path'];
        if ((file_exists("../$voice_path") == False) || ($voice_path == Null)) {
            $voice_path = '';
        }

        //age computation
        $now = new DateTime();
        $age = $now->format('Y') - $date_of_birth->format('Y');
        $x_now = new DateTime(sprintf('2010-%s-%s', $now->format('m'), $now->format('d')));
        $x_date_of_birth = new DateTime(sprintf('2010-%s-%s', $date_of_birth->format('m'), $date_of_birth->format('d')));
        if ($x_now->format('U') < $x_date_of_birth->format('U')) {
            $age -= 1;
        }

        $home_working_environment_md5 = new AvailableStaffCheckSum($userid, $db, 'personal', 'home_working_environment');
        $internet_connection_md5 = new AvailableStaffCheckSum($userid, $db, 'personal', 'internet_connection');
        $computer_hardware_md5 = new AvailableStaffCheckSum($userid, $db, 'personal', 'computer_hardware');
        $headset_quality_md5 = new AvailableStaffCheckSum($userid, $db, 'personal', 'headset_quality');

        $sql = $db->select()
                ->from('education')
                ->where('userid = ?', $userid);
        $education = $db->fetchRow($sql);
        if ($education) {
            try {
                $graduation_date = new DateTime(sprintf('%s-%s-01', $education['graduate_year'], $education['graduate_month']));
                $education['graduation_date'] = $graduation_date->format('M Y');
            }
            catch (Exception $e){
                $education['graduation_date'] = '';
            }
        }
        else {
            $education['educationallevel'] = '';
            $education['fieldstudy'] = '';
            $education['major'] = '';
            $education['college_name'] = '';
            $education['college_country'] = '';
            $education['gpascore'] = '';
            $education['graduation_date'] = '';
        }


        $sql = $db->select()
                ->from('currentjob')
                ->where('userid = ?', $userid);
        $currentjob = $db->fetchRow($sql);

        //strip down unprintable characters fromm computer_hardware
        $computer_hardware = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $personal['computer_hardware']);

        return Array(
            'userid' => $userid,
            'fname' => $personal['fname'],
            'fname_valid' => $fname_md5->Valid(),
            'picture_valid' => $picture_md5->Valid(),
            'voice_path' => $voice_path,
            'voice_valid' => $voice_md5->Valid(),
            'evaluation_comments' => $this->GetEvaluation(),
            'evaluation_comments_valid' => $this->GetValidEvaluation(),
            'nationality' => $personal['nationality'],
            'gender' => $personal['gender'],
            'country_id' => $personal['country_id'],
            'date_of_birth' => $date_of_birth->format('M d, Y'),
            'age' => $age,
            'home_working_environment' => $personal['home_working_environment'],
            'home_working_environment_valid' => $home_working_environment_md5->Valid(),
            'internet_connection' => $personal['internet_connection'],
            'internet_connection_valid' => $internet_connection_md5->Valid(),
            'computer_hardware' => $computer_hardware,
            'computer_hardware_valid' => $computer_hardware_md5->Valid(),
            'headset_quality' => $personal['headset_quality'],
            'headset_quality_valid' => $headset_quality_md5->Valid(),
            'education' => $education,
            'education_valid' => $this->GetValidEducation(),
            'currentjob' => $currentjob,
            'currentjob_valid' => $this->GetValidCurrentJob(),
            'language' => $this->GetLanguages(),
            'language_valid' => $this->GetValidLanguage(),
            'skills' => $this->GetSkills(),
            'skills_valid' => $this->GetValidSkills(),
            'staff_rates' => $this->GetStaffRates(),
            'tb_applicant_files' => $this->GetApplicantFiles(),
            'tb_applicant_files_valid' => $this->GetValidApplicantFiles(),
        );
    }


    private function GetStaffRates() {
        global $db;
        $sql = $db->select()
                ->from('staff_rate', Array('product_id', 'part_time_product_id'))
                ->where('userid = ?', $this->userid)
                ->order('date_updated DESC')
                ->limit(1);
        return $db->fetchRow($sql);
    }


    private function GetValidApplicantFiles() {
        global $db;
        $sql = $db->select()
                ->from('tb_applicant_files', 'id')
                ->where('userid = ?', $this->userid);

        $return_data = Array();
        $data = $db->fetchAll($sql);
        
        foreach ($data as $file) {
            $md5 = new AvailableStaffCheckSum($this->userid, $db, 'tb_applicant_files', $file['id']);
            $return_data[$file['id']] = $md5->Valid();
        }

        return $return_data;
    }


    private function GetApplicantFiles() {
        global $db;
        $sql = $db->select()
                ->from('tb_applicant_files', Array('id', 'file_description', 'name'))
                ->where('file_description != "RESUME"')
                ->where('userid = ?', $this->userid);
        return $db->fetchAll($sql);
    }


    private function GetLanguages() {
        global $db;
        $sql = $db->select()
                ->from('language')
                ->where('userid = ?', $this->userid);
        $language = $db->fetchAll($sql);
        return $language;
    }


    private function GetSkills() {
        global $db;
        $sql = $db->select()
                ->from('skills', Array('id', 'skill', 'experience', 'proficiency'))
                ->where('userid = ?', $this->userid);
        return $db->fetchAll($sql);
    }


    private function GetValidSkills() {
        global $db;

        $return_data = Array();

        $sql = $db->select()
                ->from('skills', 'id')
                ->where('userid = ?', $this->userid);
        $data = $db->fetchAll($sql);

        foreach ($data as $skill) {
            $md5 = new AvailableStaffCheckSum($this->userid, $db, 'skills', $skill['id']);
            $return_data[$skill['id']] = $md5->Valid();
        }

        return $return_data;
    }


    private function GetValidLanguage() {
        global $db;
        
        $return_data = Array();
        $sql = $db->select()
                ->from('language', 'id')
                ->where('userid = ?', $this->userid);
        $data = $db->fetchAll($sql);

        foreach ($data as $language) {
            $md5 = new AvailableStaffCheckSum($this->userid, $db, 'language', $language['id']);
            $return_data[$language['id']] = $md5->Valid();
        }

        return $return_data;

    }


    private function GetValidCurrentJob() {
        global $db;
        $counter = Array('', '2', '3', '4', '5', '6', '7', '8', '9', '10');

        $return_data = Array();
        foreach ($counter as $x) {
            foreach (Array('companyname', 'position', 'employment_period', 'duties') as $resource) {
                $resource_x = sprintf('%s%s', $resource, $x);
                $md5 = new AvailableStaffCheckSum($this->userid, $db, 'currentjob', $resource_x);
                $return_data[$resource_x] = $md5->Valid();
            }
        }

        $md5 = new AvailableStaffCheckSum($this->userid, $db, 'currentjob', 'available_status');
        $return_data['available_status'] = $md5->Valid();

        return $return_data;
    }


    private function GetEvaluation() {
        global $db;
        $sql = $db->select()
                ->from('evaluation_comments')
                ->where('userid = ?', $this->userid);
        $evaluation_comments = $db->fetchAll($sql);
        return $evaluation_comments;
    }


    private function GetValidEvaluation() {
        global $db;
        $data = $this->GetEvaluation();
        $return_data = Array();

        foreach ($data as $evaluation) {
            $id = $evaluation['id'];
            $md5 = new AvailableStaffCheckSum($this->userid, $db, 'evaluation_comments', $id);
            $return_data[$id] = $md5->Valid();
        }

        return $return_data;
    }


    //returns an associative array
    private function GetValidEducation() {
        global $db;
        $fields = Array('educationallevel', 'fieldstudy', 'major', 'college_name', 'college_country', 'graduate_year', 'graduate_month', 'graduation_date', 'gpascore');

        $return_data = Array();
        foreach ($fields as $field) {
            $md5 = new AvailableStaffCheckSum($this->userid, $db, 'education', $field);
            $return_data[$field] = $md5->Valid();
        }
        return $return_data;
    }


    public function approve_attachment($userid, $approved, $resource) {
        global $db;
        $md5 = new AvailableStaffCheckSum($userid, $db, 'tb_applicant_files', $resource);
        $md5->portal_path = '../';  //variable to locate path
        if ($approved == '1') {
            $md5->SaveChecksum();
        }
        else {
            $md5->Clear();
        }
    }


    public function approve_picture($userid, $approved) {
        global $db;
        $picture_md5 = new AvailableStaffCheckSum($userid, $db, 'picture', '');
        $picture_md5->portal_path = '../';  //variable to locate path
        if ($approved == '1') {
            $picture_md5->SaveChecksum();
        }
        else {
            $picture_md5->Clear();
        }
    }


    public function approve_resource($userid, $approved, $resource_type, $resource) {
        global $db;
        $details_md5 = new AvailableStaffCheckSum($userid, $db, $resource_type, $resource);
        if ($approved == '1') {
            $details_md5->SaveChecksum();
        }
        else {
            $details_md5->Clear();
        }
    }


    public function approve_voice($userid, $approved) {
        global $db;
        $voice_md5 = new AvailableStaffCheckSum($userid, $db, 'voice', '');

        $voice_md5->portal_path = '../';  //variable to locate path
        if ($approved == '1') {
            $voice_md5->SaveChecksum();
        }
        else {
            $voice_md5->Clear();
        }
    }


    public function approve_evaluation($userid, $approved, $resource) {
        global $db;
        $evaluation_md5 = new AvailableStaffCheckSum($userid, $db, 'evaluation_comments', $resource);
        if ($approved == '1') {
            $evaluation_md5->SaveChecksum();
        }
        else {
            $evaluation_md5->Clear();
        }
    }


    public function manual_approve($userid, $datas, $product_id_fulltime, $product_id_parttime) {
        global $db;
        foreach ($datas as $data) {
            $resource_type = $data[0];
            $resource = $data[1];
            $approved = $data[2];
            $md5 = new AvailableStaffCheckSum($userid, $db, $resource_type, $resource);
            if ($approved == '1') {
                $md5->SaveChecksum();
            }
            else {
                $md5->Clear();
            }
        }
        //dont update staff rate if one is blank
        if (($product_id_fulltime != '') && ($product_id_parttime != '')) {
            //check first if it really needs to be updated
            $this->userid = $userid;
            $rates = $this->GetStaffRates();
            if (($product_id_fulltime != $rates['product_id']) || ($product_id_parttime != $rates['part_time_product_id'])) {
                $this->set_staff_rate($userid, $product_id_fulltime, $product_id_parttime);
            }
        }
    }

    public function convert_to_mp3($userid) {
        global $db;
        $sql = $db->select()
                ->from('personal', 'voice_path')
                ->where('userid = ?', $userid);
        $voice_path = $db->fetchOne($sql);

        //sanity check 
        $patterns = Array ('/&/', '/;/', '/>/', '/</', '/`/', '/#/', '/!/', '/\|/');
        $voice_path = preg_replace($patterns, '', $voice_path);

        if ($voice_path == False) {
            return False;
        }

        if (file_exists("../$voice_path")) {
            //check file type, extra steps for the wma since debian doesn't support directly converting wma to mp3
            $voice_parts = pathinfo($voice_path);
            if (strtolower($voice_parts['extension']) == 'wma') {
                $output = "uploads/voice/$userid.wav";
                $sh = sprintf("ffmpeg -v 0 -i ../%s -y ../%s", $voice_path, $output);
                $out = shell_exec($sh);

                $stat = stat("../$output");

                if (!stat) {
                    return 'stat() call failed wav...';
                }
                if ($stat['size'] == 0) {
                    return 'Failed to convert. Filesize is 0';
                }
                //delete the wma file
                unlink("../$voice_path");

                //re-assign $voice_path
                $voice_path = $output;
            }

            //convert using lame
            $output = "uploads/voice/$userid.mp3";
            $sh = sprintf("lame -m m --silent ../%s ../%s", $voice_path, $output);
            $out = shell_exec($sh);

            $stat = stat("../$output");

            if (!stat) {
                return 'stat() call failed for mp3...';
            }
            if ($stat['size'] == 0) {
                return 'Failed to convert. Filesize is 0';
            }

            //update voice_path
            $data = Array (
                'voice_path' => $output,
            );
            $db->update('personal', $data, "userid = $userid");

            //delete the file
            unlink("../$voice_path");
            return "Ok";
        }
        return False;
    }

    private function GetPhilippineTimeString() {
        $ph_tz = new DateTimeZone('Asia/Manila');
        $now = new DateTime();
        $now->setTimezone($ph_tz);
        return $now->format('Y-m-d H:i:s');
    }


    public function set_staff_rate($userid, $product_id_fulltime, $product_id_parttime) {
        global $db;
        $data = Array(
            'product_id' => $product_id_fulltime,
            'part_time_product_id' => $product_id_parttime,
            'userid' => $userid,
            'admin_id' => $this->admin_id,
            'date_updated' => $this->GetPhilippineTimeString()
        );
        $db->insert('staff_rate', $data);
        return 'Ok';
    }


    public function get_session_userid() {
        return $_SESSION['available_staff_checker_userid'];
    }
}

$server = new Zend_Json_Server();
$method = $server->getRequest()->getMethod();
if ($method == 'login') {
    $server->setClass('LoginAdmin');
}
else if ($method == 'get_rates') {
    $server->setClass('StaffRates');
}
else {
    $server->setClass('AvailableStaffChecker');
}
$server->handle();
?>
