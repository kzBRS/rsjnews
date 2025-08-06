<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Rede Social</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f0f2f5;
            color: #333;
        }
        
        .container {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            gap: 20px;
        }
        
        /* Sidebar esquerda */
        .sidebar-left {
            width: 25%;
            position: sticky;
            top: 20px;
            height: fit-content;
        }
        
        .profile-card {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .profile-pic {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        
        .profile-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 5px;
            cursor: pointer;
        }
        
        .menu-item:hover {
            background-color: #f0f2f5;
        }
        
        .menu-item i {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .main-content {
            width: 50%;
        }
        
        .create-post {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .post-input {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .post-input img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .post-input input {
            flex: 1;
            padding: 10px 15px;
            border-radius: 20px;
            border: none;
            background-color: #f0f2f5;
            outline: none;
        }
        
        .post-options {
            display: flex;
            justify-content: space-between;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
        
        .post-option {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
        }
        
        .post-option:hover {
            background-color: #f0f2f5;
        }
        
        .post {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .post-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .post-user {
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .post-time {
            font-size: 12px;
            color: #65676b;
        }
        
        .post-content {
            margin-bottom: 15px;
        }
        
        .post-image {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        
        .post-stats {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            margin-bottom: 10px;
            font-size: 14px;
            color: #65676b;
        }
        
        .post-actions {
            display: flex;
            justify-content: space-around;
        }
        
        .post-action {
            display: flex;
            align-items: center;
            padding: 8px 0;
            cursor: pointer;
            border-radius: 5px;
            flex: 1;
            justify-content: center;
        }
        
        .post-action:hover {
            background-color: #f0f2f5;
        }
        
        /* Sidebar direita */
        .sidebar-right {
            width: 25%;
            position: sticky;
            top: 20px;
            height: fit-content;
        }
        
        .sponsored, .contacts {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 16px;
            color: #65676b;
            margin-bottom: 15px;
        }
        
        .contact {
            display: flex;
            align-items: center;
            padding: 8px 0;
            cursor: pointer;
            border-radius: 8px;
        }
        
        .contact:hover {
            background-color: #f0f2f5;
        }
        
        .contact img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .sidebar-left, .main-content, .sidebar-right {
                width: 100%;
            }
        }
    </style>
    <!-- Ícones do Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar esquerda -->
        <div class="sidebar-left">
            <div class="profile-card">
                <img src="https://via.placeholder.com/300" alt="Foto de perfil" class="profile-pic">
                <div class="profile-name">João Silva</div>
            </div>
            
            <div class="menu-item">
                <i class="fas fa-user-friends"></i>
                <span>Amigos</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-bell"></i>
                <span>Notificações</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-envelope"></i>
                <span>Mensagens</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Eventos</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-bookmark"></i>
                <span>Salvos</span>
            </div>
        </div>
        
        <!-- Conteúdo principal -->
        <div class="main-content">
            <!-- Criar post -->
            <div class="create-post">
                <div class="post-input">
                    <img src="https://via.placeholder.com/40" alt="Foto do usuário">
                    <input type="text" placeholder="No que você está pensando, João?">
                </div>
                <div class="post-options">
                    <div class="post-option">
                        <i class="fas fa-video" style="color: #f3425f;"></i>
                        <span>Vídeo ao vivo</span>
                    </div>
                    <div class="post-option">
                        <i class="fas fa-images" style="color: #45bd62;"></i>
                        <span>Foto/vídeo</span>
                    </div>
                    <div class="post-option">
                        <i class="far fa-smile" style="color: #f7b928;"></i>
                        <span>Sentimento/atividade</span>
                    </div>
                </div>
            </div>
            
            <!-- Post 1 -->
            <div class="post">
                <div class="post-header">
                    <img src="https://via.placeholder.com/40" alt="Foto do usuário">
                    <div>
                        <div class="post-user">Maria Oliveira</div>
                        <div class="post-time">Ontem às 18:30</div>
                    </div>
                </div>
                <div class="post-content">
                    <p>Acabei de voltar de uma viagem incrível para a praia! O lugar era maravilhoso e o clima estava perfeito. Recomendo muito esse destino!</p>
                </div>
                <img src="https://via.placeholder.com/600x400" alt="Imagem do post" class="post-image">
                <div class="post-stats">
                    <span>120 curtidas</span>
                    <span>24 comentários</span>
                </div>
                <div class="post-actions">
                    <div class="post-action">
                        <i class="far fa-thumbs-up"></i>
                        <span>Curtir</span>
                    </div>
                    <div class="post-action">
                        <i class="far fa-comment"></i>
                        <span>Comentar</span>
                    </div>
                    <div class="post-action">
                        <i class="fas fa-share"></i>
                        <span>Compartilhar</span>
                    </div>
                </div>
            </div>
            
            <!-- Post 2 -->
            <div class="post">
                <div class="post-header">
                    <img src="https://via.placeholder.com/40" alt="Foto do usuário">
                    <div>
                        <div class="post-user">Carlos Souza</div>
                        <div class="post-time">Hoje às 10:15</div>
                    </div>
                </div>
                <div class="post-content">
                    <p>Alguém pode me recomendar um bom restaurante na região central? Estou querendo experimentar algo novo!</p>
                </div>
                <div class="post-stats">
                    <span>45 curtidas</span>
                    <span>18 comentários</span>
                </div>
                <div class="post-actions">
                    <div class="post-action">
                        <i class="far fa-thumbs-up"></i>
                        <span>Curtir</span>
                    </div>
                    <div class="post-action">
                        <i class="far fa-comment"></i>
                        <span>Comentar</span>
                    </div>
                    <div class="post-action">
                        <i class="fas fa-share"></i>
                        <span>Compartilhar</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar direita -->
        <div class="sidebar-right">
            <div class="sponsored">
                <div class="section-title">Patrocinado</div>
                <div class="contact">
                    <img src="https://via.placeholder.com/30" alt="Anúncio">
                    <span>Oferta especial - 50% off</span>
                </div>
                <div class="contact">
                    <img src="https://via.placeholder.com/30" alt="Anúncio">
                    <span>Novo curso online</span>
                </div>
            </div>
            
            <div class="contacts">
                <div class="section-title">Contatos</div>
                <div class="contact">
                    <img src="https://via.placeholder.com/30" alt="Amigo">
                    <span>Ana Paula</span>
                </div>
                <div class="contact">
                    <img src="https://via.placeholder.com/30" alt="Amigo">
                    <span>Pedro Henrique</span>
                </div>
                <div class="contact">
                    <img src="https://via.placeholder.com/30" alt="Amigo">
                    <span>Juliana Costa</span>
                </div>
                <div class="contact">
                    <img src="https://via.placeholder.com/30" alt="Amigo">
                    <span>Ricardo Almeida</span>
                </div>
                <div class="contact">
                    <img src="https://via.placeholder.com/30" alt="Amigo">
                    <span>Fernanda Silva</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>