<?php

class Contact{
    
     public function rs_contact_numbers($db){
            
            $rs_contact_nos_sql = $db -> select()
                                      -> from('rs_contact_nos')
                                      -> where('active =?', 'yes');
            $rs_contact_nos = $db->fetchAll($rs_contact_nos_sql);
        
            foreach($rs_contact_nos as $number){
                if($number['site'] == 'aus' and $number['type'] == 'header number'){
                    $aus_header_number .= sprintf('%s<br>', $number['contact_no']);
                    $aus_header_trunkline_number = $number['contact'];
                }
                if($number['site'] == 'aus' and $number['type'] == 'company number'){
                    $aus_company_number .= sprintf('%s<br>', $number['contact_no']);
                    $aus_company_trunkline_number = $number['contact'];
                }
                if($number['site'] == 'aus' and $number['type'] == 'office number'){
                    $aus_office_number .= sprintf('%s<br>', $number['contact_no']);
                    $aus_office_trunkline_number = $number['contact'];
                }
                if($number['site'] == 'aus' and $number['type'] == 'office number' and $number['description'] == 'AUS Toll Free Number'){
                    $aus_toll_number .= sprintf('%s<br>', $number['contact_no']);
                    $aus_toll_trunkline_number = $number['contact'];
                }
                
                if($number['site'] == 'usa' and $number['type'] == 'company number'){
                    $usa_company_number .= sprintf('%s<br>', $number['contact_no']);
                    $usa_company_trunkline_number = $number['contact'];
                }
                
                if($number['site'] == 'php' and $number['type'] == 'company number'){
                    $php_company_number .= sprintf('%s<br>', $number['contact_no']);
                    $php_company_trunkline_number = $number['contact'];
                }
                if($number['site'] == 'uk' and $number['type'] == 'header number'){
                    $uk_header_number .= sprintf('%s<br>', $number['contact_no']);
                    $uk_header_trunkline_number = $number['contact'];
                }
                if($number['site'] == 'uk' and $number['type'] == 'company number'){
                    $uk_company_number .= sprintf('%s<br>', $number['contact_no']);
                    $uk_company_trunkline_number = $number['contact'];
                }
                
                
                
            }
            $aus_header_number = substr($aus_header_number,0,(strlen($aus_header_number)-4));
            $aus_company_number =substr($aus_company_number,0,(strlen($aus_company_number)-4));
            $aus_office_number = substr($aus_office_number,0,(strlen($aus_office_number)-4));
            $usa_company_number = substr($usa_company_number,0,(strlen($usa_company_number)-4));
            $php_company_number = substr($php_company_number,0,(strlen($php_company_number)-4));
            $aus_toll_number = substr($aus_toll_number,0,(strlen($aus_toll_number)-4));
            $uk_header_number = substr($uk_header_number,0,(strlen($uk_header_number)-4));
            $uk_company_number = substr($uk_company_number,0,(strlen($uk_company_number)-4));
            
            return array(
                'rs_contact_nos' => $rs_contact_nos,
                'aus_numbers' => $aus_numbers,
                'aus_header_number' => $aus_header_number,
                'aus_header_trunkline_number'=>$aus_header_trunkline_number,
                'aus_company_number' => $aus_company_number,
                'aus_company_trunkline_number'=>$aus_company_trunkline_number,
                'aus_office_number' => $aus_office_number,
                'aus_office_trunkline_number'=>$aus_office_trunkline_number,
                'usa_company_number' => $usa_company_number,
                'usa_company_trunkline_number'=>$usa_company_trunkline_number,
                'php_company_number' => $php_company_number,
                'php_company_trunkline_number'=>$php_company_trunkline_number,
                'aus_toll_number' => $aus_toll_number,
                'aus_toll_trunkline_number'=>$aus_toll_trunkline_number,
                'uk_header_number'=>$uk_header_number,
                'uk_company_number'=>$uk_company_number
            );
    }
    
}        
      
