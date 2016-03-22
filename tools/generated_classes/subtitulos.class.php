<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        Subtitulos
* GENERATION DATE:  20.03.2016
* CLASS FILE:       /var/www/html/seedbox/tools/generated_classes/Subtitulos.class.php
* FOR MYSQL TABLE:  Subtitulos
* FOR MYSQL DB:     seedbox
* -------------------------------------------------------
*/

// **********************
// CLASS DECLARATION
// **********************

class Subtitulos extends QueryBuilder {


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	protected $Id;
	protected $Id_pelicula;
	protected $Subtitulo;
	protected $Descargas;

	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	public function Subtitulos() {}


	// **********************
	// GETTER METHODS
	// **********************


	public function getId() {
		return $this->Id;
	}

	public function getId_pelicula() {
		return $this->Id_pelicula;
	}

	public function getSubtitulo() {
		return $this->Subtitulo;
	}

	public function getDescargas() {
		return $this->Descargas;
	}

	// **********************
	// SETTER METHODS
	// **********************


	public function setId($val) {
		$this->Id =  $val;
	}

	public function setId_pelicula($val) {
		$this->Id_pelicula =  $val;
	}

	public function setSubtitulo($val) {
		$this->Subtitulo =  $val;
	}

	public function setDescargas($val) {
		$this->Descargas =  $val;
	}


}