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
    echo "<script>location.href = 'recuperardatos.php';</script>";
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
  <div class="container" id="container_recDatos">
    <div class="row">
      <div class="col-12 col-md-8 offset-md-2 text-white my-3 my-md-5" id="recuperar_Datos_col">
        <p class="font-weight-bold" id="primerParrafoRec">El hambre a veces te puede hacer perder la memoria... Pero tranquilo, ¡te ayudaremos a recuperar tus datos!</p>
        <p class="font-weight-light" id="segundoParrafoRec">Indícanos tu correo y te enviaremos tu usuario con tu contraseña.</p>
        <form id='formSesion' action='recuperarDatos.php' method='get' class='pt-2'>
          <div class='form-group'>
            <label for='email_input'><i class="fas fa-envelope"></i> Email</label>
            <input type='text' class='form-control' id='email_input' name='email_input' placeholder='Inserte su correo'>
          </div>
          <div id='emailRecEnviado' style='display:none;'>
            <p class='text-primary'><i class="fas fa-check-circle"></i> El email se ha enviado a la dirección de correo indicada.</p>
          </div>
          <div id='emailRecErrorEnviado' style='display:none;'>
            <p class='text-danger'><i class="fas fa-exclamation-circle"></i> Error al enviar.</p>
          </div>
          <div id='emailRecErrorIncorrecto' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> El email indicado no es correcto.</p>
          </div>
          <div id='emailRecErrorVacio' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> No puedes dejar el campo de email vacío!</p>
          </div>
          <button type='submit' name='recuperar' class='btn btn-success w-100 mt-2'>ENVÍAME MIS DATOS</button>
        </form>
      </div>
    </div>
    <?php

    $enviarCorreo = false;
    // Comprobación de email y si es correcto.
    if (isset($_REQUEST['email_input'])) {
      if ($_REQUEST['email_input'] != "") {
        $email = $_REQUEST['email_input'];
        if (preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $email)) {
          if (isset($_REQUEST['recuperar'])) {
            $enviarCorreo = true;
          }
        } else {
          echo "<script>document.getElementById('emailRecErrorIncorrecto').style.display='initial';</script>";
        }
      } else {
        echo "<script>document.getElementById('emailRecErrorVacio').style.display='initial';</script>";
      }
    }

    // Envío de correo con los datos.
    if ($enviarCorreo == true) {
      $email = $_REQUEST['email_input'];
      $usuario = Base::getUserEmail($email);
      $password = Base::getPasswordUser($usuario);
      $nombre = Base::getNombreEmail($email);

      require '../librerias/phpmailer/PHPMailer.php';
      require '../librerias/phpmailer/SMTP.php';

      $mail = new PHPMailer();
      $mail->CharSet = 'UTF-8';
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPSecure = 'tls';
      $mail->Port       = 587;
      $mail->SMTPAuth   = true;
      $mail->Username   = 'bocateriamarquez@gmail.com';
      $mail->Password   = 'BocateriaMarquez1498';
      $mail->SetFrom('bocateriamarquez@gmail.com', "Bocateria Márquez");

      $mail->isHTML(true);

      $mail->Subject = 'Bocatería Márquez - Recuperar contraseña';
      $mail->addEmbeddedImage('../img/LogoBlack.png', 'imagen_logo');
      $mail->Body = "<html><body><p>Hola $nombre, hemos visto que tienes problemas para recordar tus datos de acceso y queremos ayudarte. Aquí te dejamos la información de sesión:</p><p><strong>Usuario: </strong>$usuario</p><p><strong>Contraseña: </strong>$password</p><br/><p>Esperamos que disfrutes de tu comida.</p><p>Un saludo de tu bocatería más cercana!</p><br/><img src='cid:imagen_logo' width='240px'></body></html>";
      $mail->AltBody = "Hola $nombre, hemos visto que tienes problemas para recordar tus datos de acceso y queremos ayudarte. Aquí te dejamos la información de sesión: Usuario: $usuario, Contraseña: $password. Esperamos que disfrutes de tu comida. Un saludo de tu bocatería más cercana!";

      $mail->addAddress($email);

      if ($mail->send()) {
        echo "<script>document.getElementById('emailRecEnviado').style.display='initial';</script>";
      } else {
        echo "<script>document.getElementById('emailRecErrorEnviado').style.display='initial';</script>";
      }
    }

    ?>

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