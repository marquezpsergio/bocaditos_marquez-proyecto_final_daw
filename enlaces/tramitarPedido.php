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

$subtotal = $_SESSION['subtotal'];
$total = $subtotal;
$_SESSION['metodoEnvio'] = "recogida";
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
      $('input[type=radio][name=metodoEnvio]').change(function() {
        if (this.value == 'recogida') {
          $.ajax({
            url: "../enlaces/ajax.php?metodoEnvio=recogida",
            dataType: 'json'
          });
        } else if (this.value == 'domicilio') {
          $.ajax({
            url: "ajax.php?metodoEnvio=domicilio",
            dataType: 'json'
          });
        }
      });
    };
  </script>
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
        <div class="p-0 m-0 px-2 py-2 bg-dark text-center">
          <span class='text-white'>¡ESTÁS A UN PASO DE FINALIZAR TU PEDIDO!</span><br />
          <span class='text-white'>Confirma tus datos, elige el método de entrega y finalice su pedido:</span>
        </div>
      </div>
      <div class='col-12 col-lg-9 m-0 p-0 pr-lg-2 mt-2'>
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 m-0 pt-2 px-2  bg-dark">
              <h5 class='text-white'><i class="fas fa-user"></i> DATOS PERSONALES</h5>
              <?php
              // Obtener datos de usuario para rellenar datos de perfil.
              $usuario = $_SESSION['usuario'];
              $array_cls = Base::getDatosCliente($usuario);
              if (isset($array_cls)) {
                if (sizeof($array_cls) > 0) {
                  foreach ($array_cls as $cl) {
                    $_SESSION['nombre'] = $cl->getNombre();
                    $_SESSION['apellidos'] = $cl->getApellidos();
                    $_SESSION['dni'] = $cl->getDni();
                    $_SESSION['direccion'] = $cl->getDireccion();
                    $_SESSION['telefono'] = $cl->getTelefono();
                    $_SESSION['fNac'] = $cl->getFechaNacimiento();
              ?>
                    <form id='formPedido' action='tramitarPedido.php' method='get' class='pt-1'>
                      <div class="form-row text-white">
                        <div class='form-group col-12 col-sm-4'>
                          <label for='nombre_input' class="ml-1">Nombre</label>
                          <input type='text' class='form-control' id='nombre_input' name='nombre_input' placeholder='Inserte su nombre' required="true" value='<?php echo $_SESSION['nombre']; ?>'>
                        </div>
                        <div class='form-group col-12 col-sm-8'>
                          <label for='apellidos_input'>Apellidos</label>
                          <input type='text' class='form-control' id='apellidos_input' name='apellidos_input' placeholder='Inserte sus apellidos' required="true" value='<?php echo $_SESSION['apellidos']; ?>'>
                        </div>
                        <div class='form-group col-12 col-sm-3'>
                          <label for='dni_input'>DNI</label>
                          <input type='text' class='form-control' id='dni_input' name='dni_input' placeholder='Inserte su DNI' required="true" value='<?php echo $_SESSION['dni']; ?>'>

                          <div id='dniIncorrecto' style='display:none;'>
                            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> El DNI indicado no es correcto.</p>
                          </div>
                          <div id='dniExistente' style='display:none;'>
                            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Este DNI ya está asociado a una cuenta.</p>
                          </div>
                        </div>
                        <div class='form-group col-12 col-sm-9'>
                          <label for='direccion_input'>Dirección</label>
                          <input type='text' class='form-control' id='direccion_input' name='direccion_input' placeholder='Inserte su dirección: Calle, número, piso...' required="true" value='<?php echo $_SESSION['direccion']; ?>'>
                        </div>
                        <div class='form-group col-12 col-sm-5'>
                          <label for='telefono_input'>Teléfono</label>
                          <input type='text' class='form-control' id='telefono_input' name='telefono_input' placeholder='Inserte su teléfono' required="true" value='<?php echo $_SESSION['telefono'];  ?>'>
                          <div id='telIncorrecto' style='display:none;'>
                            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> El teléfono indicado no es correcto.</p>
                          </div>
                          <div id='telExistente' style='display:none;'>
                            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Este teléfono ya está asociado a una cuenta.</p>
                          </div>
                        </div>
                        <div class='form-group col-12 col-sm-7'>
                          <label for='fechaNac_input'>Fecha de Nacimiento</label>
                          <input type='date' class='form-control' id='fechaNac_input' name='fechaNac_input' required="true" value='<?php echo $_SESSION['fNac']; ?>'>
                        </div>
                        <div id='fechaIncorrecta' style='display:none;'>
                          <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Debes ser mayor de 16 años.</p>
                        </div>
                        <button type='submit' name='actualizarDatos' class='btn btn-warning w-100 my-2 mx-1'>ACTUALIZAR DATOS!</button>
                      </div>
                <?php
                  }
                }
              }
                ?>
                    </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-3 mt-2 p-0">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 w-100 px-3 py-2 text-center bg-dark" id="subtotal_carrito">
              <form action='finalizarPedido.php' method='get'>
                <div class='container-fluid metodoRecogida mb-2'>
                  <div class="row">
                    <div class="col-12 mb-2">
                      <span class='text-white font-weight-bold mb-2'>MÉTODO DE ENTREGA</span>
                    </div>
                    <div class="col-6 col-lg-12">
                      <input type="radio" id="recogida" name="metodoEnvio" value="recogida" checked="checked">
                      <label for="recogida" class='text-white'>Recogida en tienda</label>
                    </div>
                    <div class="col-6 col-lg-12">
                      <input type="radio" id="domicilio" name="metodoEnvio" value="domicilio" <?php if ($subtotal < 5) {
                                                                                                echo "disabled";
                                                                                              } ?>>
                      <label for="domicilio" class='text-white' <?php if ($subtotal < 5) {
                                                                  echo "style='text-decoration:line-through;'";
                                                                }
                                                                ?>>Envío a domicilio</label>
                    </div>
                  </div>
                </div>
                <?php


                if (Base::getCantPedidosCliente($_SESSION['codUsuario']) < 1 && $subtotal >= 5) {
                  echo "<span class='text-warning'>DESCUENTO 50% (1º PEDIDO)</span><br/>";
                  $_SESSION['descuento'] = 50;
                  $total = ($subtotal * $_SESSION['descuento']) / 100;
                  $_SESSION['total'] = number_format($total,2);
                } else {
                  $_SESSION['descuento'] = 0;
                  $total = $subtotal;
                  $_SESSION['total'] = number_format($total,2);
                }

                ?>
                <span class='text-white'>TOTAL: <span class='text-warning font-weight-bold'><?php echo number_format($_SESSION['total'], 2); ?>€</span> </span>

                <button type='submit' id="finalizarPedido" name='finalizarPedido' class='btn btn-warning w-75 mt-2 mb-2'>PAGO EN EFECTIVO</button>

                <?php
                include('paypal/config.php');
                $currency = "EUR";
                $productPrice = $_SESSION['total'];
                ?>
                <?php include 'paypal/paypalCheckout.php'; ?>
              </form>
            </div>
            <?php
            if ($subtotal < 5) {
              $falta = 5 - $subtotal;
              echo "<div class='col-12 w-100 mt-2 px-3 py-2 text-center bg-danger'>
              <span class='text-white'>Añade <span class='font-weight-bold'>" . $falta . "€</span> al carrito para recibirlo en casa.</span>
            </div>";
            }
            ?>

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
  <?php
  // Comprobación DNI
  $dniCorrecto = false;
  if (isset($_REQUEST['dni_input'])) {
    $dni = $_REQUEST['dni_input'];
    if ($dni != $_SESSION['dni']) {
      // Comprobación si dni es correcto
      if (preg_match('/^[0-9]{8,8}[A-Za-z]$/', $dni)) {
        // Comprobación si existe dni
        $comprobacion = Base::comprobarDniExistente($dni);
        if ($comprobacion > 0) {
          echo "<script>$('#dniExistente').show();</script>";
        } else {
          $dniCorrecto = true;
        }
      } else {
        echo "<script>$('#dniIncorrecto').show();</script>";
      }
    } else {
      $dniCorrecto = true;
    }
  }

  // Comprobación teléfono
  $telCorrecto = false;
  if (isset($_REQUEST['telefono_input'])) {
    $tel = $_REQUEST['telefono_input'];
    if ($tel != $_SESSION['telefono']) {
      // Comprobación si telefono es correcto
      if (preg_match('/^[0-9]{9,9}$/', $tel)) {
        // Comprobación si existe telefono
        $comprobacion = Base::comprobarTelExistente($tel);
        if ($comprobacion > 0) {
          echo "<script>$('#telExistente').show();</script>";
        } else {
          $telCorrecto = true;
        }
      } else {
        echo "<script>$('#telIncorrecto').show();</script>";
      }
    } else {
      $telCorrecto = true;
    }
  }

  // Comprobación fecha y edad
  $fechaCorrecta = false;
  if (isset($_REQUEST['fechaNac_input'])) {
    $fechaNac = $_REQUEST['fechaNac_input'];
    // Comprobación si es mayor de 16 años
    $fechaActual = date("Y-n-j H:i:s");
    $edad = (strtotime($fechaActual) - strtotime($fechaNac));
    if ($edad >= 504576000) {
      $fechaCorrecta = true;
    } else {
      echo "<script>$('#fechaIncorrecta').show();</script>";
    }
  }

  // Si esta todo correcto, se envían los datos y se actualizan.
  if (isset($_REQUEST['actualizarDatos']) && $dniCorrecto == true && $telCorrecto == true && $fechaCorrecta == true) {
    $dni = $_REQUEST['dni_input'];
    $nombre = $_REQUEST['nombre_input'];
    $apell = $_REQUEST['apellidos_input'];
    $dir = $_REQUEST['direccion_input'];
    $tel = $_REQUEST['telefono_input'];
    $fechaNac = $_REQUEST['fechaNac_input'];
    $user = $_SESSION['usuario'];

    $afectadosModifCliente = Base::modificarClienteFinalizarPed($dni, $nombre, $apell, $dir, $tel, $fechaNac, $user);
    if ($afectadosModifCliente > 0) {
      $_SESSION['nombre'] = $nombre;
      $_SESSION['apellidos'] = $apell;
      $_SESSION['dni'] = $dni;
      $_SESSION['direccion'] = $dir;
      $_SESSION['telefono'] = $tel;
      $_SESSION['fNac'] = $fechaNac;
    }
  }

  ?>
</body>

</html>