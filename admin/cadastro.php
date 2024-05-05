<?php 
    include_once('../php/verifica_login.php');
    include_once('../php/conexao.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../script/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../script/bootstrap.js"></script>
    <title>Cadastrar Usuário</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
        }
        h1 {
            color: #323130;
            font-size: 24px;
            margin-top: 30px;
        }
        label {
            color: #323130;
        }
        .btn-primary {
            background-color: #0078d4;
            border-color: #0078d4;
            color: #fff;
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #005a9e;
            border-color: #005a9e;
        }
        .btn-secondary {
            background-color: #ffffff;
            border-color: #0078d4;
            color: #0078d4;
            font-size: 16px;
        }
        .btn-secondary:hover {
            background-color: #eaeaea;
            border-color: #0078d4;
            color: #0078d4;
        }
        .table {
            background-color: #ffffff;
            margin-top: 30px;
        }
        .table th, .table td {
            border-color: #d4d4d4;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Cadastrar Usuário</h1>
        <form action="processa_cadastro.php" method="POST">
            <div class="mb-3">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="usuario">Usuário</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="mb-3">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="mb-3">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <a href="admin.php" class="btn btn-secondary">Cancelar</a>
        </form>

        <!-- Listagem de usuários cadastrados -->
        <h1 class="mt-5">Usuários Cadastrados</h1>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Usuário</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop para exibir os usuários -->
                <?php while($row = mysqli_fetch_assoc($result_usuarios)) { ?>
                    <tr>
                        <!-- Nome do usuário -->
                        <td><?php echo $row['nome']; ?></td>
                        <!-- Nome de usuário -->
                        <td><?php echo $row['usuario']; ?></td>
                        <!-- E-mail do usuário -->
                        <td><?php echo $row['email']; ?></td>
                        <!-- Botões de ação -->
                        <td>
                            <!-- Botão para editar -->
                            <a href='editar.php?id=<?php echo $row['id']; ?>' class='btn btn-primary'>Editar</a>
                            <!-- Botão para excluir com alerta de confirmação -->
                            <button type="button" class="btn btn-danger" onclick="confirmarExclusao(<?php echo $row['id']; ?>)">Excluir</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Botão para voltar -->
        <a href="admin.php" class="btn btn-secondary mt-3">Voltar</a>
    </div>

    <!-- Script para confirmar exclusão -->
    <script>
        function confirmarExclusao(id) {
            // Exibe o alerta de confirmação
            var confirmacao = confirm("Você realmente deseja excluir este usuário?");
            // Se confirmar, redireciona para a página de exclusão
            if (confirmacao) {
                window.location.href = "excluir.php?id=" + id;
            }
        }
    </script>
</body>
</html>
