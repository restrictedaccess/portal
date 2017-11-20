<!--

// browser detector
function Browser() {
	this.ns6 = (!document.all && document.getElementById)?true:false;
	this.ns4 = (document.layers)?true:false;
	this.ie = (document.all)?true:false;
}

var is = new Browser();

function write_heading(swNested)
{
   addstr = "";
   if (swNested == 1)
   { addstr = "../"; }
   document.write ("<table border='0' width='748' cellpadding='0' cellspacing='0'>");
   document.write ("<tbody>");
   document.write ("<tr>");
   document.write ("<td width='8'>&nbsp;</td>");
   document.write ("<td width='100'>");
   document.write ("<!-- JMCIM LOGO -->");
   document.write ("<a href='"+addstr+"index.php'><img src='"+addstr+"graphics/noborder-logo.gif' alt='JESUS Miracle Crusade International Ministry' border='0' /></a>");
   document.write ("</td>");
   document.write ("<td>&nbsp;</td>");
   document.write ("<td width='375' align='left'>");
   document.write ("<img src='"+addstr+"graphics/header-verse.gif' alt='Matthew 16:18' />");
   document.write ("</td>");
   document.write ("</tr>");
   document.write ("</tbody>");
   document.write ("</table>");
}

function write_menu(menu_id, swNested)
{
   addstr = "";
   if (swNested == 1)
      { addstr = "../"; }

   document.write ("<table border='0' width='748' height='20' bgcolor='#e7e7e7' class='verdana_10' cellpadding='0' cellspacing='0'>");
   document.write ("<tbody>");
   document.write ("<tr>");
   document.write ("<td align='center'>");
   
   if (menu_id == 1)
      {document.write("<strong><a href='"+addstr+"index.php' class='main_menu'>HOME</a></strong> | ");}
   else
      {document.write("<a href='"+addstr+"index.php' class='main_menu'>HOME</a> | ");}
      
   if (menu_id == 2)
      {document.write("<strong><a href='"+addstr+"about/the_JMCIM.htm' class='main_menu'>ABOUT US</a></strong> | ");}
   else
      {document.write("<a href='"+addstr+"about/the_JMCIM.htm' class='main_menu'>ABOUT US</a> | ");}

   if (menu_id == 3)
      {document.write("<strong><a href='"+addstr+"doctrine/doctrine_p1.htm' class='main_menu'>DOCTRINE</a></strong> | ");}
   else
      {document.write("<a href='"+addstr+"doctrine/doctrine_p1.htm' class='main_menu'>DOCTRINE</a> | ");}
      
   if (menu_id == 4)
      {document.write("<strong><a href='"+addstr+"testimonies/living_testimonies_p1.htm' class='main_menu'>TESTIMONIES</a></strong> | ");}
   else
      {document.write("<a href='"+addstr+"testimonies/living_testimonies_p1.htm' class='main_menu'>TESTIMONIES</a> | ");}
      
   // NEW ITEM
   if (menu_id == 9)
         {document.write("<strong><a href='"+addstr+"multimedia/praise_songs.php' class='main_menu'>MULTIMEDIA</a></strong> | ");}
   else
         {document.write("<a href='"+addstr+"multimedia/praise_songs.php' class='main_menu'>MULTIMEDIA</a> | ");}

   if (menu_id == 5)
      {document.write("<strong><a href='"+addstr+"archives/albums.php' class='main_menu'>ARCHIVES</a></strong> | ");}
   else
      {document.write("<a href='"+addstr+"archives/albums.php' class='main_menu'>ARCHIVES</a> | ");}

   if (menu_id == 6)
      {document.write("<strong><a href='"+addstr+"services/phils.php' class='main_menu'>SCHEDULE OF SERVICES</a></strong> | ");}
   else
      {document.write("<a href='"+addstr+"services/phils.php' class='main_menu'>SCHEDULE OF SERVICES</a> | ");}

   if (menu_id == 8)
      {document.write("<strong><a href='javascript:alert(str_alertmsg)' class='main_menu'>GIVING</a></strong> | ");}
   else
      {document.write("<a href='javascript:alert(str_alertmsg)' class='main_menu'>GIVING</a> | ");}

   if (menu_id == 7)
      {document.write("<strong><a href='"+addstr+"contact/phils.php' class='main_menu'>CONTACT US</a></strong>");}
   else
      {document.write("<a href='"+addstr+"contact/phils.php' class='main_menu'>CONTACT US</a>");}


      
   
   
   document.write ("</td>");
   document.write ("</tr>");
   document.write ("</tbody>");
   document.write ("</table>");
}

function write_secondary_menu(menu_id, swNested)
{
   addstr = "";
   str_alertmsg = "Under development."
   if (swNested == 1)
      { addstr = "../"; }

   document.write ("<table border='0' width='748' height='20' bgcolor='#e7e7e7' class='verdana_10' cellpadding='0' cellspacing='0'>");
   document.write ("<tbody>");
   document.write ("<tr>");
   document.write ("<td align='center'>");
   
   if (menu_id == 1)
      {document.write("<strong><a href='"+addstr+"message_boards/message_boards.php' class='main_menu'>MESSAGE BOARDS</a></strong> | ");}
   else
      {document.write("<a href='"+addstr+"message_boards/message_boards.php' class='main_menu'>MESSAGE BOARDS</a> | ");}
      
   if (menu_id == 2)
      {document.write("<strong><a href='"+addstr+"events/events.php' class='main_menu'>EVENTS &amp; ACTIVITIES</a></strong> | ");}
   else
      {document.write("<a href='"+addstr+"events/events.php' class='main_menu'>EVENTS &amp; ACTIVITIES</a> | ");}

   if (menu_id == 3)
      {document.write("<strong><a href='"+addstr+"html/site_index.htm' class='main_menu'>SITE INDEX</a></strong>");}
   else
      {document.write("<a href='"+addstr+"html/site_index.htm' class='main_menu'>SITE INDEX</a>");}
   
   document.write ("</td>");
   document.write ("</tr>");
   document.write ("</tbody>");
   document.write ("</table>");
}

function write_footer(swNested)
{
   addstr = "";
   // swNested == 0 default 
   // swNested == 1 when the calling file is nested, but only by one level/folder
   // swNested == 2 when the calling file is from the main directory (i.e. index.php)
   if (swNested == 1)
   { addstr = "../contact/"; }
   else if (swNested == 2)
   { addstr = "contact/"; }
   
   document.write ("<table border='0' width='748' class='verdana_10_dkgray' bgcolor='#ffffff'>");
   document.write ("<tbody>");
   document.write ("<tr>");
   document.write ("<td align='center'>");
   document.write ("<br />JMCIM.org<br />");
   document.write ("Created for the greater glory of our Lord and Savior, dearest JESUS.<br />");
   document.write ("Send your feedback and inquiries <a href='"+addstr+"send_mail.htm'>here</a>.<br />&nbsp;");
   document.write ("</td>");
   document.write ("</tr>");
   document.write ("</tbody>");
   document.write ("</table>");
}


function nav_about(menu_id)
{
   if (menu_id == 0)
   { document.write("<strong>The JMCIM</strong>"); }
   else
   { document.write("<a href='the_JMCIM.htm' class='sidemenu'>The JMCIM</a>"); }
   
   // START SUBMENU 
   
   document.write("<table border='0' width='150' class='pt_11' cellpadding='0' cellspacing='10'><tbody>");

   document.write("<tr><td>");
      if (menu_id == 1)
      { document.write("<strong>JESUS Miracle Crusade and the JESUS Church</strong>"); }
      else
      { document.write("<a href='the_church.htm' class='sidemenu'>JESUS Miracle Crusade and the JESUS Church</a>"); }
   document.write("</td></tr>");

   document.write("<tr><td>");
      if (menu_id == 2)
      { document.write("<strong>Humble Beginnings</strong>"); }
      else
      { document.write("<a href='humble_beginnings.htm' class='sidemenu'>Humble Beginnings</a>"); }
   document.write("</td></tr>");

   document.write("<tr><td>");
      if (menu_id == 3)
      { document.write("<strong>Price to Pay</strong>"); }
      else
      { document.write("<a href='price_to_pay.htm' class='sidemenu'>Price to Pay</a>"); }
   document.write("</td></tr>");


   document.write("<tr><td>");
      if (menu_id == 4)
      { document.write("<strong>The Scope of the Gospel</strong>"); }
      else
      { document.write("<a href='scope.htm' class='sidemenu'>The Scope of the Gospel</a>"); }
   document.write("</td></tr>");

   document.write("<tr><td>");
      if (menu_id == 5)
      { document.write("<strong>Greater Things in Store for the World</strong>"); }
      else
      { document.write("<a href='greater.htm' class='sidemenu'>Greater Things in Store for the World</a>"); }
   document.write("</td></tr>");

   document.write("<tr><td>");
      if (menu_id == 6)
      { document.write("<strong>Victorious Mindanao Peace Mission Catapults JMCIM to Worldwide Evangelism</strong>"); }
      else
      { document.write("<a href='victorious.htm' class='sidemenu'>Victorious Mindanao Peace Mission Catapults JMCIM to Worldwide Evangelism</a>"); }
   document.write("</td></tr>");

   
   document.write("<tr><td>");
      if (menu_id == 7)
      { document.write("<strong>The Kingdom of GOD</strong>"); }
      else
      { document.write("<a href='kingdom.htm' class='sidemenu'>The Kingdom of GOD</a>"); }
   document.write("</td></tr>");

   document.write("</tbody></table>");
   
   
   // END SUBMENU
   
   document.write("<hr class='ltgray_thin' />");
   
   if (menu_id == 8)
   { document.write("<strong>A Tribute</strong>"); }
   else
   { document.write("<a href='final_tribute.htm' class='sidemenu'>A Tribute</a>"); }
   document.write("<hr class='ltgray_thin' />");

   if (menu_id == 9)
   { document.write("<strong>JMCIM Music Ministry</strong>"); }
   else
   { document.write("<a href='music_ministry.htm' class='sidemenu'>JMCIM Music Ministry</a>"); }
   //document.write("<hr class='ltgray_thin' />");

   //if (menu_id == 10)
   //{ document.write("<strong>DBFI</strong>"); }
   //else
   //{ document.write("<a href='dbfi.htm' class='sidemenu'>DBFI</a>"); }
}


function nav_archives(menu_id, swNested)
{
   var addstr = "";
   if (swNested == 1) { addstr = "../archives/";}

   if (menu_id == 1) 
   { document.write("<a href='"+addstr+"albums.php' class='sidemenu'><strong>Praise & Worship Albums</strong></a>"); }
   else
   { document.write("<a href='"+addstr+"albums.php' class='sidemenu'>Praise & Worship Albums</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 2) 
   { document.write("<a href='"+addstr+"news.php' class='sidemenu'><strong>News</strong></a>"); }
   else
   { document.write("<a href='"+addstr+"news.php' class='sidemenu'>News</a>"); }

}

function nav_talipao(menu_id, swNested)
{
   var addstr = "";
   if (swNested == 1) { addstr = "../news/";}

   if (menu_id == 0)
   { document.write("<strong>Main</strong>"); }
   else
   { document.write("<a href='"+addstr+"talipao_p0.htm' class='sidemenu'>Main</a>"); }
   document.write("<hr class='ltgray_thin' />");   


   if (menu_id == 1)
   { document.write("<strong>Year 2000 Mindanao Crisis Heightens</strong>"); }
   else
   { document.write("<a href='"+addstr+"talipao_p1.htm' class='sidemenu'>Year 2000 Mindanao Crisis Heightens</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 2)
   { document.write("<strong>Sipadan Hostage Crisis Rocks The World</strong>"); }
   else
   { document.write("<a href='"+addstr+"talipao_p2.htm' class='sidemenu'>Sipadan Hostage Crisis Rocks The World</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 3)
   { document.write("<strong>Evangelist Wilde Almeda Offers to Rescue Sipadan Hostages</strong>"); }
   else
   { document.write("<a href='"+addstr+"talipao_p3.htm' class='sidemenu'>Evangelist Wilde Almeda Offers to Rescue Sipadan Hostages</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 4)
   { document.write("<strong>Evangelist Wilde Almeda Goes to Sulu</strong>"); }
   else
   { document.write("<a href='"+addstr+"talipao_p4.htm' class='sidemenu'>Evangelist Wilde Almeda Goes to Sulu</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 5)
   { document.write("<strong>The Many Faces of Death And Danger In The Abu Sayyaf Camp</strong>"); }
   else
   { document.write("<a href='"+addstr+"talipao_p5.htm' class='sidemenu'>The Many Faces of Death And Danger In The Abu Sayyaf Camp</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 6)
   { document.write("<strong>Triumphant Entry Into The Abu Sayyaf Stronghold</strong>"); }
   else
   { document.write("<a href='"+addstr+"talipao_p6.htm' class='sidemenu'>Triumphant Entry Into The Abu Sayyaf Stronghold</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 7)
   { document.write("<strong>Assistant Pastor Lina Almeda Faces Detractors</strong>"); }
   else
   { document.write("<a href='"+addstr+"talipao_p7.htm' class='sidemenu'>Assistant Pastor Lina Almeda Faces Detractors</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 8)
   { document.write("<strong>Evangelist Wilde Almeda Severely Weakens to The Point of Death</strong>"); }
   else
   { document.write("<a href='"+addstr+"talipao_p8.htm' class='sidemenu'>Evangelist Wilde Almeda Severely Weakens to The Point of Death</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 9)
   { document.write("<strong>Surprise Military Assault Ordered</strong>"); }
   else
   { document.write("<a href='"+addstr+"talipao_p9.htm' class='sidemenu'>Surprise Military Assault Ordered</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 10)
   { document.write("<strong>Wonder of Wonders: Alive From NO MAN'S LAND</strong>"); }
   else
   { document.write("<a href='"+addstr+"talipao_p10.htm' class='sidemenu'>Wonder of Wonders: Alive From NO MAN'S LAND</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 11)
   { document.write("<strong>Peace Mission Triumphs: Chronology of Hostages' Release</strong>"); }
   else
   { document.write("<a href='"+addstr+"talipao_p11.htm' class='sidemenu'>Peace Mission Triumphs: Chronology of Hostages' Release</a>"); }

}


function nav_message_boards(menu_id, swNested)
{
   var addstr = "";
   if (swNested == 1) { addstr = "../message_boards/";}
   
   if (menu_id == 1)
   { document.write("<strong>Announcements</strong>"); }
   else
   { document.write("<a href='"+addstr+"announcements.php' class='sidemenu'>Announcements</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 2)
   { document.write("<strong>Prayer Requests</strong>"); }
   else
   { document.write("<a href='"+addstr+"prayer_requests.php' class='sidemenu'>Prayer Requests</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 3)
   { document.write("<strong>Miscellaneous</strong>"); }
   else
   { document.write("<a href='"+addstr+"miscellaneous.php' class='sidemenu'>Miscellaneous</a>"); }

}

function nav_doctrine(menu_id)
{
   if (menu_id == 1)
   { document.write("<strong>Fundamental Doctrine</strong>"); }
   else
   { document.write("<a href='doctrine_p1.htm' class='sidemenu'>Fundamental Doctrine</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 2)
   { document.write("<strong>Wheel of Prophecy</strong>"); }
   else
   { document.write("<a href='wheel_of_prophecy.htm' class='sidemenu'>Wheel of Prophecy</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   //if (menu_id == 3)
   //{ document.write("<strong>Q&A</strong>"); }
   //else
   //{ document.write("<a href='qna.php' class='sidemenu'>Q&A</a>"); }
   //document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 4)
   { document.write("<strong>Praise & Worship Sequence</strong>"); }
   else
   { document.write("<a href='praise_sequence.htm' class='sidemenu'>Praise & Worship Sequence</a>"); }
}



function nav_testimony(menu_id, swNested)
{
   var addstr = "";
   if (swNested == 1) { addstr = "../testimonies/";}

   if (menu_id == 1)
   { document.write("<strong><a href='"+addstr+"living_testimonies_p1.htm' class='sidemenu'>Living Testimonies</a></strong>"); }
   else
   { document.write("<a href='"+addstr+"living_testimonies_p1.htm' class='sidemenu'>Living Testimonies</a>"); }

   // START SUBMENU 
   
   document.write("<table border='0' width='150' class='pt_11' cellpadding='0' cellspacing='10'><tbody>");

   document.write("<tr><td>");
   if (menu_id == 2)
   { document.write("<strong><a href='"+addstr+"living_testimonies_p2.htm' class='sidemenu'>JESUS Saved Me from Holdupper's Bullet</a></strong>"); }
   else
   { document.write("<a href='"+addstr+"living_testimonies_p2.htm' class='sidemenu'>JESUS Saved Me from Holdupper's Bullet</a>"); }
   document.write("</td></tr>");
   
   document.write("<tr><td>");
   if (menu_id == 3)
   { document.write("<strong><a href='"+addstr+"living_testimonies_p3.htm' class='sidemenu'>JESUS Saved Me from Gunshot</a></strong>"); }
   else
   { document.write("<a href='"+addstr+"living_testimonies_p3.htm' class='sidemenu'>JESUS Saved Me from Gunshot</a>"); }
   document.write("</td></tr>");
   
   document.write("<tr><td>");
   if (menu_id == 4)
   { document.write("<strong><a href='"+addstr+"living_testimonies_p4.htm' class='sidemenu'>Shotgun Blast in the Chest, JESUS Saved Me</a></strong>"); }
   else
   { document.write("<a href='"+addstr+"living_testimonies_p4.htm' class='sidemenu'>Shotgun Blast in the Chest, JESUS Saved Me</a>"); }
   document.write("</td></tr>");

   document.write("<tr><td>");
   if (menu_id == 5)
   { document.write("<strong><a href='"+addstr+"living_testimonies_p5.htm' class='sidemenu'>Before-and-After Photos</a></strong>"); }
   else
   { document.write("<a href='"+addstr+"living_testimonies_p5.htm' class='sidemenu'>Before-and-After Photos</a>"); }
   document.write("</td></tr>");
   document.write("</tbody></table>");
   // END SUBMENU 


   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 6)
   { document.write("<strong><a href='"+addstr+"personal_testimonies.php' class='sidemenu'>Personal Testimonies</a></strong>"); }
   else
   { document.write("<a href='"+addstr+"personal_testimonies.php' class='sidemenu'>Personal Testimonies</a>"); }
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 7)
   { document.write("<strong><a href='"+addstr+"testimony_mailer.htm' class='sidemenu'>Share Your Testimony</a></strong>"); }
   else
   { document.write("<a href='"+addstr+"testimony_mailer.htm' class='sidemenu'>Share Your Testimony</a>"); }
   //document.write("<hr class='ltgray_thin' />"); 

   //if (menu_id == 4)
   //{ document.write("<strong><a href='"+addstr+"testimonies_search.php' class='sidemenu'>Search ...</a></strong>"); }
   //else
   //{ document.write("<a href='"+addstr+"testimonies_search.php' class='sidemenu'>Search ...</a>"); }
}


function nav_contact(menu_id, swNested)
{
   var addstr = "";
   if (swNested == 1) { addstr = "../contact/";}

   if (menu_id == 1)
   { document.write("<strong>Philippines</strong>"); }
   else
   { document.write("<a href='"+addstr+"phils.php' class='sidemenu'>Philippines</a>"); }
   document.write("<hr class='ltgray_thin' />");

   if (menu_id == 2)
   { document.write("<strong>Other Countries</strong>"); }
   else
   { document.write("<a href='"+addstr+"abroad.php' class='sidemenu'>Other Countries</a>"); }
   document.write("<hr class='ltgray_thin' />");

   if (menu_id == 3)
   { document.write("<strong>Send Us an E-Mail</strong>"); }
   else
   { document.write("<a href='"+addstr+"send_mail.htm' class='sidemenu'>Send Us an E-Mail</a>"); }
}


function nav_multimedia(menu_id, swNested)
{
   var addstr = "";
   if (swNested == 1) { addstr = "../multimedia/";}

   if (menu_id == 1)
   { document.write("<a href='"+addstr+"praise_songs.php' class='sidemenu'><strong>Praise Songs</strong></a>"); }
   else
   { document.write("<a href='"+addstr+"praise_songs.php' class='sidemenu'>Praise Songs</a>"); }
   document.write("<hr class='ltgray_thin' />");

   if (menu_id == 2)
   { document.write("<a href='"+addstr+"photos.php' class='sidemenu'><strong>Photos</strong></a>"); }
   else
   { document.write("<a href='"+addstr+"photos.php' class='sidemenu'>Photos</a>"); }
   document.write("<hr class='ltgray_thin' />");

   if (menu_id == 3)
   { document.write("<a href='"+addstr+"audio_video.php' class='sidemenu'><strong>Audio/Video</strong></a>"); }
   else
   { document.write("<a href='"+addstr+"audio_video.php' class='sidemenu'>Audio/Video</a>"); }
   document.write("<hr class='ltgray_thin' />");

   if (menu_id == 4)
   { document.write("<a href='../webstream/jmcim.html' class='sidemenu'><strong>Webcast</strong></a>"); }
   else
   { document.write("<a href='../webstream/jmcim.html' class='sidemenu'>Webcast</a>"); }
}



function nav_services(menu_id, swNested)
{
   var addstr = "";
   if (swNested == 1) { addstr = "../services/";}
   
   if (menu_id == 1)
   { document.write("<strong><a href='"+addstr+"phils.php' class='sidemenu'>Philippines</a></strong>");}
   else
   { document.write("<a href='"+addstr+"phils.php' class='sidemenu'>Philippines</a>");}
   document.write("<hr class='ltgray_thin' />");   
   
   if (menu_id == 2)
   { document.write("<strong><a href='"+addstr+"abroad.php' class='sidemenu'>Other Countries</a></strong>");}
   else
   { document.write("<a href='"+addstr+"abroad.php' class='sidemenu'>Other Countries</a>");}
   document.write("<hr class='ltgray_thin' />");   

   if (menu_id == 3)
   { document.write("<strong><a href='"+addstr+"services_mailer.htm' class='sidemenu'>Submit an Outreach Service Schedule</a></strong>");}
   else
   { document.write("<a href='"+addstr+"services_mailer.htm' class='sidemenu'>Submit an Outreach Service Schedule</a>");}
}



function nav_events(menu_id, swNested)
{
   var addstr = "";
   if (swNested == 1) { addstr = "../events/";}

   if (menu_id == 1)
   { document.write("<a href='"+addstr+"events.php' class='sidemenu'><strong>Events &amp; Activities</strong></a>"); }
   else
   { document.write("<a href='"+addstr+"events.php' class='sidemenu'>Events &amp; Activities</a>"); }
   document.write("<hr class='ltgray_thin' />");

   if (menu_id == 2)
   { document.write("<strong>Submit an Event/Activity</strong>"); }
   else
   { document.write("<a href='"+addstr+"event_mailer.php' class='sidemenu'>Submit an Event/Activity</a>"); }
}



function nav_giving(menu_id, swNested)
{
   var addstr = "";
   if (swNested == 1) { addstr = "../giving/";}

   if (menu_id == 1)
   { document.write("<a href='"+addstr+"giving.php' class='sidemenu'><strong>Donations, Tithes, Offerings</strong></a>"); }
   else
   { document.write("<a href='"+addstr+"giving.php' class='sidemenu'>Donations, Tithes, Offerings</a>"); }
   document.write("<hr class='ltgray_thin' />");

   if (menu_id == 2)
   { document.write("<strong>FAQ</strong>"); }
   else
   { document.write("<a href='"+addstr+"faq.php' class='sidemenu'>FAQ</a>"); }
}


function writesyntax(funcname)
{
   window.document.form1.txtcontent.value=eval(funcname);
}


function enlargeView(imgSource)
{
   var strViewPic = "document.viewer.src="+imgSource;
   eval(strViewPic);
}



function show_hide() 
{
   for (var i=0; i<show_hide.arguments.length; i++) 
   {
      var element = document.getElementById(show_hide.arguments[i]);
      element.style.display = (element.style.display == "none") ? "block" : "none";
   }
}




//-->