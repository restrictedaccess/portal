<div id="nav">
    <img src="./media/images/remote_staff_logo.png" />
	<div id="navholder">
        <div id="navbox">
            <ul>
		        <li>&nbsp;</li>
				<li><a href="./" id="navadminhome">Team</a></li>
				{foreach from=$navs item=nav name=nav}
				    <li><a href="./?nav={$nav}" {if $selected_nav eq $nav} id="navselected" {/if}>{$nav|upper}</a></li>
				{/foreach}
				<li><a href="addteam.php" id='navaddteam'>Add A Team</a></li>
			</ul>
		</div>
	</div>			
</div>
<h2 align="center">Recruitment Team Management</h2>