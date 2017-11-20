<?php
function getStatus($status){
	if ($status=="Single"){
		return "Single";
	}else if ($status=="In a relationship"){
		return "Single";
	}else if ($status=="Engaged"){
		return "Engaged";
	}else if ($status=="It's Complicated"){
		return "Its Complicated";
	}else if ($status=="In an open relationship"){
		return "DeFacto";
	}else if ($status=="Married"){
		return "Married";
	}else if ($status=="Divorced"){
		return "Divorced";
	}else if ($status=="Separated"){
		return "Divorced";
	}else if ($status=="In a civil union"){
		return "DeFacto";
	}else if ($status=="In a domestic partnership"){
		return "DeFacto";
	}else if ($status=="Married"){
		return "Married";
	}else{
		return "Single";
	}
}
function getMonth($month){
		if ($month=="01"){
			return "JAN";
		}else if ($month=="02"){
			return "FEB";
		}else if ($month=="03"){
			return "MAR";
		}else if ($month=="04"){
			return "APR";
		}else if ($month=="05"){
			return "MAY";
		}else if ($month=="06"){
			return "JUN";
		}else if ($month=="07"){
			return "JUL";
		}else if ($month=="08"){
			return "AUG";
		}else if ($month=="09"){
			return "SEP";
		}else if ($month=="10"){
			return "OCT";
		}else if ($month=="11"){
			return "NOV";
		}else if ($month=="12"){
			return "DEC";
		}else{
			return "Present";
		}
	}