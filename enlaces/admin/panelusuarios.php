<?php

session_start();

include_once("../../include/BD.php");
if (!isset($_SESSION['adminLogged']) || $_SESSION['adminLogged'] != true) {
  echo "<script>location.href = '../../index.php';</script>";
}

// Función paginación productos
$total_prods = Base::getTotalUsers();
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
              <li class="nav-item">
                <a class="nav-link panel_menu_links" href="panelclientes.php">CLIENTES</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link panel_menu_links" href="panelusuarios.php">USUARIOS</a>
              </li>
            </ul>
          </div>
        </nav>

        <div class='col-12 mt-3' id='tabla_panel'>
          <h3 class='py-2 px-2 m-0 text-center'>TABLA USUARIOS</h3>
          <table class="table table-hover table-dark">
            <thead>
              <tr class="text-center header_panel">
                <th scope="col" class="align-middle" colspan="2">Usuario</th>
                <th scope="col" class="align-middle" colspan="2">Tipo</th>
                <th scope="col" class="align-middle">Nº Usuario</th>
                <th scope="col" colspan="2"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $array_users = Base::getUsuariosPag($pagLimit);
              if (isset($array_users)) {
                if (sizeof($array_users) > 0) {
                  foreach ($array_users as $au) {
                    $codigo = $au->getCodigo();
                    $user = $au->getUsuario();
                    $tipo = $au->getTipo();
                    echo "
                  <tr class='text-center filas_panel'>
                  <form action='' method='post'>
                  <td class='align-middle' colspan='2'><input type='text' name='user_input' value='$user' readonly class='text-center w-100 p-1'></input></td>
                  <td class='align-middle' colspan='2'><select name='tipo_input' class='text-center w-100 p-1'>";

                    if ($tipo == "Administrador") {
                      echo "<option value='Administrador' selected>Administrador</option><option value='Usuario'>Usuario</option>";
                    } else {
                      echo "<option value='Administrador'>Administrador</option><option value='Usuario' selected>Usuario</option>";
                    }
                    echo "</select></td>
                  <td class='align-middle'><input type='text' name='codigo_input' value='$codigo' readonly class='text-center w-100 p-1'></input></td>
                  <td class='align-middle'><button type='submit' name='modificarUser' class='btn btn-primary'><i class='fas fa-check'></i></button></td>
                  <td class='align-middle'><button type='submit' name='eliminarUser' class='btn btn-danger'><i class='fas fa-trash-alt'></i></button></td>
                  </form></tr>";
                  }
                }
              }
              ?>
              <tr class='filas_panel text-center'>
                <form action='' method='post'>
                  <td colspan='2'>Nuevo Usuario</td>
                  <td colspan="6"></td>
              </tr>
              <tr class='text-center filas_panel'>
                <td class='align-middle'><input type='text' name='add_user_input' class='text-center w-100 p-1' placeholder="Usuario"></input></td>
                <td class='align-middle'><input type='text' name='add_pass_input' class='text-center w-100 p-1' placeholder="Password"></input></td>
                <td class='align-middle'><input type='text' name='add_tipo_input' class='text-center w-100 p-1' placeholder="Tipo"></input></td>
                <td class='align-middle'><select name='add_tipo_input' class='text-center w-100 p-1'>
                    <option value='Administrador'>Administrador</option>
                    <option value='Administrador'>Usuario</option>
                  </select></td>
                <td class='align-middle'><button type='submit' name='addUsuario' class='btn btn-success'><i class='fas fa-plus'></i></button></td>
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
                echo "<a class='page-link' href='panelusuarios.php?pagActual=$pagAnterior' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
              }
              for ($i = 0; $i < $total_pags; $i++) {
                $pagi = $i + 1;
                if ($pagi == $pagActual) {
                  echo "<li class='page-item'><a class='page-link text-danger font-weight-bold' href='panelusuarios.php?pagActual=$pagi'>$pagi</a></li>";
                } else {
                  echo "<li class='page-item'><a class='page-link' href='panelusuarios.php?pagActual=$pagi'>$pagi</a></li>";
                }
              }
              $pagPosterior = $pagActual + 1;
              if ($pagActual >= $total_pags) {
                echo "<li class='page-item disabled'>";
                echo "<a class='page-link' href='' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
              } else {
                echo "<li class='page-item'>";
                echo "<a class='page-link' href='panelusuarios.php?pagActual=$pagPosterior' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
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
if (isset($_REQUEST['addUsuario'])) {
  $user = $_REQUEST['add_user_input'];
  $pass = $_REQUEST['add_pass_input'];
  $tipo = $_REQUEST['add_tipo_input'];
  Base::nuevoUsuarioPanel($user, $pass, $tipo);
  echo "<script>location.href = 'panelusuarios.php';</script>";
}


if (isset($_REQUEST['modificarUsuario'])) {
  $codigo = $_REQUEST['codigo_input'];
  $user = $_REQUEST['user_input'];
  $pass = $_REQUEST['pass_input'];
  $tipo = $_REQUEST['tipo_input'];
  Base::modificarUsuario($codigo, $nombre, $pass, $tipo);
  echo "<script>location.href = 'panelusuarios.php';</script>";
}

if (isset($_REQUEST['eliminarUsuario'])) {
  $codigo = $_REQUEST['codigo_input'];
  $user = $_REQUEST['user_input'];
  Base::eliminarUsuario($codigo);
  Base::eliminarClientePorUser($user);
  echo "<script>location.href = 'panelusuarios.php';</script>";
}

?>

</html>