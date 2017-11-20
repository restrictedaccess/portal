<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>RemoteStaff Communication History for {$leads_name}</title>
<script language=javascript src="js/MochiKit.js"></script>
<script language=javascript src="js/functions.js"></script>
{literal}
<style type="text/css">
	pre {
	    white-space: -moz-pre-wrap; /* Mozilla, supported since 1999 */
	    white-space: -pre-wrap; /* Opera */
	    white-space: -o-pre-wrap; /* Opera */
	    white-space: pre-wrap; /* CSS3 - Text module (Candidate Recommendation) http://www.w3.org/TR/css3-text/#white-space */
	    word-wrap: break-word; /* IE 5.5+ */
	}
</style>
{/literal}
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action="viewHistory.php?id={$result.id}"  >
<div><img src='./images/remote_staff_logo.png' width='241' height='70'></div>
<div style=" background:url(../images/remote-staff-nav-bg.jpg) top repeat-x; height:40px; color:#FFFFFF; line-height:40px; font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; padding-left:20px;">#{$leads_id} {$leads_name}</div>
{ if $actions eq 'CSR' }
  
  <div align="right" style="padding:5px;">
  {if $enabled_button eq True }
  <input type="button" value="edit" id="edit" /><input type="submit" value="delete" name="delete" />
  {else}
  <input type="button" value="edit" id="edit" disabled="disabled" /><input type="button" value="delete" name="delete" disabled="disabled" />
  {/if}
  </div>
  
{ /if }
<div id="history_csr" style="display:none;">
<table  width="100%" cellpadding="0" cellspacing="1" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-top:20px;">

{foreach from=$csrs item=csr name=csr}
  <tr>
    <td width="37%" ><b>{$csr.question}</b>
    <input type="hidden" name="question[{$smarty.foreach.csr.index}]"  value="{$csr.question}" /></td>
    <td width="63%" align="left" valign="top"><textarea name="answer[{$smarty.foreach.csr.index}]"   style="width:100%; height:50px;" >{$csr.answer}</textarea></td>
  </tr>
{/foreach}
  <tr>
    <td >&nbsp;</td>
    <td valign="top"><input type="submit" class="lsb" name="save_csr" value="Save"  /><input type="button" value="cancel" id="cancel"  /></td>
  </tr>  
</table>  
</div>






<div id="history">
<table  width="100%" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-top:20px;">
    <tr>
    <td width='2%' valign='top'><img src='leads_information/media/images/quote.png'></td>
    <td width='98%' valign='top'  style="border-left:#CCCCCC solid 1px; padding-left:5px;">
    
    
    <div style="vertical-align:top; margin-bottom:10px;">{$message}</div>
    <div style=" color:#999999;">{$creator} - , {$result.date_created|date_format:"%A, %B %e, %Y %H:%M:%S %p"}<br />Communication Type : {if $result.actions eq 'MAIL'} NOTES {else} {$result.actions} {/if}</div>
    </td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
</table>
</div>
{literal}
<script>
connect('edit' , 'onclick', ShowEditForm);
connect('cancel' , 'onclick', HideEditForm);
function ShowEditForm(e){
  appear('history_csr');
  fade('history');
}

function HideEditForm(e){
  fade('history_csr');
  appear('history');
}
</script>
{/literal}
</form>
</body>
</html>


