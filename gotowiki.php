<?php
session_start();

session_write_close();
session_name("remotestaff");
if( strpos($_SERVER['HTTP_HOST'], 'test.') !== false ) {
    session_set_cookie_params(0, '/', '.remotestaff.com.au', false, true);
    $wikiURL = "http://test.remotestaff.com.au/dokuwiki/doku.php?id=start";
} else {
    session_set_cookie_params(0, '/', '.remotestaff.com.au', true, true);
    $wikiURL = "https://dokuwiki.remotestaff.com.au/dokuwiki/doku.php?id=start";
}
session_start();

$_SESSION['REMOTESTAFF'] = time();

header("location: $wikiURL");
//header("location: https://dokuwiki.remotestaff.com.au/dokuwiki/doku.php?id=start");
//header("location: http://test.remotestaff.com.au/dokuwiki/doku.php?sectok=$sectok&u=user&p=RemotE&do=login&id=start");
exit;
?>