<?php
session_start();
include_once("include/BD.php");
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

// Si se pulsa el botón de cerrar sesión.
if (isset($_REQUEST['logOut'])) {
  session_destroy();
  echo "<script>location.href = 'index.php';</script>";
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

  <!-- Bootstrap CSS, FontAwesome y Estilos CSS -->
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="librerias/fontawesome/css/all.css">
  <link rel="stylesheet" href="estilos/estilos_home.css">

  <!-- JavaScript: jQuery y  Bootstrap JS -->
  <script src="librerias/jquery/jquery-3.4.1.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="enlaces/main.js"></script>
  <!-- Título Página -->
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
          <a class="navbar-brand" href="index.php">
            <img src="img/Logo.png" alt="Logo" id="img_logo">
          </a>

          <!-- MENÚ ACCESO y CARRITO -->
          <ul class="nav justify-content-end">
            <li class="nav-item" onmouseover="color_acceso();" onmouseout="color_acceso_normal();">
              <div class="container-fluid">
                <a class="nav-link" href=<?php
                                          // Si hay sesión, redirige a 'Mi Cuenta', si no, irá a 'Inicio Sesión'.
                                          if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == true)) {
                                            echo "#miCuenta";
                                          } else {
                                            echo "#inicioSesion";
                                          }
                                          ?>>
                  <div class="row">
                    <div class="col-12 text-center ">
                      <i class="fas fa-user" id="acceso_icono"></i>
                    </div>
                    <div class="col-12 text-center"><span id="acceso_texto">
                        <?php
                        // Si hay sesión, aparecerá el nombre de usuario, si no, aparecerá "ACCESO" para iniciar sesión.
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
                <a class="nav-link" href="enlaces/carrito.php">
                  <div class="row">
                    <div class="col-12 text-center ">
                      <i class="fas fa-shopping-cart" id="carrito_icono"></i>
                    </div>
                    <div class="col-12 text-center">
                      <span id="carrito_texto">CARRITO</span>
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
              <a class="nav-link" href="enlaces/bocadillos.php">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12 text-center"><img class="letra_header_menu" src="img/B.png"></div>
                    <div class="col-12 text-center texto_header_menu mt-1"> BOCADILLOS </div>
                  </div>
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="enlaces/hamburguesas.php">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12 text-center"><img class="letra_header_menu" src="img/H.png"></div>
                    <div class="col-12 text-center texto_header_menu mt-1"> HAMBURGUESAS </div>
                  </div>
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="enlaces/refrescos.php">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12 text-center"><img class="letra_header_menu" src="img/R.png"></div>
                    <div class="col-12 text-center texto_header_menu mt-1"> REFRESCOS </div>
                  </div>
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="enlaces/extras.php">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12 text-center"><img class="letra_header_menu" src="img/E.png"></div>
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
              <a href="enlaces/bocadillos.php"><img class="letra_header_menu" src="img/B.png"><span class="texto_header_menu align-bottom">OCADILLOS</span></a>
            </div>
            <div class="col-3 text-center">
              <a href="enlaces/hamburguesas.php"><img class="letra_header_menu" src="img/H.png"><span class="texto_header_menu align-bottom">AMBURGUESAS</span></a>
            </div>
            <div class="col-3 text-center">
              <a href="enlaces/refrescos.php"><img class="letra_header_menu" src="img/R.png"><span class="texto_header_menu align-bottom">EFRESCOS</span></a>
            </div>
            <div class="col-3 text-center">
              <a href="enlaces/extras.php"><img class="letra_header_menu" src="img/E.png"><span class="texto_header_menu align-bottom">XTRAS</span></a>
            </div>
          </div>
        </div>
      </div>
      <!-- // HEADER MENU -->

    </div>
  </div>
  <!-- // HEADER -->

  <!-- CUERPO -->
  <div class="container mt-4">
    <div class="row">

      <!-- CAROUSEL -->
      <div class="col-12 col-lg-8">
        <div id="carouselCuerpo" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselCuerpo" data-slide-to="0" class="active"></li>
            <li data-target="#carouselCuerpo" data-slide-to="1"></li>
            <li data-target="#carouselCuerpo" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="img/carrusel1.jpg" class="d-block w-100" alt="bocadillo">
              <div class="carousel-caption slide_etiqueta">
                <span class="slide_label">Nuestros bocadillos</span>
                <p class="slide_texto">Comparte tu bocadillo preferido con la persona que tengas al lado.</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="img/carrusel2.jpg" class="d-block w-100" alt="hamburguesa">
              <div class="carousel-caption slide_etiqueta">
                <span class="slide_label">Nuestras hamburguesas</span>
                <p class="slide_texto">Con nuestra sabrosa carne, disfruta de una merecida cena a tu placer.</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="img/carrusel3.jpg" class="d-block w-100" alt="servicioDomicilio">
              <div class="carousel-caption slide_etiqueta">
                <span class="slide_label">Servicio a domicilio</span>
                <p class="slide_texto">No te muevas del sofá, nosotros nos encargamos de servirte la comida en la mesa.</p>
              </div>
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselCuerpo" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
          </a>
          <a class="carousel-control-next" href="#carouselCuerpo" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
          </a>
        </div>
      </div>
      <!-- // CAROUSEL -->

      <!-- INICIO SESIÓN / MI CUENTA -->
      <!-- Si hay sesión, crea 'Mi Cuenta' -->
      <?php
      if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == true)) {
        echo "<div class='col-12 col-lg-4 mt-3 mt-lg-0' id='miCuenta'>
          <div class='container-fluid'>
            <div class='row list-group'>
              <div class='list-group-item col-12 text-center m-0' id='miCuenta_h5'><h5>MI CUENTA</h5></div>
              <a href='enlaces/miperfil.php' class='list-group-item list-group-item-action miCuenta_a'><i class='fas fa-user'></i> MI PERFIL</a>
              <a href='enlaces/mispedidos.php' class='list-group-item list-group-item-action miCuenta_a'><i class='fas fa-utensils'></i> MIS PEDIDOS</a>
              <a href='index.php?logOut=' class='list-group-item list-group-item-action miCuenta_a'><i class='fas fa-sign-out-alt'></i> CERRAR SESIÓN</a>
              </div>
          </div>
        </div>"; ?>
        <!-- Si no hay sesión, crea 'Inicio Sesión' -->
      <?php
      } else {
        echo "<div class='col-12 col-lg-4 mt-3 mt-lg-0' id='inicioSesion'>
          <h5 class='m-0 text-center'>Inicio Sesión</h5>
          <form id='formSesion' action='index.php' method='post' class='pt-2'>
            <div class='form-group'>
              <label for='user_input'>Usuario</label>
              <input type='text' class='form-control' id='user_input' name='user_input' placeholder='Inserte su usuario'>
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
            <div class='text-right' id='enlaceOlvidarDatos'><a href='enlaces/recuperardatos.php'>¿Olvidaste tus datos?</a></div>
            <button type='submit' name='login' class='btn btn-success w-100 mt-2'>A COMER <i class='fas fa-utensils'></i></button>
          </form>
          <div id='debajo_form' class='py-2'>
            <div class='text-center' id='aunNoReg_texto'><span>¿Aún no estás registrado?</span></div>
            <div class='text-center mt-2 px-2' id='btn_registro'><a href='enlaces/registro.php'><button type='submit' class='btn btn-warning w-100'>REGISTRARME</button></a></div>
          </div>
        </div>";
      }
      ?>
      <?php
      // Comprobar si datos de sesión son correctos.
      if (isset($_REQUEST['user_input']) && isset($_REQUEST['pass_input'])) {
        if ($_REQUEST['user_input'] != "" && $_REQUEST['pass_input'] != "") {
          $userLogin = $_REQUEST['user_input'];
          $passLogin = $_REQUEST['pass_input'];
          $comprobacion = Base::comprobarUserLogin($userLogin, $passLogin);
          if ($comprobacion > 0) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['usuario'] = $userLogin;
            $_SESSION['codUsuario'] = Base::getCodigoClientePorUser($userLogin);
            echo "<script>location.href = 'index.php';</script>";
          } else {
            echo "<script>document.getElementById('datosIncorrectos').style.display='initial';</script>";
          }
        } else {
          echo "<script>document.getElementById('datosVacios').style.display='initial';</script>";
        }
      }
      ?>
      <!-- // INICIO SESIÓN / MI CUENTA -->

      <!-- SERVICIO DOMICILIO -->
      <div class="col-12 m-0 p-0 mt-4 mb-4 py-3 text-white" id="servicio_domicilio_principal">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-md-10 offset-md-1">
              <div class="container-fluid text-center">
                <div class="row">
                  <div class="col-12">
                    <h3 class="font-weight-bold text-warning">Servicio a domicilio</h3>
                  </div>
                  <div class="col-5 offset-1 font-weight-bold"><i class="fas fa-phone-alt"></i> 924 731 425</div>
                  <div class="col-5 font-weight-bold"><i class="fas fa-mobile-alt"></i> 655 654 327</div>
                  <div class="col-12 mt-2" id="pedido_minimo_text">Pedido mínimo de 5€ para pedidos a domicilio</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-10 offset-md-1 mt-3 pt-3 horarios_loc">
              <div class="container-fluid text-center">
                <div class="row">
                  <div class="col-12">
                    <h4 class="font-weight-bold text-warning">Horarios</h5>
                  </div>
                  <div class="col-5 offset-1">
                    <span class="font-weight-bold"><i class="fas fa-cloud"></i> Invierno</span><br />
                    <span class="font-italic">20:00h - 23:00h</span>
                  </div>
                  <div class="col-5">
                    <span class="font-weight-bold"><i class="fas fa-sun"></i> Verano</span><br />
                    <span class="font-italic">20:30h - 00:30h</span></div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-10 offset-md-1 mt-3 pt-3 horarios_loc text-center">
              <h4 class="font-weight-bold text-warning">Localízanos</h5>
                <span class="font-italic">C/ Calzada 22 - 06380 Jerez de los Caballeros</span><br />
                <div class="mt-2"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3130.257076733395!2d-6.776110120901885!3d38.31987727469907!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd1137b9c6cadb05%3A0x9ae55e027c6a593f!2sCalle%20Calzada%2C%2022%2C%2006380%20Jerez%20de%20los%20Caballeros%2C%20Badajoz!5e0!3m2!1ses!2ses!4v1587590490957!5m2!1ses!2ses" width="100%" height="250" frameborder="0" style="border:1px solid rgb(0, 0, 0, 0.25);" allowfullscreen="true" aria-hidden="false" tabindex="0"></iframe></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- // SERVICIO DOMICILIO -->

  </div>
  <!-- // CUERPO -->

  <!-- QUÉ TE APETECE -->
  <div class="container p-0">
    <div class="row">
      <div class="col-12">
        <div class="col-12 m-0 p-0" id="comida_pizarra_div" class="w-100">
          <img src="img/comida_pizarra.png" class="w-100">
        </div>
      </div>
    </div>
  </div>
  <!-- // QUÉ TE APETECE -->

  <!-- FOOTER -->
  <div class="container">
    <div class="row">
      <div class="col-12 py-2" id="redsoc_footer">
        <ul class="nav justify-content-center">
          <li class="nav-item">
            <a class="nav-link" href="http://www.facebook.es"><img src="img/facebook.png" alt="facebook" class="red_social"></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://www.twitter.es" alt="twitter"><img src="img/twitter.png" class="red_social"></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://www.instagram.com"><img src="img/instagram.png" alt="instagram" class="red_social"></a>
          </li>
        </ul>
      </div>
      <div class="col-12 py-3 text-center">
        <span id="texto_footer">@2020 Bocatería Márquez. Todos los derechos reservados. <a href='enlaces/loginpanel.php' class='url_admin'>Admin.</a></span>
      </div>
    </div>
  </div>
  <!-- // FOOTER -->
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