<!--
function AddRecord(ctlFrom, ctlTo, ctlSelectedString, intMaxAllow) {
	if (GetValueFromCtl(ctlFrom) == "") {
		alert("Please select an item from the selection list and click on [Add].");	
		return false;
	}

	if (ctlTo.options.length > (intMaxAllow - 1)){
		alert("Please DO NOT select more than " + intMaxAllow + " Items");
		return false;
	}

	if (ctlSelectedString.value == "") {
		BumpUp(ctlTo);				
	}
		
	var no = new Option;
	no.value = BuildRecordString(ctlFrom);
	no.text = BuildSelectedString(ctlFrom, ctlTo);
	   
	if (SetToRecordsString (ctlSelectedString, no.value)) {
		mblnIsDirty = true;
		ctlTo.options[ctlTo.options.length] = no;
	}

//alert(ctlSelectedString.value);
	return false;
}

function DeleteRecord(ctlFrom, ctlSelectedString) {
	var strRemovedRecord = "";
	var n = 0;

	listing = ctlFrom;

	// exit if there's nothing to remove
	if (listing.options.length == 0)
		return false;

	txtSelectedString = ctlSelectedString

	// don't remove the no records string
	if (listing.options[0].value != "-1")
		strRemovedRecord = RemoveItem(listing, txtSelectedString);
	
	if (strRemovedRecord.length > 0)
		mblnIsDirty = true;

//	if (from_control == 1 ? msg = "[You have no skill in your skill list.]" : msg = "[You have no language in your language list.]")
//	txtSelectedString.value = txtSelectedString.value.replace(res,"").replace(ree,""); 

	if (txtSelectedString.value == "") {
		op = new Option();
		op.value=""
//		op.text = msg
		listing.options[listing.options.length] = op;
	}
//alert(ctlSelectedString.value);
	return false;
}

function BuildRecordString (ctlFrom) {
	var strRecord;

	return GetValueFromCtl(ctlFrom);
}

function BuildSelectedString (ctlFrom, ctlTo) {
	var strRecord;

	if (GetValueFromCtl(ctlTo) == "")
		BumpUp(ctlTo)

	return GetTextFromCtl(ctlFrom);
}

function GetValueFromCtl (ctl) {
	for (var i=0; i < ctl.options.length; i++) {
		if(ctl.options[i].selected ) {
			if (ctl.options[i].value == "" || ctl.options[i].value == "0" || ctl.options[i].value == "-" || ctl.options[i].value == "00" || ctl.options[i].value == "000") {
				return "";
			} else
				return ctl.options[i].value;
		}
	}
	return "";
}

function GetTextFromCtl (ctl) {
	for (var i=0; i < ctl.options.length; i++) {
		if(ctl.options[i].selected ) {
			return ctl.options[i].text;
		}
	}
	return "";
}

function SetToRecordsString (ctl, strValue) {
	var strRecords = ctl.value;
	var strRecordToAdd = "," + strValue;	
	var alertmsg;
	var strRecordsLCase = (ctl.value).toLowerCase();
	var strRecordToAddLCase = ("," + strValue).toLowerCase();

	alertmsg = "You already have this item in your skill list.  Please delete first if you wish to add the same item."
		
	if (strRecordsLCase.indexOf(strRecordToAddLCase) == -1) {	
		strRecords = strRecords + strRecordToAdd;
		ctl.value = strRecords;		

//		if (from_control == 1 ? frm.txtSelectedString_skill.value = ctl.value : frm.txtSelectedString_lang.value = ctl.value)

		return true;
	} else
		alert (alertmsg);

	return false;
}

function SetValueToCtl (ctl, value) {
	for (var i=0; i < ctl.options.length; i++) {
		if(ctl.options[i].value == value ) {
			ctl.options[i].selected = true;
			return;
		}
	}
}


function RemoveItem(ctlFrom, ctlRecordsString) {
	var strRet = "";
	for(var i=0; i<ctlFrom.options.length; i++) {
		if(ctlFrom.options[i].selected && ctlFrom.options[i].value != "") {
			strRet = ctlFrom.options[i].value;
		RemoveFromRecordsString(ctlRecordsString, ctlFrom.options[i].value);
			ctlFrom.options[i].value = "";
			ctlFrom.options[i].text = "";
		}
	}
	BumpUp(ctlFrom);
	return strRet;
}

function StringReplace(pstrIn, pstrToReplace, pstrReplace) {
	var strRet = pstrIn;
	intPos = strRet.indexOf(pstrToReplace);
	while (intPos >= 0) {
		strRet = strRet.substring(0, intPos) + pstrReplace + strRet.substring (intPos + pstrToReplace.length, strRet.length);
		intPos = strRet.indexOf(pstrToReplace);
	}
	return strRet;
}

function RemoveFromRecordsString (ctl, value) {
	var strRecords = ctl.value;
	var strRE = value;

	strRecords = StringReplace(strRecords, "," + strRE, "")
	ctl.value = strRecords;
}

function BumpUp(box)  {
	var ln = box.options.length;
	
	for(var i=0; i<box.options.length; i++) {
		if(box.options[i].value == "")  {
			for(var j=i; j<box.options.length-1; j++)  {
				box.options[j].value = box.options[j+1].value;
				box.options[j].text = box.options[j+1].text;
			}
			ln = i;
			break;
		}
	}

	if(ln < box.options.length)  {
		box.options.length -= 1;
		BumpUp(box);
	}
}

//-->	

