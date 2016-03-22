<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        Usuarios
* GENERATION DATE:  20.03.2016
* CLASS FILE:       /var/www/html/seedbox/tools/generated_classes/Usuarios.class.php
* FOR MYSQL TABLE:  Usuarios
* FOR MYSQL DB:     seedbox
* -------------------------------------------------------
*/

// **********************
// CLASS DECLARATION
// **********************

class Usuarios extends QueryBuilder {


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	protected $Id;
	protected $Nombre;
	protected $Email;
	protected $Password;
	protected $Cookie;

	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	public function Usuarios() {}


	// **********************
	// GETTER METHODS
	// **********************


	public function getId() {
		return $this->Id;
	}

	public function getNombre() {
		return $this->Nombre;
	}

	public function getEmail() {
		return $this->Email;
	}

	public function getPassword() {
		return $this->Password;
	}

	public function getCookie() {
		return $this->Cookie;
	}

	// **********************
	// SETTER METHODS
	// **********************


	public function setId($val) {
		$this->Id =  $val;
	}

	public function setNombre($val) {
		$this->Nombre =  $val;
	}

	public function setEmail($val) {
		$this->Email =  $val;
	}

	public function setPassword($val) {
		$this->Password =  $val;
	}

	public function setCookie($val) {
		$this->Cookie =  $val;
	}


}