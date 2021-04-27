@if (Route::has('login'))
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        @auth
            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
            <a href="{{ url('/admin/users') }}" class="text-sm text-gray-700 underline">Panel administatora</a>
        @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
            @endif
        @endauth
    </div>
@endif
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
