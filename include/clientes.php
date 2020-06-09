<?php

class Clientes {
  private $codigo;
  private $dni;
  private $nombre;
  private $apellidos;
  private $direccion;
  private $telefono;
  private $email;
  private $fechaNacimiento;
  private $usuario;

  function __Construct( $registro ) {
    $this->codigo = $registro[ 'codigoCliente' ];
    $this->dni = $registro[ 'dniCliente' ];
    $this->nombre = $registro[ 'nombreCliente' ];
    $this->apellidos = $registro[ 'apellidosCliente' ];
    $this->direccion = $registro[ 'direccionCliente' ];
    $this->telefono = $registro[ 'telefonoCliente' ];
    $this->email= $registro[ 'emailCliente' ];
    $this->fechaNacimiento = $registro[ 'fechaNacimientoCliente' ];
    $this->usuario = $registro[ 'usuarioCliente' ];
  }
  //Métodos Getters
  function getCodigo() {
    return $this->codigo;
  }

  function getDni() {
    return $this->dni;
  }

  function getNombre() {
    return $this->nombre;
  }

  function getApellidos() {
    return $this->apellidos;
  }

  function getDireccion() {
    return $this->direccion;
  }

  function getTelefono() {
    return $this->telefono;

  }

  function getEmail() {
    return $this->email;

  }

  function getFechaNacimiento() {
    return $this->fechaNacimiento;

  }

  function getUsuario() {
    return $this->usuario;

  }
  //Metodos Setters
  function setCodigo( $codigo ) {
    $this->codigo = $codigo;
  }

  function setDni( $dni ) {
    $this->dni = $dni;
  }

  function setNombre( $nombre ) {
    $this->nombre = $nombre;
  }

  function setApellidos( $apellidos ) {
    $this->apellidos = $apellidos;
  }

  function setDireccion( $direccion ) {
    $this->direccion = $direccion;
  }
  
  function setTelefono( $telefono ) {
    $this->telefono = $telefono;
  }

  function setEmail( $email ) {
    $this->email = $email;
  }

  function setFechaNacimiento( $fechaNacimiento ) {
    $this->fechaNacimiento = $fechaNacimiento;
  }

  function setUsuario( $usuario ) {
    $this->usuario = $usuario;
  }
}
?>