/**
 * @version 0.1 - New jobseeker portal
 */
jQuery(document).ready(function(){
	
	
	init_reset_password_first("jobseeker", jQuery("#jobseeker_date_registered").val());
	
	jQuery(".popup").click(function(e){
		popup_win7(jQuery(this).attr("href"), 950, 600);
		e.preventDefault();
	})
	
	/**
	 * Open photo dialog click button event
	 */
	jQuery("#upload_photo").click(function(e){
		jQuery("#photoUploader").modal({backdrop: 'static',keyboard: true})
		e.preventDefault();
	})
	
	/**
	 * Upload photo build element
	 */
	var uploaderPhoto = new qq.FileUploader({
		element: jQuery("#picture_path_uploader")[0],
		button:jQuery("#photo_select_button")[0],
		autoUpload:false,
		multiple:false,
		action:"/portal/jobseeker/upload_photo.php",
		onComplete:function(id, filename, response){
			if (response.success){
				alert("You have successfully uploaded your picture.")
				jQuery("#photoUploader").modal("hide");
				window.location.reload();
			}
			
		}
		
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
	
	
	
	
	/**
	 * Upload file to server
	 */
	jQuery("#upload_photo_dialog").live("click", function(e){
		uploaderPhoto.uploadStoredFiles();
		e.preventDefault();
	})
	
	/**
	 * Open voice dialog click button event
	 */
	jQuery("#upload_voice").live("click", function(e){
		jQuery("#voiceUploader").modal({backdrop: 'static',keyboard: true})
		e.preventDefault();
	});
	
	
	jQuery("#upload_voice_dialog").live("click", function(e){
		uploaderVoice.uploadStoredFiles();
		e.preventDefault();
	});
});
