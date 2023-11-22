<aside class="">
    <ul class="h-100 m-0 p-0 d-flex flex-column flex-shrink-0 px-5 py-4 gap-4 bg-secondary">
        <li>
            <a class="{{Request::is('inicio') ? 'active' : ''}}" href="{{url('/inicio')}}">Página Inicial</a>
        </li>
        <li>
            <a class="{{Request::is('ucs') ? 'active' : ''}}" href="{{url('/ucs')}}">Unidades Curriculares</a>
        </li>
        <li>
            <a class="{{Request::is('restrições') ? 'active' : ''}}" href="{{url('/restricoes')}}">Preencher Restrições</a>
        </li>
        <li>
            <a class="{{Request::is('processos') ? 'active' : ''}}" href="{{url('/processos')}}">Gerir Processos</a>
        </li>
        <li>
            <a class="{{Request::is('gerir') ? 'active' : ''}}" href="{{url('/gerir')}}">Gerir Dados</a>
        </li>
        <li>
            <a class="" href="">Ajuda</a>
        </li>
    </ul>
</aside>