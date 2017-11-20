<?php
//2011-03-16 Normaneil Macutay <normanm@remotestaff.com.au>
// - Array list of states of countries :  Australia , United States , United Kingdom


function GetCountryStatesList($country){
	//returns an array
	if($country == 'United States'){
		$state_list = array("Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","District Of Columbia","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming");
	}else if($country == 'Australia'){
		$state_list = array("Australian Capital Territory","New South Wales","Northern Territory","Queensland","South Australia","Tasmania","Victoria"," Western Australia");
	}else if($country == 'United Kingdom'){
		$state_list = array("England","Scotland","Wales","Northern Ireland");
	}else{
		$state_list = array();
	}
	return $state_list;
}

?>