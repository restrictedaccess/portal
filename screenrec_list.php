<?php
header('Access-Control-Allow-Origin: http://screen.remotestaff.net:5080');
header("Access-Control-Allow-Credentials: true"); 
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");

include '../conf/zend_smarty_conf.php';

$valid_session = (!empty($_SESSION['admin_id']) && empty($_SESSION['userid'])) ||
(empty($_SESSION['admin_id']) && !empty($_SESSION['userid']));

//if(empty($_SESSION['client_id'])) {
if( !$valid_session ) {
	header("location:index.php");
	exit;
}
$email = $_SESSION['emailaddr'];
if( !empty($_SESSION['admin_id']) ) {
	$userid = $_SESSION['admin_id'];
	$ind = 'ad';
} else {
	if( !empty($_SESSION['userid'])) {
		$userid = $_SESSION['userid'];
		$ind = 'sc';
	}
}
//$userid = empty($_SESSION['admin_id']) ? $_SESSION['userid'] : $_SESSION['admin_id'];
$rs_site = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
		? "https://". $_SERVER['HTTP_HOST'] : "http://". $_SERVER['HTTP_HOST'];
		
$select = $db->select()->from('rschat_users', array('conn_id') )
->where('userid=?', $userid)
->where('chatid=?', $userid.$ind);
$connid = $db->fetchOne( $select );
?>

<html>
<head>
<title>Screen Recording Links</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="/portal/ticketmgmt/css/ticket_styles.css">
<script language=javascript src="js/functions.js"></script>
<style type="text/css">
ul.howto {list-style-type:none;margin:0;}
</style>
</head>



<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<?php if ($_REQUEST["page_type"]!="iframe"):?>
<?php include 'header.php';?>
<?php //include 'client_top_menu.php';?>
<?php endif;?>
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr><?php if ($_REQUEST["page_type"]!="iframe"){
	?>
	<td width="24%"style="border-right: #006699 2px solid; width: 170px; vertical-align:top;"><?php //include 'clientleftnav.php';?></td>
	<?php }?>
<td style="width:100%;padding:15px;vertical-align:top;">
<p><strong>Screen Recording Links</strong></p>
<div>Your screen recorded report.<br/>
All screens links will remain for 3 months time and then deleted.
</div>
<iframe id='screenframe' name='screenframe' frameborder='0'
src='http://screen.remotestaff.net:5080/screen/screenlist_html.jsp?email=<?php echo $email;?>&userid=<?php echo $userid;?>&host=<?php echo $rs_site;?>&connid=<?php echo $connid;?>'
		scrolling="no" style='width:100%;height:100%;padding:1px;margin:1px;float:left;overflow:hidden;'></iframe>

</td>

</tr>


</table></td>
</tr>
</table>

<script type='text/javascript'>
var parentScrollTop = undefined;
function resizeScreenFrame(h){
    document.getElementById('screenframe').style.height = (50+parseInt(h))+'px';
	var parentframe = parent.document.getElementsByTagName('iframe');
	parentframe[0].style.height = (50+parseInt(h))+'px';
}
function getScrollOffset() {
	parent.document.onscroll = function() {
		parentScrollTop = parent.document.documentElement.scrollTop;
		console.log('scrolling:'+parentScrollTop);
		
	};
}
</script>

<?php if ($_REQUEST["page_type"]!="iframe"):?>
<?php include 'footer.php';?>
<?php endif;?>
</body>
</html>
