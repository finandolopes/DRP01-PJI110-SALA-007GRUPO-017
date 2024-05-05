const sidebar = document.querySelector(".sidebar");
const closeBtn = document.querySelector("#btn");
const searchBtn = document.querySelector(".bx-search");

closeBtn.addEventListener("click", function () {
    sidebar.classList.toggle("open");
})

searchBtn.addEventListener("click", function () {
    sidebar.classList.toggle("open");
})
function carregarPagina(url) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.querySelector(".home_section").innerHTML = xhr.responseText;
            ajustarTamanhoSe��oPrincipal();
        }
    };
    xhr.send();
}

function ajustarTamanhoSe��oPrincipal() {
    var sidebarWidth = document.querySelector(".sidebar").offsetWidth;
    document.querySelector(".home_section").style.width = "calc(100% - " + sidebarWidth + "px)";
    // Adicionar outras opera��es de ajuste conforme necess�rio
}
document.addEventListener("DOMContentLoaded", function () {
    ajustarTamanhoSe��oPrincipal();
    // Adicionar outros event listeners conforme necess�rio
});

// JavaScript para abrir o modal de como chegar
$(document).ready(function(){
    $("#btnOpenMap").click(function(){
        $("#modalComoChegar").modal('show');
    });
});
$(document).ready(function () {
    // Esconder todas as respostas
    $('.panel-collapse').hide();

    // Adicionar evento de clique para cada cabeçalho de pergunta
    $('.panel-heading').click(function () {
        // Esconder todas as respostas
        $('.panel-collapse').hide();

        // Mostrar apenas a resposta correspondente à pergunta clicada
        $(this).next('.panel-collapse').show();
    });
});
$('.panel-heading a').on('click', function () {
    var old_content = $(this).attr('href');
    $('.panel-heading a').each(function () {
        if (old_content !== $(this).attr('href')) {
            $($(this).attr('href')).collapse('hide');
        }
    });
});
$('#accordion').on('show.bs.collapse', function () {
    $('#accordion .in').collapse('hide');

    $(document).ready(function () {
        $('.carousel').carousel({
            padding: 200
        });
        autoplay();
        function autoplay() {
            $('.carousel').carousel('next');
            setTimeout(autoplay, 4500);
        }
    });