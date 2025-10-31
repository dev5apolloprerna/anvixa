@extends('layouts.front')
@section('title', 'Home')
@section('content')

    <header class="hero-banner text-center position-relative">

        <video autoplay muted loop id="video-bg" class="hero-img-bg">
            <source src="{{ asset('assets/front/img/banner-video.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="hero-content-overlay py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 text-start" data-aos="fade-up">
                        <h1 class="display-3 fw-bold text-white mb-3" data-aos="fade-right" data-aos-delay="200">
                            From Insight to Impact
                        </h1>
                        <p class="lead text-white-50 mb-4" data-aos="fade-left" data-aos-delay="400">
                            Anviksha empowers health systems through knowledge, evidence, and community engagement.
                        </p>
                        <div class="cta-buttons" data-aos="zoom-in" data-aos-delay="600">
                            <a href="#" target="_blank" class="btn btn-primary  custom-btn-red me-3">
                                Explore Services
                            </a>
                            <a href="#" class="btn btn-outline-light  custom-btn-outline-orange">
                                About Us &rarr;
                            </a>
                            <a href="#" class="btn btn-outline-light custom-btn-outline-orange mt-2 mt-md-0">
                                View All Videos & Resources &rarr;
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </header>

    <section class="impact-counters py-5 position-relative">
        <div class="impact-bg-overlay"></div>
        <div class="container position-relative">
            <h2 class="text-center  mb-5 section-title" data-aos="fade-up">Quick Highlights</h2>
            <div class="row text-center text-white">

                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="impact-card p-4">
                        <i class="fas fa-video fa-3x mb-3 "></i>
                        <div class="counter-value display-4 fw-bold" data-target="150" id="counter1">0</div>
                        <p class="lead mb-0">Video Lectures Delivered</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="impact-card p-4">
                        <i class="fas fa-microphone-alt fa-3x mb-3 "></i>
                        <div class="counter-value display-4 fw-bold" data-target="250" id="counter2">0</div>
                        <p class="lead mb-0">Podcast Episodes Released</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="300">
                    <div class="impact-card p-4">
                        <i class="fas fa-flask fa-3x mb-3 "></i>
                        <div class="counter-value display-4 fw-bold" data-target="330" id="counter3">0</div>
                        <p class="lead mb-0">Research Projects Supported</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="400">
                    <div class="impact-card p-4">
                        <i class="fas fa-hands-helping fa-3x mb-3 "></i>
                        <div class="counter-value display-4 fw-bold" data-target="275" id="counter4">0</div>
                        <p class="lead mb-0">Community Activities Conducted</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="card-spotlight py-5 position-relative">
        <div class="container">
            <h2 class="text-center mb-5 text-white section-title" data-aos="fade-up">Our Top Video, Podcast, and
                Community
                Spotlight.</h2>
            <div class="row">

                <!-- 🎥 Video Lecture Card -->
                <div class="col-lg-4 mb-4" data-aos="flip-left" data-aos-delay="100">
                    <div class="spotlight-card">
                        <div class="spotlight-img-wrapper">
                            <img src="https://cdn.prod.website-files.com/65e89895c5a4b8d764c0d70e/671f609afb2bddf96eaa518a_e49f04c1-ab78-4f34-9680-73fefb69127a.jpeg"
                                class="card-img-top" alt="Latest Video Lecture">
                            <div class="spotlight-overlay">
                                <i class="fas fa-play-circle fa-3x text-white"></i>
                            </div>
                        </div>
                        <div class="spotlight-body">
                            <h5 class="card-title text-danger">🎬 Video Lecture</h5>
                            <p class="card-text fw-bold">Basics of Public Health Research</p>
                            <a href="#" class="btn spotlight-btn-red">
                                <i class="fas fa-play me-2"></i> Watch Full Library
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 🎧 Podcast Card -->
                <div class="col-lg-4 mb-4" data-aos="flip-left" data-aos-delay="200">
                    <div class="spotlight-card">
                        <div class="spotlight-img-wrapper">
                            <img src="https://media.istockphoto.com/id/1330934437/photo/radio-interview-podcast-recording-business-people-talking-in-broadcasting-studio.jpg?s=612x612&w=0&k=20&c=q_PyqMSyaa4yIk0LKYQt4vISuEBrNLRIMgfXwG4F_nQ="
                                class="card-img-top" alt="Featured Podcast Episode">
                            <div class="spotlight-overlay">
                                <i class="fas fa-headphones fa-3x text-white"></i>
                            </div>
                        </div>
                        <div class="spotlight-body">
                            <h5 class="card-title text-warning">🎧 Podcast Episode</h5>
                            <p class="card-text fw-bold">Preventive Medicine in Today's India</p>
                            <a href="#" class="btn spotlight-btn-orange">
                                <i class="fas fa-headphones-alt me-2"></i> Full Podcast Library
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 🤝 Community Activity Card -->
                <div class="col-lg-4 mb-4" data-aos="flip-left" data-aos-delay="300">
                    <div class="spotlight-card">
                        <div class="spotlight-img-wrapper">
                            <img src="https://www.apple.com/newsroom/images/product/services/standard/Apple-Community-Education-Initiative-students-thumbs-up_big.jpg.large.jpg"
                                class="card-img-top" alt="Community Activity Spotlight">
                            <div class="spotlight-overlay">
                                <i class="fas fa-handshake fa-3x text-white"></i>
                            </div>
                        </div>
                        <div class="spotlight-body">
                            <h5 class="card-title text-success">🤝 Community Activity</h5>
                            <p class="card-text fw-bold">Adolescent Nutrition Awareness Drive</p>
                            <a href="#" class="btn spotlight-btn-green">
                                <i class="fas fa-images me-2"></i> Photo/Video Gallery
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Newsletter Section -->
    <section class="newsletter-hero position-relative overflow-hidden">
        <div class="newsletter-bg position-absolute top-0 start-0 w-100 h-100"></div>

        <div class="container position-relative py-5 py-md-5">
            <!-- Eyebrow -->

            <div class="row g-4 align-items-center mx-auto">
                <div class="col-12 text-center">
                    <h2 class=" fw-bold  mb-0">Subscribe for updates on our podcasts, video lectures,
                        and community work.</h2>
                </div>
            </div>
            <div class="row ">
                <div class="col-12 col-lg-7 mx-auto mt-3">
                    <form id="newsletterForm" class="newsletter-form needs-validation" novalidate>
                        <div class="d-flex align-items-stretch newsletter-pill">
                            <input type="email" class="form-control newsletter-input"
                                placeholder="Enter Your Email ......." aria-label="Email address" required />
                            <button class="btn newsletter-btn" type="submit">
                                SUBSCRIBE NOW
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
