<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        Chats
* GENERATION DATE:  20.03.2016
* CLASS FILE:       /var/www/html/seedbox/tools/generated_classes/Chats.class.php
* FOR MYSQL TABLE:  Chats
* FOR MYSQL DB:     seedbox
* -------------------------------------------------------
*/

// **********************
// CLASS DECLARATION
// **********************

class Chats extends QueryBuilder {


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	protected $Id;
	protected $Fecha;
	protected $Mensaje;
	protected $Id_usuario;

	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	public function Chats() {}


	// **********************
	// GETTER METHODS
	// **********************


	public function getId() {
		return $this->Id;
	}

	public function getFecha() {
		return $this->Fecha;
	}

	public function getMensaje() {
		return $this->Mensaje;
	}

	public function getId_usuario() {
		return $this->Id_usuario;
	}

	// **********************
	// SETTER METHODS
	// **********************


	public function setId($val) {
		$this->Id =  $val;
	}

	public function setFecha($val) {
		$this->Fecha =  $val;
	}

	public function setMensaje($val) {
		$this->Mensaje =  $val;
	}

	public function setId_usuario($val) {
		$this->Id_usuario =  $val;
	}


}