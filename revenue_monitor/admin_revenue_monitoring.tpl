<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Remotestaff Revenue Monitoring</title>

<link rel="icon" href="/portal/favicon.ico" type="image/x-icon" />


<link rel=stylesheet type=text/css href="/portal/ticketmgmt/css/tabs.css">
<link rel=stylesheet type=text/css href="/portal/css/global_styles.css">
<link rel=stylesheet type=text/css href="revmonitor.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/portal/js/jquery.js"><\/script>')</script>
<script type="text/javascript" src="get_csro_coord.php?id=csro_id"></script>
<script type="text/javascript" src="get_csro_coord.php?id=coordinator"></script>
<script type="text/javascript" src="get_filter_data.php?fld=contract_year"></script>
<script type="text/javascript" src="get_filter_data.php?fld=contract_status"></script>
<script type="text/javascript" src="get_filter_data.php?fld=currency"></script>
</head>
<body>
<iframe id='ajaxframe' name='ajaxframe' style='display:none;height:10px;overflow:scroll;' src='javascript:false;'></iframe>
<div id='contract_active' style='height:20px;'>
</div>
<table cellpadding='0' cellspacing='0' border='0' width='100%'>
<tr><td valign="top">
</td>
</tr>

<tr bgcolor="#7a9512"><td style="width:23%;font:8pt verdana;height:20px;border-bottom:1px solid #7a9512;">
<div style='float:left;width:100%;color:#000;padding-top:2px;'>&#160;&#160;<b>Revenue Monitoring</b></div></td>
<td style="width:77%;font:8pt verdana;height:20px;border-bottom:1px solid #7a9512;">
<div style='float:left;width:100%;font: 8pt verdana;'>
  <table width="100%" border='0'>
	<tr><td align="right" style="font: 8pt verdana;">
	
	</td></tr>
</table>
</div>
</td></tr>
</table>

<link rel="stylesheet" type="text/css" href="/portal/seatbooking/css/simpleAutoComplete.css" />
<script type="text/javascript" src="/portal/ticketmgmt/js/simpleAutoComplete.js"></script>
{if $login}
<script type="text/javascript" src="/portal/ticketmgmt/js/jqModal.js"></script>
{/if}

<div class="main-container" style="width:85%">
<p class="lastNode">Revenue Monitoring</p>
<span id='loading' style='left:30%;'>Getting data from contract page... please wait!</span>
<div style="float:left;width:100%;height:auto;margin:7px 0;padding-left:7px;border:1px solid #aaa;">&nbsp;
	<div style='float:left;width:100%;height:37px;'>
		<form id='filter_form' action='' method='get' style='float:left;'>
			<div style='float:left;width:auto;margin:0 5px; 0 0'>
			<span id='field_label'>Filter By:</span>
			<select id="filter_by" name="filter_by" class="inputbox" style="width:150px;height:23px;padding-top:2px;vertical-align:top;">
				<option value=''>All </option>
				<option value="csro_id">CSRO</option>
				<option value="coordinator">Hiring Manager</option>
				<option value='client_name'>Client Name</option>
				<option value='staff_name'>Staff Name</option>
				<option value='contract_year'>Contract Start</option>
				<option value='currency'>Currency</option>
			</select>
			&nbsp;&nbsp;
			
			<span id='query'></span>
			
			  &nbsp;&nbsp;&nbsp;&nbsp;
			<span id='status_label'>Status:</span>
			  <select id="contract_status" name="contract_status" class="inputbox" style="width:150px;height:23px;padding-top:2px;vertical-align:top;">
				<option value=''>All</option>
			</select>
			</div>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='submit' id="filter" value='Filter' title="Submit Filter"/>
		</form>
	</div>
	<br/>
	
	
</div>
<div class='showingresult'>{*<span><strong>Showing report:</strong> <span id='filteredby'></span> </span><br/>*}
	 <table cellpadding='0' cellspacing='0' class='list' style='float:left;width:auto;padding-top:6px;'>
            <tr><td>Total Record: {$total_rec}</td>
            <td>{$items_total}</td>
               <td> &nbsp; {$pages}</td><td> &nbsp; {$items_pp} &nbsp; </td>
                  <td>{$jump_menu}</td>
            </tr>
           </table>
	 {if $show_export}
	 <span style=" float:right;"><input type="button" id="toxcel" value="Export to Excel"></span>
	 {/if}
</div>
		
		<div id="contractsholder" style="float:left;width:100%;padding-right:20px;">
            <table width="100%" cellspacing="2" class="list">
				<tbody>
            	<tr>
				  <td class='header'>#</td>
				  <td class='header'>Client Name</td>
				  <td class='header'>Staff Name</td>
				  <td class='header'>Contract ID</td>
				  <td class='header'>Contract Status</td>
				  <td class='header'>Contract Length(days)</td>
				  <td class='header'>Job Designation</td>
				  <td class='header'>Staff Monthly Salary</td>
				  <td class='header'>Client Price</td>
				  <td class='header'>Staff Work Status</td> 
				  <td class='header'>Currency</td>
				  <td class='header'>Revenue</td>
				</tr>
				{if $data_array|@count > 0}
					{assign var='total_revenue' value=0}
					{section name=idx loop=$data_array}
	
					<tr bgcolor="{cycle values='#E0E5F0,#e9edf4'}">
					  <td class='item'>{math equation="x+y" x=$smarty.section.idx.index y=$ipp+1}</td>
					  <td class='item'><a href='/portal/leads_information.php?id={$data_array[idx].client_id}' target='_blank'>{$data_array[idx].client_name}</a></td>
					  <td class='item'><a href='/portal/recruiter/staff_information.php?userid={$data_array[idx].userid}&page_type=popup' target='_blank'>{$data_array[idx].staff_name}</a></td>
					  <td class='item'><a href='/portal/contractForm.php?sid={$data_array[idx].contract_id}' target='_blank'>{$data_array[idx].contract_id}</a></td>
					  <td class='item'>{$data_array[idx].status}</td>
					  <td class='item'>
						{if $data_array[idx].contract_length}
						  {assign var='days' value=$data_array[idx].contract_length}
						  {assign var='year' value=0}
						  {assign var='month' value=0}
						  {assign var='day' value=0}
						  {assign var='y' value=365}
						  {assign var='m' value=30}
						  {if $days > $y}
							{math equation="(d/y)" d=$days y=$y assign='year'}
							{math equation="(d % y / m)" d=$days y=$y m=$m assign='month'}
							{math equation="(d % y % m)" d=$days y=$y m=$m assign='day'}
						  {elseif $days > $m}
							{assign var='year' value=0}
							{math equation="(d/m)" d=$days m=$m assign='month'}
							{math equation="(d % m)" d=$days m=$m assign='day'}
						  {elseif $days > 0}
							{math equation="d" d=$days assign='day'}
						  {/if}
						  {$year|string_format:"%d year"}, {$month|string_format:"%d month/s"}, {$day|string_format:"%d day/s"}
						{/if}
					  </td>
					  <td class='item'>{$data_array[idx].job_designation}</td>
					  <td class='item'>{$data_array[idx].php_monthly}</td>
					  <td class='item'>{$data_array[idx].client_price}</td>
					  <td class='item'>{$data_array[idx].work_status}</td>
					  <td class='item'>{$data_array[idx].currency}</td>
					  <td class='item'>
						{assign var='rate' value=$data_array[idx].currency}
						{assign var='r' value=$rates.$rate}
						{assign var='cp' value=$data_array[idx].client_price}
						{assign var='php' value=$data_array[idx].php_monthly}
						{if $rate && $r && $cp && $php}
						  {math equation="(c-(s/r))" c=$cp s=$php r=$r format="%.2f" assign='revenue'}
						  {$revenue}
						  {math equation="x+y" x=$total_revenue y=$revenue assign='total_revenue'}
						{/if}
					  </td>
					</tr>
					{/section}
			  
				<tr bgcolor="#d0d0d0"><td class='item' colspan='11'>TOTAL</td>
				  <td class='item' id='total_revenue'>{$total_revenue}</td>
				</tr>
			  {else}
				<tr bgcolor="#d0d0d0"><td colspan='9'>No record found.</td></tr>
			  {/if}
			  </tbody>
                    
            </table>
        </div>
<div id="footer_divider"></div>
</div>


<script type="text/javascript">
{literal}
var testNames = [];
(function($) {
	
	jsrep = (function(){
		return {
			search_onblur : function(id) {
				id.css('color','#666');
				if(id.val() == '') id.val('keyword');
				return true;
			},
			
			display_keyword_input : function(showfield) {
				$('span#query').empty();
				$('span#query').append( $('<input/>').attr({'name':'search','id':'search','class':'inputbox2'}).
						   css({'width':'150px','padding-right':'10px'}) );
				if(showfield=='') $('input#search').attr('readonly', true);
				
			},
			populate_csro:function() {
			  $('span#query').empty();
			  $('span#query').append( $('<select/>').attr({'name':'search','id':'csro','class':'inputbox2'}).
				  css({'width':'164px','height':'24px','padding-top':'3px'}) );
			  for (var i = 0; i < adminList.length; i++) {
			    var admin = adminList[i];
				$('select#csro').append("<option value='"+admin.csro_id+"'>"+admin.admin_fname+" "+admin.admin_lname+"</option>");
			  }
			},
			populate_hiring_manager:function() {
			  $('span#query').empty();
			  $('span#query').append( $('<select/>').attr({'name':'search','id':'coordinator','class':'inputbox2'}).
				  css({'width':'164px','height':'24px','padding-top':'3px'}) );
			  for (var i = 0; i < managerList.length; i++) {
			    var admin = managerList[i];
				$('select#coordinator').append("<option value='"+admin.hiring_coordinator_id+"'>"+admin.admin_fname+" "+admin.admin_lname+"</option>");
			  }
			},
			populate_contract_status:function() {
			  //$('span#query').append( $('<select/>').attr({'name':'search','id':'contract_','class':'inputbox2'}).
				//  css({'width':'164px','height':'24px','padding-top':'3px'}) );
			  var contract_status = window.parent.contract_status;
			  for (var i = 0; i < contract_status.length; i++) {
			    var status = contract_status[i];
				$('select#contract_status').append("<option value='"+status.contract_status+"'>"+status.contract_status+"</option>");
			  }
			},
			populate_filter_field:function(fldname, data_array) {
			  $('span#query').empty();
			  $('span#query').append( $('<select/>').attr({'name':'search','id':fldname,'class':'inputbox2'}).
				  css({'width':'164px','height':'24px','padding-top':'3px'}) );
			  $.each(data_array, function(key, value) {
				$.each(value, function(key, value){
				  $('select#'+fldname).append("<option value='"+value+"'>"+value+"</option>");
				});
				
			  });
			  
			},
			
			submit_data:function(num, cid) {
			  $('#loading').show();
			   $('body').append( $('<form/>').attr({'action': 'admin_revenue_monitoring.php', 'method': 'post', 'target':'ajaxframe', 'id':'contractform'})
					.append( $('<input/>').attr({'type': 'hidden', 'name': 'item', 'value':'contract_get'}) )
					.append( $('<input/>').attr({'type': 'hidden', 'name': 'counter', 'value':num}) )
					.append( $('<input/>').attr({'type': 'hidden', 'name': 'cid', 'value': cid}) ))
					.find('form#contractform').submit().remove();
			},
			
			get_contract_page:function(num, cid) {
			  $.ajax({        
				type:"POST", url:"admin_revenue_monitoring.php",      
				data: {'item':'contract_get', 'cid':cid, 'counter':num},
				dataType:"html",
				success: function(data) {
				  $('#ajaxframe').contents().find('html').html(data);
				  //.append( $('<script/>').attr({'type':'text/javascript', 'src':'/portal/admin_subcon/admin_subcon.js'}) )
				  //.append( "<script type='text/javascript'>revenueMargin();<\/script>" );

				  //.append("<script src='/portal/admin_subcon/admin_subcon.js'><\/script>\n"+
				//		  "<script type='text/javascript'>revenueMargin();<\/script>")
				  return true;
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					$('ul#staff li:first').remove();
					$('ul#staff ul:first').append("<li>error!</li>");
					alert(textStatus + " (" + errorThrown + ")");
				}
			  });
			},
			
			prepare_filter:function(query_val, search_val) {
			  switch(query_val) {
				case 'csro_id':
				  jsrep.populate_csro();
				  break;
				case 'coordinator':
				  jsrep.populate_hiring_manager();
				  break;
				case 'contract_year':
				case 'currency':
				  jsrep.populate_filter_field(query_val, window[query_val]);
				  break;
				default:
				  jsrep.display_keyword_input(query_val);
				  $('input#search').val('');
				  
				  var cb_func = function(param, elID){$("input#"+elID).val( param[1]+' '+param[2] );}
  
					
				  $('input#search').off();
				  $('input#search').simpleAutoComplete('/portal/ticketmgmt/autocomplete_query.php',{
					autoCompleteClassName: 'autocomplete',	selectedClassName: 'sel', attrCallBack: 'rel',
					identifier: query_val, updateElem:'search'}, cb_func);
				  break;
			  }
			  if($('input#search').is('input')) $('input#search').val(search_val);
			  else $('select[name=search] option[value='+search_val+']').attr('selected', true);
			},
			excelExport:function() {
			  location.href='output_to_xls.php'+location.search;
		  }
	
		}
	}());
	
	$(document).ready(function($) {
		jsrep.display_keyword_input('');
		jsrep.search_onblur($('input#search'));
		jsrep.populate_contract_status();
		
		$('input#search').blur(function(){jsrep.search_onblur($(this));});
		$('input#search').focus(function(){
			$(this).css('color','');
			if($(this).val() == 'keyword')
				$(this).val('');
			else $(this).select();
			return true;
		});
		
		$('select#filter_by').change(function() {
			var optval = $(this).val();
			jsrep.prepare_filter(optval, '');
		});
		
		$('input#reset').click(function() {
			$(this).closest('form').find("input[type=text]").val("");
			$('input#search').val('keyword');
			$('select#filter_by').val('');
		});
		
		$("select#contract_status option[value='{/literal}{$contract_status}{literal}']").attr('selected', true);
		
		$("select#filter_by option[value='{/literal}{$filter_by}{literal}']").attr('selected', true);
		var filter_field = $("select#filter_by :selected");
		jsrep.prepare_filter(filter_field.val(), '{/literal}{$search}{literal}');
		
		$('input#toxcel').click(function() {
		  jsrep.excelExport();
		});
		
		$(window).keydown(function(event){
			if(event.keyCode == 13 && event.target.nodeName == 'INPUT') {
			  event.preventDefault();
			  return false;
			}
		});		
	});

})(jQuery);

{/literal}
</script>