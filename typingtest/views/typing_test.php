<style type="text/css">
   form {margin: 20px auto; width: 500px;}
</style>

<script type="text/javascript">
<!---
var ttMin = <?php echo $duration>0?$duration:5;?>;
var ttSec = 0;
var total_words = 0;
var total_chars = 0;

$.fn.wrapStart = function (numWords) { 
    var node = this.contents().filter(function () {
        return this.nodeType < 4
     }),
     
     text = node.text(),
     foundWords = text.split(/[\s,]+/, numWords);
	 first = foundWords[foundWords.length-1];
	 //first = text.split(" ", numWords).join(" ");

    if (!node.length)
        return;
	
	for( var i=0, len=node.length; i<len; i++ ) {
		alert(node[i].nodeValue+': '+node[i].nodeName+' - '+node[i].nodeType);	
	}
	alert(text+' :: '+foundWords.join(" "));
	var rstr = "\\b(" + first + ")\\b";
	//var rstr = "\\b" + first + "\\b(.+)?";
	var reg = new RegExp(rstr);
	var newtext = text.split(reg);
	
    
    //node[0].nodeValue = text.slice(first.length);
	//alert(first+':'+text.slice(foundWords.length)+'... ');
	//var newtext = text.split(' '+first+' ');
	
	//alert('first:>'+first+'< newtext0:'+newtext[0]+' > '+newtext[newtext.length-1]);//+' :: '+node[1].nodeValue);
	
	//node[0].nodeValue = newtext[0] + '<span>' + first + '</span>';
	
	//node[1].nodeValue = newtext[newtext.length-1];
	//alert('>'+first+'< :'+node[0].nodeValue+' > '+node.length+' :: '+node[1].nodeValue);
	
    node.before(newtext[0] + ' <span>' + first + '</span>');
};


//$(document).click(function() { $("div#user_input").focus() });
$(function($){
    /*$.fn.editableContent = function() {
        return this.html().replace(/<div>/gi,'<br>').replace(/<\/div>/gi,'');   
    };*/
	var input_text = typtest.trim($('div#text_source').text());
	total_chars = input_text.length;
	total_words = input_text.split(/[\s]+/).length+1;

	$('div#user_input').focus();
	/*$("div#user_input").click(function(e){
		typtest.setEndOfContenteditable($("div#user_input").get(0));
		e.preventDefault();});*/
	typtest.init_keytest();
	$('input#btntest').click(function(){
		//alert(typtest.getContentEditableText($('div#user_input')).replace(/\\n/g,"\n"));
		//var h = countVisibleCharacters(document.getElementById('text_source') );
		//var hiddenEls = new Array();
		//checkIfInView($('.currentword'));
		
		//var sh = $("div#text_source")[0].scrollHeight;
	});
	
});
function checkIfInView(element){
    var offset = element.position().top - $('#text_source').scrollTop() - 200;
    if(offset > $('#text_source').height()){
	//if($('#text_source').scrollTop() > $('#text_source').height()){
        // Not in view
        $('#text_source').animate({scrollTop: offset}, 500);
        return false;
    }
   return true;
}

function countVisibleCharacters(element) {
    var text = element.firstChild.nodeValue;
    var r = 0;

    element.removeChild(element.firstChild);

    for(var i = 0; i < text.length; i++) {
        var newNode = document.createElement('span');
        newNode.appendChild(document.createTextNode(text.charAt(i)));
        element.appendChild(newNode);

        if(newNode.offsetLeft < element.offsetWidth) {
            r++;
        }
    }

    return r;
}
function submitResult() {
	var uid = $('input#userid').val();
	var test_id = $('input#test_id').val();
	var gwpm = $('td#gross_speed').text();
	var nwpm = $('td#net_speed').text();
	var errors = $('td#total_errors').text();
	var keys = $('td#keystrokes').text();
	var correct = $('input#correct').val();
	$.ajax({
		type: "POST",
		url: "typing.php?/user_result_save",
		data: { 'userid':uid, 'gwpm':gwpm, 'test_id':test_id, 'nwpm':nwpm,
			'errors':errors, 'keys':keys, 'correct':correct },
		dataType: "json",
		success: function(data){
			location.href='/portal/applicant_test.php';
			return true;
		}
	});
}


/*$(document).ready(function() {
	$("div#user_input").click(function(e){
		typtest.setEndOfContenteditable($("div#user_input").get(0));
		e.preventDefault();});
	typtest.init_keytest();
});*/

// -->
</script>
<style type='text/css'>
span.currentword { text-decoration:underline; color:#FF8301;/*31617B;*/ }
</style>


<div class="newscontainer" style='padding:12px 0 12px 0;'>
	
	
	
	<!--<div style='float:left;width:35px;height:100%;'>sdfsdf</div>-->
	
    <div style='float:left;width:80%;height:100%;'>
		<div class="graybox"><?php echo $test_info['test_name'];?>
		</div>
		

		<div class="bg_box">
			<div id="text_source" class="text_content">
				<?php echo $test_info['test_content'];?> 
			</div>
			<hr style='float:left;width:100%;color:#7a9512;'/>
			<span id='timernotice'>Timer will start when you press your first key! &nbsp;&nbsp;-&nbsp;&nbsp;
			Press enter or space key when you finish the test.</span>
			<div id='user_input' class="text_content" contenteditable="true"></div>
			<!--<textarea id='user_input' class="text_content" ></textarea>-->
			<!--<div id='debug' style='width:100%;height:100px;float:left;overflow:auto;border:1px solid #ff0000;'></div>-->
		</div>
		
	</div>
	
	<div style='float:right;width:220px;height:height:100%;'>
		
			<!--<div style='float:left;width:180px;height:100px;border:1px solid #ccc;'></div>-->
	
	
		<div class="left" style='padding:40px 0 0 0;'>
			 <div style='float:left;text-align:center;width:100%;height:23px;line-height:20px;background:#7a9512;color:#fff;font-size:17px;font-weight:bold'>
			TIMER</div>
			 <div id='counter' style='text-align:center;font-size:20px;padding:30px 2px 0 2px;'></div>
			  <br /><br />
			  <div style='padding:6px;'>
			  <p><span class="label">WPM</span>
				<span id="WPM">0</span></p>
			  <p><span class="label">Net WPM</span>
				<span id="NPM">0</span>
				</p>
			  <p><span class="label">Error</span>
				<span id="ERR">0</span>
				</p>
			  <!--<input type='button' id='btntest' value='Test'/>-->
				</div>
				

		</div>

	</div>
	
</div>


<div id='resultdiv' class='overlay'><span id='task-status'></span>
  <div class='content' style='width:420px;padding:3px;border:1px solid #011a39;margin: 5% auto'>
	<div class='title'>Typing Test Result <span id='notecat'></span></div>
		
		<form name='regform' method='POST' target='ajaxframe' action='?/sendemail/' style='float:left;padding:0;margin:0;'>
			<input type='hidden' name='test_id' id='test_id' value='<?php echo $test_info['id'];?>'/>
			<input type='hidden' name='userid' id='userid' value='<?php echo $user_info['userid'];?>'/>
			<input type='hidden' name='duration' id='duration' value='<?php echo $duration;?>'/>
			<input type='hidden' name='correct' id='correct' value='0'/>
			<table width="70%" border='0' cellpadding="0" cellspacing="0" class="list">
			  
			  <tr><td class='form2' style='width:120px;'>Your Name:</td><td class='form2'><?php echo $user_info['fname'].' '.$user_info['lname'];?></td></tr>
			  <tr><td class='form2'>Email Address:</td><td class='form2'><?php echo $user_info['email'];?></td></tr>
			  <tr><td class='form2'>Test Title:</td><td class='form2'><?php echo $test_info['test_name'];?></td></tr>
			  <tr><td class='form2'>Duration:</td><td class='form2'><?php echo ($test_info['test_duration']/60).':00 minutes';?></td></tr>
			  <tr><td colspan='2'>&nbsp;</td></tr>
			  <tr><td class='form2' style='width:120px;'>Keystrokes:</td><td class='form2' id='keystrokes'></td></tr>
			  <tr><td class='form2'>Gross Speed:</td><td class='form2' id='gross_speed'></td></tr>
			  <tr><td class='form2'>Errors:</td><td class='form2' id='total_errors'></td></tr>
			  <tr><td class='form2'>Net Speed:</td><td class='form2' id='net_speed'></td></tr>
			  <tr><td class='form2'>Accuracy:</td><td class='form2' id='accuracy'></td></tr>
			   
			 <tr>
			<td colspan="2"><br/>
			<input type='button' class='button' id='submitbutton' value=' OK ' onclick="submitResult();"> &nbsp;
			<input type='submit' class='button' id='createbutton' value='Re-take the Typing Test' onclick="location.href='?/typing_start/userid=<?php echo $user_info['userid'];?>'">
			</tr>
		  </table>
		</form>
	</div>
	
</div>