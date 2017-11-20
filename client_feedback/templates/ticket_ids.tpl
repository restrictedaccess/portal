<!-- type display -->
<link rel="stylesheet" type="text/css" href="/portal/aclog/css/styles.css" />
	<strong>TICKET/S ASSIGNED: </strong> <a href='#' class='jqmClose' style='float:right'>Close</a><hr style='width:100%'>
				
		
	<div style="float:left;width:100%;height:200px;padding:4px;overflow-x:hidden;overflow-y:scroll;">
		
			<div id="tabular">
				
			<table summary="tickets" id='tbltype'>
				
			<tbody>
           	<tr>
				<th scope="col" style='width:17%;'>Ticket ID</th>
				<th scope="col">Ticket Title</th>
				<th scope="col" style='width:20px;'></th>
			</tr>
			
			{if $tickets|@count > 0 }
			{section name=idx loop=$tickets}
			<tr>
				<td class="number">{$tickets[idx].id}</td>
				<td style='text-align:left;padding:0 5px;'><span class='ticket_title'>{$tickets[idx].ticket_title}</span></td>
				<td class="number"><input type='radio' name='selecttid' value='{$tickets[idx].id}'/></td>
			</tr>
			{/section}
			{else}
			<tr><td colspan="3">No Ticket Found</td></tr>
			{/if}
			  </tbody>
                    
            </table>
			
			</div>
    </div>
	
	<script type='text/javascript'>
	{literal}
	(function($){
		tasktype = (function(){
			return {
				add_typefield : function() {
					console.log($('table#tbltype tr:gt(0)'));
					$('table#tbltype').append($('<tr/>').append( $('<td/>').addClass('number') )
													  .append($('<td/>')
															  .append($('<input/>').attr({'type':'text', 'name':'newtype[]', 'autocomplete':'off'})) )
													  );
					var divtype = $('div#task-types');
					divtype.scrollTop(divtype.height()+500);
					
				}
			}
		}());
		
		$(document).ready(function(){
			
			/*$('form#typeform input[type=text]').keydown(function(){
				var inp = $(this);
				inp.data( inp.attr('name') , inp.val() );
			});*/
			
			/*$('form#rateform input[type=text]').keyup(function(){
				var inp = $(this);
				var currentval = inp.val();
				var rateval = inp.data( inp.attr('name') );
				if(currentval != rateval) {
					var uid = inp.attr('name').split('rate')[1];
					$("input[name=edit"+uid+"]").val(true);
				}
			});*/
			$("input[name=selecttid]").click(function(){
				var tid = $(this).val();//closest('tr').find('td:first').text();
				console.log('double!'+tid);
				$('#{/literal}{$catdiv}{literal}tid').text('#'+tid);
				$('.attach_ticket').jqmHide();
				//tasktype.add_typefield();
			});
		});
	})(jQuery);
	{/literal}
	</script>