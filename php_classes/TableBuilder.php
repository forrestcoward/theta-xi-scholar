<?php

class TableBuilder {

	private $tableString;
	private $dataPerRow;
	private $dataCount;
	private $css;
	private $nextRowClass;
	private $setNextRowClass;
	
	public function __construct($dataPerRow, $css = "") {
		$this->tableString = '';
		$this->dataPerRow = $dataPerRow;
		$this->dataCount = 1;
		$this->css = $css;
		$this->nextRowClass = "";
		$this->setNextRowClass = false;
	}
	
	public function begin() {
		$this->tableString .= '<table class="'.$this->css.'">';
		return $this;
	}
	
	public function setNextRowClass($nextRowClass) {
		$this->nextRowClass = $nextRowClass;
		$this->setNextRowClass = true;
		return $this;
	}
	
	public function td($td, $class = '') {
		if($this->dataCount == 1) {
			if($this->setNextRowClass) {
				$this->tableString .= '<tr class="'.$this->nextRowClass.'">';
				$this->setNextRowClass = false;
			} else {
				$this->tableString .= '<tr>';
			}
		}
		$this->tableString .= '<td class="'.$class.'">'.$td.'</td>';
		if($this->dataCount == $this->dataPerRow) {
			$this->tableString .= '</tr>';
			$this->dataCount = 1;
		} else {
			$this->dataCount++;
		}
		return $this;
	}
	
	public function end() {
		$this->tableString .= '</table>';
		return $this->tableString;
	}
}

?>