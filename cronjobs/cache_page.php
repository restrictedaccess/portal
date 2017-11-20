<?php
include '../conf/zend_smarty_conf.php';
/**
 * Created by PhpStorm.
 * User: JMOQUENDO
 * Date: 3/31/17
 * Time: 10:40 AM
 */


global $curl;
$refresh = true;
$BASE_URI = "http://www.remotestaff.com.au";


if(TEST)
{
    $BASE_URI = "http://devs.remotestaff.com.au";
}
else if(STAGING)
{
    $BASE_URI = "http://staging.remotestaff.com.au";
}
else if(BETA)
{
    $BASE_URI = "http://beta.remotestaff.com.au";
}
else
{

}


$roles = array("va","php","writer","telemarketer","gd","webdes",
    "bookkeeper","accountant","seo","dataentry",
    "frontend","wpdev","qatester");



$roles2 = array("seo","boa","php","webdev","dataentry","cs",
    "va","gd","accountant","writer",
    "telemarketer","bookkeeper","ma","webdes");

$dedicated_roles = array("virtual-assistant","php-developer","writer","telemarketer",
    "graphic-designer","web-designer","bookkeeper","accountant","seo-specialist","data-entry-operator",
    "frontend-developer","wordpress-developer","qa-tester");

$landing_roles = array("virtual-assistants","php-developers","writers","telemarketer",
    "graphic-designers","web-designers","bookkeepers","accountants","seo-specialists","data-entry-operators",
    "back-office-admins","web-developers","customer-supports","telemarketers","marketing-assistants");


$links = array(

    "main" =>$BASE_URI."?refresh=".$refresh,
    "price-range"=>$BASE_URI."/view-price-range.php?refresh=".$refresh,
    "about-us"=>$BASE_URI."/aboutus.php?refresh=".$refresh,
    "rs-diff"=>$BASE_URI."/remote_staff_difference?refresh=".$refresh,
    "office-solution"=>$BASE_URI."/about/office-solution.php?refresh=".$refresh,
    "our-tech"=>$BASE_URI."/our_technology.php?refresh=".$refresh,
    "skill-assessment"=>$BASE_URI."/about/skill_assessment.php?refresh=".$refresh,
    "client-testimonials"=>$BASE_URI."/client-testimonials.php?refresh=".$refresh,
    "staffing-solutions"=>$BASE_URI."/about/staffing_solutions.php?refresh=".$refresh,
    "contact-us"=>$BASE_URI."/contactus.php?refresh=".$refresh,
    "terms"=>$BASE_URI."/terms.php?refresh=".$refresh,
    "privacy"=>$BASE_URI."/privacy.php?refresh=".$refresh,
    "agreement2"=>$BASE_URI."/agreement2.php?refresh=".$refresh,
    "sitemap"=>$BASE_URI."/sitemap.php?refresh=".$refresh,
    "staff-working"=>$BASE_URI."/staff_currently_working.php?refresh=".$refresh,
    "thank-you"=>$BASE_URI."/thankyou.php?refresh=".$refresh,
    "review-candidates"=>$BASE_URI."/review_candidates.php?refresh=".$refresh,
    "interview-bookings"=>$BASE_URI."/interview_bookings.php?refresh=".$refresh,
    "available-staff"=>$BASE_URI."/available-staff-resume?refresh=".$refresh,
    "thanks"=>$BASE_URI."/thanks.php?refresh=".$refresh,
    "video-presentation"=>$BASE_URI."/video-presentations.php?refresh=".$refresh,
    "j-video-presentation"=>$BASE_URI."/jobseekers-video-presentation.php?refresh".$refresh,
    "e-video-presentation"=>$BASE_URI."/employers-video-presentation.php?refresh=".$refresh,
    "c-video-presentation"=>$BASE_URI."/corporate-video-presentation.php?refresh=".$refresh,
    "mixergy-interview"=>$BASE_URI."/chris-jankulovski-mixergy-interview.php?refresh=".$refresh,
    "sutherland-interview"=>$BASE_URI."/chris-jankulovski-lisette-sutherland-interview.php?refresh=".$refresh,
    "genius-innovators"=>$BASE_URI."/about/genius_innovators.php?refresh=".$refresh,
    "seminar"=>$BASE_URI."/5-minute-seminar.php?refresh=".$refresh,
    "how-it-works"=>$BASE_URI."/client-services.php?refresh=".$refresh,
    "dedicated-roles"=>$BASE_URI."/roles/",
    "new-landing"=>$BASE_URI

);


foreach ($links as $key => $value)
{
    if($key == "dedicated-roles")
    {

        for($i = 0 ; $i < count($dedicated_roles); $i++)
        {
            $curl->get($value.$dedicated_roles[$i]."?refresh=".$refresh);
        }


    }

    if($key == "new-landing")
    {
        for($i = 0 ; $i < count($landing_roles); $i++)
        {
            $curl->get($value."/".$landing_roles[$i]."/?refresh=".$refresh);
        }

    }

    $curl->get($value);
}