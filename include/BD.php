<?php

require_once "clientes.php";
require_once "usuarios.php";
require_once "productos.php";
require_once "pedidos.php";
require_once "detalles_pedidos.php";

class Base
{
  public static function ejecutarConsulta()
  {
    $conexion = new PDO("mysql:host=localhost; dbname=bocaditos_marquez", "root", "");
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("SET CHARACTER SET utf8");
    return $conexion;
  }

  // -- PRODUCTOS --
  // - Bocadillos
  public static function getBocadillos()
  {
    $sql = "SELECT * FROM PRODUCTOS where tipoProducto='Bocadillo'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_prods = array();
    while ($fila = $resultado->fetch()) {
      $array_prods[] = new Productos($fila);
    }
    $resultado->closeCursor();
    return ($array_prods);
  }

  // - Hamburguesas
  public static function getHamburguesas()
  {
    $sql = "SELECT * FROM PRODUCTOS where tipoProducto='Hamburguesa'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_prods = array();
    while ($fila = $resultado->fetch()) {
      $array_prods[] = new Productos($fila);
    }
    $resultado->closeCursor();
    return ($array_prods);
  }

  // - Sándwich
  public static function getSandwiches()
  {
    $sql = "SELECT * FROM PRODUCTOS where tipoProducto='Sándwich'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_prods = array();
    while ($fila = $resultado->fetch()) {
      $array_prods[] = new Productos($fila);
    }
    $resultado->closeCursor();
    return ($array_prods);
  }

  // - Varios
  public static function getExtras()
  {
    $sql = "SELECT * FROM PRODUCTOS where tipoProducto='Extras'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_prods = array();
    while ($fila = $resultado->fetch()) {
      $array_prods[] = new Productos($fila);
    }
    $resultado->closeCursor();
    return ($array_prods);
  }

  // - Bebidas
  public static function getRefrescos()
  {
    $sql = "SELECT * FROM PRODUCTOS where tipoProducto='Refresco'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_prods = array();
    while ($fila = $resultado->fetch()) {
      $array_prods[] = new Productos($fila);
    }
    $resultado->closeCursor();
    return ($array_prods);
  }

  // Obtener producto por código
  public static function getProducto($codProd)
  {
    $sql = "SELECT * FROM PRODUCTOS where codigoProducto='$codProd'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_prods = array();
    while ($fila = $resultado->fetch()) {
      $array_prods[] = new Productos($fila);
    }
    $resultado->closeCursor();
    return ($array_prods);
  }

  // OBTENER TOTAL PRODUCTOS
  public static function getTotalProds()
  {
    $sql = "SELECT COUNT(*) FROM PRODUCTOS";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    $num_filas = $resultado->fetchColumn();
    return $num_filas;
  }

  // OBTENER TODOS LOS PRODUCTOS PARA PAGINACIÓN
  public static function getProductosPag($pagLimit)
  {
    $sql = "SELECT * FROM PRODUCTOS ORDER BY tipoProducto, nombreProducto LIMIT $pagLimit, 20";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_prods = array();
    while ($fila = $resultado->fetch()) {
      $array_prods[] = new Productos($fila);
    }
    $resultado->closeCursor();
    return ($array_prods);
  }

  // Nuevo producto
  public static function nuevoProducto($nombre, $tipo, $ingred, $precio, $img)
  {
    $sql = "INSERT INTO PRODUCTOS (nombreProducto, tipoProducto, ingredientesProducto, precioProducto, imagenProducto) VALUES ('$nombre','$tipo','$ingred','$precio','$img')";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Producto insertado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al insertar producto!.');</script>";
    }
  }

  // Modificar producto
  public static function modificarProducto($codigo, $nombre, $tipo, $ingred, $precio, $img)
  {
    $sql = "UPDATE PRODUCTOS SET nombreProducto = '$nombre', tipoProducto='$tipo', ingredientesProducto='$ingred', precioProducto = '$precio', imagenProducto = '$img' WHERE codigoProducto = '$codigo'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Producto modificado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al modificar el producto!');</script>";
    }
  }

  // Eliminar producto
  public static function eliminarProducto($codigo)
  {
    $sql = "DELETE FROM PRODUCTOS WHERE codigoProducto = '$codigo'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Producto eliminado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al eliminar el producto!');</script>";
    }
  }

  // -- USUARIOS --
  // Comprobar si existe usuario
  public static function comprobarUserExistente($user)
  {
    $sql = "SELECT COUNT(*) FROM USUARIOS WHERE nombreUsuario='$user'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    $num_filas = $resultado->fetchColumn();
    return $num_filas;
  }

  // Comprobación de login de usuario.
  public static function comprobarUserLogin($user, $pass)
  {
    $sql = "SELECT COUNT(*) FROM USUARIOS WHERE nombreUsuario='$user' AND passwordUsuario='$pass' AND tipoUsuario='Usuario'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    $num_filas = $resultado->fetchColumn();
    return $num_filas;
  }

  // Comprobación de login de admin.
  public static function comprobarAdminLogin($user, $pass)
  {
    $sql = "SELECT COUNT(*) FROM USUARIOS WHERE nombreUsuario='$user' AND passwordUsuario='$pass' AND tipoUsuario='Administrador'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    $num_filas = $resultado->fetchColumn();
    return $num_filas;
  }

  // Obtener contraseña de usuario
  public static function getPasswordUser($user)
  {
    $sql = "SELECT * FROM USUARIOS where nombreUsuario='$user'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $user = new Usuarios($resultado->fetch());
    $password = $user->getPassword();
    $resultado->closeCursor();
    return ($password);
  }

  // Nuevo usuario
  public static function nuevoUsuario($user, $password, $dni, $nombre, $apell, $dir, $tel, $email, $fechaNac)
  {
    $sql = "INSERT INTO USUARIOS (nombreUsuario, passwordUsuario) VALUES ('$user','$password')";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      Base::nuevoCliente($dni, $nombre, $apell, $dir, $tel, $email, $fechaNac, $user);
    } else {
      echo "<script>alert('¡Error al registrar!.');</script>";
    }
  }

  // Modificar usuario
  public static function modificarSoloUsuario($usuario, $usuario_sesion)
  {
    $sql = "UPDATE USUARIOS SET nombreUsuario = '$usuario' WHERE nombreUsuario = '$usuario_sesion'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    return $afectados;
  }

  public static function modificarUsuarioyPassword($usuario, $password, $usuario_sesion)
  {
    $usuario_Sesion = $_SESSION['usuario'];
    $sql = "UPDATE USUARIOS SET nombreUsuario = '$usuario', passwordUsuario='$password' WHERE nombreUsuario = '$usuario_sesion'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    return $afectados;
  }

  // OBTENER TOTAL USUARIOS
  public static function getTotalUsers()
  {
    $sql = "SELECT COUNT(*) FROM USUARIOS";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    $num_filas = $resultado->fetchColumn();
    return $num_filas;
  }

  // OBTENER TODOS LOS USUARIOS PARA PAGINACIÓN
  public static function getUsuariosPag($pagLimit)
  {
    $sql = "SELECT * FROM USUARIOS ORDER BY tipoUsuario, nombreUsuario LIMIT $pagLimit, 20";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_users = array();
    while ($fila = $resultado->fetch()) {
      $array_users[] = new Usuarios($fila);
    }
    $resultado->closeCursor();
    return ($array_users);
  }

  // Nuevo usuario
  public static function nuevoUsuarioPanel($nombre, $pass, $tipo)
  {
    $sql = "INSERT INTO USUARIOS (nombreUsuario, passwordUsuario, tipoUsuario) VALUES ('$nombre','$pass','$tipo')";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Usuario insertado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al insertar usuario!.');</script>";
    }
  }

  // Modificar usuario
  public static function modificarUsuario($codigo, $nombre, $pass, $tipo)
  {
    $sql = "UPDATE USUARIOS SET nombreUsuario = '$nombre', passwordUsuario='$pass', tipoUsuario='$tipo' WHERE codigoUsuario = '$codigo'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Usuario modificado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al modificar el usuario!');</script>";
    }
  }

  // Eliminar usuario
  public static function eliminarUsuario($codigo)
  {
    $sql = "DELETE FROM USUARIOS WHERE codigoUsuario = '$codigo'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Usuario eliminado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al eliminar el usuario!');</script>";
    }
  }

  // Eliminar usuario por usuario
  public static function eliminarUsuarioPorUser($user)
  {
    $sql = "DELETE FROM USUARIOS WHERE nombreUsuario = '$user'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Usuario eliminado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al eliminar el usuario!');</script>";
    }
  }

  // -- CLIENTES --
  public static function getDatosCliente($usuario)
  {
    $sql = "SELECT * FROM CLIENTES where usuarioCliente='$usuario'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_cls = array();
    while ($fila = $resultado->fetch()) {
      $array_cls[] = new Clientes($fila);
    }
    $resultado->closeCursor();
    return ($array_cls);
  }

  // Obtener código cliente por usuario
  public static function getCodigoClientePorUser($user)
  {
    $sql = "SELECT * FROM CLIENTES where usuarioCliente='$user'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $cliente = new Clientes($resultado->fetch());
    $codigo = $cliente->getCodigo();
    $resultado->closeCursor();
    return ($codigo);
  }

  // Comprobar si existe email
  public static function comprobarEmailExistente($email)
  {
    $sql = "SELECT COUNT(*) FROM CLIENTES WHERE emailCliente='$email'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    $num_filas = $resultado->fetchColumn();
    return $num_filas;
  }

  // Comprobar si existe dni
  public static function comprobarDniExistente($dni)
  {
    $sql = "SELECT COUNT(*) FROM CLIENTES WHERE dniCliente='$dni'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    $num_filas = $resultado->fetchColumn();
    return $num_filas;
  }

  // Comprobar si existe telefono
  public static function comprobarTelExistente($tel)
  {
    $sql = "SELECT COUNT(*) FROM CLIENTES WHERE telefonoCliente='$tel'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    $num_filas = $resultado->fetchColumn();
    return $num_filas;
  }


  // Obtener nombre de usuario según email
  public static function getUserEmail($email)
  {
    $sql = "SELECT * FROM CLIENTES where emailCliente='$email'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $cliente = new Clientes($resultado->fetch());
    $usuario = $cliente->getUsuario();
    $resultado->closeCursor();
    return ($usuario);
  }

  // Obtener nombre según email
  public static function getNombreEmail($email)
  {
    $sql = "SELECT * FROM CLIENTES where emailCliente='$email'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $cliente = new Clientes($resultado->fetch());
    $nombre = $cliente->getNombre();
    $resultado->closeCursor();
    return ($nombre);
  }

  // Nuevo cliente
  public static function nuevoCliente($dni, $nombre, $apell, $dir, $tel, $email, $fechaNac, $user)
  {
    $sql = "INSERT INTO CLIENTES (dniCliente, nombreCliente, apellidosCliente, direccionCliente, telefonoCliente, emailCliente, fechaNacimientoCliente, usuarioCliente) VALUES ('$dni','$nombre','$apell','$dir','$tel','$email','$fechaNac','$user')";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      // Envío de correo de bienvenida.
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

      $mail->Subject = 'Bocaditos Márquez - Bienvenido';
      $mail->addEmbeddedImage('../img/LogoBlack.png', 'imagen_logo');
      $mail->Body = "<html><body><p>Bienvenido $nombre, gracias por registrarte y formar parte de nosotros!</p><p><strong>Tu usuario es </strong>$user, utilízalo junto a la contraseña que confirmaste.</p><p>Esperamos que disfrutes de tu comida.</p><p>Un saludo de tu bocatería más cercana!</p><br/><img src='cid:imagen_logo' width='240px'></body></html>";
      $mail->AltBody = "Bienvenido $nombre, gracias por registrarte y formar parte de nosotros! Tu usuario es: Usuario: $user, utilízalo junto a la contraseña que confirmaste. Esperamos que disfrutes de tu comida. Un saludo de tu bocatería más cercana!";

      $mail->addAddress($email);

      if ($mail->send()) {
        echo "<script>alert(' Usuario creado! $user \\n Ahora formas parte de nuestra familia, disfruta!!!');</script>";
        echo "<script>location.href='../index.php#inicioSesion';</script>";
      } else {
        echo "<script>alert('Error al registrarte!! <br/> Intentalo de nuevo, por favor.');</script>";
      }
    } else {
      echo "<script>alert('¡Error al registrar!.');</script>";
    }
  }

  // Modificar cliente por user
  public static function modificarCliente($dni, $nombre, $apell, $dir, $tel, $email, $fechaNac, $user)
  {
    $sql = "UPDATE CLIENTES SET nombreCliente = '$nombre', apellidosCliente='$apell', dniCliente='$dni', direccionCliente = '$dir', telefonoCliente = '$tel', emailCliente ='$email', fechaNacimientoCliente = '$fechaNac', usuarioCliente = '$user' WHERE usuarioCliente = '$user'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('Tus datos han sido modificados correctamente.');</script>";
      echo "<script>location.href='miperfil.php';</script>";
    } else {
      echo "<script>alert('Tus datos no se han podido modificar.');</script>";
    }
    return $afectados;
  }

  // Modificar cliente en finalización de pedido por user
  public static function modificarClienteFinalizarPed($dni, $nombre, $apell, $dir, $tel, $fechaNac, $user)
  {
    $sql = "UPDATE CLIENTES SET nombreCliente = '$nombre', apellidosCliente='$apell', dniCliente='$dni', direccionCliente = '$dir', telefonoCliente = '$tel', fechaNacimientoCliente = '$fechaNac' WHERE usuarioCliente = '$user'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('Tus datos han sido modificados correctamente.');</script>";
      echo "<script>location.href='tramitarPedido.php';</script>";
    } else {
      echo "<script>alert('Tus datos no se han podido modificar.');</script>";
    }
    return $afectados;
  }

  // OBTENER TOTAL CLIENTES
  public static function getTotalClientes()
  {
    $sql = "SELECT COUNT(*) FROM CLIENTES";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    $num_filas = $resultado->fetchColumn();
    return $num_filas;
  }

  // OBTENER TODOS LOS CLIENTES PARA PAGINACIÓN
  public static function getClientesPag($pagLimit)
  {
    $sql = "SELECT * FROM CLIENTES ORDER BY nombreCliente, apellidosCliente LIMIT $pagLimit, 20";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_cl = array();
    while ($fila = $resultado->fetch()) {
      $array_cl[] = new Clientes($fila);
    }
    $resultado->closeCursor();
    return ($array_cl);
  }

  // Modificar cliente
  public static function modificarClientePanel($codigo, $dni, $nombre, $apell, $dir, $tel, $email, $fechaNac, $user)
  {
    $sql = "UPDATE CLIENTES SET dniCliente = '$dni', nombreCliente='$nombre', apellidosCliente='$apell', direccionCliente='$dir',telefonoCliente='$tel',emailCliente='$email',fechaNacimientoCliente='$fechaNac', usuarioCliente='$user' WHERE codigoCliente = '$codigo'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Cliente modificado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al modificar el cliente!');</script>";
    }
  }

  // Eliminar cliente por código
  public static function eliminarCliente($codigo)
  {
    $sql = "DELETE FROM CLIENTES WHERE codigoCliente = '$codigo'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Cliente eliminado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al eliminar el cliente!');</script>";
    }
  }

  // Eliminar cliente por usuario
  public static function eliminarClientePorUser($user)
  {
    $sql = "DELETE FROM CLIENTES WHERE usuarioCliente = '$user'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Cliente eliminado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al eliminar el cliente!');</script>";
    }
  }

  // -- PEDIDOS --
  // Obtener pedidos
  public static function getPedidoCodigo($codigo)
  {
    $sql = "SELECT * FROM PEDIDOS where codigoPedido='$codigo'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_peds = array();
    while ($fila = $resultado->fetch()) {
      $array_peds[] = new Pedidos($fila);
    }
    $resultado->closeCursor();
    return ($array_peds);
  }

  // Obtener pedidos de un cliente por código
  public static function getPedidosCliente($codigo)
  {
    $sql = "SELECT * FROM PEDIDOS where clientePedido='$codigo'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_peds = array();
    while ($fila = $resultado->fetch()) {
      $array_peds[] = new Pedidos($fila);
    }
    $resultado->closeCursor();
    return ($array_peds);
  }

  // Obtener descuento de un pedido
  public static function getDescuentoPedido($codPedido)
  {
    $sql = "SELECT * FROM PEDIDOS where codigoPedido='$codPedido'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $pedido = new Pedidos($resultado->fetch());
    $desc = $pedido->getDescuento();
    $resultado->closeCursor();
    return ($desc);
  }

  // Obtener precio de un pedido
  public static function getPrecioPedido($codPedido)
  {
    $sql = "SELECT * FROM PEDIDOS where codigoPedido='$codPedido'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $pedido = new Pedidos($resultado->fetch());
    $prec = $pedido->getPrecio();
    $resultado->closeCursor();
    return ($prec);
  }

  // OBTENER TOTAL PEDIDOS
  public static function getTotalPedidos()
  {
    $sql = "SELECT COUNT(*) FROM PEDIDOS";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    $num_filas = $resultado->fetchColumn();
    return $num_filas;
  }

  // OBTENER TODOS LOS PEDIDOS PARA PAGINACIÓN
  public static function getPedidosPag($pagLimit)
  {
    $sql = "SELECT * FROM PEDIDOS ORDER BY clientePedido LIMIT $pagLimit, 20";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_peds = array();
    while ($fila = $resultado->fetch()) {
      $array_peds[] = new Pedidos($fila);
    }
    $resultado->closeCursor();
    return ($array_peds);
  }

  // OBTENER CANTIDAD PEDIDOS DE UN CLIENTE
  public static function getCantPedidosCliente($codigoCl)
  {
    $sql = "SELECT COUNT(*) FROM PEDIDOS WHERE clientePedido = '$codigoCl'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    $num_filas = $resultado->fetchColumn();
    return $num_filas;
  }

  // Nuevo pedido panel
  public static function nuevoPedidoPanel($cliente, $precio, $descuento, $precFinal)
  {
    $sql = "INSERT INTO PEDIDOS (clientePedido, precioPedido, descuentoPedido, precioFinalPedido) VALUES ('$cliente','$precio','$descuento','$precFinal')";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Pedido insertado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al insertar pedido!.');</script>";
    }
  }

  // Modificar pedido
  public static function modificarPedido($codigo, $cliente, $precio, $descuento, $precFinal)
  {
    $sql = "UPDATE PEDIDOS SET clientePedido = '$cliente', precioPedido='$precio', descuentoPedido='$descuento', precioFinalPedido='$precFinal' WHERE codigoPedido = '$codigo'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Pedido modificado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al modificar el pedido!');</script>";
    }
  }

  // Modificar precios de pedido
  public static function modificarPreciosPedido($codigo, $precio, $precFinal)
  {
    $sql = "UPDATE PEDIDOS SET precioPedido='$precio', precioFinalPedido='$precFinal' WHERE codigoPedido = '$codigo'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Pedido modificado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al modificar el pedido!');</script>";
    }
  }

  // Eliminar pedido
  public static function eliminarPedido($codigo)
  {
    $sql = "DELETE FROM PEDIDOS WHERE codigoPedido = '$codigo'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Pedido eliminado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al eliminar el pedido!');</script>";
    }
  }

  // Nuevo pedido
  public static function nuevoPedido($cliente, $precio, $descuento, $precFinal)
  {
    $sql = "INSERT INTO PEDIDOS (clientePedido, precioPedido, descuentoPedido, precioFinalPedido) VALUES ('$cliente','$precio','$descuento','$precFinal')";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
  }

  // Obtener último pedido cliente
  public static function getUltimoPedidoCliente($codigoCl)
  {
    $sql = "SELECT codigoPedido FROM PEDIDOS WHERE clientePedido = '$codigoCl' ORDER BY codigoPedido DESC LIMIT 1";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array($sql));
    $array_peds = $resultado->fetchAll();
    $resultado->closeCursor();
    return ($array_peds);
  }

  // -- DETALLES PEDIDOS --
  // Obtener detalles pedidos por código pedido
  public static function getDetallesPedido($codigo)
  {
    $sql = "SELECT * FROM DETALLES_PEDIDOS where codigoPedido='$codigo'";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_det = array();
    while ($fila = $resultado->fetch()) {
      $array_det[] = new Detalles_Pedidos($fila);
    }
    $resultado->closeCursor();
    return ($array_det);
  }

  // OBTENER TOTAL DETALLES PEDIDOS
  public static function getTotalDetPedidos()
  {
    $sql = "SELECT COUNT(*) FROM DETALLES_PEDIDOS";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    $num_filas = $resultado->fetchColumn();
    return $num_filas;
  }

  // OBTENER TODOS LOS DETALLES_PEDIDOS PARA PAGINACIÓN
  public static function getDetPedidosPag($pagLimit)
  {
    $sql = "SELECT * FROM DETALLES_PEDIDOS ORDER BY codigoPedido, codigoProductoDetalle LIMIT $pagLimit, 20";
    $conexion = self::ejecutarConsulta();
    $resultado = $conexion->prepare($sql);
    $resultado->execute(array());
    $array_dets = array();
    while ($fila = $resultado->fetch()) {
      $array_dets[] = new Detalles_Pedidos($fila);
    }
    $resultado->closeCursor();
    return ($array_dets);
  }

  // Nuevo detalle panel
  public static function nuevoDetallePanel($codPed, $codProducto, $cantidad, $precio)
  {
    $sql = "INSERT INTO DETALLES_PEDIDOS (codigoPedido, codigoProductoDetalle, cantidadDetalle, precioDetalle) VALUES ('$codPed','$codProducto','$cantidad','$precio')";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Detalle de pedido insertado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al insertar detalle de pedido!.');</script>";
    }
  }

  // Modificar detalle
  public static function modificarDetalle($codigo, $codPed, $codProducto, $cantidad, $precio)
  {
    $sql = "UPDATE DETALLES_PEDIDOS SET codigoPedido = '$codPed', codigoProductoDetalle='$codProducto', cantidadDetalle='$cantidad', precioDetalle='$precio' WHERE codigoDetalle = '$codigo'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Detalle de pedido modificado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al modificar el detalle del pedido!');</script>";
    }
  }

  // Eliminar detalle
  public static function eliminarDetalle($codigo)
  {
    $sql = "DELETE FROM DETALLES_PEDIDOS WHERE codigoDetalle = '$codigo'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Detalle de pedido eliminado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al eliminar el detalle del pedido!');</script>";
    }
  }

  // Eliminar detalles de un pediddo
  public static function eliminarDetallesPedido($codPedido)
  {
    $sql = "DELETE FROM DETALLES_PEDIDOS WHERE codigoPedido = '$codPedido'";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
    if ($afectados > 0) {
      echo "<script>alert('¡Detalles de pedido eliminado con éxito!.');</script>";
    } else {
      echo "<script>alert('¡Error al eliminar los detalles del pedido!');</script>";
    }
  }

  // Nuevo detalle
  public static function nuevoDetalle($codPed, $codProducto, $cantidad, $precio)
  {
    $sql = "INSERT INTO DETALLES_PEDIDOS (codigoPedido, codigoProductoDetalle, cantidadDetalle, precioDetalle) VALUES ('$codPed','$codProducto','$cantidad','$precio')";
    $conexion = self::ejecutarConsulta($sql);
    $resultado = $conexion->prepare($sql);
    $afectados = $resultado->execute();
  }
}
