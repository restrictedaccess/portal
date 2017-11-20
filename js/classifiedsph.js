function showsubmenufor(catid) {
  $$('.submenu').each( function (s) { s.style.display='none' } )
  $('submenu'+catid).style.display='block'
}
