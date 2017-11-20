
var typtest = (function(){
var xLastTime = 0;
var xTime = 0;
var xTotal = 0;
var xKeys = 0;

var wordPos = 1;
var lastWord = '';

var xWords = 1;
var gWPM = 0;

foundWord = false;
var errNum = -1;
var bkspc = 0;
var xSpc = 0;
return{
	init_keytest:function() {
		$(document).unbind('keydown').bind('keydown', function (e) {
			switch (e.keyCode) {
				case 37:
				case 38:case 39:
				case 32:  // space
					if( xSpc > 5) e.preventDefault();
				  break;
				case 8:
					if( xKeys > 0 && bkspc > 1 && bkspc > 0 )
						e.preventDefault();
					break;
				
			 }
		});


		
		
		//$('div#user_input').keypress(function(e){ return e.which != 13; });
		
				  
		$('div#user_input')
			.keyup(function(e){
				typtest.checkSpeed();
				if( !xKeys ) {
					countdown('counter');
					$('span#timernotice').fadeOut(2000);
				}
				
				key = e.which ? e.which : e.keyCode;
				//$("div#text_source").wrapWord(xWords, 'content.');
				//alert('bkspc:'+bkspc+' : '+key);
				if( (/\s+/.test(String.fromCharCode(key) || key == 13 )) || xWords == 1) {
					if( xSpc==0 ) {					
					var divcontent = $('div#text_source');
					divcontent.find("span").each(function(index) {
						var text = $(this).text();//get span content
						$(this).replaceWith(text);//replace all span with just content
					});
					divcontent.html(divcontent.html());//get back new string
					
					//checkSpeed();
					// check error
					//lastInput = typtest.trim($(this).val()).split(/[\s|\r\n]+/);
					
					/*user_text = typtest.getContentEditableText($('div#user_input')).replace(/\\n/g,"\n");
					lastInput = typtest.trim(user_text).split(/\s+/);*/
					lastInput = typtest.get_userText();
					//$('div#debug').prepend('LW:'+typtest.lastWord+':'+lastInput[lastInput.length-1]+'<br/>');
					var words_num = (lastInput.length == 1 && xWords == 1) ? lastInput.length : lastInput.length+1;
					if( typtest.lastWord != lastInput[lastInput.length-1]) {
						errNum++;
						$('#ERR').html(errNum);
					}
					
					
					$("div#text_source").wrapWord(words_num); //, 'content.');
					}
					//2012-10-12
					if( total_words == xWords ) typtest.typing_finish();
					
					//2012-10-11 - checkIfInView($('.currentword'));
					bkspc = 0;
					xSpc++;
				} else {
					if( key == 8 && xKeys > 0 ) bkspc++;
					else bkspc>0?bkspc--:0;
					xSpc = 0;
				}
	
			});
	},
	
	checkSpeed:function() {
		xTime = new Date().getTime();
	
		if (xLastTime != 0) {
			xKeys++;
			xTotal += xTime - xLastTime;
			lastInput = typtest.getContentEditableText($('div#user_input')).replace(/\\n/g,"\n");
			xWords = typtest.trim(lastInput).split(/\s+/).length+1;
			//xWords = typtest.trim($('div#user_input').text()).split(/[\s|<br>]+/).length+1;
			
			//wordPos = xWords + 1;
			//$('div#debug').prepend(xTime+':>'+xLastTime+' - '+ (xTotal / 60)+'< <br/>');
			//$('div#debug').prepend(xWords+':>'+typtest.trim($('div#user_input').val()).split(/[\s|\r\n]+/).join(" ")+'< <br/>');
			/*$('div#debug').prepend("."+typtest.getContentEditableText($('div#user_input'))+'.:'+xWords+
						' ->'+typtest.trim(lastInput)+'<- <br/>');*/
			//$("div#container").wrapWord(xWords, 'content.');

			gWPM = Math.round( (xKeys / 5) / (xTotal / 1000 / 60), 2);
			var netwpm = Math.round( gWPM - (errNum / (xTotal / 1000 / 60)), 2);
			$('#WPM').html(gWPM);
			$('#NPM').html(netwpm);
		}
	
		xLastTime = xTime;
	},
	
	trim:function (str) {
    return str.replace(/^\s+|\s+$/g,'').replace(/ +(?= )/g,'');
	},
	
	setEndOfContenteditable:function (contentEditableElement){
		var range,selection;
		if(document.createRange)//Firefox, Chrome, Opera, Safari, IE 9+
		{
			range = document.createRange();//Create a range (a range is a like the selection but invisible)
			range.selectNodeContents(contentEditableElement);//Select the entire contents of the element with the range
			range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
			selection = window.getSelection();//get the selection object (allows you to change selection)
			selection.removeAllRanges();//remove any selections already made
			selection.addRange(range);//make the range you have just created the visible selection
		}
		else if(document.selection)//IE 8 and lower
		{ 
			range = document.body.createTextRange();//Create a range (a range is a like the selection but invisible)
			range.moveToElementText(contentEditableElement);//Select the entire contents of the element with the range
			range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
			range.select();//Select the range (make it the visible selection
		}
	},
	getContentEditableText:function(id) {
		var ce = $("<pre />").html(id.html());

		if ($.browser.webkit)
		  ce.find("div").replaceWith(function() { return "\n" + this.innerHTML; });
		if ($.browser.msie)
		  ce.find("p").replaceWith(function() { return this.innerHTML + "<br>"; });
		if ($.browser.mozilla || $.browser.opera || $.browser.msie) {
		  ce.find("br").replaceWith("\\n");
		  //ce.find("br").replaceWith(function() { return "\n";});
		}
	
		return ce.text();
	},
	setLastWord:function(lword) {
		
		typtest.lastWord = lword;
		//$('div#debug').prepend('last:'+typtest.lastWord+'<br/>');
	},
	get_xKeys:function() { return xKeys;},
	get_gWPM:function() { return gWPM;},
	get_Error:function() { return errNum;},
	get_xWords:function(){ return xWords;},
	typing_finish:function() {
		clearInterval(interval);
        var gwpm = typtest.get_gWPM();
        var gerror = typtest.get_Error();
		var tmins = $('input[name=duration]').val()
        var netwpm = Math.round( gwpm - (gerror / tmins), 2);
		var keystrokes = typtest.get_xKeys();
		
		var typedword = typtest.get_xWords();
		var accuracy = Math.round( ( (typedword-gerror) / typedword ) * 100, 2 );
		//var accuracy = Math.round( (keystrokes/total_chars) * 100, 2 );
        $('div#resultdiv').show();
        $('td#keystrokes').text( keystrokes );
        $('td#gross_speed').text( gwpm+ ' wpm');
        $('td#total_errors').text( gerror+' words');
        $('td#net_speed').text( netwpm+' wpm');
		$('td#accuracy').text( accuracy+'%');
		$('input#correct').val(typedword);
	},
	get_userText:function() {
		user_text = typtest.getContentEditableText($('div#user_input')).replace(/\\n/g,"\n");
		lastInput = typtest.trim(user_text).split(/\s+/);
		return lastInput;
	}

}
})();

$.fn.wrapWord = function (numWords) {//, reStr) {
	//$('div#debug').prepend(numWords+'<br/>');
	nodesCnt = 0;
	prevCnt = 0;
	allWords = '';
	defaultTagName = "span";
	hClass = "highlight";
	nodeArr = undefined;
	//re = new RegExp( "(" + reStr + ")", "ig" );
	//re = new RegExp( "\\b(" + reStr + ")\\b" );
	foundWord = false;
	this.each( function() {
		// select all contents of this element
		$( this ).find( "*" ).andSelf().contents()
	
		// filter to only text nodes that aren't already highlighted
		.filter( function () {
			return (this.nodeType === 3) && $( this ).closest( "." + hClass ).length === 0;
		})
		
	
		// loop through each text node
		.each( function () {
			var output;
			
			if(this.nodeValue != null) this.nodeValue = this.nodeValue.trim();
			
			if( this.nodeValue != "" && this.nodeValue !== null) {
				allWords = allWords + ' ' +this.nodeValue;
				
				//var lastInput = typtest.get_userText();
				//numWords = lastInput.length == 1 ? lastInput.length : lastInput.length+1;
				//last = typtest.trim(allWords).split(/[\s,]+/, numWords);
				last = typtest.trim(allWords).split(/[\s]+/, numWords);
			
				nodeArr = this.nodeValue.split(/\s+/);
				nodesCnt += nodeArr.length;
				//$('div#debug').prepend(this.nodeValue+'<br/>');
				/*$('div#debug').prepend('< '+last.length+' = '+last[last.length-1]+
								   '= count:'+prevCnt+'-'+nodesCnt+' : '+typtest.get_xWords()+
								   ' .. node:'+this.nodeValue+'<br/>');*/
			}
			
			lastWord = last[last.length-1];
			typtest.setLastWord(lastWord);
			//$('div#debug').prepend("rep:"+"\\b(" + lastWord + ")"+'<br/>');
			
			if( lastWord.indexOf('(') > -1 || lastWord.indexOf(')') > -1) {
				lastWord = lastWord.replace("(","\\(").replace(")","\\)");
				re = new RegExp( "\\b( " + lastWord + ")" );
			}
			else re = new RegExp( "\\b(" + lastWord + ")" );
			
			
			
			//if(this.nodeValue)
			//$('div#debug').prepend('words: '+lastWord+'< nodevalue: >'+this.nodeValue+'< <br/>');
			
			
			if( numWords > prevCnt && numWords <= nodesCnt ) {
			//if( xWords >= prevCnt && xWords <= nodesCnt ) {
				//$('div#debug').append('>> '+this.nodeValue+' - '+!foundWord+'<br/>');
				/*output = this.nodeValue
				.replace( re, "<" + defaultTagName + " class='currentword'>$1</" + defaultTagName +">" );*/
				
				nodeArr = this.nodeValue.split(/[\s]+/, numWords - prevCnt);
				
				str = nodeArr.join(' ');
				
				// highlight the current word
				nodeArr[nodeArr.length-1] = "<" + defaultTagName + " class='currentword'>"+nodeArr[nodeArr.length-1] +"</"+ defaultTagName +">";
				
				output = nodeArr.join(' ') + this.nodeValue.split( str )[1];
				
				
				/*$('div#debug').prepend(this.nodeValue+'< '+last.length+' = '+lastWord+
								   '= count:'+prevCnt+'-'+nodesCnt+
								   ' .. node:'+output+'<br/>');*/
			//}
			
				if ( output !== this.nodeValue ) {
					$( this ).wrap( "<p></p>" ).parent()
					.html( output ).contents().unwrap();
					foundWord = true;
				}
			}
			
			prevCnt = nodesCnt;
		});
		foundWord = false;
	});	

};
