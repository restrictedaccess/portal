<html>
<head>
    <title>Personnel Information</title>
    <link rel=stylesheet type=text/css href="css/font.css">
    <link rel=stylesheet type=text/css href="adminmenu.css">
    <link rel=stylesheet type=text/css href="css/tooltip.css"> 
<style type="text/css">
{literal}
    #table_payment_details tr:hover {background-color: #FFFFCC;}
    th {font-weight: bold; font-size: 12; color: white; background: #888888;};
{/literal}
</style>
<script type="text/javascript" src="./js/tooltip.js"></script>
<script src="./js/sbox.js" type="text/javascript"></script>
</head>
<body style="margin-top:0; margin-left:0">
{php}include("./header.php"){/php}
{php}include("./admin_header_menu.php"){/php}

<table width=100% cellpadding=0 cellspacing=0 border=0>
    <tr>
        <td bgcolor="#666666" height="25" colspan=2><font color='#FFFFFF'><b> &nbsp; PERSONNEL INFO - INVOICE LIST</b></font></td>
    </tr>
    <tr>
        <td width="194" style='border-right: #FFFFFF 2px solid; width: 170px; vertical-align:top; '>
            {php}include("adminleftnav.php"){/php}
        </td>
        <td width=100% valign=top>
			<div style='width:97%;border:1px solid #aaa;float:left;'><div style='width:20%;height:100%;padding:12px 0 12px 4px;border-left:1px solid #aaa;float:right;'><a href='admin_personnel_info.php' style='text-decoration:none'>PERSONNEL LIST</a></div></div>
            
            <table cellpadding='0' cellspacing='0' class='list' style='float:left;width:auto;'>
            <tr><td>Total Record: {$items_total}</td>
            <td>&nbsp;</td>
               <td> &nbsp; {$pages}</td><td> &nbsp; {$items_pp} &nbsp; </td>
                  <td>{$jump_menu}</td>
				<td>
				
		        <form id="ff" name="ff" action="" method="GET">
            <div style="padding-left:8px;margin-left:8px;float:right;">	
            <span>Browse by:
            <select name="browse_by" onchange='ff.submit();'>
            <option value="">--</option>
            <option value="draft" {$sel_draft}>Draft</option>
			<option value="approved" {$sel_approved}>Approved</option>
			<option value="posted" {$sel_posted}>Posted</option>
			<option value="deleted" {$sel_deleted}>Deleted</option>
            </select></span> &nbsp; &nbsp;
         
            </div>
			<input type='hidden' name='list' value='1' />
            </form> 
     					
					
				</td>
            </tr>
           </table>

            <table cellpadding='3' class='invoice_list_contents' style='float:left;width:90%' id='invoice_list_drafts'>
                <th>ID</th><th>Invoice Date</th><th>Name</th>
                <th>Description</th>
				<th>Drafted by</th>
				<th>Start Date</th>
                <th>End Date</th>
				<th>Status</th>
				
               {if $personnel_invoices|@count > 0}
          	   {section name=idx loop=$personnel_invoices}

                    <tr bgcolor="{cycle values='#eeeeee,#d0d0d0'}">
                        <td>{$personnel_invoices[idx].id}</td>
						<td>{$personnel_invoices[idx].invoice_date}</td>
                        <td>{$personnel_invoices[idx].fname|escape} {$personnel_info[idx].lname|escape}</td>
                        <td><span onmouseover="tooltip('{$personnel_invoices[idx].payment_details}');"; onmouseout="exit();">{$personnel_invoices[idx].description}</span></td>
                        <td>{$personnel_invoices[idx].posted_by}</span></td>
                        <td>{$personnel_invoices[idx].start_date}</td>
						<td>{$personnel_invoices[idx].end_date}</td>
						<td>{$personnel_invoices[idx].status}</td>                        
                  
                        
                    </tr>
                {/section}
                {else}
                   <tr bgcolor="#d0d0d0"><td colspan='7'>No record found.</td></tr>
                {/if}
            </table>
            <table cellpadding='0' cellspacing='0' class='list' style='float:left;width:auto;'>
            <tr><td>Total Record: {$items_total}</td>
            <td>&nbsp;</td>
               <td> &nbsp; {$pages}</td><td> &nbsp; {$items_pp} &nbsp; </td>
                  <td>{$jump_menu}</td>
            </tr>
           </table>
        </td>
    </tr>
</table>

{php}include("./footer.php"){/php}
</body>
</html>

