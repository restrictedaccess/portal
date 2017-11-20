<script type="text/javascript">
jQuery().ready(function($){
    /*Calendar.setup({inputField : "bugdate", trigger: "bd", onSelect: function() { this.hide()  },//showTime   : 12,
		fdow:0, dateFormat : "%Y-%m-%d"
    });*/
    brep.submit_form('bug_form');
    
    brep.load_assignto('staff_name', 'Search staff...', 'assignto');
    
    $('input#cancel').click(function() {
        var report_id = $('input#report_id').val();
        history.go(-1);
	});
    
    $(window).keydown(function(event){
		if(event.keyCode == 13 && event.target.nodeName == 'INPUT') {
		  event.preventDefault();
		  return false;
		}
	});
    $('div#prompt').hide();
});
function disable_button(id, flag) {    
    flag = (typeof flag !== 'undefined') ? flag : false;
    jQuery('input#'+id).attr('disabled', flag);
    if( jQuery('span#task-status').is(':visible') ) jQuery('span#task-status').hide();
}
</script>   
    <style type='text/css'>
    div.container{float:left;width:97%;margin-left:auto;margin-right:auto;border:1px solid #7a9512;}
    </style>
    
    <div id='divresult' class='container'>
        <span id='task-status'></span>
		
		<div id="formholder" style="float:left;width:97%;padding:10px;">
                <form id='bug_form' action='?/create_report' method='post' target='ajaxframe'>
                    <input type='hidden' name='assignto' id='assignto'/>
                    <input type='hidden' name='assignto_ref' id='assignto_ref'/>
                <table width="100%" cellspacing="2" class="list">
            		<tr><td height="30" class="header">Enter Report Details</td>
                        <td height="30" align='right' class="header">[ by: <?php echo $reporter;?> #<?php echo $user_id;?> ]</td>
                    </tr>
                    <!--<tr>
                    <td class="label">Execution Date:</td>
                    <td class="form2 hilite">
                        <input type="text" id="bugdate" name="bugdate" class="inputbox2" readonly style="width:76px;"/> <input type='button' id="bd" value='...' title="Date From selector"/>
                    </td>
                    </tr>-->
                    <!--<tr>
                    <td class="label" width="200">Report Type:</td>
                    <td class="form2 hilite" colspan='2'>
                        <select name='ticket_type' id='ticket_type' class='inputbox2' style='height:22px;'>
						  <option value=''></option>
						  
						  <option value='any'>[Any]</option>
                          <option value='any'>Design Error</option>
                          <option value='any'>Coding error</option>
                          <option value='any'>Website</option>
						</select>
                    </td>
                    </tr>-->
                    
                    <tr>
                    <td class="label" width="200">Severity</td>
                    <td class="form2 hilite">
                        <select name='severity' id='severity' class='inputbox2' style='width:120px;height:22px;'>
                          <option value='low'>Low</option>
                          <option value='medium'>Medium</option>
                          <option value='high'>High</option>
                          <option value='critical'>Critical</option>
						</select>
                    </td>
                    
                    </tr>
        
                    <tr>
                    <td class="label" width="200">Title / Summary<span>*</span></td>
                    <td class="form2 lolite" colspan='2'><input class="inputbox2" name="report_title" style='width:79%;' />
                    </td>
                    </tr>
                    
                    <tr>
                    <td class="label">Link (URL)<span>*</span></td>
                    <td class="form2 hilite">
                        <input class="inputbox2" name="report_link" style='width:79%;' />
                    </td>
                    </tr>
                    
                    <tr>
                    <td class="label">Steps To Reproduce /<br/> How did you get here?<span>*</span></td>
                    <td class="form2 lolite">
                        <textarea class="inputbox2" name="steptorep" rows='3' style='width:79%;height:66px;'></textarea>
                    </td>
                    </tr>
                    
                    <tr>
                    <td class="label">Actual Result<span>*</span></td>
                    <td class="form2 hilite">
                        <textarea class="inputbox2" id='actualresult' name="actualresult" style='width:79%;height:44px;'></textarea>
                    </td>
                    </tr>
                    
                    
                    <tr>
                    <td class="label">Expected Result / <br/> What were you expecting to happen? </td>
                    <td class="form2 lolite">
                        <textarea class="inputbox2" name="expectedresult" rows='3' style='width:79%;height:44px;'></textarea>
                    </td>
                    </tr>
                    
                    <tr>
                    <td class="label">Additional Information <br/>(e.g. browser/platform)</td>
                    <td class="form2 hilite">
                        <input class="inputbox2" name="otherinfo" style='width:79%;' />
                        <span style='font-size:10px;font-weight:normal'>(Max. char: 250)</span>
                    </td>
                    </tr>
                    
                    <tr>
                    <td class="label">Notes / Sample:</td>
                    <td class="form2 hilite">
                        <textarea class="inputbox2" id='report_note' name="report_note" style='width:79%;height:44px;'></textarea>
                    </td>
                    </tr>
                    <?php
                    if( in_array($user_array, $users)  ):?>
                    <tr>
                    <td class="label">Assign To:</td>
                    <td class="form2 lolite">
                       <input class="button" name="staff_name" id="staff_name" style='width:160px;' />
                    </td>
                    </tr>
                    <?php endif;?>
                    
                    <!--<tr><td class="form1 hilite">
                    </td>
                    <td id='attachedfiles' class="hilite"></td>
                    </tr>-->
                </table>
                </form>
                <table width="100%" cellspacing="2" class="list">
            	<tr><td class="form1 lolite" width="216">
                    <div style='float:left;width:100%;'>
                        <div style="display: block; width: 210px; height: 30px; overflow: hidden;">
                        <form action="?/fileupload" method="post" target="ajaxframe" enctype="multipart/form-data" name="fileform" id="fileform">
                        <button id="btn_upload" style="width: 110px; height: 29px; position:relative; top: -1px; left: -5px;">
						<a href="javascript:void(0)" id='attfile' style='color:#000;'>Attach file</a></button>
						<input type="hidden" name="ids" value="">
						<input type="hidden" name="grpchat" value="0">
						<input type="hidden" name="chat" value="true">
						<input type="file" id="inpfile" name="inpfile[]" onChange="brep.fileUpload(this);"
						style="font-size:50px;width:120px;height:30px;opacity:0;filter:alpha(opacity: 0);position:relative;top:-30px;left:-20px"/>
						</form>
						</div>
					</div>
                </td>
                    <td id='attachedfiles' class="form2 hilite"></td>
                    </tr>
                </table>
                
            <div style='float:right;width:20%;right:10px;'>
            <input type='button' class='button' value="Cancel" name='cancel' id='cancel' title="Cancel"/> &nbsp;
			<input type='submit' class='button' value="Submit" name='submit' id='new_report' title="Submit new report" form="bug_form"/>
            </div>
            
        </div>
            
        <div id='prompt' style='padding:20px;'>
            <p>
               The bug report has been submitted. Our technical team will fix any related issue of this report.<br/><br/>
               <a href='?<?php echo $_SERVER['QUERY_STRING'];?>'>Report another bug?</a>
            </p>
        </div>    
        
    </div>
<br />
<script type="text/javascript">
<!--
function createResult(err_msg) {
    if( err_msg )
    	jQuery('span#task-status').empty().append(err_msg).show().fadeOut(9000);
	else {
        jQuery('span#task-status').empty();
        jQuery('div#formholder').hide();
        jQuery('div#prompt').show();
        //location.href='/portal/bugreport/';
	}
}

function createUploadResult(err_msg, file_id) {
    if( err_msg ) {
    	jQuery('span#task-status').empty().append(err_msg).show().fadeOut(9000);
		if(jQuery('input[name='+file_id+']').length > 0) jQuery('input[name='+file_id+']').remove();
		if(jQuery('span#txt_'+file_id).length > 0) jQuery('span#txt_'+file_id).remove();
		if(jQuery('input#'+file_id).length > 0) jQuery('input#'+file_id).remove();
    }
}
-->
</script>
