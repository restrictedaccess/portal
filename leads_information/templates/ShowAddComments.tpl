<div class="comment_div">
<div style=" background:#CA0000; color:#FFFFFF; font-weight:bold; padding:3px;">Comments / Note</div>
<table width='100%'>
<tr><td valign="top" colspan='2'>
<div style="height:300px; overflow-y:scroll; overflow-x:hidden; border:#fff solid 1px;">
<table class='mess_box' width='100%'>
{$comments_result}
</table>
</div>
</td></tr>
<tr><td colspan='2' style="background:#EEEEEE;">
<b>Add Comment / Note</b><br />
<textarea name="message" id="message"  style="width:590px; height:100px;" ></textarea><br />
<input type="button" class="lsb" value="Add & Save" onclick="AddComment({$invoice_id})" /> <input class="lsb" type="button" value="close" onclick="toggle('comment_div')" />
</td></tr>
</table>
</div>