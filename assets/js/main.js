
(function() {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all)
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener))
      } else {
        selectEl.addEventListener(type, listener)
      }
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Scrolls to an element with header offset
   */
  const scrollto = (el) => {
    let header = select('#header')
    let offset = header.offsetHeight

    if (!header.classList.contains('header-scrolled')) {
      offset -= 16
    }

    let elementPos = select(el).offsetTop
    window.scrollTo({
      top: elementPos - offset,
      behavior: 'smooth'
    })
  }

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Mobile nav toggle
   */
  on('click', '.mobile-nav-toggle', function(e) {
    select('#navbar').classList.toggle('navbar-mobile')
    this.classList.toggle('bi-list')
    this.classList.toggle('bi-x')
  })

  /**
   * Mobile nav dropdowns activate
   */
  on('click', '.navbar .dropdown > a', function(e) {
    if (select('#navbar').classList.contains('navbar-mobile')) {
      e.preventDefault()
      this.nextElementSibling.classList.toggle('dropdown-active')
    }
  }, true)

  /**
   * Scrool with ofset on links with a class name .scrollto
   */
  on('click', '.scrollto', function(e) {
    if (select(this.hash)) {
      e.preventDefault()

      let navbar = select('#navbar')
      if (navbar.classList.contains('navbar-mobile')) {
        navbar.classList.remove('navbar-mobile')
        let navbarToggle = select('.mobile-nav-toggle')
        navbarToggle.classList.toggle('bi-list')
        navbarToggle.classList.toggle('bi-x')
      }
      scrollto(this.hash)
    }
  }, true)

  /**
   * Scroll with ofset on page load with hash links in the url
   */
  window.addEventListener('load', () => {
    if (window.location.hash) {
      if (select(window.location.hash)) {
        scrollto(window.location.hash)
      }
    }
  });

  /**
   * Preloader
   */
  let preloader = select('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove()
    });
  }

  /**
   * Hero carousel indicators
   */
  let heroCarouselIndicators = select("#hero-carousel-indicators")
  let heroCarouselItems = select('#heroCarousel .carousel-item', true)

  heroCarouselItems.forEach((item, index) => {
    (index === 0) ?
    heroCarouselIndicators.innerHTML += "<li data-bs-target='#heroCarousel' data-bs-slide-to='" + index + "' class='active'></li>":
      heroCarouselIndicators.innerHTML += "<li data-bs-target='#heroCarousel' data-bs-slide-to='" + index + "'></li>"
  });

  /**
   * Porfolio isotope and filter
   */
  window.addEventListener('load', () => {
    let portfolioContainer = select('.portfolio-container');
    if (portfolioContainer) {
      let portfolioIsotope = new Isotope(portfolioContainer, {
        itemSelector: '.portfolio-item',
        layoutMode: 'fitRows'
      });

      let portfolioFilters = select('#portfolio-flters li', true);

      on('click', '#portfolio-flters li', function(e) {
        e.preventDefault();
        portfolioFilters.forEach(function(el) {
          el.classList.remove('filter-active');
        });
        this.classList.add('filter-active');

        portfolioIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
      }, true);
    }

  });

  /**
   * Initiate portfolio lightbox 
   */
  const portfolioLightbox = GLightbox({
    selector: '.portfolio-lightbox'
  });

    /**
     * Testimonials slider
     */
    new Swiper('.testimonials-slider', {
        speed: 600,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        slidesPerView: 'auto',
        pagination: {
            el: '.swiper-pagination',
            type: 'bullets',
            clickable: true
        }
    });

    /**
     * Animation on scroll
     */
    window.addEventListener('load', () => {
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        })
    });

    /**
     * Initiate Pure Counter 
     */
    new PureCounter();

})()
<!-- Script JavaScript para validar o formulário -->

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


    $(document).ready(function () {
        // Máscara para data (DD/MM/AAAA)
        //  $('#data_nascimento').mask('00/00/0000');

        // Máscara para hora (HH:MM)
        $('#horario_contato').mask('00:00');

        $(document).ready(function() {
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

  // Aguarda o carregamento do documento
  document.addEventListener('DOMContentLoaded', function () {
    // Seleciona o elemento com o ID "btnOpenMap"
    var btnOpenMap = document.getElementById('btnOpenMap');
    // Adiciona um evento de clique ao elemento
    btnOpenMap.addEventListener('click', function () {
      // Seleciona o modal de como chegar pelo ID
      var modalComoChegar = document.getElementById('modalComoChegar');      
      // Abre o modal de como chegar
      $(modalComoChegar).modal('show');
    });
  });

   // $(document).ready(function () {
        // Remover a máscara de data antes de enviar o formulário
      //  $('#form-requisicao').submit(function () {
            // Remover a máscara de data antes de enviar o formulário
          //  var dataNascimento = $('#data_nascimento').val();
            // Remover qualquer caractere que não seja número
          //  var dataLimpa = dataNascimento.replace(/\D/g, '');
            // Formatar a data para o padrão YYYY-MM-DD
          //  var dataFormatada = dataLimpa.replace(/(\d{2})(\d{2})(\d{4})/, '$3-$2-$1');
            // Atribuir a data formatada de volta ao campo
         //   $('#data_nascimento').val(dataFormatada);
      //  });
   // });
