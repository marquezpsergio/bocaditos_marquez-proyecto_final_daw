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
    echo "<script>location.href = 'miperfil.php';</script>";
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
  <div class="container" id="container_perfil">
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
      <div class='col-12 col-lg-9 mt-3' id='perfil'>
        <h3 class='py-2 m-0'>MI PERFIL</h3>
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
              $_SESSION['email'] = $cl->getEmail();
        ?>
              <form id='formPerfil' action='miperfil.php' method='post' class='pt-2'>
                <div class="form-row">
                  <div class='form-group col-12 col-sm-4'>
                    <label for='nombre_input' class="ml-1">Nombre</label>
                    <input type='text' class='form-control' id='nombre_input' name='nombre_input' placeholder='Inserte su nombre' required="true" value='<?php echo $_SESSION['nombre'] ?>'>
                  </div>
                  <div class='form-group col-12 col-sm-8'>
                    <label for='apellidos_input'>Apellidos</label>
                    <input type='text' class='form-control' id='apellidos_input' name='apellidos_input' placeholder='Inserte sus apellidos' required="true" value='<?php echo $_SESSION['apellidos'] ?>'>
                  </div>
                  <div class='form-group col-12 col-sm-3'>
                    <label for='dni_input'>DNI</label>
                    <input type='text' class='form-control' id='dni_input' name='dni_input' placeholder='Inserte su DNI' required="true" value='<?php echo $_SESSION['dni']  ?>'>

                    <div id='dniIncorrecto' style='display:none;'>
                      <p class='text-danger'><i class='fas fa-exclamation-circle'></i> El DNI indicado no es correcto.</p>
                    </div>
                    <div id='dniExistente' style='display:none;'>
                      <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Este DNI ya está asociado a una cuenta.</p>
                    </div>
                  </div>
                  <div class='form-group col-12 col-sm-9'>
                    <label for='direccion_input'>Dirección</label>
                    <input type='text' class='form-control' id='direccion_input' name='direccion_input' placeholder='Inserte su dirección: Calle, número, piso...' required="true" value='<?php echo $_SESSION['direccion'] ?>'>
                  </div>
                  <div class='form-group col-12 col-sm-5 col-md-3'>
                    <label for='telefono_input'>Teléfono</label>
                    <input type='text' class='form-control' id='telefono_input' name='telefono_input' placeholder='Inserte su teléfono' required="true" value='<?php echo $_SESSION['telefono']  ?>'>

                    <div id='telIncorrecto' style='display:none;'>
                      <p class='text-danger'><i class='fas fa-exclamation-circle'></i> El teléfono indicado no es correcto.</p>
                    </div>
                    <div id='telExistente' style='display:none;'>
                      <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Este teléfono ya está asociado a una cuenta.</p>
                    </div>
                  </div>
                  <div class='form-group col-12 col-sm-7 col-md-4'>
                    <label for='fechaNac_input'>Fecha de Nacimiento</label>
                    <input type='date' class='form-control' id='fechaNac_input' name='fechaNac_input' required="true" value='<?php echo $_SESSION['fNac'] ?>'>
                  </div>
                  <div id='fechaIncorrecta' style='display:none;'>
                    <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Debes ser mayor de 16 años.</p>
                  </div>
                  <div class='form-group col-12 col-sm-6 col-md-5'>
                    <label for='email_input'>Email</label>
                    <input type='text' class='form-control' id='email_input' name='email_input' value='<?php echo $_SESSION['email']  ?>'>

                    <div id='emailRecErrorIncorrecto' style='display:none;'>
                      <p class='text-danger'><i class='fas fa-exclamation-circle'></i> El email indicado no es correcto.</p>
                    </div>
                    <div id='emailRecErrorVacio' style='display:none;'>
                      <p class='text-danger'><i class='fas fa-exclamation-circle'></i> No puedes dejar el campo de email vacío!</p>
                    </div>
                    <div id='emailExistente' style='display:none;'>
                      <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Este email ya está asociado a una cuenta.</p>
                    </div>
                  </div>
                  <div class='form-group col-12 col-sm-6 col-md-4'>
                    <label for='usuario_input'>Usuario</label>
                    <input type='text' class='form-control' id='usuario_input' name='usuario_input' required="true" value='<?php echo $_SESSION['usuario']  ?>'>

                    <div id='usuarioExistente' style='display:none;'>
                      <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Este nombre de usuario ya está en uso.</p>
                    </div>
                  </div>
                  <div class='form-group col-12 col-sm-6 col-md-4'>
                    <label for='pass_input'>Nueva Contraseña</label>
                    <input type='password' class='form-control' id='pass_input' name='pass_input'>
                    <span toggle="#pass_input" class="fa fa-fw fa-eye icono_pass toggle_password"></span>
                    <span id="contenido_pass" class="pt-2">Tu contraseña deberá contener al menos 6 caracteres.</span>
                  </div>
                  <div class='form-group col-12 col-sm-6 col-md-4''>
                    <label for=' confirmar_pass_input'>Confirmar Contraseña</label>
                    <input type='password' class='form-control' id='confirmar_pass_input' name='confirmar_pass_input'>
                    <span toggle="#confirmar_pass_input" class="fa fa-fw fa-eye icono_pass toggle_password"></span>

                    <div id='passLongitudMinima' style='display:none;'>
                      <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Tu contraseña contiene menos de 6 caracteres.</p>
                    </div>
                    <div id='passNoCoincide' style='display:none;'>
                      <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Tus contraseñas no coinciden.</p>
                    </div>
                  </div>
                  <button type='submit' name='modificarUsuario' class='btn btn-warning w-100 mt-2'>CONFIRMAR CAMBIOS!</button>
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

// Comprobación de email.
$emailCorrecto = false;
if (isset($_REQUEST['email_input'])) {
  if ($_REQUEST['email_input'] != "") {
    $email = $_REQUEST['email_input'];
    if ($email != $_SESSION['email']) {
      // Comprobación si email es correcto
      if (preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $email)) {
        // Comprobación si existe email
        $comprobacion = Base::comprobarEmailExistente($email);
        if ($comprobacion > 0) {
          echo "<script>$('#emailExistente').show();</script>";
        } else {
          $emailCorrecto = true;
        }
      } else {
        echo "<script>$('#emailRecErrorIncorrecto').show();</script>";
      }
    }
  } else {
    echo "<script>$('#emailRecErrorVacio').show();</script>";
  }
}

// Comprobación si existe usuario
$userCorrecto = false;
if (isset($_REQUEST['usuario_input'])) {
  $user = $_REQUEST['usuario_input'];
  if ($user != $_SESSION['usuario']) {
    $comprobacion = Base::comprobarUserExistente($user);
    if ($comprobacion > 0) {
      echo "<script>$('#usuarioExistente').show();</script>";
    } else {
      $userCorrecto = true;
    }
  }
}

// Si esta todo correcto, se envían los datos y se modifican si se ha pulsado en modificar.
if (isset($_REQUEST['modificarUsuario'])) {
  $dni = $_REQUEST['dni_input'];
  $nombre = $_REQUEST['nombre_input'];
  $apell = $_REQUEST['apellidos_input'];
  $dir = $_REQUEST['direccion_input'];
  $tel = $_REQUEST['telefono_input'];
  $fechaNac = $_REQUEST['fechaNac_input'];
  $email = $_REQUEST['email_input'];
  $user = $_REQUEST['usuario_input'];
  $usuario_sesion = $_SESSION['usuario'];
  $afectadosModifUser = 0;

  // Comprobación longitud contraseña
  $passCorrecta = false;
  if (isset($_REQUEST['pass_input']) && $_REQUEST['pass_input'] != "") {
    $pass = $_REQUEST['pass_input'];
    if (strlen($pass) >= 6) {
      // Comprobación coincidir contraseña
      $confirmPass = $_REQUEST['confirmar_pass_input'];
      if ($pass == $confirmPass) {
        $passCorrecta = true;
      } else {
        echo "<script>$('#passNoCoincide').show();</script>";
      }
    } else {
      echo "<script>$('#passLongitudMinima').show();</script>";
    }
  } else {
    $afectadosModifUser = Base::modificarSoloUsuario($user, $usuario_sesion);
  }

  if ($passCorrecta == true) {
    $pass = $_REQUEST['pass_input'];
    $afectadosModifUser = Base::modificarUsuarioyPassword($user, $pass, $usuario_sesion);
  }

  if ($afectadosModifUser > 0) {
    $afectadosModifCliente = Base::modificarCliente($dni, $nombre, $apell, $dir, $tel, $email, $fechaNac, $user);
    if ($afectadosModifCliente > 0) {
      $_SESSION['nombre'] = $nombre;
      $_SESSION['apellidos'] = $apell;
      $_SESSION['dni'] = $dni;
      $_SESSION['direccion'] = $dir;
      $_SESSION['telefono'] = $tel;
      $_SESSION['fNac'] = $fechaNac;
      $_SESSION['email'] = $email;
      $_SESSION['usuario'] = $user;
    }
  }
}

?>
<script>
  // FUNCIONES MOSTRAR CONTRASEÑA //
  $(".toggle_password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
  // ... //

  // FUNCIÓN COMPROBAR USUARIO EXISTENTE //
  function cargarDatosUser() {
    let usuario = $("#usuario_input").val();
    $.ajax({
      url: "../enlaces/ajax.php?usuario_input=" + usuario,
      dataType: 'json',
      success: comprobarUser,
      error: function() {
        console.log("No se ha podido obtener la información");
      }
    });
  }

  function comprobarUser(datos) {
    if (datos.existente == true) {
      $('#usuarioExistente').show();
    } else {
      $('#usuarioExistente').hide();
    }
  }
  // .. //
</script>

</html>