<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        Comentarios
* GENERATION DATE:  27.09.2015
* CLASS FILE:       /home/wwweefol/public_html/seedbox/tools/generated_classes/Comentarios.class.php
* FOR MYSQL TABLE:  Comentarios
* FOR MYSQL DB:     wwweefol_movie
* -------------------------------------------------------
*/

// **********************
// CLASS DECLARATION
// **********************

class Comentarios extends QueryBuilder {


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	protected $Id;
	protected $Id_usuario;
	protected $Id_pelicula;
	protected $Comentario;
	protected $Tipo;
	protected $Fecha;

	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	public function Comentarios() {}


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

	public function getComentario() {
		return $this->Comentario;
	}

	public function getTipo() {
		return $this->Tipo;
	}

	public function getFecha() {
		return $this->Fecha;
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

	public function setComentario($val) {
		$this->Comentario =  $val;
	}

	public function setTipo($val) {
		$this->Tipo =  $val;
	}

	public function setFecha($val) {
		$this->Fecha =  $val;
	}


}