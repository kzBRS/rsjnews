<?php
session_start();

$profileHTML = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'] ?? '';

    if (empty(trim($user))) {
        $error = "<p style='color:red;'>Nome de usuário inválido!</p>";
    } else {
        $conexao = mysqli_connect('localhost', 'root', '', 'RSJNews');
        if (!$conexao) {
            $error = "<p style='color:red;'>Erro na conexão: " . mysqli_connect_error() . "</p>";
        } else {
            $stmt = mysqli_prepare($conexao, "SELECT usuario, nome, sobrenome, bio FROM User WHERE usuario = ?");
            if (!$stmt) {
                $error = "<p style='color:red;'>Erro na preparação: " . mysqli_error($conexao) . "</p>";
            } else {
                mysqli_stmt_bind_param($stmt, "s", $user);
                if (!mysqli_stmt_execute($stmt)) {
                    $error = "<p style='color:red;'>Erro na execução: " . mysqli_stmt_error($stmt) . "</p>";
                } else {
                    $result = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $nome = htmlspecialchars($row['nome']);
                            $sobrenome = htmlspecialchars($row['sobrenome']);
                            $todo = $nome . ' ' . $sobrenome;
                            $usuario = htmlspecialchars($row['usuario']);
                            $bio = htmlspecialchars($row['bio']);
                            
                            $profileHTML .= '<div class="sidebar">';
                            $profileHTML .= '<div class="profile-card">';
                            $profileHTML .= '<img class="profile-avatar" src="https://m.media-amazon.com/images/M/MV5BZDE2ZjIxYzUtZTJjYS00OWQ0LTk2NGEtMDliYmI3MzMwYjhkXkEyXkFqcGdeQWFsZWxvZw@@._V1_.jpg" alt="Avatar do Eduardo">';
                            $profileHTML .= '<div class="profile-info">';
                            $profileHTML .= '<div class="profile-name">' . $todo . '</div>';
                            $profileHTML .= '<div class="profile-username">@' . $usuario . '</div>';
                            $profileHTML .= '</div>';
                            $profileHTML .= '<div class="profile-bio">';
                            $profileHTML .= $bio;
                            $profileHTML .= '</div>';
                            $profileHTML .= '</div>';
                            $profileHTML .= '</div>';
                        }
                    } else {
                        $error = "Usuário não existe!";
                    }
                }
                mysqli_stmt_close($stmt);
            }
            mysqli_close($conexao);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSJNews - Pesquisa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="estilos/pesquisa.css">
</head>
<body>
  <div class="header">
    <div class="logo-container">
      <div class="logo"><a href="feed.php">RSJNews</a></div>
      <div class="search-bar">
        <i class="fas fa-search"></i>
        <form action="pesquisa.php" method="post">
          <input type="text" placeholder="Pesquisar pessoas e páginas" name="user" required />
        </form>
      </div>
    </div>
    <div class="nav-icons">
      <a href="feed.php" title="Página inicial"><i class="fas fa-home"></i></a>
      <a href="criar_post.php" title="Criar postagem"><i class="fas fa-plus"></i></a>
      <a href="perfil.php" title="Perfil" class="active"><i class="fas fa-user"></i></a>
    </div>
  </div>

  <div class="results-container">
    <div class="feed-header">
      <i class="fas fa-search"></i>
      <h2>Resultados</h2>
    </div>

    <?php
      if (!empty($profileHTML)) { 
        echo '<a href="perfis.php">';     
        echo $profileHTML;
        echo '</a>';
      } else if (!empty($error)) {
          echo '<div class="sidebar"><center>' . $error . '</center></div>';
      }
    ?>
  </div>

  <a href="criar_post.php" class="add-post-button" title="Criar postagem">
    <i class="fas fa-plus"></i>
  </a>

  <div class="footer">
    <p>© 2025 RSJNews - Conectando jovens e idosos através da tecnologia</p>
  </div>
</body>
</html>
