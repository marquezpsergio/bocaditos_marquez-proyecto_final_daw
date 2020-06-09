<?php

session_start();
include_once("../../include/BD.php");
if (!isset($_SESSION['adminLogged']) || $_SESSION['adminLogged'] != true) {
  echo "<script>location.href = '../../index.php';</script>";
}

// Función paginación productos
$total_peds = Base::getTotalPedidos();
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
              <li class="nav-item active">
                <a class="nav-link panel_menu_links" href="panelpedidos.php">PEDIDOS</a>
              </li>
              <li class="nav-item">
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
          <h3 class='py-2 px-2 m-0 text-center'>TABLA PEDIDOS</h3>
          <table class="table table-hover table-dark">
            <thead>
              <tr class="text-center header_panel">
                <th scope="col" class="align-middle">Cliente</th>
                <th scope="col" class="align-middle">Precio</th>
                <th scope="col" class="align-middle">Descuento</th>
                <th scope="col" class="align-middle">Precio Final</th>
                <th scope="col" class="align-middle">Código</th>
                <th scope="col" colspan="2"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $array_peds = Base::getPedidosPag($pagLimit);
              if (isset($array_peds)) {
                if (sizeof($array_peds) > 0) {
                  foreach ($array_peds as $ap) {
                    $codigo = $ap->getCodigo();
                    $cliente = $ap->getCliente();
                    $prec = $ap->getPrecio();
                    $desc = $ap->getDescuento();
                    $precFinal = $ap->getPrecioFinal();
                    $_SESSION['nuevoCodigo'] = $codigo + 1;
                    echo "
                  <tr class='text-center filas_panel'>
                  <form action='' method='post'>
                  <td class='align-middle'><input type='text' name='cliente_input' value='$cliente' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='prec_input' value='$prec' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='desc_input' value='$desc' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='precFinal_input' value='$precFinal' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='codigo_input' value='$codigo' readonly class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><button type='submit' name='modificarPedido' class='btn btn-primary'><i class='fas fa-check'></i></button></td>
                  <td class='align-middle'><button type='submit' name='eliminarPedido' class='btn btn-danger'><i class='fas fa-trash-alt'></i></button></td>
                  </form></tr>
                  ";
                  }
                }
              }
              ?>
              <tr class='filas_panel text-center'>
                <form action='' method='post'>
                  <td colspan='2'>Nuevo Pedido</td>
                  <td colspan="5"></td>
              </tr>
              <tr class='text-center filas_panel'>
                <td class='align-middle'><input type='text' name='add_cliente_input' class='text-center w-100 p-1' placeholder="Nº Cliente"></input></td>
                <td class='align-middle'><input type='text' name='add_prec_input' class='text-center w-100 p-1' placeholder="Precio"></input></td>
                <td class='align-middle'><input type='text' name='add_desc_input' class='text-center w-100 p-1' placeholder="Descuento"></input></td>
                <td class='align-middle'><input type='text' name='add_precFinal_input' class='text-center w-100 p-1' placeholder="Precio Final"></input></td>
                <td class='align-middle'><button type='submit' name='addPedido' class='btn btn-success'><i class='fas fa-plus'></i></button></td>
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
                echo "<a class='page-link' href='panelpedidos.php?pagActual=$pagAnterior' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
              }
              for ($i = 0; $i < $total_pags; $i++) {
                $pagi = $i + 1;
                if ($pagi == $pagActual) {
                  echo "<li class='page-item'><a class='page-link text-danger font-weight-bold' href='panelpedidos.php?pagActual=$pagi'>$pagi</a></li>";
                } else {
                  echo "<li class='page-item'><a class='page-link' href='panelpedidos.php?pagActual=$pagi'>$pagi</a></li>";
                }
              }
              $pagPosterior = $pagActual + 1;
              if ($pagActual >= $total_pags) {
                echo "<li class='page-item disabled'>";
                echo "<a class='page-link' href='' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
              } else {
                echo "<li class='page-item'>";
                echo "<a class='page-link' href='panelpedidos.php?pagActual=$pagPosterior' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
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
if (isset($_REQUEST['addPedido'])) {
  $cliente = $_REQUEST['add_cliente_input'];
  $prec = $_REQUEST['add_prec_input'];
  $desc = $_REQUEST['add_desc_input'];
  $precFinal = $_REQUEST['add_precFinal_input'];
  Base::nuevoPedidoPanel($cliente, $prec, $desc, $precFinal);
  echo "<script>location.href = 'paneldetallesped.php';</script>";
}


if (isset($_REQUEST['modificarPedido'])) {
  $codigo = $_REQUEST['codigo_input'];
  $cliente = $_REQUEST['cliente_input'];
  $prec = $_REQUEST['prec_input'];
  $desc = $_REQUEST['desc_input'];
  $precFinal = $_REQUEST['precFinal_input'];
  Base::modificarPedido($codigo, $cliente, $prec, $desc, $precFinal);
  echo "<script>location.href = 'panelpedidos.php';</script>";
}

if (isset($_REQUEST['eliminarPedido'])) {
  $codigo = $_REQUEST['codigo_input'];
  Base::eliminarDetallesPedido($codigo);
  Base::eliminarPedido($codigo);
  echo "<script>location.href = 'panelpedidos.php';</script>";
}

?>

</html>