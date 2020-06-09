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
    echo "<script>location.href = 'registro.php';</script>";
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
  <div class="container" id="container_registro">
    <div class="row">
      <div class='col-12 col-md-7 col-lg-8 mt-3' id='registro'>
        <h3 class='m-0'>A nombre de quien?</h3>
        <p class='m-0' id="p_dinosdatos">Dinos tus datos personales y podemos conversar con más confianza!</p>
        <form id='formRegistro' action='registro.php' method='post' class='pt-2'>
          <div class='form-group'>
            <label for='nombre_input' class="ml-1">Nombre</label>
            <input type='text' class='form-control' id='nombre_input' name='nombre_input' placeholder='Inserte su nombre' required="true" maxlength="100">
          </div>
          <div class='form-group'>
            <label for='apellidos_input'>Apellidos</label>
            <input type='text' class='form-control' id='apellidos_input' name='apellidos_input' placeholder='Inserte sus apellidos' required="true" maxlength="200">
          </div>
          <div class='form-group'>
            <label for='dni_input'>DNI</label>
            <input type='text' class='form-control' id='dni_input' name='dni_input' placeholder='Inserte su DNI' required="true" maxlength="9">
          </div>
          <div id='dniIncorrecto' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> El DNI indicado no es correcto.</p>
          </div>
          <div id='dniExistente' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Este DNI ya está asociado a una cuenta.</p>
          </div>
          <div class='form-group'>
            <label for='direccion_input'>Dirección</label>
            <input type='text' class='form-control' id='direccion_input' name='direccion_input' placeholder='Inserte su dirección: Calle, número, piso...' required="true" maxlength="500">
          </div>
          <div class='form-group'>
            <label for='telefono_input'>Teléfono</label>
            <input type='text' class='form-control' id='telefono_input' name='telefono_input' placeholder='Inserte su teléfono' required="true" maxlength="9">
          </div>
          <div id='telIncorrecto' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> El teléfono indicado no es correcto.</p>
          </div>
          <div id='telExistente' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Este teléfono ya está asociado a una cuenta.</p>
          </div>
          <div class='form-group'>
            <label for='fechaNac_input'>Fecha de Nacimiento</label>
            <input type='date' class='form-control' id='fechaNac_input' name='fechaNac_input' required="true">
          </div>
          <div id='fechaIncorrecta' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Debes ser mayor de 16 años.</p>
          </div>
          <div class='form-group'>
            <label for='email_input'>Email</label>
            <input type='text' class='form-control' id='email_input' name='email_input' maxlength="200">
          </div>
          <div id='emailRecErrorIncorrecto' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> El email indicado no es correcto.</p>
          </div>
          <div id='emailRecErrorVacio' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> No puedes dejar el campo de email vacío!</p>
          </div>
          <div id='emailExistente' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Este email ya está asociado a una cuenta.</p>
          </div>
          <div class='form-group'>
            <label for='usuario_input'>Usuario</label>
            <input type='text' class='form-control' id='usuario_input' name='usuario_input' required="true" maxlength="20">
          </div>
          <div id='usuarioExistente' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Este nombre de usuario ya está en uso.</p>
          </div>
          <div class='form-group'>
            <label for='pass_input'>Contraseña<span id="contenido_pass" class="ml-2">Tu contraseña deberá contener al menos 6 caracteres.</span></label>
            <input type='password' class='form-control' id='pass_input' name='pass_input'>
            <span toggle="#pass_input" class="fa fa-fw fa-eye icono_pass toggle_password"></span>
          </div>
          <div class='form-group'>
            <label for='confirmar_pass_input'>Confirmar Contraseña</label>
            <input type='password' class='form-control' id='confirmar_pass_input' name='confirmar_pass_input'>
            <span toggle="#confirmar_pass_input" class="fa fa-fw fa-eye icono_pass toggle_password"></span>
          </div>
          <div id='passLongitudMinima' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Tu contraseña contiene menos de 6 caracteres.</p>
          </div>
          <div id='passNoCoincide' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Tus contraseñas no coinciden.</p>
          </div>
          <button type='submit' name='registrar' class='btn btn-warning w-100 mt-2'>FINALIZAR REGISTRO</button>
        </form>
      </div>
      <div class="col-12 col-md-5 col-lg-4 mt-3" id='ventajas_registro'>
        <div class="card bg-light mb-3">
          <div class="card-header text-center font-weight-bold pb-1">Ventajas de registrarte</div>
          <div class="card-body pt-1">
            <p class="card-text mt-1 mb-0"><span class="text-danger font-weight-bold"><i class="fas fa-check"></i> 50% de descuento</span> en tu primer pedido.</p>
            <p class="card-text mt-1 mb-0"><span class="text-danger font-weight-bold"><i class="fas fa-check"></i> Cupones de descuento</span> exclusivos para clientes.</p>
            <p class="card-text mt-1 mb-0"><span class="text-danger font-weight-bold"><i class="fas fa-check"></i></span> Revisa todos <span class="text-danger font-weight-bold">tus pedidos anteriores.</span></p>
            <p class="card-text mt-1 mb-0"><span class="text-danger font-weight-bold"><i class="fas fa-check"></i></span> Guarda y gestiona tus<span class="text-danger font-weight-bold"> direcciones de entrega.</span></p>
          </div>
        </div>
        <div class="card bg-light mb-3">
          <div class="card-header text-center font-weight-bold pb-1">¿Ya tienes cuenta?</div>
          <div class="card-body p-1 text-center" id='yaTienesCuenta'>
            <a href='../index.php#inicioSesion' style='text-decoration:none;'>
              <div class="alert my-1 mx-2">
                <h5 class="font-weight-bold mb-0"><i class="fas fa-sign-in-alt"></i> INICIA SESIÓN</h5>
              </div>
            </a>
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
<?php
// Comprobación DNI
$dniCorrecto = false;
if (isset($_REQUEST['dni_input'])) {
  $dni = $_REQUEST['dni_input'];
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

// Comprobación teléfono
$telCorrecto = false;
if (isset($_REQUEST['telefono_input']) && $dniCorrecto == true) {
  $tel = $_REQUEST['telefono_input'];
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

// Comprobación fecha y edad
$fechaCorrecta = false;
if (isset($_REQUEST['fechaNac_input']) && $telCorrecto == true) {
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
if (isset($_REQUEST['email_input']) && $fechaCorrecta == true) {
  if ($_REQUEST['email_input'] != "") {
    $email = $_REQUEST['email_input'];
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
  } else {
    echo "<script>$('#emailRecErrorVacio').show();</script>";
  }
}

// Comprobación si existe usuario
$userCorrecto = false;
if (isset($_REQUEST['usuario_input']) && $emailCorrecto == true) {
  $user = $_REQUEST['usuario_input'];
  $comprobacion = Base::comprobarUserExistente($user);
  if ($comprobacion > 0) {
    echo "<script>$('#usuarioExistente').show();</script>";
  } else {
    $userCorrecto = true;
  }
}

// Comprobación longitud contraseña
$passCorrecta = false;
if (isset($_REQUEST['pass_input']) && $userCorrecto == true) {
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
}

// Si esta todo correcto, se envían los datos y se registran
if ($passCorrecta == true) {
  $dni = $_REQUEST['dni_input'];
  $nombre = $_REQUEST['nombre_input'];
  $apell = $_REQUEST['apellidos_input'];
  $dir = $_REQUEST['direccion_input'];
  $tel = $_REQUEST['telefono_input'];
  $fechaNac = $_REQUEST['fechaNac_input'];
  $email = $_REQUEST['email_input'];
  $user = $_REQUEST['usuario_input'];
  $pass = $_REQUEST['pass_input'];

  Base::nuevoUsuario($user, $pass, $dni, $nombre, $apell, $dir, $tel, $email, $fechaNac);
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