<?php

class Config {


//private $DBH;

public $config;




// Fetch config table into a $config array

public function __construct ($DBH, $url) {
	try {
		$STH = $DBH->query('SELECT item, value FROM '.PREFIX.'config');
		$STH->setFetchMode(PDO::FETCH_OBJ);
		while ($row = $STH->fetch()) :
			$this->config[$row->item] = $row->value;
		endwhile;
		$this->config['url'] = $url;
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
}




// Return a stripslashed config value

public function o ($item) {
	return Str::o($this->config[$item]);
}




// Echo a stripslashed config value

public function e ($item) {
	Str::e($this->config[$item]);
}




// Retrurn site URL

public function ourl () {
	return $this->o('url');
}



// Echo site URL

public function url () {
	$this->e('url');
}




}


// Initialize CONFIG

$c = new Config($DBH, $DBcfg['url']);
