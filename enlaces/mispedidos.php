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
    echo "<script>location.href = 'index.php';</script>";
  } else {
    $_SESSION['ultimoAcceso'] = $ahora;
  }
} else {
  $_SESSION['ultimoAcceso'] = date("Y-n-j H:i:s");
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
  <script>
    window.onload = function() {
      $("#usuario_input").focusout(cargarDatosUser);
    };
  </script>
</head>

<body>
  <!-- HEADER -->
  <div class="container mb-2">
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
  <div class="container" id="container_mispedidos">
    <div class="row">
      <div class='col-12 col-lg-3 mt-3' id='miCuenta'>
        <div class='container-fluid'>
          <div class='row list-group'>
            <div class='list-group-item col-12 text-center m-0' id='miCuenta_h5'>
              <h5>MI CUENTA</h5>
            </div>
            <a href='miperfil.php' class='list-group-item list-group-item-action miCuenta_a'><i class='fas fa-user'></i> MI PERFIL</a>
            <a href='mispedidos.php' class='list-group-item list-group-item-action miCuenta_a'><i class='fas fa-utensils'></i> MIS PEDIDOS</a>
            <a href='../index.php?logOut=' class='list-group-item list-group-item-action miCuenta_a'><i class='fas fa-sign-out-alt'></i> CERRAR SESIÓN</a>
          </div>
        </div>
      </div>
      <div class='col-12 col-lg-9 mt-3' id='mispedidos'>
        <h3 class='py-2 px-2 m-0'><i class='fas fa-bread-slice'></i> MIS PEDIDOS</h3>
        <table class="table table-hover table-dark">
          <thead>
            <tr class="text-center header_tabla_pedidos">
              <th scope="col" class="align-middle">Nº Pedido</th>
              <th scope="col" class="align-middle">Precio Pedido</th>
              <th scope="col" class="align-middle">Descuento</th>
              <th scope="col" class="align-middle">Precio Final</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $codigoUser = Base::getCodigoClientePorUser($_SESSION['usuario']);
            $array_peds = Base::getPedidosCliente($codigoUser);
            if (isset($array_peds)) {
              if (sizeof($array_peds) > 0) {
                foreach ($array_peds as $ap) {
                  $codigo = $ap->getCodigo();
                  $precio = $ap->getPrecio();
                  $descuento = $ap->getDescuento();
                  $precioFinal = $ap->getPrecioFinal();
                  echo "<tr class='text-center filas_tabla_pedidos'>
                  <td class='align-middle'>$codigo</td>
                  <td class='align-middle'>" . $precio . "€</td>
                  <td class='align-middle'>" . $descuento . "%</td>
                  <td class='align-middle'>" . $precioFinal . "€</td>
                  <td class='align-middle'><a href='detallespedido.php?codigoPedido=$codigo' class='text-center text-warning text-decoration-none'><i class='fas fa-bread-slice'></i> Ver detalles</a></td>
                  </tr>";
                }
              }
            }
            ?>
          </tbody>
        </table>
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

</html>