<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Seus Gostos</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="estilos/gostos.css">
</head>
<body>
  <div class="header">
    <div class="logo-container">
      <div class="logo">
        <a href="feed.php">RSJNews</a>
      </div>
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
      <a href="gostos.php" title="Seus Gostos" class="active"><i class="fas fa-user"></i></a>
    </div>
  </div>

  <div class="main-container">
    <div class="feed-header">
      <i class="fas fa-heart"></i>
      <h2>Gostos e Preferências</h2>
    </div>
    
    <form action="verificador.php" method="post">
      <div class="preferences-wrap">
        <label class="preference-label">
          <input type="checkbox" class="preference-checkbox" name="preferencias[]" value="economia">
          <div class="preference-item">
            <i class="fas fa-usd"></i>
            <span>Economia</span>
            <div class="checkmark">
              <i class="fas fa-check"></i>
            </div>
          </div>
        </label>
        
        <label class="preference-label">
          <input type="checkbox" class="preference-checkbox" name="preferencias[]" value="politica">
          <div class="preference-item">
            <i class="fas fa-balance-scale"></i>
            <span>Política</span>
            <div class="checkmark">
              <i class="fas fa-check"></i>
            </div>
          </div>
        </label>
        
        <label class="preference-label">
          <input type="checkbox" class="preference-checkbox" name="preferencias[]" value="educacao">
          <div class="preference-item">
            <i class="fas fa-book"></i>
            <span>Educação</span>
            <div class="checkmark">
              <i class="fas fa-check"></i>
            </div>
          </div>
        </label>
        
        <label class="preference-label">
          <input type="checkbox" class="preference-checkbox" name="preferencias[]" value="esportes">
          <div class="preference-item">
            <i class="fas fa-futbol"></i>
            <span>Esportes</span>
            <div class="checkmark">
              <i class="fas fa-check"></i>
            </div>
          </div>
        </label>
        
        <label class="preference-label">
          <input type="checkbox" class="preference-checkbox" name="preferencias[]" value="jogos">
          <div class="preference-item">
            <i class="fas fa-gamepad"></i>
            <span>Jogos</span>
            <div class="checkmark">
              <i class="fas fa-check"></i>
            </div>
          </div>
        </label>
        
        <label class="preference-label">
          <input type="checkbox" class="preference-checkbox" name="preferencias[]" value="musica">
          <div class="preference-item">
            <i class="fas fa-music"></i>
            <span>Música</span>
            <div class="checkmark">
              <i class="fas fa-check"></i>
            </div>
          </div>
        </label>
        
        <label class="preference-label">
          <input type="checkbox" class="preference-checkbox" name="preferencias[]" value="saude">
          <div class="preference-item">
            <i class="fas fa-heart-pulse"></i>
            <span>Saúde</span>
            <div class="checkmark">
              <i class="fas fa-check"></i>
            </div>
          </div>
        </label>
        
        <label class="preference-label">
          <input type="checkbox" class="preference-checkbox" name="preferencias[]" value="internacional">
          <div class="preference-item">
            <i class="fas fa-plane"></i>
            <span>Internacional</span>
            <div class="checkmark">
              <i class="fas fa-check"></i>
            </div>
          </div>
        </label>
      </div>

      <div class="save-button-wrap">
        <button type="submit" class="save-button">
          <i class="fas fa-save"></i> Salvar Preferências
        </button>
      </div>
    </form>
  </div>

  <script>
    document.querySelectorAll('.preference-label').forEach(label => {
      label.addEventListener('click', function(e) {
        const checkbox = this.querySelector('.preference-checkbox');
        checkbox.checked = !checkbox.checked;
        
        const item = this.querySelector('.preference-item');
        if(checkbox.checked) {
          item.classList.add('selected');
        } else {
          item.classList.remove('selected');
        }
      });
    });
  </script>
</body>
</html>