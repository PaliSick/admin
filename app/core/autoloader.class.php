<?php

class AutoLoad {

	public static $loader;
	private $paths = array('app/core/', 'app/model/', 'app/inc/');
	private $filePatterns = array('%s.class.php');

	public static function init() {

		if (self::$loader == null)
			self::$loader = new self();

		return self::$loader;
	}

	private function __construct() {
		spl_autoload_register(array($this, 'autoLoad'));
	}

	public function autoLoad($className) {
		$parts = explode('\\', $className);
		$className = array_pop($parts);
		foreach ($this->paths as $path) {
			foreach ($this->filePatterns as $fileName) {
				$fName = strtolower($path . sprintf($fileName, $className));
				$fName."\n";
				if (is_file($fName)) {
					require_once ($fName);
					break;
				}
			}
		}
	}

}

//We should init it to this get to work
AutoLoad::init();