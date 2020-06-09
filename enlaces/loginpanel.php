<?php
session_start();
session_destroy();
session_start();
include_once("../include/BD.php");

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
        <nav class="navbar navbar-light" id="header_top_admin">
          <!-- LOGO -->
          <a class="navbar-brand" href="../index.php">
            <img src="../img/Logo.png" alt="Logo" id="img_logo_admin">
          </a>
        </nav>
      </div>
      <!-- // HEADER TOP -->


    </div>
  </div>
  <!-- // HEADER -->

  <!-- CUERPO -->
  <div class="container">
    <div class="row">
      <div class='col-12 col-lg-8 offset-lg-2 mt-3' id='inicioSesion'>
        <h5 class='m-0 text-center'>Bienvenido Administrador!</h5>
        <form id='formSesion' action='loginpanel.php' method='post' class='pt-2 mb-1'>
          <div class='form-group'>
            <label for='admin_input'>Usuario</label>
            <input type='text' class='form-control' id='admin_input' name='admin_input' placeholder='Inserte su usuario'>
          </div>
          <div class='form-group mb-0'>
            <label for='pass_input'>Password</label>
            <input type='password' class='form-control' id='pass_input' name='pass_input' placeholder='Inserte su contraseña'>
            <span toggle='#pass_input' class='fa fa-fw fa-eye icono_pass toggle_password'></span>
          </div>
          <div id='datosVacios' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Debes indicar tu nombre de usuario y contraseña.</p>
          </div>
          <div id='datosIncorrectos' style='display:none;'>
            <p class='text-danger'><i class='fas fa-exclamation-circle'></i> Usuario o contraseña incorrecto.</p>
          </div>
          <button type='submit' name='login' class='btn btn-success w-100 mt-3'>ADMINISTRAR <i class="fas fa-laptop-code"></i></button>
        </form>
        <a href='../index.php' class='text-warning'><i class="fas fa-chevron-left"></i> Volver a página principal</a>
      </div>
    </div>

    <?php
    // Comprobar si datos de sesión admin son correctos.
    if (isset($_REQUEST['admin_input']) && isset($_REQUEST['pass_input'])) {
      if ($_REQUEST['admin_input'] != "" && $_REQUEST['pass_input'] != "") {
        $adminLogin = $_REQUEST['admin_input'];
        $passLogin = $_REQUEST['pass_input'];
        $comprobacion = Base::comprobarAdminLogin($adminLogin, $passLogin);
        if ($comprobacion > 0) {
          $_SESSION['adminLogged'] = true;
          $_SESSION['admin'] = $adminLogin;
          echo "<script>location.href = 'admin/panelproductos.php';</script>";
        } else {
          echo "<script>document.getElementById('datosIncorrectos').style.display='initial';</script>";
        }
      } else {
        echo "<script>document.getElementById('datosVacios').style.display='initial';</script>";
      }
    }
    ?>

  </div>
  <!-- // CUERPO -->
</body>
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
</script>

</html>