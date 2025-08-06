<?php
    session_start();

    $codigoSTR = $_SESSION['codigo'] ?? '';
    $codigo = $_POST['code'] ?? '';

    if($codigo == $codigoSTR){
        header("Location: senha.php");
    }
    else {
        header("Location: codigo.php");
    }
?>