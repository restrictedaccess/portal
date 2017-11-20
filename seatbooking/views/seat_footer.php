
<?php // seat_footer.php 2011-11-29 mike
?>

</td>
</tr>
</table>

<style type='text/css'>
#bottom {
  position: fixed;
  bottom: 0;
  left: 0;
  z-index: 999;
  width: 100%;
  height: 20px;
  text-align:right;
  padding-right:10px;
}

* html #bottom {
  position: absolute;
  bottom: -1px;
}

#bottom-inner {
    width:auto;
  height: 20px;
  float:right;
  background: #7a9512; /*abccdd;*/
}
#bottom-inner a {
  color:#000;
  font-weight:bold;
}

* html #bottom-inner {
  margin-right: 17px;
}
</style>

<br />
<br />
<div id="bottom"> 
  <div id="bottom-inner"><!--<a href='ah_rschat.php?login=remote.michaell@gmail.com' onclick="return show_hide_cbox(this, 900, 470, '3px solid #011a39', 35,20);">RS-Chat</a> &nbsp; &nbsp;-->
    <?php /*<a href='ahschat.php?login={$email}&type={$type}' onclick="return show_hide_cbox(this, 270, 430, '2px solid #011a39', '');">RS-Chat</a> &nbsp;*/?>
    </div>
</div>

</body>
</html>
