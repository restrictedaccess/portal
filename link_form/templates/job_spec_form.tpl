<!doctype html>
<html class="no-js" lang="">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="google-site-verification" content="pFwgC_ROSWz4vRknFzyDk4A5Xg1qsttXmYBlvFdQzbc" />
		<!-- Bootstrap Core CSS -->
		<link rel="canonical" href="https://remotestaff.com.au/portal/link_form/job_specification_form.php">


<!-- Bootstrap Core CSS -->

		 <!-- Facebook Pixel Code / all pages -->
    <script defer src="/remotestaff_2015/js/fb_pixel_code/fb_pixel_code_all_pages.js"></script>
    <noscript>
        <img height="1" width="1" style="display:none"src="https://www.facebook.com/tr?id=1563269480622812&ev=PageView&noscript=1"/>
    </noscript>

		{include file = "css_include.tpl"}
		<link rel="stylesheet" href="/remotestaff_2015/css/header_v2.css"/>
		
		<title>Job Specification Form</title>
	</head>
	
	<body>
		{include file = "request_call_back.tpl"}
        {php}
			if(isset($_SESSION["link_form_success"])):
		{/php}
		
		<div class="row">
			<div class="col-lg-3">

			</div>
			<div class="col-lg-12">
				<div class="form-group alert alert-info text-center" style="width:50%;margin-left: 26%;margin-top: 3%;font-size:115%;">
                    <span><p>
                    {php}
                    	echo $_SESSION["link_form_success"];
                    {/php}
                    </p></span>
            	</div>
			</div>
		</div>
		{php}
			unset($_SESSION["link_form_success"]);
		{/php}
        {php}
        	endif;
        {/php}
        
			<div id="wrapper" >
			{include file="mobile_view/mobile_navigation.tpl"}
			<div class="color-fade">
					<div id="page-content-wrapper">

					<div class="mobile-view-header">
						{include file="mobile_view/header.tpl"}
					</div>
					<div class="desktop-view-header">
						{include file="header_v2.tpl"}
					</div>
					<div id = "key-benefits" style="position:absolute;top: -130px;"></div>
					
					<div class="container-fluid">
					{include file = "job_spec_form_fold1.tpl"}
					</div>
				<div class="mobile-view-header">
					{include file="mobile_view/footer.tpl"}
				</div>

				<div class="desktop-view-header">
					{include file="new_dedicated_footer.tpl"}
					{include file="footer.tpl"}
				</div>

				<div class="mobile-view-header">
					<div class = "float_buttons_ipad">
						<!-- <a href="http://chat.zoho.com/mychat.sas?u=11c9151727d333f9aca5af5701ae1ffa&chaturl=Remote%20Staff&V=ffffff-82d5cd-82d5cd-caf6f3-Remote%20Staff" target="_blank" class="cd-chat-lg"></a> -->
						<a href="#0" class="cd-top-lg"></a>
					</div>

					<div class = "float_buttons_mobile">
						<!--<a href="http://chat.zoho.com/mychat.sas?u=11c9151727d333f9aca5af5701ae1ffa&chaturl=Remote%20Staff&V=ffffff-82d5cd-82d5cd-caf6f3-Remote%20Staff" target="_blank" class="cd-chat"></a> -->
						<a href="#0" class="cd-top"></a>
					</div>
				</div>

				<div class="desktop-view-header">
					<!-- <a href="http://chat.zoho.com/mychat.sas?u=11c9151727d333f9aca5af5701ae1ffa&chaturl=Remote%20Staff&V=ffffff-82d5cd-82d5cd-caf6f3-Remote%20Staff" target="_blank" class="cd-chat-lg"></a>-->
					<a href="#0" class="cd-top-lg"></a>
				</div>
			</div>
			</div>
		</div>

			
			
			
		<input id="base_api_url" type="hidden" value="{$base_api_url}" />
		
		{include file = "js_include.tpl"}
 
	</body>
</html>
