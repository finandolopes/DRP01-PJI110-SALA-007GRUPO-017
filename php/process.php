<?php
// Conectar ao banco de dados (substitua os valores conforme necessário)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "confinter";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

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

    // Fechar a declaração para inserir os dados na tabela clientes
    $stmtClientes->close();
} else {
    echo "Erro na preparação da declaração para inserir os dados na tabela clientes: " . $conn->error;
    exit(); // Sai do script se houver erro
}

// Definir a consulta SQL para inserir os dados na tabela requisicoes
$sqlRequisicoes = "INSERT INTO requisicoes (id_cliente, horario_contato, tipo, categoria, outros_info) VALUES (?, ?, ?, ?, ?)";

// Preparar e executar a declaração para inserir os dados na tabela requisicoes
if ($stmtRequisicoes = $conn->prepare($sqlRequisicoes)) {
    $stmtRequisicoes->bind_param("issss", $id_cliente, $horario_contato, $tipo, $categoria, $outros_info);

    // Atribuir os valores recebidos do formulário às variáveis para a tabela requisicoes
    $id_cliente = $conn->insert_id; // Obtém o ID do cliente inserido anteriormente
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

// Fechar a conexão
$conn->close();

// Redirecionar de volta ao index.php
echo "<script>alert('Requisição enviada com sucesso!'); window.location.href = 'index.php';</script>";
exit();
?>
