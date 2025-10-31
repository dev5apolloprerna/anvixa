@extends('layouts.front')
@section('title', 'Image & Community Gallery')
@section('content')

    <!-- Header -->
    <section class="py-5 text-white text-center" style="background: linear-gradient(90deg, #ff7b00, #ff4500);">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2" data-aos="fade-up">Resources & Media Library</h1>
            <p class="lead text-white-50" data-aos="fade-up" data-aos-delay="200">
                Explore our collection of lectures, podcasts, images, and reports — your one-stop hub for learning and
                community engagement.
            </p>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="300">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('front.index') }}"
                            class="text-white text-decoration-underline">Home</a>
                    </li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Resources & Media Library</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="py-5 bg-white resource-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="resource-sidebar p-4 shadow-sm rounded-4">
                        <h5 class="fw-bold text-danger mb-3 text-center">
                            <i class="fas fa-folder-open me-2"></i> Resources
                        </h5>
                        @include('frontview.tabview')
                    </div>
                </div>

                <div class="col-lg-9">

                    <div class="container" data-aos="fade-up">
                        <h3 class="fw-bold text-danger mb-4 text-center">📸 Image & Community Gallery</h3>
                        <p class="text-center text-muted ">Snapshots from awareness campaigns, health drives, and
                            youth engagement.</p>
                        <div class="row">
                            <div class="py-5 bg-light border-bottom">

                                <form id="filterForm">
                                    <div class="row justify-content-end g-3 align-items-end">

                                        <!-- Resource Type -->
                                        <div class="col-md-3">
                                            <select id="filterType" class="form-select">
                                                <option value="all">type of activity</option>
                                                <option value="video">health screenings</option>
                                                <option value="podcast">awareness campaigns</option>
                                                <option value="gallery">youth programs</option>

                                            </select>
                                        </div>
                                        <!-- Search Button (Themed) -->
                                        <div class="col-md-2 d-grid">
                                            <button type="button" id="searchBtn" class="btn custom-btn-red fw-semibold">
                                                <i class="fas fa-search me-2"></i>
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                        </div>


                        <div class="row g-3 justify-content-center" id="galleryList">

                            @foreach ($galleries as $gallery)
                                <div class="col-md-4 resource-item" data-topic="{{ $gallery->title }}">
                                    <img src="{{ asset('anvixa/' . $gallery->image) }}"
                                        class="img-fluid rounded-3 shadow-sm">
                                    <h5 class="mt-2 text-center">{{ $gallery->title }}</h5>
                                </div>
                            @endforeach

                        </div>

                        @if ($totalGallery > 1)
                            <div class="text-center mt-4">
                                <button id="loadMoreBtn" class="btn custom-btn-red px-4 py-2"
                                    data-skip="{{ count($galleries) }}">
                                    <i class="fas fa-images me-2"></i> View More
                                </button>
                            </div>
                        @endif



                    </div>
                </div>
            </div>
        </div>


    </section>

@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('#loadMoreBtn').click(function() {
                var skip = $(this).data('skip');
                var limit = 6;
                var btn = $(this);

                btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Loading...').prop('disabled', true);

                $.ajax({
                    url: "{{ route('front.loadMoreGallery') }}",
                    method: 'GET',
                    data: {
                        skip: skip,
                        limit: limit
                    },
                    success: function(response) {
                        if (response.galleries.length > 0) {
                            response.galleries.forEach(function(gallery) {
                                var galleryHtml = `
                        <div class="col-md-4 resource-item" data-aos="zoom-in" data-aos-delay="100">
                            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                                <img src="/anvixa/${gallery.image}" class="img-fluid" alt="${gallery.title}">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold mb-0">${gallery.title}</h6>
                                </div>
                            </div>
                        </div>
                    `;
                                $('#galleryList').append(galleryHtml);
                            });

                            // Update skip count
                            $('#loadMoreBtn').data('skip', skip + response.galleries.length);
                            btn.html('<i class="fas fa-images me-2"></i> View More').prop(
                                'disabled', false);

                            // Hide or disable button if all are loaded
                            if ($('#galleryList .resource-item').length >=
                                {{ $totalGallery }}) {
                                btn.text('No more images').attr('disabled', true);
                            }
                        } else {
                            btn.text('No more images').attr('disabled', true);
                        }
                    },
                    error: function() {
                        alert('Error loading more images.');
                        btn.html('<i class="fas fa-images me-2"></i> View More').prop(
                            'disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
