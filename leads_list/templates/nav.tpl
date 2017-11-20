<script type="text/javascript" src="/portal/bugreport/pullmenu.js"></script>
<link rel=stylesheet type=text/css href="/portal/seatbooking/css/pullmenu.css">
<script type="text/javascript" src="/portal/js/full-text-search-function.js"></script>



<div id="nav">
    <img src="./media/images/remote_staff_logo.png" />
	<span>{$current_user.user_type}: <a href="../admin_profile.php">#{$current_user.id} {$current_user.fname} {$current_user.lname}</a><br />
		<a href="/portal/bubblehelp/bhelp.php?/create_page/&curl={$current_url}" title="Open Help Page" target="_blank">Help Page</a> | 
		{ if $admin_section eq True }
		<a href="#" onmouseover="showReportMenu(this)" onmouseout="mclosetime()" style='text-decoration:none;color:#666666;'>Bug Report</a>  |
		<a href="https://dokuwiki.remotestaff.com.au/dokuwiki/doku.php?id=start" title="Open the Wiki page" target="_blank" class="hlink">Wiki</a> |
		{ else }
		<a href="#" onmouseover="showReportMenu(this)" onmouseout="mclosetime()" style='text-decoration:none;color:#666666;'>Bug Report</a>  |
		{/if}
		<a href="../logout.php" >Logout</a>
		</span>	
		{if $admin_section eq True}
		<div style = "float:right; padding-top:45px;padding-right:15px;">
	<form action="/portal/recruiter_search/recruiter_search.php" method="GET">
		<input type="text" class="form-control" id="full-text-search" placeholder="Search Candidate, Job Order, Leads" name="q" style="border: 1px solid #c4c4c4; height: 20px; 
    margin-top: 4px;
    width: 275px; 
    font-size: 13px;  
   border-radius: 4px; 
    -moz-border-radius: 4px; 
    -webkit-border-radius: 4px; 
    box-shadow: 0px 0px 8px #d9d9d9; 
    -moz-box-shadow: 0px 0px 8px #d9d9d9; 
    -webkit-box-shadow: 0px 0px 8px #d9d9d9;">	
		<button type="submit" id="full-text-search-button" style="margin-top:-5px;height:23px;">
			Search
		</button>
	</form>
	</div>
	{else}
	{/if}
	
<?php 
$api_url = "";
if(TEST){
	$api_url = "http://test.remotestaff.com.au/portal/recruiter_search/recruiter_search.php";
}else{
	$api_url = "http://remotestaff.com.au/portal/recruiter_search/recruiter_search.php";	
} 
?>
<input type="hidden" id="api_url" value="<?php echo $api_url ?>"/>		
	<div id="navholder">
        <div id="navbox">
            <ul>
		        <li>&nbsp;</li>
				{ if $admin_section eq True }
                    <li><a href="../adminHome.php" id="navadminhome">Home</a></li>
					{ if $current_user.menu_status eq 'FULL-CONTROL' || $current_user.menu_status eq 'COMPLIANCE'}
					    <li><a href='/portal/recruiter/recruiter_home.php' >Recruitment</a></li>
					{/if}
				{ else }
				    <li><a href="../agentHome.php" id="navadminhome">Home</a></li>
				{ /if }
				
				{ foreach from=$statuses item=status}
				    { if $lead_status eq $status}
					    {if $status eq 'Client'}
						    <li id="sample_attach_menu_parent">
							{foreach from=$flag_menus item=flag}
								{if $flag.status eq $status}
								    {$flag.flag}
								{/if}
				            {/foreach}
							<a href="index.php?lead_status=Client" id="navselected" >{$status|capitalize}</a>
							</li>
						{else}
                            <li>
							{foreach from=$flag_menus item=flag}
								{if $flag.status eq $status}
								    {$flag.flag}
								{/if}
				            {/foreach}
							<a href="index.php?lead_status={$status}" id="navselected">{$status|capitalize}</a>
							</li>
						{/if}
					{ else }
					    {if $status eq 'Client'}
						    <li id="sample_attach_menu_parent">
							{foreach from=$flag_menus item=flag}
								{if $flag.status eq $status}
								    {$flag.flag}
								{/if}
				            {/foreach}
							<a href="index.php?lead_status=Client"   >{$status|capitalize}</a>
							</li>
						{else}
                            <li>
							{foreach from=$flag_menus item=flag}
								{if $flag.status eq $status}
								    {$flag.flag}
								{/if}
				            {/foreach}

							<a href="index.php?lead_status={$status}" >{$status|capitalize}</a>
							</li>
						{/if}
					{ /if }	
				{ /foreach}
				
				{ if $admin_section eq True }
					<li><a href="/portal/subcon_management/rssc_reports.html"> Sub Contractors Management</a></li>
                    <li><a href='../subconlist.php'>List of Sub Contractors</a></li>
					<li><a href='/portal/ticketmgmt/'>Tickets</a></li>
				{ else }
				    <li><a href="../bp_affiliates.php">Affiliates</a></li>
				{ /if }
                
            </ul>
		</div>	
    </div>
</div>
<div id="sample_attach_menu_child">
<a class="sample_attach" href="index.php?lead_status=Client&filter=ACTIVE">Active Clients</a>
<a class="sample_attach" href="index.php?lead_status=Client&filter=INACTIVE">Inactive Clients</a>
<a class="sample_attach" href="index.php?lead_status=Client">All Clients</a>
</div>
{literal}
<script type="text/javascript">
at_attach("sample_attach_menu_parent", "sample_attach_menu_child", "hover", "y", "pointer");
</script>
{/literal}