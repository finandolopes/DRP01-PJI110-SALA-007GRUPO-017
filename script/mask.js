$(document).ready(function(){
    $('.celular').mask('(99)9 9999-9999');
    $('.telefone').mask('(99) 9999-9999');
    $('.cpf').mask('999.999.999-99');
    $('.valor').mask('#.##0,00', {reverse: true});
    $('.cep').mask('99999-999');
    $('.nascimento').mask('99/99/9999');
    $('.dependentes').mask('9');
    $('.referencia').mask('(99)9999-9999');
    $('.ano').mask('9999');
    $('.km').mask('#.##0', {reverse: true});
    $('.prestacoes').mask('999');
    });