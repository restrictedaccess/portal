<link rel=stylesheet type=text/css href="/portal/css/tooltip.css">
<script type="text/javascript" src="/portal/js/tooltip.js"></script>
<script type="text/javascript" src="/portal/ticketmgmt/js/jqModal.js"></script>
<script type="text/javascript">
<!---
$(document).ready(function() {
	//$('input#status').val('<?php echo $status;?>');
	$("div.main ul li:first").addClass("youarehere");

	$('a.loglink').click(function() {
		var activeID = $(this).attr("href");
		var test_id = activeID.substring(1);
		
		var testname = $('span#testname'+test_id).text();
		
		var logs = $('div#logs');
		$('span#log_testname').text(testname);
		getHistory(test_id, logs);
	});
	
	$('.jqmWindow').jqm({overlay: 50, modal: true, trigger: false});
	

});

// -->
</script>
<style type="text/css">
.jqmWindow {
    display: none;
    
    position: fixed;

    
    margin-left: -30px;
    
    background-color: #EEE;
    color: #333;
    border: 1px solid black;
    padding: 12px;
	width:75%;padding:12px;
	border:1px solid #ff9900;

	text-align:center;
	top:70px;left:30px;
}

.jqmOverlay { background-color: #000; }

* html .jqmWindow {
     position: absolute;
     top: expression((document.documentElement.scrollTop || document.body.scrollTop) + Math.round(17 * (document.documentElement.offsetHeight || document.body.clientHeight) / 100) + 'px');
}
</style>

<div id='cases' style='padding:15px 7px;'>
    
					
    <div id="reports" class="pane_content">
		<div id='hmenu'>
			<div class='nav main'>
				<ul>
					<li><a href='#open'>Test List</a></li>
					<li id='nav-createticket'>
						<a href='?/testinfo/0'>Add Test</a>
					</li>
				</ul>
			</div>
			
		</div>
        <?php if($suser):?>
			<input type='button' id='ackAll' value='Delete' onclick='class_ticket.delAll();' style='float:right;'/>
		<?php endif;?>
	   <form name='casesform' action='?/delete/' method='post' target='ajaxframe'>
        <div id='result' style='float:left;width:100%;border:1px solid #7a9512;'>
        <input type='hidden' name='action' id='action'/>
           <span style=" float:left;">Total Result: <span id='totalresult'><?php echo count($test_info);?></span></span>
           <!--<span style=" float:right;"><input type="button" onClick="class_seminar.excelExport();" value="Export to Excel"></span>-->
           <table cellpadding='1' cellspacing='0' class='list' width='100%' id='ticket_list'>
           <tbody id='tbody_list'>
           <tr>
             <td class='header' style='width:4%;'>Test ID</td>
             <!--<td class='header'>Client ID</td>-->
             <td class='header' style='width:15%;'>Test Name</td>
             <td class='header' style='width:15%;'>Test Description</td>
             <td class='header' style='width:5%;'>Questions #</td>
             <td class='header' style='width:10%;'>Date / Admin</td>
			 <td class='header' style='width:5%;'>Duration (min)</td>
			 <td class='header' style='width:5%;'>Published</td>
			 <td class='header' style='width:2%;'>History</td>
           </tr>
		   
		   <?php if(count($test_info) > 0):
		    $bgcolor = array('#d0d8e8', '#e9edf4');
			foreach($test_info as $info):
				$row_bg = $bgcolor[$ctr++ % 2];
			?>

			<tr id='row<?php echo $info['id'];?>' bgcolor="<?php echo $row_bg;?>">
			  <!--<td class='item'></td>-->
			  <td class='item'><a href='?/testinfo/<?php echo $info['id'];?>'><?php echo $info['id'];?></a></td>
			  <!--<td class='item'></td>-->
			  <td class='item'><a href='?/testinfo/<?php echo $info['id'];?>'><span id='testname<?php echo $info['id'];?>'><?php echo $info['test_name'];?></span></a></td>
			  <td class='item'><?php echo $info['test_desc'];?></td>
			  
			  <td class='item'><?php echo $info['question_count'];?></td>
			  <td class='item'><?php echo $info['test_creation_date'].' /'.$info['created_by'];?></td>
			  <?php if($suser):?>
				<td class='item'><input type='checkbox' name='tick[]' value='<?php echo $info['id'];?>' /></td>
			  <?php endif;?>
			  <td class='item'><?php echo $info['test_duration'];?></td>
			  <td class='item'><?php echo $info['published'];?></td>
			  <td class='item'><a href='#<?php echo $info['id'];?>' class='loglink'>Show</a></td>
			</tr>
			
			<?php endforeach;
			else:?>
            <tr bgcolor="#d0d0d0"><td colspan='8'>No record found.</td></tr>
			<?php endif;?>
   
           </tbody>
   
           </table>

		</div>
	   </form>
  

    </div>
</div>

<!--<div style='float:left;width:100%;text-align:left;padding-top:10px;'>History [ <a href='#loghist' id='showhide'>Show</a> ]</div>-->

  <div class='jqmWindow' id='logs'>
	<span id='log_testname'>Test</span>
	<a href='#' class='jqmClose' style='float:right'>Close</a><hr>
		
	<table width='100%' border='0' cellpadding="7" cellspacing="2" class="list" id="logtbl">
		<tbody>
		<tr><td class='header' style='width:15%;'>Date</td>
		<td class='header' style='width:15%'>Admin</td>
		<td class='header' style='width:70%;'>Changes</td>
		</tr>
		<tr><td class='item'>Date</td>
		<td class='item'>Admin</td>
		<td class='item'>Changes</td>
		</tr>
		</tbody>
	</table>
  </div>
  

<script type='text/javascript'>
<!--
function getHistory(id, logs) {
	var tbl = $('table#logtbl');
	tbl.find("tr:gt(0)").remove();
		
	var bgcolor = new Array('#d0d8e8', '#e9edf4');

	if( !logs.is(':visible') ) {
					
		$.ajax({
			type: "POST",
			url: "?/historylist/",
			data: { 'test_id': id}, dataType: "json",
			success: function(data){			
				for(var i = 0; i < data.length; i++) {
					var log_info = data[i];
					rowbg = bgcolor[i % 2];
								
					tbl.find('tbody').append("<tr bgcolor='"+rowbg+"'>"+
					"<td class='item'>"+log_info.date_updated+"</td>"+
					"<td class='item'>"+log_info.admin_fname+"</td>"+
					"<td class='item'>"+log_info.field_update+"</td></tr>");
				}
				//$(window).scrollTop($(window).height()+500);
				if( logs.height() > $(window).height() ) {
					logs.css({'height':$(window).height()-100, 'overflow':'auto'});
				}
			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
					
		//logs.show();
		$('.jqmWindow').jqmShow();
				
		$(window).scrollTop($(window).height()+500);
		//$('a#showhide').text('Hide');
					
	} else {
		//logs.hide();
		$('#dialog').jqmHide();
		//$('a#showhide').text('Show');
	}
	
}
//-->
</script>