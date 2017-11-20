(function($) {
	rep = (function(){
		return {
			search_onblur : function(id) {
				id.css('color','#666');
				if(id.val() == '') id.val('search staff name');
				return true;
			},
			showUsers : function(obj) {
				var userslist = $('div.userslist');
				if(obj.value == 'select') {
					userslist.show();
					//document.getElementsByClass('userslist').style.display = 'block';
					//$('select[name=users]').blur().attr('disabled',true);
					if(userslist.height() > 400) userslist.height(400);
					if(userslist.height() > $('#iFrameRep').height()) $('#iFrameRep').height(userslist.height());
					//console.log(obj.options.length);
				} else {
					userslist.hide();
				}
				// remove the extra option from select field
				if(obj.options.length > 2) obj.remove(2);
			},
			hideUsers : function() {
				$('div.userslist').hide();
				$('select[name=users]').removeAttr('disabled');
			},
			filterReport : function(summary) {
				summary = (typeof summary !== 'undefined') ? summary : '';
				var datefrom = document.getElementById('from_date').value;
				var dateto = document.getElementById('to_date').value;
				var category = document.getElementById('category').value;
				var selectuser = document.getElementsByName("selectUser[]");
				var selUser = document.getElementsByName("users")[0];
				
				//console.log(datefrom+' - '+category + ':'+selUser.value);
				var tickArr = new Array();
				if(selUser.value == 'all') {
					for(var i=0; i < selectuser.length; i++) tickArr.push(selectuser[i].value);
				} else {
					for(var i=0; i < selectuser.length; i++){
						if ( selectuser[i].checked ) tickArr.push(selectuser[i].value);
					}
				}
				//console.log(tickArr);
				if(selUser.selectedIndex == 1 && selUser.options.length < 3) {
					//this.hideUsers();
					//console.log(selUser);
					var opt = document.createElement('option');
					opt.value = 'custom';
					opt.text = 'Custom select';
					selUser.add(opt);
					selUser.selectedIndex = 2;
					//console.log(selUser.options.length);
					//selUser.options[selUser.options.length] = new Option('Text 1', 'Value1');
					
				}
				$('#loading').show();
				document.getElementById('iFrameRep').src='?item=createreport&users='+tickArr.join(',')+'&datefrom='+datefrom+'&dateto='+dateto+'&category='+category+'&summary='+summary;
				this.hideUsers();
			}
		}
	}());
	$(document).ready(function() {
		$(window).keydown(function(event){
			if(event.keyCode == 13 && event.target.nodeName == 'INPUT') {
			  event.preventDefault();
			  return;
			}
		});
		
		Calendar.setup({inputField : "from_date", trigger: "from_date", onSelect: function() { this.hide()  },//showTime   : 12,
			fdow:0, dateFormat : "%Y-%m-%d"
		});
		
		Calendar.setup({inputField : "to_date", trigger: "to_date", onSelect: function() { this.hide()  },//showTime   : 12,
			fdow:0, dateFormat : "%Y-%m-%d"
		});
		
		$('#iFrameRep').load(function() {
			var ifheight = $(this).contents().find('body').height();
			$(this).height(ifheight);
		});
	});
})(jQuery);