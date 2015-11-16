<?php

class QueryBuilder
{

	public function getPKName() {
		return 'Id' ;
	}

	public function getInsert() {
		$className = get_class ($this);

		$reflector = new ReflectionClass($className);
		$props = $reflector->getProperties();

		$sql = "INSERT INTO %s (%s) VALUES (%s);";

		$c = $p = $v = array();

		$pk = $this->getPKName();

		foreach ($props as $prop) {
			$name = $prop->getName();

			if ($pk == $name) continue; //si es el atributo ID_CLASS no lo agregamos al insert.

			$c[] = '`'. $name .'`';
			$v[] = ':'. $name;

			$p[$name] = $this->$name;
		}

		return array(
					'sql' => sprintf($sql, $className, implode(', ', $c), implode(', ', $v)),
					'params' => $p
					);
	}

	public function getUpdate() {
		$className = get_class ($this);
		
		$pk = $this->getPKName();

		$reflector = new ReflectionClass($className);
		$props = $reflector->getProperties();

		$sql = "UPDATE %s SET %s WHERE %s = %s;";

		$c = $p = $v = array();

		foreach ($props as $prop) {
			$name = $prop->getName();

			if ($pk == $name) continue; //si es el atributo ID_CLASS no lo agregamos al update.

			$c[] = '`'. $name .'` = :'. $name;
			$p[$name] = $this->$name;
		}

		$p[$pk] = $this->$pk;

		return array(
					'sql' => sprintf($sql, $className, implode(', ', $c), $pk, ':'.$pk),
					'params' => $p
					);
	}

	public function getDelete()
	{
		$className = get_class ($this);
		
		$pk = $this->getPKName();

		$sql = "DELETE FROM %s WHERE %s = %s";
		$p = array(':'.$pk => $this->$pk);
		
		return array(
			'sql' => sprintf($sql, $className, $pk, ':'.$pk),
			'params' => $p
			);
	}

	public function convertToArray()
	{
		$className = get_class ($this);

		$reflector = new ReflectionClass($className);
		$props = $reflector->getProperties();

		foreach ($props as $prop) {
			$name = $prop->getName();			
			$p[$name] = $this->$name;
		}

		return $p;
	}
}