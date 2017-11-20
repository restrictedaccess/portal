<?php

//include "./seat_header.php";
include '../conf/zend_smarty_conf.php';
header('Content-type: text/html; charset=UTF-8');

if( isset( $_REQUEST['query'] ) && $_REQUEST['query'] != "" ) {
    $q = addslashes( $_REQUEST['query'] );
	//$q = mysql_real_escape_string( $_REQUEST['query'] );

    if( isset( $_REQUEST['identifier'] ) ) {
		$iden = $_REQUEST['identifier'];
		switch ($iden) {
			case 'search': case 'staff_name':
				$sql = "SELECT * FROM (
					SELECT admin_id userid, admin_fname fname, concat(admin_lname,' (admin)') lname, admin_email email
					 FROM admin WHERE status <> 'REMOVED' AND status<>'PENDING'
					 AND (locate('$q',admin_fname)>0 OR locate('$q',admin_lname)>0 OR locate('$q',admin_email)>0
					 OR locate('$q', concat(admin_fname,' ',admin_lname))>0)
					 group by admin_id
					UNION ALL
					SELECT s.userid, p.fname, p.lname, p.email
					 FROM subcontractors s LEFT JOIN personal p ON s.userid=p.userid
					 WHERE s.status='ACTIVE' AND p.email IS NOT NULL AND s.leads_id=11
					  AND (locate('$q',fname)>0 OR locate('$q',lname)>0 OR locate('$q',email)>0
					  OR locate('$q', concat(fname,' ',lname))>0)
					  group by userid
					UNION ALL
					SELECT agent_no userid, fname, concat(lname,' (bp)') lname, email
					 FROM agent	WHERE status='ACTIVE' AND work_status='BP'
					  AND (locate('$q',fname)>0 OR locate('$q',lname)>0 OR locate('$q',email)>0
					  OR locate('$q', concat(fname,' ',lname))>0)
					  group by userid
					) list
				ORDER BY list.fname, list.lname ASC";
				break;
			case 'staff_id':
				$sql = "SELECT p.userid, p.fname, p.lname FROM personal p
				LEFT JOIN subcontractors s ON s.userid=p.userid
				where p.userid LIKE '$q%' AND s.status!='deleted'
				group by userid order by p.userid limit 13";
				//$sql = "SELECT userid, fname, lname FROM personal where ('$q',fname) > 0 order by locate('$q',fname) limit 10";
				break;
			case 's2':
				$sql = "SELECT s.userid, p.email, p.fname, p.lname FROM subcontractors s LEFT JOIN rp_staff p ON s.userid=p.userid where locate('$q',fname)>0 OR locate('$q',lname)>0 OR locate('$q',email)>0 OR locate('$q', concat(fname,' ',lname))>0 order by locate('$q',fname) limit 13";
				break;
			case 'client_name':
				$sql = "SELECT * FROM (
					SELECT id userid, fname, lname FROM leads WHERE (locate('$q',fname)>0
					OR locate('$q',lname)>0 OR locate('$q',email)>0
					OR locate('$q', concat(fname,' ',lname))>0) AND status='Client' group by id
					UNION ALL 
					SELECT l.id userid, l.fname, l.lname FROM member m
					LEFT JOIN leads l ON m.leads_id=l.id
					WHERE (locate('$q',fname)>0 OR locate('$q',lname)>0 OR locate('$q',email)>0
					OR locate('$q', concat(fname,' ',lname))>0) AND l.status='Client' group by l.id) clients
					ORDER BY clients.fname, clients.lname";
				break;
		}
	}
	$row = $db->fetchAll( $sql );

	echo '<ul>'."\n";
	for( $i = 0; $i < count($row); $i++ ) {
		if( in_array($iden, array('client_id', 'staff_id')) ) $p = $row[$i]['userid'];
		else $p = $row[$i]['fname'] . ' ' .$row[$i]['lname'];// . ' ('.$row[$i]['email'].')';
		$p = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold;color:#ff0000;">$1</span>', $p);
		echo "\t".'<li id="autocomplete_'.$row[$i]['userid'].'" rel="'.$row[$i]['userid'].'_' . $row[$i]['fname'].'_'.$row[$i]['email'] . '">'.  $p  .'</li>'."\n";
	}
	echo '</ul>';


   /* elseif( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "lname")
    {
	//$sql = isset( $_REQUEST['extraParam'] ) ? " and email = " . mysql_real_escape_string( $_REQUEST['extraParam'] ) . " " : "";
	$sql = "SELECT * FROM tb_cidades where locate('$q',lname) > 0 $sql order by locate('$q',lname) limit 10";
	$r = mysql_query( $sql );

	    echo '<ul>'."\n";
	    while( $l = mysql_fetch_array( $r ) )
	    {
		$p = $l['nome'];
		$p = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold;">$1</span>', $p);
		echo "\t".'<li id="autocomplete_'.$l['id'].'" rel="'.$l['id'].'_' . $l['uf'] . '">'. utf8_encode( $p ) .'</li>'."\n";
	    }
	    echo '</ul>';
	}
    }*/
   exit();
}

?>