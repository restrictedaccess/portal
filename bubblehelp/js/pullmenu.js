// javascript-array.com

var timeout	= 500;
var closetimer	= 0;
var ddmenuitem	= 0;

//var adminsu = false;

// open hidden layer
function mopen(id)
{	
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';
	//alert(ddmenuitem.style.visibility+' '+id);

}
// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

// close layer when click-out
document.onclick = mclose;

function showContextMenu(el, su) {
	
	var url = el.href.replace(/[\'|\s\%|27]/gm, '');
	var elhref = url.replace(/[\=|\.|\?|\&|\,|\'|\s|\-]/gm, '');
	var el_arr = elhref.split('/');
	var iden = el_arr[el_arr.length-1] ? el_arr[el_arr.length-1] : el_arr[el_arr.length-2]
	var last_char = iden.charAt(iden.length-1);
	
	if( last_char == '#' ) iden = last_char +  el.innerHTML.replace(/[\=|\.|\?|\&|\,|\'|\s|\-]/gm, '');
	
	//appendChildNodes(el, UL({'class':'sddm'}, "test", "123",")"));
	//appendChildNodes(el, UL({'class':'sddm'}, DIV({'id':'m12', 'onmouseover':''},'() '),DIV({'class':'author'}, msg.author, ':'), msg.message));
	
	var m_ul  = document.createElement("ul"),
	 m_li  = document.createElement("li"),
    m_div = document.createElement("div"),
    m_link1 = document.createElement("a");
	
	m_ul.setAttribute('class', 'sddm');
	
	m_div.setAttribute('id', iden);
	m_div.onmouseover = function(){mcancelclosetime()};
	m_div.onmouseout = function(){mclosetime()};
	
	m_link1.href = 'javascript:void(0);';
	m_link1.setAttribute('class', 'menu');
	m_link1.appendChild(document.createTextNode('Open this link'));
	m_link1.onclick = function(){
		var urlpath = el.href.split('portal/');
		var filepath = urlpath[ urlpath.length - 1];
		var splitURL = filepath.split('target=');

		if(splitURL.length > 1 && (splitURL[1] == "'_blank'" || splitURL[1] == "%27_blank%27") ) {
			var w = window.open('/portal/'+splitURL[0].replace(/(%27)+/gm, ''), '_new');
			w.focus();
			return false;
		}
		location.href = '/portal/view_bh.php?view='+filepath.replace(/[\']/gm, '');

		//.replace(/[\'|%27]/gm, '').replace(/0/gm, ' ').replace(/\&/gm,'_amp_');
		// get the data from database
		// if data exists set $('item').value='update' else 'new'
		
		
		//$('blink').innerHTML = url;
		
	}
	
	m_div.appendChild(m_link1);
	
	/*if( su ) {
		m_link2 = document.createElement("a");
		
		m_link2.href = "javascript:void(0);";
		m_link2.setAttribute('class', 'menu');
		m_link2.appendChild(document.createTextNode('Edit Help'));
		m_link2.onclick = function(){
			$('task-status').style.display = 'none';
			// get the data from database
			// if data exists set $('item').value='update' else 'new'
			bubbletip.fetch_data(iden, function(resp){
					if(resp == false) {
						$('help_content').value = '';
						$('item').value = 'new';
					} else {
						$('help_content').value=resp;
						$('item').value = 'update';
					}
				}
			);
			
			$('blink').innerHTML = url;
			$('link_id').value = iden;
			//$('help_content').value = '';
			//appendChildNodes(to_msgbox, DIV({'class':'message'}, SPAN({'class':'time'},'(',msg.timestamp, ') '),DIV({'class':'author'}, msg.author, ':'), msg.message));
			$('boxdiv').style.display = 'block';
		}
		m_div.appendChild(m_link2);
		
	}*/

		
	m_li.appendChild(m_div);
	m_ul.appendChild(m_li);
	
	if (el.nextSibling) {
		el.parentNode.insertBefore(m_ul, el.nextSibling);
	} else {
		el.parentNode.appendChild(m_ul);
	}

	//alert(bubbletip.adminsu);
	if( bubbletip.adminsu == false ) {
		bubbletip.check_admin(m_div, url, iden);
	} else {
		bubbletip.edit_help(m_div, url, iden);
	}
	
	
	mopen(iden);
	
	/*<ul class="sddm">
		<div id="m6" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
		  <a href='#' class='menu'>Go to the link</a>
		  <a href='#' class='menu'>Edit Help</a>
		</div>
  </li>
  </ul>*/
}



