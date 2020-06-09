<?php

session_start();
include_once("../../include/BD.php");
if (!isset($_SESSION['adminLogged']) || $_SESSION['adminLogged'] != true) {
  echo "<script>location.href = '../../index.php';</script>";
}

// Función paginación productos
$total_prods = Base::getTotalClientes();
$total_pags = $total_prods / 20;
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
              <li class="nav-item">
                <a class="nav-link panel_menu_links" href="paneldetallesped.php">DETALLES PEDIDOS</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link panel_menu_links" href="panelclientes.php">CLIENTES</a>
              </li>
              <li class="nav-item">
                <a class="nav-link panel_menu_links" href="panelusuarios.php">USUARIOS</a>
              </li>
            </ul>
          </div>
        </nav>

        <div class='col-12 mt-3' id='tabla_panel'>
          <h3 class='py-2 px-2 m-0 text-center'>TABLA CLIENTES</h3>
          <table class="table table-hover table-dark">
            <thead>
              <tr class="text-center header_panel">
                <th scope="col" class="align-middle">DNI</th>
                <th scope="col" class="align-middle">Nombre</th>
                <th scope="col" class="align-middle">Apellidos</th>
                <th scope="col" class="align-middle">Direccion</th>
                <th scope="col" class="align-middle">Teléfono</th>
                <th scope="col" class="align-middle">Email</th>
                <th scope="col" class="align-middle">Fecha Nacimiento</th>
                <th scope="col" class="align-middle">Usuario</th>
                <th scope="col" colspan="2"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $array_cls = Base::getClientesPag($pagLimit);
              if (isset($array_cls)) {
                if (sizeof($array_cls) > 0) {
                  foreach ($array_cls as $ac) {
                    $codigo = $ac->getCodigo();
                    $dni = $ac->getDni();
                    $nombre = $ac->getNombre();
                    $apell = $ac->getApellidos();
                    $dir = $ac->getDireccion();
                    $tel = $ac->getTelefono();
                    $email = $ac->getEmail();
                    $fNac = $ac->getFechaNacimiento();
                    $user = $ac->getUsuario();
                    echo "
                  <tr class='text-center filas_panel'>
                  <form action='' method='post'>
                  <td class='align-middle'><input type='text' name='dni_input' value='$dni' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='nombre_input' value='$nombre' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='apell_input' value='$apell' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='dir_input' value='$dir' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='tel_input' value='$tel' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='email_input' value='$email' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='fNac_input' value='$fNac' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='user_input' value='$user' class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><input type='text' name='codigo_input' value='$codigo' readonly class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><button type='submit' name='modificarCliente' class='btn btn-primary'><i class='fas fa-check'></i></button></td>
                  <td class='align-middle'><button type='submit' name='eliminarCliente' class='btn btn-danger'><i class='fas fa-trash-alt'></i></button></td>
                  </form></tr>
                  ";
                  }
                }
              }
              ?>
              <tr class='filas_panel text-center'>
                <form action='' method='post'>
                  <td colspan='2'>Nuevo Cliente</td>
                  <td colspan="6"></td>
              </tr>
              <tr class='text-center filas_panel'>
                <td class='align-middle'><input type='text' name='add_dni_input' class='text-center w-100 p-1' placeholder="DNI"></input></td>
                <td class='align-middle'><input type='text' name='add_nombre_input' class='text-center w-100 p-1' placeholder="Nombre"></input></td>
                <td class='align-middle'><input type='text' name='add_apell_input' class='text-center w-100 p-1' placeholder="Apellidos"></input></td>
                <td class='align-middle'><input type='text' name='add_dir_input' class='text-center w-100 p-1' placeholder="Dirección"></input></td>
                <td class='align-middle'><input type='text' name='add_tel_input' class='text-center w-100 p-1' placeholder="Teléfono"></input></td>
                <td class='align-middle'><input type='text' name='add_email_input' class='text-center w-100 p-1' placeholder="Email"></input></td>
                <td class='align-middle'><input type='text' name='add_fNac_input' class='text-center w-100 p-1' placeholder="Fecha Nacimiento"></input></td>
                <td class='align-middle'><input type='text' name='add_user_input' class='text-center w-100 p-1' placeholder="Usuario"></input></td>
                <td class='align-middle'><button type='submit' name='addCliente' class='btn btn-success'><i class='fas fa-plus'></i></button></td>
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
                echo "<a class='page-link' href='panelclientes.php?pagActual=$pagAnterior' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
              }
              for ($i = 0; $i < $total_pags; $i++) {
                $pagi = $i + 1;
                if ($pagi == $pagActual) {
                  echo "<li class='page-item'><a class='page-link text-danger font-weight-bold' href='panelclientes.php?pagActual=$pagi'>$pagi</a></li>";
                } else {
                  echo "<li class='page-item'><a class='page-link' href='panelclientes.php?pagActual=$pagi'>$pagi</a></li>";
                }
              }
              $pagPosterior = $pagActual + 1;
              if ($pagActual >= $total_pags) {
                echo "<li class='page-item disabled'>";
                echo "<a class='page-link' href='' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
              } else {
                echo "<li class='page-item'>";
                echo "<a class='page-link' href='panelclientes.php?pagActual=$pagPosterior' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
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
if (isset($_REQUEST['addCliente'])) {
  $dni = $_REQUEST['add_dni_input'];
  $nombre = $_REQUEST['add_nombre_input'];
  $apell = $_REQUEST['add_apell_input'];
  $dir = $_REQUEST['add_dir_input'];
  $tel = $_REQUEST['add_tel_input'];
  $email = $_REQUEST['add_email_input'];
  $fNac = $_REQUEST['add_fNac_input'];
  $user = $_REQUEST['add_user_input'];
  Base::nuevoCliente($dni, $nombre, $apell, $dir, $tel, $email, $fNac, $user);
  echo "<script>location.href = 'panelclientes.php';</script>";
}


if (isset($_REQUEST['modificarCliente'])) {
  $codigo = $_REQUEST['codigo_input'];
  $dni = $_REQUEST['dni_input'];
  $nombre = $_REQUEST['nombre_input'];
  $apell = $_REQUEST['apell_input'];
  $dir = $_REQUEST['dir_input'];
  $tel = $_REQUEST['tel_input'];
  $email = $_REQUEST['email_input'];
  $fNac = $_REQUEST['fNac_input'];
  $user = $_REQUEST['user_input'];
  Base::modificarClientePanel($codigo, $dni, $nombre, $apell, $dir, $tel, $email, $fNac, $user);
  echo "<script>location.href = 'panelclientes.php';</script>";
}

if (isset($_REQUEST['eliminarCliente'])) {
  $codigo = $_REQUEST['codigo_input'];
  $user = $_REQUEST['user_input'];
  Base::eliminarCliente($codigo);
  Base::eliminarUsuarioPorUser($user);
  echo "<script>location.href = 'panelclientes.php';</script>";
}

?>

</html>