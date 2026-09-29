@extends('layouts.front')
@section('title', 'Thank You')

@section('content')

    <!-- Orange Header -->
    <section class="py-5 text-white text-center" style="background: linear-gradient(90deg, #ff7b00, #ff4500);">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2" data-aos="fade-up">Thank You</h1>
            <p class="lead text-white-50" data-aos="fade-up" data-aos-delay="200">
                Reflective inquiry. Evidence-based understanding. Sustainable health impact.
            </p>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="300">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('front.index') }}"
                            class="text-white text-decoration-underline">Home</a>
                    </li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Thank You</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="section-padding thank-you">
        <div class="container-fluid">

            <div class="row px-xl-5 justify-content-between d-flex">
                <div class="col-lg-4 thank-you-img ">
                    <img src="{{ asset('assets/front/img/thankyou.png') }}" alt="Thank You" class="img-fluid">
                </div>
                <div class="col-lg-6">
                    <h2 class="text-pink">Thank You for Connecting with Anviksha</h2>
                    <p>
                        We appreciate your interest in <strong>Anviksha</strong>. Your message has been received,
                        and our team will get back to you shortly.
                    </p>

                </div>
            </div>
        </div>
    </section>

@endsection
