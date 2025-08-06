<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>RSJNews - Feed</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="estilos/feed.css">
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
      <a href="feed.php" title="Feed" class="active">
        <i class="fas fa-home"></i>
      </a>
      <a href="criar_post.php" title="Criar postagem">
        <i class="fas fa-plus"></i>
      </a>
      <a href="perfil.php" title="Perfil">
        <i class="fas fa-user"></i>
      </a>
    </div>
  </div>

  <div class="main-container">
    <div class="feed">
      <div class="post">
        <div class="post-header">
          <img class="post-avatar" src="https://m.media-amazon.com/images/M/MV5BZDE2ZjIxYzUtZTJjYS00OWQ0LTk2NGEtMDliYmI3MzMwYjhkXkEyXkFqcGdeQWFsZWxvZw@@._V1_.jpg" alt="Avatar"/>
          <div class="post-user">
            <div class="post-name">Eduardo Merli</div>
            <div class="post-username">@eduardomerli · 2h</div>
          </div>
        </div>

        <div class="post-content">
          Acabei de lançar meu novo projeto de interface para idosos. Focado em acessibilidade e usabilidade.
          É incrível ver como a tecnologia pode conectar gerações! #Acessibilidade #DesignUniversal
        </div>

        <img class="post-image" src="https://images.unsplash.com/photo-1635805737707-575885ab0820?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Projeto 1"/>

        <div class="post-stats">
          <div class="post-stat"><i class="far fa-comment"></i> 24</div>
          <div class="post-stat"><i class="fas fa-retweet"></i> 8</div>
          <div class="post-stat"><i class="far fa-heart"></i> 142</div>
          <div class="post-stat"><i class="fas fa-chart-bar"></i> 1.2K</div>
        </div>

        <div class="post-actions">
          <div class="post-action">
            <i class="far fa-comment"></i>
            <span>Comentar</span>
          </div>
          <div class="post-action">
            <i class="fas fa-retweet"></i>
            <span>Republicar</span>
          </div>
          <div class="post-action">
            <i class="far fa-heart"></i>
            <span>Curtir</span>
          </div>
          <div class="post-action">
            <i class="fas fa-share"></i>
            <span>Compartilhar</span>
          </div>
        </div>
      </div>
    </div>

    <div class="sidebar">
      <div class="ad">
        <div class="ad-header">Patrocinado</div>
        <div class="ad-content">
          <img src="https://images.unsplash.com/photo-1581093458799-ef0d0c87f1a1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Aplicativo">
          <h3>App Conecta Gerações</h3>
          <p>Plataforma para conectar jovens e idosos em atividades de aprendizado mútuo</p>
          <button class="ad-button">Baixe Agora</button>
        </div>
      </div>
    </div>
  </div>

  <div class="footer">
    <div class="footer-ads"></div>
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

    document.querySelectorAll('.ad-button').forEach(button => {
      button.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.05)';
      });
      button.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
      });
    });
  </script>
</body>
</html>