@extends('layouts.master-blank')

@section('content')
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

            <div class="account-card-content">
                <img src="{{ asset('assets/images/opalpayfull.png') }}" alt="Logo" class="img-fluid">

            </div>
            <div class="d-flex flex-column justify-content-center align-items-center">
                <h1 data-aos="fade-up" class="">Welcome to <span>Opal Time Card</span></h1>
                <p data-aos="fade-up" data-aos-delay="100" class="">Quickly start your project now and set the stage for success<br></p>
                <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                    <a href="#about" class="btn-get-started">Get Started</a>
                    <a href="#" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
                </div>
                <img src="{{ asset('assets/images/hero-services-img.webp') }}" class="img-fluid hero-img" alt="" data-aos="zoom-out" data-aos-delay="300">
            </div>
        </div>


    </div>
    <!-- end wrapper-page -->
@endsection

@section('script')
@endsection
