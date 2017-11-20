		var curSubMenu = '';
		var selected_x_id = 0;
		
		function lead(id) 
		{
			previewPath = "viewLead.php?id="+id;
			window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}			

		function voucher_details(id) 
		{
			previewPath = "admin_request_for_interview_popup.php?v="+id;
			window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}			
		
		function update(id) 
		{
			previewPath = "update_endorse_to_client.php?id="+id;
			window.open(previewPath,'_blank','width=500,height=400,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
	
		function showSubMenu(menuId)
		{
			if (curSubMenu!='') 
				hideSubMenu();
			
			eval('document.all.'+menuId).style.visibility='visible';
			curSubMenu=menuId;
		}
		
		function hideSubMenu()
		{
			eval('document.all.'+curSubMenu).style.visibility='hidden';
			curSubMenu='';
		}
		
		var voucher_obj = makeObject()
		function update_voucher(id,voucher)
		{
			selected_x_id = id;
			var comments = document.getElementById('comments_'+id).value;
			var date_expire = document.getElementById('date_expire_'+id).value;
			voucher_obj.open('get', 'admin_request_for_interview_voucher_update.php?code_number='+voucher+'&date_expire='+date_expire+'&comment='+comments)
			voucher_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			voucher_obj.onreadystatechange = voucher_details_preview 
			voucher_obj.send(1)
			hideSubMenu();
		}
		function voucher_details_preview()
		{
			var data;
			data = voucher_obj.responseText
			if(voucher_obj.readyState == 4)
			{
				document.getElementById('voucher_details_'+selected_x_id).innerHTML = data;
			}
			else
			{
				document.getElementById('voucher_details_'+selected_x_id).innerHTML="<img src='images/ajax-loader.gif'>";
			}
		}			
		function voucher_limit(voucher)
		{
			var limit_of_use = document.getElementById('limit_of_use'+voucher).value;
			voucher_obj.open('get', 'admin_request_for_interview_voucher_limit_of_use.php?code_number='+voucher+'&limit_of_use='+limit_of_use)
			voucher_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			voucher_obj.send(1)
			alert("Changes has been saved.");
		}	
		function show_hide_search(id, label) 
		{
			var search_box = document.getElementById(id);
			var label_str = document.getElementById(label);
			if (search_box.style.display == 'none') 
			{
				search_box.style.display = '';
				label_str.innerHTML = '[Hide]';
			} 
			else 
			{
				search_box.style.display = 'none';
				label_str.innerHTML = '[Show]';
			}
		}		