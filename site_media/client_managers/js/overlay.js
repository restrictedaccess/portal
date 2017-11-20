var y1 = 0;   // change the # on the left to adjuct the Y co-ordinate
(document.getElementById) ? dom = true : dom = false;

function placeIt() {
  if (dom && !document.all) {document.getElementById("overlay").style.top = window.pageYOffset + (window.innerHeight - (window.innerHeight-y1)) + "px";}
  if (document.all) {document.all["overlay"].style.top = document.documentElement.scrollTop + (document.documentElement.clientHeight - (document.documentElement.clientHeight-y1)) + "px";}
  window.setTimeout("placeIt()", 10); }
