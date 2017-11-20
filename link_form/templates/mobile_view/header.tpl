<!-- start: TRACKING CODE FOR PHONE NUMBER EXECUTION -->


<input type="hidden" id="contact_numbers_forcall_mobile" value="{$contact_numbers_forcall.aus_header_number}">

<!-- header xs -->
<nav class="navbar navbar-default navbar-top navbar-static-top nav-top-2 mobile-header-navigation">
	<div class="container-fluid header-container">
		<div class="row">
			<div class="col-xs-12 header-panel">
				<div class="pull-right phone-logo">
					<a id = "ga_mobile_number_tracker" href="tel:{$contact_numbers_forcall.aus_header_number}" ><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></a>
				</div>
				<div class="pull-left">
				<!-- insert mmenu here-->
				<a id="menu-toggle" type="button" class="navbar-toggle collapsed">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar" style="background-color: #00AFD9;"></span>
					<span class="icon-bar" style="background-color: #00AFD9;"></span>
					<span class="icon-bar" style="background-color: #00AFD9;"></span>
				</a>
				
				</div>
				<div class="navbar-header text-center" style="margin-top: 10px">  
					<a class="rs-logo" href="{$url}/aboutus.php#corevalues-m"><img src="/remotestaff_2015/img/rs-fb-header.png" alt="logo" class="remotestaff-logo img-rounded logo-top"></a>
				</div>
		</div>
	</div>
	
	<div class = "row contact-panel">
			<div class ="col-xs-5">
					<p>Australia</p>
					<a href="tel:{$contact_numbers_forcall.aus_office_number}">{$contact_numbers.aus_office_number}</a>
			</div>
			<div class ="col-xs-1"><div class="vertical-line-separator"></div></div>
			<div class ="col-xs-5">
					<p>Worldwide</p>
					<a href="tel:{$contact_numbers_forcall.aus_company_number}">{$contact_numbers.aus_company_number}</a>
					<span class="mobile-number-glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			</div>
	</div>
	
</nav>
<!--/.nav-collapse -->
<!--/ header xs -->