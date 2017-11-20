// JavaScript Document
var items = getElementsByTagAndClassName('span', 'faq', parent=document);
for (var item in items){
	connect(items[item], 'onclick', ShowFAQsAnswer);
}

function ShowFAQsAnswer(e){
    var id = getNodeAttribute(e.src(), 'id');
	toggle(id+"_div");
}