<?php
//  2010-06-02  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Object for saving and setting checksum related to Available Staff
class AvailableStaffCheckSum {
    function __construct($userid, $db, $resource_type, $resource) {
        $this->userid = $userid;
        $this->db = $db;
        $this->resource_type = $resource_type;
        $this->resource = $resource;
        $this->portal_path = '../';     //to be overriden
        if ($logger) {
            $this->logger = $logger;
        }
    }

    private function ClearPic() {
        $admin_id = $_SESSION['admin_id'];
        if ($admin_id == '') {
            return False;
        }
        $this->db->delete('available_staff_checksum', sprintf('userid=%s and resource_type="picture"', $this->userid));
        return True;
    }

    private function SaveApplicantFiles() {
        //get file
        $sql = $this->db->select()
                ->from('tb_applicant_files', 'name')
                ->where('id = ?', $this->resource);
        $applicant_file = $this->db->fetchOne($sql);
        
        //no file found
        if ($applicant_file == False) {
            return False;
        }

        //check if file exists
        $file = sprintf('%sapplicants_files/%s', $this->portal_path, $applicant_file);
        if (file_exists($file) == False) {
            return False;
        }

        $md5 = md5_file($file);

        $data = Array(
            'userid' => $this->userid,
            'resource_type' => $this->resource_type,
            'resource' => $this->resource,
            'md5' => $md5,
            'admin_id' => $_SESSION['admin_id'],
            'time_stamp' => $this->GetPhilippineTimeString(),
        );

        $sql = $this->db->select()
                ->from('available_staff_checksum', 'id')
                ->where('userid = ?', $this->userid)
                ->where('resource_type = ?', $this->resource_type)
                ->where('resource = ?', $this->resource);
        $id = $this->db->fetchOne($sql);

        if ($id) {
            $this->db->update('available_staff_checksum', $data, "id = $id");
        }
        else {
            $this->db->insert('available_staff_checksum', $data);
        }
        return True;

    }

    private function SavePicture() {
        //get image
        $sql = $this->db->select()
                ->from('personal', 'image')
                ->where('userid = ?', $this->userid);
        $image = $this->db->fetchOne($sql);
        

        //no image found
        if ($image == False) {
            return False;
        }

        //check if file exists
        $file = sprintf("%s%s",$this->portal_path, $image);
        if (file_exists($file) == False) {
            return False;
        }
        $md5 = md5_file($file);

        $sql = $this->db->select()
                ->from('available_staff_checksum')
                ->where('userid = ?', $this->userid)
                ->where('resource_type = "picture"');
        $stored_md5 = $this->db->fetchAll($sql);

        $data = Array(
            'userid' => $this->userid,
            'resource_type' => 'picture',
            'md5' => $md5,
            'admin_id' => $_SESSION['admin_id'],
            'time_stamp' => $this->GetPhilippineTimeString(),
        );
        if (count($stored_md5) == 0) { //no record yet, insert one
            $this->db->insert('available_staff_checksum', $data);
        }
        else {
            $id = $stored_md5[0]['id'];
            $this->db->update('available_staff_checksum', $data, "id = $id");
        }
    }

    private function GetPhilippineTimeString() {
        $ph_tz = new DateTimeZone('Asia/Manila');
        $now = new DateTime();
        $now->setTimezone($ph_tz);
        return $now->format('Y-m-d H:i:s');
    }


    private function ApplicantFileValid() {
        //get file
        $sql = $this->db->select()
                ->from('tb_applicant_files', 'name')
                ->where('id = ?', $this->resource);
        $name = $this->db->fetchOne($sql);

        //no file found
        if ($name == False) {
            return False;
        }

        //check if file exists
        $file = sprintf("%s/applicants_files/%s", $this->portal_path, $name);
        if (file_exists($file) == False) {
            return False;
        }
        
        $md5 = md5_file($file);

        $sql = $this->db->select()
                ->from('available_staff_checksum', 'md5')
                ->where('userid = ?', $this->userid)
                ->where('resource_type = ?', $this->resource_type)
                ->where('resource = ?', $this->resource);
        $stored_md5 = $this->db->fetchOne($sql);

        return ($stored_md5 === $md5);

    }


    private function PictureValid() {
        //get image
        $sql = $this->db->select()
                ->from('personal', 'image')
                ->where('userid = ?', $this->userid);
        $image = $this->db->fetchOne($sql);

        //no image found
        if ($image == False) {
            return False;
        }

        //check if file exists
        $file = sprintf("%s%s", $this->portal_path, $image);
        if (file_exists($file) == False) {
            return False;
        }

        $sql = $this->db->select()
                ->from('available_staff_checksum', 'md5')
                ->where('userid = ?', $this->userid)
                ->where('resource_type = "picture"');
        $stored_md5 = $this->db->fetchOne($sql);
        if ($stored_md5 == False) {
            return False;
        }

        $md5 = md5_file($file);
        if ($stored_md5 == $md5) {
            return True;
        }
        return False;

    }


    public function Valid() {
        switch ($this->resource_type) {
            case 'picture':
                return $this->PictureValid();
                break;
            case 'personal':
                return $this->DetailsValid();
                break;
            case 'education':
                return $this->DetailsValid();
                break;
            case 'voice':
                return $this->VoiceValid();
                break;
            case 'evaluation_comments':
                return $this->EvaluationValid();
                break;
            case 'currentjob':
                return $this->DetailsValid();
                break;
            case 'language':
                return $this->OneToManyValid();
                break;
            case 'skills':
                return $this->OneToManyValid();
                break;
            case 'tb_applicant_files':
                return $this->ApplicantFileValid();
                break;
            default:
                return False;
        }
    }


    private function EvaluationValid() {
        //get comment
        $sql = $this->db->select()
                ->from('evaluation_comments', 'comments')
                ->where('id = ?', $this->resource);
        $comment = $this->db->fetchOne($sql);

        if ($comment == False) {
            return False;
        }

        if ($comment == '') {
            return False;
        }

        $sql = $this->db->select()
                ->from('available_staff_checksum', 'md5')
                ->where('resource_type = "evaluation_comments"')
                ->where('userid = ?', $this->userid)
                ->where('resource = ?', $this->resource);
        $md5 = $this->db->fetchAll($sql);
        if (count($md5) == 0) {
            return False;
        }
        return ($md5[0]['md5'] == md5($comment));

    }


    private function GetVoiceFileFromPersonalTable() {
        $sql = $this->db->select()
                ->from('personal', 'voice_path')
                ->where('userid = ?', $this->userid);
        return $this->db->fetchOne($sql);
    }


    private function VoiceValid() {
        $file = $this->portal_path.$this->GetVoiceFileFromPersonalTable();
        if (file_exists($file) == False) {
            return False;
        }

        $sql = $this->db->select()
                ->from('available_staff_checksum', 'md5')
                ->where('userid = ?', $this->userid)
                ->where('resource_type = "voice"');
        $md5 = $this->db->fetchOne($sql);

        return (md5_file($file) == $md5);
    }


    private function ResourceValid() {
        //get from resource 
        $sql = $this->db->select()
                ->from($this->resource_type, $this->resource)
                ->where('userid = ?', $this->userid);
        $fname = $this->db->fetchOne($sql);
        if ($fname == False) {
            return False;
        }

        $fname_md5 = md5($fname);
        //get from available_staff_checksum
        $sql = $this->db->select()
                ->from('available_staff_checksum', 'md5')
                ->where('userid = ?', $this->userid)
                ->where('resource_type = ?', $this->resource_type)
                ->where('resource = ?', $this->resource);
        $md5 = $this->db->fetchOne($sql);
        return ($fname_md5 == $md5);
    }


    private function GraduationDateValid() {
        $sql = $this->db->select()
                ->from($this->resource_type, Array('graduate_year', 'graduate_month'))
                ->where('userid = ?', $this->userid);
        $data = $this->db->fetchRow($sql);

        if ($data == False) {
            return False;
        }

        if (($data['graduate_year'] == Null) || ($data['graduate_year'] == '')) {
            return False;
        }

        if (($data['graduate_month'] == Null) || ($data['graduate_month'] == '')) {
            return False;
        }

        $graduate_md5 = md5($data['graduate_year'].$data['graduate_month']);

        //get from available_staff_checksum
        $sql = $this->db->select()
                ->from('available_staff_checksum', 'md5')
                ->where('userid = ?', $this->userid)
                ->where('resource_type = ?', $this->resource_type)
                ->where('resource = ?', $this->resource);
        $md5 = $this->db->fetchOne($sql);
        return ($graduate_md5 == $md5);
    }


    private function EmploymentPeriodValid($suffix) {
        $monthfrom  = sprintf('monthfrom%s', $suffix);
        $yearfrom   = sprintf('yearfrom%s', $suffix);
        $monthto    = sprintf('monthto%s', $suffix);
        $yearto     = sprintf('yearto%s', $suffix);

        $sql = $this->db->select()
                ->from($this->resource_type, Array(
                    $monthfrom,
                    $yearfrom,
                    $monthto,
                    $yearto,
                ))
                ->where('userid = ?', $this->userid);
        $data = $this->db->fetchRow($sql);

        if ($data == False) {
            return False;
        }

        $string = '';
        foreach ($data as $x) {
            if ($x == False) {
                return False;
            }
            if ($x == '') {
                return False;
            }
            $string = $string.$x;
        }
        $md5_period = md5($string);

        //get from available_staff_checksum
        $sql = $this->db->select()
                ->from('available_staff_checksum', 'md5')
                ->where('userid = ?', $this->userid)
                ->where('resource_type = ?', $this->resource_type)
                ->where('resource = ?', $this->resource);
        $md5 = $this->db->fetchOne($sql);
        return ($md5_period == $md5);
    }


    private function DetailsValid() {
        if (($this->resource_type == 'education') && ($this->resource == 'graduation_date')) {
            //special case scenario for validating graduation date
            return $this->GraduationDateValid();
        }
        else if (($this->resource_type == 'currentjob') && (strpos($this->resource, 'employment_period') === 0)) {
            $suffix = str_replace('employment_period', '', $this->resource);
            return $this->EmploymentPeriodValid($suffix);
            //special case for the employment_period
        }
        else {
            return $this->ResourceValid();
        }
    }


    private function SaveDetails() {
        if (($this->resource_type == 'education') && ($this->resource == 'graduation_date')) {
            //special case for the graduation_date
            $sql = $this->db->select()
                    ->from($this->resource_type, Array('graduate_year', 'graduate_month'))
                    ->where('userid = ?', $this->userid);
            $data = $this->db->fetchRow($sql);

            if ($data == False) {
                return False;
            }

            if (($data['graduate_year'] == Null) || ($data['graduate_year'] == '')) {
                return False;
            }

            if (($data['graduate_month'] == Null) || ($data['graduate_month'] == '')) {
                return False;
            }

            $md5 = md5($data['graduate_year'].$data['graduate_month']);
        }
        else if (($this->resource_type == 'currentjob') && (strpos($this->resource, 'employment_period') === 0)) {
            //special case for the employment_period
            $suffix = str_replace('employment_period', '', $this->resource);
            $sql = $this->db->select()
                    ->from($this->resource_type, Array(
                        sprintf('monthfrom%s', $suffix),
                        sprintf('yearfrom%s', $suffix),
                        sprintf('monthto%s', $suffix),
                        sprintf('yearto%s', $suffix),
                    ))
                    ->where('userid = ?', $this->userid);
            $data = $this->db->fetchRow($sql);
            
            if ($data == False) {
                return False;
            }
            $string = '';
            foreach ($data as $x) {
                if ($x == False) {
                    return False;
                }
                if ($x == '') {
                    return False;
                }
                $string = $string.$x;
            }
            $md5 = md5($string);
        }
        else {
            $sql = $this->db->select()
                    ->from($this->resource_type, $this->resource)
                    ->where('userid = ?', $this->userid);
            $detail = $this->db->fetchOne($sql);

            if ($detail == False) {
                return False;
            }
            $md5 = md5($detail);
        }

        //check if record exists on our checksum table
        $sql = $this->db->select()
                ->from('available_staff_checksum')
                ->where('userid = ?', $this->userid)
                ->where('resource_type = ?', $this->resource_type)
                ->where('resource = ?', $this->resource);
        $record_exists = $this->db->fetchAll($sql);

        $data = Array(
            'userid' => $this->userid,
            'resource_type' => $this->resource_type,
            'resource' => $this->resource,
            'md5' => $md5,
            'admin_id' => $_SESSION['admin_id'],
            'time_stamp' => $this->GetPhilippineTimeString()
        );
        if (count($record_exists) == 0) {
            $this->db->insert('available_staff_checksum', $data);
        }
        else {
            $id = $record_exists[0]['id'];
            $this->db->update('available_staff_checksum', $data, "id = $id");
        }
        return True;
    }


    private function SaveVoice() {
        $file = $this->portal_path.$this->GetVoiceFileFromPersonalTable();
        if (file_exists($file) == False) {
            return False;
        }

        //check first if record already exists
        $sql = $this->db->select()
                ->from('available_staff_checksum')
                ->where('userid = ?', $this->userid)
                ->where('resource_type = "voice"');
        $voice_checksum_exists = $this->db->fetchAll($sql);

        $md5 = md5_file($file);

        $data = Array(
            'userid' => $this->userid,
            'resource_type' => 'voice',
            'md5' => $md5,
            'admin_id' => $_SESSION['admin_id'],
            'time_stamp' => $this->GetPhilippineTimeString()
        );

        if (count($voice_checksum_exists) == 0) {
            $this->db->insert('available_staff_checksum', $data);
        }
        else {
            $id = $voice_checksum_exists[0]['id'];
            $this->db->update('available_staff_checksum', $data, "id = $id");
        }
    }


    private function SaveEvaluation() {
        //get comment
        $sql = $this->db->select()
                ->from('evaluation_comments', 'comments')
                ->where('id = ?', $this->resource);
        $comment = $this->db->fetchOne($sql);

        if ($comment == False) {
            return False;
        }

        if ($comment == '') {
            return False;
        }

        $sql = $this->db->select()
                ->from('available_staff_checksum')
                ->where('resource_type = "evaluation_comments"')
                ->where('userid = ?', $this->userid)
                ->where('resource = ?', $this->resource);
        $md5 = $this->db->fetchAll($sql);

        $data = Array(
            'userid' => $this->userid,
            'resource_type' => 'evaluation_comments',
            'resource' => $this->resource,
            'md5' => md5($comment),
            'admin_id' => $_SESSION['admin_id'],
            'time_stamp' => $this->GetPhilippineTimeString(),
        );

        if (count($md5) == 0) {
            $this->db->insert('available_staff_checksum', $data);
        }
        else {
            $id = $md5[0]['id'];
            $this->db->update('available_staff_checksum', $data, "id = $id");
        }

    }


    /*
    a generic md5 validator
    uses primary key id and userid field that links to personal.userid
    */
    private function OneToManyValid() {
        $sql = $this->db->select()
                ->from($this->resource_type)
                ->where('userid = ?', $this->userid)
                ->where('id = ?', $this->resource);
        $data = $this->db->fetchRow($sql);

        $str = '';
        foreach ($data as $rec) {
            if ($rec == False) {
                return False;
            }
            $str = $str.$rec;
        }
        if ($str == '') {
            return False;
        }

        $md5 = md5($str);


        //check record if it exist
        $sql = $this->db->select()
                ->from('available_staff_checksum', 'md5')
                ->where('resource_type = ?', $this->resource_type)
                ->where('userid = ?', $this->userid)
                ->where('resource = ?', $this->resource);

        $stored_md5 = $this->db->fetchOne($sql);

        return ($md5 === $stored_md5);

    }


    /*
    a generic md5 saver
    uses primary key id and userid field that links to personal.userid
    */
    private function SaveOneToMany() {
        $sql = $this->db->select()
                ->from($this->resource_type)
                ->where('userid = ?', $this->userid)
                ->where('id = ?', $this->resource);
        $data = $this->db->fetchRow($sql);

        $str = '';
        foreach ($data as $rec) {
            if ($rec == False) {
                return False;
            }
            $str = $str.$rec;
        }
        if ($str == '') {
            return False;
        }

        $md5 = md5($str);

        $data = Array(
            'userid' => $this->userid,
            'resource_type' => $this->resource_type,
            'resource' => $this->resource,
            'md5' => $md5,
            'admin_id' => $_SESSION['admin_id'],
            'time_stamp' => $this->GetPhilippineTimeString(),
        );

        //check record if it exist
        $sql = $this->db->select()
                ->from('available_staff_checksum', 'id')
                ->where('resource_type = ?', $this->resource_type)
                ->where('userid = ?', $this->userid)
                ->where('resource = ?', $this->resource);

        $old_record = $this->db->fetchOne($sql);

        if ($old_record) {
            $this->db->update('available_staff_checksum', $data, "id = $old_record");
        }
        else {
            $this->db->insert('available_staff_checksum', $data);
        }
        return False;
    }


    public function SaveChecksum() {
        $admin_id = $_SESSION['admin_id'];
        if ($admin_id == '') {
            return False;
        }
        switch ($this->resource_type) {
            case 'picture':
                return $this->SavePicture();
                break;
            case 'personal':
                return $this->SaveDetails();
                break;
            case 'voice':
                return $this->SaveVoice();
                break;
            case 'education':
                return $this->SaveDetails();
                break;
            case 'evaluation_comments':
                return $this->SaveEvaluation();
                break;
            case 'currentjob':
                return $this->SaveDetails();
                break;
            case 'language':
                return $this->SaveOneToMany();
                break;
            case 'skills':
                return $this->SaveOneToMany();
                break;
            case 'tb_applicant_files':
                return $this->SaveApplicantFiles();
                break;
            default:
                return False;
        }
    }


    public function Clear() {
        $admin_id = $_SESSION['admin_id'];
        if ($admin_id == '') {
            return False;
        }
        switch ($this->resource_type) {
            case 'picture':
                return $this->ClearPic();
                break;
            case 'personal':
                return $this->ClearDetails();
                break;
            case 'education':
                return $this->ClearDetails();
                break;
            case 'voice':
                return $this->ClearVoice();
                break;
            case 'evaluation_comments':
                return $this->ClearEvaluation();
                break;
            case 'currentjob':
                return $this->ClearDetails();
                break;
            case 'language':
                return $this->ClearDetails();
                break;
            case 'skills':
                return $this->ClearDetails();
                break;
            case 'tb_applicant_files':
                return $this->ClearDetails();
                break;
            default:
                return False;
        }
    }


    private function ClearEvaluation() {
        return $this->db->delete('available_staff_checksum', sprintf('userid=%s and resource_type="evaluation_comments" and resource="%s"', $this->userid, $this->resource));
    }


    private function ClearVoice() {
        return $this->db->delete('available_staff_checksum', sprintf('userid=%s and resource_type="voice"', $this->userid));
    }


    private function ClearDetails() {
            return $this->db->delete('available_staff_checksum', sprintf('userid=%s and resource_type="%s" and resource="%s"', $this->userid, $this->resource_type, $this->resource));
    }
}
?>
