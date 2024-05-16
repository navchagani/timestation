@include('layouts.welcome')

    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links color-white">
            @auth
            <a href="{{ url('/admin') }}">Admin</a>
            @else
            <a style="color: white" href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif

            <div class="wrapper-page">
                <div class="card overflow-hidden account-card mx-4 shadow">


                </div>


            </div>
    </div>

