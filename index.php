<?php
session_start();
include_once('php/conexao.php');
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CONFINTER | Consolidando sonhos</title>
    <meta name="description" content="Consolidando sonhos">
    <meta name="keywords" content="edart,investment,investimento,consulting,consultoria,financial,financeira">
    <meta name="author" content="Gian Carlos Barros Honório">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="img/favicon.png" rel="icon">
    <link href="img/favicon.png" rel="apple-touch-icon">
    <link href="lib/fonts-googleapis/family-open-sans.min.css" rel="stylesheet">
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="lib/nivo-slider/css/nivo-slider.min.css" rel="stylesheet">
    <link href="lib/nivo-slider/css/nivo-slider-theme.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/owl.transitions.min.css" rel="stylesheet">
    <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/venobox/venobox.min.css" rel="stylesheet">
    <link href="css/responsive.min.css" rel="stylesheet">
    <link href="css/style.min.css" rel="stylesheet">
    <script>
        $(document).ready(function () {
            // Remover a máscara de data antes de enviar o formulário
            $('#form-requisicao').submit(function () {
                // Remover a máscara de data antes de enviar o formulário
                var dataNascimento = $('#data_nascimento').val();
                // Remover qualquer caractere que não seja número
                var dataLimpa = dataNascimento.replace(/\D/g, '');
                // Formatar a data para o padrão YYYY-MM-DD
                var dataFormatada = dataLimpa.replace(/(\d{2})(\d{2})(\d{4})/, '$3-$2-$1');
                // Atribuir a data formatada de volta ao campo
                $('#data_nascimento').val(dataFormatada);
            });
        });
    </script>


    <!-- Script JavaScript para validar o formulário -->
    <script>
        $(document).ready(function () {
            // Função para validar o formulário antes do envio
            $('#form-requisicao').submit(function (event) {
                // Verifica se o campo nome está vazio
                if ($('#nome').val().trim() === '') {
                    alert('Por favor, preencha o campo nome.');
                    event.preventDefault(); // Impede o envio do formulário
                    return;
                }

                // Verifica se o campo data de nascimento está vazio
                //  if ($('#data_nascimento').val().trim() === '') {
                //     alert('Por favor, preencha o campo data de nascimento.');
                //     event.preventDefault(); // Impede o envio do formulário
                //     return;
                //  }

                // Verifica se o campo telefone está vazio
                if ($('#telefone').val().trim() === '') {
                    alert('Por favor, preencha o campo telefone.');
                    event.preventDefault(); // Impede o envio do formulário
                    return;
                }

                // Verifica se o campo email está vazio
                if ($('#email').val().trim() === '') {
                    alert('Por favor, preencha o campo email.');
                    event.preventDefault(); // Impede o envio do formulário
                    return;
                }

                // Verifica se o campo horário de contato está vazio
                if ($('#horario_contato').val().trim() === '') {
                    alert('Por favor, preencha o campo horário de contato.');
                    event.preventDefault(); // Impede o envio do formulário
                    return;
                }

                // Verifica se pelo menos uma opção de categoria foi selecionada
                if ($('input[name="categoria[]"]:checked').length === 0) {
                    alert('Por favor, selecione pelo menos uma categoria.');
                    event.preventDefault(); // Impede o envio do formulário
                    return;
                }
            });
        });
    </script>
    <script>
        // Função para exibir o campo "Outros" quando a opção é selecionada
        document.addEventListener('DOMContentLoaded', function () {
            var outrosCheckbox = document.getElementById('outros_check');
            var outrosInfoDiv = document.getElementById('outros_info_div');

            outrosCheckbox.addEventListener('change', function () {
                if (outrosCheckbox.checked) {
                    outrosInfoDiv.style.display = 'block';
                } else {
                    outrosInfoDiv.style.display = 'none';
                }
            });

            // Verifica se pelo menos uma categoria foi selecionada antes de enviar o formulário
            var form = document.getElementById('form-requisicao');
            form.addEventListener('submit', function (event) {
                var checkboxes = document.querySelectorAll('input[name="categoria[]"]');
                var isChecked = false;
                checkboxes.forEach(function (checkbox) {
                    if (checkbox.checked) {
                        isChecked = true;
                    }
                });
                if (!isChecked) {
                    alert('Por favor, selecione pelo menos uma categoria.');
                    event.preventDefault(); // Impede o envio do formulário
                }
            });
        });
    </script>


    </script>
    <script>
        $(document).ready(function () {
            // Máscara para data (DD/MM/AAAA)
            //  $('#data_nascimento').mask('00/00/0000');

            // Máscara para hora (HH:MM)
            $('#horario_contato').mask('00:00');

            // Máscara para e-mail
            $('#email').mask('A', {
                translation: {
                    'A': { pattern: /[\w@\-.+]/, recursive: true }
                }
            });

            // Validação do formulário
            $('#modalForm').submit(function (event) {
                // Limpar mensagens de erro
                $('.error-msg').remove();

                // Flag para validação
                var isValid = true;

                // Validar nome
                var nome = $('#nome').val();
                if (!nome.trim()) {
                    $('#nome').after('<div class="error-msg">Por favor, preencha o nome.</div>');
                    isValid = false;
                }

                // Validar data de nascimento
                var dataNascimento = $('#data_nascimento').val();
                if (!dataNascimento.trim()) {
                    $('#data_nascimento').after('<div class="error-msg">Por favor, preencha a data de nascimento.</div>');
                    isValid = false;
                }

                // Validar telefone
                var telefone = $('#telefone').val();
                if (!telefone.trim()) {
                    $('#telefone').after('<div class="error-msg">Por favor, preencha o telefone.</div>');
                    isValid = false;
                }

                // Validar e-mail
                var email = $('#email').val();
                if (!email.trim()) {
                    $('#email').after('<div class="error-msg">Por favor, preencha o e-mail.</div>');
                    isValid = false;
                } else if (!isValidEmail(email)) {
                    $('#email').after('<div class="error-msg">Por favor, preencha um e-mail válido.</div>');
                    isValid = false;
                }

                // Validar horário de contato
                var horarioContato = $('#horario_contato').val();
                if (!horarioContato.trim()) {
                    $('#horario_contato').after('<div class="error-msg">Por favor, preencha o horário de contato.</div>');
                    isValid = false;
                }

                // Validar categoria
                var categoria = $('#categoria').val();
                if (!categoria.trim()) {
                    $('#categoria').after('<div class="error-msg">Por favor, selecione a categoria.</div>');
                    isValid = false;
                }

                // Se algum campo estiver inválido, impedir o envio do formulário
                if (!isValid) {
                    event.preventDefault();
                    $('#modalAlert').addClass('alert alert-danger').html('Por favor, corrija os campos destacados.');
                }
            });

            // Função para verificar se o e-mail é válido
            function isValidEmail(email) {
                var pattern = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
                return pattern.test(email);
            }
        });

    </script>
</head>
<body data-spy="scroll" data-target="#navbar-edart">
<div id="preloader"></div>
<header>
    <div id="sticker" class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <nav class="navbar navbar-default">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".bs-edart-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a id="navbar-logo" class="navbar-brand page-scroll sticky-logo br hidden-sm hidden-xs" href="#">
                                <img src="img/logo01-white.png" alt="logo" width="140px">
                            </a>
                            <a id="navbar-logo" class="navbar-brand page-scroll sticky-logo br visible-xs" href="#">
                                <img src="img/logo01-white.png" alt="logo" width="125px">
                            </a>
                        </div>
                        <div class="collapse navbar-collapse main-menu bs-edart-navbar-collapse-1" id="navbar-example">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a class="page-scroll" href="#about">
                                        <div class="br">Sobre</div>
                                    </a>
                                </li>
                                <li>
                                    <a class="page-scroll" href="#services">
                                        <div class="br">Serviços</div>
                                    </a>
                                </li>
                                <li>
                                    <a class="page-scroll" href="#requisicoes">
                                        <div class="br">Requisições</div>
                                    </a>
                                </li>
                                <li>
                                    <a class="page-scroll" href="#duvidas">
                                        <div class="br">Dúvidas</div>
                                    </a>
                                </li>
                                <li>
                                    <a class="page-scroll" href="#contact">
                                        <div class="br">Contato</div>
                                    </a>
                                </li>
                                <li>
                                    <a class="page-scroll" href="#contact">
                                        <div class="br">Depoimentos</div>
                                    </a>
                                </li>
                                <li>
                                    <a class="page-scroll" href="#" data-toggle="modal" data-target="#loginModal">
                                        <div class="br">Login</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Modal Login -->
<div id="loginModal" class="modal fade modal-login" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Login</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="processa_login.php" method="POST">
                            <div class="form-group">
                                <label for="user">Usuário:</label>
                                <input type="text" class="form-control" id="user" name="user">
                            </div>
                            <div class="form-group">
                                <label for="senha">Senha:</label>
                                <input type="password" class="form-control" id="senha" name="senha">
                            </div>
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <img src="img/logo01-black.png" alt="Imagem de Login" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="full-site">
    <div id="home" class="slider-area">
        <div class="bend niceties preview-2">
            <div id="ensign-nivoslider" class="slides">
                <img src="img/slider/slider1.jpg" alt="slider1" title="#slider-direction-1" />
                <img src="img/slider/slider2.jpg" alt="slider2" title="#slider-direction-2" />
                <img src="img/slider/slider3.jpg" alt="slider3" title="#slider-direction-3" />
                <img src="img/slider/slider4.jpg" alt="slider4" title="#slider-direction-4" />
                <img src="img/slider/slider5.jpg" alt="slider5" title="#slider-direction-5" />
            </div>
            <div id="slider-direction-1" class="slider-direction slider-one">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="slider-content">
                                <div class="layer-1-1 hidden-xs wow slideInDown" data-wow-duration="2s" data-wow-delay=".2s">
                                    <h2 class="title1"></h2>
                                </div>
                                <div class="layer-1-2 wow slideInUp" data-wow-duration="2s" data-wow-delay=".1s">
                                    <h1 class="title2"></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="slider-direction-2" class="slider-direction slider-two">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="slider-content text-center">
                                <div class="layer-1-2 wow slideInUp" data-wow-duration="2s" data-wow-delay=".1s">
                                    <h1 class="title2">
                                        <div class="br">Experiência no Mercado</div>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="slider-direction-3" class="slider-direction slider-two">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="slider-content">
                                <div class="layer-1-2 wow slideInUp" data-wow-duration="2s" data-wow-delay=".1s">
                                    <h1 class="title2">
                                        <div class="br">Transparência e Credibilidade</div>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="slider-direction-4" class="slider-direction slider-two">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="slider-content">
                                <div class="layer-1-2 wow slideInUp" data-wow-duration="2s" data-wow-delay=".1s">
                                    <h1 class="title2">
                                        <div class="br">Foco no Resultado</div>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="slider-direction-5" class="slider-direction slider-two">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="slider-content">
                                <div class="layer-1-2 wow slideInUp" data-wow-duration="2s" data-wow-delay=".1s">
                                    <h1 class="title2">
                                        <div class="br">Alcançar Objetivos</div>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="about" class="about-area area-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="section-headline text-center">
                        <h2 class="br">Sobre</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="well-middle">
                        <div class="single-well">
                            <span class="br minor-title-about"></span>
                            <h2 class="br">Nossos Valores</h2>
                            <h4 class="about-content">
                                <div class="br">
                                    Um novo projeto onde o conceito e a missão vão além do que se espera de uma consultoria, totalmente estruturada e pronta para sermos o futuro de nossos clientes.
                                </div>
                            </h4>
                            <h4 class="about-content">
                                <div class="br">
                                    Nossa palavra de ordem é o <strong>SUCESSO</strong>. Transparência e Honestidade são os nossos principais valores.
                                </div>
                            </h4>
                            <br /><br />
                            <div class="col-md-4 col-sm-4 col-xs-12 adjacent-item-about-details">
                                <h3 class="title-item-about-details">
                                    <div class="br">
                                        Missão
                                    </div>
                                </h3>
                                <h5 class="about-content">
                                    <div class="br">
                                        Facilitar o acesso a crédito consignado e fornecer consultoria financeira personalizada, visando o equilíbrio e bem-estar financeiro dos nossos clientes.
                                    </div>
                                </h5>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 middle-item-about-details">
                                <h3 class="title-item-about-details">
                                    <div class="br">
                                        Visão
                                    </div>
                                </h3>
                                <h5 class="about-content">
                                    <div class="br">
                                        Ser reconhecida como a empresa líder em crédito consignado e consultoria financeira, destacando-nos pela excelência no atendimento ao cliente e pela construção de relacionamentos sólidos e duradouros. Almejamos ser a referência no mercado, sendo conhecidos por nossa integridade, transparência e compromisso com a melhoria contínua.
                                    </div>
                                </h5>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 adjacent-item-about-details">
                                <h3 class="title-item-about-details">
                                    <div class="br">
                                        Valores
                                    </div>
                                </h3>
                                <h5 class="about-content">
                                    <div class="br">
                                        <strong>Transparência:</strong> Agimos com total transparência em nossas operações e informações, promovendo a confiança mútua.
                                        <strong>Comprometimento Personalizado:</strong> Nos dedicamos a entender as necessidades individuais de cada cliente, oferecendo soluções financeiras.
                                        <strong>Respeito e Empatia:</strong> Valorizamos a diversidade e tratamos todos com respeito e empatia, construindo relações duradouras.
                                        <strong>Sustentabilidade Financeira:</strong> Comprometemo-nos a promover práticas financeiras sustentáveis, visando o bem-estar financeiro a longo prazo de nossos clientes.
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="services" class="services-area area-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="section-headline services-head text-center">
                                <h2 class="br">Nossos serviços</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="services-contents">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="about-move">
                                    <div class="services-details">
                                        <div class="single-services">
                                            <div class="services-icon" href="#">
                                                <i class="fa fa-handshake-o" aria-hidden="true"></i>
                                            </div>
                                            <h3 class="br">Consultoria</h3>
                                            <h5 class="service-content">
                                                <div class="br">
                                                    Nossos especialistas ajudarão desde a abertura de contas até delinear a melhor estratégia para os diferentes mercados financeiros
                                                </div>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class=" about-move">
                                    <div class="services-details">
                                        <div class="single-services">
                                            <div class="services-icon" href="#">
                                                <i class="fa fa-line-chart" aria-hidden="true"></i>
                                            </div>
                                            <h3 class="br">Investimento</h3>
                                            <h5 class="service-content">
                                                <div class="br">
                                                    Estudamos o seu perfil e focamos nosso trabalho em resultados
                                                </div>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="about-move">
                                    <div class="services-details">
                                        <div class="single-services">
                                            <div class="services-icon" href="#">
                                                <i class="fa fa-money" aria-hidden="true"></i>
                                            </div>
                                            <h3 class="br">Trade</h3>
                                            <h5 class="service-content">
                                                <div class="br">
                                                    Operamos várias estratégias no mercado financeiro usando nossa experiência para alcançar seus objetivos
                                                </div>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="requisicoes" class="our-team-area area-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="section-headline text-center">
                                <h2 class="br">Requisição de Análise de Crédito</h2>
                            </div>
                        </div>
                    </div>
                    <!-- Formulário de Requisição de Análise de Crédito -->
                    <div class="formulario-modal" id="requisicaoForm">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="process.php" method="POST" id="form-requisicao">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Insira seu nome" required>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="data_nascimento">Data de Nascimento:</label>
                                                <input type="date" class="form-control" id="data_nascimento" placeholder="Data de Nascimento:" name="data_nascimento" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="data_nascimento">Telefone:</label>
                                                <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="Telefone" required maxlength="15">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="data_nascimento">E-mail:</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu E-mail" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="horario_contato">Horário para Contato:</label>
                                            <div class="input-group">
                                                <input type="time" class="form-control" id="horario_contato" name="horario_contato" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tipo" class="text-left">Tipo:</label>
                                            <textarea class="form-control" id="tipo" name="tipo" rows="3" maxlength="250"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Categoria:</label><br>
                                            <div class="form-row">
                                                <div class="form-check col-md-3">
                                                    <input class="form-check-input" type="checkbox" id="aposentado" name="categoria[]" value="Aposentado">
                                                    <label class="form-check-label" for="aposentado">Aposentado</label>
                                                </div>
                                                <div class="form-check col-md-3">
                                                    <input class="form-check-input" type="checkbox" id="pensionista" name="categoria[]" value="Pensionista">
                                                    <label class="form-check-label" for="pensionista">Pensionista</label>
                                                </div>
                                                <div class="form-check col-md-3">
                                                    <input class="form-check-input" type="checkbox" id="servidor_publico" name="categoria[]" value="Servidor Público">
                                                    <label class="form-check-label" for="servidor_publico">Servidor Público</label>
                                                </div>
                                                <div class="form-check col-md-3">
                                                    <input class="form-check-input" type="checkbox" id="outros_check" name="categoria[]" value="Outros">
                                                    <label class="form-check-label" for="outros_check">Outros</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="outros_info_div" style="display: none;">
                                            <label for="outros_info">Insira outras informações se necessário:</label>
                                            <input type="text" class="form-control" id="outros_info" name="outros_info" rows="3" maxlength="200">
                                        </div>
                                        <div class="row justify-content-end">
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-primary">Enviar Requisição</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {
                            // Máscara para telefone (fixo ou celular)
                            $('#telefone').mask('(00) 00000-0000');
                        });
                    </script>



                    <script>
                        // Desabilitar outras opções de categoria quando "Outros" é selecionado
                        document.addEventListener('DOMContentLoaded', function () {
                            var outrosCheckbox = document.getElementById('outros_check');
                            var outrasOpcoes = document.querySelectorAll('input[name="categoria"]:not(#outros_check)');

                            outrosCheckbox.addEventListener('change', function () {
                                if (outrosCheckbox.checked) {
                                    outrasOpcoes.forEach(function (opcao) {
                                        opcao.disabled = true;
                                    });
                                    document.getElementById('outros_info_div').style.display = 'block';
                                } else {
                                    outrasOpcoes.forEach(function (opcao) {
                                        opcao.disabled = false;
                                    });
                                    document.getElementById('outros_info_div').style.display = 'none';
                                }
                            });
                        });
                    </script>


                    <style>
                        /* Estilo para tornar o modal responsivo */
                        .formulario-modal .modal-dialog {
                            width: auto; /* Define a largura do modal em relação à largura da tela */
                            max-width: 60%; /* Define uma largura máxima para o modal */
                            height: auto; /* Define a altura do modal em relação à altura da tela */
                            max-height: 60%; /* Define uma altura máxima para o modal */
                        }

                        /* Estilo para centralizar o conteúdo dentro do modal */
                        .formulario-modal .modal-content {
                            height: auto;
                        }

                        .formulario-modal .modal-body {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: auto;
                        }
                    </style>
                    <div id="duvidas" class="faq-area area-padding">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="section-headline text-center">
                                        <h2 class="br">Dúvidas frequentes</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="faq-details">
                                        <div class="panel-group" id="accordion">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="check-title">
                                                        <a data-toggle="collapse" class="active" data-parent="#accordion" href="#check1">
                                                            <span class="acc-icons"></span>
                                                            <h3 class="br">Em que área financeira a empresa opera?</h3>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="check1" class="panel-collapse collapse in">
                                                    <div class="panel-body">
                                                        <h5 class="br">
                                                            Operamos com credito Consignado.
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="check-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#check2">
                                                            <span class="acc-icons"></span>
                                                            <h3 class="br">Porquê escolher a CONFINDER como parceira?</h3>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="check2" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <h5 class="br">

                                                            Possuímos ampla experiência no mercado.
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="check-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#check3">
                                                            <span class="acc-icons"></span>
                                                            <h3 class="br">Como fazemos sua análise de Crédito?</h3>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="check3" class="panel-collapse collapse ">
                                                    <div class="panel-body">
                                                        <h5 class="br">
                                                            Com estratégias diversificadas buscamos sempre as melhores opções para nossos clientes
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>

                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="contact" class="contact-area">
            <div class="contact-inner area-padding">
                <div class="contact-overly"></div>
                <div class="container ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="section-headline text-center">
                                <h2 class="br">Entre<spam class="section-headline-lowercase">&nbsp;em&nbsp;</spam>contato conosco</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <h2 class="br">Faça uma simulação de crédito conosco</h2>
                        <br />
                        <h4 class="about-content">
                            <div class="br">
                                O primeiro passo é deixar seus dados abaixo
                            </div>
                        </h4>
                        <br />
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.674620432733!2d-46.34657878502169!3d-23.529135784679013!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce43de0d92a6f5%3A0x8f85eeb0c19e3c32!2sMarina%20La%20Regina!5e0!3m2!1sen!2sus!4v1648523258379!5m2!1sen!2sus" width="100%" height="380" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form contact-form">
                                <div id="sendmessage">
                                    <div class="br">Sua mensagem foi enviada. Obrigado!</div>
                                </div>
                                <div id="errormessage"></div>
                                <form action="" method="post" role="form" class="contactForm">
                                    <div class="form-group">
                                        <input type="text" name="name" class="br form-control" id="name_br" placeholder="Nome completo" data-rule="minlen:4" data-msg="Digite pelo menos 4 caracteres" />
                                        <div class="br validation"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="br form-control" name="email" id="email_br" placeholder="E-mail" data-rule="email" data-msg="Por favor digite um e-mail válido" />
                                        <div class="br validation"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="br form-control" name="phone" id="phone_br" placeholder="Celular/Whatsapp" data-rule="regexp:[0-9]{8,}" data-msg="Por favor digite um número de celular válido" />
                                        <div class="br validation"></div>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="br form-control" name="message" name="message_br" rows="5" data-rule="required" data-msg="Por favor escreva algo para nós" placeholder="Mensagem"></textarea>										<div class="br validation"></div>

                                        <div class="en validation"></div>
                                    </div>
                                    <div class="form-group">
                                        <h5>
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                            <strong class="br">Seus dados estão protegidos conosco</strong>
                                        </h5>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit">
                                            <div class="br">Enviar Dados</div>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <br /><br />
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="contact-icon text-center">
                                <div class="single-icon">
                                    <i class="fa fa-envelope-o"></i>
                                    <h5>
                                        E-mail: <a href="mailto:contato@confinter.com.br">contato@confinter.com.br</a><br>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="contact-icon text-center">
                                <div class="single-icon">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                    <h5 class="number-sequence">
                                        (11) 94801-6298
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="contact-icon text-center">
                                <div class="single-icon">
                                    <i class="fa fa-map-marker"></i>
                                    <h6 class="br">
                                        Marina La Regina nº203</spam><br />Centro<br />Poá  - SP<br />CEP:&nbsp;<spam class="number-sequence">08550-210</spam>&nbsp;&nbsp;&nbsp;
                                    </h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer>
                <div class="footer-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="footer-content">
                                    <div class="footer-head">
                                        <div class="footer-logo">
                                            <img src="img/logo01-black.png" alt="logo" width="125px">
                                        </div>
                                        <h4 class="br">CONFINTER Consultoria Financeira<br /><spam class="number-sequence">CNPJ: 11.727.809.0001/36</spam></h4>
                                        <h5 class="br">Especialista em corretagem, consultoria, intermediação<br />e mediação de negócios financeiros.</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="footer-content">
                                    <div>
                                        <br /><br />
                                        <h4 class="footer-title-icons">
                                            <div class="br">Siga-nos em nossas redes sociais</div>

                                        </h4>
                                        <div class="footer-icons">
                                            <ul>
                                                <li>
                                                    <a href="https://www.instagram.com/confintersp?igsh=a3NuaGJrem5pYzZu" target="_blank"><i class="fa fa-instagram"></i></a>
                                                    <a href="https://api.whatsapp.com/send?phone=11948016298" target="_blank"><i class="fa fa-whatsapp"></i></a>
                                                </li>
                                                <style>
                                                    /* Estilizando os ícones das redes sociais */
                                                    .fa-instagram {
                                                        color: #e4405f; /* Cor do Instagram */
                                                        font-size: 130%; /* Aumenta o tamanho em 30% */
                                                    }

                                                    .fa-whatsapp {
                                                        color: #25d366; /* Cor do WhatsApp */
                                                        font-size: 130%; /* Aumenta o tamanho em 30% */
                                                    }
                                                </style>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="footer-area-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- Div para Envio de Depoimentos -->
                        <div class="col-md-6 col-sm-6 col-xs-12 text-center">
                            <h2>Enviar Depoimento</h2>
                            <div class="d-inline-block mx-auto" style="max-width: 500px; border: 1px solid #ccc; padding: 20px; border-radius: 10px;">
                                <form action="php/enviar_depoimento.php" method="POST">
                                    <div class="form-group">
                                        <input type="text" name="nome" class="br form-control" id="nome" placeholder="Insirir nome,em branco enviará como Anônimo" data-rule="minlen:4" data-msg="" />
                                        <div class="br validation"></div>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="br form-control" name="mensagem" name="mensagem" rows="5" data-rule="required" data-msg="Por favor escreva algo para nós" placeholder="Mensagem"></textarea>										<div class="br validation"></div>

                                        <div class="en validation"></div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Enviar Depoimento</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Div para Depoimentos Aprovados -->
        <div class="col-12 mt-5 bg-success pb-2">

            <hr>
            <?php
            // Consultar os depoimentos aprovados no banco de dados
            $sql = "SELECT nome, mensagem FROM depoimentos WHERE status_mod = 'aprovado'";
            $result = mysqli_query($conexao, $sql);

            // Verificar se há depoimentos aprovados
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $nome = $row['nome'] ? $row['nome'] : "Anônimo";
                    $mensagem = $row['mensagem'];
                    ?>
                    <blockquote class="blockquote text-center text-light">
                        <p class="mb-0"><em>"<?php echo $mensagem; ?>"</em></p>
                        <footer class="blockquote-footer text-white"><?php echo $nome; ?>
                    </blockquote>
                    <?php
                }
            } else {
                echo "<p class='text-center text-white'>Nenhum depoimento aprovado disponível.</p>";
            }
            ?>
        </div>
    </div>
</div>
</div>
</div>
<div class="footer-area-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="copyright text-center">
                    <p class="br">&copy; Copyright 2024 CONFINTER. Todos Direitos Reservados.</p>
                </div>
                <div class="credits">
                    <div class="br">Desenvolvido por <a href="https://github.com/finandolopes/">Fernando A. L. da Silva</a> com <a href="https://bootstrapmade.com/">BootstrapMade</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
</footer>
<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
</div>
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/venobox/venobox.min.js"></script>
<script src="lib/knob/jquery.knob.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/parallax/parallax.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/nivo-slider/js/jquery.nivo.slider.min.js" type="text/javascript"></script>
<script src="lib/appear/jquery.appear.min.js"></script>
<script src="lib/isotope/isotope.pkgd.min.js"></script>
<script src="js/main.min.js"></script>
<script src="js/contactform.min.js"></script>
<script src="js/language.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>