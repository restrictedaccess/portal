<!-- Voice Uploader Modal -->
<div id="voiceUploader" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="voiceModalLabel">Upload Voice Recording</h3>
  </div>
  <div class="modal-body">
    <form enctype="multipart/form-data" name="upload" method="post">
    	<div id="voice_recording_uploader"></div>
    	<a id="voice_select_button" class="btn" href="#">Select Voice Recording</a><br/>
    	
    	<small><span class="label label-important">Note:</span> Upload voice only MP3, WAV, or WMA files.</small>
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id="upload_voice_dialog">Upload Voice</button>
  </div>
</div>