/*
var i = parseInt(document.getElementById('to_counter_id').value);
var temp;
function createNewTextBox()
{
	i = i + 1;
	document.getElementById('myDivName').innerHTML = document.getElementById('myDivName').innerHTML + "<input type='text' name='to" + i + "' style='width:50%' class='text' value=''><br />";
	document.getElementById('to_counter_id').value = i;
}
*/




function moreFields(jr_list_id , row) {
	var counter = parseInt(document.getElementById(row).value);	
	counter++;
	
	var newFields = document.getElementById('readroot'+jr_list_id).cloneNode(true);
	newFields.id = '';
	newFields.style.display = 'block';

	elements = newFields.getElementsByTagName("input");
	 for (i = 0; i < elements.length; i++) {
        element = elements.item(i);
        s = null;
        s = element.getAttribute("name");
        if (s == null)
            continue;
        t = s.split("[");
        if (t.length < 2)
            continue;
        s = t[0] + "[" + counter.toString() + "]";
        element.setAttribute("name", s);
        element.value = "";
    }
	
	var insertHere = document.getElementById('writeroot'+jr_list_id);
	insertHere.parentNode.insertBefore(newFields,insertHere);
	document.getElementById(row).value = counter;
}
