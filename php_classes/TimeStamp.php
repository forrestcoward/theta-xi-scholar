<?php

class TimeStamp {

	private $year;
	private $month;
	private $day;
	private $hour;
	private $minute;
	private $second;
	private $ymd; // year/month/date format
	private $hms; // hour:minute:second format
	private $ampm; // Either 'AM' or 'PM'
	
	/*
		$sql_timestamp must be in format 'year/month/date hour:minutes:seconds'
		where hour is between 1 and 23. 
	*/
	public function __construct($sql_timestamp) {
	
		$split = explode(" ", $sql_timestamp);
		$days = explode("-", $split[0]);
		$times = explode(":", $split[1]);
		
		$this->year = $days[0];
		$this->month = $days[1];
		$this->day = $days[2];
		$this->hour = $times[0];
		$this->minute = $times[1];
		$this->second = $times[2];
		$this->ymd = $split[0];
		
		$set = false;
		if($this->hour == 0) {
			$this->hour = 12;
			$this->ampm = "PM";
			$set = true;
		}
		
		$this->hour = $this->hour - 1;
		
		if($this->hour == 0) {
			$this->hour = 12;
			$this->ampm = "AM";
		}
		
		if($this->hour > 12) {
			$this->ampm = "PM";
			$this->hour = $this->hour - 12;
		} else {
			if(!$set) {
				$this->ampm = "AM";
			}
		}
		
		$this->hms = $this->hour.':'.$this->minute.':'.$this->second.' '.$this->ampm;
	}
	
	public function getDateString() {
		return $this->ymd.' '.$this->hms;
	}
	
	public function getDateStringWithoutYear() {
		return $this->month.'/'.$this->day.' '.$this->hms;
	}
}

?>