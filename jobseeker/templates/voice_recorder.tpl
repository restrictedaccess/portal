<!-- Voice Uploader Modal -->
{* 2013-02-14 - the src file of iframe has moved to doc.root to prevent the warning/blocking of flash app from chrome *}
{* add starting point *}
{php}$_SESSION['VREC'] = true;{/php}
<div id="voiceRecorder" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="voiceModalLabel">Record your voice</h3>
  </div>
  <div class="modal-body">
    <form name="upload" action="" method="post" enctype="multipart/form-data" id="uploader">
	<input type="hidden" id="action" name="action" value="upload">
	<table cellspacing="1" cellpadding="3" width="100%">
		<tbody><tr>
			<td style="text-align:center;">
			<iframe id="vrframe" frameborder="0" scrolling="no" src="{$host}/audio_client.php?login=jobseeker&amp;email={$user.email}&userid={$user.userid}" style="width:100%;height:150px;"></iframe>
			</td>											
		</tr>
		<tr>
			<td align="left">
				Click on Record button above.
				State your first name and a quick introduction on your work experiences and skills.
				The recording should not last more than 2 minutes. You can re-do your voice recording until you are satisfied.
				Click Sync to finally upload your voice recording. The voice recording is important to identify your level of spoken English.
				DO NOT RECORD ANY CONTACT DETAILS.  
			</td>
		</tr>
		<tr>
        <td align="right">
        <input type="hidden" id="from_button"></td>
      </tr>
	</tbody></table>
	</form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id="sync_voice_record">Sync Voice Record</button>
  </div>
</div>