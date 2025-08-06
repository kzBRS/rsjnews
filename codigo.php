<?php
    session_start();

    $codigoSTR = $_SESSION['codigo'] ?? '';
    $codigo = $_POST['code'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Esqueceu</title>
  <link rel="stylesheet" href="estilos/registro.css"/>
</head>
<body>
<div class="container">
  <h1>Mudança de senha para acessar o <code>RSJNews</code></h1>
  <form action="ver.php" method="post">
    <div class="input-group">
    <input type="text" name="code" placeholder="Digite o código enviado" required/>
    </div>
    <div class="input-group">
        <button type="submit">Verificar</button>
    </div>
  </form>
</div>
</body>
</html>