{*
2010-07-17  Normaneil Macutay <normanm@remotestaff.com.au>

*}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
{include file = "head.tpl"}
<body class="sub-bg" id="registernow">

<div id="container" >


{include file="header.tpl"}
<!--  End of Header -->
<!-- End of Navigation -->
{php}include("inc/nav.php"){/php}  

<div id="main-image" style="height:30px;"></div>
<!-- End of Main Image -->

<div id="contents" >

{include file="register-left-menu.tpl"}
<div id="applynow" >
<div align="right">{$welcome}</div>
{if $userid eq ""}
{include file="email-validation-form.tpl"}
<div class="shodow_out" style="height:1780px;">&nbsp;</div>
{/if}

{if $error eq False}
	<div class="error_msg">{$error_msg}</div>
{/if}


<form name="form" method="post" action="register/register-step4.php">
<input type="hidden" name="page" value="{$page}" />
<input type="hidden" name="form_id" id="form_id" value="{$form_id}" />


<p><strong>Fill in this section to give employers a snapshot of your profile. </strong></p> 
<h2>Current Status</h2>
<div id="fieldcontents">
<table border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="50" align="right"><input type="radio" name="current_status" value="still studying" {$still_studying_selected}/></td>
<td width="450">I am still pursuing my studies and seeking internship or part-time jobs</td>
</tr>
<tr>
<td width="50" align="right"><input type="radio" name="current_status" value="fresh graduate" {$fresh_graduate_selected}/></td>
<td width="450">I am a fresh graduate seeking my first job</td>
</tr>
<tr>
  <td width="50" align="right"><input type="radio" name="current_status" value="experienced" {$experienced_selected}/></td>
  <td width="450">I have been working for
 <select name="years_worked" id="years_worked" style="width:40px;" class="text">
	{$years_worked_options}
 </select>
&nbsp;year(s)
 <select name="months_worked" id="months_worked" style="width:40px;" class="text">
	{$months_worked_options}
 </select>
 &nbsp;month(s)</td>
</tr>
</table>
</div>

<h2>Expected Salary</h2>
<div id="fieldcontents">
<table style="width:600px;" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="150" align="right">Expected Monthly Salary:</td>
<td width="450">&nbsp;&nbsp;
  <input type="checkbox" value="Yes" name="expected_salary_neg" {$is_negotiable} />
  Negotiable 
  <input type="text" class="text" name="expected_salary"  id="expected_salary" maxlength="15" size="16" value="{$expected_salary}" />
  <select name="salary_currency" id="salary_currency" style="font:8pt, Verdana" >  
	{$salary_currency_options}
</select>&nbsp;&nbsp;</td>
</tr>
</table>
</div>


<h2>Current/latest Job Title</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="200" align="right">Position:</td>
<td width="300"><input name="latest_job_title" type="text" id="latest_job_title" size="35" value="{$latest_job_title}"/></td>
</tr>
</table>
</div>

<!--
<h2><strong>Current Job</strong></h2>
<div id="fieldcontents">
<p><em><strong>SKIP if you have no working experience</strong></em></p>
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="200" align="right">Company Name:</td>
<td width="300"><input name="current_company_name" type="text" id="current_company_name" size="35" /></td>
</tr>
<tr>
  <td align="right">Position Title:</td>
  <td><input name="current_position" type="text" id="current_position" size="35" /></td>
</tr>
<tr>
  <td align="right">Employment Period</td>
  <td><select name="current_monthfrom">
                <option value="JAN">JAN </option>
                <option value="FEB">FEB </option>
                <option selected="selected" value="MAR">MAR </option>
                <option value="APR">APR </option>
                <option value="MAY">MAY </option>
                <option value="JUN">JUN </option>

                <option value="JUL">JUL </option>
                <option value="AUG">AUG </option>
                <option value="SEP">SEP </option>
                <option value="OCT">OCT </option>
                <option value="NOV">NOV </option>
                <option value="DEC">DEC </option>

              </select>
			  <select name="current_yearfrom" >
                  <option value="2010">2010 </option>
				  <option value="2009" selected>2009 </option>
				  <option value="2008">2008 </option>
				  <option value="2008">2008 </option>
                  <option value="2007">2007 </option>

                  <option value="2006">2006 </option>
                  <option value="2005">2005 </option>
                  <option value="2004">2004 </option>
                  <option value="2003">2003 </option>
                  <option value="2002">2002 </option>
                  <option value="2001">2001 </option>

                  <option value="2000">2000 </option>
                  <option value="1999">1999 </option>
                  <option value="1998">1998 </option>
                  <option value="1997">1997 </option>
                  <option value="1996">1996 </option>
                  <option value="1995">1995 </option>

                  <option value="1994">1994 </option>
                  <option value="1993">1993 </option>
                  <option value="1992">1992 </option>
                  <option value="1991">1991 </option>
                  <option value="1990">1990 </option>
                  <option value="1989">1989 </option>

                  <option value="1988">1988 </option>
                  <option value="1987">1987 </option>
                  <option value="1986">1986 </option>
                  <option value="1985">1985 </option>
                  <option value="1984">1984 </option>
                  <option value="1983">1983 </option>

                  <option value="1982">1982 </option>
                  <option value="1981">1981 </option>
                  <option value="1980">1980 </option>
                  <option value="1979">1979 </option>
                  <option value="1978">1978 </option>
                  <option value="1977">1977 </option>

                  <option value="1976">1976 </option>
                  <option value="1975">1975 </option>
                  <option value="1974">1974 </option>
                  <option value="1973">1973 </option>
                  <option value="1972">1972 </option>
                  <option value="1971">1971 </option>

                  <option value="1970">1970 </option>
                  <option value="1969">1969 </option>
                  <option value="1968">1968 </option>
                  <option value="1967">1967 </option>
                  <option value="1966">1966 </option>
                  <option value="1965">1965 </option>

                  <option value="1964">1964 </option>
                  <option value="1963">1963 </option>
                  <option value="1962">1962 </option>
                  <option value="1961">1961 </option>
                  <option value="1960">1960 </option>
                  <option value="1959">1959 </option>

                  <option value="1958">1958 </option>
                  <option value="1957">1957 </option>
                  <option value="1956">1956 </option>
                  <option value="1955">1955 </option>
                  <option value="1954">1954 </option>
                  <option value="1953">1953 </option>

                  <option value="1952">1952 </option>
                  <option value="1951">1951 </option>
                  <option value="1950">1950 </option>
              </select>
			  <select name="current monthto" >
                <option value="JAN">JAN </option>
                <option value="FEB">FEB </option>

                <option value="MAR">MAR </option>
                <option value="APR">APR </option>
                <option value="MAY">MAY </option>
                <option value="JUN">JUN </option>
                <option value="JUL">JUL </option>
                <option value="AUG">AUG </option>

                <option value="SEP">SEP </option>
                <option value="OCT">OCT </option>
                <option value="NOV">NOV </option>
                <option value="DEC">DEC </option>
              </select>
			  <select name="current_yearto" >
                <option value="2010">2010 </option>

				<option value="2009" selected>2009 </option>
                <option value="2008">2008 </option>
                <option value="2007">2007 </option>
                <option value="2006">2006 </option>
                <option value="2005">2005 </option>
                <option value="2004">2004 </option>

                <option value="2003">2003 </option>
                <option value="2002">2002 </option>
                <option value="2001">2001 </option>
                <option value="2000">2000 </option>
                <option value="1999">1999 </option>
                <option value="1998">1998 </option>

                <option value="1997">1997 </option>
                <option value="1996">1996 </option>
                <option value="1995">1995 </option>
                <option value="1994">1994 </option>
                <option value="1993">1993 </option>
                <option value="1992">1992 </option>

                <option value="1991">1991 </option>
                <option value="1990">1990 </option>
                <option value="1989">1989 </option>
                <option value="1988">1988 </option>
                <option value="1987">1987 </option>
                <option value="1986">1986 </option>

                <option value="1985">1985 </option>
                <option value="1984">1984 </option>
                <option value="1983">1983 </option>
                <option value="1982">1982 </option>
                <option value="1981">1981 </option>
                <option value="1980">1980 </option>

                <option value="1979">1979 </option>
                <option value="1978">1978 </option>
                <option value="1977">1977 </option>
                <option value="1976">1976 </option>
                <option value="1975">1975 </option>
                <option value="1974">1974 </option>

                <option value="1973">1973 </option>
                <option value="1972">1972 </option>
                <option value="1971">1971 </option>
                <option value="1970">1970 </option>
                <option value="1969">1969 </option>
                <option value="1968">1968 </option>

                <option value="1967">1967 </option>
                <option value="1966">1966 </option>
                <option value="1965">1965 </option>
                <option value="1964">1964 </option>
                <option value="1963">1963 </option>
                <option value="1962">1962 </option>

                <option value="1961">1961 </option>
                <option value="1960">1960 </option>
                <option value="1959">1959 </option>
                <option value="1958">1958 </option>
                <option value="1957">1957 </option>
                <option value="1956">1956 </option>

                <option value="1955">1955 </option>
                <option value="1954">1954 </option>
                <option value="1953">1953 </option>
                <option value="1952">1952 </option>
                <option value="1951">1951 </option>
                <option value="1950">1950 </option>

              </select>
</td>
</tr>
<tr>
  <td align="right" valign="top">Responsibilities Achievement</td>
  <td><textarea name="current_responsibilities" cols="35" rows="7" id="current_responsibilities"></textarea></td>
</tr>
</table>

</div>
-->  
<h2><strong>Work History</strong></h2>
<div id="fieldcontents">
<div id="resultarea" >
	{$history_HTML}	
	<br />
</div>
<p align="center"><strong><span style="color:red;cursor:pointer;text-decoration:underline;" onclick="form.action='register/register-step4-expand.php';document.form.submit();" <!--onclick="expandWorkHistory()"--> >Click Here to add more work history</span></strong></p> 
</div>

<h2>Position Desired</h2>
<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
<td width="200" align="right" valign="top">First Choice:</td>
<td width="300"><select name="position_first_choice" id="position_first_choice">
<option value="" selected="selected">Select Position </option>
	{$position_first_choice_options}
</select>
  <br />
  <span class="smalltext">any experience doing this role?  {$position_first_choice_exp_options} </span> <br /></td>
</tr>
<tr>
  <td align="right" valign="top">Second Choice: </td>
  <td><select name="position_second_choice" id="position_second_choice">
	{$position_second_choice_options}
  </select>
  <br />
  <span class="smalltext">any experience doing this role?  {$position_second_choice_exp_options} </span> <br />
  
  </td>
</tr>
<tr>
  <td align="right" valign="top">Third Choice:</td>
  <td><select name="position_third_choice" id="position_third_choice">
	{$position_third_choice_options}
  </select>
  <br />
  <span class="smalltext">any experience doing this role?   {$position_third_choice_exp_options} </span> <br />
  </td>
</tr>
<tr>
  <td align="right">Others:</td>
  <td><input name="others" type="text" id="others" size="35" /></td>
</tr>
</table>
</div>




<div id="fieldcontents">
<table width="500" border="0" cellspacing="0" cellpadding="0" id="applyform">
<tr>
  <!--<td width="500" align="right" style="border:0;">&nbsp;&nbsp;<a href="registernow-step5-skills-details.php"><img src="images/btn-clicksavenext.png" width="200" height="40" border="0" /></a></td>-->
	<input type="image" src="images/btn-clicksavenext.png" width="200" height="40" border="0" onclick="expandForm=false;document.form.submit();"   />
  </tr>
</table>
</div>



</form>
</div>




</div>
<!-- End of Content Box  -->

<div id="contents" style="clear:both">
</div>
<!-- End of Left Contents -->
<!-- End of Main Contents -->
<!-- End of Right Contents -->
</div>
<!-- End of Content Box  -->



</div><!-- End of Container -->
<p>&nbsp;</p>
<p>&nbsp;</p>
{php}include("inc/footer.php"){/php} 
</body>
</html>
