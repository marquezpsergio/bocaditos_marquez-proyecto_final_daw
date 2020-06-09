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
    echo "<script>location.href = 'refrescos.php';</script>";
  } else {
    $_SESSION['ultimoAcceso'] = $ahora;
  }
} else {
  $_SESSION['ultimoAcceso'] = date("Y-n-j H:i:s");
}

if (!isset($_SESSION['arrayProdRef']) || !isset($_SESSION['arrayCantRef'])) {
  $_SESSION['arrayProdRef'] = array();
  $_SESSION['arrayCantRef'] = array();
}

// Iniciar el contador de carrito
if (!isset($_SESSION['cantidadCarrito'])) {
  $_SESSION['cantidadCarrito'] = 0;
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

      <!-- HEADER MENU -->
      <!-- HEADER MENU PEQUEÑO -->
      <div class="col-12 d-md-none" id="header_menu">
        <nav class="navbar navbar-light justify-content-center">

          <!-- MENÚ -->
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="bocadillos.php">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12 text-center"><img class="letra_header_menu" src="../img/B.png"></div>
                    <div class="col-12 text-center texto_header_menu mt-1"> BOCADILLOS </div>
                  </div>
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="hamburguesas.php">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12 text-center"><img class="letra_header_menu" src="../img/H.png"></div>
                    <div class="col-12 text-center texto_header_menu mt-1"> HAMBURGUESAS </div>
                  </div>
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="refrescos.php">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12 text-center"><img class="letra_header_menu" src="../img/R.png"></div>
                    <div class="col-12 text-center texto_header_menu mt-1"> REFRESCOS </div>
                  </div>
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="extras.php">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12 text-center"><img class="letra_header_menu" src="../img/E.png"></div>
                    <div class="col-12 text-center texto_header_menu mt-1"> EXTRAS </div>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </nav>
      </div>

      <!-- HEADER MENU MD -->
      <div class="col-12 d-none d-md-flex" id="header_menu">
        <div class="container-fluid">
          <div class="row">
            <div class="col-3 text-center">
              <a href="bocadillos.php"><img class="letra_header_menu" src="../img/B.png"><span class="texto_header_menu align-bottom">OCADILLOS</span></a>
            </div>
            <div class="col-3 text-center">
              <a href="hamburguesas.php"><img class="letra_header_menu" src="../img/H.png"><span class="texto_header_menu align-bottom">AMBURGUESAS</span></a>
            </div>
            <div class="col-3 text-center">
              <a href="refrescos.php"><img class="letra_header_menu" src="../img/R.png"><span class="texto_header_menu align-bottom">EFRESCOS</span></a>
            </div>
            <div class="col-3 text-center">
              <a href="extras.php"><img class="letra_header_menu" src="../img/E.png"><span class="texto_header_menu align-bottom">XTRAS</span></a>
            </div>
          </div>
        </div>
      </div>
      <!-- // HEADER MENU -->

    </div>
  </div>
  <!-- // HEADER -->

  <!-- CUERPO -->
  <!-- REFRESCOS -->
  <div class="container">
    <?php
    // MOSTRAR REFRESCOS
    $array_prods = Base::getRefrescos();
    if (isset($array_prods)) {
      if (sizeof($array_prods) > 0) {
        echo "<div class='row'>
            <div class='col-12'>
              <h2 class='text-warning text-center mt-4 font-weight-bold'>REFRESCOS</h4>
            </div>
          </div>";
        echo "<div class='row row-cols-1 row-cols-sm-2 row-cols-lg-3'>";
        foreach ($array_prods as $ap) {
          $codigo = $ap->getCodigo();
          $nombre = $ap->getNombre();
          $ingredientes = $ap->getIngredientes();
          $precio = $ap->getPrecio();
          $imagen = $ap->getImagen();

          echo "<div class='col mb-3'>
            <form method='get' action='' class='h-100 pb-2'>
              <div class='card h-100 bg-transparent'>
                  <input type='text' name='codigoRefresco' value='$codigo' hidden>
                  <input type='text' name='nombreRefresco' value='$nombre' hidden>
                  <input type='text' name='precioRefresco' value='$precio' hidden>
                  <div class='card-body mb-0'>
                    <span class='card-text mb-0'>
                    <div class='text-center mb-2'><img src='$imagen' class='card-img-top text-center w-25' alt='Sin Imagen'></div>
                    <h5 class='font-weight-bold text-warning'>$precio €</h5>
                    <h5 class='font-weight-bold text-warning'>$nombre</h5>
                      <p class='text-white mt-1'>$ingredientes</p>
                    </span>
                  </div>
                  <div class='align-bottom mt-0'>
                    <div class='text-center'>
                    <p class='text-white'><strong>Cantidad:</strong> <input type='number' name='cantidadRefresco' class='w-25 text-center' min='1' max='200' value='1'></p>
                    <button type='submit' name='addCarrito' class='btn btn-warning text-center mb-2'><i class='fas fa-shopping-cart'></i> Añadir al carrito</button>
                    </div>
                  </div>
              </div>
              </form>
            </div>";
        }
      }
    }

    if (isset($_REQUEST['addCarrito'])) {
      $codigo = $_REQUEST['codigoRefresco'];
      $cant = $_REQUEST['cantidadRefresco'];
      $prodExistente = false;
      for ($i = 0; $i < sizeof($_SESSION['arrayProdRef']); $i++) {
        if ($_SESSION['arrayProdRef'][$i] == $codigo) {
          $cantAnterior = $_SESSION['arrayCantRef'][$i];
          $newCant = $cantAnterior + $cant;
          $_SESSION['arrayCantRef'][$i] = $newCant;
          $prodExistente = true;
        }
      }
      if ($prodExistente == false) {
        array_push($_SESSION['arrayProdRef'], $codigo);
        array_push($_SESSION['arrayCantRef'], $cant);
        $_SESSION['cantidadCarrito'] += 1;
      }
      echo "<script>alert('Refresco añadido al carrito con éxito.')</script>";
    }
    ?>
  </div>
  <!-- // REFRESCOS -->
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