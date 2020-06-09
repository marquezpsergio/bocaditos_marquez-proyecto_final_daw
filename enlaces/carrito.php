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


    </div>
  </div>
  <!-- // HEADER -->

  <!-- CUERPO -->
  <div class="container" id='container_carrito'>
    <div class="row">
      <div class='col-12 col-md-9 mt-3'>
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 pt-2 px-2 m-0 bg-dark">
              <h5 class='text-white'><i class="fas fa-shopping-cart"></i> CARRITO (<?php echo $_SESSION['cantidadCarrito']; ?>)</h5>
            </div>
            <div class="col-12">
              <div class="container-fluid">
                <?php
                $contadorProds = 0;
                // BOCADILLOS
                $subtotal = 0;
                if (isset($_SESSION['arrayProdBoc'])) {
                  if (sizeof($_SESSION['arrayProdBoc']) > 0) {
                    for ($i = 0; $i < sizeof($_SESSION['arrayProdBoc']); $i++) {
                      $codArray = $_SESSION['arrayProdBoc'][$i];
                      $cantArray = $_SESSION['arrayCantBoc'][$i];
                      $producto = Base::getProducto($codArray);
                      foreach ($producto as $p) {
                        $contadorProds += 1;
                        $nombre = $p->getNombre();
                        $ingred = $p->getIngredientes();
                        $precio = $p->getPrecio();
                        $subtotal += $precio * $cantArray;
                        $tipo = $p->getTipo();
                        $img = $p->getImagen();
                        echo "<div class='row mt-3 mb-4 text-white'>
                        <div class='col-4 col-lg-3 text-center pt-3'><img src='$img' width='100%'/></div>
                        <div class='col-6 col-lg-7'>
                          <div class='container-fluid'>
                          <div class='row'>
                            <div class='col-12'><span class='nombreProd'>$nombre</span> <span class='tipoProd'>($tipo)</span></div>
                            <div class='col-12 ingredProd'>$ingred</div>
                            <div class='col-12 mt-3 cantProd'><form method='post'>Cantidad: <input type='number' value='$cantArray' name='cantProd' class='text-center align-middle' min='1' max='200'></input>
                            <input type='text' name='codProd' value='$codArray' hidden></input>
                            <input type='text' name='tipoProd' value='$tipo' hidden></input>
                            <button type='submit' name='actualizarCarrito' class='btn btn-info p-0 m-0 px-1 mt-1 mt-lg-0 productoButton'>Actualizar</button>
                            <button type='submit' name='eliminarCarrito' class='btn btn-danger p-0 m-0 px-1 mt-1 mt-lg-0 productoButton'>Eliminar</button>
                            </form></div>
                          </div>
                          </div>
                        </div>
                        <div class='col-2 text-center font-weight-bold'>" . $precio . "€</div>
                        </div>";
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
                        $contadorProds += 1;
                        $nombre = $p->getNombre();
                        $ingred = $p->getIngredientes();
                        $precio = $p->getPrecio();
                        $subtotal += $precio * $cantArray;
                        $tipo = $p->getTipo();
                        $img = $p->getImagen();
                        echo "<div class='row mt-3 mb-4 text-white'>
                        <div class='col-4 col-lg-3 text-center pt-3'><img src='$img' width='100%'/></div>
                        <div class='col-6 col-lg-7'>
                          <div class='container-fluid'>
                          <div class='row'>
                            <div class='col-12'><span class='nombreProd'>$nombre</span> <span class='tipoProd'>($tipo)</span></div>
                            <div class='col-12 ingredProd'>$ingred</div>
                            <div class='col-12 mt-3 cantProd'><form method='post'>Cantidad: <input type='number' value='$cantArray' name='cantProd' class='text-center align-middle' min='1' max='200'></input>
                            <input type='text' name='codProd' value='$codArray' hidden></input>
                            <input type='text' name='tipoProd' value='$tipo' hidden></input>
                            <button type='submit' name='actualizarCarrito' class='btn btn-info p-0 m-0 px-1 mt-1 mt-lg-0 productoButton'>Actualizar</button>
                            <button type='submit' name='eliminarCarrito' class='btn btn-danger p-0 m-0 px-1 mt-1 mt-lg-0 productoButton'>Eliminar</button>
                            </form></div>
                          </div>
                          </div>
                        </div>
                        <div class='col-2 text-center font-weight-bold'>" . $precio . "€</div>
                        </div>";
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
                        $contadorProds += 1;
                        $nombre = $p->getNombre();
                        $ingred = $p->getIngredientes();
                        $precio = $p->getPrecio();
                        $subtotal += $precio * $cantArray;
                        $tipo = $p->getTipo();
                        $img = $p->getImagen();
                        echo "<div class='row mt-3 mb-4 text-white'>
                        <div class='col-4 col-lg-3 text-center pt-1'><img src='$img' width='100%'/></div>
                        <div class='col-6 col-lg-7'>
                          <div class='container-fluid'>
                          <div class='row'>
                            <div class='col-12'><span class='nombreProd'>$nombre</span> <span class='tipoProd'>($tipo)</span></div>
                            <div class='col-12 ingredProd'>$ingred</div>
                            <div class='col-12 mt-3 cantProd'><form method='post'>Cantidad: <input type='number' value='$cantArray' name='cantProd' class='text-center align-middle' min='1' max='200'></input>
                            <input type='text' name='codProd' value='$codArray' hidden></input>
                            <input type='text' name='tipoProd' value='$tipo' hidden></input>
                            <button type='submit' name='actualizarCarrito' class='btn btn-info p-0 m-0 px-1 mt-1 mt-lg-0 productoButton'>Actualizar</button>
                            <button type='submit' name='eliminarCarrito' class='btn btn-danger p-0 m-0 px-1 mt-1 mt-lg-0 productoButton'>Eliminar</button>
                            </form></div>
                          </div>
                          </div>
                        </div>
                        <div class='col-2 text-center font-weight-bold'>" . $precio . "€</div>
                        </div>";
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
                        $contadorProds += 1;
                        $nombre = $p->getNombre();
                        $ingred = $p->getIngredientes();
                        $precio = $p->getPrecio();
                        $subtotal += $precio * $cantArray;
                        $tipo = $p->getTipo();
                        $img = $p->getImagen();
                        echo "<div class='row mt-3 mb-4 text-white'>
                        <div class='col-4 col-lg-3 text-center pt-1'><img src='$img' width='100%'/></div>
                        <div class='col-6 col-lg-7'>
                          <div class='container-fluid'>
                          <div class='row'>
                            <div class='col-12'><span class='nombreProd'>$nombre</span> <span class='tipoProd'>($tipo)</span></div>
                            <div class='col-12 ingredProd'>$ingred</div>
                            <div class='col-12 mt-3 cantProd'><form method='post'>Cantidad: <input type='number' value='$cantArray' name='cantProd' class='text-center align-middle' min='1' max='200'></input>
                            <input type='text' name='codProd' value='$codArray' hidden></input>
                            <input type='text' name='tipoProd' value='$tipo' hidden></input>
                            <button type='submit' name='actualizarCarrito' class='btn btn-info p-0 m-0 px-1 mt-1 mt-lg-0 productoButton'>Actualizar</button>
                            <button type='submit' name='eliminarCarrito' class='btn btn-danger p-0 m-0 px-1 mt-1 mt-lg-0 productoButton'>Eliminar</button>
                            </form></div>
                          </div>
                          </div>
                        </div>
                        <div class='col-2 text-center font-weight-bold'>" . $precio . "€</div>
                        </div>";
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
                        $contadorProds += 1;
                        $nombre = $p->getNombre();
                        $ingred = $p->getIngredientes();
                        $precio = $p->getPrecio();
                        $subtotal += $precio * $cantArray;
                        $tipo = $p->getTipo();
                        $img = $p->getImagen();
                        echo "<div class='row mt-3 mb-4 text-white'>
                        <div class='col-4 col-lg-3 text-center pt-1'><img src='$img' width='50%'/></div>
                        <div class='col-6 col-lg-7'>
                          <div class='container-fluid'>
                          <div class='row'>
                            <div class='col-12'><span class='nombreProd'>$nombre</span> <span class='tipoProd'>($tipo)</span></div>
                            <div class='col-12 ingredProd'>$ingred</div>
                            <div class='col-12 mt-3 cantProd'><form method='post'>Cantidad: <input type='number' value='$cantArray' name='cantProd' class='text-center align-middle' min='1' max='200'></input>
                            <input type='text' name='codProd' value='$codArray' hidden></input>
                            <input type='text' name='tipoProd' value='$tipo' hidden></input>
                            <button type='submit' name='actualizarCarrito' class='btn btn-info p-0 m-0 px-1 mt-1 mt-lg-0 productoButton'>Actualizar</button>
                            <button type='submit' name='eliminarCarrito' class='btn btn-danger p-0 m-0 px-1 mt-1 mt-lg-0 productoButton'>Eliminar</button>
                            </form></div>
                          </div>
                          </div>
                        </div>
                        <div class='col-2 text-center font-weight-bold'>" . $precio . "€</div>
                        </div>";
                      }
                    }
                  }
                }

                // Actualizar Carrito y Borrar
                if (isset($_REQUEST['actualizarCarrito'])) {
                  $codProd = $_REQUEST['codProd'];
                  $cantProd = $_REQUEST['cantProd'];
                  $tipoProd = $_REQUEST['tipoProd'];
                  $arrayProd = "";

                  if ($tipoProd == "Bocadillo") {
                    $arrayProd = $_SESSION['arrayProdBoc'];
                  } else if ($tipoProd == "Hamburguesa") {
                    $arrayProd = $_SESSION['arrayProdHam'];
                  } else if ($tipoProd == "Sándwich") {
                    $arrayProd = $_SESSION['arrayProdSan'];
                  } else if ($tipoProd == "Refresco") {
                    $arrayProd = $_SESSION['arrayProdRef'];
                  } else if ($tipoProd == "Extras") {
                    $arrayProd = $_SESSION['arrayProdExt'];
                  }

                  for ($i = 0; $i < sizeof($arrayProd); $i++) {
                    if ($arrayProd[$i] == $codProd) {
                      if ($tipoProd == "Bocadillo") {
                        $_SESSION['arrayCantBoc'][$i] = $cantProd;
                      } else if ($tipoProd == "Hamburguesa") {
                        $_SESSION['arrayCantHam'][$i] = $cantProd;
                      } else if ($tipoProd == "Sándwich") {
                        $_SESSION['arrayCantSan'][$i] = $cantProd;
                      } else if ($tipoProd == "Refresco") {
                        $_SESSION['arrayCantRef'][$i] = $cantProd;
                      } else if ($tipoProd == "Extras") {
                        $_SESSION['arrayCantExt'][$i] = $cantProd;
                      }
                    }
                    echo "<script>location.href = 'carrito.php';</script>";
                  }
                }

                if (isset($_REQUEST['eliminarCarrito'])) {
                  $_SESSION['cantidadCarrito'] -= 1;
                  $codProd = $_REQUEST['codProd'];
                  $cantProd = $_REQUEST['cantProd'];
                  $tipoProd = $_REQUEST['tipoProd'];
                  $arrayProd = "";
                  if ($tipoProd == "Bocadillo") {
                    $arrayProd = $_SESSION['arrayProdBoc'];
                  } else if ($tipoProd == "Hamburguesa") {
                    $arrayProd = $_SESSION['arrayProdHam'];
                  } else if ($tipoProd == "Sándwich") {
                    $arrayProd = $_SESSION['arrayProdSan'];
                  } else if ($tipoProd == "Refresco") {
                    $arrayProd = $_SESSION['arrayProdRef'];
                  } else if ($tipoProd == "Extras") {
                    $arrayProd = $_SESSION['arrayProdExt'];
                  }

                  for ($i = 0; $i < sizeof($arrayProd); $i++) {
                    if ($arrayProd[$i] == $codProd) {
                      if ($tipoProd == "Bocadillo") {
                        array_splice($_SESSION['arrayProdBoc'], $i, 1);
                        array_splice($_SESSION['arrayCantBoc'], $i, 1);
                      } else if ($tipoProd == "Hamburguesa") {
                        array_splice($_SESSION['arrayProdHam'], $i, 1);
                        array_splice($_SESSION['arrayCantHam'], $i, 1);
                      } else if ($tipoProd == "Sándwich") {
                        array_splice($_SESSION['arrayProdSan'], $i, 1);
                        array_splice($_SESSION['arrayCantSan'], $i, 1);
                      } else if ($tipoProd == "Refresco") {
                        array_splice($_SESSION['arrayProdRef'], $i, 1);
                        array_splice($_SESSION['arrayCantRef'], $i, 1);
                      } else if ($tipoProd == "Extras") {
                        array_splice($_SESSION['arrayProdExt'], $i, 1);
                        array_splice($_SESSION['arrayCantExt'], $i, 1);
                      }
                    }
                    echo "<script>location.href = 'carrito.php';</script>";
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-3 mt-3 p-0">
        <div class="container-fluid bg-dark">
          <div class="row">
            <div class="col-12 w-100 mt-2">
              <p class='text-white info_beneficio'><i class="fas fa-info-circle"></i> Para beneficiarte del <strong>ENVÍO A DOMICILIO</strong> añade al menos 5€ en productos en tu pedido.</p>
            </div>
            <div class="col-12 w-100 px-3 py-2 text-center" id="subtotal_carrito">
              <span class='text-white'>SUBTOTAL: <span class='text-warning font-weight-bold'><?php $subtotal_format = number_format($subtotal, 2);
                                                                                              echo $subtotal_format;
                                                                                              $_SESSION['subtotal'] = $subtotal; ?>€</span> </span>
              <?php
              if ($contadorProds > 0) {
                echo "<a href='tramitarPedido.php'><button id='tramitarPedido' class='btn btn-warning w-100 mt-2'>TRAMITAR PEDIDO</button></a>";
              } else {
                echo "<button id='tramitarPedido' class='btn btn-secondary w-100 mt-2'>TRAMITAR PEDIDO</button>";
                echo "<script>
                $('#tramitarPedido').click(function() {
                  alert('Debe añadir al menos un producto en el carrito.');
                });
              </script>";
              }
              ?>

            </div>
          </div>
        </div>
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