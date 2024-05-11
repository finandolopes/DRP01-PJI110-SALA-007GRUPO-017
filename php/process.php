<?php
// Incluir o arquivo de conexão e as funções de manipulação de clientes
include_once('conexao.php');

// Preparar a declaração SQL para inserir os dados na tabela clientes
$sqlClientes = "INSERT INTO clientes (nome, data_nascimento, email, telefone) VALUES (?, ?, ?, ?)";

// Preparar e executar a declaração para inserir os dados na tabela clientes
if ($stmtClientes = $conn->prepare($sqlClientes)) {
    $stmtClientes->bind_param("ssss", $nome, $data_nascimento, $email, $telefone);

    // Atribuir os valores recebidos do formulário às variáveis para a tabela clientes
    $nome = $_POST['nome'];
    // Convertendo a data de nascimento do formato brasileiro para o formato MySQL
    $data_nascimento = date('Y-m-d', strtotime($_POST['data_nascimento']));
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Executar a declaração para inserir os dados na tabela clientes
    if (!$stmtClientes->execute()) {
        echo "Erro ao executar a declaração para inserir os dados na tabela clientes: " . $stmtClientes->error;
        exit(); // Sai do script se houver erro
    }

    // Obtém o ID do cliente inserido
    $id_cliente = $stmtClientes->insert_id;

    // Fechar a declaração para inserir os dados na tabela clientes
    $stmtClientes->close();
} else {
    echo "Erro na preparação da declaração para inserir os dados na tabela clientes: " . $conn->error;
    exit(); // Sai do script se houver erro
}

// Preparar a declaração SQL para inserir os dados na tabela requisicoes
$sqlRequisicoes = "INSERT INTO requisicoes (id_cliente, horario_contato, tipo, categoria, outros_info, data_requisicao) VALUES (?, ?, ?, ?, ?, NOW())";

// Preparar e executar a declaração para inserir os dados na tabela requisicoes
if ($stmtRequisicoes = $conn->prepare($sqlRequisicoes)) {
   $stmtRequisicoes->bind_param("issss", $id_cliente, $horario_contato, $tipo, $categoria, $outros_info);


    // Atribuir os valores recebidos do formulário às variáveis para a tabela requisicoes
    $horario_contato = $_POST['horario_contato'];
    $tipo = $_POST['tipo'];

    // Definir categoria
    if (isset($_POST['categoria'])) {
        if (in_array('Outros', $_POST['categoria'])) {
            $categoria = 'Outros';
        } else {
            $categoria = implode(', ', $_POST['categoria']);
        }
    } else {
        $categoria = '';
    }

    // Definir outros_info
    $outros_info = isset($_POST['outros_info']) ? $_POST['outros_info'] : '';

    // Executar a declaração para inserir os dados na tabela requisicoes
    if (!$stmtRequisicoes->execute()) {
        echo "Erro ao executar a declaração para inserir os dados na tabela requisicoes: " . $stmtRequisicoes->error;
        exit(); // Sai do script se houver erro
    }

    // Fechar a declaração para inserir os dados na tabela requisicoes
    $stmtRequisicoes->close();
} else {
    echo "Erro na preparação da declaração para inserir os dados na tabela requisicoes: " . $conn->error;
    exit(); // Sai do script se houver erro
}
// Importe a biblioteca PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Adicione os arquivos da biblioteca PHPMailer
require 'php/PHPMailer/src/Exception.php';
require 'php/PHPMailer/src/PHPMailer.php';
require 'php/PHPMailer/src/SMTP.php';


// Configuração do servidor SMTP
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.example.com';
$mail->SMTPAuth = true;
$mail->Username = 'contato@confinter.com.br';
$mail->Password = 'sua_senha';
$mail->Port = 587; // Porta SMTP
$mail->SMTPSecure = 'tls'; // ou 'ssl' se necessário

// Configurações do e-mail
$mail->setFrom('contato@confinter.com.br', 'CONFINTER');
$mail->addAddress($_POST['email']); // Endereço de e-mail do destinatário
$mail->Subject = 'Cópia do Formulário de Requisição';
$mail->isHTML(true); // Habilita o formato HTML para o corpo do e-mail

// Corpo do e-mail
$mailBody = "
    <h1>Cópia do Formulário de Requisição</h1>
    <p><strong>Nome:</strong> {$_POST['nome']}</p>
    <p><strong>Data de Nascimento:</strong> {$_POST['data_nascimento']}</p>
    <p><strong>Telefone:</strong> {$_POST['telefone']}</p>
    <p><strong>E-mail:</strong> {$_POST['email']}</p>
    <p><strong>Horário para Contato:</strong> {$_POST['horario_contato']}</p>
    <p><strong>Tipo:</strong> {$_POST['tipo']}</p>
    <p><strong>Categoria:</strong> {$_POST['categoria']}</p>
    <p><strong>Outras Informações:</strong> {$_POST['outros_info']}</p>
";

$mail->Body = $mailBody;

// Envia o e-mail
if(!$mail->send()) {
    echo 'Erro ao enviar e-mail: ' . $mail->ErrorInfo;
} else {
    echo 'E-mail enviado com sucesso!';
}


// Fechar a conexão
$conn->close();

// Redirecionar de volta ao index.php
echo "<script>alert('Requisição enviada com sucesso!'); window.location.href = '../index.php';</script>";
exit();
?>
