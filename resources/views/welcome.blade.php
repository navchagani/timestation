@include('layouts.welcome')

@extends('layouts.master-blank')

@section('content')
    @if (Route::has('login'))
        <div class="top-right links color-white">
            @auth
                <a href="{{ url('/admin') }}">Admin</a>
            @else
                <a style="color: blue" href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif
    <div class="wrapper-page">
        <div class="card overflow-hidden account-card mx-4 shadow">

            <div class="account-card-content">
                <img src="{{ asset('assets/images/opalpayfull.png') }}" alt="Logo" class="img-fluid">

            </div>
        </div>


    </div>
    <!-- end wrapper-page -->
@endsection

@section('script')
@endsection

