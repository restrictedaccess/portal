<?php
class TimesheetDetails extends Zend_Db_Table {
	protected $_name = "timesheet_details";
	
	public $month_year1;
	public $month_year2;
	public $day_start;
	public $day_end;
	
	public function staff_timesheet_details($info = array()) {
		$select = $this->select()
		->setIntegrityCheck(false)
		->from( array('td'=>$this->_name), array('id', 'adj_hrs', 'regular_rostered', 'day') )
		->joinLeft( array('t'=>'timesheet'), 'td.timesheet_id=t.id', array('monthyear'=>'substring(month_year,1,7)') )
		->where('t.userid=?', $info['userid'])
		->where('t.subcontractors_id=?', $info['contractid'])
		->where("unix_timestamp(concat(substring(month_year,1,7),'-',td.day)) >= unix_timestamp(?)", $this->month_year1.'-'.$this->day_start)
		->where("unix_timestamp(concat(substring(month_year,1,7),'-',td.day)) <= unix_timestamp(?)", $this->month_year2.'-'.$this->day_end)
		->where('t.status != ?', 'deleted')
		->group('td.id');
		return $this->fetchAll($select)->toArray();
	}
}
/*select regular_rostered, 
tr.time_in, tr.time_out,
td.adj_hrs,
IF(adj_hrs IS NULL, 
ROUND( (UNIX_TIMESTAMP(tr.time_out)-UNIX_TIMESTAMP(tr.time_in))/3600, 2 ), adj_hrs) adj_hrs2 ,

ROUND( (
UNIX_TIMESTAMP( tr.time_out ) - UNIX_TIMESTAMP( tr.time_in ) ) /3600, 2 )
total_hrs,

IF(td.adj_hrs IS NULL, time_out,
 from_unixtime(unix_timestamp(time_in) + (td.adj_hrs*3600)) ) t_out,

floor(IF(td.adj_hrs IS NULL, unix_timestamp(time_out),
 unix_timestamp(time_in) + (td.adj_hrs*3600) )) timestamp_out,

unix_timestamp(time_out) time_out2,

from_unixtime(unix_timestamp( concat(SUBSTRING(tr.time_in, 1, 10 ),' 22:00:00') )) regular_time_limit,

from_unixtime(unix_timestamp( date_add(concat(SUBSTRING(tr.time_in, 1, 10 ),' 06:00:00'),interval 1 day) )) night_diff_end

FROM
timesheet_details td
left join timesheet t on td.timesheet_id=t.id

left join timerecord tr 
on tr.time_in LIKE concat(SUBSTRING(t.month_year, 1, 8 ),LPAD(td.day,2,0),' %')

where t.userid=5671
and t.month_year >= '2013-07-01 00:00:00'
and t.month_year <= '2013-08-01 00:00:00'
and tr.time_in >= '2013-07-21'
and tr.time_in <= '2013-08-5 23:00:00'
and t.leads_id=11
and tr.subcontractors_id=3049

group by tr.id*/
?>