function getCookie(name) { 
	var re = new RegExp(name + "=([^;]+)");
	var value = re.exec(document.cookie);
	return (value != null) ? unescape(value[1]) : null;
}

function setCookie(name, value, e) { 
	// e = in minutes
	var today = new Date();
	var expiry = new Date(today.getTime() + e * 60 * 1000); // plus 1 hour
	document.cookie=name + "=" + escape(value) + "; expires=" + expiry.toGMTString();
}
