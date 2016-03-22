<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        Rel_pelicula_usuario
* GENERATION DATE:  20.03.2016
* CLASS FILE:       /var/www/html/seedbox/tools/generated_classes/Rel_pelicula_usuario.class.php
* FOR MYSQL TABLE:  Rel_pelicula_usuario
* FOR MYSQL DB:     seedbox
* -------------------------------------------------------
*/

// **********************
// CLASS DECLARATION
// **********************

class Rel_pelicula_usuario extends QueryBuilder {


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	protected $Id;
	protected $Id_usuario;
	protected $Id_pelicula;
	protected $Estado;
	protected $Tipo;

	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	public function Rel_pelicula_usuario() {}


	// **********************
	// GETTER METHODS
	// **********************


	public function getId() {
		return $this->Id;
	}

	public function getId_usuario() {
		return $this->Id_usuario;
	}

	public function getId_pelicula() {
		return $this->Id_pelicula;
	}

	public function getEstado() {
		return $this->Estado;
	}

	public function getTipo() {
		return $this->Tipo;
	}

	// **********************
	// SETTER METHODS
	// **********************


	public function setId($val) {
		$this->Id =  $val;
	}

	public function setId_usuario($val) {
		$this->Id_usuario =  $val;
	}

	public function setId_pelicula($val) {
		$this->Id_pelicula =  $val;
	}

	public function setEstado($val) {
		$this->Estado =  $val;
	}

	public function setTipo($val) {
		$this->Tipo =  $val;
	}


}