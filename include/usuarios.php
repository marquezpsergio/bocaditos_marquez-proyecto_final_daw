<?php

class Usuarios {
  private $codigo;
  private $usuario;
  private $password;
  private $tipo;
  private $fechaRegistro;

  function __Construct( $registro ) {
    $this->codigo = $registro[ 'codigoUsuario' ];
    $this->usuario = $registro[ 'nombreUsuario' ];
    $this->password = $registro[ 'passwordUsuario' ];
    $this->tipo = $registro[ 'tipoUsuario' ];
    $this->fechaRegistro = $registro[ 'fechaRegistroUsuario' ];
  }
  //Métodos Getters
  function getCodigo() {
    return $this->codigo;
  }

  function getUsuario() {
    return $this->usuario;
  }

  function getPassword() {
    return $this->password;
  }

  function getTipo() {
    return $this->tipo;
  }

  function getFechaRegistro() {
    return $this->fechaRegistro;
  }

  //Metodos Setters
  function setCodigo( $codigo ) {
    $this->codigo = $codigo;
  }

  function setUsuario( $usuario ) {
    $this->usuario = $usuario;
  }

  function setPassword( $password ) {
    $this->password = $password;
  }

  function setTipo( $tipo ) {
    $this->tipo = $tipo;
  }

  function setFechaRegistro( $fechaRegistro ) {
    $this->fechaRegistro = $fechaRegistro;
  }

}
?>