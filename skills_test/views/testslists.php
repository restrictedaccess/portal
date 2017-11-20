<div class="main-container" style="width:98%">
<p class="lastNode">Tests Lists</p>
<div style='float:right;width:99%;'>
	<span style='float:left;line-height:23px'>*Contains US Terminology</span>
	
	<select name='ticket_csro' id='category' class='inputbox2' style='float:right;height:21px'onchange="location.href='?/testlist800plus/'+this.value;">
		<option value="">- All Category -</option>
		<?php foreach($categories as $cat):?>
			<option value='<?php echo $cat."'"; if($cat==$category) echo " selected";?>><?php echo $cat;?></option>
		<?php endforeach;?>
	</select><span style='float:right;padding-right:10px;line-height:22px;font-weight:bold;'>Category:</span>
</div>
<p>&nbsp;</p>
		
		<div id="qholder" style="float:left;width:450px;">
            <table width="100%" cellspacing="2" class="list">
            	<tr><td class='header' style='width:4%;'>#</td>
					<td class='header' style='width:7%;'>Category</td>
					<td class='header' style='width:15%;'>Skill Test Title</td>
					<td class='header' style='width:5%;'># of Questions</td>
                </tr>
                    
                <?php
					$cnt = 0;
					$cnt2 = 0;
					
					$len = count($test_lists);
				
					$cnt2 = floor($len / 2);
					$cnt = $cnt2 + ($len%2);
					
					if($cnt > 0):
		    			for($i = 0; $i < $cnt; $i++):?>
							
                    <tr>
						<td class='item'><?php echo $i+1;?></td>
						<?php $data = explode("\t", $test_lists[$i]);
						foreach( $data as $item ):
							if(trim($item) != ""):
						?>
							
							<td class='item'><?php echo $item;?></td>
						<?php endif;
						endforeach;?>
                    </tr>
                    <?php endfor;
                endif;?>
                    
            </table>
        </div>
            
        <div id="qholder" style="float:right;width:450px;">
            <table width="100%" cellspacing="2" class="list">
            	<tr><td class='header' style='width:4%;'>#</td>
					<td class='header' style='width:7%;'>Category</td>
					<td class='header' style='width:15%;'>Skill Test Title</td>
					<td class='header' style='width:5%;'># of Questions</td>
                </tr>
                    
                <?php

					if($cnt2 > 0):
		    			for($i = 0; $i < $cnt2; $i++):?>
							
                    <tr>
						<td class='item'><?php echo ($i+$cnt+1);?></td>
						<?php $data = explode("\t", $test_lists[$i+$cnt]);
						foreach( $data as $item ):
							if(trim($item) != ""):
						?>
							
							<td class='item'><?php echo $item;?></td>
						<?php endif;
						endforeach;?>
                    </tr>
                    <?php endfor;
                endif;?>
                    
            </table>
        </div>
<div id="footer_divider"></div>
</div>