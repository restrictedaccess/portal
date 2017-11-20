var bubbletip=function(){
	var id = 'bt';
	var offsetfromcursorX=12;
	var offsetfromcursorY=10 ;

	var offsetdivfrompointerX=10;
	var offsetdivfrompointerY=14;
	
	var top = 23;
	var left = 3;
	var maxw = 400;
	var speed = 10;
	var timer = 20;
	var endalpha = 95;
	var alpha = 0;
	var bt,t,c,b,h;
	var ie = document.all ? true : false;
	var ns6 = document.getElementById && !document.all
	var ff = /Firefox/i.test(navigator.userAgent);
	var ctr = 0;
	var task_status = document.getElementById('task-status');
	var boxdiv = document.getElementById('boxdiv');
	
	return{
		show:function(v,w){
			if(bt == null){
				bt = document.createElement('div');
				bt.setAttribute('id',id);
				t = document.createElement('div');
				t.setAttribute('id',id + 'top');
				c = document.createElement('div');
				c.setAttribute('id',id + 'cont');
				b = document.createElement('div');
				b.setAttribute('id',id + 'bot');
				bt.appendChild(t);
				bt.appendChild(c);
				bt.appendChild(b);
				document.body.appendChild(bt);
				bt.style.opacity = 0;
				bt.style.filter = 'alpha(opacity=0)';
				document.onclick = this.pos; //function(e){bubbletip.pos2(v, e);}
			}
			//alert(document.documentElement.scrollWidth);//>div.clientWidth

			bt.style.display = 'block';
			bt.style.zIndex = '999999';
			//c.innerHTML = v;
			//var url = el.href.replace(/[\'|\s\%|27]/gm, '');
			//var elhref = url.replace(/[\=|\.|\?|\&|\,|\'|\s|\-]/gm, '');
			href = v.href.replace(/[\=|\.|\?|\&|\%|\,|\'|\s|\-|27]/gm, '');
			var el_arr = href.split('/');
			var iden = el_arr[el_arr.length-1] ? el_arr[el_arr.length-1] : el_arr[el_arr.length-2];
			
			var last_char = iden.charAt(iden.length-1);
			if( last_char == '#' ) {
				iden = last_char + v.innerHTML.replace(/[\=|\.|\?|\&|\,|\'|\s|\-]/gm, '');
			}
			c.innerHTML='Loading...';
			
			this.fetch_data(iden, function(resp){c.innerHTML='<pre>'+resp+'</pre>';});
			
			bt.style.width = w ? w + 'px' : 'auto';
			if(!w && ie){
				t.style.display = 'none';
				b.style.display = 'none';
				bt.style.width = bt.offsetWidth;
				t.style.display = 'block';
				b.style.display = 'block';
			}
			//alert(bt.offsetWidth+' - '+bt.style.left);
			if(bt.offsetWidth > maxw){bt.style.width = maxw + 'px'}
			
			//var winwidth=ie&&!window.opera? ietruebody().clientWidth : window.innerWidth-20;
			//var winheight=ie&&!window.opera? ietruebody().clientHeight : window.innerHeight-20;
			
			//var rightedge=ie&&!window.opera? winwidth-event.clientX-offsetfromcursorX : winwidth-e.clientX-offsetfromcursorX;
			//var bottomedge=ie&&!window.opera? winheight-event.clientY-offsetfromcursorY : winheight-e.clientY-offsetfromcursorY;
				
			//var leftedge=(offsetfromcursorX<0)? offsetfromcursorX*(-1) : -1000;
			
			
			
			h = parseInt(bt.offsetHeight) + top;
			clearInterval(bt.timer);
			bt.timer = setInterval(function(){bubbletip.fade(1)},timer);
			return false;
		},
		pos:function(e){
			var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
			var l = ie ? event.clientX + document.documentElement.scrollLeft : e.pageX;
			bt.style.top = (u - h) + 'px';
			bt.style.left = (l + left) + 'px';
		},
		fade:function(d){
			var a = alpha;
			if((a != endalpha && d == 1) || (a != 0 && d == -1)){
				var i = speed;
				if(endalpha - a < speed && d == 1){
					i = endalpha - a;
				}else if(alpha < speed && d == -1){
					i = a;
				}
				alpha = a + (i * d);
				bt.style.opacity = alpha * .01;
				bt.style.filter = 'alpha(opacity=' + alpha + ')';
			}else{
				clearInterval(bt.timer);
				if(d == -1){bt.style.display = 'none'}
			}
		},
		hide:function(){
			if( bt != null ) {
				clearInterval(bt.timer);
				bt.timer = setInterval(function(){bubbletip.fade(-1)},timer);
			}
		},
		pos2:function(v,e){
			
			var nondefaultpos=false;
			var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
			var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
			//Find out how close the mouse is to the corner of the window
			var winwidth=ie&&!window.opera? ietruebody().clientWidth : window.innerWidth-20;
			var winheight=ie&&!window.opera? ietruebody().clientHeight : window.innerHeight-20;

			var rightedge=ie&&!window.opera? winwidth-event.clientX-offsetfromcursorX : winwidth-e.clientX-offsetfromcursorX;
			var bottomedge=ie&&!window.opera? winheight-event.clientY-offsetfromcursorY : winheight-e.clientY-offsetfromcursorY;
				
			var leftedge=(offsetfromcursorX<0)? offsetfromcursorX*(-1) : -1000;
			//alert(rightedge+' < '+bt.offsetWidth+' = '+curX);
			//if the horizontal distance isn't enough to accomodate the width of the context menu
			if (rightedge<bt.offsetWidth){
				//move the horizontal position of the menu to the left by it's width
				bt.style.left = (curX-bt.offsetWidth-10)+"px";
				nondefaultpos=true;
			}
			else if (curX<leftedge) {
				bt.style.left="5px";
			} else{
				//position the horizontal position of the menu where the mouse is positioned
				bt.style.left=curX + offsetfromcursorX - (offsetdivfrompointerX ) +"px";
				//pointerobj.style.left=curX+offsetfromcursorX+"px";
			}
			

			//same concept with the vertical position
			/*if (bottomedge<tipobj.offsetHeight){
				tipobj.style.top=curY-tipobj.offsetHeight-offsetfromcursorY+"px"
				nondefaultpos=true
			}else{
				tipobj.style.top=curY+offsetfromcursorY+offsetdivfrompointerY+"px"
				pointerobj.style.top=curY+offsetfromcursorY+"px"
			}
			
			tipobj.style.visibility="visible"
			if (!nondefaultpos)
				pointerobj.style.visibility="visible"
			else
				pointerobj.style.visibility="hidden"
			*/
			
			
			var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
			


			bt.style.top = (u - h) + 'px';

		},
		
		
		postJSON:function(url, postVars, statmsg) {
			var req = getXMLHttpRequest();
			if (statmsg && task_status) {
				if(task_status.style != undefined) task_status.style.display = 'block';
				replaceChildNodes( task_status, SPAN( null, statmsg));
			}
		
			req.open("POST", url, true);

			req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			//req.setRequestHeader("Cache-Control", "no-store, no-cache");
	
			var data = queryString(postVars);
			//cache clearing
			var now = "upid=" + new Date().getTime();
			data += "&" + now;
			var d = sendXMLHttpRequest(req, data);

			return d; //.addCallback(evalJSONRequest);
		},

		fetchFailed:function (err) {
			//replaceChildNodes( "chat-status", SPAN( null, "Data could not be fetched."));
			c.innerHTML = "Data could not be fetched.";
			//replaceChildNodes( "chat-status", SPAN( null, err.message));
		},
		
		fetch_data:function(idlink, bfunc) {
			response = bubbletip.postJSON('/portal/bubblehelp/bhelp.php?/fetch_data/', {'href':idlink }, 'Loading...');
			response.addCallback(function(resp) {
				resp = evalJSONRequest(resp);

				setTimeout(function(){
					var task_status = document.getElementById('task-status');
					task_status.style.display='none';
				}, 1000);
				
				bfunc(resp.result);
				var dimen = getElementDimensions('bt');
				
				var bt_left = parseInt(bt.style.left);
				
				var _firefox = /Firefox/i.test(navigator.userAgent);
				if(ff) {
					var diff_offset = parseInt(document.documentElement.scrollWidth) - bt_left;	
				} else {
					var diff_offset = parseInt(document.body.scrollWidth) - bt_left;
				}
				
				if( diff_offset == dimen.w ) {
					//alert(diff_offset);
					bt.style.left = (bt_left - (dimen.w + 3) )+"px";
				}
				
			});
		},
		
		check_admin:function(m_div, url, iden) {
			response = bubbletip.postJSON('/portal/bubblehelp/bhelp.php?/admin_get/', {}, '');
			response.addCallback(function(resp) {
				resp = evalJSONRequest(resp);
				
				
				if( resp.result != false ) {
					bubbletip.adminsu = true;
					
					bubbletip.edit_help(m_div, url, iden);
				}
			
				//alert(document.documentElement.scrollWidth+':'+bt.style.left+' < '+bt.offsetWidth+' = '+dimen.w);
				//alert(document.documentElement.scrollWidth);//>div.clientWidth
				//alert(bt.offsetWidth);
				//setTimeout("$(task_status).style.display='none';",1000);
			});
		},
		
		edit_help: function(m_div, url, iden) {
			//alert('edit');
			m_link2 = document.createElement("a");
			
			m_link2.href = "javascript:void(0);";
			m_link2.setAttribute('class', 'menu');
			m_link2.appendChild(document.createTextNode('Edit Help'));
			m_link2.onclick = function(){
				if(task_status) task_status.style.display = 'none';
				// get the data from database
				// if data exists set $('item').value='update' else 'new'
				bubbletip.fetch_data(iden, function(resp){
					var help_content = document.getElementById('help_content');
					var item = document.getElementById('item');
					if(resp == false) {	
						help_content.value = '';
						item.value = 'new';
					} else {
						help_content.value=resp;
						item.value = 'update';
					}
				});
				var blink = document.getElementById('blink');
				var link_id = document.getElementById('link_id');;
				blink.innerHTML = url;
				link_id.value = iden;
				//$('help_content').value = '';
				//appendChildNodes(to_msgbox, DIV({'class':'message'}, SPAN({'class':'time'},'(',msg.timestamp, ') '),DIV({'class':'author'}, msg.author, ':'), msg.message));
				boxdiv.style.display = 'block';
			}
			
			m_div.appendChild(m_link2);
			
			return m_div;
		},
		
		createResult: function(error_message) {
			if(error_message) {
				task_status.style.display = 'block';
				task_status.innerHTML = '';
				task_status.innerHTML = error_message;
			} else boxdiv.style.display='none';
			
		},
		
		redirectLogin: function(url) {
			location.href = url;
		},
		
		adminsu : false
	};
}();