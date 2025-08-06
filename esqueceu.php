<?php
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include 'mudanca.php';
    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);

    $codigoSTR = $_SESSION['codigo'];
    $email = $_SESSION['email'];

    
    $conexao = mysqli_connect('localhost', 'root', '', 'RSJNews');
        if (!$conexao) die("<p style='color:red;'>Erro na conexão: " . mysqli_connect_error() . "</p>");

        $stmt = mysqli_prepare($conexao, "SELECT nome FROM User WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $stmt1 = mysqli_prepare($conexao, "SELECT sobrenome FROM User WHERE email = ?");
        mysqli_stmt_bind_param($stmt1, "s", $email);
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

    try {
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Username = 'kauaryan29@gmail.com';
        $mail->Password = 'kpxa byoq tcqj acov';
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;

        $mail->setFrom('kauaryan29@gmail.com', 'RSJNews');
        $mail->addAddress('' . $email . '', '' . $nome_completo . '');

        $mail->isHTML(true);
        $mail->Subject = 'Nova senha';
        $mail->Body    = 'Olá, <b> ' . $nome_completo . ' </b><br> Há uma tentativa de mudança de senha da conta, caso não seja você, ignore o código e altere a senha <strong>imediatamente</strong>! <br>Caso seja você, o código é:<b> ' . $codigoSTR . '</b>';
        $mail->AltBody = 'Olá, <b> ' . $nome_completo . ' </b><br> Há uma tentativa de mudança de senha da conta, caso não seja você, ignore o código e altere a senha <strong>imediatamente</strong>! <br>Caso seja você, o código é:<b> ' . $codigoSTR . '</b>';

        $mail->send();
        echo 'A mensagem foi enviada com sucesso!';
        header("location: codigo.php");
        exit;
    } catch (Exception $e) {
        echo "Erro ao enviar: {$mail->ErrorInfo}";
    }
?>