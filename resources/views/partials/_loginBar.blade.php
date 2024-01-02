<style>
       #login-bar{
            background-color: white;
        }
    </style>


<ul id="login-bar" class="d-flex justify-content-end px-5 py-2 gap-2 login-txt text-accent">
    <li>
        {{$user ? $user->email : 'user'}}
    </li>
    <li>|</li>
    <li>
        <form action="{{route('logout.action')}}" method="POST">
            @csrf
            <button type="submit" class="bg-transparent border-0">sair</button>
            {{-- <a href="#" onclick="event.preventDefault()" id="logout-btn">sair</a> --}}
            
        </form>
    </li>
    <li><i class="fa-solid fa-user"></i></li>
</ul>

