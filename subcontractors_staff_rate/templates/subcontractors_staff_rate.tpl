<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $title}{$title}{else}Subcontractors Staff Rate{/if}</title>
<link rel=stylesheet type=text/css href="./media/css/subcontractors_staff_rate.css">

</head>

<body>
<form name="form" method="post" >
<div align="center"><h2>
{$numrows} (<em>"active", "suspended", "terminated", "resigned"</em>) staff contracts found.<br />
Page {$pageNum} of {$maxPage}<br /></h2>
Showing {$rowsPerPage} per page.<br />
</div>
<div class='pagination'>
<ul>{$paging}</ul>
<br clear="all" />
<input type="submit" name="submit" value="save staff rates" />
</div>

<ol start="{$offset}">
    {foreach from=$SUBCONS name=subcon item=subcon}
    <li style="border-bottom:#CCC solid 1px; margin-bottom:10px;"><input type="hidden" name="subconid[]" value="{$subcon.subcon.id}" />
        <a href="../contractForm.php?sid={$subcon.subcon.id}" target="_blank">#{$subcon.subcon.id}</a>
        {$subcon.personal.fname} {$subcon.personal.lname} 
        <ol>{if $subcon.staff_rate}<strong>Recorded Staff Rates</strong>{else}Salary updates history{/if}
            {foreach from=$subcon.staff_rates name=staff_rate item=staff_rate}
                <li>{$staff_rate.start_date|date_format} - {$staff_rate.work_status} {$staff_rate.rate}</li>  
                {foreachelse}
                    None    
            {/foreach}
        </ol>
    </li>
    {/foreach}
</ol>


<div class='pagination'>
<ul>{$paging}</ul>
<br clear="all" />
<input type="submit" name="submit" value="save staff rates" />
</div>

</form>
</body>
</html>
