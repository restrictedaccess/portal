/**
 * @version 0.2 - Added Mike Lacanilao Record Voice Function
 * @version 0.1 - New jobseeker portal
 */
jQuery(document).ready(function(){
	jQuery(".popup").click(function(e){
		popup_win7(jQuery(this).attr("href"), 950, 600);
		e.preventDefault();
	})
	
	/**
	 * Upload voice build element
	 */
	var uploaderVoice = new qq.FileUploader({
		element: jQuery("#voice_recording_uploader")[0],
		button:jQuery("#voice_select_button")[0],
		autoUpload:false,
		multiple:false,
		action:"/portal/jobseeker/upload_voice.php",
		onComplete:function(id, filename, response){
			if (response.success){
				alert("You have successfully uploaded your voice recording.")
				jQuery("#voiceUploader").modal("hide");	
				window.location.reload();
			}
			
		}
		
	})
	
	jQuery("#upload_voice").live("click", function(e){
		uploaderVoice.uploadStoredFiles();
		e.preventDefault();
	});
	
	/**
	 * Event to launch the dialog for recording
	 * 2013-2-14 - added .get() request to create session //@mike
	 */
	jQuery("#record_voice").click(function(e){
		jQuery.get("/portal/jobseeker/create_session.php", function(data){
			jQuery("#voiceRecorder").modal({backdrop: 'static',keyboard: true})
			if( data != 'usernotfound' ) {
				var frame_src = jQuery("#vrframe").attr("src");
				var _href = frame_src.split("&sid");
				jQuery("#vrframe").attr("src", _href[0] + "&sid=" + data);
			} else alert('Session not found.');
		});
		e.preventDefault()
	})

	/**
	 * Event to sync recording
	 */	
	jQuery("#sync_voice_record").click(function(e){
		var data = jQuery("#uploader").serialize()
		jQuery.post("/portal/jobseeker/sync_voice.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				alert("You have successfully synced the voice you recorded in your profile")
				window.location.reload();
			}
		})
	})
	
	/**
	 * Upload file build element
	 */
	var uploaderFile = new qq.FileUploader({
		element: jQuery("#file_uploader")[0],
		button:jQuery("#file_select_button")[0],
		autoUpload:false,
		multiple:false,
		action:"/portal/jobseeker/upload_files.php",
		
		onComplete:function(id, filename, response){
			if (response.success){
				alert("You have successfully uploaded the file you are uploading.")
				window.location.reload();
			}
			
		}
		
	})
	
	jQuery("#upload_file").live("click", function(e){
		uploaderFile.setParams({
			type:jQuery("#file_description").val()
		});
		uploaderFile.uploadStoredFiles();
		e.preventDefault();
	});
	
	
	jQuery(".delete_file").live("click", function(e){
		var me = jQuery(this);
		var href = me.attr("href");
		jQuery.get(href, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				me.parent().parent().fadeOut(500, function(){
					jQuery(this).remove();
				})
			}else{
				alert("File deletion failed");
			}
		})
		e.preventDefault();
	})
})
