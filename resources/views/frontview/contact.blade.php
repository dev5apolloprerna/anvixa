@extends('layouts.front')
@section('title', 'Contact Us')
@section('content')

    <!-- Modern Contact Section with Background -->
    <section class="contact-modern position-relative py-5"
        style="background: url('https://images.pexels.com/photos/3183197/pexels-photo-3183197.jpeg?auto=compress&cs=tinysrgb&w=1200')
  center/cover no-repeat; min-height: 100vh; display: flex; align-items: center; justify-content: center;">

        <!-- Overlay for dark tint -->
        <div class="position-absolute top-0 start-0 w-100 h-100"
            style="background: rgba(0,0,0,0.55); backdrop-filter: blur(4px);"></div>

        <!-- Contact Card -->
        <div class="container position-relative" data-aos="zoom-in">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card shadow-lg border-0 rounded-4 p-4 p-md-5"
                        style="background: rgba(255, 255, 255, 0.92); backdrop-filter: blur(10px);">
                        <h3 class="fw-bold text-center text-danger mb-3">Get in Touch</h3>
                        <p class="text-center text-muted mb-4">We’d love to hear from you — drop us a message below.</p>

                        <form id="contactForm" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <input type="text" class="form-control rounded-3" id="name" placeholder="Your Name"
                                    required>
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input type="email" class="form-control rounded-3" id="email"
                                    placeholder="your@email.com" required>
                                <div class="invalid-feedback">Please enter a valid email.</div>
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label fw-semibold">Subject</label>
                                <input type="text" class="form-control rounded-3" id="subject" placeholder="Subject"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label fw-semibold">Message</label>
                                <textarea class="form-control rounded-3" id="message" rows="4" placeholder="Write your message..." required></textarea>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-lg custom-btn-red fw-semibold" type="submit">
                                    <i class="fas fa-paper-plane me-2"></i> Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Info Row -->
            <div class="row justify-content-center text-center mt-5 text-white">
                <div class="col-md-3 mb-3">
                    <i class="fas fa-phone-alt fa-2x mb-2 text-orange"></i>
                    <h6 class="fw-bold">Call Us</h6>
                    <p class="mb-0">+91 98765 43210</p>
                </div>
                <div class="col-md-3 mb-3">
                    <i class="fas fa-envelope fa-2x mb-2 text-orange"></i>
                    <h6 class="fw-bold">Email</h6>
                    <p class="mb-0">info@anviksha.org</p>
                </div>
                <div class="col-md-3 mb-3">
                    <i class="fas fa-map-marker-alt fa-2x mb-2 text-orange"></i>
                    <h6 class="fw-bold">Address</h6>
                    <p class="mb-0">Pune, Maharashtra, India</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Map -->
    <section class="map-section">
        <div class="container-fluid px-0" data-aos="fade-up">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3770.929318358743!2d72.87765527500473!3d19.072577782125563!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c87d71f4e61b%3A0xb648c40f777c0b4e!2sTech%20Street%2C%20Mumbai!5e0!3m2!1sen!2sin!4v1698981012085!5m2!1sen!2sin"
                width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

@endsection
