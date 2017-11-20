<script type="text/javascript" src="/portal/js/jscal2.js"></script>
<script type="text/javascript" src="/portal/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />

<link rel="stylesheet" type="text/css" href="/portal/seatbooking/css/simpleAutoComplete.css" />
<script type="text/javascript" src="/portal/ticketmgmt/js/simpleAutoComplete.js"></script>

<div class="main-container" style="width:85%">
<p class="lastNode">Tests Reports</p>

<div style="float:left;width:100%;height:auto;margin:7px 0;padding-left:7px;border:1px solid #aaa;">&nbsp;
	<div style='float:left;width:100%;height:37px;'>
		<form id='filter_form' action='' method='post' style='float:left;'>
			<?php if($nologo):?>
			<input type='hidden' id='nl' name='nl' value='1' />
			<?php endif;?>
			<span id='show_count'>Filter By:</span>
			<select id="filter_by" name="filter_by" class="inputbox" style="width:150px;height:23px;padding-top:2px;vertical-align:top;">
				<option value=''>All </option>
				<option value='p.fname'>Candidate Name</option>
				<option value='p.userid'>Candidate ID</option>
				<option value='p.email'>Candidate Email</option>
				<option value='r.result_pct'>Test PCT. (%)</option>
				<option value="l.assessment_title">Test Name</option>
			</select>
			&nbsp;&nbsp;
			
			<span id='query'></span>
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span id='show_count'>Date from:</span>
			<input type="text" id="from_date" name="from_date" value="" class="inputbox2" readonly style="width:100px;"/>
			&nbsp;&nbsp;
			<span id='show_count'>Date to:</span>
			<input type="text" id="to_date" name="to_date" value="" class="inputbox2" readonly style="width:100px;"/>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='submit' id="filter" value='Filter' title="Submit Filter"/> &nbsp;&nbsp;
			<!--<input type='button' id="reset" value='Reset' title="Reset filter"/>
			<a href='javascript:void(0);' onclick='class_seat.daycount(1);'>1 day</a>
			<input type='button' class='button' value="Filter Date" name='submit' id='filterdate'/>-->
		</form>
	</div>
	<br/>
	
	
</div>
<div class='showingresult'><span><strong>Showing report:</strong> <span id='filteredby'></span> <?php if($search) echo '-> '. $search;?></span>
	<span class='daterange'><strong>Date Range:</strong> <?php if($from_date && $to_date) echo $from_date.' to '.$to_date;?></span></div>
		
		<div id="qholder" style="float:left;width:100%;padding-right:20px;">
            <table width="100%" cellspacing="2" class="list">
				<tbody>
            	<tr>
				  <td class='header'>#</td>
				  <td class='header' style='width:80px'>Date Taken</td>
				  <td class='header' style='width:50px'>User ID</td>
				  <td class='header'>Candidate Name</td>
				  <td class='header'>Test Name</td>
				  <td class='header'>Category</td>
				  <td class='header'>Score</td>
				  <td class='header'>PCT. (%)</td>
				  
				  <td class='header'>Result Details</td>
				</tr>
                    
                <?php if(count($test_result) > 0):
				$bgcolor = array('#E0E5F0', '#e9edf4');
				$ctr=0;
				foreach($test_result as $test):
					$ctr++;?>
	
			  <tr bgcolor="<?php echo $bgcolor[$ctr%2];?>">
				<td class='item'><?php echo $ctr;?></td>
				<td class='item'><?php echo $test['test_date'];?></td>
				<td class='item'><a href='/portal/recruiter/staff_information.php?userid=<?php echo $test['userid'];?>' target='_blank'><?php echo $test['userid'];?></a></td>
				<td class='item'><a href='/portal/recruiter/staff_information.php?userid=<?php echo $test['userid'];?>' target='_blank'><?php echo $test['fname'].' '.$test['lname'];?></a></td>
				<td class='item'><?php echo $test['assessment_title']?></td>
				<td class='item'><?php echo $test['assessment_category'];?></td>
				<td class='item'><?php echo $test['result_score'];?></td>
				<td class='item'><?php echo $test['result_pct'];?>%</td>
				<td class='item'><a href='<?php echo $test['result_url'];?>' target='_blank'>click here</a></td>
				
				
			  </tr>
			  <?php endforeach;?>
				<tr bgcolor="#d0d0d0"><td class='item' colspan='8'>TOTAL</td>
				  <td class='item'><?php echo $ctr;?></td>
				</tr>
			  <?php elseif(!$from_date && !$to_date && !$search):?>
			  <tr bgcolor="#d0d0d0"><td colspan='9'>Use search filters.</td></tr>
			  <?php else:?>
				<tr bgcolor="#d0d0d0"><td colspan='9'>No record found.</td></tr>
			  <?php endif;?>
			  </tbody>
                    
            </table>
        </div>
            
        
<div id="footer_divider"></div>
</div>

<script type="text/javascript">
var testNames = [];
(function($) {
	
	var jsrep = (function(){
		return {
			search_onblur : function(id) {
				id.css('color','#666');
				if(id.val() == '') id.val('keyword');
				return true;
			},
			
			request_testname : function() {
				$('body').append( $('<form/>').attr({'action': '?/get_testname/', 'method': 'post', 'target':'ajaxframe', 'id':'request_test'}))
					.find('form#request_test').submit();//.remove();
			},
			
			display_keyword_input : function(showfield) {
				$('span#query').empty();
				$('span#query').append( $('<input/>').attr({'name':'search','id':'search','class':'inputbox2'}).
						   css({'width':'150px','padding-right':'10px'}) );
				if(showfield=='') $('input#search').attr('readonly', true);
				
			}
			
	
		}
	}());
	
	$(document).ready(function($) {
		
		$('input#filterdate').click(function() {
			var from_date = $('input#from_date').val();
			var to_date = $('input#to_date').val();
			window.location.href='?/reports/&from='+from_date+'&to='+to_date+'&nl='+$('input#nl').val();
		});
		jsrep.search_onblur($('input#search'));
		jsrep.display_keyword_input('');
		
		/*$('input#search').simpleAutoComplete('/portal/ticketmgmt/autocomplete_query.php',{
		autoCompleteClassName: 'autocomplete',	selectedClassName: 'sel', attrCallBack: 'rel',
		identifier: 'staff_name', updateElem:'search'},
		function(param, elID){$("input#"+elID).val( param[1]+' '+param[2] );});*/
		
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
			if(optval == 'l.assessment_title') jsrep.request_testname();
			else {
				//if($('input#search').length == 0)
				jsrep.display_keyword_input(optval);
				$('input#search').val('');
				
				var iden = '';
				if(optval == 'p.fname') {
					iden = 'staff_name';
					var cb_func = function(param, elID){$("input#"+elID).val( param[1]+' '+param[2] );}
				}else if(optval == 'p.userid') {
					iden = 'staff_id';
					var cb_func = function(param, elID){$("input#"+elID).val( param[0] );}
				}
				$('input#search').off();
				if(iden) {
					$('input#search').simpleAutoComplete('/portal/ticketmgmt/autocomplete_query.php',{
					autoCompleteClassName: 'autocomplete',	selectedClassName: 'sel', attrCallBack: 'rel',
					identifier: iden, updateElem:'search'}, cb_func);
				}
			}
		});
		
		$('input#reset').click(function() {
			$(this).closest('form').find("input[type=text]").val("");
			$('input#search').val('keyword');
			$('select#filter_by').val('');
		});
		
		var selected_option = $("select#filter_by option[value='<?php echo $filter_by;?>']").html();
		//var selected_option = $('select#filter_by option:selected').html();
		$('span#filteredby').text(selected_option);


		
		$(window).keydown(function(event){
			if(event.keyCode == 13 && event.target.nodeName == 'INPUT') {
			  event.preventDefault();
			  return false;
			}
		});
	
		Calendar.setup({inputField : "from_date", trigger: "from_date", onSelect: function() { this.hide()  },//showTime   : 12,
			fdow:0, dateFormat : "%Y-%m-%d"
		});
		
		Calendar.setup({inputField : "to_date", trigger: "to_date", onSelect: function() { this.hide()  },//showTime   : 12,
			fdow:0, dateFormat : "%Y-%m-%d"
		});
	});

})(jQuery);
function populate_testname() {
	$('span#query').empty();
	$('span#query').append( $('<select/>').attr({'name':'search','id':'test_name','class':'inputbox2'}).
						   css({'width':'150px','height':'27px','padding-top':'5px','vertical-align':'top'}) );
	for (var i = 0; i < testNames.length; i++) {
		var test = testNames[i];
		if(test.assessment_title != null) $('select#test_name').append('<option>'+test.assessment_title+'</option>');
	}
}
</script>