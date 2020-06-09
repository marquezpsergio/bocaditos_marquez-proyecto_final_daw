<?php
if (!empty($_GET['paymentID']) && !empty($_GET['payerID']) && !empty($_GET['token'])) {
    $_SESSION['paymentID'] = $_GET['paymentID'];
    $_SESSION['payerID'] = $_GET['payerID'];
    $_SESSION['token'] = $_GET['token'];
    echo "<script>alert('Pago realizado con éxito!!')</script>";
    echo "<script>location.href = '../finalizarPedido.php';</script>";
} else {
    echo "<script>alert('Error al procesar el pago...')</script>";
    echo "<script>location.href = '../tramitarPedido.php';</script>";
}
