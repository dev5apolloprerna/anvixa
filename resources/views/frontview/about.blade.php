@extends('layouts.front')
@section('title', 'About Us')
@section('content')

    <!-- Orange Header -->
    <section class="py-5 text-white text-center" style="background: linear-gradient(90deg, #ff7b00, #ff4500);">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2" data-aos="fade-up">About Us</h1>
            <p class="lead text-white-50" data-aos="fade-up" data-aos-delay="200">
                Reflective inquiry. Evidence-based understanding. Sustainable health impact.
            </p>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="300">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('front.index') }}"
                            class="text-white text-decoration-underline">Home</a>
                    </li>
                    <li class="breadcrumb-item active text-white" aria-current="page">About</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Our Story Section -->
    <!-- Our Story Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1551836022-4c4c79ecde51?auto=format&fit=crop&w=1200&q=80"
                        class="img-fluid rounded-4 shadow-lg" alt="Our Story - Team Collaboration">
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <h3 class="fw-bold text-danger mb-4">Our Story</h3>
                    <ul class="list-unstyled text-muted fs-5">
                        <li class="mb-3"><i class="fas fa-circle text-orange me-2 small"></i>
                            <strong>Anviksha (अन्वीक्षा)</strong> means reflective inquiry, analysis, and evidence-based
                            understanding.
                        </li>
                        <li class="mb-3"><i class="fas fa-circle text-orange me-2 small"></i>
                            We are a team of public health professionals and community physicians committed to strengthening
                            health
                            systems through research, capacity building, and community engagement.
                        </li>
                        <li class="mb-3"><i class="fas fa-circle text-orange me-2 small"></i>
                            Our work goes beyond treating illness — we focus on understanding communities, identifying
                            health needs,
                            and designing evidence-based solutions.
                        </li>

                    </ul>
                </div>
                <div class="col-12 mt-4" data-aos="fade-up">
                    <ul class="list-unstyled text-muted fs-5">
                        <li class="mb-3"><i class="fas fa-circle text-orange me-2 small"></i>
                            We combine academic rigor with field insights to transform health programs and policies into
                            measurable
                            impact.
                        </li>
                        <li><i class="fas fa-circle text-orange me-2 small"></i>
                            Anviksha was born out of a simple question: <em>“How do we make preventive and social medicine
                                truly
                                visible and impactful?”</em>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <!-- Vision and Mission Section -->
    <section class="py-5">
        <div class="container text-center" data-aos="fade-up">
            <h2 class="fw-bold text-primary mb-4">Our Vision & Mission</h2>
            <p class="lead text-muted mb-5">To make preventive and social medicine more visible, relevant, and
                action-oriented
                through evidence, empathy, and collaboration.</p>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-lg rounded-4 h-100">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-orange mb-3"><i class="fas fa-eye me-2"></i>Our Vision</h4>
                            <p class="text-muted mb-0">A society where health systems are strengthened by reflective
                                learning,
                                evidence-based practice, and community participation — ensuring well-being for all.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-lg rounded-4 h-100">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-orange mb-3"><i class="fas fa-bullseye me-2"></i>Our Mission</h4>
                            <p class="text-muted mb-0">To bridge the gap between research and practice by nurturing public
                                health
                                professionals, supporting evidence-based programs, and engaging communities in meaningful
                                health action.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Info -->
    <section class="py-5 bg-light">
        <div class="container" data-aos="fade-up">
            <h3 class="fw-bold text-center text-danger mb-4">Contact Information</h3>
            <div class="row justify-content-center text-center">
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <i class="fas fa-phone fa-2x text-orange mb-3"></i>
                        <h5 class="fw-bold mb-2">Mobile Number</h5>
                        <p class="text-muted mb-0">+91 98765 43210</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <i class="fas fa-envelope fa-2x text-orange mb-3"></i>
                        <h5 class="fw-bold mb-2">Email ID</h5>
                        <p class="text-muted mb-0">info@anviksha.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
