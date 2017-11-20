<script type="text/javascript">
jQuery().ready(function($){
    brep.load_assignto('staff_name', '<?php echo $report['assigned'];?>', 'assignto');
    
    /*Calendar.setup({inputField : "bugdate", trigger: "bd", onSelect: function() { this.hide()  },//showTime   : 12,
		fdow:0, dateFormat : "%Y-%m-%d"
    });*/
    brep.submit_form('bug_form');
    var report_id = $('input#report_id').val();
    
    
    $('table#logs').hide();
    $('table#uploads').hide();
	$('input#cancel').click(function() {
        
        history.go(-1);
		//location.href='?/view_details/'+report_id;
	});
    $('select[name=resolution]').change(function(){
        var res = $(this).val();
        if(res != 'open') $('.notbugWin').show();
        else $('.notbugWin').hide();
    });
    //$('.notbugWin').jqm({overlay: 50, modal: true, trigger: false});
});
</script>   
<style type='text/css'>
div.container{width:87%;height:600px;margin-left:auto;margin-right:auto;border:1px solid #7a9512;}
.notbugWin {
    display: none;
    position: absolute;
    margin-left: -30px;
    background-color: #696;
    color: #000;
    border: 1px solid black;
	width:250px;padding:6px;
	border:1px solid #ff9900;
    left:67%;
}

/*.jqmOverlay { background-color: #000; }*/

</style>
    </style>
    
    <div id='divresult' class='container'>
        <span id='task-status'></span>
		
			<div id="qholder" style="float:left;width:80%;padding:10px;">
                <form id='edit_form' target='ajaxframe' action='/portal/bugreport/?/update_report/' method='post'>
                    <input type='hidden' name='report_id' id='report_id' value='<?php echo $report['id'];?>'/>
                    <input type='hidden' name='assignto' id='assignto'/>
                <table width="100%" cellspacing="2" class="list">
            		<tr><td height='30' class='header' colspan='4'>Edit Bug Details</td></tr>
                    <tr>
                    <td class="label2" width='170'>ID</td>
                    <td class="label2" width='170'>Severity</td>
                    <td class="label2" width='150'>Status</td>
                    <td class="label2">Resolution</td>
                    </tr>
                    
                    <tr>
                    <td class="item lolite"><?php printf('%05d', $report['id']);?></td>
                    <td class="item lolite"><select name='severity' id='severity' class='inputbox2' style='width:120px;height:22px;'>
                         <?php if( count($severity_array) > 0) {
                                    foreach( $severity_array as $severity ){
                                        $str = "<option value='".$severity."'";
                                        if( $severity == $report['severity'] ) $str .= " selected";
                                        $str .= ">".ucfirst($severity)."</option>";
                                        echo $str;
                                    }
                                }?>
						</select></td>
                    
                    <td class="item lolite" ><select name='status' id='status' class='inputbox2' style='width:120px;height:22px;'>
                                    <?php if( count($status_array) > 0) {
                                      foreach( $status_array as $status ){
                                        $str = "<option value='".$status."'";
                                        if( $status == $report['status'] ) $str .= " selected";
                                        $str .= ">".ucfirst($status)."</option>";
                                        echo $str;
                                      }
                                    }?>
                                </select></td>
                    
                    <td class="item lolite" ><select name='resolution' class='inputbox2' style='width:120px;height:22px;'>
                        <option value=''></option>
                          <?php if( count($resolution_array) > 0) {
                            foreach( $resolution_array as $res ){
                                $str = "<option value='".$res."'";
                                if( $res == $report['resolution'] ) $str .= " selected";
                                $str .= ">".ucfirst($res)."</option>";
                                echo $str;
                            }
                            }?>
						</select>
                        <div class='notbugWin' id='addnote'>
                        <span>Resolution note (optional):</span>
                        <!--<a href='#' class='jqmClose' style='float:right'>Close</a>--><hr>
                            
                        <div style='width:100%;float:left'>
                            <textarea class="inputbox2" id='report_note' name="report_note" style='width:97%;height:27px;'></textarea>
                            <!--<span style='float:right;'><input type='button' id='submit_note' value='Ok'/></span>-->
                        </div>
                      </div>
                        </td>
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
                    <!--<tr>
                    <td class="label2">Reporter</td>
                    <td class="form2 hilite" colspan='3'></td>
                    </tr>-->
                    
                    <tr>
                    <td class="label2">Assign To</td>
                    <td class="form2 hilite" colspan='3'>
                        <input class="inputbox2" name="staff_name" id="staff_name" style='width:79%;' />
                        <!--<select name='staff_name' id='staff_name' class='inputbox2' style='width:170px;height:22px;'>
                            <option value='0'>[any]</option>
                                    <?php if( count($inhouse_staff) > 0) {
                                      foreach( $inhouse_staff as $staff ){
                                        $str = "<option value='".$staff['userid']."'";
                                        if( $staff['userid'] == $report['assignto']) $str .= " selected";
                                        $str .= ">".$staff['fname']." ".$staff['lname']."</option>";
                                        echo $str;
                                      }
                                    }
                                    ?>
                                </select>-->
                    </td>
                    </tr>
                    
                    <!--<tr>
                    <td class="label2">Priority</td>
                    <td class="form2 hilite">Normal</td>
                    
                    <td class="label2" width='100'>Resolution</td>
                    <td class="form2 hilite">
                        <select name='severity' id='severity' class='inputbox2' style='width:120px;height:22px;'>
                          
						</select>
                    </td>
                    </tr>-->
                    
                    <!--<tr>
                    <td class="label2">Status</td>
                    <td class="form2 hilite" colspan='3'>New</td>
                    
                    <td class="label2">Resolution</td>
                    <td class="form2 hilite">Open</td>
                    </tr>-->
                    
                    
                    <tr><td class='lolite' colspan='4' style='height:7px;'></td></tr>
        
                    <tr>
                    <td class='label2'>Title / Summary:</td>
                    <td class='form2 hilite' colspan='3'>
                        <input class="inputbox2" name="report_title" value="<?php echo htmlentities($report['report_title'], ENT_QUOTES);?>" style='width:79%;' />
                    </td>
                    </tr>
                    
                    <tr>
                    <td class='label2'>Link (URL):</td>
                    <td class='form2 hilite' colspan='3'>
                        <input class="inputbox2" name="report_link" value="<?php echo htmlentities($report['report_link'],ENT_QUOTES);?>" style='width:79%;' /></td>
                    </tr>
                    
                    <tr>
                    <td class='label2'>Steps To Reproduce /<br/> How did you get here? </td>
                    <td class='form2 hilite' colspan='3'>
                        <textarea class="inputbox2" name="steptorep" rows='3' style='width:79%;height:66px;'><?php echo stripslashes(preg_replace('(\\\r\\\n|\\\r|\\\n)', "\n", $report['steps_reproduce']));?></textarea></td>
                    </tr>
                    
                    <tr>
                    <td class='label2'>Actual Result:</td>
                    <td class='form2 hilite' colspan='3'>
                        <textarea class="inputbox2" id='actualresult' name="actualresult" style='width:79%;height:44px;'><?php echo stripslashes(preg_replace('(\\\r\\\n|\\\r|\\\n)', "\n", $report['actual_result']));?></textarea></td>
                    </tr>
                    
                    
                    <tr>
                    <td class='label2'>Expected Result / <br/> What were you expecting to happen? </td>
                    <td class='form2 hilite' colspan='3'>
                        <textarea class="inputbox2" name="expectedresult" rows='3' style='width:79%;height:44px;'><?php echo stripslashes(preg_replace('(\\\r\\\n|\\\r|\\\n)', "\n", $report['expected_result']));?></textarea></td>
                    </tr>
                    
                    <tr>
                    <td class='label2'>Additional Information</td>
                    <td class='form2 hilite' colspan='3'>
                        <input class="inputbox2" name="otherinfo" value="<?php echo htmlentities($report['other_info'],ENT_QUOTES);?>" style='width:79%;' />
                        <span style='font-size:10px;font-weight:normal'>(Maximum char: 250)</span>
                    </td>
                    </tr>
                    
                    <!--<tr><td class="label2">Attached Files</td>
                    <td class='form2 hilite' colspan='3'></td>
                    </tr>-->
                </table>
                </form>
                
                <div style='float:right;width:100%;right:10px;border:1px dotted #ff0000;'>
                <!--<form id='case_form' action='ticket.php?/index/' method='post'>
                    <input type='hidden' name='status' id='status' value=''/>
                    <input type='hidden' name='tab' id='tab' value='<?php echo $tab;?>'/>
                    <input type='hidden' name='leads_id' id='leads_id' value='<?php echo $leads;?>'/>
                    <input type='hidden' name='userid' id='userid' value='<?php echo $userid?$userid:($filter['userid']?:$filter['userid']);?>'/>
                
                        
                    <div style='width:auto;padding:6px;margin-left:auto;margin-right:auto;'>
                        <div class='nav'>
                            <ul>
                                <li><input type='button' class='button' value="Edit" name='cancel' title="Cancel"/></li>
                                <li><input type='button' class='button' value="Assign To:" name='cancel'/>
                                <select></select>
                                </li>
                                <li><input type='button' class='button' value="Change Status:" name='cancel'/>
                                <select></select></li>
                                <li><input type='button' class='button' value="Delete" name='cancel' title="Cancel"/></li>
                            </ul>
                        </div>
 
                    </div>
                </form>-->
                <input type='button' class='button' value="Cancel" name='cancel' id='cancel' title="Cancel"/> &nbsp;
                <input type='submit' class='button' value="Save Changes" name='submit' title="Edit report" form="edit_form"/>
                </div>
            
            </div>
            <p>&nbsp;</p>




       
    </div>
<br />

<script type="text/javascript">
<!--
function createResult(err_msg, id) {
    if( err_msg )
    	jQuery('span#task-status').empty().append(err_msg).show().fadeOut(9000);
	else {
		//alert('The data has been saved.');
		location.href='?/view_details/'+id;
	}
}

function createUploadResult(err_msg) {
    if( err_msg )
    	jQuery('span#task-status').empty().append(err_msg).show().fadeOut(9000);
	/*else {
		alert('The data has been saved.');
		location.href='apptest.php?/testinfo/'+id;
	}*/
}
-->
</script>
