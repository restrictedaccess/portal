<html>
<head>
    <title>Personnel Information</title>
    <link rel=stylesheet type=text/css href="css/font.css">
    <link rel=stylesheet type=text/css href="adminmenu.css">
    <link rel=stylesheet type=text/css href="css/tooltip.css"> 
<style type="text/css">
{literal}
    #table_personnel_details {float:left;}
    #table_personnel_details tr:hover {background-color: #FFFFCC;}
    th {font-weight: bold; font-size: 12; color: white; background: #888888;};
{/literal}
</style>
<script type="text/javascript" src="./js/tooltip.js"></script>
<script src="./js/sbox.js" type="text/javascript"></script>
</head>
<body style="margin-top:0; margin-left:0">
{php}include("header.php"){/php}
{php}include("admin_header_menu.php"){/php}

<table width=100% cellpadding=0 cellspacing=0 border=0>
    <tr>
        <td bgcolor="#666666" height="25" colspan=2><font color='#FFFFFF'><b> &nbsp; PERSONNEL INFORMATION</b></font></td>
    </tr>
    <tr>
        <td width="194" style='border-right: #FFFFFF 2px solid; width: 170px; vertical-align:top; '>
            {php}include("adminleftnav.php"){/php}
        </td>
        <td width=100% valign=top>
            <div style='width:97%;border:1px solid #aaa;float:left;'><div style='width:20%;height:100%;padding:12px 0 12px 4px;border-left:1px solid #aaa;float:right;'><a href='admin_personnel_invoicelist.php?list=1' style='text-decoration:none'>INVOICE LIST</a></div></div>
            
            <table cellpadding='0' cellspacing='0' class='list' style='float:left;width:auto;border:1px solid #aaa;'>
            <tr><td>Total Record: {$total_rec}</td>
            <td>{$items_total}</td>
               <td> &nbsp; {$pages}</td><td> &nbsp; {$items_pp} &nbsp; </td>
                  <td>{$jump_menu}</td>
            </tr>
           </table>
            

            <table id="table_personnel_details" cellpadding='3'>
                <th>#</th><th>Personnel Name</th><th>Email Address</th><th>Nationality</th>
                <th>Telephone No.</th><th>Address</th>
                <th>Bank Account/s</th>
               {if $personnel_info|@count > 0}
          	   {section name=idx loop=$personnel_info}

                    <tr bgcolor="{cycle values='#eeeeee,#d0d0d0'}">
                        <td>{math equation="x+y" x=$smarty.section.idx.index y=$ipp+1}</td>
                        <td><span onmouseover="tooltip('{if $personnel_info[idx].image}<img src=\'{$personnel_info[idx].image}\'>{else}USER-ID: {$personnel_info[idx].userid}{/if}');"; onmouseout="exit();">{$personnel_info[idx].fname|escape} {$personnel_info[idx].lname|escape}</span></td>
                        <td>{$personnel_info[idx].email}</td>
                        <td><span onmouseover="tooltip('Permanent Residence: {$personnel_info[idx].permanent_residence}');"; onmouseout="exit();">{$personnel_info[idx].nationality}</span></td>
                        <td><span onmouseover="tooltip('Mobile No.: {$personnel_info[idx].handphone_country_code}-{$personnel_info[idx].handphone_no}');"; onmouseout="exit();"><span style='cursor:pointer;'>&nbsp; &nbsp;{$personnel_info[idx].tel_area_code}-{$personnel_info[idx].tel_no}</span></span></td></td>
                    
                        <td>{$personnel_info[idx].address1|cat:$personnel_info[idx].address2|cat:' '|cat:$personnel_info[idx].postcode|cat:' '|cat:$personnel_info[idx].city|truncate:50:'...'}</td>
                        <td><a href='admin_personnel_bank_info.php?userid={$personnel_info[idx].userid}' style='text-decoration:none;' onclick="return show_hide_box(this, 500, 350, '1px dashed', 0,50)">click here</a></td>
                        
                        
                  
                        
                    </tr>
                {/section}
                {else}
                   <tr bgcolor="#d0d0d0"><td colspan='7'>No record found.</td></tr>
                {/if}
            </table>
            <table cellpadding='0' cellspacing='0' class='list' style='float:left;width:auto;'>
            <tr><td>Total Record: {$total_rec}</td>
            <td>{$items_total}</td>
               <td> &nbsp; {$pages}</td><td> &nbsp; {$items_pp} &nbsp; </td>
                  <td>{$jump_menu}</td>
            </tr>
           </table>
        </td>
    </tr>
</table>
sdfsdf
{php}include("footer.php"){/php}
</body>
</html>
