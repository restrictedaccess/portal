<input type="hidden" name="client_prepaid" id="client_prepaid" value="{$prepaid}" />
<input type="hidden" name="currency_code" id="currency_code" value="{$currency_code}" />
<table cellpadding=1 cellspacing=0 border=0 width=100%>

<tr class="tb_hdr" >

<td width="3%" class="tb_td_hdr">#</td>

<td width="2%" class="tb_td_hdr"></td>

<td width="37%" class="tb_td_hdr">TITLE</td>

<td width="15%" class="tb_td_hdr">OUTSOURCING MODEL</td>

<td width="14%" class="tb_td_hdr">DATE CREATED</td>

<td width="18%" class="tb_td_hdr">STATUS</td>

</tr>

{section name=j loop=$result}

	



    <tr bgcolor="{cycle values='#EEEEEE,#CCFFCC'}">

       <td>{$smarty.section.j.iteration} )</td>

	   <td>

	   {if $posting_id eq $result[j].id }

	     	   <input type="radio" name="ads" checked="checked" value="{$result[j].id}"/>

	   {else}	

			   <input type="radio" name="ads" value="{$result[j].id}"/>

	   {/if}	

	   </td>

	   

	   <td><a href='ads.php?id={$result[j].id}' target='_blank' >{$result[j].jobposition}</a></td>

	   <td>{$result[j].outsourcing_model}</td>

	    <td>{$result[j].date_created}</td>

		<td>{$result[j].status}</td>

    </tr>

{sectionelse}

<tr><td colspan="6" align="center"><br><b>No Ads to be shown </b> <br> </td></tr>

{/section}

   

</table> 

