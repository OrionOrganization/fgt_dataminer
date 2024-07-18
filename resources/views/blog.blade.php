@php
    $whatsappUrl = 'https://contate.me/forosgt';
    $whatsappNumber = '(19) 97121-6718';
    $instagramUrl = 'https://www.instagram.com/forosgt/';
    $linkedinUrl = 'https://www.linkedin.com/company/forosgestaotributaria';
    $email = 'contato@forosgt.com.br';
@endphp

<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>FGT - Blog</title>
 
    {{-- Style --}}
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">

    <!-- Bootstrap -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <noscript><link rel="stylesheet" href="styles.css"></noscript>

    <!-- Line Awesome Icons -->
    <link rel="preload" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="styles.css"></noscript>
</head>
<body>
    <!-- Header -->
    <header id="main-header">
        <div id="header-content">
            <a href="/">
                <img src="{{ asset('img/logo.svg') }}" alt="Logo FGT (Fóros Gestão Tributária)" id="header-logo" width="140px" height="75px">
            </a>
            <h1 id="header-title">Blog & Notícias</h1>
            <a  id="header-cta" href="{{ $whatsappUrl }}" target="_blank" class="main-button">Conhecer</a>
        </div>
    </header>
    <hr>

    <main>
        <div id="main-posts-container">
            <!-- Main Blog Post -->
            @php
                $mainPost = \App\Models\BlogPost::latest()->first();
                $postUrl = url('/blog/' . $mainPost->id);
            @endphp
            @if ($mainPost)
                <section id="main-post">
                    <a href="{{ $postUrl }}">
                        <img src="{{ $mainPost->image }}" alt="Imagem de capa do post">
                    </a>
                    <p class="post-item-date">
                        <i class="las la-clock"></i> {{ \Carbon\Carbon::parse($mainPost->created_at)->format('d M Y'); }} |
                        <i class="las la-eye"></i> {{ $mainPost->views }}
                    </p>
                    <h2>
                        <a
                            href="{{ $postUrl }}"
                            class="post-item-title">
                            {{ $mainPost->title }}
                        </a>
                    </h2>
                    <p id="main-post-resume">
                        {{ $mainPost->resume }}
                    </p>
                </section>
            @else
                <h1 class="m-auto">Nenhum post encontrado</h1>
            @endif

            <!-- Secondary Blog Post -->
            @php
                $secondaryPost = \App\Models\BlogPost::latest()->get()->skip(1)->first();
            @endphp
            @if ($secondaryPost)
                @php
                    $postUrl = url('/blog/' . $secondaryPost->id);
                @endphp
                <section id="secondary-post">
                    <a href="{{ $postUrl }}">
                        <img src="{{ $secondaryPost->image }}" alt="Imagem de capa do post">
                    </a>
                    <p class="post-item-date">
                        <i class="las la-clock"></i> {{ \Carbon\Carbon::parse($secondaryPost->created_at)->format('d M Y'); }} |
                        <i class="las la-eye"></i> {{ $secondaryPost->views }}
                    </p>
                    <h3>
                        <a
                            href="{{ $postUrl }}"
                            class="post-item-title">
                            {{ $secondaryPost->title }}
                        </a>
                    </h3>
                    <p id="secondary-post-resume">{{ $secondaryPost->resume }}</p>
                </section>
            @endif
        </div>

        <!-- All Blogs -->
        @php
            $blogs = \App\Models\BlogPost::orderBy('created_at', 'DESC')
                ->get()
                ->skip(2);
        @endphp
        <section id="all-blogs">
            @foreach ($blogs as $blog)
                <div class="blog-post-container">
                    <a href="{{ url('/blog/' . $blog->id) }}">
                        <img loading="lazy" class="" src="{{ $blog->image }}" alt="img">
                    </a>
                    <div>
                        <a href="{{ url('/blog/' . $blog->id) }}">
                            <h3>{{ $blog->title }}</h3>
                        </a>
                        <p>{{ $blog->resume }}</p>
                        <span>
                            <i class="las la-clock"></i> {{ \Carbon\Carbon::parse($mainPost->created_at)->format('d M Y'); }}
                            | <i class="las la-eye"></i> {{ $blog->views }}
                        </span>
                    </div>
                </div>
            @endforeach
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
</body>
</html>