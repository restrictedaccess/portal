{ include file="header.tpl" }

<div id="divteam">
<pre style="display:none;">
DROP TABLE IF EXISTS `recruitment_team`;
CREATE TABLE  `recruitment_team` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `team` text,
  `team_description` text,
  `team_created_by_id` int(10) unsigned default NULL,
  `team_date_created` datetime default NULL,
  `team_status` enum('active','removed') NOT NULL default 'active',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `recruitment_team_member`;
CREATE TABLE  `recruitment_team_member` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `team_id` int(10) unsigned default NULL,
  `admin_id` int(10) unsigned default NULL,
  `member_position` enum('hiring coordinator','head recruiter','recruiter','csro') default NULL,
  `team_member_created_by_id` int(10) unsigned default NULL,
  `team_member_date_created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `recruitment_team_history`;
CREATE TABLE  `recruitment_team_history` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `team_id` int(10) unsigned default NULL,
  `history` text,
  `date_history` datetime default NULL,
  `admin_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
</pre>
<table id="divteamtb" align="center" width="90%" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<td width="5%" class="hdr">ID</td>
<td width="15%" class="hdr">Team Name</td>
<td width="20%" class="hdr">Hiring Coordinator</td>
<td width="20%" class="hdr">Head Recruiter</td>
<td width="20%" class="hdr">Reccruiters</td>
<td width="20%" class="hdr">CSRO</td>
</tr>

{foreach from=$teams name=team item=team}
<tr bgcolor="#FFFFFF">
<td><a href="team.php?team_id={$team.id}" target="_blank" title="edit">{$team.id}</a></td>
<td><a href="view.php?team_id={$team.id}" title="view details" >{$team.team}</a></td>
<td class="admin_name">
{foreach from=$team.members name=m item=m}
    {if $m.member_position eq 'hiring coordinator' }<span class="admin_name" >{$m.admin_fname} {$m.admin_lname}</span> {/if}
{/foreach}
</td>
<td class="admin_name">
{foreach from=$team.members name=m item=m}
    {if $m.member_position eq 'head recruiter' }<span class="admin_name">{$m.admin_fname} {$m.admin_lname}</span> {/if}
{/foreach}
</td>
<td class="admin_name">
{foreach from=$team.members name=m item=m}
    {if $m.member_position eq 'recruiter' }<span class="admin_name">{$m.admin_fname} {$m.admin_lname}</span> {/if}
{/foreach}
</td>
<td class="admin_name">
{foreach from=$team.members name=m item=m}
    {if $m.member_position eq 'csro' }<span class="admin_name">{$m.admin_fname} {$m.admin_lname}</span> {/if}
{/foreach}
</td>
</tr>
{/foreach}
</table>



</div>


{literal}
<script>
<!--
//script here
-->
</script>
{/literal}
{ include file="footer.tpl" }