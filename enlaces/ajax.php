<?php
session_start();
include_once("../include/BD.php");
if (isset($_REQUEST['usuario_input'])) {
  $usuario = $_REQUEST["usuario_input"];
  $userSesion = $_SESSION['usuario'];
  $comprobacion = Base::comprobarUserExistente($usuario);
  $datos["existente"] = false;

  if ($comprobacion > 0) {
    if ($usuario != $userSesion) {
      $datos["existente"] = true;
    } else {
      $datos["existente"] = false;
    }
  } else {
    $datos["existente"] = false;
  }
  echo json_encode($datos);
}

if (isset($_REQUEST['metodoEnvio'])) {
  $_SESSION['metodoEnvio'] = $_REQUEST['metodoEnvio'];
  $datos["envio"] = $_SESSION['metodoEnvio'];
  echo json_encode($datos);
}

?>