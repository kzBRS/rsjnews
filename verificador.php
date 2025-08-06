<?php
session_start();
echo "SESSION user_id: " . $_SESSION['user_id'];

require_once 'conexao.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $delete_sql = "DELETE FROM Gostos_User WHERE user_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $user_id);
    $delete_stmt->execute();
    $delete_stmt->close();
    
    if (isset($_POST['preferencias'])) {
        $interesses = $_POST['preferencias'];
        
        foreach ($interesses as $interesse_nome) {
            $select_sql = "SELECT ID FROM Interesses WHERE Nome = ?";
            $select_stmt = $conn->prepare($select_sql);
            $select_stmt->bind_param("s", $interesse_nome);
            $select_stmt->execute();
            $result = $select_stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $interesse_id = $row['ID'];
                $insert_sql = "INSERT INTO Gostos_User (user_id, interesse_id, valor) VALUES (?, ?, 1)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("ii", $user_id, $interesse_id);
                $insert_stmt->execute();
                $insert_stmt->close();
            }
            $select_stmt->close();
        }
    }
    
    $_SESSION['msg'] = "Preferências atualizadas com sucesso!";
    header("Location: feed.php");
    exit();
}
?>