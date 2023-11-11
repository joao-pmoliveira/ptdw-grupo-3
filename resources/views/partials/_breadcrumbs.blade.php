<ul class="breadcrumb my-4 bg-primary text-primary">
    @for ($i = 0; $i < count($crumbs); $i++)
        <li class="breadcrumb-item breadcrumb-txt {{$i == count($crumbs) - 1 ? 'active' : ''}}">
            <a href="{{url($crumbs[$i][1])}}">{{$crumbs[$i][0]}}</a>
        </li>
    @endfor
</ul>