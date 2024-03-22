@php
    $whatsappUrl = 'https://contate.me/forosgt';    
    $whatsappNumber = '(19) 97127-6718';
    $instagramUrl = 'https://www.instagram.com/forosgt/';
    $linkedinUrl = 'https://www.linkedin.com/company/forosgestaotributaria';
    $email = 'contato@forosgt.com.br';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FGT - Serviços</title>

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('css/services.css') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Line Awesome Icons -->
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
</head>
<body>
    <!-- Header -->
    <header id="main-header">
        <figure id="image-figure">
            <img src="" id="services-bg" alt="Imagem de fundo página de serviços">
        </figure>
        <a href="/" class="main-link"><i class="las la-arrow-left"></i> Voltar ao Início</a>
        <h1>Nossos Serviços</h1>
        <a href="{{$whatsappUrl}}" target="_blank" class="secondary-button">Entrar em Contato</a>
    </header>

    <main>
        <!-- Services -->
        <div class="service">
            <div class="service-left-content">
                <small>Nós oferecemos</small>
                <h3>
                    Consultoria Tributária <br>
                    <strong>Personalizada</strong>
                </h3>
                <br>
                <p>
                    Na <em>Fóros - Gestão Tributária</em>, entendemos que lidar <br>
                    com questões tributárias pode ser desafiador e complexo <br>
                    para empresas de todos os tamanhos.
                    <br>
                    <br>
                    É por isso que oferecemos nossa <strong>Consultoria Tributária Personalizada</strong>, <br>
                    um serviço dedicado a ajudar empresas a otimizar suas  <br>
                    operações fiscais e minimizar riscos.
                </p>
                <br>
                <br>
                <a href="{{$whatsappUrl}}" class="main-button" target="_blank">Entrar em Contato</a>
            </div>
            <div class="service-right-content">
                <p>
                    <i class="las la-user-alt"></i> <span>Abordagem Personalizada</span> <br>
                    Abordagem sob medida para atender às necessidades <br> específicas de cada cliente.
                </p>
                <br>
                <br>
                <p>
                    <i class="las la-search"></i> <span>Análise Detalhada</span> <br>
                    Análise minuciosa da situação tributária da empresa para <br> identificar oportunidades de otimização.
                </p>
                <br>
                <br>
                <p>
                    <i class="las la-comment-dollar"></i> <span>Recomendações Estratégicas</span> <br>
                    Recomendações estratégicas para minimizar encargos <br> fiscais e maximizar a eficiência financeira.
                </p>
            </div>
        </div>

        <div class="service">
            <div class="service-left-content">
                <small>Nós oferecemos</small>
                <h3>
                    Recuperação de Valores Pagos a Título de Tributação Indevida ou a Maior
                </h3>
                <br>
                <p>
                    De acordo com dados do IBGE/Impostômetro, 95% das empresas <br>
                    pagam impostos em excesso devido à complexidade da <br>
                    legislação tributária brasileira. Isso resulta em desembolsos que excedem o valor devido.
                    <br>
                    <br>
                    Você já parou para pensar quanto dinheiro sua empresa pode estar deixando <br>
                    na mesa devido a créditos tributários não aproveitados? <br>
                    Imagine ter a oportunidade de recuperar esses recursos e direcioná-los <br>
                    para impulsionar o crescimento do seu negócio.
                    <br>
                    <br>
                    Com a equipe especializada da FGT ao seu lado, essa realidade está mais próxima do que você imagina.
                </p>
                <br>
                <br>
                <a href="{{$whatsappUrl}}" class="main-button" target="_blank">Entrar em Contato</a>
            </div>
            <div class="service-right-content">
                <p>
                    <i class="las la-certificate"></i> <span>Especializados</span> <br>
                    Especializados em recuperar créditos fiscais não utilizados ou indevidamente cobrados.
                </p>
                <br>
                <br>
                <p>
                    <i class="las la-thumbtack"></i> <span>Avaliação Minuciosa</span> <br>
                    Avaliação detalhada de registros e transações para identificar oportunidades de recuperação.
                </p>
                <br>
                <br>
                <p>
                    <i class="las la-phone"></i> <span>Assessoria</span> <br>
                    Assessoria no processo de reivindicação de créditos junto <br> aos órgãos competentes.
                </p>
            </div>
        </div>

        <div class="service">
            <div class="service-left-content">
                <small>Nós oferecemos</small>
                <h3>Busca de Dívida Ativa Tributária </h3>
                <br>
                <p>
                    Oferecemos uma ferramenta exclusiva projetada especificamente <br>
                    para ajudar empresas a gerenciar e regularizar suas <br>
                    obrigações tributárias de forma eficiente e oportuna.
                    <br>
                    <br>
                    Com esta ferramenta poderosa, oferecemos uma abordagem <br> 
                    proativa para lidar com dívidas pendentes junto aos órgãos fiscais.
                </p>
                <br>
                <br>
                <a href="{{$whatsappUrl}}" class="main-button" target="_blank">Entrar em Contato</a>
            </div>
            <div class="service-right-content">
                <p>
                    <i class="las la-tools"></i> <span>Ferramenta Exclusiva</span> <br>
                    Permite às empresas verificar ativamente suas dívidas tributárias.
                </p>
                <br>
                <br>
                <p>
                    <i class="las la-stopwatch"></i> <span>Identificação Rápida</span> <br>
                    Identificação rápida e precisa de débitos pendentes <br> junto aos órgãos fiscais.
                </p>
                <br>
                <br>
                <p>
                    <i class="las la-file-alt"></i> <span>Relatórios Detalhados</span> <br>
                    Relatórios detalhados e orientações sobre as <br> melhores estratégias para regularização.
                </p>
            </div>
        </div>

        <div class="service">
            <div class="service-left-content">
                <small>Nós oferecemos</small>
                <h3>
                    Assessoria na <br>
                    Regularização Fiscal
                </h3>
                <br>
                <p>
                    A Assessoria na Regularização Fiscal oferecida pela <em>FGT</em> <br>
                    é uma solução completa e personalizada para empresas que buscam <br>
                    regularizar sua situação fiscal de forma eficaz e sem complicações. <br>
                    <br>
                    Com nossa equipe de especialistas, estamos aqui para ajudá-lo <br>
                    a navegar pelo complexo cenário tributário e garantir <br>
                    que sua empresa esteja em conformidade com todas as obrigações fiscais.
                </p>
                <br>
                <br>
                <a href="{{$whatsappUrl}}" class="main-button" target="_blank">Entrar em Contato</a>
            </div>
            <div class="service-right-content">
                <p>
                    <i class="las la-comment-dots"></i> <span>Orientação Técnica</span> <br>
                    Orientação técnica e profissional para empresas em <br> processo de regularização fiscal.
                </p>
                <br>
                <br>
                <p>
                    <i class="las la-file-invoice-dollar"></i> <span>Planos de Pagamento</span> <br>
                    Elaboração de planos de pagamento e negociação <br> de débitos junto aos órgãos fiscais.
                </p>
                <br>
                <br>
                <p>
                    <i class="las la-hands-helping"></i> <span>Acompanhamento Contínuo</span> <br>
                    Acompanhamento contínuo para garantir a conformidade <br> e evitar futuros problemas.</p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer id="footer" class="footer bg-overlay">
        <!-- Footer Main -->
        <div class="footer-main">
            <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-4 col-md-6 footer-widget footer-about">
                <h3 class="widget-title">Sobre Nós</h3>
                <img loading="lazy" width="200px" class="footer-logo" src="{{ asset('img/logo-white.png') }}" alt="Constra">
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

    {{-- Whatsapp Button --}}
    <a href="{{$whatsappUrl}}" class="whatsapp-button" target="_blank">
        <img src="{{ asset('img/whatsapp-button.webp') }}" alt="Botão Whatsapp" width="60px" height="60px">
    </a>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>