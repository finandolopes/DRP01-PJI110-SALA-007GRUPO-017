<?php
    // Incluir o arquivo de conexão e as funções de manipulação de usuários
    include('../php/conexao.php');
    include('../php/funcoes_usuarios.php');


    // Verificar se o formulário de criação de usuário foi enviado
    if(isset($_POST['criar_usuario'])) {
        // Processar os dados do formulário e criar um novo usuário
        $nome = $_POST['nome'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $email = $_POST['email'];
        
        criarUsuario($conexao, $nome, $usuario, $senha, $email);
    }

    // Verificar se o formulário de edição de usuário foi enviado
    if(isset($_POST['editar_usuario'])) {
        // Processar os dados do formulário e atualizar o usuário
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $email = $_POST['email'];
        
        editarUsuario($conexao, $id, $nome, $usuario, $senha, $email);
    }

    // Verificar se há uma solicitação para excluir um usuário
    if(isset($_GET['excluir_id'])) {
        $id = $_GET['excluir_id'];
        excluirUsuario($conexao, $id);
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-core/11.0.0/css/fabric.min.css">
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-core/11.0.0/css/fabric.components.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Adicionando Font Awesome -->
    <title>Gerenciar Usuários</title>
    <style>
        body {
            background-color: #fff; /* Cor de fundo */
            color: #333; /* Cor do texto */
            padding: 20px; /* Espaçamento interno */
            font-family: "Segoe UI", Arial, sans-serif; /* Fonte */
        }

        h1 {
            color: #333; /* Cor do texto do cabeçalho */
            margin-bottom: 20px; /* Espaçamento abaixo */
        }

        h2 {
            color: #333; /* Cor do texto do cabeçalho */
            margin-top: 20px; /* Espaçamento acima */
        }

        label {
            font-weight: bold; /* Texto em negrito */
            margin-right: 10px; /* Espaçamento à direita */
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: calc(100% - 40px); /* Largura total menos 40px */
            padding: 8px; /* Espaçamento interno */
            margin-bottom: 10px; /* Espaçamento abaixo */
            border: 1px solid #ccc; /* Borda */
            border-radius: 4px; /* Bordas arredondadas */
        }

        .input-icon {
            position: relative;
        }

        .input-icon input[type="password"] {
            padding-right: 30px; /* Espaço para o ícone */
        }

        .input-icon i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        input[type="submit"],
        button {
            background-color: #0078d4; /* Cor de fundo */
            color: #fff; /* Cor do texto */
            padding: 10px 20px; /* Espaçamento interno */
            border: none; /* Remover borda */
            cursor: pointer; /* Cursor de ponteiro */
            border-radius: 4px; /* Bordas arredondadas */
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #005a9e; /* Cor de fundo ao passar o mouse */
        }

        table {
            width: 100%; /* Largura total */
            border-collapse: collapse; /* Colapso de bordas */
            margin-top: 20px; /* Espaçamento acima */
        }

        th, td {
            padding: 8px; /* Espaçamento interno */
            text-align: left; /* Alinhamento à esquerda */
            border-bottom: 1px solid #ccc; /* Borda inferior */
        }

        th {
            background-color: #f4f4f4; /* Cor de fundo do cabeçalho */
            font-weight: bold; /* Texto em negrito */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* Cor de fundo das linhas pares */
        }

        tr:hover {
            background-color: #f2f2f2; /* Cor de fundo ao passar o mouse */
        }
    </style>
</head>
<body>
    <h1>Gerenciar Usuários</h1>

    <!-- Formulário para criar um novo usuário -->
    <h2>Criar Novo Usuário</h2>
    <form action="" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>
        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" id="usuario" required>
        <label for="senha">Senha:</label>
        <div class="input-icon">
            <input type="password" name="senha" id="senha" required>
            <i class="fas fa-eye" onclick="togglePassword('senha')"></i> <!-- Ícone para exibir a senha -->
        </div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <input type="submit" name="criar_usuario" value="Criar Usuário">
    </form>

    <!-- Tabela para listar os usuários -->
    <h2>Listar Usuários</h2>
    <table>
        <tr>
            <th>Nome</th>
            <th>Usuário</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php
            // Consultar e exibir a lista de usuários
            $usuarios = listarUsuarios($conexao);
            foreach($usuarios as $usuario) {
                echo "<tr>";
                echo "<td>" . $usuario['nome'] . "</td>";
                echo "<td>" . $usuario['usuario'] . "</td>";
                echo "<td>" . $usuario['email'] . "</td>";
                echo "<td>
                        <button class='ms-Button ms-Button--primary' onclick=\"window.location.href ='editar_usuario.php?id=" . $usuario['id'] . "'\">Editar</button>
                        <button class='ms-Button ms-Button--primary' onclick=\"if(confirm('Tem certeza que deseja excluir este usuário?')) window.location.href='gerenciar_usuarios.php?excluir_id=" . $usuario['id'] . "'\">Excluir</button>
                      </td>";
                echo "</tr>";
            }
        ?>
    </table>
    
    <button type="button" class="ms-Button ms-Button--primary" onclick="window.location.href='admin.php'">Voltar</button>

    <script>
        function togglePassword(inputId) {
            var input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
</html>
