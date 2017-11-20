<script type="text/javascript">
jQuery().ready(function($){
    var divres = $('div#divresult');
    var winheight = $(window).height();
    /*$(window).resize(function(e){
        $('body').prepend($(window).height()+':'+$(window).scrollTop());
    });*/
    //divres.height( winheight );
    brep.load_assignto('staff_name', 'Search staff...', 'assignto');
    
    var report_id = $('input#report_id').val();
    brep.report_id = report_id;
    /*
    $('textarea').keyup(function(e) {
        while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
            $(this).height($(this).height()+1);
        };
    });
    */
    /*Calendar.setup({inputField : "bugdate", trigger: "bd", onSelect: function() { this.hide()  },//showTime   : 12,
		fdow:0, dateFormat : "%Y-%m-%d"
    });*/
    brep.submit_form('bug_form');
    
    $('table#logs').hide();
    $('table#uploads').hide();

	$('a#showhideupload').click(function() {
		var uploads = $('table#uploads');
        if( uploads.is(':visible') ) {
            uploads.hide();
            $(this).text('Show');
        } else {uploads.show();
            $(this).text('Hide')
        }
        //$('div#divresult').css({'height': $(window).height()} );
	});
    
    $('a#showhidenotes').click(function() {		
		var notes = $('table#notes');
        if( notes.is(':visible') ) {
            notes.hide();
            $(this).text('Show');
        } else {notes.show();
            $(this).text('Hide')
        }
        //$('div#divresult').css({'height': divres.height() + $(window).scrollTop()} );
        //$('div#divresult').css({'height': $(window).height()} );
        
	});
    
    $('a#showhidehist, a#jumphist').click(function() {
		var hist_txt = $('a#showhidehist');
		
		var logs = $('table#logs');
        if( logs.is(':visible') ) {
            logs.hide();
            hist_txt.text('Show');
        } else {logs.show();
            hist_txt.text('Hide')
        }
        
		brep.getHistory(report_id, logs);
        var h = $(window).height()+$(window).scrollTop();
        //$('#divresult').css({'height':h});
        //alert(divres.height());
	});
    $('input#changestatus').attr('disabled', 'disabled');
    
    $('input#assign_to').click(function() {
        var assignto = $('input#assignto').val();
		var staff_name = $('input#staff_name').val();
        if( assignto )	brep.assign_to(report_id, assignto, staff_name);
	});
    
    $('select#status').change(function() {
        //var report_id = $('input#report_id').val();
		var status_selected = $(this).val();
        if( status_selected ) $('input#changestatus').removeAttr('disabled');
        else $('input#changestatus').attr('disabled', 'disabled');
	});
    
    $('input#changestatus').click(function() {
        //var report_id = $('input#report_id').val();
		var status_selected = $('select#status').val();
        if( status_selected ) brep.change_status(report_id, status_selected);
	});
    
    $('input#report_edit').click(function() {
        //var report_id = $('input#report_id').val();
        location.href='?/edit_details/'+report_id;
	});
    
    $('input#report_delete').click(function() {
        //var report_id = $('input#report_id').val();
        if( confirm("This bug report will mark as deleted.") ) {
            location.href='?/delete_report/'+report_id;
        }
        
	});
	
	//$('input[name=submit_notes]').attr("disabled", "disabled");
	
	/*
	$('textarea#report_note').keyup(function(event){
		//alert(this.value);
		var key = event.which;
		var str = $.trim($(this).val());		
		if(str.length == 0) $('input[name=submit_notes]').attr("disabled", "disabled");
		else $('input[name=submit_notes]').removeAttr("disabled");
	});
    */
    <?php
    $edit_enabled = 0;
    $assignto_id = $report['assignto'];
    $assignto_ref = explode('.', $report['assignto_ref']);
    
    $login_tbl = array('personal' => 'staff', 'admin' => 'admin', 'agent' => 'business_partner');
    //echo $login_tbl[ $assignto_ref[0] ].' = '.$_SESSION['logintype'].'<br>';
    //echo $assignto_id.' = '.$user_array['userid'];
    if( in_array($user_array, $tester) || $su ||
       ( $assignto_id == $user_array['userid'] && $_SESSION['logintype'] == $login_tbl[ $assignto_ref[0] ] ) ||
       ( $report['reporter_email'] == $user_array['email'] ) ) {
        $edit_enabled = 1;
    }
    if( !$edit_enabled ) {
        echo "$('input#report_edit').attr('disabled', 'disabled');";
        echo "$('input#assign_to').attr('disabled', 'disabled');";
        echo "$('select#status').attr('disabled', 'disabled');";
        echo "$('input#report_delete').attr('disabled', 'disabled');";
    }
?>

	//VALIDATE BEFORE SUBMIT
	$('#noteform').submit(function(e){
		var report_note = $('#report_note').val();
		if(report_note == ''){
			alert('Please fill up report note!');
			e.preventDefault();
		}else{
			var answer = confirm("Do you want to add this note?");
			if(answer){
				$('span#task-status').empty().append('Loading...').show();
				$("input[name=id]").val($('input#report_id').val());
			}
		}
	});

});
</script>

    <style type='text/css'>
    div.container{float:left;width:87%;height:100%;margin-left:auto;margin-right:auto;border:1px solid #7a9512;}
    </style>
    <div style='float:left;width:12px;'>&nbsp;</div>
    <div id='divresult' class='container'>
        <span id='task-status'></span>
		
			<div id="qholder" style="float:left;width:80%;padding:10px;">
                <table width="100%" cellspacing="2" class="list">
            		<tr><td height='30' class='header' colspan='4'>View Bug Details
                        <div style='float:right;font-weight:normal;'>[<a href='#notes'>notes</a>] [<a href='#history' id='jumphist'>history</a>]</div></td>
                    </tr>
                    <tr>
                    <td class="label2" width='170'>ID</td>
                    <td class="label2" width='170'>Severity</td>
                    <td class="label2" width='150'>Date Submitted</td>
                    <td class="label2" colspan='2'>Last Updated</td>
                    </tr>
                    <tr>
                    <td class="item lolite"><?php printf('%05d', $report['id']);?></td>
                    <td class="item lolite"><?php echo $report['severity'];?></td>
                    <td class="item lolite"><?php echo $report['creation_date'];?></td>
                    <td class="item lolite" colspan='2'><?php echo $report['update_date'];?></td>
                    </tr>
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
                    <tr><td class='lolite' colspan='4'></td></tr>
                    <tr>
                    <td class="label2">Reporter</td>
                    <td class="form2 hilite" colspan='3'><?php echo $report['reporter'];?></td>
                    </tr>
                    
                    <tr>
                    <td class="label2">Assign To</td>
                    <td class="form2 hilite" colspan='3' id='report_assignto'><?php echo $report['assigned'];?></td>
                    </tr>
                    
                    <tr>
                    <td class="label2">Status</td>
                    <td class="form2 hilite"><?php echo ucfirst($report['status']);?>
                    <?php //$priority = explode('_', $report['priority'], 2); echo ucfirst($priority[0]);?></td>
                    
                    <td class="label2" width='100'>Resolution</td>
                    <td class="form2 hilite"><?php echo ucfirst($report['resolution']);?></td>
                    </tr>
                    
                    <!--<tr>
                    <td class="label2">Status</td>
                    <td class="form2 hilite" colspan='3' id='report_status'><?php //echo ucfirst($report['status']);?></td>-->
                    
                    <!--<td class="label2">Resolution</td>
                    <td class="form2 hilite">Open</td>-->
                    <!--</tr>-->
                    
                    
                    <tr><td class='lolite' colspan='4' style='height:7px;'></td></tr>
        
                    <tr>
                    <td class='label2'>Title / Summary:</td>
                    <td class='form2 hilite' colspan='3'><?php echo $report['report_title'];?></td>
                    </tr>
                    
                    <tr>
                    <td class='label2'>Link (URL):</td>
                    <td class='form2 hilite' colspan='3'>
                        <?php
                        $report_link = $report['report_link'];
                        if(preg_match('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', $report_link, $match))
                            $report_link = "<a href='".$match[0]."' target='_blank'>".$match[0]."</a>";
                        echo $report_link;?></td>
                    </tr>
                    
                    <tr>
                    <td class='label2'>Steps To Reproduce /<br/> How did you get here? </td>
                    <td class='form2 hilite' colspan='3'>
                        
                    <?php
                        $str = nl2br(htmlspecialchars($report['steps_reproduce']));
                        $str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $str);
                        $str = stripslashes($str);
                    echo $str;?>

                    </td>
                    </tr>
                    
                    <tr>
                    <td class='label2'>Actual Result:</td>
                    <td class='form2 hilite' colspan='3'>
                    <?php $str = nl2br(htmlspecialchars($report['actual_result']));
                        $str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $str);
                        $str = stripslashes($str);
                    echo $str;?></td>
                    </tr>
                    
                    
                    <tr>
                    <td class='label2'>Expected Result / <br/> What were you expecting to happen? </td>
                    <td class='form2 hilite' colspan='3'>
                        <?php $str = nl2br(htmlspecialchars($report['expected_result']));
                        $str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $str);
                        $str = stripslashes($str);
                    echo $str;?>
                    </td>
                    </tr>
                    
                    <tr>
                    <td class='label2'>Additional Information</td>
                    <td class='form2 hilite' colspan='3'><?php echo $report['other_info'];?></td>
                    </tr>
                    
                    <tr><td class="label2">Attached Files</td>
                    <td class='form2 hilite' colspan='3'>
                        <?php
                        $files = $report['files'];
                        if( count($files) ) {
                            foreach( $files as $file ) {
                                if( file_exists("../../portal/uploads/bugreport/".$report['userid']."/".$file['file_name']) )
                                    $file_link = "<a href='/portal/uploads/bugreport/".$report['userid']."/".$file['file_name']."'";
                                else
                                    $file_link = "<a href='/portal/uploads/bugreport/".$file['file_name']."'";
                                
                                if( strpos($file['file_name'], '/') !== false )
                                    $file_link = $file_link . " target='_blank'>".substr($file['file_name'], strpos($file['file_name'], '/')+1)."</a> &nbsp;";
                                else
                                    $file_link = $file_link . " target='_blank'>".$file['file_name']."</a> &nbsp;";
                                echo $file_link;
                            }
                        }
                        ?>
                    </td>
                    </tr>
                </table>
                
                <div style='float:right;width:100%;right:10px;border:1px solid #aaa;padding-bottom:9px;'>
                <form id='bug_form' action='?/index/' method='post' style='padding:0;top:0;'>
                    <input type='hidden' name='report_id' id='report_id' value='<?php echo $report['id'];?>'/>                
                    <input type='hidden' name='assignto' id='assignto'/>
                    <input type='hidden' name='assignto_ref' id='assignto_ref' value='personal.userid'/>    
                    <div style='width:auto;margin-left:auto;margin-right:auto;'>
                        <div class='nav'>
                            <ul>
                                <li><input type='button' class='button' value="Edit" name='edit' id='report_edit' title="Edit Details"/></li>
                                <li><input class="inputbox2" name="staff_name" id="staff_name" style='width:160px;height:16px;' />
                                    <input type='button' class='button' value="Assign" name='assign_to' id='assign_to'/> &nbsp;
                                <!--<select name='users' id='users' class='inputbox2' style='width:170px;height:22px;'>
                                    
                                </select>-->
                                </li>
                                <li>
                                <select name='status' id='status' class='inputbox2' style='width:120px;height:22px;'>
                                    <option value=''>--</option>
                                    <?php if( count($status_array) > 0) {
                                      foreach( $status_array as $status ){
                                        if( $status != $report['status'] ) echo "<option value='".$status."'>".ucfirst($status)."</option>";
                                      }
                                    }?>
                                </select>
                                <input type='button' class='button' value="Change Status" name='changestatus' id='changestatus'/> &nbsp;</li>
                                <li><?php if($report['status']!='deleted'):?>
                                    <input type='button' class='button' value="Mark as deleted" name='delete' id='report_delete' title="Delete Report"/>
                                    <?php else: echo 'Deleted';
                                    endif;?>
                                    
                                </li>
                                <!--<li><a href='#newtrigger' class='newtrigger'>Report Bug</a></li>-->
                            </ul>
                        </div>
 
                    </div>
                </form>
                <!--<input type='button' class='button' value="Cancel" name='cancel' title="Cancel"/> &nbsp;
                <input type='submit' class='button' value="Submit" name='submit' title="Submit new report" form="bug_form"/>-->
                </div>
            
            </div>
            <p>&nbsp;</p>
            
            <div style='float:left;width:80%;padding:12px;'>
            <a name='notes'/>
                <div style='float:left;width:100%;padding-top:10px;border:1px solid #ff9900;'>
                    <div style='float:left;width:100%;padding-left:2px;text-align:left;position:relative;bottom:5px;'>Notes [ <a href='#lognotes' id='showhidenotes'>Hide</a> ]</div>
                    <form action="?/add_note" method="post" target="ajaxframe" enctype="multipart/form-data" name="noteform" id="noteform">
                        <input type='hidden' name='id'/>

                    <table width='100%' border='0' cellpadding="7" cellspacing="2" class="list" id="notes">
                        <tr>
						<td class='form2' style='width:80%' id='notelist'>
						<?php if(count($notes) > 0):
							foreach($notes as $k => $note):
								$user_info = $note['user_info'];
							?>
								<div style='width:100%;float:left;padding:2px;font-size:11px;background:#E3FFB0;border-bottom:1px solid #aaa;'>
								<?php echo $note['date'].' <strong>'.$user_info['fname'].': </strong>'.$note['note_content'];?>
								</div>
							<?php endforeach;
						endif;?>
						  
						  <textarea id="report_note" name='report_note' class='text' rows='2' style='width:95%;'></textarea>
						</td>
                        <td class='item' style='width:15%;' valign='baseline'>
                            <input type='submit' style='float:left;margin-top:20%;bottom:1px;' class='button' value="Add Note" name='submit_notes'/>
                        </td>
						</tr>
                    </table>
                    </form>
                </div>
    
            </div>
            
            <p>&nbsp;</p>

            <div style='float:left;width:80%;padding:12px;'>
                
                <div style='float:left;width:100%;padding-top:10px;border:1px solid #ff9900;'>
                    <div style='float:left;width:100%;padding-left:2px;text-align:left;position:relative;bottom:5px;'>Upload Files [ <a href='#uploadfiles' id='showhideupload'>Show</a> ]</div>
                    <form action="?/upload_files" method="post" target="ajaxframe" enctype="multipart/form-data" name="fileform" id="fileform">
                        <input type='hidden' name='id' value='<?php echo $report['id'];?>'/>
                    <table width='100%' border='0' cellpadding="7" cellspacing="2" class="list" id="uploads">
                        <tbody>
                        <tr><td class='label2' style='width:10%;'>Select Files<br/>
                        <span style='font-size:10px;font-weight:normal'>(Maximum size: 200kb)</span>
                        </td>
                        <td class='item' style='width:15%'>
                            <input type='file' id="inpfile" name="inpfile[]" class='button'/><br/>
                            <input type='file' id="inpfile" name="inpfile[]" class='button' style='padding:2px;'/><br/>
                            <input type='file' id="inpfile" name="inpfile[]" class='button' style='padding:2px;'/>
                        </td>
                        <td class='item' style='width:15%;' valign='baseline'>
                                <input type='submit' style='float:left;margin-top:20%;bottom:1px;' class='button' value="Upload" name='submit' title="Upload files" form="fileform"/>
                            </td>
                        </tr>
                        
                        </tbody>
                    </table>
                    </form>
                </div>
    
            </div>
            
            <p>&nbsp;</p>
            <div style='float:left;width:80%;padding:12px;'>
                <a name='history'/>
                <div style='float:left;width:100%;padding-top:10px;border:1px solid #ff9900;'>
                    <div style='float:left;width:100%;padding-left:2px;text-align:left;position:relative;bottom:5px;'>History [ <a href='#loghist' id='showhidehist'>Show</a> ]</div>

                    <table width='100%' border='0' cellpadding="7" cellspacing="2" class="list" id="logs">
                        <tbody>
                        <tr><td class='label2' style='width:20%;'>Date</td>
                        <td class='label2' style='width:15%'>User Name</td>
                        <td class='label2' style='width:70%;'>Changes</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
    
            </div>
       
    </div>
<br />
<script type="text/javascript">
<!--
function displayNote(date, author, note) {
    var tbl = jQuery('td#notelist div:last');
    if( note != "" ) {
        if( tbl.length > 0 )
            tbl.append("<div style='width:100%;float:left;padding:2px;font-size:11px;'>"+date+" <strong>"+author+": </strong>"+note+"</div>");
        else {
            tbl = jQuery('td#notelist');
            tbl.prepend("<div style='width:100%;float:left;padding:2px;font-size:11px;'>"+date+" <strong>"+author+": </strong>"+note+"</div>");
        }
        jQuery('textarea#report_note').val('');
    }
    jQuery('span#task-status').empty().append('Note Added.').show().fadeOut(10000);
    
    
    
}

function createUploadResult(err_msg) {
    if( err_msg )
    	jQuery('span#task-status').empty().append(err_msg).show().fadeOut(9000);
	/*else {
		alert('The data has been saved.');
		location.href='apptest.php?/testinfo/'+id;
	}*/
}
function createResult(err_msg, id) {
    if( err_msg )
    	jQuery('span#task-status').empty().append(err_msg).show().fadeOut(9000);
	else {
		location.href='?/view_details/'+id;
	}
}
-->
</script>
