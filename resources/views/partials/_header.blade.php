<div id="header" class="container-fluid d-flex align-items-center px-5 py-3 gap-4 bg-accent">
    <div id="menu-btn" class="{{$sidebar ? '' : 'invisible'}}" onclick= "toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </div>
    <a class="img-wrapper" href="{{route('inicio.view')}}">
        <img src="{{ asset('img/Logo.png') }}" alt="">
    </a>
    <div id="titulo-pagina-inicial">
        <p>Suporte à Criação de Horários</p>
    </div>
</div>