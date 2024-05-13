<?php
session_start();
include_once('php/conexao.php');

// Verificar se o formulário de login foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once('php/processa_login.php');
}
// Consulta ao banco de dados para recuperar as imagens do carrossel
$sql = "SELECT * FROM imagens_carrossel";
$result = mysqli_query($conexao, $sql);


// Verificar se a variável de sessão sucesso_depoimento está definida
if (isset($_SESSION['sucesso_depoimento']) && $_SESSION['sucesso_depoimento']) {
    // Exibir a mensagem de sucesso
    echo "<p class='text-success'>Depoimento enviado com sucesso!</p>";
    // Remover a variável de sessão para que a mensagem não seja exibida novamente após o próximo carregamento da página
    unset($_SESSION['sucesso_depoimento']);
}

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">   
    <title>CONFINTER | Consolidando sonhos</title>
    <meta name="description" content="Consolidando sonhos">    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/favicon.png" rel="apple-touch-icon">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
   
    
    <style>
        /* Estilos personalizados */
        .testimonial-item {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
        }

        .testimonial-img {
            max-width: 150px;
            margin-bottom: 15px;
        }

        .testimonial-name {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .testimonial-message {
            font-size: 16px;
        }
    </style>

   
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

            $(document).ready(function () {
                // Máscara para telefone
                $('#telefone').mask('(00) 00000-0000');
            });

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


    <style>
        .floating-buttons {
            position: fixed;
            top: 50%;
            left: 0; /* Ajuste para centralizar os botões na lateral esquerda */
            transform: translateY(-50%);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            width: 50px; /* Definindo a largura dos botões */
            border-radius: 50%; /* Tornando o container redondo */
        }

            .floating-buttons a {
                display: flex; /* Usando flex para alinhar ícone verticalmente */
                justify-content: center; /* Alinhando ícone horizontalmente */
                align-items: center; /* Alinhando ícone verticalmente */
                margin-bottom: 10px;
                width: 40px; /* Definindo a largura dos botões */
                height: 40px; /* Definindo a altura dos botões */
                background-color: rgba(0, 0, 0, 0.5); /* Adicionando um fundo semi-transparente */
                border-radius: 50%; /* Tornando o botão redondo */
                text-decoration: none;
                transition: background 0.3s ease;
            }

        /* Estilo dos botões flutuantes */
        .floating-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }

        /* Estilo do ícone do WhatsApp */
        .whatsapp i {
            color: #25D366; /* Cor verde do logo do WhatsApp */
        }

        /* Estilo do ícone do Email */
        .email i {
            color: #4285F4; /* Cor vermelha do logo do Gmail, por exemplo */
        }

        /* Estilo do ícone do Instagram */
        .instagram i {
            color: #D44638; /* Cor vermelha do logo do Instagram, por exemplo */
        }


        .floating-buttons a {
            display: block;
            margin-bottom: 10px;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            background-color: #fff; /* Fundo branco para todos os ícones */
            border-radius: 50%;
            text-decoration: none;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2); /* Sombra para destacar os ícones */
        }

            .floating-buttons a:hover {
                opacity: 0.8; /* Efeito ao passar o mouse */
            }
        /* Aumentando o tamanho dos ícones */
        .whatsapp i,
        .instagram i,
        .email i {
            font-size: 30px; /* Ajuste o tamanho dos ícones conforme necessário */
            line-height: 40px; /* Alinhamento vertical dos ícones */
        }
    </style>
    <style>
        /* Estilo dos ícones das redes sociais */
        .footer-icons a i {
            font-size: 45px; /* Ajuste o tamanho do ícone */
            margin-right: 10px; /* Adiciona um espaçamento entre os ícones */
        }

        .footer-icons a .fab.fa-instagram {
            color: #e4405f; /* Cor do Instagram */
        }

        .footer-icons a .fab.fa-whatsapp {
            color: #25d366; /* Cor do WhatsApp */
        }

        /* Remover estilo padrão dos links */
        .footer-icons a {
            text-decoration: none; /* Remove sublinhado */
        }

        .panel-collapse {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

            .panel-collapse.in {
                max-height: 1000px; /* Defina um valor adequado para a altura máxima */
            }
    </style>
</head>
<div class="floating-buttons">
    <a href="https://www.instagram.com/confintersp?igsh=a3NuaGJrem5pYzZu" target="_blank" class="instagram"><i class="fab fa-instagram"></i></a>
    <a href="https://api.whatsapp.com/send?phone=11948016298" target="_blank" class="whatsapp"><i class="fab fa-whatsapp"></i></a>
    <a href="mailto:contato@confinter.com.br" class="email"><i class="far fa-envelope"></i></a>
</div>

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
                                    <img src="assets/img/logo01-white.png" alt="logo" width="80px">
                                </a>
                                <a id="navbar-logo" class="navbar-brand page-scroll sticky-logo br visible-xs" href="#">
                                    <img src="assets/img/logo01-white.png" alt="logo" width="80px">
                                </a>
                            </div>
                            <div class="collapse navbar-collapse main-menu bs-edart-navbar-collapse-1" id="navbar-example">
                                <ul class="nav navbar-nav navbar-right">
                                    <li>
                                        <a class="page-scroll" href="#sobre">
                                            <div class="br">Sobre</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="page-scroll" href="#valores">
                                            <div class="br">Nossos Valores</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="page-scroll" href="#serviços">
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
                                        <a class="page-scroll" href="#depoimentos">
                                            <div class="br">Depoimentos</div>
                                        </a>
                                    </li>
                                     <li>
                                        <a class="page-scroll" href="#chegar">
                                            <div class="br">Como Chegar</div>
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
                            <form action="php/processa_login.php" method="POST">
                                <div class="form-group">
                                    <label for="user">Usuário:</label>
                                    <input type="text" class="form-control" id="user" name="usuario">
                                </div>
                                <div class="form-group">
                                    <label for="senha">Senha:</label>
                                    <input type="password" class="form-control" id="senha" name="senha">
                                </div>
                                <button type="submit" class="btn btn-primary">Entrar</button>
                            </form>

                        </div>
                        <div class="col-md-6">
                            <img src="assets/img/logo01-black.png" alt="Imagem de Login" class="img-fluid">
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
                <?php
                $diretorio = "assets/img/slider/";
                $imagens = glob($diretorio . "*.{jpg,png,gif}", GLOB_BRACE);
                foreach ($imagens as $imagem) {
                    echo '<img src="' . $imagem . '" alt="slider" />';
                }
                ?>
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
                                    <div class="container">
                                <h2 class="animate__animated animate__fadeInDown">Experiência no Mercado</h2>
                            </div>
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
                                     <div class="container">
                                <p class="animate__animated animate__fadeInUp">Transparência e Credibilidade</p>
                            </div>
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
                                    <div class="container">
                                <p class="animate__animated animate__fadeInUp">Foco no Resultado</p>
                            </div>
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
                                   <div class="container">
                                <p class="animate__animated animate__fadeInUp">Alcançar Objetivos</p>
                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <div id="sobre" class="about-area area-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="section-headline text-center">
                        <h2 class="br">Sobre Nós</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="well-middle">
                        <div class="single-well">
                            <span class="br minor-title-about"></span>
                            <h4 class="about-content">
                                <div class="br">
                                    A <strong>CONFINTER</strong> é uma empresa especializada em Consultoria Financeira e Correspondente Bancária que atua na intermediação de negócios, presencialmente e online.
                                </div>
                            </h4>
                            <h4 class="about-content">
                                <div class="br">
                                    Seguimos as diretrizes do Banco Central do Brasil, nos termos da Resolução no 3.954/2011. Nosso procedimento de avaliação de crédito é submetido à política de crédito da Instituição
                                    Financeira escolhida pelo usuário e está submetida a aprovação.
                                </div>
                            </h4>
                            <h4 class="about-content">
                                <div class="br">
                                    Antes da contratação de qualquer serviço através de nossos parceiros e consultores, você receberá todas as condições e informações relativas à linha
                                    de crédito a ser contratada, de forma completa e transparente.
                                </div>
                            </h4>
                            <br /><br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Fim do Sobre Nós -->
    <div id="valores" class="valores-area area-padding">
        <!-- ======= Nossos Valores  ======= -->
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="section-headline text-center">
                        <h2 class="br">Nossos Valores</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="well-middle">
                        <div class="single-well">
                            <span class="br minor-title-about"></span>
                            <h4 class="about-content">
                                <div class="br">
                                    Um novo projeto onde o conceito e a missão vão além do que se espera de uma consultoria, totalmente estruturada e
                                    pronta para sermos o futuro de nossos clientes. Uma consultoriafinanceira totalmente estruturada e personalizada,
                                    pronta para entregar o melhor custo xbenefício aos nossos clientes.
                                </div>
                            </h4>
                            <h4 class="about-content">
                                <div class="br">
                                    Nossa palavra de ordem é o <strong>SUCESSO</strong>. Transparência e Honestidade são os nossos principais valores.
                                </div>
                            </h4>
                            <br /><br />
                            <div class="slider1 owl-carousel">
        <div class="card">
            <div class="img">
                <img src="assets/img/missao.png" alt="missao">
            </div>
            <div class="content">
                <div class="title">                    
                </div>
                <div class="sub-title">
                    
                </div>
                <p>
                    
                    Facilitar o acesso a crédito consignado e fornecer consultoria financeira personalizada, visando o equilíbrio e bem-estar financeiro dos nossos clientes.
                </p>
                
            </div>
        </div>
        <div class="card">
            <div class="img">
                <img src="assets/img/visao.png" alt="visao">
            </div>
            <div class="content">
                <div class="title">                    
                </div>
                <div class="sub-title">
                    
                </div>
                <p>
                    Ser reconhecida como a empresa líder  em intermediação de negócios, destacando-se pela excelência no atendimento ao cliente e pela construção de relacionamentos sólidos e duradouros.
                </p>
                
            </div>
        </div>
        <div class="card">
            <div class="img">
                <img src="assets/img/valores.png" alt="valores">
            </div>
            <div class="content">
                <div class="title">                    
                </div>
                <div class="sub-title">
                    
                </div>
                <p>
                    <strong>Transparência:</strong> Agimos com total transparência em nossas operações e informações, promovendo a confiança mútua.<br>
                    <strong>Comprometimento Personalizado:</strong> Nos dedicamos a entender as necessidades individuais de cada cliente, oferecendo soluções financeiras.<br>
                    <strong>Respeito e Empatia:</strong> Valorizamos a diversidade e tratamos todos com respeito e empatia, construindo relações duradouras.<br>
                    <strong>Sustentabilidade Financeira:</strong> Comprometemo-nos a promover práticas financeiras sustentáveis, visando o bem-estar financeiro a longo prazo de nossos clientes.<br>
                </p>
                
            </div>
        </div>
    </div>
    <script>
  $(".slider1").owlCarousel({
    loop: true,
    autoplay: true,
    autoplayTimeout: 5000, // 5000ms = 5s;
    autoplayHoverPause: true,
    items: 3, // Inicialmente mostrar 3 itens
    onInitialized: function(event) {
        // Depois que o carrossel é inicializado, alterar para mostrar 1 item
        this.options.items = 1;
    }
});

</script>
            </div>
        </div>

        <div id="serviços" class="services-area area-padding">
            <!-- ======= Serviços ======= -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="section-headline services-head text-center">
                            <h2>Nossos serviços</h2>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <!-- Inicio Serviços -->
                        <div class="about-move">
                            <div class="services-details">
                                <div class="single-services">
                                    <a class="services-icon" href="#">
                                        <i class="fa fa-handshake-o" aria-hidden="true"></i>
                                    </a>
                                    <h4>Consultoria</h4>
                                    <p>
                                        Nossos especialistas ajudarão desde a abertura de contas até delinear a melhor estratégia para os diferentes mercados financeiros.
                                    </p>
                                </div>
                            </div><!-- Fim Detalhes Sobre -->
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="about-move">
                            <div class="services-details">
                                <div class="single-services">
                                    <a class="services-icon" href="#">
                                        <i class="fa fa-line-chart" aria-hidden="true"></i>
                                    </a>
                                    <h4>Intermediação de Negócios</h4>
                                    <p>
                                        Atuando como correspondentes bancários com mais de 15 anos de experiência. Parceria com os principais bancos e financeiras de crédito consignado no país.
                                    </p>
                                </div>
                            </div><!-- Fim Detalhes Sobre -->
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class=" about-move">
                            <!-- fim col-md-3 -->
                            <div class="services-details">
                                <div class="single-services">
                                    <a class="services-icon" href="#">
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                    </a>
                                    <h4>Cartões de Crédito Consignado</h4>
                                    <p>
                                        Conveniado com os principais bancos, ao todo são mais de 250 convênios ativos em Governos, Prefeituras e para aposentados e pensionistas do INSS.
                                    </p>
                                </div>
                            </div><!-- fim dos detalhes do sobre -->
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <!-- fim col-md-3 -->
                        <div class=" about-move">
                            <div class="services-details">
                                <div class="single-services">
                                    <a class="services-icon" href="#">
                                        <i class="fa fa-money" aria-hidden="true"></i>
                                    </a>
                                    <h4>Saque Aniversário FGTS</h4>
                                    <p>
                                        No saque-aniversário você pode sacar o valor que possui em FGTS com taxas a partir de 1.29% a.m..
                                    </p>
                                </div>
                            </div><!-- fim dos detalhes do sobre -->
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- fim da Seção de serviços -->
        <div class="container">
            <div class="row align-items-stretch">
                <div class="col-md-6">
                    <!-- Coluna 1: Requisição de Análise de Crédito -->
                    <div id="requisicoes" class="our-team-area area-padding">
                        <div class="section-headline text-center">
                            <h2 class="br">Requisição de Análise de Crédito</h2>
                        </div>
                        <div class="formulario-modal" id="requisicaoForm">
                            <form action="php/process.php" method="POST" id="form-requisicao">
                                <div class="form-group">
                                    <input type="text" class="br form-control" id="nome" name="nome" placeholder="Nome completo" required>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="data_nascimento">Data Nasci.:</label>
                                        <input type="date" class="br form-control" id="data_nascimento" placeholder="Data de Nascimento:" name="data_nascimento" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="telefone">Telefone:</label>
                                        <input type="tel" class="br form-control" id="telefone" name="telefone" placeholder="Telefone" required maxlength="15">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="email">E-mail:</label>
                                        <input type="email" class="br form-control" id="email" name="email" placeholder="Digite seu E-mail" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="horario_contato">Horário para Contato:</label>
                                    <div class="input-group">
                                        <input type="time" class="br form-control" id="horario_contato" name="horario_contato" required>
                                        <div class="input-group-append">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tipo" class="text-left">Tipo:</label>
                                    <textarea class="br form-control" id="tipo" name="tipo" rows="3" maxlength="250"></textarea>
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
                                    <input type="text" class="br form-control" id="outros_info" name="outros_info" rows="3" maxlength="200">
                                </div>
                                <div class="form-group text-center">
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary">
                                            <div class="br">Enviar Requisição</div>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- Fim da coluna Requisição de Análise de Crédito -->
                <div class="col-md-6">
                    <!-- Coluna 2: Dúvidas Frequentes -->
                    <div class="col-md-12" style="overflow-y: auto;">
                        <div id="duvidas" class="faq-area area-padding">
                            <div class="section-headline text-center">
                                <h2 class="br">Dúvidas frequentes</h2>
                            </div>
                            <div class="faq-details">
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default" style="margin-bottom: 5px; width: 100%;">
                                        <!-- Pergunta 1 -->
                                        <div class="panel-heading">
                                            <h4 class="check-title">
                                                <a data-toggle="collapse" class="active" data-parent="#accordion" href="#check1">
                                                    <span class="acc-icons"></span>
                                                    <h3 class="br" style="font-size: 14px; margin-bottom: 0;">Em que área a empresa opera?</h3>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="check1" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <h5 class="br" style="font-size: 12px;">
                                                    Operamos como prestadores de serviços, há mais de 15 anos nas áreas de
                                                    Crédito Consignado, Intermediação de Negócios,
                                                    Consultoria Financeira e Cobranças.
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default" style="margin-bottom: 5px; width: 100%;">
                                        <!-- Pergunta 2 -->
                                        <div class="panel-heading">
                                            <h4 class="check-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#check2">
                                                    <span class="acc-icons"></span>
                                                    <h3 class="br" style="font-size: 14px; margin-bottom: 0;">Porquê escolher a CONFINTER?</h3>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="check2" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <h5 class="br" style="font-size: 12px;">
                                                    Você terá um atendimento rápido e prático em todo território nacional.
                                                    Nossos profissionais são dinâmicos e altamente qualificados,
                                                    oferecendo suporte eficiente, soluções práticas com foco em resultados.
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default" style="margin-bottom: 5px; width: 100%;">
                                        <!-- Pergunta 3 -->
                                        <div class="panel-heading">
                                            <h4 class="check-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#check3">
                                                    <span class="acc-icons"></span>
                                                    <h3 class="br" style="font-size: 14px; margin-bottom: 0;">O que é empréstimo consignado?</h3>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="check3" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <h5 class="br" style="font-size: 12px;">
                                                    O consignado é uma modalidade de crédito em que os pagamentos são descontados automaticamente
                                                    do salário do servidor ou do benefício do INSS do tomador.
                                                    Por conta dessa dinâmica, a taxa de inadimplência é baixa e o risco para os bancos muito pequeno,
                                                    e é isso que faz com que o crédito consignado tenha uma das menores taxas do mercado.
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default" style="margin-bottom: 5px; width: 100%;">
                                        <!-- Pergunta 4 -->
                                        <div class="panel-heading">
                                            <h4 class="check-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#check4">
                                                    <span class="acc-icons"></span>
                                                    <h3 class="br" style="font-size: 14px; margin-bottom: 0;">Quem pode solicitar crédito consignado?</h3>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="check4" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <h5 class="br" style="font-size: 12px;">
                                                    Aqui na CONFINTER, o crédito consignado está disponível para alguns públicos, entre eles:
                                                    Beneficiário do INSS (BPC/LOAS), Servidores Públicos Municipais, Estaduais e Federais do SIAPE,
                                                    Militares das Forças Armadas e Aposentados e Pensionistas do INSS.
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default" style="margin-bottom: 5px; width: 100%;">
                                        <!-- Pergunta 5 -->
                                        <div class="panel-heading">
                                            <h4 class="check-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#check5">
                                                    <span class="acc-icons"></span>
                                                    <h3 class="br" style="font-size: 14px; margin-bottom: 0;">Quais são as taxas de juros?</h3>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="check5" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <h5 class="br" style="font-size: 12px;">
                                                    Oferecemos Empréstimo Consignado com taxas personalizadas que podem variar dependendo do tipo de convênio,
                                                    operação, prazo, valor solicitado e perfil do cliente.
                                                    As taxas de juros máximas são de 1.72% ao mês no empréstimo consignado para aposentado e/ou pensionista do INSS
                                                    e Beneficiário do INSS (BPC/LOAS); e para Servidores Públicos à partir de 1.93% ao mês.
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default" style="margin-bottom: 5px; width: 100%;">
                                        <!-- Pergunta 6 -->
                                        <div class="panel-heading">
                                            <h4 class="check-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#check6">
                                                    <span class="acc-icons"></span>
                                                    <h3 class="br" style="font-size: 14px; margin-bottom: 0;">Como é feita a análise de crédito?</h3>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="check6" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <h5 class="br" style="font-size: 12px;">
                                                    Prezando sempre pela saúde financeira, optamos pelas melhores estratégias de acordo com a gama de bancos parceiros e financeiras,
                                                    buscando o melhor custo-benefício para nossos clientes.
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default" style="margin-bottom: 5px; width: 100%;">
                                        <!-- Pergunta 7 -->
                                        <div class="panel-heading">
                                            <h4 class="check-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#check7">
                                                    <span class="acc-icons"></span>
                                                    <h3 class="br" style="font-size: 14px; margin-bottom: 0;">Como a CONFINTER pode me ajudar hoje?</h3>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="check7" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <h5 class="br" style="font-size: 12px;">
                                                    A CONFINTER atua também como Correspondente Digital autorizado pelo Banco Central e pode intermediar operações de crédito ajudando você,
                                                    consumidor, a escolher as melhores opções de crédito disponíveis para seu perfil.
                                                    Conosco, você não precisa sair de casa ou do trabalho perdendo tempo indo até o banco, enfrentando filas e burocracia! Nós fazemos todo o
                                                    processo e acompanhamos o seu caso, digitalmente até a liberação do crédito em conta.
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default" style="margin-bottom: 5px; width: 100%;">
                                        <!-- Pergunta 8 -->
                                        <div class="panel-heading">
                                            <h4 class="check-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#check8">
                                                    <span class="acc-icons"></span>
                                                    <h3 class="br" style="font-size: 14px; margin-bottom: 0;">Como faço para assinar o meu contrato?</h3>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="check8" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <h5 class="br" style="font-size: 12px;">
                                                    A assinatura é de forma digital, podendo ser enviado um link por WhatsApp ou SMS, enviado para o seu número de celular informado no formulário.  A maioria dos bancos exigem:
                                                    •	o envio do documento de identidade;
                                                    •	o aceite (SIM) na CCB: essa etapa o cliente verifica se todas as condições contratadas e precisa dar o aceite para seguir para a assinatura;
                                                    •	tirar uma selfie (foto de si mesmo) que é a etapa de assinatura digital do cliente;
                                                    Entretanto, essa modalidade pode variar de acordo com as exigências de cada Instituição Financeira.
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Fim da coluna Dúvidas Frequentes -->
            </div>
           
<div class="container-fluid container-center">
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-8 col-xs-12 text-center">
            <div class="section-headline">
                <h2 class="br">Enviar Depoimento</h2>
            </div>
            <!-- Adicionando um identificador único ao formulário -->
            <form id="form-depoimento" action="php/enviar_depoimento.php" method="POST">
                <div class="form-group">
                    <input type="text" name="nome" class="br form-control" id="nome" placeholder="Insira o nome, em branco enviará como Anônimo" data-rule="minlen:4" data-msg="" />
                    <div class="br validation"></div>
                </div>
                <div class="form-group">
                    <textarea class="br form-control" name="mensagem" rows="5" data-rule="required" data-msg="Por favor escreva algo para nós" placeholder="Mensagem"></textarea>
                    <!-- Adicionando um identificador único ao elemento onde a mensagem de erro será exibida -->
                    <div id="erro-mensagem" class="text-danger">
                        <?php
                        // Verificar se a variável de sessão erro_mensagem está definida
                        if (isset($_SESSION['erro_mensagem'])) {
                            // Exibir a mensagem de erro
                            echo $_SESSION['erro_mensagem'];
                            // Remover a variável de sessão para que a mensagem não seja exibida novamente após atualizar a página
                            unset($_SESSION['erro_mensagem']);
                        }
                        ?>
                    </div>
                    <div class="br validation"></div>
                    <div class="en validation"></div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Enviar Depoimento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script JavaScript para rolar a página até a mensagem de erro -->
<script>
    window.onload = function() {
        // Verificar se a URL contém o parâmetro de erro
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('erro')) {
            // Rolar a página até a mensagem de erro
            const erroMensagem = document.getElementById('erro-mensagem');
            if (erroMensagem) {
                erroMensagem.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    };
</script>
<div id="depoimentos" class="testimonials">
<div class="container">
        <div class="owl-carousel owl-theme">
            <!-- Consultar os depoimentos aprovados no banco de dados -->
            <?php
            $sql = "SELECT nome, mensagem FROM depoimentos WHERE status_mod = 'aprovado'";
            $result = mysqli_query($conexao, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $nome = $row['nome'] ? $row['nome'] : "Anônimo";
                    $mensagem = $row['mensagem'];
                    ?>
                    <!-- Cada depoimento deve estar dentro de um item do Owl Carousel -->
                    <div class="item">
                        <div class="testimonial-item">
                            <img src="assets/img/depoimentos/1.png" class="testimonial-img" alt="Depoimento Imagem">
                            <div class="testimonial-name"><?php echo $nome; ?></div>
                            <div class="testimonial-message"><?php echo $mensagem; ?></div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Caso não haja depoimentos aprovados
                echo "<p>Nenhum depoimento aprovado disponível.</p>";
            }
            ?>
        </div>
    </div>

     <div class="footer-area">
                <div class="container">
                    <div class="row">
                        <!-- Coluna da Informação da Empresa -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="footer-content">
                                <div class="footer-head">
                                    <div class="section-headline text-center">
                                        <h2 class="br">A Empresa</h2>
                                    </div>
                                    <div class="footer-logo">
                                        <img src="assets/img/logo01-black.png" alt="logo" width="125px">
                                    </div>
                                    <h4 class="br">CONFINTER Consultoria Financeira<br /><span class="number-sequence">CNPJ: 11.727.809.0001/36</span></h4>
                                    <h5 class="br">Especialista em corretagem, consultoria, intermediação<br />e mediação de negócios financeiros.</h5>
                                </div>
                            </div>
                        </div>
                        <div id="chegar" class="chegar">
                        <!-- Coluna de Como Chegar -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="footer-content">
                                <div class="footer-head">
                                    <div class="section-headline text-center">
                                        <h2 class="br">Como Chegar</h2>
                                    </div>
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.674620432733!2d-46.34657878502169!3d-23.529135784679013!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce43de0d92a6f5%3A0x8f85eeb0c19e3c32!2sMarina%20La%20Regina!5e0!3m2!1sen!2sus!4v1648523258379!5m2!1sen!2sus&hl=pt-BR" width="100%" height="380" frameborder="0" style="border:0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
 
    <footer>
        <footer class="footer-area-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="copyright text-center">
                            <p class="br">&copy; Copyright 2024 CONFINTER. Todos Direitos Reservados.</p>
                        </div>
                        <div class="credits">
                            <div class="br">Desenvolvido por <a href="https://github.com/finandolopes/DRP01-PJI110-SALA-007GRUPO-017/tree/main">DRP01-PJI110-SALA-007GRUPO-017</a> com <a href="https://bootstrapmade.com/">BootstrapMade</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                // Iniciar o carrossel de depoimentos aprovados
                $('#carouselDepoimentos').carousel({
                    interval: 5000 // Muda o depoimento a cada 5 segundos
                });
            });
        </script>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="js/script.js"></script>
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
    // Inicialize o carrossel do Owl Carousel
    $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 30,
        autoplay: true,
        autoplayTimeout: 5000, // 5000ms = 5s
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: false
            },
            1000: {
                items: 3,
                nav: true,
                loop: false
            }
        }
    });
</script>
</body>
</html>

<?php
// Fechar a conexão com o banco de dados após o uso
mysqli_close($conexao);
?>
