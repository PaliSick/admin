<?php

class DBManager {

	private static $db = null;
		

	private static function construct(){
		if (!isset($db)) {
			self::$db = MysqlPDO::get();
		}
	}


	public function beginTransaction()
	{
		self::construct();

		self::$db->beginTransaction();
	}

	public function commit()
	{
		self::construct();

		self::$db->commit();
	}

	public function rollback()
	{
		self::construct();

		self::$db->rollback();
	}

	public static function selectAll($class, $asClass = false) {

		self::construct();
		
		$sql = 'SELECT * FROM `'.$class.'`;';

		try {

			if ($asClass) {
				$p1 = PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE;
				$p2 = $class;
			} else {
				$p1 = null;
				$p2 = null;
			}

			$r = self::$db->query($sql, null, $p1, $p2); //PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $class

			return $r;
		} catch(Exception $e) {
			throw new Exception("Error selecting records");
		}
	}

	public static function selectLimit($class, $page, $itemsByPage, &$totalRows, $asClass=true) {
		self::construct();
		
		$offset = ($page-1) * $itemsByPage;

		$sql = 'SELECT * FROM `'.$class.'` LIMIT '.$offset.', '.$itemsByPage.';';
		

		$sql2 = 'SELECT count(*) as `totalRows` FROM `'.$class.'`;';

		try {

			if ($asClass) {
				$p1 = PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE;
				$p2 = $class;
			} else {
				$p1 = null;
				$p2 = null;
			}

			$rt = self::$db->query($sql2);
	
			$totalRows = $rt[0]['totalRows'];

			$r = self::$db->query($sql, null, $p1, $p2); //PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $class

			return $r;
		} catch(Exception $e) {
			throw new Exception("Error selecting records");
		}
	}

	public static function selectClassById($className, $id, $asClass = false) {

		self::construct();

		$class = new $className();
		
		$sql = 'SELECT * FROM `'.$className.'` WHERE `'.$class->getPKName().'` = :'.$class->getPKName().';';
		
		$p = array($class->getPKName() => $id);
		try {

			if ($asClass) {
				$p1 = PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE;
				$p2 = $className;
			} else {
				$p1 = null;
				$p2 = null;
			}

			$r = self::$db->query($sql, $p, $p1, $p2); //PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $class

			return $r[0];
		} catch(Exception $e) {
			throw new Exception("Error selecting record");
		}

	}

	public static function selectClassByParam($className, $param, $asClass = true) {

		self::construct();

		$class = new $className();
		
		$sql = 'SELECT * FROM `'.$className.'` WHERE %s;';

		if (!is_array($param)) {
			throw new Exception("Array parameter not provided");
		}

		$p = array();
		foreach ($param as $column => $value) {
			$p[] = '`'.$column.'` = :'.$column;
		}

		$sql_params = join(' AND ', $p);

		$sql = sprintf($sql, $sql_params);
		
		try {

			if ($asClass) {
				$p1 = PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE;
				$p2 = $className;
			} else {
				$p1 = null;
				$p2 = null;
			}

			$r = self::$db->query($sql, $param, $p1, $p2); //PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $class

			return $r;
		} catch(Exception $e) {
			throw new Exception("Error selecting records");
		}
	}

	public static function customQuery($className, $sql, $parameters = null, $asClass = true) {

		//$sql = "SELECT * FROM Post ORDER BY IdPost LIMIT 2";


		self::construct();

		if ($asClass) {
			$p1 = PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE;
			$p2 = $className;
		} else {
			$p1 = null;
			$p2 = null;
		}

		try {
			$r = self::$db->query($sql, $parameters, $p1, $p2); //PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $class
			return $r;
		} catch(Exception $e) {
			throw new Exception("Error selecting records". $e->getMessage());
		}

	}

	public static function insert(QueryBuilder $obj) {

		self::construct();
		
		$insert = $obj->getInsert();

		try {
			self::$db->exec($insert['sql'], $insert['params']);
			return self::$db->lastInsertId();
		} catch(Exception $e) {
			throw new Exception("Error inserting record. Error:".$e->getMessage());
		}

	}

	public static function update(QueryBuilder $obj) {

		self::construct();
		
		$update = $obj->getUpdate();
		
		try {
			self::$db->exec($update['sql'], $update['params']);
			return true;
		} catch(Exception $e) {
			throw new Exception("Error updating record. Error:".$e->getMessage());
		}

	}

	public static function delete(QueryBuilder $obj) {

		self::construct();
		
		$delete = $obj->getDelete();

		try {
			$r = self::$db->exec($delete['sql'], $delete['params']);
			return $r;
		} catch(Exception $e) {
			throw new Exception("Error deleting record. Error:".$e->getMessage());
		}

	}

}