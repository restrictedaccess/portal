Answers : 

1. 
<?php

$i = 1;
while ($i++ <= 10) {
print $i++ . “,”;
$i++;
}
print $i;

?>


Initial value of i=1 
Upon increment i++ 1st value of i = 2 
While loop will continue until i <= 10.
Value of I will increment from 2 to 5 and next value will 
increment itself to 3 plus the last value of "i" 
"I" will be called and will be separate by a comma ",". 
Output = 2,5,8,11

2. 

<?php

$data = "one,1\ntwo,2\nthree,3\nfour,4\nfive,5\nsix,6\nseven,7\neight,8\nnine,9\nzero,0";

$a = explode("\n", $data);
while (list(,$b) = each($a)) {
list($c,$d) = explode(",", $b);
$e[$d] = $c;
}

$x = "1759100283";
$a = preg_split("//", $x, -1, PREG_SPLIT_NO_EMPTY);
foreach ($a as $n) {
$d = ($n + 5) % 10;
$f[] = $e[$d];
}  
print implode(" ", $f);
?>

$data stores string value "one,1\ntwo,2\nthree,3\nfour,4\nfive,5\nsix,6\nseven,7\neight,8\nnine,9\nzero,0";
$a will have a value of the array from $data and explode it 
Value of striung is now placed into an array held by $a
$data(
[1] => one
[2] => two
[3] => three
[4] => four
[5] => five
[6] => six 
[7] => seven 
[8] => eight
[9] => nine
[0] => zero
)

Using While loo \p and List function to assign values $b with the current value of $a (each function returns current element key and value)

Value of $X =  1759100283
Using preg_Split function the value will be 
: 1 7 5 9 1 0 0 2 8 3 
1+5 = 6 Modulus division 6 % 10 = 6
7+5 = 12 Modulus division 12 % 10 = 2
5+5 = 10 Modulus division 10 % 10 = 0
9+5 = 14 Modulus division 14 % 10 = 4
1+5 = 6 Modulus division 6 % 10 = 6
0+5 = 5 Modulus division 5 % 10 = 5
0+5 = 5 Modulus division 5 % 10 = 5
2+5 = 7 Modulus division 7 % 10 =7
8+5 = 13 Modulus division 13 % 10 = 3
3+5 = 8 Modulus division 8 % 10 = 8

Using implode that returns a string from the elements of an array.
$f will print and store the value :Output (six two zero four six five five seven three eight)



3.You will be required to provide us with the source code of the application once completed. 
The code may use external libraries but the main application code must be your own. 
While we are big fans of PHP frameworks (Zend etc), 
please avoid using frameworks for this test - we are interested in seeing how you 
would put an application together from scratch.
You are required to create a PHP script that will download a list of pictures from flickr 
and save the data (URL, title, etc) associated with them in a MySQL database 
(database schema to be provided). While we know there’s a native serialised PHP output
format in the flickr API, we’d prefer it if you used the REST input/output formats.
(Why? We want to see you parse an XML feed - not all feeds are as easy to use as flickr!)
The user will be able to specify a search term and a geographic location 
(optional - if user doesn’t specify a location then search all locations).
You will then provide a simple view to browse theses images. Ideally a list of “last 10 searches” -
each linking through to the list of images downloaded for each search.
You should provide pagination if there are more than 15 images returned in a search.
You are not required to provide any sort of CSS, formatting or tests, it is only to test your knowledge of PHP,
database design, and general API access ability.

A. Create Database for MySQL 

Create Database Question3;

B. Create Table ImgQuestion3 for Database Question3

CREATE TABLE `ImgQuestion3` (`ImageIndex` INT NOT NULL AUTO_INCREMENT ,`ImagesData` LONGTEXT NOT NULL, ,`ImgURL` LONGTEXT NOT NULL ,PRIMARY KEY (`ImageIndex`));  

C. PHP Script 

<? $img = $_GET['img']; ?>
<?php
$link = mysql_connect("localhost", "Dan", "Dan") OR DIE("Unable to connect to the MYSQL "); 

mysql_conectDB("Question3",$db);

$PictureUrl="http://www.flickr.com/photos/davidgutierrez/3357419498.jpg"
$mysqlPicture = addslashes(stream_get_contents(fopen($PictureUrl, "rb"), -1));
mysql_query("INSERT INTO ImgQuestion3 (ImagesData,ImgUrl) VALUES ('$mysqlPicture','$Pictureurl')") or die("Insert Query Error: ".mysql_error());

$query = "select * FROM ImgQuestion3 where ImagesData = '$img'"; 
$rsc  = mysql_query($query) or die(mysql_error());

?>

<body>
<p align="center">Question3  <? echo $img ?> </p>
<table width="250" border="0" align="center">
   <tr>
      <?
$i = 0;
while($rowc = mysql_fetch_array($rsc)) {
if(($i%8 == 0) && ($i > 0)) { ?>
  </tr>
     <tr> <? }  ?>
     <td valign="top">
<? 
$file = $rowc['file'];//<-----------
$fname = $rowc['fname'];//<-----------
$ext = $rowc['ext'];//<-----------
$img = $file.$fname.$ext; //<-----------
?>
<a href="files/<? echo $img;?>" target="_blank"><img src ="files/min/<? echo $img;?>" border="1" align="absmiddle" /></a></p></td> 
     <div id="filler"></div>
<? $i++;
} ?></tr>     
</table>
</body>
</html>
