<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item d-flex justify-content-center">
    <div class="groupTitle"><b>ADM</b></div>
</li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('blog-post') }}'><i class="nav-icon las la-blog"></i> Blog Posts</a></li>

@if (backpack_user()->can('access_administrative'))
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon las la-key"></i> Autenticação
        </a>
        <ul class="nav-dropdown-items">
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class="nav-icon las la-user"></i> Usuários</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('role') }}'><i class="nav-icon las la-users"></i> Grupos</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('permission') }}'><i class="nav-icon las la-key"></i> Permissões</a></li>
        </ul>
    </li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'><i class='nav-icon la la-cog'></i> <span>Configurações</span></a></li>
    <li class='nav-item'><a class='nav-link' href={{ '/' . config('horizon.path') }}><i class='nav-icon la la-server'></i> <span>Horizon</span></a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i class='nav-icon la la-terminal'></i> Logs</a></li>
@endif

@if (backpack_user()->can('access_integration'))
    <li class="nav-item d-flex justify-content-center">
        <div class="groupTitle"><b>CRM</b></div>
    </li>
    
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('lead') }}'><i class="nav-icon las la-bullhorn"></i> Leads</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('contact') }}'><i class="nav-icon las la-phone"></i> Contatos</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('company') }}'><i class="nav-icon las la-city"></i> Empresas</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('oportunity') }}'><i class="nav-icon las la-thumbtack"></i> Oportunidades</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('task') }}'><i class="nav-icon las la-tasks"></i> Tarefas</a></li>
@endif

@if (backpack_user()->can('access_administrative'))
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('product') }}'><i class="nav-icon las la-archive"></i> Produtos</a></li>
@endif

<li class="nav-item d-flex justify-content-center">
    <div class="groupTitle"><b>DATA MINE</b></div>
</li>

@if (backpack_user()->can('access_administrative'))
    <li class='nav-item'><a class='nav-link' href='{{ route('datamine-file') }}'><i class="nav-icon las la-archive"></i> Arquivo</a></li>
@endif

@if (backpack_user()->can('access_integration'))
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('datamine/raw') }}'><i class='nav-icon la la-archive'></i> Dívidas Abertas</a></li>

    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('datamine/entity') }}'><i class='nav-icon la la-industry'></i> Entidades</a></li>
@endif