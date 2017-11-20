/**
 * Load staff for endorsement script file
 */
jQuery(document).ready(function() {
	jQuery("#endorse-staff").click(function(e) {

		var data = {};

		jQuery(".evaluation_notes_item").each(function() {
			if( typeof data[jQuery(this).attr("data-userid")] == "undefined") {
				data[jQuery(this).attr("data-userid")] = [];
			}

			if(jQuery(this).is(":checked")) {
				data[jQuery(this).attr("data-userid")].push(jQuery(this).val());
			}
		});

		jQuery.post("/portal/recruiter/set_evaluation_notes_to_session.php", {
			eval_notes : data
		}, function(response) {
			jQuery.get("/portal/recruiter/load_staff_for_endorsement.php?json=1", function(data) {
				data = jQuery.parseJSON(data);
				if(data.result) {
					var width = screen.width;
					var height = screen.height;
					previewPath = "/portal/endorsement/multiple-endorse.php";
					window.open(previewPath,'_blank','width='+width+',height='+height+',resizable=yes,toolbar=no,directories=no,location=no,menubar=no,fullscreen=yes,scrollbars=yes,status=no');
					//location.href = "/portal/endorsement/multiple-endorse.php";
				} else {
					alert("One or more of the staff resume is not yet created.");
				}
			});
		});


		e.preventDefault();
	});
	jQuery(".evaluation_notes_item").parent().parent().sortable();
	jQuery(".open-popup").click(function(e) {
		path = $(this).attr("href");
		var height = screen.height;
		window.open(path, '_blank', 'width=700,height=' + height + ',resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		e.preventDefault();
	});
});
