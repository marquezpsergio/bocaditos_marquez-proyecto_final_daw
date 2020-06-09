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

        </nav>
      </div>
      <!-- // HEADER TOP -->
    </div>
  </div>
  <!-- // HEADER -->

  <!-- CUERPO -->
  <div class="container" id="container_detallespedido">
    <div class="row">
      <div class='col-12 mt-3' id='miCuenta'>
        <a href='mispedidos.php' class='text-warning volverAtras'><i class="fas fa-chevron-left"></i> VOLVER ATRÁS</a>
      </div>
      <div class='col-12 mt-3' id='detallespedido'>
        <?php $codPedido = $_REQUEST['codigoPedido']; ?>
        <h5 class='py-2 px-2 m-0'><i class='fas fa-bread-slice'></i> DETALLES PEDIDO #<?php echo $codPedido ?></h5>
        <table class="table table-hover table-dark table-sm">
          <thead>
            <tr class="text-center header_tabla_detallespedidos">
              <th scope="col" class="align-middle">Código Producto</th>
              <th scope="col" class="align-middle">Producto</th>
              <th scope="col" class="align-middle">Precio</th>
              <th scope="col" class="align-middle">Cantidad</th>
              <th scope="col" class="align-middle">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $array_det = Base::getDetallesPedido($codPedido);
            $precioTotal = 0;
            if (isset($array_det)) {
              if (sizeof($array_det) > 0) {
                foreach ($array_det as $ad) {
                  $codProducto = $ad->getCodigoProducto();
                  $array_prods = Base::getProducto($codProducto);
                  if (isset($array_prods)) {
                    if (sizeof($array_prods) > 0) {
                      foreach ($array_prods as $ap) {
                        $cantidad = $ad->getCantidad();
                        $nombreProd = $ap->getNombre();
                        $ingProd = $ap->getIngredientes();
                        if ($ingProd != "") {
                          $ingProd = "(" . $ingProd . ")";
                        }
                        $precioUnidad = $ap->getPrecio();
                        $precioTotalUnidad = $ad->getPrecio();
                        $precioTotal = $precioTotal + $precioTotalUnidad;
                        $precioTotal = number_format($precioTotal, 2);
                        echo "<tr class='text-center filas_tabla_detallespedidos'>
                    <td class='align-middle'>$codProducto</td>
                    <td class='align-middle'>$nombreProd $ingProd</td>
                    <td class='align-middle'>" . $precioUnidad . "€</td>
                    <td class='align-middle'>$cantidad</td>
                    <td class='align-middle'>" . $precioTotalUnidad . "€</td>
                    </tr>";
                      }
                    }
                  }
                }
              }
            }
            ?>
            <tr><td colspan='5'></td></tr>
            <tr class="text-center header_tabla_detallespedidos mt-2">
              <th scope="col" class="align-middle text-right" colspan='3'>SUBTOTAL</th>
              <th scope="col" class="align-middle text-right">DESCUENTO</th>
              <th scope="col" class="align-middle text-right">TOTAL</th>
            </tr>
            <?php
            $descuento = Base::getDescuentoPedido($codPedido);
            if ($descuento > 0){
              $precioFinal = $precioTotal * $descuento / 100;
              $precioFinal = number_format($precioFinal, 2);
            } else {
              $precioFinal = $precioTotal;
            }
            
            echo "<tr class='text-center filas_tabla_detallespedidos'>
                <td class='align-middle text-right' colspan='3'>" . $precioTotal . "€</td>
                <td class='align-middle text-right'>" . $descuento . "%</td>
                <td class='align-middle text-right'>" . $precioFinal . "€</td>
                </tr>";
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