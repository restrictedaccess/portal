
<?php // footer.php 2012-05-07 mike ?>

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
<!--
<br />
<div id="bottom"> 
  <div id="bottom-inner"><a href='ah_rschat.php?login=remote.michaell@gmail.com' onclick="return show_hide_cbox(this, 900, 470, '3px solid #011a39', 35,20);">RS-Chat</a> &nbsp; &nbsp;
    <?php /*<a href='ahschat.php?login={$email}&type={$type}' onclick="return show_hide_cbox(this, 270, 430, '2px solid #011a39', '');">RS-Chat</a> &nbsp;*/?>
    </div>
</div>
-->
<br/>
<hr style='float:left;width:100%'/>

</div>
	<div id="footer">
    	<!--<div class="footermain"></div>-->
        
		<div class="footermain"><div id="dash-divider"></div>
		  <span class="footernav">
		<p>&reg; Copyright 2012 All Rights Reserved Remotestaff Inc.<br/>
		E-mail us at <a href=''>info@remotestaff.com.au</a> with questions or feedback about the Website
		</p>
	    </div>
	</div>


</body>
</html>
