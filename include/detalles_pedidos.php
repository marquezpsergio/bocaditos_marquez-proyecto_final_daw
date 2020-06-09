<?php

class Detalles_Pedidos {
  private $codigo;
  private $codigoPedido;
  private $codigoProducto; 
  private $cantidad;
  private $precio;


  function __Construct( $registro ) {
    $this->codigo = $registro[ 'codigoDetalle' ];
    $this->codigoPedido = $registro[ 'codigoPedido' ];
    $this->codigoProducto = $registro[ 'codigoProductoDetalle' ];
    $this->cantidad = $registro[ 'cantidadDetalle' ];
    $this->precio = $registro[ 'precioDetalle' ];
  }
  //Métodos Getters
  function getCodigo() {
    return $this->codigo;
  }

  function getCodigoPedido() {
    return $this->codigoPedido;
  }

  function getCodigoProducto() {
    return $this->codigoProducto;
  }

  function getCantidad() {
    return $this->cantidad;
  }

  function getPrecio() {
    return $this->precio;
  }

  //Metodos Setters
  function setCodigo( $codigo ) {
    $this->codigo = $codigo;
  }

  function setCodigoPedido( $codigoPedido ) {
    $this->codigoPedido = $codigoPedido;
  }

  function setCodigoProducto( $codigoProducto ) {
    $this->codigoProducto = $codigoProducto;
  }

  function setCantidad( $cantidad ) {
    $this->cantidad = $cantidad;
  }

  function setPrecio( $precio ) {
    $this->precio = $precio;
  }
}
