<?php
    session_start();
    $codigoINT = rand(1000, 9999);
    $codigoSTR = strval($codigoINT);
    $_SESSION['codigo'] = $codigoSTR;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'] ?? '';
        $_SESSION['email'] = $email;

        $conexao = mysqli_connect('localhost', 'root', '', 'RSJNews');
        if (!$conexao) die("<p style='color:red;'>Erro na conexão: " . mysqli_connect_error() . "</p>");

        $stmt = mysqli_prepare($conexao, "SELECT nome, sobrenome, email FROM User WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {

                header("Location: esqueceu.php");
                exit;
        } else {
            $erro = "<p style='color:red;'>E-mail não encontrado! Tente novamente.</p>";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conexao);
    }

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
  <form action="mudanca.php" method="post">
    <div class="input-group">
    <input type="text" name="email" placeholder="E-mail" required/>
    </div>
    <div class="input-group">
        <button type="submit">Verificar</button>
    </div>
  </form>
</div>
</body>
</html>