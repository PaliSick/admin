<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        Peliculas
* GENERATION DATE:  20.03.2016
* CLASS FILE:       /var/www/html/seedbox/tools/generated_classes/Peliculas.class.php
* FOR MYSQL TABLE:  Peliculas
* FOR MYSQL DB:     seedbox
* -------------------------------------------------------
*/

// **********************
// CLASS DECLARATION
// **********************

class Peliculas extends QueryBuilder {


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	protected $Id;
	protected $Id_usuario;
	protected $Pelicula;
	protected $Descripcion;
	protected $Fecha;
	protected $Tipo;

	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	public function Peliculas() {}


	// **********************
	// GETTER METHODS
	// **********************


	public function getId() {
		return $this->Id;
	}

	public function getId_usuario() {
		return $this->Id_usuario;
	}

	public function getPelicula() {
		return $this->Pelicula;
	}

	public function getDescripcion() {
		return $this->Descripcion;
	}

	public function getFecha() {
		return $this->Fecha;
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

	public function setPelicula($val) {
		$this->Pelicula =  $val;
	}

	public function setDescripcion($val) {
		$this->Descripcion =  $val;
	}

	public function setFecha($val) {
		$this->Fecha =  $val;
	}

	public function setTipo($val) {
		$this->Tipo =  $val;
	}


}