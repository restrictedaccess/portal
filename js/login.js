$(function() {

	function before_login(){
		var email = jQuery(this).children("input[name=email]");
		var value = jQuery.trim(email.val());
		email.val(value);
		return true;
	}
	$("form").submit(before_login);
	
    // expose the form when it's clicked or cursor is focused
    var form = $(".expose").bind("click keydown", function() {

        $(this).expose({

            // when exposing is done, change form's background color
            onLoad: function() {
                form.css({backgroundColor: '#ffffff'});
                $('.login_error').remove();
            },

            // when "unexposed", return to original background color
            onClose: function() {
                form.css({backgroundColor: '#ffffff'});
                $("#id_jobseeker_login")[0].reset();
                $("#id_contracted_staff_login")[0].reset();
                $("#id_business_partner_login")[0].reset();
                $("#id_inhouse_admin_login")[0].reset();
                $("#id_client_login")[0].reset();
                $("#id_referral_partner_login")[0].reset();
            }

        });
    });

    $("#id_jobseeker_login").validator({
        position: 'top right',
        offset: [22, 8]
    });

    $("#id_contracted_staff_login").validator({
        position: 'top right',
        offset: [22, 8]
    });

    $("#id_business_partner_login").validator({
        position: 'top right',
        offset: [22, 8]
    });

    $("#id_inhouse_admin_login").validator({
        position: 'top right',
        offset: [22, 8]
    });

    $("#id_client_login").validator({
        position: 'top left',
        offset: [22, -280]
    });

    $("#id_referral_partner_login").validator({
        position: 'top left',
        offset: [22, -280]
    });

    $(".retrieve_pass").bind("click", function() {
        url = $(this).attr("url");
        window.open(url, 'forgot', 'width=580, height=380');
    });

});

