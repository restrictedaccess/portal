{ include file="header.tpl" }

<form name="form" method="post" >

{ include file="users_search_form.tpl" }
<div id="leads_list" counter="{counter start=$counter}" style="background:#BBCCFF;" >
{if $marked_leads_counter}
<div class="list_list_holder"><span style="background:#009900; cursor:pointer;" onclick="toggle('marked_leads_list_div')" title="show/hide">MARKED LEADS</span></div>
<div id="marked_leads_list_div" >
<table id="marked_leads_list_tb" class="leads_list" width="100%" cellpadding="0" cellspacing="1" bgcolor="#cccccc" >

<thead>
<tr >
<th class="sort" mochi:format="number" style="cursor:pointer;">#</th>
<th>ID</th>
<th class="sort" mochi:format="str" style="cursor:pointer;">NAME</th>
<th >INFO</th>
<th class="sort" mochi:format="isodate" style="cursor:pointer;">DATE UPDATED</th>
<th class="sort" mochi:format="isodate" style="cursor:pointer;">REGISTERED DATE</th>
<th >&nbsp;</th>
<th >{$marked_leads_counter} Marked leads found..</th>
</tr>
</thead>
<tfoot class="invisible">
<tr>
<td colspan="0"></td>
</tr>
</tfoot>
<tbody>
{$marked_leads_list}
</tbody>
</table>

</div>
{/if}

<div style="clear:both;background:#BBCCFF; height:20px;">&nbsp;</div>

<div class="list_list_holder">

<span><a name="UNMARKED">UNMARKED LEADS</a> {if $numrows}
[ {$numrows} Records ] <select name='unmarked_list' id='unmarked_list' onchange='setPageNum2(this.value)'  >
{section name=waistsizes start=1 loop=$maxPage  step=1}
<option value="{$smarty.section.waistsizes.index}" {if $pageNum eq $smarty.section.waistsizes.index} selected="selected" {/if}>Page {$smarty.section.waistsizes.index}</option>
{/section}
</select>
{/if}
</span>


</div>
<table id="leads_list_tb" class="leads_list" width="100%" cellpadding="0" cellspacing="1" bgcolor="#cccccc" >

<thead>
<tr >
<th class="sort" mochi:format="number" style="cursor:pointer;">#</th>
<th>ID</th>
<th class="sort" mochi:format="str" style="cursor:pointer;">NAME</th>
<th >INFO</th>
<th class="sort" mochi:format="isodate" style="cursor:pointer;">DATE UPDATED</th>
<th class="sort" mochi:format="isodate" style="cursor:pointer;">REGISTERED DATE</th>
<th >&nbsp;</th>
<th >&nbsp;</th>
</tr>
</thead>
<tfoot class="invisible">
<tr>
<td colspan="0"></td>
</tr>
</tfoot>
<tbody>
{$leads_list}
</tbody>
</table>
</div>


{literal}
<script src="./media/js/sortable_tables.js"></script>
<script src="./media/js/sortable_tables2.js"></script>
<script>
CheckFocus();
if($('marked_leads_list_tb')){
    sortableManager2.initWithTable('marked_leads_list_tb');
}
sortableManager.initWithTable('leads_list_tb');
connect('search', 'onclick', ClearQueryString);

//DATE UPDATE
Calendar.setup({
	inputField     :    "date_updated_start",     // id of the input field
	ifFormat       :    "%Y-%m-%d",      // format of the input field
	button         :    "bd1",          // trigger for the calendar (button ID)
	align          :    "Tl",           // alignment (defaults to "Bl")
	showsTime	   :    false, 
	singleClick    :    true
});  
Calendar.setup({
	inputField     :    "date_updated_end",     // id of the input field
	ifFormat       :    "%Y-%m-%d",      // format of the input field
	button         :    "bd2",          // trigger for the calendar (button ID)
	align          :    "Tl",           // alignment (defaults to "Bl")
	showsTime	   :    false, 
	singleClick    :    true
});

//REGISTER DATE
Calendar.setup({
	inputField     :    "register_date_start",     // id of the input field
	ifFormat       :    "%Y-%m-%d",      // format of the input field
	button         :    "bd3",          // trigger for the calendar (button ID)
	align          :    "Tl",           // alignment (defaults to "Bl")
	showsTime	   :    false, 
	singleClick    :    true
});  
Calendar.setup({
	inputField     :    "register_date_end",     // id of the input field
	ifFormat       :    "%Y-%m-%d",      // format of the input field
	button         :    "bd4",          // trigger for the calendar (button ID)
	align          :    "Tl",           // alignment (defaults to "Bl")
	showsTime	   :    false, 
	singleClick    :    true
});
				
</script>
{/literal}
</form>
{ include file="footer.tpl" } 
