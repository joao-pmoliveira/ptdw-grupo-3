<ul class="breadcrumb my-4 bg-primary text-primary">
    @foreach ($crumbs as $index => $crumb)
        <li class="breadcrumb-item breadcrumb-txt  @if($loop->last) active @endif" >
            <a href="{{url($crumb[1])}}">{{$crumb[0]}}</a>
        </li>
    @endforeach
</ul>