<style>
   .fixed-sidebar {
    position: fixed;
    top: 100px;
    width: 250px;
    height: calc(100vh - 100px);
    overflow-y: auto;
    background-color: #f8f9fa;
    transition: transform 0.3s ease;
    transform: translateX(-250px); 
    transition: margin-left 0.3s ease;
    }

    .shifted {
    margin-left: 250px;
    transition: margin-left 0.3s ease;
    }

</style>

<aside class="fixed-sidebar" id="sidebar" style="transform: translateX(-250px); position: fixed; top: 5; left: 0;">
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


<script>
     function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        if (sidebar.style.transform === 'translateX(0px)') {
            sidebar.style.transform = 'translateX(-250px)';
            content.style.marginLeft = '0'; 
        } else {
            sidebar.style.transform = 'translateX(0px)'; 
            content.style.marginLeft = '250px';
        }
    }
</script>