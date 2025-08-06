<?php

$nome = '';
$sobrenome = '';
    $conexao = mysqli_connect('localhost', 'root', '', 'RSJNews');
        if (!$conexao) die("<p style='color:red;'>Erro na conexão: " . mysqli_connect_error() . "</p>");

        $stmt = mysqli_prepare($conexao, "SELECT nome FROM User WHERE email = ?");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $stmt1 = mysqli_prepare($conexao, "SELECT sobrenome FROM User WHERE email = ?");
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);

        if($result) {
            if($result1) {
                while($row = mysqli_fetch_assoc($result)){
                    while($row1 = mysqli_fetch_assoc($result1)){
                        $nome_completo = $row['nome']. ' ' . $row1 ['sobrenome'];
                    }
                }
            }
        }
?>