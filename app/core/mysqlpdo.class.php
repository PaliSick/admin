<?php
class MysqlPDO {

	private $hostname,
			$database,
			$username,
			$password;

	private $db;

	private function __construct(DbConfig $config) {
		$this->hostname = $config->hostname;
		$this->database = $config->database;
		$this->username = $config->username;
		$this->password = $config->password;

		try {
			$this->db = new PDO($this->getConnectionString(), $this->username, $this->password);
			$this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch (Exception $e) {
			throw new Exception("Failed to connect to database. Error:".$e->getMessage());
		}

	}

	private static $instance;


	public static function get() {
		if (isset(self::$instance) and (self::$instance instanceof self)) {
			return self::$instance;
		} else {
			$dbConfig = new DbConfig('./app/etc/mysql_database.ini');
			self::$instance = new self($dbConfig);
			return self::$instance;
		}
	}


	private function getConnectionString() {
		return "mysql:host={$this->hostname};dbname=$this->database";
	}



	public function query($sql, $params = null, $fetch_mode = PDO::FETCH_ASSOC, $fetch_arg = null, $fetch_ctoargs = null) {

		$stmt = $this->db->prepare($sql);
		
		try {
			if ($params != null){
				$stmt->execute($params);
			} else {
				$stmt->execute();
			}
		} catch (Exception $e) {
			throw new Exception("Failed query: ".$e->getMessage());
			return false;
		}


		switch ($fetch_mode) {
			case PDO::FETCH_COLUMN:
			case PDO::FETCH_INTO:   						$all = $stmt->fetchAll($fetch_mode, $fetch_arg); 					break;

			case PDO::FETCH_CLASS:
			case PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE:	$all = $stmt->fetchAll($fetch_mode, $fetch_arg, $fetch_ctoargs); 	break;

			//TODO: Soportar FETCH_OBJ y FETCH_INTO
			default:										$all = $stmt->fetchAll(PDO::FETCH_ASSOC); 							break;
		}


		try {
			$stmt->closeCursor();
		} catch (Exception $e) {
			
		}
	

		if ($all !== false)
			return $all;
		else
			return false;
	}

	/**
	 * Exec ejecuta una Query que no devuelve resultados
	 *
	 * @return true|false
	 * @author
	 **/
	public function exec($sql, $params = null)
	{


		$stmt = $this->db->prepare($sql);

		try {
			if ($params != null){
				$stmt->execute($params);
			} else {
				$stmt->execute();
			}
		} catch (Exception $e) {

			throw new Exception("Error al ejecutar la query. {$e->getMessage()}", 1);

			return false;
		}

		$affectedRows = $stmt->rowCount();
		return $affectedRows;
	}


	public function lastInsertId() {
		return $this->db->lastInsertId();
	}

	public function beginTransaction() {
		$this->db->beginTransaction();
	}

	public function commit() {
		$this->db->commit();
	}


	public function rollback() {
		$this->db->rollBack();
	}

}