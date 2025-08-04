<?php
function validarEmail($email) {
  $padrao = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/";
  return preg_match($padrao, $email);
}

function validarDataNascimento($data) {
  $d = new DateTime($data);
  $hoje = new DateTime();
  $idade = $d->diff($hoje)->y;
  if ($d->format("Y") < 1900 || $d > $hoje) {
    return false;
  }
  return $idade >= 13;
}

$email = $_POST['email'] ?? '';
$nome = $_POST['nome'] ?? '';
$sobrenome = $_POST['sobrenome'] ?? '';
$usuario = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';
$repetirsenha = $_POST['repetirsenha'] ?? '';
$nascimento = $_POST['nascimento'] ?? '';
$nome_completo = $nome . ' ' . $sobrenome;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!validarEmail($email)) {
    echo "<p style='color:red;'>Erro: O e-mail informado não é válido!</p>";
  } elseif (!validarDataNascimento($nascimento)) {
    echo "<p style='color:red;'>Erro: Data de nascimento inválida ou idade mínima não atendida!</p>";
  } elseif ($senha !== $repetirsenha) {
    echo "<p style='color:red;'>Erro: As senhas não coincidem!</p>";
  } elseif (strlen($senha) < 8) {
    echo "<p style='color:red;'>Erro: A senha deve ter pelo menos 8 caracteres!</p>";
  } else {
    $conexao = mysqli_connect('localhost', 'root', '', 'RSJNews');
    if (!$conexao) die("<p style='color:red;'>Erro na conexão: " . mysqli_connect_error() . "</p>");

    $verf = mysqli_prepare($conexao, "SELECT id FROM User WHERE email = ?");
    mysqli_stmt_bind_param($verf, "s", $email);
    mysqli_stmt_execute($verf);
    $resEmail = mysqli_stmt_get_result($verf);

    $uv = mysqli_prepare($conexao, "SELECT id FROM User WHERE usuario = ?");
    mysqli_stmt_bind_param($uv, "s", $usuario);
    mysqli_stmt_execute($uv);
    $resUser = mysqli_stmt_get_result($uv);

    if (mysqli_num_rows($resEmail) > 0) {
      echo "<p style='color:red;'>Já existe um usuário cadastrado com esse e-mail.</p>";
    } elseif (mysqli_num_rows($resUser) > 0) {
      echo "<p style='color:red;'>Já existe alguém cadastrado com esse usuário.</p>";
    } else {
    $hash = password_hash($senha, PASSWORD_DEFAULT);
    $ins = mysqli_prepare(
        $conexao,
        "INSERT INTO User (email, nome, sobrenome, nome_completo, usuario, senha, nascimento) VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($ins, "sssssss", $email, $nome, $sobrenome, $nome_completo, $usuario, $hash, $nascimento);
    
    if (mysqli_stmt_execute($ins)) {
        session_start();
        $_SESSION['user_id'] = mysqli_insert_id($conexao);
        $_SESSION['usuario'] = $usuario;
        
        header("Location: gostos.php");
        exit;
    } else {
        echo "<p style='color:red;'>Erro ao registrar usuário!</p>";
    }
    mysqli_stmt_close($ins);
}}}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro</title>
  <link rel="stylesheet" href="estilos/registro.css"/>
</head>
<body>
<div class="container">
  <h1>Registre-se para ter acesso a <code>RSJNews</code></h1>
  <form action="registro.php" method="post">
    <div class="input-group">
    <input type="text" name="email" placeholder="E-mail" required value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>"/>
    </div>
    <div class="input-group">
        <input type="text" name="usuario" placeholder="Usuário" required value="<?php echo htmlspecialchars($usuario, ENT_QUOTES); ?>"/>
    </div>
    <div class="input-group">
        <input type="text" name="nome" placeholder="Nome" required value="<?php echo htmlspecialchars($nome, ENT_QUOTES); ?>"/>
    </div>
    <div class="input-group">
        <input type="text" name="sobrenome" placeholder="Sobrenome" required value="<?php echo htmlspecialchars($sobrenome, ENT_QUOTES); ?>"/>
    </div>
    <div class="input-group">
        <input type="password" name="senha" placeholder="Senha" required value="<?php echo htmlspecialchars($senha, ENT_QUOTES); ?>"/>
    </div>
    <div class="input-group">
        <input type="password" name="repetirsenha" placeholder="Repetir senha" required value="<?php echo htmlspecialchars($repetirsenha, ENT_QUOTES); ?>"/>
    </div>
    <div class="input-group">
        <input type="date" name="nascimento" required value="<?php echo htmlspecialchars($nascimento, ENT_QUOTES); ?>"/>
    </div>
    <div class="input-group">
        <button type="submit">Registrar</button>
    </div>
  </form>
</div>
</body>
</html>