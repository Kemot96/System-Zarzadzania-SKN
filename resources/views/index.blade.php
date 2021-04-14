<div>
@foreach($clubs as $club)
        <div><a href="{{ route('clubMainPage', ['club' => $club])}}">{{$club->name}}</a></div>
        <a href="{{ route('clubMainPage', ['club' => $club])}}"><img src="{{ asset('storage/' . $club->icon) }}"
             alt=""
             style=""
             width="150"
            ></a>
    @endforeach
</div>
