<center>
<table width="680" bgcolor="#2a629f" cellpadding="16">
	<tr>
    	<td>

    
            <table width="100%" bgcolor="#FFFFFF" cellpadding="3">
                <tr>
                    <td colspan="2">
						<div style="padding-top: 8px; padding-bottom: 4px;"><img src="http://{ $PERMALINK }/images/remote-staff-logo.jpg"/></div>
                    </td>
                </tr>             
            	<tr>
                	<td colspan="2">
                        <table width="100%" bgcolor="#2a629f" cellpadding="10">
                            <tr>
                                <td>
                                    <strong><font size="4" color="#FFFFFF" face="Verdana">Remotestaff Applicant ID: { $userid }</font></strong>
                                </td>
                            </tr>                     
						</table>
                    </td>
                </tr>
                <tr>
                    <td width="30%" align="center" valign="top">
                        <img src="http://{ $PERMALINK }/available-staff-image.php?w=110&id={ $userid }"/><br />
                        <div><font face="Verdana" size="2"><strong>{ $fname|upper }</strong></font></div>                    
                    </td>
                    <td width="70%">
                        <div style="padding-top: 18px;float: right; width : 538px; max-height: 258px; overflow: auto;">
                            <div style="text-align: center; font-weight: bold; padding-bottom: 8px;"><font face="Verdana" size="2">INHOUSE RECRUITER COMMENTS AND NOTES</font></div>
                            { foreach from=$valid_evaluation_comments item=comment name=ctr }
                                <div style="float: left; width: 24px;"><font face="Verdana" size="2">{ $smarty.foreach.ctr.iteration })</font></div>
                                <div style="float: left; width: 490px;"><font face="Verdana" size="2">{ $comment }</font></div>
                                <div style="clear: both;"></div>
                            { /foreach }
                        </div>              
                    </td>
                </tr> 
                <tr>
                	<td colspan="2">
                        <div style="padding-top: 8px;">
                            <font face="Verdana" size="2">
                            <strong>
                                Availability:
                            </strong>
                            { if $availability.available_status eq 'a'}
                                I can start work after 
                                { $availability.available_notice|escape }
                                month(s) of notice period.
                            { /if }
                            { if $availability.available_status eq 'b'}
                                I can start work after 
                                { $availability.amonth|escape }
                                { $availability.aday|escape },
                                { $availability.ayear|escape }.
                            { /if }
                            { if $availability.available_status eq 'p'}
                                I am not actively looking for a job now.
                            { /if }
                            { if $availability.available_status eq 'Work Immediately'}
                                I can Work Immediately.
                            { /if }
                            </font>
                        </div>                    
                    </td>
                </tr>
                
                
                <tr>
                    <td colspan="2">
                        <div style="padding-top: 8px;">
                            <strong>
                                <font face="Verdana" size="2">{ $timezone_availability }</font>
                            </strong>
                        </div>
                    </td>
                </tr> 
                
                
                <tr>
                    <td colspan="2" bgcolor="#CCCCCC"><font face="Verdana" size="2"><strong>Personal Information</strong></font></td>
                </tr>   
                <tr>
                    <td colspan="2">
                        <table style="float: left;">
                            <tr>
                                <td><font face="Verdana" size="2"><b>Age</b></font></td>
                                <td>:</td>
                                <td><font face="Verdana" size="2">{ $age }</font></td>
                            </tr>
                            <tr>
                                <td><font face="Verdana" size="2"><b>Nationality</b></font></td>
                                <td>:</td>
                                <td>{ $nationality }</td>
                            </tr>
                            <tr>
                                <td><font face="Verdana" size="2"><b>Permanent Residence</b></font></td>
                                <td>:</td>
                                <td><font face="Verdana" size="2">{ $country_id }</font></td>
                            </tr>
                        </table>
                        <table style="float: right;">
                            <tr>
                                <td><font face="Verdana" size="2"><b>Date of Birth</b></font></td>
                                <td>:</td>
                                <td><font face="Verdana" size="2">{ $date_of_birth }</font></td>
                            </tr>
                            <tr>
                                <td><font face="Verdana" size="2"><b>Gender</b></font></td>
                                <td>:</td>
                                <td><font face="Verdana" size="2">{ $gender }</font></td>
                            </tr>
                        </table>
                    </td>
                </tr> 
                
                
                <tr>
                    <td colspan="2" bgcolor="#CCCCCC"><font face="Verdana" size="2"><strong>Working at Home Capabilities</strong></font></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="padding-top: 8px; padding-bottom: 18px; padding-left: 18px; padding-right: 18px;">
                            <div><font face="Verdana" size="2"><b>Working Environment :</b> { $home_working_environment }</font></div>
                            <div><font face="Verdana" size="2"><b>Internet Connection :</b> { $internet_connection }</font></div>
                            <div><font face="Verdana" size="2"><b>Computers Hardware/s :</b> { $computer_hardware }</font></div>
                            <div><font face="Verdana" size="2"><b>Headset Quality :</b> { $headset_quality }</font></div>
                        </div>
                    </td>
                </tr> 
                
                
                <tr>
                    <td colspan="2" bgcolor="#CCCCCC"><font face="Verdana" size="2"><strong>Highest Qualification</strong></font></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table style="float: left; width: 400px;">
                            <tr>
                                <td><font face="Verdana" size="2"><b>Level</b></font></td>
                                <td>:</td>
                                <td><font face="Verdana" size="2">{$education.educationallevel}</font></td>
                            </tr>
                            <tr>
                                <td><font face="Verdana" size="2"><b>Field of Study</b></font></td>
                                <td>:</td>
                                <td><font face="Verdana" size="2">{$education.fieldstudy}</font></td>
                            </tr>
                            <tr>
                                <td><font face="Verdana" size="2"><b>Major</b></font></td>
                                <td>:</td>
                                <td><font face="Verdana" size="2">{$education.major}</font></td>
                            </tr>
                            <tr>
                                <td nowrap="true"><font face="Verdana" size="2"><b>Institute / University</b></font></td>
                                <td>:</td>
                                <td><font face="Verdana" size="2">{$education.college_name}</font></td>
                            </tr>
                            <tr>
                                <td><font face="Verdana" size="2"><b>Located In</b></font></td>
                                <td>:</td>
                                <td><font face="Verdana" size="2">{$education.college_country}</font></td>
                            </tr>
                        </table>
                        <table style="float: right;">
                            <tr>
                                <td><font face="Verdana" size="2"><b>Graduation Date</b></font></td>
                                <td>:</td>
                                <td><font face="Verdana" size="2">{$education.graduation_date}</font></td>
                            </tr>
                        </table>
                    </td>
                </tr> 
                
                
                <tr>
                    <td colspan="2" bgcolor="#CCCCCC"><font face="Verdana" size="2"><strong>Employment History</strong></font></td>
                </tr>
                <tr>
                    <td colspan="2">
        				<table>
                            { foreach from=$currentjob item=job name=ctr}
                                <tr>
                                    <td><font face="Verdana" size="2">{ $smarty.foreach.ctr.iteration }.</font></td>
                                    <td style="vertical-align: top;"><font face="Verdana" size="2"><b>Company Name</b></font></td>
                                    <td style="vertical-align: top;">:</td>
                                    <td><font face="Verdana" size="2"><b>{ $job.companyname }</b></font></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="vertical-align: top;"><font face="Verdana" size="2"><b>Position / Title</b></font></td>
                                    <td style="vertical-align: top;">:</td>
                                    <td><font face="Verdana" size="2"><b>{ $job.position }</b></font></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="vertical-align: top;"><font face="Verdana" size="2"><b>Employment Period</b></font></td>
                                    <td style="vertical-align: top;">:</td>
                                    <td><font face="Verdana" size="2">{ $job.employment_period }</font></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="vertical-align: top;"><font face="Verdana" size="2"><b>Responsibilities / Achivements</b></font></td>
                                    <td style="vertical-align: top;">:</td>
                                    <td><font face="Verdana" size="2">{ $job.duties }</font> </td><!--<td>{ $job.duties }</td>-->
                                </tr>
                            { /foreach }
                        </table>                    
                    </td>
                </tr>
                
                
                <tr>
                    <td colspan="2" bgcolor="#CCCCCC"><font face="Verdana" size="2"><strong>Languages</strong></font></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="text-align: right;"><font face="Verdana" size="2"><b>Proficiency</b> (0=Poor -10=Excellent)</font></div>
                        <table style="width: 100%;">
                            <tr>
                                <td><font face="Verdana" size="2"><b>Language</b></font></td><td><font face="Verdana" size="2"><b>Spoken</b></font></td><td><font face="Verdana" size="2"><b>Written</b></font></td>
                            </tr>
                            { foreach from=$language item=lang }
                                <tr>
                                    <td><font face="Verdana" size="2">{ $lang.language }</font></td>
                                    <td style="padding-left: 12px;"><font face="Verdana" size="2">{ $lang.spoken }</font></td>
                                    <td style="padding-left: 12px;"><font face="Verdana" size="2">{ $lang.written }</font></td>
                                </tr>
                            { /foreach }
                        </table>                    
                    </td>
                </tr>
                         
                         
                <tr>
                    <td colspan="2" bgcolor="#CCCCCC"><font face="Verdana" size="2"><strong>Skills</strong></font></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="text-align: right;"><font face="Verdana" size="2"><b>Proficiency</b> (1=Beginner - 2=Intermediate, 3=Advanced)</font></div>
                        <table style="width: 100%;">
                            <tr>
                                <td><font face="Verdana" size="2"><b>Skill</b></font></td><td><font face="Verdana" size="2"><b>Experience</b></font></td><td><font face="Verdana" size="2"><b>Proficiency</b></font></td>
                            </tr>
                            { foreach from=$skills item=skill }
                                <tr>
                                    <td><font face="Verdana" size="2">{ $skill.skill }</font></td>
                                    <td style="padding-left: 12px;"><font face="Verdana" size="2">
                                   		{if $skill.experience eq 0.75}
								        	Over 6 months
								        {elseif $skill.experience eq 0.5}
								        	Less than 6 months
								        {elseif $skill.experience > 10}
								        	More than 10 years
								        {else}
								        	{$skill.experience} yr/s
								        {/if}
                                    </font></td>
                                    <td style="padding-left: 12px;"><font face="Verdana" size="2">{ $skill.proficiency }</font></td>
                                </tr>
                            { /foreach }
                        </table>                  
                    </td>
                </tr>      
                
                
                <tr>
                    <td colspan="2" bgcolor="#CCCCCC"><font face="Verdana" size="2"><strong>Voice</strong></font></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="padding-top: 8px; padding-bottom: 18px; padding-left: 18px; padding-right: 18px;">
                            <!--
                            <div style="padding-left: 18px;">
                                {if $voice_type eq 'audio/mpeg'}
                                    <object type="application/x-shockwave-flash" data="/audio_player/player_mp3_maxi.swf" width="128" height="28">
                                        <param name="movie" value="/audio_player/player_mp3_maxi.swf" />
                                        <param name="FlashVars" value="mp3=/applicants_voice.php?id={$userid}&amp;showinfo=1&amp;width=128&amp;height=28&amp;file={$voice}&amp;type={$voice_type}" />
                                    </object>
                                {elseif $voice_type eq 'audio/wav'}
                                    <embed width="128" height="28" src="http://{ $PERMALINK }//portal/{$voice}" controls="controls" autostart="false">
                                    </embed>
                                {/if}
                            </div>
                            -->
                            <div style="padding-left: 18px;">
                                <font face="Verdana" size="2"><a href="http://{ $PERMALINK }/applicants_voice.php?id={$userid}&file={$voice}&type={$voice_type}">Download</a></font>
                            </div>
                        </div>                 
                    </td>
                </tr>                                                            
                        
                        
                <tr>
                    <td colspan="2" bgcolor="#CCCCCC"><font face="Verdana" size="2"><strong>Samples</strong></font></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="padding-top: 8px; padding-bottom: 18px; padding-left: 18px; padding-right: 18px;">
                            { foreach from=$applicant_files item=file }
                                {if $file.description neq 'RESUME'}
                                <div><font face="Verdana" size="2">{ $file.description }: <a href="http://{ $PERMALINK }/available-staff-attachments.php?userid={$userid}&file_name={$file.name}">{$file.name}</a></font></div>
                                {/if}
                            { /foreach }
                        </div>                
                    </td>
                </tr>
                
                                                                                                                                                                                           
            </table>
        </td>
    </tr>
</table>
</center>