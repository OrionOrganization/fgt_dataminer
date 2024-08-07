@php
    $whatsappUrl = 'https://contate.me/forosgt';
    $whatsappNumber = '(19) 97121-6718';
    $instagramUrl = 'https://www.instagram.com/forosgt/';
    $linkedinUrl = 'https://www.linkedin.com/company/forosgestaotributaria';
    $email = 'contato@forosgt.com.br';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Bem-vindo à Fóros - Gestão Tributária, uma empresa dedicada a fornecer soluções de gestão tributária para nossos clientes. Com uma equipe experiente de advogados especializados, estamos comprometidos em oferecer serviços de alta qualidade. Conte conosco para alcançar resultados eficazes. Agende uma consulta hoje mesmo e descubra como podemos ajudar você a alcançar seus objetivos legais.">

        <title>Fóros - Gestão Tributária</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/landing_page.css') }}">

        <!-- Bootstrap -->
        <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <noscript><link rel="stylesheet" href="styles.css"></noscript>

        <!-- Line Awesome Icons -->
        <link rel="preload" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="styles.css"></noscript>

        <!-- Noty -->
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css"> --}}
    </head>
    <body>
         <!-- Header -->
        <nav id="sub-header" class="display-flex-around">
            <div id="sub-header-contact">
                <div><i class="las la-phone header-contact-icon"></i> <span><a href="{{$whatsappUrl}}" target="_blank">{{$whatsappNumber}}</a></span></div>
                <div><i class="las la-envelope header-contact-icon"></i> <span>{{$email}}</span></div>
            </div>
            <div id="sub-header-socials">
                <a href="{{$instagramUrl}}" target="_blank" class="header-social-link" aria-label="Acesse nosso Instagram"><i class="lab la-instagram header-social-icon"></i></a>
                <a href="{{$linkedinUrl}}" target="_blank" class="header-social-link" aria-label="Acesse nosso LinkedIn"><i class="lab la-linkedin header-social-icon"></i></a>
            </div>
        </nav>
        <header id="main-header">
            <a href="#">
                <img src="{{ asset('img/logo.svg') }}" alt="Logo FGT (Fóros Gestão Tributária)" id="header-logo" width="140px" height="75px">
            </a>

            <nav id="main-navigation">
                <img src="{{ asset('img/logo-white.png') }}" alt="Logo FGT (Fóros - Gestão Tributária)" class="d-none" id="main-navigation-logo" width="70px" height="30px">

                <a href="#" class="header-nav-link">Início</a>
                <a href="#about-section" class="header-nav-link">Sobre</a>
                <a href="/servicos" class="header-nav-link">Serviços</a>
                {{-- <a href="#contact-section" class="header-nav-link">Contato</a> --}}
                <a href="#news-section" class="header-nav-link">Blog</a>

                <a href="{{$whatsappUrl}}" target="_blank" class="header-nav-button secondary-button">Conhecer</a>
            </nav>

            <button class="hamburger-menu" aria-label="Botão acessar menu"></button>
        </header>

        <!-- Main -->
        <main>
            <!-- Carousel -->
            <section id="main-slider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#main-slider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#main-slider" data-bs-slide-to="1" aria-label="Slide 2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="5000">
                        <img src="" id="carousel-pic-1" rel="preload" fetchpriority="high" as="image" type="image/webp" class="d-block w-100" alt="Foto 1 da equipe FGT - Fundo de carrossel de fotos" width="100%" height="100%">
                        <div class="carousel-caption hidden d-md-block">
                            <h2>Gestão Tributária</h2>
                            <p>Gerenciamento, planejamento, análise, controle e acompanhamento.</p>
                            <a href="{{$whatsappUrl}}" target="_blank" class="main-button">Quero Conhecer a FGT</a>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="5000">
                        <img src="" class="d-block w-100" id="carousel-pic-2" alt="Foto 2 da equipe FGT - Fundo de carrossel de fotos" width="100%" height="100%">
                        <div class="carousel-caption hidden d-md-block">
                            <h2>Recuperação de Créditos</h2>
                            <p>Recuperação de valores pagos a título de tributação indevida ou a maior.</p>
                            <a href="{{$whatsappUrl}}" target="_blank" class="main-button">Quero Conhecer a FGT</a>
                        </div>
                    </div>
                    {{-- AINDA EM CONSTRUÇÃO --}}
                    {{-- <div class="carousel-item" data-bs-interval="5000">
                        <img src="" class="d-block w-100" id="carousel-pic-3" alt="Foto 3 da equipe FGT - Fundo de carrossel de fotos" width="100%" height="100%">
                        <div class="carousel-caption hidden d-md-block">
                            <h2>Busca de Dívida Ativa Tributária</h2>
                            <p>Encontre a solução para o passivo inscrito em dívida ativa.</p>
                            <a href="{{$whatsappUrl}}" target="_blank" class="main-button">Quero Conhecer a FGT</a>
                        </div>
                    </div> --}}
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#main-slider" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#main-slider" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </section>

            <!-- Honesty -->
            <figure class="text-center" id="honesty-figure">
                <blockquote class="blockquote">
                    <i class="las la-balance-scale"></i>
                    <p>
                        Temos compromisso com a honestidade e a transparência, são estes os princípios mestres, que guiam nossa tomada de decisão .
                    </p>
                </blockquote>
                <figcaption class="blockquote-footer">
                    Fóros Gestão Tributária
                </figcaption>
            </figure>

            <!-- About -->
            <section id="about-section">
                <img src="" id="about-bg-image" alt="Imagem de fundo da seção Sobre">
                <div id="about-container" class="container">
                    <div id="text-content">
                        <h1>Sobre Nós</h1>
                        <figure>
                            <blockquote class="blockquote">
                                <p>
                                    <em>
                                    "Escolher a FÓROS é optar pela segurança, agilidade e eficiência na gestão Fiscal. Possuimos uma equipe especializada e antenada com as regulamentações mais recentes, garantido que a gestão fiscal estará sempre atualizada e propondo soluções avançadas e inovadoras. Confie na FÓROS, sua melhor parceria de gestão tributária."
                                    </em>
                                </p>
                            </blockquote>
                            <figcaption class="blockquote-footer" style="color: var(--main-color);">
                            Marco Desiato, <cite title="Source Title">CEO da FGT</cite>
                            </figcaption>
                        </figure>
                        <a href="{{$whatsappUrl}}" target="_blank" class="main-button">Solicitar Orçamento</a>
                    </div>

                    <img src="" alt="Foto de Marco Desiato, CEO da FGT" id="about-image" loading="lazy">
                </div>
            </section>

            <!-- History -->
            <div class="container text-left">
                <div class="row" id="history-section">
                <img src="" id="history-image" alt="Foto da equipe da FGT" class="hidden">
                  <div class="col">
                    <div class="hidden text-content">
                        <small>Venha conhecer</small>
                        <h1>Nossa História</h1>
                        <br>
                        <p>
                            A Fóros nasceu da visão empreendedora
                            dos fundadores, que almejavam estabelecer um escritório
                            especializado em fornecer soluções tributárias personalizadas
                            e seguras para seus clientes.<br>
                            <br>

                            Nosso compromisso é oferecer excelência na gestão fiscal,
                            proporcionando confiança e tranquilidade aos empresários
                            que buscam otimizar sua performance financeira. <br>

                            <br>

                            Contamos com uma equipe dedicada e especializada,
                            pronta para transformar desafios tributários em oportunidades
                            de crescimento para o seu negócio.
                        </p>
                    </div>
                  </div>
                </div>
            </div>

            <!-- Team -->
            <section id="team-section">
                <div id="team-container">
                    {{-- Marco --}}
                    <div class="team-member-card hidden mt-3">
                        <div class="team-member-card-container">
                            <img src="" id="lawyer-1-pic" alt="Foto do CEO da FGT, Marco Desiato">
                            <div class="lawyer-info">
                                <ul>
                                    <li><i class="las la-angle-double-right mt-2"></i> Empresário</li>
                                    <li><i class="las la-angle-double-right mt-2"></i> Consultor de empresas</li>
                                    <li><i class="las la-angle-double-right mt-2"></i> Eng. da Computação - PUCCAMP</li>
                                    <li><i class="las la-angle-double-right mt-2"></i> MBA em gestão estratégica - FGV</li>
                                    <li><i class="las la-angle-double-right mt-2"></i> MBA em Gestão em Ohio - FGV</li>
                                    <li><i class="las la-angle-double-right mt-2"></i> MBA em Design Think - INOVA BS</li>
                                </ul>
                            </div>
                        </div>
                        <div class="bottom-div">
                            <h2>Marco Desiato</h2>
                            <hr class="divisor">
                            <small>Presidente - CEO</small>
                        </div>
                    </div>

                    {{-- Everton --}}
                    <div class="team-member-card hidden mt-3">
                        <div class="team-member-card-container">
                            <img src="" id="lawyer-2-pic" alt="Foto do CRO da FGT, Everton Alves">
                            <div class="lawyer-info">
                                <ul>
                                    <li><i class="las la-angle-double-right"></i> Pós graduando em Direito Tributário e Processual Tributário - Faculdade Alphaville (FAVI)</li>
                                    <li><i class="las la-angle-double-right"></i> Direito - USF</li>
                                </ul>
                                <p class="text-light text-center align-self-center">
                                   
                                </p>
                            </div>
                        </div>
                        <div class="bottom-div">
                            <h2>Everton Alves</h2>
                            <hr class="divisor">
                            <small>Diretor de Receita - CRO</small>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Values -->
            <section id="values-section">
                <div id="values-text-content">
                    <small>Descubra</small>
                    <h2>Nossos Valores</h2>

                    <div class="value-content hidden">
                        <i class="las la-balance-scale values-icon"></i>
                        <div class="values-text">
                            <h3 class="values-name">Honestidade e Transparência</h3>
                            <p>
                                Atuamos com integridade em todas as interações, <br>
                                sendo transparentes em nossas práticas e decisões.
                            </p>
                        </div>
                    </div>
                    <div class="value-content hidden">
                        <i class="las la-handshake values-icon"></i>
                        <div class="values-text">
                            <h3 class="values-name">Empatia e Comprometimento</h3>
                            <p>
                                Compreendemos as necessidades individuais de cada cliente, <br>
                                comprometendo-nos a superar obstáculos e oferecer suporte personalizado.
                            </p>
                        </div>
                    </div>
                    <div class="value-content hidden">
                        <i class="las la-medal values-icon"></i>
                        <div class="values-text">
                            <h3 class="values-name">Excelência Profissional</h3>
                            <p>
                                Buscamos continuamente aprimorar nossas  <br>
                                habilidades e conhecimentos, proporcionando serviços <br>
                                de alta qualidade e soluções inovadoras.
                            </p>
                        </div>
                    </div>
                    <div class="value-content hidden">
                        <i class="las la-globe values-icon"></i>
                        <div class="values-text">
                            <h3 class="values-name">Impacto Positivo</h3>
                            <p>
                               Contribuímos para o desenvolvimento social ajudando pessoas e <br>
                                empresas a recuperarem créditos tributários, superarem desafios fiscais <br>
                                e alcançarem seus objetivos financeiros.
                            </p>
                        </div>
                    </div>
                </div>
                <img src="" id="values-pic" alt="Foto da equipe reunida na mesa">
            </section>

            <!-- Services -->
            <section id="services-section">
                <small>Nossos Serviços</small>
                <h1>
                    Os melhores serviços tributários <br>
                    Para sua empresa
                </h1>

                <div id="services-container">
                    {{-- CONSULTORIA TRIBUTÁRIA --}}
                    <div class="card text-center" style="width: 18rem;">
                        <div class="card-body">
                            <i class="service-icon las la-comments-dollar"></i>
                            <h2 class="card-title">Consultoria Tributária</h2>
                            <hr class="card-divisor">
                            <p class="card-text">Análise detalhada da situação tributária para identificar oportunidades de otimização.</p>
                            <a href="/servicos" class="main-button">Saiba Mais</a>
                        </div>
                    </div>
                    {{-- RECUPERAÇÃO DE CRÉDITOS --}}
                    <div class="card text-center" style="width: 18rem;">
                        <div class="card-body">
                            <i class="service-icon las la-donate"></i>
                            <h2 class="card-title">Recuperação de Créditos</h2>
                            <hr class="card-divisor">
                            <p class="card-text">Avaliação minuciosa de registros e transações para identificar oportunidades de reduzir a tributação e recuperar os valores pagos a maior.</p>
                            <a href="/servicos" class="main-button">Saiba Mais</a>
                        </div>
                    </div>
                    {{-- DÍVIDA ATIVA --}}
                    {{-- <div class="card text-center" style="width: 18rem;">
                        <div class="card-body">
                            <i class="service-icon las la-balance-scale-right"></i>
                            <h2 class="card-title">Dívida Ativa</h2>
                            <hr class="card-divisor">
                            <p class="card-text">Ferramenta exclusiva que permite verificar ativamente suas dívidas tributárias.</p>
                            <a href="/servicos" class="main-button">Saiba Mais</a>
                        </div>
                    </div> --}}
                    {{-- REGULARIZAÇÃO FISCAL --}}
                    <div class="card text-center" style="width: 18rem;">
                        <div class="card-body">
                            <i class="service-icon las la-file-invoice-dollar"></i>
                            <h2 class="card-title">Regularização Fiscal</h2>
                            <hr class="card-divisor">
                            <p class="card-text">Orientação técnica e profissional para empresas em processo de regularização fiscal.</p>
                            <a href="/servicos" class="main-button">Saiba Mais</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact -->
            {{-- <section id="contact-section">
                <div class="row">
                    <div class="contact-container col-md-6">
                        <small>Contato</small>
                        <h1>Fale Conosco</h1>
                        <p>
                            Caso tenha alguma dúvida, entre em contato <br>
                            através de um dos nossos telefones ou email. <br>
                            Se tiver preferência, venha visitar nosso escritório!
                        </p>
                        <div class="footer-contacts">
                            <p class="contact-content"><strong><i class="las la-phone header-contact-icon"></i> Telefone:</strong> {{$whatsappNumber}}</p>
                            <p class="contact-content"><strong><i class="las la-envelope header-contact-icon"></i> Email:</strong> {{$email}}</p>
                            <p class="contact-content"><strong><i class="las la-thumbtack header-contact-icon"></i> Endereço:</strong> Rua Conceição, 233, Sala 916, Centro, <br> Campinas SP, 13010-916, Brasil</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <form id="contact-form" action="{{ url('/lead') }}" method="post">
                        @csrf
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="name">Nome</label>
                              <input class="form-control form-control-name" name="name" id="name" placeholder="" type="text" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="company_name">Empresa</label>
                              <input class="form-control form-control-company_name" name="company_name" id="company_name" placeholder="" type="text" required>
                            </div>
                          </div>
                          <div class="col-md-12 mt-3">
                            <div class="form-group">
                              <label for="phone">Telefone</label>
                              <input class="form-control form-control-phone" name="phone" id="phone" placeholder="" required>
                            </div>
                          </div>
                          <div class="col-md-12 mt-3">
                            <div class="form-group">
                              <label for="email">Email</label>
                              <input class="form-control form-control-email" name="email" id="email" placeholder="" type="email"
                                required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="message">Mensagem</label>
                            <textarea class="form-control form-control-message" name="message" id="message" placeholder="" rows="10"
                            required></textarea>
                        </div>
                        <div>
                            <br>
                            <button class="secondary-button" type="submit">Enviar Mensagem</button>
                        </div>
                      </form>
                    </div>

                  </div>
            </section> --}}

            <!-- Blog/News -->
            <section id="news-section">
                <div class="row">
                    @php
                        $blogs = \App\Models\BlogPost::orderBy('created_at', 'DESC')->take(3)->get();
                    @endphp

                    @foreach ($blogs as $blog)
                        <div class="col-lg-4 col-md-6 mb-4">
                        <div class="latest-post">
                            <div class="latest-post-media">
                            <a target="_blank" href="{{ url('/blog/' . $blog->id) }}">
                                <img loading="lazy" class="img-fluid latest-post-img" src="{{ $blog->image }}" alt="img">
                            </a>
                            </div>
                            <div class="post-body">
                                <h2 class="post-title">
                                    <a target="_blank" href="{{ url('/blog/' . $blog->id) }}" class="d-inline-block">
                                        {{ $blog->title }}
                                    </a>
                                </h2>
                                <div class="latest-post-meta">
                                    <p>{{ $blog->resume }}</p>
                                    <span class="post-item-date">
                                        <i class="las la-clock"></i> {{ \Carbon\Carbon::parse($blog->created_at)->format('M Y'); }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        </div>
                    @endforeach
                </div>
                @if (count($blogs) > 0)
                    <div class="text-center mt-4">
                        <a class="main-button" href="/blog" target="_blank">Ver Mais</a>
                    </div>
                @endif
            </section>
        </main>

        <!-- Footer -->
        <footer id="footer" class="footer bg-overlay">
            <!-- Footer Main -->
            <div class="footer-main">
              <div class="container">
                <div class="row justify-content-between">
                  <div class="col-lg-4 col-md-6 footer-widget footer-about">
                    <h3 class="widget-title">Sobre Nós</h3>
                    <img loading="lazy" width="200px" height="88px" class="footer-logo" src="{{ asset('img/logo-white.png') }}" alt="Logo contrastada FGT">
                    <p>
                        A essência da Fóros - Gestão Tributária
                        reside em oferecer segurança financeira
                        e excelência na gestão tributária, pautadas
                        pela honestidade, transparência e empatia.
                    </p>
                    <div class="footer-social">
                      <ul>
                        <li><a href="{{$instagramUrl}}" target="_blank" aria-label="Instagram"><i class="lab la-instagram"></i></a></li>
                        <li><a href="{{$linkedinUrl}}" target="_blank" aria-label="Linkedin"><i class="lab la-linkedin"></i></a></li>
                      </ul>
                    </div>
                  </div>

                  <div class="col-lg-4 col-md-6 footer-widget mt-5 mt-md-0">
                    <h3 class="widget-title">Contatos</h3>
                    <div class="footer-contacts">
                        <p class="contact-content"><strong><i class="las la-phone header-contact-icon"></i> Telefone:</strong> {{$whatsappNumber}}</p>
                        <p class="contact-content"><strong><i class="las la-thumbtack header-contact-icon"></i> Endereço:</strong> Rua Conceição, 233, Sala 916, Centro, Campinas SP, 13010-916, Brasil</p>
                        <p class="contact-content"><strong><i class="las la-envelope header-contact-icon"></i> Email:</strong> {{$email}}</p>
                    </div>
                  </div>

                  <div class="col-lg-3 col-md-6 mt-5 mt-lg-0 footer-widget">
                    <h3 class="widget-title">Serviços</h3>
                    <ul class="list-arrow">
                      <li><a href="/servicos">Consultoria Tributária</a></li>
                      <li><a href="/servicos">Recuperação de Créditos</a></li>
                      <li><a href="/servicos">Busca por Dívida Ativa</a></li>
                      <li><a href="/servicos">Regularização Fiscal</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- Copyright -->
            <div class="copyright">
                <span>Copyright &copy; {{ date('Y') }}, Desenhado &amp; Desenvolvido pela <em><a href="https://www.linkedin.com/company/orion-erp-solutions/" target="_blank">Orion</a></em></span>
            </div>
        </footer>

        <!-- Whatsapp Button -->
        <a href="{{$whatsappUrl}}" class="whatsapp-button" target="_blank">
            <img src="{{ asset('img/whatsapp-button.webp') }}" alt="Botão Whatsapp" width="60px" height="60px">
        </a>

        <!-- Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <!-- Script -->
        <script src="{{ asset('scripts/script.js') }}"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#contact-form').submit(function(event) {
                    event.preventDefault();

                    var formData = $(this).serialize();
                    var route = "{{ url('/lead') }}";

                    let form = this;

                    $.ajax({
                        url: route,
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            new Noty({
                                type: 'success',
                                text: 'Formulário enviado com sucesso! Entraremos em contato o mais rápido possível.'
                            }).show();

                            form.reset();
                        },
                        error: function(xhr, status, error) {
                            new Noty({
                                type: 'error',
                                text: 'Ocorreu um erro ao enviar o formulário. Por favor, tente novamente.'
                            }).show();
                        }
                    });
                });
            });
        </script>
    </body>
</html>
