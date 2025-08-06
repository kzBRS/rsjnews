<?php
$host = 'localhost';
$dbname = 'RSJNews';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $user_id = 1;
    $stmt = $pdo->prepare("SELECT * FROM User WHERE ID = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("SELECT COUNT(*) AS post_count FROM Post WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $post_count = $stmt->fetchColumn();
    
    $stmt = $pdo->prepare("SELECT COUNT(*) AS followers_count FROM Seguidores WHERE seguido_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $followers_count = $stmt->fetchColumn();
    
    $stmt = $pdo->prepare("SELECT COUNT(*) AS following_count FROM Seguidores WHERE seguidor_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $following_count = $stmt->fetchColumn();
    
    $stmt = $pdo->prepare("SELECT * FROM Post WHERE user_id = :user_id ORDER BY data_publicacao DESC");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $data_cadastro = new DateTime($user['data_cadastro']);
    $data_formatada = $data_cadastro->format('F Y');
    
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($user['nome_completo']); ?> - Perfil</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="estilos/perfil.css">
</head>
<body>
  <div class="header">
    <div class="logo-container">
      <div class="logo"><a href="feed.php">RSJNews</a></div>
      <div class="search-bar">
        <i class="fas fa-search"></i>
        <form action="pesquisa.php" method="post">
          <input type="text" placeholder="Pesquisar pessoas e páginas" name="user" required>
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
    <div class="sidebar">
      <div class="profile-card">
        <img class="profile-avatar" src="<?php echo $user['avatar_path'] ? htmlspecialchars($user['avatar_path']) : 'https://m.media-amazon.com/images/M/MV5BZDE2ZjIxYzUtZTJjYS00OWQ0LTk2NGEtMDliYmI3MzMwYjhkXkEyXkFqcGdeQWFsZWxvZw@@._V1_.jpg'; ?>" alt="Avatar do usuário">
        <div class="profile-name"><?php echo htmlspecialchars($user['nome_completo']); ?></div>
        <div class="profile-username">@<?php echo htmlspecialchars($user['usuario']); ?></div>
        
        <div class="profile-stats">
          <div class="stat">
            <span class="stat-value"><?php echo $post_count; ?></span>
            <span class="stat-label">Posts</span>
          </div>
          <div class="stat">
            <span class="stat-value"><?php echo $followers_count; ?></span>
            <span class="stat-label">Seguidores</span>
          </div>
          <div class="stat">
            <span class="stat-value"><?php echo $following_count; ?></span>
            <span class="stat-label">Seguindo</span>
          </div>
        </div>
        
        <div class="profile-bio">
          <?php echo $user['bio'] ? htmlspecialchars($user['bio']) : 'Este usuário ainda não adicionou uma bio.'; ?>
        </div>
        
        <a href="editar_perfil.php" class="post-button" style="width: 100%; margin-top: 15px; text-decoration: none;">
          <i class="fas fa-edit"></i> Editar Perfil
        </a>
      </div>
      
      <div class="profile-info">
        <?php if ($user['trabalho']): ?>
        <div class="info-item">
          <i class="fas fa-briefcase"></i>
          <div>
            <div style="font-weight: 500;">Trabalho</div>
            <div><?php echo htmlspecialchars($user['trabalho']); ?></div>
          </div>
        </div>
        <?php endif; ?>
        
        <?php if ($user['formacao']): ?>
        <div class="info-item">
          <i class="fas fa-graduation-cap"></i>
          <div>
            <div style="font-weight: 500;">Formação</div>
            <div><?php echo htmlspecialchars($user['formacao']); ?></div>
          </div>
        </div>
        <?php endif; ?>
        
        <?php if ($user['localizacao']): ?>
        <div class="info-item">
          <i class="fas fa-map-marker-alt"></i>
          <div>
            <div style="font-weight: 500;">Localização</div>
            <div><?php echo htmlspecialchars($user['localizacao']); ?></div>
          </div>
        </div>
        <?php endif; ?>
        
        <?php if ($user['website']): ?>
        <div class="info-item">
          <i class="fas fa-link"></i>
          <div>
            <div style="font-weight: 500;">Website</div>
            <div><?php echo htmlspecialchars($user['website']); ?></div>
          </div>
        </div>
        <?php endif; ?>
        
        <div class="info-item">
          <i class="fas fa-calendar-alt"></i>
          <div>
            <div style="font-weight: 500;">Entrou em</div>
            <div><?php echo $data_formatada; ?></div>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="feed">
        <div class="feed-header">
          <i class="fas fa-user-circle"></i>
          <h2>Meu Perfil</h2>
        </div>
        
        <div class="feed-content">
          <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
              <?php 
                $post_date = new DateTime($post['data_publicacao']);
                $current_date = new DateTime();
                $interval = $current_date->diff($post_date);
                
                if ($interval->y > 0) {
                  $time_ago = $interval->y . ' ano' . ($interval->y > 1 ? 's' : '');
                } elseif ($interval->m > 0) {
                  $time_ago = $interval->m . ' mês' . ($interval->m > 1 ? 'es' : '');
                } elseif ($interval->d > 0) {
                  $time_ago = $interval->d . ' dia' . ($interval->d > 1 ? 's' : '');
                } elseif ($interval->h > 0) {
                  $time_ago = $interval->h . ' hora' . ($interval->h > 1 ? 's' : '');
                } elseif ($interval->i > 0) {
                  $time_ago = $interval->i . ' minuto' . ($interval->i > 1 ? 's' : '');
                } else {
                  $time_ago = 'agora mesmo';
                }
              ?>
              <div class="post">
                <div class="post-header">
                  <img class="post-avatar" src="<?php echo $user['avatar_path'] ? htmlspecialchars($user['avatar_path']) : 'https://m.media-amazon.com/images/M/MV5BZDE2ZjIxYzUtZTJjYS00OWQ0LTk2NGEtMDliYmI3MzMwYjhkXkEyXkFqcGdeQWFsZWxvZw@@._V1_.jpg'; ?>" alt="Avatar">
                  <div class="post-user">
                    <div class="post-name"><?php echo htmlspecialchars($user['nome_completo']); ?></div>
                    <div class="post-username">@<?php echo htmlspecialchars($user['usuario']); ?> · <?php echo $time_ago; ?></div>
                  </div>
                </div>
                
                <div class="post-content">
                  <?php echo htmlspecialchars($post['conteudo']); ?>
                </div>
                
                <?php if ($post['imagem_path']): ?>
                  <img class="post-image" src="<?php echo htmlspecialchars($post['imagem_path']); ?>" alt="Imagem do post">
                <?php endif; ?>
                
                <div class="post-stats">
                  <div class="post-stat"><i class="far fa-comment"></i> <?php echo $post['comentarios']; ?></div>
                  <div class="post-stat"><i class="far fa-heart"></i> <?php echo $post['curtidas']; ?></div>
                  <div class="post-stat"><i class="fas fa-chart-bar"></i> <?php echo $post['visualizacoes']; ?></div>
                </div>
                
                <div class="post-actions">
                  <div class="post-action">
                    <i class="far fa-comment"></i>
                    <span>Comentar</span>
                  </div>
                  <div class="post-action">
                    <i class="far fa-heart"></i>
                    <span>Curtir</span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="post" style="text-align: center; padding: 40px;">
              <i class="fas fa-feather-alt" style="font-size: 48px; color: var(--roxo-claro); margin-bottom: 20px;"></i>
              <h3>Nenhum post ainda</h3>
              <p>Quando você postar algo, aparecerá aqui.</p>
              <a href="criar_post.php" class="post-button" style="margin-top: 20px;">Criar primeiro post</a>
            </div>
          <?php endif; ?>
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