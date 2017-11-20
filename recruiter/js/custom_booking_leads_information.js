//START: endorsement
var active_userid = "";
var endorse_obj = makeObject()
function order(userid)
{
	if(document.getElementById('app_id'+userid).checked == true)
	{

		endorse_obj.open('get', 'recruiter/staff_custom_booking_session.php?userid='+userid)
		endorse_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		endorse_obj.send(1)
	}
	else
	{

		endorse_obj.open('get', 'recruiter/staff_custom_booking_session.php?uncheck_id='+userid)
		endorse_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		endorse_obj.send(1)
	}
}
function booking(to)
{
	previewPath = "../custom-portal-booking.php?to="+to;
	// window.open(previewPath,'_blank','width=700,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	window.open(previewPath,'_blank','width=820,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
//ENDED: endorsement