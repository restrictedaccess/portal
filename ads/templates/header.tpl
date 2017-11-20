{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>
{if $mode eq 'create'}
{$mode|capitalize} {$job_title.selected_job_title} Advertisement
{else}
{$ad.jobposition}
{/if}
</title>

{foreach from=$stylesheets item=stylesheet}
    <link rel="stylesheet" type="text/css" href="{$stylesheet}" />
{/foreach}

{foreach from=$javascripts item=javascript}
    <script src="{$javascript}" type="text/javascript"></script>
{/foreach}


</head>

<body {$body_attributes} >


<div style="background:#FFFFFF;"><img src="./../images/remote-staff-logo.jpg" /></div>
<div id="border-top" style=" background:url(./media/images/remote-staff-nav-bg.jpg); height:40px; line-height:40px; text-align:center; color:#FFFFFF; font-weight:bold; font-size:18px;">{$job_title.selected_job_title}</div>



<div id="container">
{if $added_flag eq True}
<div style=" background:#FFFF00; text-align:center; font-weight:bold; padding:5px;">New Job Advertisement Created</div>
{/if}

<!--
{if $existing_flag eq True}
<div style=" background:#FFFF00; text-align:center; font-weight:bold; padding:5px;">Already Existing</div>
{/if}
-->


{if $updated_flag eq True}
<div style=" background:#FFFF00; text-align:center; font-weight:bold; padding:5px;">Updated Successfully</div>
{/if}




{/strip}
