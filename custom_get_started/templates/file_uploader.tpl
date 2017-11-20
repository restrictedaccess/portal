<!-- File Uploader Modal -->
<div id="fileUploader" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="fileModalLabel">Upload Files</h3>
  </div>
  <div class="modal-body">
    <form enctype="multipart/form-data" name="upload" method="post">
    	<input type="hidden" name="gs_job_titles_details_id" id="file_gs_job_titles_details_id"/>
    	<div id="file_path_uploader"></div>
    	<a id="file_select_button" class="btn" href="#">Select File Attachment</a><br/><br/>
    	<small><span class="label label-important">Note:</span> Upload files only in DOC, DOCX, XLS, XLSX or PDF, with the file extension<br/> as .doc, .docx, .xls, .xlsx or .pdf.</small>
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id="upload_file_dialog">Upload Attachment</button>
  </div>
</div>
<!-- /File Uploader Modal -->