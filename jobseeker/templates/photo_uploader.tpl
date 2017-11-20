<!-- Photo Uploader Modal -->
<div id="photoUploader" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="photoModalLabel">Upload Photo</h3>
  </div>
  <div class="modal-body">
    <form enctype="multipart/form-data" name="upload" method="post">
    	<div id="picture_path_uploader"></div>
    	<a id="photo_select_button" class="btn" href="#">Select Photo</a><br/><br/>
    	<small><span class="label label-important">Note:</span> Upload files only in JPEG or GIF format, with the file extension as .jpg, .jpeg or .gif.</small>
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id="upload_photo_dialog">Upload Photo</button>
  </div>
</div>