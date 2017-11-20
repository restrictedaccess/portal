 <script type='text/javascript'>
 jQuery().ready(function($){
	<?php
	if($report['resolution']=='not a bug' || $report['resolution']=='fixed')
		echo "$('div#divnote').show();";
	?>
 });
 </script>
	<style type='text/css'>
    div.container{float:left;width:87%;height:100%;margin-left:auto;margin-right:auto;border:1px solid #7a9512;}
    </style>
    <div style='float:left;width:12px;'>&nbsp;</div>
    <div id='divresult' class='container'>
        <span id='task-status'></span>
		
			<div id="qholder" style="float:left;width:80%;padding:10px;">
                <table width="100%" cellspacing="2" class="list">
            		<tr><td height='30' class='header' colspan='4'>View Bug Details</td></tr>
                    <tr>
                    <td class="label2" width='170'>ID</td>
                    <td class="label2" width='170'>Severity</td>
                    <td class="label2" width='150'>Date Submitted</td>
                    <td class="label2" colspan='2'>Last Updated</td>
                    </tr>
                    <tr>
                    <td class="item lolite"><?php printf('%05d', $report['id']);?></td>
                    <td class="item lolite"><?php echo $report['severity'];?></td>
                    <td class="item lolite"><?php echo $report['creation_date'];?></td>
                    <td class="item lolite" colspan='2'><?php echo $report['update_date'];?></td>
                    </tr>
                   
                    <tr><td class='lolite' colspan='4'></td></tr>
                    <tr>
                    <td class="label2">Reporter</td>
                    <td class="form2 hilite" colspan='3'><?php echo $report['reporter'];?></td>
                    </tr>
                    
                    <!--<tr>
                    <td class="label2">Assign To</td>
                    <td class="form2 hilite" colspan='3' id='report_assignto'></td>
                    </tr>-->
                    
                    <tr>
                    <td class="label2">Status</td>
                    <td class="form2 hilite"><?php echo ucfirst($report['status']);?>
                    <?php //$priority = explode('_', $report['priority'], 2); echo ucfirst($priority[0]);?></td>
                    
                    <td class="label2" width='100'>Resolution</td>
                    <td class="form2 hilite"><?php echo ucfirst($report['resolution']);?></td>
                    </tr>
                    
                    
                    <tr><td class='lolite' colspan='4' style='height:7px;'></td></tr>
        
                    <tr>
                    <td class='label2'>Title / Summary:</td>
                    <td class='form2 hilite' colspan='3'><?php echo $report['report_title'];?></td>
                    </tr>
                    
                    <tr>
                    <td class='label2'>Link (URL):</td>
                    <td class='form2 hilite' colspan='3'>
                        <?php
                        $report_link = $report['report_link'];
                        if(preg_match('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', $report_link, $match))
                            $report_link = "<a href='".$match[0]."' target='_blank'>".$match[0]."</a>";
                        echo $report_link;?></td>
                    </tr>
                    
                    <tr>
                    <td class='label2'>Steps To Reproduce /<br/> How did you get here? </td>
                    <td class='form2 hilite' colspan='3'>
                        
                    <?php
                        $str = nl2br(htmlspecialchars($report['steps_reproduce']));
                        $str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $str);
                        $str = stripslashes($str);
                    echo $str;?>

                    </td>
                    </tr>
                    
                    <tr>
                    <td class='label2'>Actual Result:</td>
                    <td class='form2 hilite' colspan='3'>
                    <?php $str = nl2br(htmlspecialchars($report['actual_result']));
                        $str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $str);
                        $str = stripslashes($str);
                    echo $str;?></td>
                    </tr>
                    
                    
                    <tr>
                    <td class='label2'>Expected Result / <br/> What were you expecting to happen? </td>
                    <td class='form2 hilite' colspan='3'>
                        <?php $str = nl2br(htmlspecialchars($report['expected_result']));
                        $str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $str);
                        $str = stripslashes($str);
                    echo $str;?>
                    </td>
                    </tr>
                    
                    <tr>
                    <td class='label2'>Additional Information</td>
                    <td class='form2 hilite' colspan='3'><?php echo $report['other_info'];?></td>
                    </tr>
                    
                    <tr><td class="label2">Attached Files</td>
                    <td class='form2 hilite' colspan='3'>
                        <?php
                        $files = $report['files'];
                        if( count($files) ) {
                            foreach( $files as $file ) {
                                //echo "<a href='/portal/uploads/bugreport/".$file['file_name']."' target='_blank'>".$file['file_name']."</a> &nbsp;";
								
								if( file_exists("../../portal/uploads/bugreport/".$report['userid']."/".$file['file_name']) )
                                    $file_link = "<a href='/portal/uploads/bugreport/".$report['userid']."/".$file['file_name']."'";
                                else
                                    $file_link = "<a href='/portal/uploads/bugreport/".$file['file_name']."'";
									
								if( strpos($file['file_name'], '/') !== false )
                                    $file_link = $file_link . " target='_blank'>".substr($file['file_name'], strpos($file['file_name'], '/')+1)."</a> &nbsp;";
                                else
                                    $file_link = $file_link . " target='_blank'>".$file['file_name']."</a> &nbsp;";
                                echo $file_link;
                            }
                        }
                        ?>
                    </td>
                    </tr>
                </table>
            
            </div>
            <p>&nbsp;</p>
            
            <div id='divnote' style='float:left;width:80%;padding:12px;display:none'>
                
                <div style='float:left;width:100%;padding-top:10px;border:1px solid #ff9900;'>
                    <div style='float:left;width:100%;padding-left:2px;text-align:left;position:relative;bottom:5px;'>Note:</div>
                    
                    <table width='100%' border='0' cellpadding="7" cellspacing="2" class="list" id="notes">
                        <tr>
						<td class='form2' style='width:80%' id='notelist'>
						<?php if(count($notes) > 0):
							foreach($notes as $k => $note):
							?>
								<div style='width:100%;float:left;padding:2px;font-size:11px;background:#E3FFB0;border-bottom:1px solid #aaa;'>
								<?php echo '('.$note['date'].') '.$note['note_content'];?>
								</div>
							<?php endforeach;
						endif;?>
						  
						
						</td>
                        
						</tr>
                    </table>
                    
                </div>
    
            </div>
       
    </div>
<br />
