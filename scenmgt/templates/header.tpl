			<header>
				
				<nav id="skipTo">
					<ul>
						<li>
							<a href="#main" title="Skip to Main Content">Skip to Main Content</a>
						</li>
					</ul>
				</nav>
				
				<h1 style="background:url(/portal/site_media/client_portal/images/rs_logo.png) no-repeat left;height:60px;">Testing</h1>
				
				{*<div style='float:left;padding-left:12px;font-weight:normal'>#{$admin.admin_id} - {$admin.admin_fname}</div>
				<div id='menu-top'>
					<ul>
					<li><a href="?/index/">Home</a></li>
					<li><a href="?/admin/">Client Concerns</a>
						<!--<div class='submenu'>
							<a href='#'>Client Concerns</a>
							<a href='#'>Users</a>
							<a href='#'>Configuration</a>
						</div>-->
					</li>					
					<li><a href="/portal/adminHome.php">Portal</a></li>
					<!--<li><a href="#">Logout</a></li>-->
					</ul>
				</div>*}
				<!--<div id="layoutdims">
					<div style='float:left;'><strong></strong> Create Test Session</div>
						<div><a href="">Create Session</a> | <a href="javascript:void(0);" onclick="alert('Not yet available')">Open Session</a> | <a href="javascript:void(0);" onclick="alert('Not yet available')">Reports</a> | <a href="">Logout</a></div>
				</div>-->
				<div style='height:50px;padding:6px;line-height:100px;float:right;'>
					Today is: {$date_now}
					<!--<input type='hidden' name='search' style='width:150px' id='search_input' maxlength='20'/>--></div>
				
				
				<nav><span style='float:right'>Logged in as: {$admin.admin_fname} #{$admin.admin_id}</span>
					<!--<ul style='font-weight:normal'>
						<li><a href='?/admin_client_concerns/0/&modal=true' id='listconcerns' title="Client Concerns">Client Concerns</a></li>	
					</ul>-->
					<ul>
						<li><a href="#" title="Admin Portal">Portal</a></li>
						<li><a href="?/admin/" title="Manage Client Concern">Manage Concerns</a>
						<li><a href="?/index/" title="Display Clients">Clients</a></li>
						
						<!--<a href='?/show_form/11' id='open_concern' style='float:right;padding-right:6px;font-weight:bold'>Client Concern List</a>-->
					</ul>
				</nav>
				
			</header>
			<script type='text/javascript'>{literal}var ccqa = {};{/literal}</script>
			<script src="static/js/admin_qa.js"></script>