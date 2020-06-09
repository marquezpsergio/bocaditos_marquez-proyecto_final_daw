<?php

session_start();
include_once("../include/BD.php");

// Comprobar sesión. Si lleva más de 6 horas, se borra.
if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == true)) {
  $fecha_guardada = $_SESSION['ultimoAcceso'];
  $ahora = date("Y-n-j H:i:s");
  $tiempo_pasado = (strtotime($ahora) - strtotime($fecha_guardada));
  if ($tiempo_pasado >= 21600) {
    session_destroy();
    echo "<script>location.href = 'carrito.php';</script>";
  } else {
    $_SESSION['ultimoAcceso'] = $ahora;
  }
} else {
  $_SESSION['ultimoAcceso'] = date("Y-n-j H:i:s");
}

// Mandar a login si no está logeado
if (!isset($_SESSION['loggedIn'])) {
  echo "<script>alert('Debe iniciar sesión para finalizar el pedido.')</script>";
  echo "<script>location.href = '../index.php#inicioSesion';</script>";
}

// Insertar pedido
$codUsuario = $_SESSION['codUsuario'];
$usuario = $_SESSION['usuario'];
$subtotal = $_SESSION['subtotal'];
$descuento = $_SESSION['descuento'];
$final = $_SESSION['total'];
Base::nuevoPedido($codUsuario, $subtotal, $descuento, $final);

// Obtener código del pedido
$codCliente = Base::getCodigoClientePorUser($usuario);
$array_peds = Base::getUltimoPedidoCliente($codCliente);
$codPedido = 0;
foreach ($array_peds as $ap) {
  $codPedido = $ap[0];
}
?>
<html lang="es">

<head>
  <!-- Etiquetas meta -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="Bocatería y hamburguesería Márquez" />
  <meta name="keywords" content="cenas jerez, bocadillos jerez, bocateria jerez, hamburguesas jerez,  hamburgueseria jerez, servicio a domicilio" />
  <meta name="author" content="Sergio Márquez" />
  <!-- Bootstrap CSS y FontAwesome -->
  <link rel="stylesheet" href="../librerias/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../librerias/fontawesome/css/all.css">
  <link rel="stylesheet" href="../estilos/estilos_productos.css">
  <!-- JavaScript: jQuery y Bootstrap JS -->
  <script src="../librerias/jquery/jquery-3.4.1.min.js"></script>
  <script src="../librerias/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../enlaces/main.js"></script>
  <title>Bocaditos Márquez | Servicio a Domicilio | Tu bocatería preferida</title>
</head>

<body>
  <!-- HEADER -->
  <div class="container">
    <div class="row">

      <!-- HEADER TOP -->
      <div class="col-12">
        <nav class="navbar navbar-light" id="header_top">

          <!-- LOGO -->
          <a class="navbar-brand" href="../index.php">
            <img src="../img/Logo.png" alt="Logo" id="img_logo">
          </a>

          <!-- MENÚ ACCESO y CARRITO -->
          <ul class="nav justify-content-end">
            <li class="nav-item" onmouseover="color_acceso();" onmouseout="color_acceso_normal();">
              <div class="container-fluid">
                <a class="nav-link" href='<?php
                                          // Si hay sesión, redirige a 'Mi Cuenta', si no, irá a 'Inicio Sesión'.
                                          if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == true)) {
                                            echo "../index.php#miCuenta";
                                          } else {
                                            echo "../index.php#inicioSesion";
                                          }
                                          ?>'>
                  <div class="row">
                    <div class="col-12 text-center ">
                      <i class="fas fa-user" id="acceso_icono"></i>
                    </div>
                    <div class="col-12 text-center"><span id="acceso_texto">
                        <?php
                        // Si hay sesión, aparecerá 'MI CUENTA', si no, aparecerá "ACCESO" para iniciar sesión.
                        if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == true)) {
                          echo $_SESSION['usuario'];
                        } else {
                          echo "ACCESO";
                        }
                        ?></span></div>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item" onmouseover="color_carrito();" onmouseout="color_carrito_normal();">
              <div class="container-fluid">
                <a class="nav-link" href="carrito.php">
                  <div class="row">
                    <div class="col-12 text-center ">
                      <i class="fas fa-shopping-cart" id="carrito_icono"></i>
                    </div>
                    <div class="col-12 text-center"><span id="carrito_texto">CARRITO</span>
                      <span class="badge badge-primary p-1" id="carrito_num"><?php echo $_SESSION['cantidadCarrito']; ?></span>
                    </div>
                  </div>
                </a>
              </div>
            </li>
          </ul>
        </nav>
      </div>
      <!-- // HEADER TOP -->


    </div>
  </div>
  <!-- // HEADER -->

  <!-- CUERPO -->
  <div class="container" id='container_carrito'>
    <div class="row">
      <div class="col-12 m-0 p-0 mt-2 w-100">
        <div class="p-0 m-0 mb-1 py-2 bg-dark text-center">
          <h3 class='text-warning m-0'>¡PEDIDO REALIZADO CON ÉXITO!</h3>
          <span class='text-white'>¡GRACIAS POR CONFIAR EN NOSOTROS!</span>
        </div>
      </div>
      <div class="col-12 m-auto px-1 bg-dark">
        <h5 class='text-white text-center tuPedido py-2'><i class="fas fa-shopping-cart"></i> TU PEDIDO</h5>
        <div class="container-fluid">
          <div class="row">
            <div class='col-2 col-md-3 m-0 p-0 mb-1 text-center'>
              <span class='text-white headerTuPedido'>CANTIDAD</span>
            </div>
            <div class='col-8 col-md-6 m-0 p-0 mb-1 text-center'>
              <span class='text-white headerTuPedido'>PRODUCTO</span>
            </div>
            <div class='col-2 col-md-3 p-0 mb-1 text-center'>
              <span class='text-white headerTuPedido'>PRECIO</span>
            </div>
            <?php
            // BOCADILLOS
            if (isset($_SESSION['arrayProdBoc'])) {
              if (sizeof($_SESSION['arrayProdBoc']) > 0) {
                for ($i = 0; $i < sizeof($_SESSION['arrayProdBoc']); $i++) {
                  $codArray = $_SESSION['arrayProdBoc'][$i];
                  $cantArray = $_SESSION['arrayCantBoc'][$i];
                  $producto = Base::getProducto($codArray);
                  foreach ($producto as $p) {
                    $codProducto = $p->getCodigo();
                    $nombre = $p->getNombre();
                    $ingred = $p->getIngredientes();
                    $precio = $p->getPrecio();
                    $tipo = $p->getTipo();
                    $img = $p->getImagen();
                    echo "<div class='col-2 col-md-3 m-0 p-0 mb-1 text-center'>
                    <span class='text-white'>$cantArray</span>
                    </div>
                    <div class='col-8 col-md-6 m-0 p-0 mb-1 text-center'>
                    <span class='text-white'>$nombre ($tipo)</span>
                    </div>
                    <div class='col-2 col-md-3 p-0 mb-1 text-center'>
                    <span class='text-white'>" . $precio . "€</span>
                    </div>";
                    $precioTotalProds = $precio * $cantArray;
                    Base::nuevoDetalle($codPedido, $codProducto, $cantArray, $precioTotalProds);
                  }
                }
              }
            }
            // HAMBURGUESAS
            if (isset($_SESSION['arrayProdHam'])) {
              if (sizeof($_SESSION['arrayProdHam']) > 0) {
                for ($i = 0; $i < sizeof($_SESSION['arrayProdHam']); $i++) {
                  $codArray = $_SESSION['arrayProdHam'][$i];
                  $cantArray = $_SESSION['arrayCantHam'][$i];
                  $producto = Base::getProducto($codArray);
                  foreach ($producto as $p) {
                    $codProducto = $p->getCodigo();
                    $nombre = $p->getNombre();
                    $ingred = $p->getIngredientes();
                    $precio = $p->getPrecio();
                    $tipo = $p->getTipo();
                    $img = $p->getImagen();
                    echo "<div class='col-2 col-md-3 m-0 p-0 mb-1 text-center'>
                    <span class='text-white'>$cantArray</span>
                    </div>
                    <div class='col-8 col-md-6 m-0 p-0 mb-1 text-center'>
                    <span class='text-white'>$nombre ($tipo)</span>
                    </div>
                    <div class='col-2 col-md-3 p-0 mb-1 text-center'>
                    <span class='text-white'>" . $precio . "€</span>
                    </div>";
                    $precioTotalProds = $precio * $cantArray;
                    Base::nuevoDetalle($codPedido, $codProducto, $cantArray, $precioTotalProds);
                  }
                }
              }
            }
            // SANDWICHES
            if (isset($_SESSION['arrayProdSan'])) {
              if (sizeof($_SESSION['arrayProdSan']) > 0) {
                for ($i = 0; $i < sizeof($_SESSION['arrayProdSan']); $i++) {
                  $codArray = $_SESSION['arrayProdSan'][$i];
                  $cantArray = $_SESSION['arrayCantSan'][$i];
                  $producto = Base::getProducto($codArray);
                  foreach ($producto as $p) {
                    $codProducto = $p->getCodigo();
                    $nombre = $p->getNombre();
                    $ingred = $p->getIngredientes();
                    $precio = $p->getPrecio();
                    $tipo = $p->getTipo();
                    $img = $p->getImagen();
                    echo "<div class='col-2 col-md-3 m-0 p-0 mb-1 text-center'>
                    <span class='text-white'>$cantArray</span>
                    </div>
                    <div class='col-8 col-md-6 m-0 p-0 mb-1 text-center'>
                    <span class='text-white'>$nombre ($tipo)</span>
                    </div>
                    <div class='col-2 col-md-3 p-0 mb-1 text-center'>
                    <span class='text-white'>" . $precio . "€</span>
                    </div>";
                    $precioTotalProds = $precio * $cantArray;
                    Base::nuevoDetalle($codPedido, $codProducto, $cantArray, $precioTotalProds);
                  }
                }
              }
            }
            // EXTRAS
            if (isset($_SESSION['arrayProdExt'])) {
              if (sizeof($_SESSION['arrayProdExt']) > 0) {
                for ($i = 0; $i < sizeof($_SESSION['arrayProdExt']); $i++) {
                  $codArray = $_SESSION['arrayProdExt'][$i];
                  $cantArray = $_SESSION['arrayCantExt'][$i];
                  $producto = Base::getProducto($codArray);
                  foreach ($producto as $p) {
                    $codProducto = $p->getCodigo();
                    $nombre = $p->getNombre();
                    $ingred = $p->getIngredientes();
                    $precio = $p->getPrecio();
                    $tipo = $p->getTipo();
                    $img = $p->getImagen();
                    echo "<div class='col-2 col-md-3 m-0 p-0 mb-1 text-center'>
                    <span class='text-white'>$cantArray</span>
                    </div>
                    <div class='col-8 col-md-6 m-0 p-0 mb-1 text-center'>
                    <span class='text-white'>$nombre ($tipo)</span>
                    </div>
                    <div class='col-2 col-md-3 p-0 mb-1 text-center'>
                    <span class='text-white'>" . $precio . "€</span>
                    </div>";
                    $precioTotalProds = $precio * $cantArray;
                    Base::nuevoDetalle($codPedido, $codProducto, $cantArray, $precioTotalProds);
                  }
                }
              }
            }
            // REFRESCOS
            if (isset($_SESSION['arrayProdRef'])) {
              if (sizeof($_SESSION['arrayProdRef']) > 0) {
                for ($i = 0; $i < sizeof($_SESSION['arrayProdRef']); $i++) {
                  $codArray = $_SESSION['arrayProdRef'][$i];
                  $cantArray = $_SESSION['arrayCantRef'][$i];
                  $producto = Base::getProducto($codArray);
                  foreach ($producto as $p) {
                    $codProducto = $p->getCodigo();
                    $nombre = $p->getNombre();
                    $ingred = $p->getIngredientes();
                    $precio = $p->getPrecio();
                    $tipo = $p->getTipo();
                    $img = $p->getImagen();
                    echo "<div class='col-2 col-md-3 m-0 p-0 mb-1 text-center'>
                    <span class='text-white'>$cantArray</span>
                    </div>
                    <div class='col-8 col-md-6 m-0 p-0 mb-1 text-center'>
                    <span class='text-white'>$nombre ($tipo)</span>
                    </div>
                    <div class='col-2 col-md-3 p-0 mb-1 text-center'>
                    <span class='text-white'>" . $precio . "€</span>
                    </div>";
                    $precioTotalProds = $precio * $cantArray;
                    Base::nuevoDetalle($codPedido, $codProducto, $cantArray, $precioTotalProds);
                  }
                }
              }
            }
            ?>
            <?php
            $subt = $_SESSION['subtotal'];
            echo "<div class='col-10 col-md-9'></div>
            <div class='col-2 col-md-3 m-0 p-0 mt-1 text-center'>
              <span class='text-warning subtotal pt-1'>" . number_format($subt, 2) . "€ </span>
            </div>";

            if ($_SESSION['descuento'] > 0) {
              $desc = $_SESSION['descuento'];
              echo "<div class='col-12 m-0 p-0 my-2 text-center'>
              <span class='text-warning'>DESCUENTO " . $desc . "% </span>
              </div>";
            }
            $total = $_SESSION['total'];
            echo "<div class='col-12 m-0 p-0 my-2 text-center'>
              <h5 class='text-white'><span class='bg-info p-2 px-3'>TOTAL: " . number_format($total, 2) . "€ </span></h5>
              </div>";
            ?>
          </div>
        </div>
      </div>
      <div class="col-12 m-0 p-0 mt-1 w-100">
        <div class="p-0 m-0 py-2 bg-warning text-center">
          <?php
          if (isset($_REQUEST['metodoEnvio'])) {
            $metodo = $_REQUEST['metodoEnvio'];
            if ($metodo == "recogida") {
              echo "<span class='p-1'>Usted podrá recoger su pedido en nuestro local en unos 30 minutos.</span>";
            }
            if ($metodo == "domicilio") {
              $direccion = $_SESSION['direccion'];
              echo "<span class='p-1'>El pedido será entregado en un plazo de 30 minutos en la siguiente dirección:</span><br/>";
              echo "<span class='text-center font-weight-bold'>$direccion</span><br/>";
            }
          } else {
            $metodo = $_SESSION['metodoEnvio'];
            if ($metodo == "recogida") {
              echo "<span class='p-1'>Usted podrá recoger su pedido en nuestro local en unos 30 minutos.</span>";
            }
            if ($metodo == "domicilio") {
              $direccion = $_SESSION['direccion'];
              echo "<span class='p-1'>El pedido será entregado en un plazo de 30 minutos en la siguiente dirección:</span><br/>";
              echo "<span class='text-center font-weight-bold'>$direccion</span><br/>";
            }
          }
          ?>
        </div>
      </div>
      <div class="col-12 m-0 p-0 w-100 mt-3 text-center">
        <a href="../index.php" class='text-white'>Volver a la página principal</a>
      </div>
    </div>
  </div>
  <!-- // CUERPO -->

  <!-- FOOTER -->
  <div class="container mt-3">
    <div class="row">
      <div class="col-12 py-2" id="redsoc_footer">
        <ul class="nav justify-content-center">
          <li class="nav-item">
            <a class="nav-link" href="http://www.facebook.es"><img src="../img/facebook.png" alt="facebook" class="red_social"></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://www.twitter.es" alt="twitter"><img src="../img/twitter.png" class="red_social"></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://www.instagram.com"><img src="../img/instagram.png" alt="instagram" class="red_social"></a>
          </li>
        </ul>
      </div>
      <div class="col-12 py-3 text-center">
        <span id="texto_footer">@2020 Bocatería Márquez. Todos los derechos reservados. <a href='loginpanel.php' class='url_admin'>Admin.</a></span>
      </div>
    </div>
  </div>
  <!-- // FOOTER -->

</body>
<?php
// VACIAR VARIABLES DE SESIÓN
$_SESSION['subtotal'] = 0;
$_SESSION['arrayProdBoc'] = array();
$_SESSION['arrayCantBoc'] = array();
$_SESSION['arrayProdHam'] = array();
$_SESSION['arrayCantHam'] = array();
$_SESSION['arrayProdSan'] = array();
$_SESSION['arrayCantSan'] = array();
$_SESSION['arrayProdRef'] = array();
$_SESSION['arrayCantRef'] = array();
$_SESSION['arrayProdExt'] = array();
$_SESSION['arrayCantExt'] = array();
$_SESSION['descuento'] = 0;
$_SESSION['total'] = 0;
$_SESSION['cantidadCarrito'] = 0;
$_SESSION['paymentID'] = "";
$_SESSION['payerID'] = "";
$_SESSION['token'] = "";
?>

</html>