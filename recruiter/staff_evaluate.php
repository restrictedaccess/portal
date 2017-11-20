<?php
include_once('../conf/zend_smarty_conf.php');
include '../function.php';

$agent_no = $_SESSION['agent_no'];
$userid=$_REQUEST['userid'];
$action = $_REQUEST['action'];
echo '
<html>
<head>
<title>Eveluation Form</title>
<meta HTTP-EQUIV=\'Content-Type\' charset=\'utf-8\'>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../css/style.css">
<link rel=stylesheet type=text/css href="../css/resume.css">
<script type="text/javascript" src="/portal/js/jquery.js"></script> 
<script type="text/javascript" src="category/category.js"></script>
<link rel=stylesheet type=text/css href="category/category.css">
</style>
</head>
<body bgcolor=\'#FFFFFF\'>
<div id="container">';
include("category/showEvaluationForm.php"); 
echo '
</div>
</body>
</html>';