<?php
/*
2009-10-21 Normaneil Macutay	
	- password encrypted
*/


function doEncryptPassword($string){
	return sha1($string);	
}
?>
