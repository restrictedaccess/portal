<link rel=stylesheet type=text/css href="/portal/css/tooltip.css">
<script type="text/javascript" src="/portal/js/tooltip.js"></script>
<script type="text/javascript" src="/adhoc/php/js/hilite.js"></script>
<script type="text/javascript">
<!---
jQuery(document).ready(function($) {
	//$('#newrep').jqm({ajax: 'views/bugform.html', trigger: 'a.newtrigger'});

	 $('input[name=report_del]').click(function() {
        var report_id = $('input#report_id').val();
        var chkd = $("input:checkbox:checked");
        /*chkd.each(function() {
            alert($(this).val());
            //$('#t').append(', '+$(this).val());
        });*/
        
        /*for(var i=0; i<chkd.length; i++) {
            var t = $('input[name=tick]');
            alert(t.attr('type'));
        }*/
        if( chkd.length > 0 && confirm('Do you want to delete this ticket?')) {
            $('form#bugsform').submit();
        }
	});

});
// -->
</script>

<div id='cases' style='padding:15px 7px;'>
    
					
    <div id="reports" class="pane_content">
		
        <?php if($suser):?>
			<input type='button' id='ackAll' value='Delete' onclick='alert("not available.");' style='float:right;'/>
		<?php endif;?>
	   <form name='bugsform' id='bugsform' action='?/delete_multiple/' method='post' target='ajaxframe'>
        <div id='result' style='float:left;width:100%;border:1px solid #7a9512;'>
           <span style=" float:left;">Total Result: <span id='totalresult'><?php echo count($reports);?></span></span>
           <!--<span style=" float:right;"><input type="button" onClick="class_seminar.excelExport();" value="Export to Excel"></span>-->
           <table cellpadding='1' cellspacing='0' class='list' width='100%' id='ticket_list'>
           <tbody id='tbody_list'>
           <tr>
			<td class='header' style='width:12%;text-align:right;padding-right:4%;'><!--input type='checkbox' name='tickAll' onclick='tick_untickAll(this);'/-->
			<a href='?/view_all/<?php echo $view_param;?>/&orderby=id&sort=<?php echo $sort_order;?>'>Bug ID</a></td>
			<td class='header' style='width:15%;'>Reporter</td>
			<td class='header' style='width:35%;'><a href='?/view_all/<?php echo $view_param;?>/&orderby=report_title&sort=<?php echo $sort_order;?>'>Title / Summary</a></td>
			<td class='header' style='width:10%;'><a href='?/view_all/<?php echo $view_param;?>/&orderby=severity&sort=<?php echo $sort_order;?>'>Priority</a></td>
			
			<!--<td class='header' style='width:20px;' title='Priority'>P</td>
             <td class='header' style='width:4%;'>ID</td>
             <td class='header' style='width:10px;'></td>-->
             
             <td class='header' style='width:10%;'>Status</td>
             <td class='header' style='width:13%;'><a href='?/view_all/<?php echo $view_param;?>/&orderby=update_date&sort=<?php echo $sort_order;?>'>Updated</a></td>
			 <!--<td class='header'>Assign to</td>-->
			 
			 
			 <?php if($suser):?><td class='header'><input type='checkbox' name='tickAll' onclick='class_ticket.tick_untickAll(this);'/></td><?php endif;?>
           </tr>
		   
		   <?php if(count($reports) > 0):
		    $bgcolor = array('#d0d8e8', '#e9edf4');
			foreach($reports as $info):
			
				$age = explode(' ', $info['age']);
				
				//$ctr = (float)$age[0];
				
				//$level1 = $ctr > 1 && $ctr < 6 && strtolower($status) == 'open';
				//$level2 = $ctr > 5 && strtolower($status) == 'open';
				
				
				
			?>

			<tr id='row<?php echo $info['id'];?>' onmouseover="hilite(this);" onmouseout="lowlite(this);">
			  <td class='item'><input type='checkbox' name='tick[]' value='<?php echo $info['id'];?>'/> &nbsp;
			  <a href='?/edit_details/<?php echo $info['id'];?>'><img src='/portal/images/b_edit.png'/></a> &nbsp;
			  <a style='line-height:20px;' href='/portal/bugreport/?/view_details/<?php echo $info['id'];?>'><?php printf('%06d', $info['id']);?></a> &nbsp;
			  <?php
				if($info['filecnt']) echo "<img src='/portal/bugreport/images/attachment.png' title='attachment'/>";
			  ?>
			  </td>
			  <td class='item' style='line-height:20px;'><?php echo $info['reporter'];?></td>
			  <td class='item'>
			  <div style='float:left;width:74%;'><?php echo $info['report_title'];?></div>
			  <div class='updated'>
				Date created:<br/><?php echo $info['creation_date'];?>
			  </div></td>
			  <td class='item'><?php echo $info['severity'];?></td>
			  <!--<td class='item'>
			  <?php
				/*if( $info['priority'] ) {
					$priority = explode('_', $info['priority'], 2);
					echo "<img title='".$priority[0]."' src='/portal/bugreport/images/".$priority[1].".gif'/>";
				}*/
				?>
			  </td>-->
			  <!--<td class='item'></td>-->
			  <!--<td class='item'><a style='line-height:20px;' href='/portal/bugreport/?/view_details/<?php //echo $info['id'];?>'><?php //printf('%06d', $info['id']);?></a></td>-->
			  
			  <!--<td class='item'>
			  <?php
				//if($info['filecnt']) echo "<img src='/portal/bugreport/images/attachment.png' title='attachment'/>";
			  ?>
			  </td>-->
			  
			  <td class='item'>
			  <?php $status = $info['status'];
			  echo $status;
			  if($status == 'assigned')
			     echo "<br/><span style='color:#ff0000;font-size:8px'>".$info['assigned']."</span>";
		      elseif($status == 'resolved')
			     echo "<br/><span style='color:#ff0000;font-size:8px'>".$info['resolution']."</span>";
			  ?>
			  </td>
			  
			  
			 
			  <td class='item' style='width:200px;word-wrap: break-word;'>
				<?php echo $info['update_date'].'<br/> ('.$info['updated_by'].')';?>
			  </td>
			  
			  
			  <?php if($suser):?>
				<td class='item'><input type='checkbox' name='tick[]' value='<?php echo $info['id'];?>' /></td>
			  <?php endif;?>
			</tr>
			<?php if($cnt > 1):?>
			<script type='text/javascript'>
			<!--
			//class_ticket.data('id<?php echo $info['id'];?>', '<?php echo implode('<br/>', $c);?>');
			//-->
			</script>
			<?php endif;?>
			<?php endforeach;
			else:?>
            <tr bgcolor="#d0d0d0"><td colspan='10'>No record found.</td></tr>
			<?php endif;?>
   
           </tbody>
   
           </table>
		   <?php if($view_param != 'deleted'):?>
		<span style='float:left;width:50px;'>
		<input type='button' class='button' value="Mark as deleted" name='report_del' title="Delete report"/></span>
			<?php endif;?>
		</div>
	   </form>
  

    </div>
</div>
<script type="text/javascript">
<!--
function createResult(err_msg) {
    if( err_msg )
    	jQuery('span#task-status').empty().append(err_msg).show().fadeOut(9000);
	else {
		location.href='?<?php echo $_SERVER['QUERY_STRING'];?>';
	}
}
-->
</script>