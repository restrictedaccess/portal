header("location:/portal/compliance_v2/#/leave-request/search");
exit;

include '../../conf/zend_smarty_conf.php';
include '../../leave_request_form/leave_request_function.php';

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;


if($_SESSION['admin_id']){
	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$_SESSION['admin_id']);
	$admin = $db->fetchRow($sql);
	
}else{
    header("location:/portal/");
    exit;
}



$sql = "SELECT DISTINCT(p.userid) , p.fname , p.lname, s.id FROM personal p JOIN subcontractors s ON s.userid = p.userid WHERE s.status IN('ACTIVE', 'suspended') ".$search_str2." ORDER BY p.fname";
$staffs = $db->fetchAll($sql);


$sql = "SELECT * FROM admin a WHERE csro='Y' AND status NOT IN('PENDING','REMOVED') ORDER BY admin_fname ASC;";
$csros = $db->fetchAll($sql); 


$smarty->assign('nodejs_api' , $nodejs_api);
$smarty->assign('start_date' , date("Y-m-d"));
$smarty->assign('end_date' , date("Y-m-d"));
$smarty->assign('staffs' , $staffs);
$smarty->assign('csros', $csros);
$smarty->assign('admin' , $admin);
$smarty->display('index.tpl');
?>