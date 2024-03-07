<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Fóros - Gestão Tributária</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/landing_page.css') }}">

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- Line Awesome Icons -->
        <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    </head>
    <body>
         <!-- Header -->
        <header id="sub-header" class="display-flex-around">
            <div id="sub-header-contact">
                <i class="las la-phone header-contact-icon"></i> <span>+55 (35) 98455-8944</span>
                <i class="las la-envelope header-contact-icon"></i> <span>fgtgestao@gmail.com</span>
            </div>
            <div id="sub-header-socials">
                <a href="" class="header-social-link"><i class="lab la-facebook-square header-social-icon"></i></a>
                <a href="" class="header-social-link"><i class="lab la-instagram header-social-icon"></i></a>
                <a href="" class="header-social-link"><i class="lab la-google-plus header-social-icon"></i></a>
            </div>
        </header>
        <header id="main-header">
            <a href="#">
                <img src="{{ asset('img/logo.svg') }}" alt="Logo FGT (Fóros Gestão Tributária)" id="header-logo">
            </a>

            <nav>
                <a href="#" class="header-nav-link">Início</a>
                <a href="#about-section" class="header-nav-link">Sobre</a>
                <a href="#services-section" class="header-nav-link">Serviços</a>
                <a href="#contact-section" class="header-nav-link">Contato</a>

                <a href="" class="header-nav-button main-button">Conhecer</a>
            </nav>
        </header>

        <!-- Main -->
        <main>
            <!-- Carousel -->
            <section id="main-slider" class="carousel slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#main-slider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#main-slider" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#main-slider" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('img/carousel-pic-1.jpg') }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Gestão Tributária</h2>
                            <p>Gerenciamento, planejamento, análise, controle e acompanhamento</p>
                            <a href="" class="main-button">Quero Conhecer a FGT</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/carousel-pic-2.jpg') }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Recuperação de Créditos</h2>
                            <p>Visa reaver valores devidos e não pagos pelo inadimplente.</p>
                            <a href="" class="main-button">Quero Conhecer a FGT</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/carousel-pic-3.jpg') }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Busca de Dívida Tributária Ativa</h2>
                            <p>Encontre e solucione suas dívidas empresariais ativas.</p>
                            <a href="" class="main-button">Quero Conhecer a FGT</a>
                        </div>
                    </div>
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
                        Nosso compromisso é com a honestidade e transparência, <br>
                        guiando cada passo de nossa atuação empresarial.
                    </p>
                </blockquote>
                <figcaption class="blockquote-footer">
                Fóros Gestão Tributária
                </figcaption>
            </figure>

            <!-- About -->
            <section id="about-section" style="background-image: url({{ asset('img/about-bg.png') }});">
                <div id="about-container" class="container">
                    <div>
                        <h1>Sobre Nós</h1>
                        <figure>
                            <blockquote class="blockquote">
                                <p>
                                    A essência da Fóros - Gestão Tributária <br>
                                    reside em oferecer segurança financeira <br>
                                    e excelência na gestão tributária, pautadas<br>
                                    pela honestidade, transparência e empatia. 
                                </p>
                            </blockquote>
                            <figcaption class="blockquote-footer" style="color: var(--main-color);">
                            Marco Desiato, <cite title="Source Title">CEO da FGT</cite>
                            </figcaption>
                        </figure>
                        <a href="" class="main-button">Solicitar Orçamento</a>
                    </div>

                    <img src="{{ asset('img/about-pic.jpeg') }}" alt="Foto de Marco Desiato, CEO da FGT" id="about-image">
                </div>
            </section>

            <!-- History -->
            <section id="history-section" class="container">
                    <img src="{{ asset('img/history-pic.jpg') }}" alt="Foto da equipe da FGT">
                    <div>
                        <small style="color: var(--main-color);">Venha conhecer</small>
                        <h1 style="margin: 0;">Nossa História</h1>
                        <br>
                        <p>
                            A Fóros nasceu da visão empreendedora <br>
                            dos fundadores, que almejavam estabelecer um escritório <br>
                            especializado em fornecer <strong>soluções tributárias personalizadas <br>
                            e seguras para seus clientes.</strong><br>
                            <br>
        
                            Nosso compromisso é oferecer excelência na gestão fiscal, <br>
                            proporcionando <strong>confiança e tranquilidade aos empresários</strong> <br>
                            que buscam otimizar sua performance financeira. <br>
        
                            <br>
        
                            Contamos com uma equipe dedicada e especializada, <br>
                            pronta para transformar desafios tributários em oportunidades <br>
                            de crescimento para o seu negócio.
                        </p>
                    </div>
            </section>

            <!-- Team -->
            <section id="team-section">
                <div id="team-container">
                    {{-- Marco --}}
                    <div class="team-member-card">
                        <img src="{{ asset('img/lawyer-1.png') }}" alt="Foto do CEO da FGT, Marco Desiato">
                        <div class="overlay">
                            <span>
                                Formado em Engenharia da Computação pela Pontifícia Universidade Católica Campinas/SP.
                                MBA em gestão estratégica na FGV, MBA em Gestão em Ohio,
                                MBA em Design Think pela Inova-Campinas.
                            </span>
                        </div>
                        <div class="bottom-div">
                            <h5>Marco Desiato</h5>
                            <hr class="divisor">
                            <small>CEO</small>
                        </div>
                    </div>

                    {{-- Everton --}}
                    <div class="team-member-card">
                        <img src="{{ asset('img/lawyer-3.png') }}" alt="Foto do CRO da FGT, Everton Alves">
                        <div class="overlay">
                            <span>
                                Pós graduando em Direito Tributário e Processual Tributário pela Faculdade Alphaville (FAVI) 
                                Bacharel em Direito pela Universidade São Francisco de Campinas/SP (USF)
                            </span>
                        </div>
                        <div class="bottom-div">
                            <h5>Everton Alves</h5>
                            <hr class="divisor">
                            <small>CRO</small>
                        </div>
                    </div>

                    {{-- Fernanda --}}
                    <div class="team-member-card">
                        <img src="{{ asset('img/lawyer-4.png') }}" alt="Foto da CTO da FGT, Fernanda Guidotti">
                        <div class="overlay">
                            <span>
                                Doutoranda em Matemática Computacional pela Universidade de São Paulo (USP), 
                                Msc em Matemática Computacional pela Universidade de São Paulo (USP) e
                                Graduada em Processamento de Dados pela Faculdade de Tecnologia do Estado de São Paulo de Taquaritinga/SP (FATEC).
                            </span>
                        </div>
                        <div class="bottom-div">
                            <h5>Fernanda Guidotti</h5>
                            <hr class="divisor">
                            <small>CTO</small>
                        </div>
                    </div>

                    {{-- Victor --}}
                    <div class="team-member-card">
                        <img src="{{ asset('img/lawyer-2.png') }}" alt="Foto do CLO da FGT, Victor Dallacosta">
                        <div class="overlay">
                            <span>
                                Mestrando em Direito Tributário pela Pontifícia Universidade Católica de São Paulo (PUC-SP)
                                Pós-graduado em Direito Tributário e Processo Tributário pela Pontifícia Universidade Católica de São Paulo (PUC-SP).
                                Bacharel em Direito pela Universidade Presbiteriana Mackenzie de Campinas/SP.
                            </span>
                        </div>
                        <div class="bottom-div">
                            <h5>Victor Dallacosta</h5>
                            <hr class="divisor">
                            <small>CLO</small>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Values -->
            <section id="values-section">
                <div id="values-text-content">
                    <small>Descubra</small>
                    <h2>Nossos Valores</h2>

                    <div class="value-content">
                        <i class="las la-balance-scale values-icon"></i>
                        <div class="values-text">
                            <h3 class="values-name">Honestidade e Transparência</h3>
                            <p>
                                Atuamos com integridade em todas as interações, <br>
                                sendo transparentes em nossas práticas e decisões.
                            </p>
                        </div>
                    </div>
                    <div class="value-content">
                        <i class="las la-handshake values-icon"></i>
                        <div class="values-text">
                            <h3 class="values-name">Empatia e Comprometimento</h3>
                            <p>
                                Compreendemos as necessidades individuais de cada cliente, <br>
                                comprometendo-nos a superar obstáculos e oferecer suporte personalizado.
                            </p>
                        </div>
                    </div>
                    <div class="value-content">
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
                    <div class="value-content">
                        <i class="las la-globe values-icon"></i>
                        <div class="values-text">
                            <h3 class="values-name">Impacto Positivo</h3>
                            <p>
                                Contribuímos para a sociedade, ajudando as pessoas e as <br>
                                empresas a recuperarem créditos, superarem desafios tributários <br>
                                e alcançarem seus objetivos financeiros.
                            </p>
                        </div>
                    </div>
                </div>
                <div id="values-image-content">
                    <img src="{{ asset('img/values-pic.jpg') }}" alt="Foto de Marco Desiato">
                </div>
            </section>

            <!-- Services -->
            <section id="services-section">
                <small>Nossos Serviços</small>
                <h1>
                    Os melhores serviços tributários <br>
                    Para sua empresa
                </h1>

                <div id="services-container">
                    <div class="card text-center" style="width: 18rem;">
                        <div class="card-body">
                            <i class="service-icon las la-comments-dollar"></i>
                            <h5 class="card-title">Consultoria Tributária</h5>
                            <hr class="card-divisor">
                            <p class="card-text">Análise detalhada da situação tributária para identificar oportunidades de otimização.</p>
                            <a href="/servicos" class="main-button">Saiba Mais</a>
                        </div>
                    </div>
                    <div class="card text-center" style="width: 18rem;">
                        <div class="card-body">
                            <i class="service-icon las la-donate"></i>
                            <h5 class="card-title">Recuperação de Créditos</h5>
                            <hr class="card-divisor">
                            <p class="card-text">Avaliação minuciosa de registros e transações para identificar oportunidades de recuperação.</p>
                            <a href="/servicos" class="main-button">Saiba Mais</a>
                        </div>
                    </div>
                    <div class="card text-center" style="width: 18rem;">
                        <div class="card-body">
                            <i class="service-icon las la-balance-scale-right"></i>
                            <h5 class="card-title">Dívida Ativa</h5>
                            <hr class="card-divisor">
                            <p class="card-text">Ferramenta exclusiva que permite verificar ativamente suas dívidas tributárias.</p>
                            <a href="/servicos" class="main-button">Saiba Mais</a>
                        </div>
                    </div>
                    <div class="card text-center" style="width: 18rem;">
                        <div class="card-body">
                            <i class="service-icon las la-file-invoice-dollar"></i>
                            <h5 class="card-title">Regularização Fiscal</h5>
                            <hr class="card-divisor">
                            <p class="card-text">Orientação técnica e profissional para empresas em processo de regularização fiscal.</p>
                            <a href="/servicos" class="main-button">Saiba Mais</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact -->
            <section id="contact-section">
                <div class="contact-container">
                    <small>Contato</small>
                    <h1>Fale Conosco</h1>
                    <p>
                        Caso tenha alguma dúvida, entre em contato <br>
                        através de um dos nossos telefones ou email. <br>
                        Se tiver preferência, venha visitar nosso escritório!
                    </p>
        
                    <p class="contact-content"><strong><i class="las la-phone header-contact-icon"></i> Telefone:</strong> (19) xxxx-xxxx</p>
                    <p class="contact-content"><strong><i class="las la-thumbtack header-contact-icon"></i> Endereço:</strong> Av. Brasil, 510 - Campinas, SP</p>
                    <p class="contact-content"><strong><i class="las la-envelope header-contact-icon"></i> Comercial:</strong> comercial@forosgt.com.br</p>
                    <p class="contact-content"><strong><i class="las la-envelope header-contact-icon"></i> Suporte:</strong> suporte@forosgt.com.br</p>
                    <p class="contact-content"><strong><i class="las la-envelope header-contact-icon"></i> Financeiro:</strong> financeiro@forosgt.com.br</p>
                    <p class="contact-content"><strong><i class="las la-envelope header-contact-icon"></i> Jurídico:</strong> juridico@forosgt.com.br</p>

                    <p><a href="" class="main-button">Entrar em Contato</a></p>
                </div>

                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d470464.1371439109!2d-47.36069152620545!3d-22.894882111583403!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c8c8f6a2552649%3A0x7475001c58043536!2sCampinas%20-%20SP!5e0!3m2!1spt-BR!2sbr!4v1709683391445!5m2!1spt-BR!2sbr" width="50%" height="450" style="border: var(--main-color) 2px solid;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </section>
        </main>

        <!-- Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
