<?php

class Page {

	public $id;
	public $title;
	public $type;
	public $pagetitle;
	public $action;
	public $pagenum;
	public $meta;

	public function __construct () {
		$this->meta = new stdClass();
	}


}
