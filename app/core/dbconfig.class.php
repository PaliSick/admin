<?php
class DbConfig
{
	public	$hostname,
			$database,
			$username,
			$password;
	
	
	function __construct($configFile)
	{
		$ini = parse_ini_file($configFile, true);
		
		
		$domain = str_replace('www.', '', $_SERVER['SERVER_NAME']);
		$this->hostname = $ini[$domain]['server'];
		$this->database = $ini[$domain]['database'];
		$this->username = $ini[$domain]['user'];
		$this->password = $ini[$domain]['pass'];
	}
}
