<?php

class Productos {
  private $codigo;
  private $nombre;
  private $tipo;
  private $ingredientes;
  private $precio;
  private $imagen;

  function __Construct( $registro ) {
    $this->codigo = $registro[ 'codigoProducto' ];
    $this->nombre = $registro[ 'nombreProducto' ];
    $this->tipo = $registro[ 'tipoProducto' ];
    $this->ingredientes = $registro[ 'ingredientesProducto' ];
    $this->precio = $registro[ 'precioProducto' ];
    $this->imagen = $registro[ 'imagenProducto' ];

  }
  //Métodos Getters
  function getCodigo() {
    return $this->codigo;
  }

  function getNombre() {
    return $this->nombre;
  }

  function getTipo() {
    return $this->tipo;
  }

  function getIngredientes() {
    return $this->ingredientes;
  }

  function getPrecio() {
    return $this->precio;
  }

  function getImagen() {
    return $this->imagen;
  }

  //Metodos Setters
  function setCodigo( $codigo ) {
    $this->codigo = $codigo;
  }

  function setNombre( $nombre ) {
    $this->nombre = $nombre;
  }

  function setTipo( $tipo ) {
    $this->tipo = $tipo;
  }

  function setIngredientes( $ingredientes ) {
    $this->ingredientes = $ingredientes;
  }

  function setPrecio( $precio ) {
    $this->precio = $precio;
  }

  function setImagen( $imagen ) {
    $this->imagen = $imagen;
  }
}
?>