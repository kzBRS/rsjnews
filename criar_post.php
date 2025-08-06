<?php
session_start();

$host = 'localhost';
$dbname = 'RSJNews';
$username = 'root';
$password = '';
$error_message = '';
$success_message = '';
$form_content = '';
$user = [
    'nome_completo' => 'Eduardo Merli',
    'avatar_path' => 'https://m.media-amazon.com/images/M/MV5BZDE2ZjIxYzUtZTJjYS00OWQ0LTk2NGEtMDliYmI3MzMwYjhkXkEyXkFqcGdeQWFsZWxvZw@@._V1_.jpg'
];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if (isset($_SESSION['user_id'])) {
        $stmt = $pdo->prepare("SELECT * FROM User WHERE ID = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $_SESSION['user_id'] = 1;
    }
} catch (PDOException $e) {
    $error_message = "Erro na conexão com o banco de dados: " . $e->getMessage();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['conteudo'] ?? '');
    $image_path = null;
    
    if (empty($content)) {
        $error_message = 'Por favor, escreva algo para publicar!';
    } elseif (strlen($content) > 500) {
        $error_message = 'O conteúdo excede o limite de 500 caracteres';
    }

    if (empty($error_message)) {
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['imagem'];
            
            $allowed_types = ['image/jpeg', 'image/png'];
            if (!in_array($file['type'], $allowed_types)) {
                $error_message = 'Tipo de arquivo inválido. Use JPG ou PNG.';
            } elseif ($file['size'] > 5 * 1024 * 1024) {
                $error_message = 'O tamanho da imagem não pode exceder 5MB.';
            } else {
                $upload_dir = 'uploads/posts/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid('post_') . '.' . $ext;
                $target_path = $upload_dir . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $target_path)) {
                    $image_path = $target_path;
                } else {
                    $error_message = 'Erro ao salvar a imagem.';
                }
            }
        }
    }

    if (empty($error_message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Post (user_id, conteudo, imagem_path) VALUES (?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $content, $image_path]);
            $success_message = 'Postagem criada com sucesso!';
            $form_content = '';
        } catch (PDOException $e) {
            $error_message = 'Erro ao criar postagem: ' . $e->getMessage();
        }
    } else {
        $form_content = htmlspecialchars($content);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Post - RSJNews</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="estilos/criar_post.css">
</head>
<body>
  <div class="header">
    <div class="logo-container">
      <div class="logo"><a href="feed.php">RSJNews</a></div>
      <div class="search-bar">
        <i class="fas fa-search"></i>
        <form action="feed.php" method="post">
          <input type="text" placeholder="Pesquisar pessoas e páginas" name="user" required>
        </form>
      </div>
    </div>

    <div class="nav-icons">
      <a href="feed.php" title="Página inicial"><i class="fas fa-home"></i></a>
      <a href="criar_post.php" title="Criar postagem" class="active"><i class="fas fa-plus"></i></a>
      <a href="perfil.php" title="Perfil"><i class="fas fa-user"></i></a>
    </div>
  </div>

  <div class="main-container">
    <div class="sidebar">
      <div class="profile-card">
        <img class="profile-avatar" src="<?= htmlspecialchars($user['avatar_path']) ?>" alt="Avatar do usuário">
        <div class="profile-name"><?= htmlspecialchars($user['nome_completo']) ?></div>
      </div>
    </div>

    <div class="content">
      <form class="create-form" method="POST" enctype="multipart/form-data">
        <div class="form-header">
          <i class="fas fa-edit"></i>
          <h2>Criar Nova Postagem</h2>
        </div>
        
        <div id="message-container">
          <?php if ($error_message): ?>
          <div class="message error">
            <i class="fas fa-exclamation-circle"></i>
            <span><?= $error_message ?></span>
          </div>
          <?php endif; ?>
          
          <?php if ($success_message): ?>
          <div class="message success">
            <i class="fas fa-check-circle"></i>
            <span><?= $success_message ?></span>
          </div>
          <?php endif; ?>
        </div>
        
        <div class="form-group">
          <label for="post-text">Conteúdo da postagem</label>
          <textarea id="post-text" class="post-text" placeholder="O que você está pensando?" name="conteudo" maxlength="500" required><?= $form_content ?></textarea>
          <div id="character-count" class="character-count">500 caracteres restantes</div>
        </div>
        
        <div class="form-group">
          <label>Adicionar imagem (opcional)</label>
          <div class="image-upload" id="image-upload-area">
            <i class="fas fa-cloud-upload-alt"></i>
            <p>Arraste e solte uma imagem aqui ou clique para selecionar</p>
            <button type="button" class="upload-btn">Selecionar imagem</button>
          </div>
          <input type="file" id="image-input" name="imagem" accept="image/*" style="display: none;">
          <div class="image-preview" id="image-preview">
            <img id="preview-img" class="preview-img" src="" alt="Pré-visualização">
            <button type="button" class="remove-image" id="remove-image">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        
        <div class="form-footer">
          <div id="character-count-bottom" class="character-count">500 caracteres restantes</div>
          <button id="submit-post" class="post-button" type="submit">
            <i class="fas fa-paper-plane"></i> Publicar
          </button>
        </div>
      </form>
    </div>
  </div>

  <a href="criar_post.php" class="add-post-button" title="Criar postagem">
    <i class="fas fa-plus"></i>
  </a>

  <div class="footer">
    <p>© 2025 RSJNews - Conectando jovens e idosos através da tecnologia</p>
  </div>

  <script>
    const postText = document.getElementById('post-text');
    const imageInput = document.getElementById('image-input');
    const imageUploadArea = document.getElementById('image-upload-area');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const removeImageBtn = document.getElementById('remove-image');
    const charCount = document.getElementById('character-count');
    const charCountBottom = document.getElementById('character-count-bottom');
    const MAX_CHARS = 500;
    
    function updateCharacterCount() {
      const currentLength = postText.value.length;
      const remaining = MAX_CHARS - currentLength;
      
      charCount.textContent = `${remaining} caracteres restantes`;
      charCountBottom.textContent = `${remaining} caracteres restantes`;
      
      if (remaining < 50) {
        charCount.classList.add('limit');
        charCountBottom.classList.add('limit');
      } else {
        charCount.classList.remove('limit');
        charCountBottom.classList.remove('limit');
      }
    }
    
    postText.addEventListener('input', updateCharacterCount);
    
    updateCharacterCount();
    
    imageUploadArea.addEventListener('click', function() {
      imageInput.click();
    });
    
    imageInput.addEventListener('change', function(e) {
      if (this.files && this.files[0]) {
        const file = this.files[0];
        
        if (!file.type.match('image.*')) {
          alert('Por favor, selecione apenas arquivos de imagem (JPEG, PNG, GIF)');
          return;
        }
        
        if (file.size > 5 * 1024 * 1024) {
          alert('O tamanho máximo permitido é 5MB');
          return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
          previewImg.src = e.target.result;
          imagePreview.style.display = 'block';
          imageUploadArea.style.display = 'none';
        }
        
        reader.readAsDataURL(file);
      }
    });
    
    removeImageBtn.addEventListener('click', function() {
      previewImg.src = '';
      imagePreview.style.display = 'none';
      imageUploadArea.style.display = 'flex';
      imageInput.value = '';
    });
    
    imageUploadArea.addEventListener('dragover', function(e) {
      e.preventDefault();
      this.style.borderColor = 'var(--roxo-primario)';
      this.style.backgroundColor = 'var(--roxo-claro)';
    });
    
    imageUploadArea.addEventListener('dragleave', function() {
      this.style.borderColor = 'var(--cinza-medio)';
      this.style.backgroundColor = '';
    });
    
    imageUploadArea.addEventListener('drop', function(e) {
      e.preventDefault();
      this.style.borderColor = 'var(--cinza-medio)';
      this.style.backgroundColor = '';
      
      if (e.dataTransfer.files && e.dataTransfer.files[0]) {
        const file = e.dataTransfer.files[0];
        
        if (!file.type.match('image.*')) {
          alert('Por favor, selecione apenas arquivos de imagem (JPEG, PNG, GIF)');
          return;
        }
        
        if (file.size > 5 * 1024 * 1024) {
          alert('O tamanho máximo permitido é 5MB');
          return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
          previewImg.src = e.target.result;
          imagePreview.style.display = 'block';
          imageUploadArea.style.display = 'none';
          
          const dataTransfer = new DataTransfer();
          dataTransfer.items.add(file);
          imageInput.files = dataTransfer.files;
        }
        
        reader.readAsDataURL(file);
      }
    });
  </script>
</body>
</html>