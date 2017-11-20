<?php
    
    require_once("./conf/zend_smarty_conf_root.php");
    require_once('./lib/misc_functions.php');
    require_once('./lib/paginator.class.php'); 

    
    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    if (!$admin_id){
        die('Invalid ID for Admin.');
    }

        
    $show_all = getVar('list', 0);
    $browse_by = getVar('browse_by');
    $sql_where = '';
    
    date_default_timezone_set("Asia/Manila");
    
    $smarty = new Smarty();
    
    $pages = new Paginator;
    $pages->items_total = $db->fetchOne("SELECT count(*) total_count FROM subcon_invoice");
        
    $pages->mid_range = 7;
    $pages->items_per_page = 50;
    $pages->paginate();
    
    $pages->items_total;

    
    if (!$show_all) {
        die('Invalid option.');      
        
    } else {
        
        if ($browse_by) $sql_where = "WHERE inv.status='$browse_by'";
        
        //$sel_{$browse_by} = 'selected';
        $sel_name = "sel_{$browse_by}";
        
        $query = "SELECT id, invoice_date, inv.status, description, inv.payment_details, updated_by, start_date, end_date, "
        . "total_amount, fname, lname, IF( admin_fname IS NOT NULL, admin_fname, p.fname ) posted_by from subcon_invoice inv "
        . "left join personal p ON inv.userid=p.userid LEFT JOIN admin ON inv.drafted_by=admin.admin_id $sql_where "
        . "order by invoice_date ".$pages->limit;
            
        
        
        
        $smarty->assign('ipp', $pages->low);
        $smarty->assign('items_total', $pages->items_total);
        $smarty->assign('pages', $pages->display_pages());
        $smarty->assign('jump_menu', $pages->display_jump_menu());
        $smarty->assign('items_pp', $pages->display_items_per_page());
        
        $smarty->assign($sel_name, 'selected');
        
        $smarty->assign('personnel_invoices', $db->fetchAll($query));
        $smarty->display('admin_personnel_invoicelist.tpl');
    
    }

    

?>
