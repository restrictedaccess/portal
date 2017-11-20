<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->
<!-- Original:  Patrick Lewis (gtrwiz@aol.com) -->
<!-- Web Site:  http://www.patricklewis.net -->
<!-- Begin
//   ##############  SIMPLE  BROWSER SNIFFER
if (document.layers) {navigator.family = "nn4"}
if (document.all) {navigator.family = "ie4"}
if (window.navigator.userAgent.toLowerCase().match("gecko")) {navigator.family = "gecko"}

//  #########  popup text
descarray = new Array(
"This site has some of the greatest scripts around!",
"These popups can have varying width. It is dependant upon the text message.",
"You can have <b>two</b> lines <br>and HTML content.",
"You can also have images in here like this:<br><img src=greenbar.gif>",
"You can put in a really long <br>description if it is nessary to <br>explain something in detail, <br>like a warning about content <br>or privacy.",
"</center>Lastly, you can have links like these:<br><a href='http://javascript.internet.com/'>JavaScript Source</a><br><a href='http://javascript.internet.com/'>JavaScript Source</a><br><a href='http://javascript.internet.com/'>JavaScript Source</a><br>With a change in the onmouseout event handler."
);

overdiv="0";
//  #########  CREATES POP UP BOXES
function poplayer(adid, totalimages, ctr, filepath){

  if (navigator.family == "gecko") {
    pad="0"; bord="1 bordercolor=black";
  }
  else {
    pad="1"; bord="0";
  }

  desc = "<img src='uploadedimages/"+filepath+"'>";

  varname = ctr+1;
  $('popupdesc'+adid).innerHTML=desc;
  $('popupdesc'+adid).style.display='block';

  for(i=0; i<totalimages; i++) {
    if(i%2 == 0)
      $('imgcol'+adid+'-'+i).style.backgroundColor='#32A0DB';
    else
      $('imgcol'+adid+'-'+i).style.backgroundColor='#8EE1E4';

    $('imgcol'+adid+'-'+i).style.fontStyle='normal';
    $('imgcol'+adid+'-'+i).style.textDecoration='underline';
  }

  $('imgcol'+adid+'-'+ctr).style.backgroundColor='#FFF66B';
  $('imgcol'+adid+'-'+ctr).style.fontStyle='italic';
  $('imgcol'+adid+'-'+ctr).style.textDecoration='none';


  //$('imgcol'+adid+'-'+ctr).style.font-style='normal';
  //$('hideimage'+adid).style.display='inline';
  //$('showimage'+adid).style.display='none';

  /*
  if(navigator.family =="nn4") {
    document.popupdesc.document.write(desc);
    document.object1.document.close();
    document.object1.left=x+15;
    document.object1.top=y-5;
  }
  else if(navigator.family =="ie4"){
    object1.innerHTML=desc;
    object1.style.pixelLeft=x+15;
    object1.style.pixelTop=y-5;
  }
  else if(navigator.family =="gecko"){

  //alert(y)
    document.getElementById("object1").innerHTML=y+"----"+desc;
    document.getElementById("object1").style.left=x+15;
    document.getElementById("object1").style.top=(y-50)+"px";

    //alert(document.getElementById("object1").style.top)
    //document.getElementById("object1").style.top="700px";
  }
  */
}

function hidelayer(adid){

  $('popupdesc'+adid).style.display='none';
  $('hideimage'+adid).style.display='none';
  //$('showimage'+adid).style.display='block';

  /*
  if (overdiv == "0") {
    if(navigator.family =="nn4") {
      eval(document.object1.top="-500");
    }
    else if(navigator.family =="ie4") {
      object1.innerHTML="";
    }
    else if(navigator.family =="gecko") {
      //includes mozila firefox
      //document.getElementById("object1").style.top="-500px";
      document.getElementById("object1").innerHTML="";
    }
  }
  */
}

//  ########  TRACKS MOUSE POSITION FOR POPUP PLACEMENT
var isNav = (navigator.appName.indexOf("Netscape") !=-1);

function handlerMM(e){
  x = (isNav) ? e.pageX : event.clientX + document.body.scrollLeft;
  y = (isNav) ? e.pageY : event.clientY + document.body.scrollTop;
}

if (isNav){ document.captureEvents(Event.MOUSEMOVE); }
document.onmousemove = handlerMM;
