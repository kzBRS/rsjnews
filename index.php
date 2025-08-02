    <?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $conexao = mysqli_connect('localhost', 'root', '', 'RSJNews');
        if (!$conexao) die("<p style='color:red;'>Erro na conexão: " . mysqli_connect_error() . "</p>");

        $stmt = mysqli_prepare($conexao, "SELECT id, usuario, senha FROM User WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($senha, $row['senha'])) {
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['usuario'] = $row['usuario'];
                header("Location: feed.php");
                exit;
            } else {
                $erro = "<p style='color:red;'>Senha incorreta! Tente novamente.</p>";
            }
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
    <title>Entrada</title>
    <link rel="stylesheet" href="estilos/index.css"/>
</head>
<body>
    <div class="container">
        <h1>Olá! Seja bem-vindo a <b><code>RSJNews</code></b>, porém é necessário que faça login ou registro!</h1>
        <?php echo $erro ?? ''; ?>
        <form action="index.php" method="post">
            <h1>Entrar</h1>
            <div class="input-group">
                <input type="email" placeholder="E-mail" name="email" required 
                       value="<?php echo htmlspecialchars($email ?? ''); ?>"/>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Senha" name="senha" required/>
            </div>
            <a href="registro.php">Não possui login? Cadastre-se agora!</a>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>