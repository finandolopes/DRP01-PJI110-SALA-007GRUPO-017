<?php
    include_once('../php/conexao.php'); 
    include_once('../php/funcoes_usuarios.php');
    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $usuario = buscarUsuarioPorId($conexao, $id);
        if(!$usuario) {
            header("Location: gerenciar_usuarios.php");
            exit();
        }
    } else {
        header("Location: gerenciar_usuarios.php");
        exit();
    }

    if(isset($_POST['editar_usuario'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $email = $_POST['email'];
        editarUsuario($conexao, $id, $nome, $usuario, $senha, $email);
        header("Location: gerenciar_usuarios.php");
        exit();
    }
    ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>Editar Usuário</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #fff;
            color: #333;
            padding: 20px;
        }

        label {
            margin-top: 10px;
            display: block;
            color: #333;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: #333;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            outline: none;
            border-color: #0078d4;
        }

        button {
            background-color: #0078d4;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #005a9e;
        }
    </style>
</head>
<body>
    <h1>Editar Usuário</h1>    

    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo $usuario['nome']; ?>" required><br>
        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" id="usuario" value="<?php echo $usuario['usuario']; ?>" required><br>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" value="<?php echo $usuario['senha']; ?>" required>
        <button type="button" onclick="togglePassword()">Exibir Senha</button><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $usuario['email']; ?>" required><br>
        <button type="submit" name="editar_usuario">Salvar</button>
    </form>

    <button type="button" class="btn btn-sm btn-success" onclick="window.location.href='admin.php'">Voltar</button>

    <script>
        function togglePassword() {
            var senhaInput = document.getElementById("senha");
            if (senhaInput.type === "password") {
                senhaInput.type = "text";
            } else {
                senhaInput.type = "password";
            }
        }
    </script>
</body>
</html>
