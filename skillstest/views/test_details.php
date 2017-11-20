
<script type="text/javascript" src="/adhoc/php/js/hilite.js"></script> 
<script type='text/javascript'>
<!--///

//back_link.style.fontSize = '14px';
//back_link.innerHTML = 'Back';
var modified = 0;
$(document).ready(function() {
	// remove layerX and layerY
    var all = $.event.props,
    len = all.length,
    res = [];
    while (len--) {
      var el = all[len];
      if (el != 'layerX' && el != 'layerY') res.push(el);
    }
    $.event.props = res;
	
	//class_ticket();

	$(window).keydown(function(event){
		//alert(event.target.nodeName);
		if(event.keyCode == 13 && event.target.nodeName == 'INPUT') {
		  event.preventDefault();
		  return false;
		}
	});
	
		
	
	$(".pane_content").hide();
	$("div.client ul li:first").addClass("youarehere");
	$(".pane_content:first").show();
	
	$("a#question_new").click(function() {
		if( !$('input#test_id').val() ) {
			alert('Please create first the Test details.')
			//return false;
		} else if(modified) {
			if(confirm("Press OK and changes will be lose or\npress Cancel then click on 'Save Changes' button to save any changes")) {
				$('div#newquestion').show();	
			}
		} else
		$('div#newquestion').show();

	});
	
	
	$("form#ticketform").submit(function(e) {
		$('span#task-status').empty().append('Loading...').show();
		var btnName = $("input[type=submit][clicked=true]").val();
		var ticket_id = $('input#tid_email').val();
		
		return true;

    });
	
	$("form#ticketform input[type=submit]").click(function() {
		$("input[type=submit]", $(this).parents("form")).removeAttr("clicked");
		$(this).attr("clicked", "true");
	});
	
	$(':input[name]').live('change onkeyup', function(e) {
		modified = 1;
	});

});


//-->
</script>

<span id='task-status'>status</span>
<?php if($submit == 'Update Ticket'):?>
<!--<div style='float:left;width:100%;background:#FFF3F3;'>
	<a href='?/ticketinfo/<?php echo $next_id-1;?>' title='Previous case' style='float:left;'><img src='images/icons/arrow_back.gif'/></a>
	
	<a href='?/ticketinfo/<?php echo $next_id+1;?>' title='Next case' style='float:right;'><img src='images/icons/arrow_next.gif'/></a>
</div>-->
<?php endif;
	
?>
  <div id='mainbox' style='float:left;width:98%;padding:15px 7px;'>
	
	<form id='ticketform' name='ticketform' method='POST' target='ajaxframe' action='?/process_test/' enctype='multipart/form-data' style='padding:0px;'>
        <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
	<input type='hidden' name='test_id' id='test_id' value='<?php echo $test_id ? $test_id : $next_id;?>'/>
    <div style='float:left;width:100%;background:<?php echo ($redalert) ? '#cc0033' : '#FFF3F3';?>;height:19px;padding-bottom:10px;'>
		
	</div>
	

	<div id='divresult' style='float:left;width:99%;border:1px solid #7a9512;'>
		
		
		
      
		<div id="holder">
		
				
		<div id='status'></div>
		
		
		<div id="qholder" style="margin-left: 15px;">
       
		<table border="0" width="100%" cellspacing="0">
        
		<tr><td colspan="2" height="50" class="header">Test Details</td><td colspan="2" class="header"></td></tr>
        
		<tr>
		<td class="form1">Name</td>
		<td class="form2 quiz" colspan='2'>
			<input class="inputbox" name="test_name" value="<?php echo $test[0]['test_name'];?>" size="80" />
		</td>
       <td><a href="javascript:quiz_enable(<?php echo $test[0]['id'];?>)" id="statlink"><?php if($test[0]['test_status'] > 0) echo 'Disable Test'; else echo 'Enable Test';?></a>
        <input type="hidden" id="quiz_status" name="quiz_status" value="<?php echo $quiz_status;?>" />
        </td>
        
		</tr>
        
		<tr>
		<td class="form1">Description</td>
		<td class="form2 quiz">
			<input class="inputbox" name="test_desc" value="<?php echo $test[0]['test_desc'];?>" size="80" />
		</td>
        </tr>
		
		<tr>
		<td class="form1">Instruction</td>
		<td class="form2 quiz">
			<textarea class="inputbox" name="test_instruction" rows='4' style='width:95%;'><?php echo str_replace("<br/>", "\n", $test[0]['test_instruction']);?></textarea>
		</td>
        </tr>
		<tr>
		<td class="form1">Duration</td>
		<td class="form2 quiz">
			<input class="inputbox" name="test_duration" value="<?php echo $test[0]['test_duration'];?>" size="3" maxlength='3'/> (minutes)
		</td>
        </tr>
	
		</table>
		</div> 
        
        
		
		<div id="qqholder" style="margin-left: 15px;">
		<table id="qtable" border="0" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #ccc;">
		<tr><td colspan="3" class="header">
        
        <span >Questions</span>: ( <span style="font-size:9px;color:#FF0000;"><?php echo count($questions);?></span> )
        <a href="#tqnew" style="color:#FF0000" id="question_new">ADD</a>
        <!--<a href="" style="color:#FF0000">Change Order</a>-->
        
        </td></tr>

		<?php if(count($questions) > 0):
		$ctr = 0;
		foreach ($questions as $question):
			$ctr++;
		?>
		
		<tr  id="q<?php echo $question['id'];?>" style="overflow:hidden; height:100%;">
		<td>
			<input type="hidden" name="test_id" value="<?php echo $test_id;?>" />
            <input type="hidden" id="question_status{$questions[question].id}" name="question_status[{$questions[question].id}]" value="{$questions[question].status}" />
           
			<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-top:1px solid #aaa">
   		       <tr><td style="font-weight:bold; padding-top:7px;" colspan="2">&nbsp;
              </td> <td><!--<a href="#bottom" style="text-decoration:none"><span onmouseover="tooltip('scroll down');"; onmouseout="exit();">&darr;&darr;</span></a>--></td></tr>
		       
               <tr onmouseover="hilite(this);" onmouseout="lowlite(this);" style="height:50px;border:1px solid #aaa;">
               
		       <td class="label" width="90" style="font-weight:bold">&nbsp;Question <?php echo $ctr;?></td>
		       <td align="left"  id="question<?php echo $question['id'];?>">
			   <textarea name="question_text[<?php echo $question['id'];?>]" class='inputbox' rows='1' style='width:67%;'><?php echo $question['question_text'];?></textarea>
			   
			   <td>
               <a href="javascript:question_enable(<?php echo $question['id'];?>,<?php echo $test_id;?>)">
			   <?php if($question['question_status'] > 0):?>
					<span id="pub<?php echo $question['id'];?>">Unpublish</span>
               <?php else:?>
					<span id="pub<?php echo $question['id'];?>">Publish</span>
				<?php endif;?>
				</a> &nbsp; &nbsp;
               <a href="javascript:question_hide(<?php echo $question['id'];?>)" style="color:#FF0000;font-weight:bold;border:1px solid #aaa;">
			   <span onmouseover="tooltip('Delete question #<?php echo $ctr;?>');"; onmouseout="exit();">X</span></a>
               </td>
               
		       </tr>
               
               
		       <tr><td colspan="4" valign="top">
		          <div style="height:100%;">
		             <table width="100%" border="0" cellpadding="0" cellspacing="0">
		             <tr>
		             	<td width="55%">
							<?php $answers = $question['answers'];
								$ctr2 = 1;
							?>
		                 <table width="90%" border="0" cellpadding="0" cellspacing="3" id="answers<?php echo $question['id'];?>" style="border-right:1px solid #aaa;">
                             <tr style="padding:5px;background-color:#ccc;height:20px;">
                             <td colspan="2" class='header'><span>Answers</span>:(<span style="font-size:9px;color:#FF0000;"><?php echo count($answers);?></span>)
                             <a href="javascript: add_more_field(<?php echo $question['id'];?>, false);">Add</a></td>
                             <td width="5%" class='header'>Correct</td>		
                             <td width="5%" class='header'>Score</td>		
                             </tr>
					
					
							<input type="hidden" id="new_answer<?php echo $question['id'];?>" name="new_answer<?php echo $question['id'];?>" value="0" />
							 <?php foreach( $answers as $answer ):?>
							 <tr id="selection<?php echo $answer['id'];?>">
							 <td width="5%"><?php echo $ctr2++;?>.</td>
							 <td id="answer.40" align="left">
							 <input type="hidden" name="answer_id[<?php echo $answer['id'];?>]" value="<?php echo $answer['id'];?>" />
							 <textarea name="answer_text[<?php echo $question['id'];?>][<?php echo $answer['id'];?>]" class="inputbox" rows='1' cols="65" style="height:20px;<?php if($answer['answer_iscorrect']):?>background-color:#FF9933;<?php endif;?>" ><?php echo $answer['answer_text'];?></textarea>
							 <a href="javascript:answer_delete(<?php echo $answer['id'];?>)"	style="color:#FF0000;font-weight:bold;border:1px solid #aaa;">x</a>
							 </td>
							 <td>
							 <input type="checkbox" name="answer_iscorrect[<?php echo $question['id'];?>][]" value="<?php echo $answer['id'];?>" <?php if($answer['answer_iscorrect']):?>checked<?php endif;?> class="inputbox" size="40" /> &nbsp;
							 </td>
							 <td>
							  <input type="text" name="answer_score[<?php echo $question['id'];?>][<?php echo $answer['id'];?>]" value="<?php echo $answer['answer_score'];?>" size="5" />
							 </td>         
							 </tr>
							 <?php endforeach;?>
                       
		                 </table>
                         
                         
		             </td>
                    <td>&nbsp;</td>
                     
                    <td valign="top" align="right" colspan="2">
                      <?php /* FILES AVAILABLE */?>
					  <?php $resources = $question['resources'];?>
                       <input type="hidden" id="file_total<?php echo $question['id'];?>" name="file_total<?php echo $question['id'];?>" value="<?php echo count($resources);?>" />
                       <?php /* THIS HOLD THE NEW FILE*/ ?>
                       <input type="hidden" id="new_file{$questions[question].id}" name="new_file{$questions[question].id}" value="0" />
					   
        
 		               <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;" id="files_list<?php echo $question['id'];?>">
		                <tr>	
		                 <td colspan="2" valign="top" class='header'><span>Image Files</span>:(<span style="font-size:9px;color:#FF0000;"><?php count($resources);?></span>)
                         <a href="javascript: add_more_file(<?php echo $question['id'];?>);">Add more</a></td>
		                </tr>
						
						
 
			              <?php if( count($resources) > 0 ):
						  foreach( $resources as $resource ):?>
						  
						<tr id="display<?php echo $resource['id'];?>" onmouseover="hilite(this);" onmouseout="lowlite(this);" style="height:50px;border:1px solid #aaa;">
               
						<td class="label" width="90" style="font-weight:bold">Display Intro: </td>
						<td align="left">
							<textarea name="resource_display[<?php echo $question['id'];?>][<?php echo $resource['id'];?>]" rows='1' class='text' style='width:90%;'><?php echo $resource['question_resource_display'];?></textarea>
						<td>
						</tr>
		                <tr id="file<?php echo $resource['id'];?>">
  
                        <td colspan='2' id="resource_file<?php echo $resource['id'];?>" onmouseover="hilite(this);" onmouseout="lowlite(this);" style="color:#990000;">
						<span onmouseover="tooltip('<img src=\'/portal/uploads/test/<?php echo $resource['question_resource_filename'];?>\'>');"; onmouseout="exit();">
						<?php echo $resource['question_resource_filename'];?> </span></td>
						<td align="right"> <a href="javascript:resource_delete(<?php echo $resource['id'];?>)"
						style="color:#FF0000;font-weight:bold;border:1px solid #aaa;">x</a>
             
                        </td>
                        </tr>
                        <?php endforeach;
						endif;?>
                        
                        <?php /* REMOVE FILE LINK */?>
                         <tr id="lessfile{$questions[question].id}" style="display:none;"><td align="right"><a href="javascript: less_file({$questions[question].id}, 0);">Less file</a></td></tr>
 
		               </table>
					 
                     </td>
                     
                     
		             
			         </tr>
			         </table>
		          </div>
				<td></tr>
                  

			</table>
		

		</td>
		</tr>

		<?php endforeach;
		endif;?>
		<tr><td align="right" height="50">
                           <input type="hidden" name="task" value="quiz_edit" />
			           <input type="button" value="Cancel" class="inputbox" onclick="location.href='apptest.php?/index/'" />
		               <input type="submit" name="update" value="Save Changes" class="inputbox" />
                       </td></tr>
				
		</table>
       
		</div> 
		 </form>
		
	<a name="bottom">	
		

		</div> 
	</div>

  </div>
  
<div id='newquestion' class='overlay'><span id='task-status'></span>
  <div class='content' style='width:90%;padding:3px;border:1px solid #011a39;'>
	<div class='title'>New Question (<span id='testname'><?php echo $test[0]['test_name'];?></span>)</div>
		
		<form name='regform' method='POST' target='ajaxframe' action='?/createquestion/' enctype='multipart/form-data' style='padding:0;margin:0;'>
			<input type='hidden' name='test_id' id='test_id' value='<?php echo $test_id;?>'/>
			<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list">
			<!--<tr><td class='form1'>Subject:</td>
				<td class='form2'><input type="text" id="email_subject" name="email_subject" value="Remotestaff: Client-Staff Support" class="inputbox2"/></td>
			</tr>-->
			  
			<tr>
				<td class='form2' colspan='2'>Question: &nbsp;&nbsp;&nbsp;
				<textarea name="question_text" cols="100" rows="1"></textarea></td>
			</tr>
			<tr>
				<td class='form2' valign='top'><div>Answers:</div>
					
					<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list" id='newanswer'>
					<tr style="padding:5px;background-color:#ccc;height:20px;">
						<td class='header' colspan='2'><span>Answers</span>:
						<a href="javascript: add_more_field(<?php echo $question['id'];?>, true);">Add</a></td>
						<td width="5%" class='header'>Correct</td>		
						<td width="5%" class='header'>Score</td>		
					</tr>
					
					<tr>
						<td width="5%">1.</td>
						<td id="answer.40" align="left">
						<textarea name="answer_text[]" class="inputbox" cols="70" rows="1"></textarea>
						</td>
						<td>
							<input type="radio" name="answer_iscorrect[]" value="0" class="inputbox" size="40" />
						</td>
						<td>
							<input type="text" name="answer_score[]" value="" size="5" />
						</td>	            
					</tr>
					<tr>
						<td width="5%">2.</td>
						<td id="answer.40" align="left">
						<textarea name="answer_text[]" class="inputbox" cols="70" rows="1"></textarea>
						</td>
						<td>
							<input type="radio" name="answer_iscorrect[]" value="1" class="inputbox" size="40" />
						</td>
						<td>
							<input type="text" name="answer_score[]" value="" size="5" />
						</td>	            
					</tr>
					
					
					</table>
				
				</td>
						
				<td class='form2' width='50%' valign='top'><div>Images: (<span style="font-size:9px;color:#000;">optional</span>)</div>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;" id="files_list">
		                <tr>
                          		
		                 <td colspan="2" valign="top" class='header'><span>Image Files</span>:
                         <!--<a href="javascript: add_more_file({$questions[question].id}, 1);">Add more</a>-->
						 </td>
		                
		                 </tr>
						
						<tr onmouseover="hilite(this);" onmouseout="lowlite(this);" style="height:50px;border:1px solid #aaa;">
               
						<td class="label" style="font-weight:bold">Intro Display: </td>
						<td class='form2'>
							<textarea id="resource_display" name='resource_display' class='text' rows='4' style='width:95%;float:left;'></textarea>
						
						</td>
						
						</tr>
		                 <tr>
                          <td colspan='2' onmouseover="hilite(this);" onmouseout="lowlite(this);" style="color:#990000;">
							<input type='file' id="resource_filename" name="resource_filename" style='float:left;'/>
						  </td>
						
                        </tr>
                        
                                                                 
		               </table>
				</td>
				
			</tr>
			
			   
			 <tr>
			<td colspan="2" align='center'>
			<input type='submit' class='button' id='createbutton' value='Create Question'> &nbsp;&nbsp;
			<input type='button' class='button' value='Cancel' onClick="$('div#newquestion').hide();">
			</tr>
		  </table>
		</form>
	</div>
	
</div>

<!--<form action="?/fileupload/" target="upload_iframe" id="uploadform" name="uploadform" method="post" enctype="multipart/form-data" style='visibility:hidden;'>
<input type='hidden' name='ticket_id' value='<?php //echo $next_id;?>'/>
  <input type="hidden" name="fileframe" value="true">
</form>-->
	<script type="text/javascript">
	<!--
	function answer_delete(id) {
		if(confirm('Do you want to delete this item from the list?')) {
			$.ajax({
				type: "POST",
				url: "apptest.php?/delete/answer",
				data: { 'id': id },
				dataType: "json",
				success: function(data){
					//if( data.text ){
					alert('Answer id #'+id+' was deleted!');
					//e.text( (e.text()=='Enable Test'?'Disable Test':'Enable Test') );
					$('tr#selection'+id).hide();
				
					return true;
				}
			});
		}
	}
	
	function resource_delete(id) {
		if(confirm('Do you want to delete this resource image?')) {
			$.ajax({
				type: "POST",
				url: "apptest.php?/delete/resource",
				data: { 'id': id },
				dataType: "json",
				success: function(data){
					//if( data.text ){
					alert('Resource id #'+id+' was deleted!');
					//e.text( (e.text()=='Enable Test'?'Disable Test':'Enable Test') );
					$('tr#display'+id).hide();
					$('tr#file'+id).hide();
				
					return true;
				}
			});
		}
	}
	
	function quiz_enable(id) {
		var e = $('a#statlink');
		
		$.ajax({
			type: "POST",
			url: "apptest.php?/teststatus/",
			data: { 'test_id': id, 'status':e.text() },
			dataType: "json",
			success: function(data){
				//if( data.text ){
				//alert(+e.text()+'');
				e.text( (e.text()=='Enable Test'?'Disable Test':'Enable Test') );
			
				return true;
			}
		});
	}
	function question_enable(id, test_id) {
		var e = $('span#pub'+id);
		
		$.ajax({
			type: "POST",
			url: "apptest.php?/setqstatus/",
			data: { 'question_id': id, 'status':e.text(), 'test_id':test_id },
			dataType: "json",
			success: function(data){
				//if( data.text ){
				alert('Question #'+id+' is now '+e.text()+'ed');
				e.text( (e.text()=='Publish'?'Unpublish':'Publish') );
			
				return true;
			}
		});		
	}
	
	function question_hide(id) {
		$('tr#q'+id).hide();
	}
	
	function add_more_file(question_id) {
		
		var root = $('table#files_list'+question_id);
		root.append("<tr onmouseover='hilite(this);' onmouseout='lowlite(this);' style='height:50px;border:1px solid #aaa;'>"+         
			"<td class='form2' style='font-weight:bold'>Message Display: </td>"+
			"<td class='form2'><textarea name='resource_display["+question_id+"][]' class='text' rows='1' cols='60'></textarea></td></tr>"+
			"<tr><td colspan='2' onmouseover='hilite(this);' onmouseout='lowlite(this);' style='color:#990000;'>"+
			"<input type='file' name='resource_filename["+question_id+"][]' style='float:left;'/></td></tr");
	}
	
	function add_more_field(question_id, newans) {
		
		if( newans ) {
			var root = $('table#newanswer');
			var cellarray = new Array('&nbsp;',
			'<textarea name="answer_text[]" class="inputbox" cols="70" rows="1" style="height:20px;"></textarea>',
			'<input type="radio" name="answer_iscorrect[]" value="0" class="inputbox" size="40" /> &nbsp;',
			'<input type="text" name="answer_score[]" value="0" size="5" />');
		} else {
			var root = $('table#answers'+question_id);
			var cellarray = new Array('&nbsp;',
			//'<input type="hidden" name="new_answer_id['+question_id+']" value="" />'+
			'<textarea name="answer_text['+question_id+'][]" class="inputbox" rows="1" cols="70" style="height:20px;"></textarea>',
			'<input type="radio" name="answer_iscorrect['+question_id+'][]" value="0" class="inputbox" size="40" /> &nbsp;',
			'<input type="text" name="answer_score['+question_id+'][]" value="0" size="5" />');	
		}
		
		var new_answer = $('new_answer'+question_id).value;
	
		var cells = '';
		for (i = 0; i < 4; i++) {
		
			cells += "<td style='background:#aaa;'>"+cellarray[i]+"</td>";
		}
		root.append("<tr>"+cells+"</tr>");
		
	}
	
	function isNumber(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}


	function createResult(err_msg, id) {
		if( err_msg )
			$('span#task-status').empty().append(err_msg).show().fadeOut(6000);
		else {
			alert('The data has been saved.');
			var seat_id = $('input#seat_id').val();
			var staff_id = $('input#staff_id').val();
			location.href='apptest.php?/testinfo/'+id;
		}
	}
	
	//-->
	</script>