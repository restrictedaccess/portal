<?php
if (isset($_GET["staff_status"])){
	$staff_status = $_GET["staff_status"];
	if ($staff_status=="UNPROCESSED"){
		include "recruiters/unprocessed.php";
	}else if ($staff_status=="INACTIVE"){
		include "recruiters/inactive.php";
	}else if ($staff_status=="PRESCREENED"){
		include "recruiters/prescreened.php";		
	}else if ($staff_status=="SHORTLISTED"){
		include "recruiters/shortlisted.php";		
	}else if ($staff_status=="ENDORSED"){
		include "recruiters/endorsed.php";	
	}else if ($staff_status=="ALL"){
		include "recruiters/viewall.php";
	}else if ($staff_status=="CATEGORIZED"){
		include "recruiters/categorized.php";
	}else if ($staff_status=="REMOTEREADY"){
		include "recruiters/remoteready.php";	
	}else{
		include "recruiters/viewall.php";
	}
}else{
	include "recruiters/viewall.php";
}