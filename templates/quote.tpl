{*
2012-02-24  Normaneil Macutay <normanm@remotestaff.com.au>
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remote Staff Quote Management</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="./quote/media/css/quote.css">
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="./quote/media/js/quote.js"></script>


<body style="margin:0;">
<form name="form" method="post" enctype="multipart/form-data" action="" accept-charset = "utf-8">
<input type="hidden" name="leads_id" id="leads_id" value="{$leads_id}" />


{php}include("header.php"){/php}
	
{if $agent_section eq True}
		{php}include("BP_header.php"){/php}
{/if}
	
{if $admin_section eq True}
		{php}include("admin_header_menu.php"){/php}
{/if}
<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#EEEEEE">
<tr>
<td valign="top" bgcolor="#FFFFFF" width="30%">
<div class="search">Search Quote : <input type="text" name="keyword" id="keyword" size="35"   /> <input type="button" name="search_btn" id="search_btn" value="search" /></div>
<div id="quote_list"></div>
</td>
<td valign="top" width="70%" >
<div class="search"><span>Quote Management</span> <input type="button" id="create_quote_btn" value="Create New" /><br clear="all" /></div>
<div id="quote_details">Select a Quote on the list to be view details...</div>
</td>
</tr>
</table>

{php}include("footer.php"){/php}
</form>
{literal}
<script>
ShowAllQuotes();
connect('search_btn', 'onclick', ShowAllQuotes);
connect('create_quote_btn', 'onclick', CreateNewQuote);
</script>
{/literal}
</body>
</html>
