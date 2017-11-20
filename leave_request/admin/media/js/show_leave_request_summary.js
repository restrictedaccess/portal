jQuery(document).ready(function() {
	jQuery(window).load(function (e) {
		console.log(window.location.pathname);
	});
	jQuery('input[name=page]').val(1);
	search_leave_summary_details();
	
	
	
	
	
	
});


function search_leave_summary_details(){
	var url = "search_leave_request_summary_details.php";
	var formData = jQuery("#leave_request_summary_frm").serialize();
	console.log(formData);
	jQuery.post(url, formData, function(data){
		data = jQuery.parseJSON(data);
		var output="";
		if(data.success){
			jQuery.each(data.records, function(i, item) {
					output += "<tr>";
					output += "<td>"+ item.counter +"</td>";
					output += "<td>"+ item.leave_type +"</td>";
					output += "<td>"+ item.staff +"</td>";
					output += "<td>"+ item.reason_for_leave +"</td>";
					output += "<td>"+ item.client +"</td>";
					output += "<td>";
						jQuery.each(item.dates, function(i, item) {
							output += "<span class='label'>"+item.date_of_leave+":"+item.status+"</span> ";							 
						});								   
					output += "</td>";
					output += "</tr>";
			});
			jQuery(".num_of_records").html(data.count +" records found");
			jQuery("#leave_request_list tbody").html(output);
			set_up_pagination( parseInt(data.pagenum), parseInt(data.maxpage));
			
			jQuery(".export").removeClass('hide');
			jQuery(".export").on('click', function (event) {
				var filename = 'leave_request_summary_details_'+randString()+".csv";
				exportTableToCSV.apply(this, [jQuery("#leave_request_list"), filename]);
			});
			
			
		}else{
			jQuery(".export").addClass('hide');
			output += "<td>No records to be shown...</td>";							 
			jQuery("#leave_request_list tbody").html(output);
		}
	});
}


function set_up_pagination(pagenum, maxpage){
	//console.log(pagenum+" "+maxpage);
	//return false;
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
	
	jQuery("#pagination-result-list").html(output );
	
	jQuery("#pagination-result-list a").click(function(e){
		e.preventDefault();
		var pagenum = jQuery(this).attr("data-page-num");
		console.log(pagenum);
		
		if(pagenum){
			jQuery('input[name=page]').val(pagenum);
			search_leave_summary_details();
		}
		
	});
	
}


function exportTableToCSV($table, filename) {
	var $headers = $table.find('tr:has(th)')
		,$rows = $table.find('tr:has(td)')

		// Temporary delimiter characters unlikely to be typed by keyboard
		// This is to avoid accidentally splitting the actual contents
		,tmpColDelim = String.fromCharCode(11) // vertical tab character
		,tmpRowDelim = String.fromCharCode(0) // null character

		// actual delimiter characters for CSV format
		,colDelim = '","'
		,rowDelim = '"\r\n"';

		// Grab text from table into CSV formatted string
		var csv = '"';
		csv += formatRows($headers.map(grabRow));
		csv += rowDelim;
		csv += formatRows($rows.map(grabRow)) + '"';

		// Data URI
		var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

	jQuery(this).attr({
		'download': filename,
		'href': csvData
			//,'target' : '_blank' //if you want it to open in a new window
	});

	//------------------------------------------------------------
	// Helper Functions 
	//------------------------------------------------------------
	// Format the output so it has the appropriate delimiters
	function formatRows(rows){
		return rows.get().join(tmpRowDelim)
			.split(tmpRowDelim).join(rowDelim)
			.split(tmpColDelim).join(colDelim);
	}
	// Grab and format a row from the table
	function grabRow(i,row){
		 
		var $row = $(row);
		//for some reason $cols = $row.find('td') || $row.find('th') won't work...
		var $cols = $row.find('td'); 
		if(!$cols.length) $cols = $row.find('th');  

		return $cols.map(grabCol)
					.get().join(tmpColDelim);
	}
	// Grab and format a column from the table 
	function grabCol(j,col){
		var $col = $(col),
			$text = $col.text();

		return $text.replace('"', '""'); // escape double quotes

	}
}


function randString(n)
{
    if(!n)
    {
        n = 7;
    }

    var text = '';
    var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    for(var i=0; i < n; i++)
    {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }

    return text;
}