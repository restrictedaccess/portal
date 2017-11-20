jQuery(document).ready(function() {
	//jQuery('.dropdown-toggle').dropdown()					   
	jQuery(window).load(function (e) {
		console.log(window.location.pathname);
	});
	jQuery("#pagenum").val(1);
	show_recorded_soa();
});

function show_recorded_soa(){
	//console.log("hello world");
	var API_URL = jQuery('#API_URL').val();
	var pagenum= jQuery("#pagenum").val();
	//jQuery("#soa_table tbody").html("<tr><td colspan=6>Loading...</td></tr>");
	jQuery.get(API_URL + "/soa/get?page="+pagenum, function(response){
		response = jQuery.parseJSON(response);
		//console.log(response);
		if(response.success){			
			var output = "";
			jQuery.each(response.result, function(i, item){
				//console.log(item);
				var url="<a href='/portal/django/accounts/soa/"+item.doc_id+"' target='_blank'>"+item.doc_id+"</a>";
				if(item.reference_db == "mongodb"){
					var url="<a href='/portal/django/accounts/mongodb_soa/"+item.doc_id+"' target='_blank'>"+item.doc_id+"</a>";
				}
				
				output += "<tr>";
					output +="<td>"+item.counter+"</td>";
					output +="<td>"+item.client_name+"</td>";
					output +="<td>"+item.start_date+" - "+item.end_date+"</td>";
					output +="<td>"+url+"</td>";
					output +="<td>"+item.admin_name+"</td>";
					output +="<td>"+item.date_created+"</td>";
				output += "</tr>";
			});
						
			jQuery("#soa_table tbody").html(output);
			set_up_pagination(parseInt(response.pagenum), parseInt(response.maxpage))			
		}else{
			console.log(response);
			jQuery("#soa_table tbody").html("<tr><td colspan=6>There's an issue in displaying clients statement of accounts</td></tr>");
		}
	})
}



function set_up_pagination(pagenum, maxpage){
	var output="";		
	if (pagenum > 1){
		page = pagenum - 1;
		output += "<li><a href='#' data-page-num="+page+"><span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span></a></li>";			
	}else{		
		output += "<li class='disabled'><a href='#'><span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span></a></li>";
	}
	
	for(var i=1; i<=maxpage; i++ ){
		
		if(pagenum == i){
			output +="<li class='active'><a href='#' data-page-num="+i+">"+i+" <span class='sr-only'>(current)</span></a></li>";
		}else{
			output +="<li><a href='#' data-page-num="+i+">"+i+"</a></li>";
		}
	}
	
	if (pagenum < maxpage){
		page = pagenum + 1;
		output += "<li><a href='#' data-page-num="+page+"><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
	}else{		
		output += "<li class='disabled'><a href='#'><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
	}
	
	jQuery(".pagination").html(output );
	
	jQuery('.pagination a').click(function(e){
		e.preventDefault();
		var pagenum = jQuery(this).attr("data-page-num");
		if(pagenum){
			jQuery("#pagenum").val(pagenum);
			show_recorded_soa();
		}
	});
	
}