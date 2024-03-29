<?php
session_start();
include_once('php/conexao.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - CONFINTER</title>
    <script src="../script/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../script/bootstrap.js"></script>
</head>
<body>

    <div class="container">
        <div class="album py-5 bg-light">
            <h2>Bem vindo ao painel de administrador</h2>
            <div class="container">
                <div class="row">
                    <!-- Seção de funcionalidades -->
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <p class="card-text">Consultar Requisições realizadas no Site</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="consultar_requisicoes.php"><button type="button" class="btn btn-sm btn-success btn-outline-success text-light">Clique aqui!</button></a>
                                    </div>
                                    <small class="text-muted">1</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Seção de funcionalidades -->
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <p class="card-text">Listar Clientes</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="listar_clientes.php"><button type="button" class="btn btn-sm btn-success btn-outline-success text-light">Clique aqui!</button></a>
                                    </div>
                                    <small class="text-muted">1</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Seção de funcionalidades -->
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <p class="card-text">Gerenciar Usuários</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="gerenciar_usuarios.php"><button type="button" class="btn btn-sm btn-success btn-outline-success text-light">Clique aqui!</button></a>
                                    </div>
                                    <small class="text-muted">1</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Seção de funcionalidades -->
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <p class="card-text">Alterar imagens do Carrossel</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="upload_imagens.php"><button type="button" class="btn btn-sm btn-success btn-outline-success text-light">Clique aqui!</button></a>
                                    </div>
                                    <small class="text-muted">1</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Seção de funcionalidades -->
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <p class="card-text">Moderar Depoimentos</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="admin_depoimentos.php"><button type="button" class="btn btn-sm btn-success btn-outline-success text-light">Clique aqui!</button></a>
                                    </div>
                                    <small class="text-muted">1</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Seção de funcionalidades -->
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <p class="card-text">Gerenciar Informações da Empresa</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button onclick="openModal()" class="btn btn-sm btn-success btn-outline-success text-light">Editar Empresa</button>
                                    </div>
                                    <small class="text-muted">1</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal de Edição -->
<div id="modal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Editar Empresa</h2>
        <form id="editForm" action="edit.php" method="POST">
            <label for="tel">Telefone:</label>
            <input type="text" id="tel" name="tel">
            <label for="celular">Celular:</label>
            <input type="text" id="celular" name="celular">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao"></textarea>
            <h3>Endereço</h3>
            <label for="logradouro">Logradouro:</label>
            <input type="text" id="logradouro" name="logradouro">
            <label for="numero">Número:</label>
            <input type="text" id="numero" name="numero">
            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro">
            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade">
            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado">
            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep">
            <input type="submit" value="Salvar">
        </form>
        <!-- Botão Voltar -->
        <button onclick="closeModal()" class="btn-voltar">Voltar</button>
    </div>
</div>

<!-- Script para abrir e fechar o modal -->
<script>
    function openModal() {
        document.getElementById('modal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('modal').style.display = 'none';
    }
</script>

<style>
    /* Estilo para o modal */
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1; 
        padding-top: 100px; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
    }

    /* Estilo para o conteúdo do modal */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%; /* Defina a largura desejada para o modal */
        border-radius: 10px;
    }

    /* Estilo para o botão Voltar */
    .btn-voltar {
        background-color: #f44336;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
        transition: background-color 0.3s;
    }

    .btn-voltar:hover {
        background-color: #d32f2f;
    }
</style>


    <!-- Botão de Sair -->
    <div class="fixed-bottom mb-3 mr-3">
        <a href="index.php" class="btn btn-danger">Sair</a>
    </div>
</body>
</html>
