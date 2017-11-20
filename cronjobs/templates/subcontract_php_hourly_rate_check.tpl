{*  
    2011-01-24 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   email template for the contract monitoring
*}

<h3>Daily Hourly Contract Monitoring</h3>
<table style="font-family:Verdana; font-size:12px;">
    <tr style="font-size:14px;color:#0000AA;">
        <td><b>Contract ID:</b></td><td><b>Staff:</b></td><td><b>Client:</b></td><td><b>Issue:</b></td>
    </tr>
{section name=i loop=$contracts_in_question}
    <tr bgcolor="{cycle values="#FFFFCC,#FFFFEE"}">
        <td>{$contracts_in_question[i].contract_id}</td>
        <td>{$contracts_in_question[i].staff}</td>
        <td>{$contracts_in_question[i].client}</td>
        <td>{$contracts_in_question[i].issue}</td>
    </tr>
{/section}
</table>
