<?php
//Open images directory
$dir = dir("Chris");//List files in images directory
while (($file = $dir->read()) !== false)
{
echo "filename: <a href='$file'>" . $file . "</a><br />";
}$dir->close();
?> 