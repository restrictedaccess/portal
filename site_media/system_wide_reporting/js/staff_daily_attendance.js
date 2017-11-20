jQuery(document).ready(function() {
	jQuery(window).load(function (e) {
		console.log(window.location.pathname);
	});
	
	
	
	
	jQuery(".export").on('click', function (event) {
		var filename = 'staff_daily_attendance_'+randString()+".csv";
        exportTableToCSV.apply(this, [jQuery("#staff_daily_attendance_tb"), filename]);
		//console.log(filename)
    });
});

function search_staff_daily_attendance(){
	
	var url = SYSTEM_WIDE_REPORTING_PATH + "search_staff_daily_attendance/";
	var formData = jQuery("#staff_daily_attendance_frm").serialize();
	console.log(formData);

	jQuery.post(url, formData, function(data){
		data = jQuery.parseJSON(data);
		if(data.success){
			var output="";
			jQuery.each(data.records, function(i, item) {
				/*output += "<li>";
					output += item.counter+". ";
					output += "<a href='"+SYSTEM_WIDE_REPORTING_PATH+"staff_daily_attendance/"+item.id+"' target='_blank'>";
						//output += "<span class='badge'>"+item.counter+"</span> ";
						
						output += "Date "+item.search_date;
						output += " 00:00:00 - 23:59:59 ";
					output += "</a>";
				output += "</li>";
				*/
				output += "<tr>";
					output += "<td>"+ item.counter+"</td>";
					output += "<td><a href='"+SYSTEM_WIDE_REPORTING_PATH+"staff_daily_attendance/"+item.id+"' target='_blank'>"+ item.search_date+"</a></td>";
					output += "<td>00:00:00 - 23:59:59</td>";
					output += "<td><a href='"+SYSTEM_WIDE_REPORTING_PATH+"staff_daily_attendance/"+item.id+"?status=working' target='_blank'>"+ item.working+"</a></td>";
					output += "<td><a href='"+SYSTEM_WIDE_REPORTING_PATH+"staff_daily_attendance/"+item.id+"?status=not_working&compliance=absent' target='_blank'>"+ item.absent+"</a></td>";
					output += "<td><a href='"+SYSTEM_WIDE_REPORTING_PATH+"staff_daily_attendance/"+item.id+"?status=not_working&compliance=approved leave' target='_blank'>"+ item.approve_leave+"</a></td>";
					output += "<td><a href='"+SYSTEM_WIDE_REPORTING_PATH+"staff_daily_attendance/"+item.id+"?status=not_working&compliance=marked absent' target='_blank'>"+ item.marked_absent+"</a></td>";
					output += "<td><a href='"+SYSTEM_WIDE_REPORTING_PATH+"staff_daily_attendance/"+item.id+"?status=not_working' target='_blank'>"+ item.not_working+"</a></td>";
					//output += "<td>"+ item.working+"</td>";
					//output += "<td>"+ item.absent+"</td>";
					//output += "<td>"+ item.approve_leave+"</td>";
					//output += "<td>"+ item.marked_absent+"</td>";
					//output += "<td>"+ item.not_working+"</td>";
				output += "</tr>";
				
				
				
			});									
			jQuery(".num_of_records").html(data.count +" records found");
			jQuery("#staff_attendance_list tbody").html(output);
			set_up_pagination( parseInt(data.pagenum), parseInt(data.maxpage));
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
			search_staff_daily_attendance();
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