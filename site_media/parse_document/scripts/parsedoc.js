(function($){
	parsedoc = (function(){
	    return {
			addFiles:function() {
				$('#loading').empty().append('Scanning uploaded documents, please wait...').show();
					$('div.show_files').jqmShow();
				$.get('/portal/django/parse_document/files/',{}, function(data) {
					if($('div.show_files').css('display')=='none')
            $('div.show_files').jqmShow();
					
					$('div.show_files').html(data);
					//$('#loading').hide();
					parsedoc.addResult('init');
				});
			},
			
		    addResult:function(errormsg) {
				//$('div.show_files').jqmHide();
			    if(errormsg && errormsg!='init') {
				    $('#loading').empty().append(errormsg).show();//.fadeOut(10000);
			    } else {
				    $('#loading').empty().append('Loading Documents...').show();
				    //$('div.show_files').jqmHide();
					$.getJSON('/portal/django/parse_document/get_doclist/',{}, function(data) {
						if(data.Error) {
							$('#loading').text(data.Error);
							return;
						}
						
						$('#leftpane').find("p:gt(0)").remove();
						for(var i=0,len=data.length; i<len-1; i++) {
							$('#leftpane')
							.append($('<p/>')
									.append( $('<a/>')
											.attr('href','/portal/django/parse_document/get_content/'+data[i].title + '/'+data[i].ext).text(data[i].title)
											.click(function(e){
												$('#ifcontent').attr('src', $(this).attr('href') )
												e.preventDefault();
											})
									) );
						}
						$('#loading').hide();
						if(errormsg!='init')$('div.show_files').jqmHide();
					});
			    }
	        }
		}
	}());
	$(document).ready(function(){
		$('div.show_files').jqm({ajax: '@href', trigger: 'a#showfiles'});
		
		$('aside a').click(function(e){
			//console.log($(this).attr('href'));
			$('#ifcontent').attr('src', $(this).attr('href') );
			//console.log($('#ifcontent').attr('src'));
			e.preventDefault();
		});
		
		$('#search_input').val('Search...').css('color','#666')
		.keyup(function(e) {
			$(this).css('color','#000');
			//console.log('keyup:'+e.keyCode);				 
			if (e.keyCode == 13) {
				var text = $(this).val();
				var maxLength = $(this).attr("maxlength");
				var length = text.length;
									
				// submit
				if (length <= maxLength + 1) {
					if( length > 1) {
						$('#ifcontent').attr('src', '/portal/django/parse_document/search_content/'+text );
						$(this).val('Search...').css('color','#666');
					}
				} else {
					$(this).val(text.substring(0, maxLength));
				}	
			}
		}).blur(function() {
			$(this).css('color','#666');
			if($(this).val() == '') $(this).val('Search...');
			return true;
		}).focus(function() {
			if($(this).val() == 'Search...') $(this).val('');
			else $(this).select();
		});
		
		parsedoc.addFiles();
	});
})(jQuery);
