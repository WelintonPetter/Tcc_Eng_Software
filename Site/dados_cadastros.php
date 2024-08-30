<?php
// PEGA DADOS CADASTRO
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha_usuario = $_POST['senha'];  // Renomeei a variável para evitar conflito
$data_atual = date('d/m/Y');
$hora_atual = date('H:i:s');

// configuração de credencial
$server = 'localhost';
$usuario = 'root';
$senha_banco = '';  // Renomeei a variável para evitar conflito
$banco = 'tcc_sisman';

// conexão com o banco
$conn = new mysqli($server, $usuario, $senha_banco, $banco);

if ($conn->connect_error) {
    die("Falha ao se comunicar com o banco de dados: " . $conn->connect_error);
}

// Corrigindo o SQL e falta de vírgula no prepare
$smtp = $conn->prepare("INSERT INTO mensagens (nome, email, senha, data, hora) VALUES (?, ?, ?, ?, ?)");
$smtp->bind_param("sssss", $nome, $email, $senha_usuario, $data_atual, $hora_atual);

if ($smtp->execute()) {
    echo "Mensagem enviada com sucesso";
} else {
    echo "Erro no envio da mensagem: " . $smtp->error;
}

$smtp->close();
$conn->close();
?>
