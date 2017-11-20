// JavaScript Document
/* modified - mike 2010-01-12 */

/* Credit: www.jtricks.com
  * www.jtricks.com/javascript/window/box.html
*/
// Moves the box object to be directly beneath an object.
function move_box(an, box, cleft, ctop)
{
	
	var width = 600;
    var height = 470;
	var x,y;
	if (self.innerHeight) // all except Explorer
	{
		x = self.innerWidth;
		y = self.innerHeight;
	}
	else if (document.documentElement && document.documentElement.clientHeight)
		// Explorer 6 Strict Mode
	{
		x = document.documentElement.clientWidth;
		y = document.documentElement.clientHeight;
	}
	else if (document.body) // other Explorers
	{
		x = document.body.clientWidth;
		y = document.body.clientHeight;
	}
	
    var obj = an;


    box.style.left = cleft + 'px';

    ctop += an.offsetHeight + 8;
	

    // Handle Internet Explorer body margins,
    // which affect normal document, but not
    // absolute-positioned stuff.
    if (document.body.currentStyle &&
        document.body.currentStyle['marginTop'])
    {
        ctop += parseInt(
            document.body.currentStyle['marginTop']);
    }

    box.style.top = ctop + 'px';
}

// Shows a box if it wasn't shown yet or is hidden
// or hides it if it is currently shown
function show_hide_box(an, width, height, borderStyle, cleft, ctop)
{
	//if (uri) var an.href = 'http://localhost'+uri;
	var href = an.href;
    var boxdiv = window.parent.document.getElementById(href);

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
	boxdiv.id = href;
	
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
	boxdiv.style.marginTop = margintop + 'px';
	boxdiv.style.top = '50%';
	boxdiv.style.left = '50%';
	
	bringToFront(boxdiv);
    
	//parent.window.document.body.appendChild(boxdiv);
	//alert(parent.window.document.body.id+' -testing123');
	parent.window.document.body.appendChild(boxdiv);
	
    var offset = 0;
	
	var back_href = parent.window.document.createElement('a');
	back_href.id = 'back_link';
	back_href.style.cssFloat = 'left';
    back_href.href = 'javascript:void(0);';
    boxdiv.appendChild(back_href);
    // End of 'Back' hyperlink code.

    // Remove the following code if 'Close' hyperlink
    // is not needed.
    var close_href = parent.window.document.createElement('a');
    close_href.href = 'javascript:void(0);';
    close_href.onclick = function()
        { show_hide_box(an, width, height, borderStyle); }
    close_href.appendChild(document.createTextNode('Close'));
	//close_href.innerHTML = 'Close';
    boxdiv.appendChild(close_href);
	
    offset = close_href.offsetHeight;
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


