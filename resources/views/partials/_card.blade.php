<div class="card p-4 gap-4 rounded-0 ">
    <div class="card-header m-0 p-0">
        <h2>{{$title ?? 'Título ñ definido'}}</h2>
    </div>
    <div class="card-body m-0 p-0 d-flex flex-column gap-2 text-terciary ">
        @foreach ($body as $p)
            <p>{{$p}}</p>
        @endforeach
    </div>
    <div class="card-footer m-0 p-0">
        <a class="btn" href="{{ url($url) }}">{{$button}}</a>
    </div>
</div>
