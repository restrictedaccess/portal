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
	
	var menubr = document.getElementById('sddm');

	// close old layer
	if(ddmenuitem) {
		menubr.style.display = 'none';
		ddmenuitem.style.visibility = 'hidden';
	}

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';
	menubr.style.display = (menubr.style.display=='block') ? 'none' : 'block';
	//alert(ddmenuitem.style.visibility+' '+id);

}
// close showed layer
function mclose()
{
	if(ddmenuitem) {
		var menubr = document.getElementById('sddm');
		menubr.style.display = 'none';
		ddmenuitem.style.visibility = 'hidden';
	}
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

function showReportMenu(el, pos, pos_val) {
	pos = (typeof pos !== 'undefined') ? pos : 'right';
	pos_val = (typeof pos_val !== 'undefined') ? pos_val : 90;
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
	
	m_ul.setAttribute('id', 'sddm');
	m_ul.style.position = 'absolute';
	
	m_ul.style[pos] = pos_val+'px';
	//float:right;margin-right:100px;
	
	m_div.setAttribute('id', iden);
	m_div.onmouseover = function(){mcancelclosetime()};
	m_div.onmouseout = function(){mclosetime()};
	
	m_link1.href = 'javascript:void(0);';
	m_link1.setAttribute('class', 'menu');
	m_link1.appendChild(document.createTextNode('Report a Bug'));
	m_link1.onclick = function(){
		mclose();
		popup_win7('/portal/bugreport/index.php?/reportform/popup',950,600);
	}
	
	m_div.appendChild(m_link1);
	m_li.appendChild(m_div);
	m_ul.appendChild(m_li);
	
	if (el.nextSibling) {
		el.parentNode.insertBefore(m_ul, el.nextSibling);
	} else {
		el.parentNode.appendChild(m_ul);
	}

	m_link2 = document.createElement("a");
			
	m_link2.href = "javascript:void(0);";
	m_link2.setAttribute('class', 'menu');
	m_link2.appendChild(document.createTextNode('My Bug Report'));
	m_link2.onclick = function(){
		mclose();
		popup_win7('/portal/bugreport/?/view_myreport',950,600);
	}
			
	m_div.appendChild(m_link2);
	
	
	mopen(iden);
	
	/*<ul class="sddm">
		<div id="m6" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
		  <a href='#' class='menu'>Go to the link</a>
		  <a href='#' class='menu'>Edit Help</a>
		</div>
  </li>
  </ul>*/
}



