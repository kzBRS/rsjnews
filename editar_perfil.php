<?php
$host = 'localhost';
$dbname = 'RSJNews';
$username = 'root';
$password = '';

$user = [];
$success_message = '';
$error_message = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_id = 1;

    $stmt = $pdo->prepare("SELECT * FROM User WHERE ID = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt_posts = $pdo->prepare("SELECT COUNT(*) FROM Post WHERE user_id = :user_id");
    $stmt_posts->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_posts->execute();
    $post_count = $stmt_posts->fetchColumn();

    $stmt_followers = $pdo->prepare("SELECT COUNT(*) FROM Seguidores WHERE seguido_id = :user_id");
    $stmt_followers->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_followers->execute();
    $followers_count = $stmt_followers->fetchColumn();

    $stmt_following = $pdo->prepare("SELECT COUNT(*) FROM Seguidores WHERE seguidor_id = :user_id");
    $stmt_following->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_following->execute();
    $following_count = $stmt_following->fetchColumn();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'] ?? '';
        $sobrenome = $_POST['sobrenome'] ?? '';
        $nome_completo = $nome . ' ' . $sobrenome;
        $bio = $_POST['bio'] ?? '';
        $localizacao = $_POST['localizacao'] ?? '';
        $trabalho = $_POST['trabalho'] ?? '';
        $formacao = $_POST['formacao'] ?? '';
        $website = $_POST['website'] ?? '';
        $avatar_path = $_POST['avatar_path'] ?? '';

        $update_stmt = $pdo->prepare("
            UPDATE User
            SET
              nome = :nome,
              sobrenome = :sobrenome,
              nome_completo = :nome_completo,
              bio = :bio,
              localizacao = :localizacao,
              trabalho = :trabalho,
              formacao = :formacao,
              website = :website,
              avatar_path = :avatar_path
            WHERE ID = :user_id
        ");

        $update_stmt->bindParam(':nome', $nome);
        $update_stmt->bindParam(':sobrenome', $sobrenome);
        $update_stmt->bindParam(':nome_completo', $nome_completo);
        $update_stmt->bindParam(':bio', $bio);
        $update_stmt->bindParam(':localizacao', $localizacao);
        $update_stmt->bindParam(':trabalho', $trabalho);
        $update_stmt->bindParam(':formacao', $formacao);
        $update_stmt->bindParam(':website', $website);
        $update_stmt->bindParam(':avatar_path', $avatar_path);
        $update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($update_stmt->execute()) {
            $success_message = 'Perfil atualizado com sucesso!';
            $stmt = $pdo->prepare("SELECT * FROM User WHERE ID = :user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $error_message = 'Erro ao atualizar o perfil. Por favor, tente novamente.';
        }
    }

    if (!empty($user['data_cadastro'])) {
        $data_cadastro = new DateTime($user['data_cadastro']);
        $data_formatada = $data_cadastro->format('F Y');
    } else {
        $data_formatada = 'Desconhecido';
    }

} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Perfil - RSJNews</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="estilos/editar_perfil.css">
  <style>
  
  </style>
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
      <a href="perfil.php" title="Perfil"><i class="fas fa-user"></i></a>
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
        
        <a href="editar_perfil.php" class="post-button" style="width: 100%; margin-top: 15px; text-decoration: none; background: var(--roxo-secundario);">
          <i class="fas fa-edit"></i> Editando Perfil
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
      <div class="edit-form-container">
        <div class="form-header">
          <i class="fas fa-user-edit"></i>
          <h2>Editar Perfil</h2>
        </div>
        
        <div class="form-description">
          Atualize suas informações pessoais para que outros usuários possam conhecê-lo melhor. Todas as informações são opcionais, exceto as marcadas como obrigatórias.
        </div>
        
        <?php if ($success_message): ?>
          <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <div><?php echo $success_message; ?></div>
          </div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
          <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div><?php echo $error_message; ?></div>
          </div>
        <?php endif; ?>
        
        <form action="editar_perfil.php" method="post">
          <div class="form-row">
  <div class="form-col">
    <div class="form-group">
      <label for="nome">Nome *</label>
      <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
    </div>
  </div>
  <div class="form-col">
    <div class="form-group">
      <label for="sobrenome">Sobrenome *</label>
      <input type="text" id="sobrenome" name="sobrenome" class="form-control"
        value="<?php echo htmlspecialchars($user['sobrenome']); ?>" required>
    </div>
  </div>
</div>
          <div class="form-group">
            <label for="bio">Biografia</label>
            <textarea id="bio" name="bio" class="form-control" placeholder="Conte um pouco sobre você..."><?php echo htmlspecialchars($user['bio']); ?></textarea>
          </div>
          
          <div class="form-row">
            <div class="form-col">
              <div class="form-group">
                <label for="localizacao">Localização</label>
                <input type="text" id="localizacao" name="localizacao" class="form-control" value="<?php echo htmlspecialchars($user['localizacao']); ?>" placeholder="Cidade, Estado">
              </div>
            </div>
            
            <div class="form-col">
              <div class="form-group">
                <label for="trabalho">Trabalho</label>
                <input type="text" id="trabalho" name="trabalho" class="form-control" value="<?php echo htmlspecialchars($user['trabalho']); ?>" placeholder="Sua profissão ou empresa">
              </div>
            </div>
          </div>
          
          <div class="form-row">
            <div class="form-col">
              <div class="form-group">
                <label for="formacao">Formação</label>
                <input type="text" id="formacao" name="formacao" class="form-control" value="<?php echo htmlspecialchars($user['formacao']); ?>"placeholder="Sua formação acadêmica">
              </div>
            </div>
            
            <div class="form-col">
              <div class="form-group">
                <label for="website">Website</label>
                <input type="url" id="website" name="website" class="form-control" value="<?php echo htmlspecialchars($user['website']); ?>" placeholder="https://exemplo.com">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="avatar_path">Link do Avatar</label>
            <input type="url" id="avatar_path" name="avatar_path" class="form-control" value="<?php echo htmlspecialchars($user['avatar_path']); ?>" placeholder="https://exemplo.com/avatar.jpg">
          </div>
          
          <div class="avatar-preview">
            <h3>Preview do Avatar</h3>
            <img id="avatar-preview" src="<?php echo $user['avatar_path'] ? htmlspecialchars($user['avatar_path']) : 'https://m.media-amazon.com/images/M/MV5BZDE2ZjIxYzUtZTJjYS00OWQ0LTk2NGEtMDliYmI3MzMwYjhkXkEyXkFqcGdeQWFsZWxvZw@@._V1_.jpg'; ?>" alt="Preview do avatar" class="profile-avatar" style="width: 120px; height: 120px;">
            <p class="text-muted">O avatar será atualizado automaticamente</p>
          </div>
          
          <div class="form-group">
            <label>Exemplos de Avatares</label>
            <div class="avatar-example">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" data-url="https://randomuser.me/api/portraits/men/32.jpg">
              <img src="https://randomuser.me/api/portraits/women/44.jpg" data-url="https://randomuser.me/api/portraits/women/44.jpg">
              <img src="https://randomuser.me/api/portraits/men/62.jpg" data-url="https://randomuser.me/api/portraits/men/62.jpg">
              <img src="https://randomuser.me/api/portraits/women/68.jpg" data-url="https://randomuser.me/api/portraits/women/68.jpg">
            </div>
          </div>
          
          <div class="form-actions">
            <a href="TelaAcount.php" class="btn btn-outline">
              <i class="fas fa-arrow-left"></i> Voltar ao Perfil
            </a>
              <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Salvar Alterações
              </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="footer">
    <p>© 2025 RSJNews - Conectando jovens e idosos através da tecnologia</p>
  </div>

  <script>
    const avatarInput = document.getElementById('avatar_path');
    const avatarPreview = document.getElementById('avatar-preview');
    
    avatarInput.addEventListener('input', function() {
      if (this.value) {
        avatarPreview.src = this.value;
      } else {
        avatarPreview.src = 'https://m.media-amazon.com/images/M/MV5BZDE2ZjIxYzUtZTJjYS00OWQ0LTk2NGEtMDliYmI3MzMwYjhkXkEyXkFqcGdeQWFsZWxvZw@@._V1_.jpg';
      }
    });
    
    document.querySelectorAll('.avatar-example img').forEach(img => {
      img.addEventListener('click', function() {
        document.querySelectorAll('.avatar-example img').forEach(i => {
          i.classList.remove('selected');
        });
        
        this.classList.add('selected');
        
        avatarInput.value = this.dataset.url;
        avatarPreview.src = this.dataset.url;
      });
    });
    
    setTimeout(() => {
      document.querySelectorAll('.alert').forEach(alert => {
        alert.style.display = 'none';
      });
    }, 5000);
  </script>
</body>
</html>