var selected_href = "http://test.remotestaff.com.au/rs/candidates/web_development/php_development/";

jQuery( document ).ready( function() {

	for( var x = 1; x <= 12; x++ ) {

		var image = new Image();

		image.src = "pics/model-"+x+".png";

	}

	jQuery( ".link-role-home" ).on( "click", function( e ) {

		e.preventDefault();

		selected_href = jQuery( this ).attr( "href" );

		jQuery( "#role-home" ).text( jQuery( this ).text() );

		jQuery( ".hourty-rate" ).text( "From " + jQuery( this ).attr("data-price") + "/hour" );

		jQuery( ".image-changer" ).attr("src", "pics/model-" + jQuery( this ).attr( "data-index" ) + ".png" );
		
		var index = $(this).data('index');
		
		//PHP DEVELOPER
		if(index==6){
			
			$('.job_role').html('PHP Developer');
			
			$('.bubble').html('"I need a PHP developer with 3 years experience fluent in CSS, Javascript and HTML with attention to detail and good English communication skills."');
			
		//VIRTUAL ASSISTANT
		}else if(index==3){
			
			$('.job_role').html('Virtual Assistant');
			
			$('.bubble').html('"I need a virtual assistant with strong organisational skills, someone who is a problem solver, has initiative and can communicate clearly and professionally."');
			
		//WRITER
		}else if(index==7){
			
			$('.job_role').html('Writer');
			
			$('.bubble').html('"I need a writer with an exceptional grasp of the English language, with experience writing content for websites, such as blog posts, reports and webpages."');
			
		//MARKETING ASSISTANT
		}else if(index==2){
			
			$('.job_role').html('Marketing Assistant');
			
			$('.bubble').html('"I need a marketing assistant who has successfully ran profitable PPC campaigns on Google Adwords, Facebook and LinkedIn."');
			
		//TELEMARKETER
		}else if(index==5){
			
			$('.job_role').html('Telemarketer');
			
			$('.bubble').html('"I need a telemarketer with previous call center experience to assist with appointment setting, must be driven, self motivated and love working with clients."');
			
		//GRAPHIC DESIGNER
		}else if(index==12){
			
			$('.job_role').html('Graphic Designer');
			
			$('.bubble').html('"I need a graphic designer who can produce print ready documents using Adobe inDesign and Photoshop, with a solid portfolio of marketing collateral work."');
			
		//WEB DESIGNER
		}else if(index==11){
			
			$('.job_role').html('Web Designer');
			
			$('.bubble').html('"I need a web designer with experience in backend development, jQuery, AJAX, PHP, mySQL skills are a must, previous work on Amazon AWS APIs a bonus."');
			
		//DATA ENTRY OPERATOR
		}else if(index==9){
			
			$('.job_role').html('Data Entry Operator');
			
			$('.bubble').html('"I need a data entry assistant with expert Microsoft Excel skills, reliable and highly accurate, experience in internet research and data mining work a plus."');
			
		//BACK OFFICE ADMIN
		}else if(index==8){
			
			$('.job_role').html('Data Office Admin');
			
			$('.bubble').html('"I need a back-office admin to assist with day to day business tasks, must have strong communication and organisation skills, experience with Microsoft Office suite."');
			
		//SEO SPECIALIST
		}else if(index==4){
			
			$('.job_role').html('SEO Specialist');
			
			$('.bubble').html('"I need an SEO specialist to assist with white hat link building, must have an understanding of how to locate high quality do-follow backlinks."');
			
		//BOOKKEEPER
		}else if(index==1){
			
			$('.job_role').html('Bookkeeper');
			
			$('.bubble').html('"I need a bookkeeper to maintain accounts receivable and payable sheets, business activity statements for GST and expense sheets, high level Excel skills critical."');
			
		//ACCOUNTANT
		}else if(index==10){
			
			$('.job_role').html('Accountant');
			
			$('.bubble').html('"I need a general accountant with working knowledge of the Australian taxation system, expert Microsoft Excel skills, experience in Xero an advantage."');
			
		}

	} );

	jQuery( ".bnt-view-candidates" ).on( "click", function( e ) {

		e.preventDefault();

		e.stopPropagation();

		window.location.href = selected_href;

	} );

	jQuery( document ).on( "click", ".number2", function( e ) {

		e.preventDefault();

		var id = $( this ).attr( "href" );

		var offset = $( id ).offset();

		$( "html, body" ).animate( {

			scrollTop: offset.top

		}, 2000);

	} );

} );
