    <style type='text/css'>
    div.container{float:left;width:100%;margin-left:auto;margin-right:auto;border:1px solid #7a9512;}
	div.qholder{float:left;width:100%; overflow-x:hidden; overflow-y:scroll;}
    </style>
    
    <div id='divresult' class='container'>
        <span id='task-status'></span>
		<div id='left' style="float:left;width:47%;padding:10px;">
			<div class="qholder" style="height:400px;">

                <table width="100%" cellspacing="2" class="list">
            		<tr><td height="30" class="header" colspan="2">Unassigned
                        <span style='float:right;width:70px;'>Count: <?php echo count($newtickets);?></span></td>
                    </tr>
                    
                    <?php if(count($newtickets) > 0):
		    			foreach($newtickets as $new):?>
                    <tr>
                    <td class="summary" style="width:90px;text-align:center;">
                        <a href='/portal/bugreport/?/view_details/<?php echo $new['id'];?>'><?php printf('%06d', $new['id']);?></a>
                        
                    <?php
                    if( $new['priority'] ) {
                        $priority = explode('_', $new['priority'], 2);
                        echo "<div style='text-align:center;'><img title='".$priority[0]."' src='/portal/bugreport/images/".$priority[1].".gif'/></div>";
                    }
                    ?>
                    </td>
                    <td class="summary">
                        <div style='float:left;width:74%;'><?php echo $new['report_title'];?></div>
                    <div class='updated'>Date created:<br/><?php echo $new['creation_date'];?></div>
                    
                    </td>
                    </tr>
                    <?php endforeach;
                    endif;?>
                    
                </table>
            </div>
            
            
            
            <div class="qholder" style="height:400px;margin-top:10px;">

                <table width="100%" cellspacing="2" class="list">
            		<tr><td height="30" class="header" colspan="2">Recently Updated
                        <span style='float:right;width:70px;'>Count: <?php echo count($updated);?></span></td>
                    </tr>
                    <?php if(count($updated) > 0):
		    			foreach($updated as $recent):?>
                    <tr>
                    <td class="summary" style="width:90px;text-align:center;">
                        <a href='/portal/bugreport/?/view_details/<?php echo $recent['id'];?>'><?php printf('%06d', $recent['id']);?></a>
                    <?php
                    if( $recent['priority'] ) {
                        $priority = explode('_', $recent['priority'], 2);
                        echo "<div style='text-align:center;'><img title='".$priority[0]."' src='/portal/bugreport/images/".$priority[1].".gif'/></div>";
                    }
                    ?>
                    </td>
                    <td class="summary">
                    <div style='float:left;width:74%;'><?php echo $recent['report_title'];?></div>
                    <div class='updated'>Updated:<br/><?php echo $recent['update_date'];?></div>
                    </td>
                    </tr>
                    <?php endforeach;
                    endif;?>
                    
                </table>
            </div>
        </div>
		
		<div id='right' style="float:right;width:47%;padding:10px;">
			<div class="qholder" style="height:800px;">

                <table width="100%" cellspacing="2" class="list">
            		<tr><td height="30" class="header" colspan="2">Resolved
                        <span style='float:right;width:70px;'>Count: <?php echo count($resolved);?></span></td>
                    </tr>
                    
        
                    <?php if(count($resolved) > 0):
		    			foreach($resolved as $closed):?>
                    <tr>
                    <td class="summary" style="width:90px;text-align:center;">
                        <a href='/portal/bugreport/?/view_details/<?php echo $closed['id'];?>'><?php printf('%06d', $closed['id']);?></a>
                    <?php
                    echo "<div style='text-align:center;'>".$closed['resolution']."</div>";
                    
                    ?>
                    </td>
                    <td class="summary">
                    <div style='float:left;width:74%;'><?php echo $closed['report_title'];?></div>
                    <div class='updated'>Updated:<br/><?php echo $closed['update_date'];?></div>
                    </td>
                    </tr>
                    <?php endforeach;
                    endif;?>
                    
                </table>
            </div>
		</div>
    </div>