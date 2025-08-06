<?php
    session_start();
    $email = $_SESSION['email'];
    $senha = $_POST['senha'] ?? '';
    $repetirsenha = $_POST['repetirsenha'] ?? '';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (strlen($senha) < 8 || strlen($repetirsenha) < 8 ){
            echo "<p> A senha deve conter pelo menos <strong>8 caracteres</strong>";
        }
        else if ($senha != $repetirsenha) {
            echo "<p> As senhas não se coincidem, tente novamente!</p>";
        }

        else{
            $conexao = mysqli_connect('localhost', 'root', '', 'RSJNews');
            if (!$conexao) die("<p style='color:red;'>Erro na conexão: " . mysqli_connect_error() . "</p>");
                $hash = password_hash($senha, PASSWORD_DEFAULT);
                $upt = mysqli_prepare($conexao, "UPDATE User SET senha = ? WHERE email = ?");
                mysqli_stmt_bind_param($upt, "ss", $hash, $email);

            if (mysqli_stmt_execute($upt)) {
                header("Location: index.php");
                exit;
            } 
            else {
                echo "<p style='color:red;'>Erro ao registrar usuário!</p>";
            }
            mysqli_stmt_close($upt);
            mysqli_close($conexao);
        }
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
  <form action="senha.php" method="post">
    <div class="input-group">
        <input type="password" name="senha" placeholder="Digite sua nova senha" required/>
    </div>
    <div class="input-group">
        <input type="password" name="repetirsenha" placeholder="Repita sua nova senha" required/>
    </div>
    <div class="input-group">
        <button type="submit">Verificar</button>
    </div>
  </form>
</div>
</body>
</html>