<link rel=stylesheet type=text/css href="/portal/css/tooltip.css">
<script type="text/javascript" src="/portal/js/tooltip.js"></script>
<script type="text/javascript" src="/adhoc/php/js/hilite.js"></script>
<script type="text/javascript">
<!---
jQuery(document).ready(function($) {
	$('#newrep').jqm({ajax: 'views/bugform.html', trigger: 'a.newtrigger'});
	 $('input[name=report_del]').click(function() {
        var report_id = $('input#report_id').val();
        var chkd = $("input:checkbox:checked");
        
        if( chkd.length > 0 && confirm('Do you want to delete this ticket?')) {
            $('form#bugsform').submit();
        }
	});

});
// -->
</script>
<style type='text/css'>
* html .jqmWindow {
     position: absolute;
     top: expression((document.documentElement.scrollTop || document.body.scrollTop) + Math.round(17 * (document.documentElement.offsetHeight || document.body.clientHeight) / 100) + 'px');
}
</style>

<div class="jqmWindow" id="newrep">
Please wait...
</div>
		

<div id='cases' style='padding:15px 7px;'>
    
					
    <div id="reports" class="pane_content">
		
        <?php if($suser):?>
			
		<?php endif;?>
	   <form name='bugsform' id='bugsform' action='?/delete_multiple/' method='post' target='ajaxframe'>
        <div id='result' style='float:left;width:100%;border:1px solid #7a9512;'>
           <span style=" float:left;">Total Result: <span id='totalresult'><?php echo count($reports);?></span></span>
           <!--<span style=" float:right;"><input type="button" onClick="class_seminar.excelExport();" value="Export to Excel"></span>-->
           <table cellpadding='1' cellspacing='0' class='list' width='100%' id='ticket_list'>
           <tbody id='tbody_list'>
           <tr>
			<td class='header' style='width:7%;'><!--input type='checkbox' name='tickAll' onclick='tick_untickAll(this);'/-->
			<a href='?/view_all/<?php echo $view_param;?>/&orderby=id&sort=<?php echo $sort_order;?>'>Bug ID</a></td>
			
			<td class='header' style='width:40%;'><a href='?/view_all/<?php echo $view_param;?>/&orderby=report_title&sort=<?php echo $sort_order;?>'>Title / Summary</a></td>
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
			?>

			<tr id='row<?php echo $info['id'];?>' onmouseover="hilite(this);" onmouseout="lowlite(this);">
			  <td class='item'>
				<a style='line-height:20px;' href='/portal/bugreport/?/view_details/<?php echo $info['id'];?>'><?php printf('%06d', $info['id']);?></a> &nbsp;
			  <?php
				if($info['filecnt']) echo "<img src='/portal/bugreport/images/attachment.png' title='attachment'/>";
			  ?>
			  </td>
			  
			  <td class='item'>
			  <div style='float:left;width:74%;'><?php echo $info['report_title'];?></div>
			  <div class='updated'>
				Date created:<br/><?php echo $info['creation_date'];?> 
			  </div></td>
			  <td class='item'><?php echo $info['severity'];?></td>
			  
			  <td class='item'>
			  <?php $status = $info['status'];
			  echo $status;
		      if($status == 'resolved')
			     echo "<br/><span style='color:#ff0000;font-size:8px'>".$info['resolution']."</span>";
			  ?>
			  </td>
			  
			  <td class='item' style='width:200px;word-wrap: break-word;'>
				<?php echo $info['update_date'];?>
			  </td>
			</tr>
			
			<?php endforeach;
			else:?>
            <tr bgcolor="#d0d0d0"><td colspan='10'>No record found.</td></tr>
			<?php endif;?>
   
           </tbody>
   
           </table>

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