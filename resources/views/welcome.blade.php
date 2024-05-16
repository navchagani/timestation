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

    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1 data-aos="fade-up" class="">Welcome to <span>Opal Time Card</span></h1>
        <p data-aos="fade-up" data-aos-delay="100" class="">Revolutionizing Attendance Tracking: Empowering Efficiency and Engagement<br></p>
        <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('login') }}" class="btn-get-started">Login</a>
            {{--<a href="#" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
       --}} </div>
        <img src="{{ asset('assets/images/hero-services-img.webp') }}" class="img-fluid hero-img" alt="" data-aos="zoom-out" data-aos-delay="300">
    </div>
    <div class="wrapper-page">
        {{--<div class="card overflow-hidden account-card mx-4 shadow">

            <div class="account-card-content">
                <img src="{{ asset('assets/images/opalpayfull.png') }}" alt="Logo" class="img-fluid">

            </div>

        </div>--}}


    </div>
    <!-- Features Section -->
    <section id="features" class="features section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2 class="">Features</h2>
            <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container">
            <div class="row justify-content-between">

                <div class="col-lg-5 d-flex align-items-center">

                    <ul class="nav nav-tabs" data-aos="fade-up" data-aos-delay="100">
                        <li class="nav-item">
                            <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
                                <i class="bi bi-binoculars"></i>
                                <div>
                                    <h4 class="d-none d-lg-block">Modi sit est dela pireda nest</h4>
                                    <p>
                                        Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                                        velit esse cillum dolore eu fugiat nulla pariatur
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2">
                                <i class="bi bi-box-seam"></i>
                                <div>
                                    <h4 class="d-none d-lg-block">Unde praesenti mara setra le</h4>
                                    <p>
                                        Recusandae atque nihil. Delectus vitae non similique magnam molestiae sapiente similique
                                        tenetur aut voluptates sed voluptas ipsum voluptas
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3">
                                <i class="bi bi-brightness-high"></i>
                                <div>
                                    <h4 class="d-none d-lg-block">Pariatur explica nitro dela</h4>
                                    <p>
                                        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
                                        Debitis nulla est maxime voluptas dolor aut
                                    </p>
                                </div>
                            </a>
                        </li>
                    </ul><!-- End Tab Nav -->

                </div>

                <div class="col-lg-6">

                    <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

                        <div class="tab-pane fade active show" id="features-tab-1">
                            <img src="{{ asset('assets/images/tabs-1.jpg') }}" alt="" class="img-fluid">
                        </div><!-- End Tab Content Item -->

                        <div class="tab-pane fade" id="features-tab-2">
                            <img src="{{ asset('assets/images/tabs-2.jpgp') }}" alt="" class="img-fluid">
                        </div><!-- End Tab Content Item -->

                        <div class="tab-pane fade" id="features-tab-3">
                            <img src="{{ asset('assets/images/tabs-3.jpg') }}" alt="" class="img-fluid">
                        </div><!-- End Tab Content Item -->
                    </div>

                </div>

            </div>

        </div>

    </section><!-- /Features Section -->
    <!-- end wrapper-page -->
@endsection

@section('script')
@endsection
