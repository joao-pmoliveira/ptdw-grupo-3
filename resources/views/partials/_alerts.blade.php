<div id="alerts">
    @if (session('alerta'))
        <div class="alert alert-dismissible fade show bg-alert" role="alert">
            @if (is_array(session('alerta')))
            @foreach (session('alerta') as $message)
                <p>
                    <i class="fa-solid fa-x"></i>
                    {{$message}}
                </p>
            @endforeach
            @else
                <p>
                    <i class="fa-solid fa-x"></i>
                    {{session('alerta')}}
                </p>
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="fa-solid fa-x"></i>
            </button> 
        </div>
    @endif

    @if (session('sucesso'))
        <div class="alert alert-dismissible fade show bg-accent" role="alert">
            @if (is_array(session('sucesso')))
            @foreach (session('sucesso') as $message)
                <p>
                    <i class="fa-solid fa-check"></i>
                    {{$message}}
                </p>
            @endforeach
            @else
                <p>
                    <i class="fa-solid fa-check"></i>
                    {{session('sucesso')}}
                </p>
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="fa-solid fa-x"></i>
            </button> 
        </div>
    @endif
</div>