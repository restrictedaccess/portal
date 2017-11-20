// JavaScript Document
/* modified - mike 2010-01-12 */

/* Credit: www.jtricks.com
  * www.jtricks.com/javascript/window/box.html
*/

// Shows a box if it wasn't shown yet or is hidden
// or hides it if it is currently shown
function toggle_box(an, width, height, borderStyle, text_header)
{
	var href = an.href;
	var hrefid = an.href.split('=');
	hrefid = 'id'+hrefid[1];

    var boxdiv = window.parent.document.getElementById(hrefid);
	//var boxdiv = window.parent.document.getElementById(href);

    if (boxdiv != null)
    { 
        if (boxdiv.style.display=='none')
        {
            // Show existing box, move it
            // if document changed layout
            //-------move_box(an, boxdiv, cleft, ctop);
            boxdiv.style.display='block';
			//alert('you are inside if block');
            bringToFront(boxdiv);

            // Workaround for Konqueror/Safari
            //if (!boxdiv.contents.contentWindow)
            //    boxdiv.contents.src = href;
			if (boxdiv.contents.contentWindow){
				boxdiv.contents.contentWindow.document.location.replace(href); }
			else {
				boxdiv.contents.src = href; }
        }
        else
            // Hide currently shown box.
            boxdiv.style.display='none';
        return false;
    }

    // Create box object through DOM
    //boxdiv = document.createElement('div');
	boxdiv = parent.window.document.createElement('div');
	
    // Assign id equalling to the document it will show
    //boxdiv.setAttribute('id', href);
	boxdiv.id = hrefid;
	
	var marginleft = (width/2) * -1;
	var margintop = (height/2) * -1;

	//boxdiv.setAttribute('style', boxdiv.getAttribute('style') + "; float:left; ");
	//alert(boxdiv.style.styleFloat);
    boxdiv.style.display = 'block';
    boxdiv.style.position = 'fixed';
    boxdiv.style.width = width + 'px';
    boxdiv.style.height = height + 'px';
    boxdiv.style.border = borderStyle;
    boxdiv.style.textAlign = 'right';
    boxdiv.style.padding = '4px';
    boxdiv.style.background = '#FFFFFF';
	boxdiv.style.marginLeft = marginleft + 'px';
	//boxdiv.style.marginTop = margintop + 'px';
	boxdiv.style.top = '0';
	boxdiv.style.left = '50%';
	
	bringToFront(boxdiv);
    
	//parent.window.document.body.appendChild(boxdiv);
	//alert(parent.window.document.body.id+' -testing123');
	parent.window.document.body.appendChild(boxdiv);
	
    var offset = 0;
	
	var div_top = parent.window.document.createElement('div');
	div_top.style.width = '100%';
	div_top.style.padding = '2px 2px 2px 5px';
	div_top.style.background = '#aaaaee';
	div_top.style.styleFloat = 'left';
	
	boxdiv.appendChild(div_top);
	
	var div_txt = parent.window.document.createElement('div');
	div_txt.style.styleFloat = 'left';
	div_txt.style.cssFloat = 'left';
	div_txt.style.fontWeight = 'bold';
	div_txt.style.fontSize = '12px';
	div_txt.appendChild(document.createTextNode(text_header));
	
	div_top.appendChild(div_txt);
	

    // Remove the following code if 'Close' hyperlink
    // is not needed.
    var close_href = parent.window.document.createElement('a');
	close_href.setAttribute('id', 'close_link');
    close_href.href = 'javascript:void(0);';
	close_href.style.styleFloat = 'right';
    close_href.onclick = function()
        { toggle_box(an, width, height, borderStyle); }
    close_href.appendChild(document.createTextNode('Close'));
	//close_href.innerHTML = 'Close';
    div_top.appendChild(close_href);
	
    offset = div_top.offsetHeight;
    // End of 'Close' hyperlink code.
	

	

    var contents = parent.window.document.createElement('iframe');
	contents.id = 'content_iframe';
    contents.scrolling = 'auto';
    contents.overflowX = 'hidden';
    contents.overflowY = 'scroll';
    contents.frameBorder = '0';
    contents.style.width = width + 'px';
    contents.style.height = (height - offset) + 'px';
    boxdiv.contents = contents;


    boxdiv.appendChild(contents);
    //-------move_box(an, boxdiv, cleft, ctop);
//return false;
	
    if (contents.contentWindow){
        contents.contentWindow.document.location.replace(href); }
    else {
        contents.src = href; }

    // The script has successfully shown the box,
    // prevent hyperlink navigation.
    return false;
}

function getAbsoluteDivs()
{
    var arr = new Array();
    var all_divs = parent.window.document.body.getElementsByTagName("DIV");
    var j = 0;

    for (i = 0; i < all_divs.length; i++)
        if (all_divs.item(i).style.position=='absolute')
        {
            arr[j] = all_divs.item(i);
            j++;
        }

    return arr;
}

function bringToFront(obj)
{
    if (!parent.window.document.getElementsByTagName)
        return;

    var divs = getAbsoluteDivs();
    var max_index = 0;
    var cur_index;

    // Compute the maximal z-index of
    // other absolute-positioned divs
    for (i = 0; i < divs.length; i++)
    {
        var item = divs[i];
        if (item == obj ||
            item.style.zIndex == '')
            continue;

        cur_index = parseInt(item.style.zIndex);
        if (max_index < cur_index)
        {
            max_index = cur_index;
        }
    }

    obj.style.zIndex = max_index + 1;
}


