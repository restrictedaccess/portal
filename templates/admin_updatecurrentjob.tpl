<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{ $applicant_data.fname } { $applicant_data.lname }'s Profile ({ $applicant_data.userid })</title>
</head>
<body>
    <form method="POST" accept-charset="utf-8">
        <input type="hidden" name="userid" value="{ $userid }"/>
        <div style="font-weight: bold; background: #eeeeee; padding: 4px; ">
            Fill in this section to give employers a snapshot of the applicants profile.
        </div>
        <div style="border: 1px solid #dee5eb; padding-bottom: 8px; margin-top: 8px;">
            <div style="background: #dee5eb; font-weight: bold; margin-bottom: 8px;">
                Current Status:
            </div>
            <input type="radio" name="freshgrad" value="2" id="freshgrad_2" 
                { if $currentjob.freshgrad eq 2}checked="checked"{ /if }/>
            <label for="freshgrad_2">I am still pursuing my studies and seeking internship or part-time jobs</label>
            <br/>
            <input type="radio" name="freshgrad" value="1" id="freshgrad_1"
                { if $currentjob.freshgrad eq 1}checked="checked"{ /if }/>
            <label for="freshgrad_1">I am a fresh graduate seeking my first job</label>
            <br/>
            <input type="radio" name="freshgrad" value="0" id="freshgrad_0"
                { if $currentjob.freshgrad eq 0}checked="checked"{ /if }/>
            <label for="freshgrad_0">I have been working for 
                <select name="years_worked">
                    {section name=years loop=17}
                        <option value="{ $smarty.section.years.index }"
                            { if $smarty.section.years.index eq $currentjob.years_worked } 
                                selected="selected"
                            { /if }>
                            { $smarty.section.years.index }
                        </option>
                    {/section}
                </select>
                year(s) and 
                <select name="months_worked">
                    {section name=months loop=12}
                        <option value="{$smarty.section.months.index}"
                            { if $smarty.section.months.index eq $currentjob.months_worked } 
                                selected="selected"
                            { /if }>
                            {$smarty.section.months.index}
                        </option>
                    {/section}
                </select>
                month(s)</label>
        </div>
        <div style="border: 1px solid #dee5eb; padding-bottom: 8px; margin-top: 8px;">
            <div style="background: #dee5eb; font-weight: bold; margin-bottom: 8px;">
                 Current / Latest Job Title
            </div>
            Title: <input type="text" maxLength=100 name="latest_job_title" value="{ $currentjob.latest_job_title } " style="width:480px;"/>
        </div>
        <div style="border: 1px solid #dee5eb; margin-top: 8px;">
            <div style="background: #dee5eb; font-weight: bold; padding-bottom: 2px;">
                Current Job (SKIP if applicant has no working experience)
            </div>
            {section name=company loop=10}
            <div style="padding: 12px; background:{ cycle values="#eeeeee,#d0d0d0"};">
                <div>Company Name: { $smarty.section.company.iteration }</div>
                {if $smarty.section.company.iteration eq 1}
                    { assign var="companyname" value="companyname"}
                {else}
                    { assign var="companyname" value="companyname`$smarty.section.company.iteration`"}
                {/if}
                <input type="text" name="{$companyname}" value="{$currentjob.$companyname}" style="width:480px;"/>

                <div>Position / Title:</div>
                {if $smarty.section.company.iteration eq 1}
                    { assign var="position" value="position"}
                {else}
                    { assign var="position" value="position`$smarty.section.company.iteration`"}
                {/if}
                <input type="text" name="{$position}" value="{$currentjob.$position}" style="width:480px;"/>

                <div>Employment Period:</div>
                {if $smarty.section.company.iteration eq 1}
                    { assign var="monthfrom" value="monthfrom" }
                    { assign var="yearfrom" value="yearfrom" }
                    { assign var="monthto" value="monthto" }
                    { assign var="yearto" value="yearto" }
                {else}
                    { assign var="monthfrom" value="monthfrom`$smarty.section.company.iteration`" }
                    { assign var="yearfrom" value="yearfrom`$smarty.section.company.iteration`" }
                    { assign var="monthto" value="monthto`$smarty.section.company.iteration`" }
                    { assign var="yearto" value="yearto`$smarty.section.company.iteration`" }
                {/if}

                <select name="{ $monthfrom }">
                    { foreach from=$month_array item=month}
                        { if $month ne 'Current Month'}
                            <option value="{ $month }"
                                { if $currentjob.$monthfrom eq $month}
                                    selected="selected"
                                { /if }
                            >
                                { $month }
                            </option>
                        { /if }
                    { /foreach }
                </select>

                <select name="{ $yearfrom }">
                    <option value=""></option>
                    { section name=year loop=$current_year max=80 step=-1}
                        <option value="{ $smarty.section.year.index }"
                            { if $smarty.section.year.index eq $currentjob.$yearfrom }
                                selected="selected"
                            { /if }
                        >
                            { $smarty.section.year.index }
                        </option>
                    { /section }
                </select>

                <select name="{ $monthto }">
                    { foreach from=$month_array item=month}
                        <option value="{ $month }"
                            { if $currentjob.$monthto eq $month}
                                selected="selected"
                            { /if }
                            { if $currentjob.$monthto|substr:0:7 eq $month|substr:0:7}
                                selected="selected"
                            { /if }
                        >
                            { $month }
                        </option>
                    { /foreach }
                </select>

                <select name="{ $yearto }">
                    <option value=""></option>
                    <option value="Current Year"
                        { if $currentjob.$yearto|substr:0:7 eq 'Current' }
                            selected="selected"
                        { /if }
                    >
                        Current Year
                    </option>
                    { section name=year loop=$current_year max=80 step=-1}
                        <option value="{ $smarty.section.year.index }"
                            { if $smarty.section.year.index eq $currentjob.$yearto }
                                selected="selected"
                            { /if }
                        >
                            { $smarty.section.year.index }
                        </option>
                    { /section }
                </select>

                <div>Responsibilities / Achievements:</div>
                {if $smarty.section.company.iteration eq 1}
                    { assign var="duties" value="duties" }
                {else}
                    { assign var="duties" value="duties`$smarty.section.company.iteration`" }
                {/if}
                {strip}
                    <textarea name="{ $duties }" style="width:480px; height: 140px;">
                        { $currentjob.$duties }
                    </textarea>
                {/strip}
            </div>
            {/section}
        </div>
        <div style="border: 1px solid #dee5eb; padding-bottom: 8px; margin-top: 8px;">
            <div style="background: #dee5eb; font-weight: bold; margin-bottom: 8px;">
                Availability Status:
            </div>
            <input type="radio" name="available_status" value="a" id="available_status_a" 
            { if $currentjob.available_status eq 'a'}
                checked="checked"
            { /if }
            />
            <label for="available_status_a">I can start work after </label>
            { strip }
            <select name="available_notice">
                <option value=""></option>
                { section name=available_notice loop=12 }
                    <option value="{ $smarty.section.available_notice.index }"
                        { if $smarty.section.available_notice.index eq $currentjob.available_notice}
                            selected="selected"
                        { /if }
                    >
                        { $smarty.section.available_notice.index }
                    </option>
                { /section }
            </select>
            { /strip }
            week(s) of notice period
            <br/>

            <input type="radio" name="available_status" value="b" id="available_status_b" 
            { if $currentjob.available_status eq 'b'}
                checked="checked"
            { /if }
            />
            <label for="available_status_b">
                I can start work after 
            </label>
            <select name="aday">
                <option value=""></option>
                { section name=aday loop=31 }
                    <option value="{ $smarty.section.aday.iteration }"
                        { if $smarty.section.aday.iteration eq $currentjob.aday }
                            selected="selected"
                        { /if }
                    >
                        { $smarty.section.aday.iteration }
                    </option>
                { /section }
            </select>
            - 
            <select name="amonth">
                <option value=""></option>
                { section name=month loop=12 }
                    { assign var="month_date" value="`$current_year`-`$smarty.section.month.iteration`-01"}
                    <option value="{ $month_date|date_format:"%B" }"
                        { if $month_date|date_format:"%B" eq $currentjob.amonth }
                            selected="selected"
                        { /if }
                    >
                        { $month_date|date_format:"%B" }
                    </option>
                { /section }
            </select>
            - 
            <input type=text name="ayear" size=4 maxlength=4 style='width=50px' value='{ $currentjob.ayear }'/>
            (YYYY)
            <br/>

            <input type="radio" name="available_status" value="p" id="available_status_p" 
            { if $currentjob.available_status eq 'p'}
                checked="checked"
            { /if }
            />
            <label for="available_status_p">I am not actively looking for a job now</label>
            <br/>

            <input type="radio" name="available_status" value="Work Immediately" id="available_status_work_immediate" 
            { if $currentjob.available_status eq 'Work Immediately'}
                checked="checked"
            { /if }
            />
            <label for="available_status_work_immediate">Work Immediately</label>
            <br/>

        </div>
        <div style="border: 1px solid #dee5eb; padding-bottom: 8px; margin-top: 8px;">
            <div style="background: #dee5eb; font-weight: bold; margin-bottom: 8px;">
                Expected Salary (Optional)
            </div>
            Expected Monthly Salary :
            <select name="salary_currency">
                <option value=""></option>
                { foreach from=$currency_array item=currency }
                    <option value="{ $currency }"
                        { if $currentjob.salary_currency eq $currency }
                        selected="selected"
                        { /if }
                    >
                        { $currency }
                    </option>
                { /foreach }
            </select>
            <input type="text" name="expected_salary" maxlength="15" 
                size="16" value="{ $currentjob.expected_salary }"/>
            <input type="checkbox" value="Yes" name="expected_salary_neg" id="expected_salary_neg"
                { if $currentjob.expected_salary_neg eq "Yes"}
                    checked="checked"
                { /if }
            > 
            <label for="expected_salary_neg">
                Negotiable
            </label>
        </div>


        <div style="text-align: center; padding-top: 8px;">
            <input type="submit" value="Update" style="width: 120px; font-weight: bold;"/>
        </div>
    </form>
</body>
<script type="text/javascript" src="media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>	
{ literal }
<script type="text/javascript">
tinyMCE.init({
    mode : "textareas",

    theme : "simple",
});
</script>
{ /literal }

</html>
