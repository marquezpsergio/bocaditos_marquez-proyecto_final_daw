<?php

class Pedidos {
  private $codigo;
  private $cliente;
  private $precio;
  private $descuento;
  private $precioFinal;
  private $fecha;

  function __Construct( $registro ) {
    $this->codigo = $registro[ 'codigoPedido' ];
    $this->cliente = $registro[ 'clientePedido' ];
    $this->precio = $registro[ 'precioPedido' ];
    $this->descuento = $registro[ 'descuentoPedido' ];
    $this->precioFinal = $registro[ 'precioFinalPedido' ];
    $this->fechaPedido = $registro[ 'fechaPedido' ];

  }
  //Métodos Getters
  function getCodigo() {
    return $this->codigo;
  }

  function getCliente() {
    return $this->cliente;
  }

  function getPrecio() {
    return $this->precio;
  }

  function getDescuento() {
    return $this->descuento;
  }

  function getPrecioFinal() {
    return $this->precioFinal;
  }

  function getFecha() {
    return $this->fechaPedido;
  }

  //Metodos Setters
  function setCodigo( $codigo ) {
    $this->codigo = $codigo;
  }

  function setCliente( $cliente ) {
    $this->cliente = $cliente;
  }

  function setPrecio( $precio ) {
    $this->precio = $precio;
  }

  function setDescuento( $descuento ) {
    $this->descuento = $descuento;
  }

  function setPrecioFinal( $precioFinal ) {
    $this->precioFinal = $precioFinal;
  }

  function setFecha( $fechaPedido ) {
    $this->fechaPedido = $fechaPedido;
  }

}
