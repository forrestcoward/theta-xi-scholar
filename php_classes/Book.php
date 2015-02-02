<?php

class Book {
	
	public $isbn13;
	public $isbn10;
	public $title;
	public $pubdate;
	public $author;
	public $publisher;	
	public $image_url;
	public $edition;
    public $pages;
	
	public function __construct($array) {
		$this->isbn13 = $array[0];
		$this->isbn10 = $array[1];
		$this->title = $array[2];
		$this->pubdate = $array[3];
		$this->author = $array[4];
		$this->publisher = $array[5];
		$this->image_url = $array[6];
		
		if($this->author == "") { $author = "N/A"; }
		$this->edition = "N/A";
		if ($array[7] != "") { $this->edition = $array[7]; }
		$this->pages = "N/A";
		if ($array[8] != "") { $this->pages = $array[8]; }
	}	
}

?>