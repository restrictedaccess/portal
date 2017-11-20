<!--

function isEmpty(objField)
{
   if (objField.value == null || objField.value.length == 0 || objField.value == "")
   { return true;  }
   else
   {
        var limit = objField.value.length;
        var ch = "";
        var tempValue = "";
        for (var ctr = 0; ctr <= limit; ctr++)
        {
            ch = objField.value.charAt(ctr);
            if (ch != " ") {tempValue += ch}
        }
        if (tempValue.length > 0) { return false; }
        else { return true; }
   }
}


function isEmail(objField)
{
   var limit = objField.value.length;
   var ch = "";
   var atCtr = 0;
   var dotCtr = 0;
   for (var ctr =0; ctr <= limit; ++ctr)
   {
      ch = objField.value.charAt(ctr);
      if (ch == "@") 
      { 
         atCtr++; 
      }
      else if (ch == ".") 
      { 
         dotCtr++; 
      }
   }
   if (atCtr != 1 || dotCtr < 1) 
   { 
      return false;
   }
   return true;
}


function validate_response_fields(form_name)
{
   var errMsg = "";
   var swErr = false;
   var elem = document.getElementById(form_name);

   if (isEmpty(elem.name)) { errMsg += "\n- Name "; }
   
   if (isEmpty(elem.email) || !isEmail(elem.email))
   { errMsg += "\n- Valid e-mail address\n(In case we need to contact you)"; }

   
   if (isEmpty(elem.location))
   { errMsg += "\n- Location "; }

   if (elem.message.value == "" || elem.message.length == 0)
   { 
      errMsg += "\n- Response "; 
   } 

   if (errMsg == "") { return true; }
   else 
   { 
      alert ("Please enter the following field(s): \n"+errMsg); 
      return false;
   }
}



function fieldValidate(swLocation, swTestimony)
{
   var errMsg = "";
   var swErr = false;

   if (isEmpty(document.frmMail.name)) { errMsg += "\n- Name "; }
   
   if (isEmpty(document.frmMail.email) || !isEmail(document.frmMail.email))
   { errMsg += "\n- Valid e-mail address\n(In case we need to contact you)"; }

   
   if (swLocation)
   {
      if (isEmpty(document.frmMail.location))
      { errMsg += "\n- Location "; }
   }

   // Not sent to isEmpty() - value might be too long
   
   if (document.frmMail.message.value == "" || document.frmMail.message.length == 0)
   { 
      if (swTestimony) { errMsg += "\n- Testimony "; }
      else { errMsg += "\n- Message "; }
   } 
   
   if (errMsg == "") { return true; }
   else 
   { 
      alert ("Please enter the following field(s): \n"+errMsg); 
      return false;
   }
}


function check_events_time(l_event_type)
{
   var error_msg = "";
   
   if (l_event_type != "other")
   {
      // IF EVENT TYPE IS NOT "OTHER" - TIME SHOULD BE ENTERED
      if (document.frmMail.sel_start_hour.value == "") 
      {
         error_msg += "\n- Start time";
      }
      else
      {
         if (document.frmMail.sel_start_min.value == "")
         { document.frmMail.sel_start_min.value = "00";}
      }
      
   }
   // CHECK IF END TIME IS ENTERED
   if (document.frmMail.sel_end_hour.value != "")
   {
      if (document.frmMail.sel_end_min.value == "") 
      {
         document.frmMail.sel_end_min.value = "00";
      }

      // IF BOTH AM OR PM -- END TIME SHOULD BE >= START TIME 
      if ((document.frmMail.sel_start_ampm.value == document.frmMail.sel_end_ampm.value) && (document.frmMail.sel_start_hour.value > document.frmMail.sel_end_hour.value))
      {
         error_msg += "\n- Invalid start and end times";
      }
      else if ((document.frmMail.sel_start_ampm.value == document.frmMail.sel_end_ampm.value) && (document.frmMail.sel_start_hour.value == document.frmMail.sel_end_hour.value) && (document.frmMail.sel_start_min.value > document.frmMail.sel_end_min.value))
      {
            error_msg += "\n- Invalid start and end times";
      }
   }
   else
   {
      if (document.frmMail.sel_end_min.value != "")
      {
         error_msg += "\n Invalid start and end times";
      }
   }
      
   return error_msg;
}


function events_fields_check()
{
   var error_msg = "";
   var today = new Date();
   var start_date = new Date();
   var end_date = new Date();
   var timecheck_ind = false;   
   
   // CHECK IF NAME IS EMPTY
   if (isEmpty(document.frmMail.name))
   {
      error_msg +="\n- Name";
   }


   // CHECK IF LOCATION IS EMPTY
   if (isEmpty(document.frmMail.location))
   {
      error_msg +="\n- Location";
   }

   // CHECK IF E-MAIL IS EMPTY OR CORRECT FORMAT
   if (isEmpty(document.frmMail.email) || !isEmail(document.frmMail.email))
   {
      error_msg +="\n- Valid e-mail address \n(In case we need to contact you)";
   }
   

   // CHECK IF TITLE IS EMPTY
   if (isEmpty(document.frmMail.event_title))
   {
      error_msg +="\n- Title";
   }
   
   // IF EVENT TYPE IS NOT SET TO OTHER, VENUE SHOULD NOT BE EMPTY
   if (document.frmMail.event_type.value != "other")
   {
      if (isEmpty(document.frmMail.event_venue))
      {
         error_msg += "\n- Venue and address";
      }
      
      error_msg += check_events_time(document.frmMail.event_type.value);
      timecheck_ind = true;
   }
   
   // VALIDATE START DATE
   if ((document.frmMail.sel_start_month.value != "") && (document.frmMail.sel_start_day.value != "") && (document.frmMail.sel_start_year.value != ""))
   {
      start_date = new Date(document.frmMail.sel_start_year.value, (document.frmMail.sel_start_month.value - 1), document.frmMail.sel_start_day.value);
      
      // CHECK IF DATE IS VALID, E.G. NOT FEB. 31
      if (start_date.getDate() != document.frmMail.sel_start_day.value) 
      {
         error_msg += "\n- Invalid start date";
      }
      //CHECK IF DATE HAS NOT EXPIRED
      else if (start_date.valueOf() < today.valueOf())
      {
         error_msg += "\n- Expired start date \n(Enter a future date)"
      }
   }
   else
   {
      error_msg += "\n- Start date";
   }

   
   // VALIDATE END DATE
   if ((document.frmMail.sel_end_month.value != "") && (document.frmMail.sel_end_day.value != "") && (document.frmMail.sel_end_year.value != ""))
   {
      end_date = new Date(document.frmMail.sel_end_year.value, (document.frmMail.sel_end_month.value - 1), document.frmMail.sel_end_day.value);
      // CHECK IF DATE IS VALID, E.G. NOT FEB. 31
      if (end_date.getDate() != document.frmMail.sel_end_day.value)
      {
         error_msg += "\n- Invalid end date";
      }
      // COMPARE START AND END DATE -- END DATE SHOULD BE LATER
      else if (start_date.valueOf() > end_date.valueOf())
      {
         error_msg += "\n- Invalid end date \n(Enter a date later than start date)";
      }
      else if (start_date.valueOf() <= end_date.valueOf())
      {
         $count_days = 0;
         $count_days = (end_date.valueOf() - start_date.valueOf())/60/60/24/1000;
         //alert ("End date: "+end_date.valueOf()+"\nStart date: "+start_date.valueOf()+"\nDiff: "+$count_days);
         document.frmMail.duration.value = $count_days + 1;
      }
   }
   
   if (timecheck_ind == false)
   {
      error_msg += check_events_time(document.frmMail.event_type.value);
      timecheck_ind = true;
   }
   
   // END OF FIELD VALIDATION -- RETURN TRUE OR FALSE
   if (error_msg == "")
   { return true; }
   else
   { 
      alert ("Please enter or double check \nthe following field(s):\n" + error_msg); 
      return false;
   }

}
   

//-->