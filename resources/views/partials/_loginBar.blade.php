<ul id="login-bar" class="d-flex justify-content-end px-5 py-2 gap-2 login-txt text-accent bg-primary">
    <li>
        <a href="{{route('perfil.view')}}">{{$user ? $user->nome : 'user'}}</a>
    </li>
    <li>|</li>
    <li>
        <form action="{{route('logout.action')}}" method="POST">
            @csrf
            <button type="submit" class="bg-transparent border-0">sair</button>
        </form>
    </li>
    <li><i class="fa-solid fa-user"></i></li>
</ul>

