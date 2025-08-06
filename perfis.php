<?php
session_start();

$profileHTML = '';
$postsHTML = '';
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
            mysqli_stmt_bind_param($stmt, "s", $user);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $nome = htmlspecialchars($row['nome']);
                    $sobrenome = htmlspecialchars($row['sobrenome']);
                    $usuario = htmlspecialchars($row['usuario']);
                    $bio = htmlspecialchars($row['bio']);

                    $profileHTML .= '<div class="sidebar">';
                    $profileHTML .= '<div class="profile-card">';
                    $profileHTML .= '<img class="profile-avatar" src="https://m.media-amazon.com/images/M/MV5BZDE2ZjIxYzUtZTJjYS00OWQ0LTk2NGEtMDliYmI3MzMwYjhkXkEyXkFqcGdeQWFsZWxvZw@@._V1_.jpg" alt="Avatar">';
                    $profileHTML .= '<div class="profile-name">' . $nome . ' ' . $sobrenome . '</div>';
                    $profileHTML .= '<div class="profile-username">@' . $usuario . '</div>';
                    $profileHTML .= '<div class="profile-stats">';
                    $profileHTML .= '<div class="stat"><span class="stat-value">34</span><span class="stat-label">Posts</span></div>';
                    $profileHTML .= '<div class="stat"><span class="stat-value">1.2k</span><span class="stat-label">Seguidores</span></div>';
                    $profileHTML .= '<div class="stat"><span class="stat-value">210</span><span class="stat-label">Seguindo</span></div>';
                    $profileHTML .= '</div>';
                    $profileHTML .= '<div class="profile-bio">' . $bio . '</div>';
                    $profileHTML .= '<a href="editar_perfil.php" class="post-button" style="width:100%;margin-top:15px;text-decoration:none;"><i class="fas fa-edit"></i> Editar Perfil</a>';
                    $profileHTML .= '</div>';

                    $profileHTML .= '<div class="profile-info">';
                    $profileHTML .= '<div class="info-item"><i class="fas fa-briefcase"></i><div><div style="font-weight:500;">Trabalho</div><div>Desenvolvedor Front-End na ShrekTech</div></div></div>';
                    $profileHTML .= '<div class="info-item"><i class="fas fa-graduation-cap"></i><div><div style="font-weight:500;">Formação</div><div>Universidade do Pântano - Ciências da Computação</div></div></div>';
                    $profileHTML .= '<div class="info-item"><i class="fas fa-map-marker-alt"></i><div><div style="font-weight:500;">Localização</div><div>Pântano Distante, Far Far Away</div></div></div>';
                    $profileHTML .= '<div class="info-item"><i class="fas fa-link"></i><div><div style="font-weight:500;">Website</div><div>www.eduardomerli.dev</div></div></div>';
                    $profileHTML .= '<div class="info-item"><i class="fas fa-calendar-alt"></i><div><div style="font-weight:500;">Entrou em</div><div>Janeiro de 2020</div></div></div>';
                    $profileHTML .= '</div>';
                    $profileHTML .= '</div>';
                }
            } else {
                $error = "<p style='color:red;'>Usuário não encontrado!</p>";
            }
            mysqli_stmt_close($stmt);

            $postStmt = mysqli_prepare($conexao, "SELECT conteudo, imagem, data_postagem FROM Posts WHERE usuario = ? ORDER BY data_postagem DESC");
            mysqli_stmt_bind_param($postStmt, "s", $user);
            mysqli_stmt_execute($postStmt);
            $postResult = mysqli_stmt_get_result($postStmt);

            if (mysqli_num_rows($postResult) > 0) {
                while ($post = mysqli_fetch_assoc($postResult)) {
                    $conteudo = htmlspecialchars($post['conteudo']);
                    $imagem = htmlspecialchars($post['imagem']);
                    $data = htmlspecialchars($post['data_postagem']);

                    $postsHTML .= '<div class="post">';
                    $postsHTML .= '<p>' . $conteudo . '</p>';
                    if (!empty($imagem)) {
                        $postsHTML .= '<img src="' . $imagem . '" alt="Imagem do post">';
                    }
                    $postsHTML .= '<p><small>' . $data . '</small></p>';
                    $postsHTML .= '</div>';
                }
            } else {
                $postsHTML = '<p>Nenhuma postagem encontrada.</p>';
            }
            mysqli_stmt_close($postStmt);

            mysqli_close($conexao);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Perfil do Usuário</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="estilos/perfil.css"/>
</head>
<body>
  <div class="header">
    <div class="logo-container">
      <div class="logo"><a href="feed.php">RSJNews</a></div>
      <div class="search-bar">
        <i class="fas fa-search"></i>
        <form action="pesquisa.php" method="post">
          <input type="text" placeholder="Pesquisar pessoas e páginas" name="user" required/>
        </form>
      </div>
    </div>

    <div class="nav-icons">
      <a href="feed.php" title="Página inicial"><i class="fas fa-home"></i></a>
      <a href="criar_post.php" title="Criar postagem"><i class="fas fa-plus"></i></a>
      <a href="perfil.php" title="Perfil" class="active"><i class="fas fa-user"></i></a>
    </div>
  </div>

  <div class="main-container">
    <?php
      if (!empty($profileHTML)) {
        echo $profileHTML;
      } else if (!empty($error)) {
        echo '<div class="sidebar"><center>' . $error . '</center></div>';
      }
    ?>

    <div class="content">
      <div class="feed">
        <div class="feed-header">
          <i class="fas fa-user-circle"></i>
          <h2>Meu Perfil</h2>
        </div>
        <div class="feed-content">
          <?php echo $postsHTML; ?>
        </div>
      </div>
    </div>
  </div>

  <a href="criar_post.php" class="add-post-button" title="Criar postagem">
    <i class="fas fa-plus"></i>
  </a>

  <div class="footer">
    <p>© 2025 RSJNews - Conectando jovens e idosos através da tecnologia</p>
  </div>

  <script>
    document.querySelectorAll('.post-action').forEach(action => {
      action.addEventListener('click', function() {
        const icon = this.querySelector('i');
        if (icon.classList.contains('far')) {
          icon.classList.replace('far', 'fas');
          icon.style.color = 'var(--roxo-primario)';
        } else {
          icon.classList.replace('fas', 'far');
          icon.style.color = '';
        }
      });
    });

    document.querySelectorAll('.post-stat .fa-heart').forEach(heart => {
      heart.addEventListener('click', function() {
        if (this.classList.contains('far')) {
          this.classList.replace('far', 'fas');
          this.style.color = 'var(--roxo-primario)';
        } else {
          this.classList.replace('fas', 'far');
          this.style.color = '';
        }
      });
    });
  </script>
</body>
</html>
