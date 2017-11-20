
function emailCheck (emailStr) {

  /* The following variable tells the rest of the function whether or not
  to verify that the address ends in a two-letter country or well-known
  TLD.  1 means check it, 0 means don't. */

  var checkTLD=1;

  /* The following is the list of known TLDs that an e-mail address must end with. */

  var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;

  /* The following pattern is used to check if the entered e-mail address
  fits the user@domain format.  It also is used to separate the username
  from the domain. */

  var emailPat=/^(.+)@(.+)$/;

  /* The following string represents the pattern for matching all special
  characters.  We don't want to allow special characters in the address. 
  These characters include ( ) < > @ , ; : \ " . [ ] */

  var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";

  /* The following string represents the range of characters allowed in a 
  username or domainname.  It really states which chars aren't allowed.*/

  var validChars="\[^\\s" + specialChars + "\]";

  /* The following pattern applies if the "user" is a quoted string (in
  which case, there are no rules about which characters are allowed
  and which aren't; anything goes).  E.g. "jiminy cricket"@disney.com
  is a legal e-mail address. */

  var quotedUser="(\"[^\"]*\")";

  /* The following pattern applies for domains that are IP addresses,
  rather than symbolic names.  E.g. joe@[123.124.233.4] is a legal
  e-mail address. NOTE: The square brackets are required. */

  var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;

  /* The following string represents an atom (basically a series of non-special characters.) */

  var atom=validChars + '+';

  /* The following string represents one word in the typical username.
  For example, in john.doe@somewhere.com, john and doe are words.
  Basically, a word is either an atom or quoted string. */
  
  var word="(" + atom + "|" + quotedUser + ")";

  // The following pattern describes the structure of the user

  var userPat=new RegExp("^" + word + "(\\." + word + ")*$");

  /* The following pattern describes the structure of a normal symbolic
  domain, as opposed to ipDomainPat, shown above. */

  var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");

  /* Finally, let's start trying to figure out if the supplied address is valid. */

  /* Begin with the coarse pattern to simply break up user@domain into
  different pieces that are easy to analyze. */
  
  var matchArray=emailStr.match(emailPat);

  if (matchArray==null) {

  /* Too many/few @'s or something; basically, this address doesn't
  even fit the general mould of a valid e-mail address. */

  alert("Email address seems incorrect (check @ and .'s)");
  return false;
  }
  var user=matchArray[1];
  var domain=matchArray[2];

  // Start by checking that only basic ASCII characters are in the strings (0-127).

  for (i=0; i<user.length; i++) {
  if (user.charCodeAt(i)>127) {
  alert("Ths username contains invalid characters.");
  return false;
   }
  }
  for (i=0; i<domain.length; i++) {
  if (domain.charCodeAt(i)>127) {
  alert("Ths domain name contains invalid characters.");
  return false;
     }
  }

  // See if "user" is valid 

  if (user.match(userPat)==null) {

  // user is not valid

  alert("The username doesn't seem to be valid.");
  return false;
  }

  /* if the e-mail address is at an IP address (as opposed to a symbolic
  host name) make sure the IP address is valid. */

  var IPArray=domain.match(ipDomainPat);
  if (IPArray!=null) {

  // this is an IP address

  for (var i=1;i<=4;i++) {
  if (IPArray[i]>255) {
  alert("Destination IP address is invalid!");
  return false;
     }
  }
  return true;
  }

  // Domain is symbolic name.  Check if it's valid.
 
  var atomPat=new RegExp("^" + atom + "$");
  var domArr=domain.split(".");
  var len=domArr.length;
  for (i=0;i<len;i++) {
  if (domArr[i].search(atomPat)==-1) {
  alert("The domain name does not seem to be valid.");
  return false;
     }
  }

  /* domain name seems valid, but now make sure that it ends in a
  known top-level domain (like com, edu, gov) or a two-letter word,
  representing country (uk, nl), and that there's a hostname preceding 
  the domain or country. */
  
  if (checkTLD && domArr[domArr.length-1].length!=2 && 
  domArr[domArr.length-1].search(knownDomsPat)==-1) {
  alert("The address must end in a well-known domain or two letter " + "country.");
  return false;
  }

  // Make sure there's a host name preceding the domain.

  if (len<2) {
  alert("This address is missing a hostname!");
  return false;
  }

  // If we've gotten this far, everything's valid!
  return true;
}

function IsNumeric(sText)
{
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
    }
   return IsNumber;
}

function checkDate(fld) {
    var mo, day, yr;
    var entry = fld.value;
    var reLong = /\b\d{1,2}[\/-]\d{1,2}[\/-]\d{4}\b/;
    var reShort = /\b\d{1,2}[\/-]\d{1,2}[\/-]\d{2}\b/;
    var valid = (reLong.test(entry)) || (reShort.test(entry));
    if (valid) {
        var delimChar = (entry.indexOf("/") != -1) ? "/" : "-";
        var delim1 = entry.indexOf(delimChar);
        var delim2 = entry.lastIndexOf(delimChar);
        mo = parseInt(entry.substring(0, delim1), 10);
        day = parseInt(entry.substring(delim1+1, delim2), 10);
        yr = parseInt(entry.substring(delim2+1), 10);
        // handle two-digit year
        if (yr < 100) {
            var today = new Date( );
            // get current century floor (e.g., 2000)
            var currCent = parseInt(today.getFullYear( ) / 100) * 100;
            // two digits up to this year + 15 expands to current century
            var threshold = (today.getFullYear( ) + 15) - currCent;
            if (yr > threshold) {
                yr += currCent - 100;
            } else {
                yr += currCent;
            }
        }
        var testDate = new Date(yr, mo-1, day);
        if (testDate.getDate( ) == day) {
            if (testDate.getMonth( ) + 1 == mo) {
                if (testDate.getFullYear( ) == yr) {
                    // fill field with database-friendly format
                    fld.value = mo + "/" + day + "/" + yr;
                    return true;
                } else {
                    alert("There is a problem with the year entry.");
                }
            } else {
                alert("There is a problem with the month entry.");
            }
        } else {
            alert("There is a problem with the date entry.");
        }
    } else {
        alert("Incorrect date format. Enter as mm/dd/yyyy.");
    }
    return false;
}