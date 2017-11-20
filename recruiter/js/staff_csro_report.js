function bank_accounts(userid)
{
	previewPath = "../admin_bank_account_details.php?userid="+userid;
	window.open(previewPath,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}		
function asl_checker(path) 
{
	window.open(path,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
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