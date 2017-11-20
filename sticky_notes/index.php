<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="./sticky_notes/sticky_notes.js"></script>
<script type="text/javascript" src="./commission/drag-drop-custom.js"></script>
<link rel="stylesheet" type="text/css" href="./sticky_notes/sticky_notes.css" />
<script type="text/javascript" src="./sticky_notes/drag.js"></script>
<input type="hidden" name="ctr" id="ctr" value="0" />
<!-- sticky notes-->
<div id="sticky_wrapper" class="dragclass" title="move" >
<!--
<div class="bak"> 
  <div class="sektion"> 
	   <div class="sticky_control_holder">
					<div class="sticky_control_plus"><a href="javascript:showAddNewStickyMessageForm();" title="add new notes">+</a></div>
					<div class="sticky_control_minus"><a href="javascript:opencloseStickyNotes();" title="close">x</a></div>
					<div style="clear:both;"></div>
		</div>
		<div id="add_div">
						<textarea class="select" id="message" name="message" style="width:320px; height:80px;"></textarea><br />
						<input type="button" value="save" id="save_message" onclick="javascript:OnClickAddNewStickyMessage();" />
						<input type="button" value="cancel" onclick="javascript:toggle('add_div');" />
		</div>
		<div id="message_status"></div>
		<div id="sticky_holder"></div>
  </div> 
</div> 
-->

	
<div class="blur">
	<div class="shadow">
		<div class="content"
			<div class="sticky_control_holder">
				<div class="sticky_control_plus"><a href="javascript:showAddNewStickyMessageForm();" title="add new notes">+</a></div>
				<div class="sticky_control_minus"><a href="javascript:opencloseStickyNotes();" title="close">x</a></div>
				<div style="clear:both;"></div>
			</div>
			<div class="message_board" >
				<div id="add_div">
					<textarea class="select" id="message" name="message" style="width:320px; height:80px;"></textarea><br />
					<input type="button" value="save" id="save_message" onclick="javascript:OnClickAddNewStickyMessage();" />
					<input type="button" value="cancel" onclick="javascript:toggle('add_div');" />
				</div>
				<div id="message_status"></div>
				<div id="sticky_holder"></div>
			</div>
		</div>
	</div>
</div>
	
	
</div>


<!-- sticky notes button-->
<div id="notification_messages_bttn" onclick="javascript:opencloseStickyNotes();" title="open notification messages">Sticky Note &nbsp;<img align="absmiddle" src="./images/001_44.png" border="0" /></div>