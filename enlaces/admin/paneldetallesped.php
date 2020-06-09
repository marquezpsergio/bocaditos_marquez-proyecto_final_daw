<?php

session_start();
include_once("../../include/BD.php");
if (!isset($_SESSION['adminLogged']) || $_SESSION['adminLogged'] != true) {
  echo "<script>location.href = '../../index.php';</script>";
}

// Función paginación productos
$total_peds = Base::getTotalDetPedidos();
$total_pags = $total_peds / 20;
$total_pags = ceil($total_pags);
if (isset($_REQUEST['pagActual'])) {
  $pagActual = $_REQUEST['pagActual'];
  if ($pagActual < 1) {
    $pagActual = 1;
  }
  if ($pagActual > $total_pags) {
    $pagActual = $total_pags;
  }
} else {
  $pagActual = 1;
}
$pagLimit = $pagActual - 1;
$pagLimit = $pagLimit * 20;
?>
<html lang="es">

<head>
  <!-- Etiquetas meta -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="Bocatería y hamburguesería Márquez" />
  <meta name="keywords" content="cenas jerez, bocadillos jerez, bocateria jerez, hamburguesas jerez, hamburgueseria jerez, servicio a domicilio" />
  <meta name="author" content="Sergio Márquez" />
  <!-- Bootstrap CSS y FontAwesome -->
  <link rel="stylesheet" href="../../librerias/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../librerias/fontawesome/css/all.css">
  <link rel="stylesheet" href="../../estilos/estilos_productos.css">
  <!-- JavaScript: jQuery y Bootstrap JS -->
  <script src="../../librerias/jquery/jquery-3.4.1.min.js"></script>
  <script src="../../librerias/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../../enlaces/main.js"></script>
  <title>Bocaditos Márquez | Servicio a Domicilio | Tu bocatería preferida</title>
</head>

<body>
  <!-- HEADER -->
  <div class="container-fluid mb-2">
    <div class="row">

      <!-- HEADER TOP -->
      <div class="col-12">
        <nav class="navbar navbar-light" id="header_top">

          <!-- LOGO -->
          <a class="navbar-brand" href="../../index.php">
            <img src="../../img/Logo.png" alt="Logo" id="img_logo">
          </a>

          <!-- MENÚ ACCESO y CARRITO -->
        </nav>
      </div>
      <!-- // HEADER TOP -->
    </div>
  </div>
  <!-- // HEADER -->

  <!-- CUERPO -->
  <div class="container-fluid">
    <div class="row">
      <div class='col-12 mt-3 w-100'>
        <nav class='col-12 navbar navbar-expand-xl navbar-dark bg-dark'>
          <h5 class='mt-1 mr-3 mr-xl-5 font-weight-bold text-white'>PANEL DE ADMINISTRACIÓN</h5>
          <button class="navbar-toggler m-0 p-2" type="button" data-toggle="collapse" data-target="#navbarPanel" aria-controls="navbarPanel" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarPanel">
            <ul class="navbar-nav mr-auto nav-justified w-100">
              <li class="nav-item">
                <a class="nav-link panel_menu_links" href="panelproductos.php">PRODUCTOS</a>
              </li>
              <li class="nav-item">
                <a class="nav-link panel_menu_links" href="panelpedidos.php">PEDIDOS</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link panel_menu_links" href="paneldetallesped.php">DETALLES PEDIDOS</a>
              </li>
              <li class="nav-item">
                <a class="nav-link panel_menu_links" href="panelclientes.php">CLIENTES</a>
              </li>
              <li class="nav-item">
                <a class="nav-link panel_menu_links" href="panelusuarios.php">USUARIOS</a>
              </li>
            </ul>
          </div>
        </nav>

        <div class='col-12 mt-3' id='tabla_panel'>
          <h3 class='py-2 px-2 m-0 text-center'>TABLA DETALLES PEDIDOS</h3>
          <table class="table table-hover table-dark">
            <thead>
              <tr class="text-center header_panel">
                <th scope="col" class="align-middle">Nº Pedido</th>
                <th scope="col" class="align-middle">Nº Producto</th>
                <th scope="col" class="align-middle">Cantidad</th>
                <th scope="col" class="align-middle">Precio</th>
                <th scope="col" class="align-middle">Código</th>
                <th scope="col" colspan="2"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $array_dets = Base::getDetPedidosPag($pagLimit);
              if (isset($array_dets)) {
                if (sizeof($array_dets) > 0) {
                  foreach ($array_dets as $ad) {
                    $codigo = $ad->getCodigo();
                    $codPed = $ad->getCodigoPedido();
                    $codProd = $ad->getCodigoProducto();
                    $cant = $ad->getCantidad();
                    $precio = $ad->getPrecio();
                    echo "
                  <tr class='text-center filas_panel'>
                  <form action='' method='post'>
                  <td class='align-middle'><input type='text' name='codPed_input' value='$codPed' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='codProd_input' value='$codProd' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='cant_input' value='$cant' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='precio_input' value='$precio' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='codigo_input' value='$codigo' readonly class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><button type='submit' name='modificarDetalle' class='btn btn-primary'><i class='fas fa-check'></i></button></td>
                  <td class='align-middle'><button type='submit' name='eliminarDetalle' class='btn btn-danger'><i class='fas fa-trash-alt'></i></button></td>
                  </form></tr>
                  ";
                  }
                }
              }
              ?>
              <tr class='filas_panel text-center'>
                <form action='' method='post'>
                  <td colspan='2'>Nuevo Detalle</td>
                  <td colspan="5"></td>
              </tr>
              <tr class='text-center filas_panel'>
                <td class='align-middle'><input type='text' name='add_codPed_input' class='text-center w-100 p-1' placeholder="Nº Pedido" value="
                <?php if (isset($_SESSION['nuevoCodigo'])) {
                  echo $_SESSION['nuevoCodigo'];
                } ?>
                "></input></td>
                <td class='align-middle'><input type='text' name='add_codProd_input' class='text-center w-100 p-1' placeholder="Nº Producto"></input></td>
                <td class='align-middle'><input type='text' name='add_cant_input' class='text-center w-100 p-1' placeholder="Cantidad"></input></td>
                <td class='align-middle'><input type='text' name='add_precio_input' class='text-center w-100 p-1' placeholder="Precio"></input></td>
                <td class='align-middle'><button type='submit' name='addDetalle' class='btn btn-success'><i class='fas fa-plus'></i></button></td>
                <td colspan="2"></td>
                </form>
              </tr>

            </tbody>
          </table>
        </div>
        <div class="col-12">
          <nav aria-label="Paginacion">
            <ul class="pagination justify-content-center">
              <?php
              $pagAnterior = $pagActual - 1;
              if ($pagAnterior < 1) {
                echo "<li class='page-item disabled'>";
                echo "<a class='page-link' href='' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
              } else {
                echo "<li class='page-item'>";
                echo "<a class='page-link' href='paneldetallesped.php?pagActual=$pagAnterior' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
              }
              for ($i = 0; $i < $total_pags; $i++) {
                $pagi = $i + 1;
                if ($pagi == $pagActual) {
                  echo "<li class='page-item'><a class='page-link text-danger font-weight-bold' href='panelpedidos.php?pagActual=$pagi'>$pagi</a></li>";
                } else {
                  echo "<li class='page-item'><a class='page-link' href='paneldetallesped.php?pagActual=$pagi'>$pagi</a></li>";
                }
              }
              $pagPosterior = $pagActual + 1;
              if ($pagActual >= $total_pags) {
                echo "<li class='page-item disabled'>";
                echo "<a class='page-link' href='' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
              } else {
                echo "<li class='page-item'>";
                echo "<a class='page-link' href='paneldetallesped.php?pagActual=$pagPosterior' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
              }
              ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <!-- // CUERPO -->
</body>
<?php
if (isset($_REQUEST['addDetalle'])) {
  $codPed = $_REQUEST['add_codPed_input'];
  $codProd = $_REQUEST['add_codProd_input'];
  $cant = $_REQUEST['add_cant_input'];
  $precio = $_REQUEST['add_precio_input'];
  Base::nuevoDetallePanel($codPed, $codProd, $cant, $precio);
  echo "<script>location.href = 'paneldetallesped.php';</script>";
}


if (isset($_REQUEST['modificarDetalle'])) {
  $codigo = $_REQUEST['codigo_input'];
  $codPed = $_REQUEST['codPed_input'];
  $codProd = $_REQUEST['codProd_input'];
  $cant = $_REQUEST['cant_input'];
  $precio = $_REQUEST['precio_input'];
  Base::modificarDetalle($codigo, $codPed, $codProd, $cant, $precio);
  echo "<script>location.href = 'paneldetallesped.php';</script>";
}

if (isset($_REQUEST['eliminarDetalle'])) {
  $codigo = $_REQUEST['codigo_input'];
  $codPed = $_REQUEST['codPed_input'];
  $precioDet = $_REQUEST['precio_input'];
  Base::eliminarDetalle($codigo);
  $array_dets = Base::getDetallesPedido($codPed);
  if (sizeof($array_dets) > 0) {
    $array_peds = Base::getPedidoCodigo($codPed);
    if (isset($array_peds)) {
      if (sizeof($array_peds) > 0) {
        foreach ($array_peds as $ap) {
          $codigo = $ap->getCodigo();
          $prec = $ap->getPrecio();
          $desc = $ap->getDescuento();
          $precFinal = $ap->getPrecioFinal();

          $nuevoPrecio = $prec - $precioDet;
          $nuevoPrecFinal = $prec - (($desc / 100) * $prec);
          Base::modificarPreciosPedido($codPed, $nuevoPrecio, $nuevoPrecFinal);
        }
      }
    }
  } else {
    Base::eliminarPedido($codPed);
  }

  echo "<script>location.href = 'paneldetallesped.php';</script>";
}

?>

</html>