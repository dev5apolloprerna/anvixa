@extends('layouts.front')
@section('title', 'Contact Us')
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
                    <li class="breadcrumb-item">
                        <a href="{{ route('front.index') }}" class="text-white text-decoration-underline">Home</a>
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
                        <div class="row g-3 justify-content-center">
                            <h3 class="fw-bold text-danger mb-4 text-center">📄 Documents & PDFs</h3>
                            <p class="text-center text-muted mb-5">Research publications, policy briefs, and field insights.
                            </p>

                            <div class="row g-4 justify-content-center" id="documentList">

                                <!-- Document 1 -->
                                @foreach ($documents as $document)
                                    <div class="col-md-4 resource-item" data-topic="{{ $document->title }}">
                                        <div class="card p-3 shadow-sm border-0 rounded-3">
                                            <img src="{{ asset('assets/front/img/images.jpeg') }}"
                                                class="img-fluid rounded-3 mb-3" alt="{{ $document->title }}">
                                            <h6 class="fw-bold mb-2">
                                                <i class="fas fa-file-pdf text-danger me-2"></i>{{ $document->title }}
                                            </h6>
                                            {{--  <p class="text-muted small mb-3">
                                                {{ $document->title }}
                                            </p>  --}}
                                            <a target="_blank" href="{{ $document->document }}"
                                                class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-download me-2"></i>Download PDF
                                            </a>
                                        </div>
                                    </div>
                                @endforeach

                            </div>


                            @if ($total_documents > 1)
                                <div class="text-center mt-4">
                                    <button id="loadMoreBtn" class="btn custom-btn-red px-4 py-2"
                                        data-skip="{{ count($documents) }}">
                                        <i class="fas fa-folder-open me-2"></i> Browse More Documents
                                    </button>
                                </div>
                            @endif
                        </div>


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
                var limit = 6; // Number of documents per request
                var btn = $(this);

                btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Loading...')
                    .prop('disabled', true);

                $.ajax({
                    url: "{{ route('front.loadMoreDocuments') }}",
                    method: 'GET',
                    data: {
                        skip: skip,
                        limit: limit
                    },
                    success: function(response) {
                        if (response.documents.length > 0) {
                            response.documents.forEach(function(document) {
                                var documentHtml = `
                            <div class="col-md-4 resource-item" data-topic="${document.title}">
                                <div class="card p-3 shadow-sm border-0 rounded-3 h-100">
                                    <img src="{{ asset('assets/front/img/images.jpeg') }}"
                                         class="img-fluid rounded-3 mb-3" alt="${document.title}">
                                    <h6 class="fw-bold mb-2">
                                        <i class="fas fa-file-pdf text-danger me-2"></i>${document.title}
                                    </h6>
                                    <a target="_blank" href="${document.document}"
                                       class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-download me-2"></i>Download PDF
                                    </a>
                                </div>
                            </div>
                        `;
                                $('#documentList').append(documentHtml);
                            });

                            // Update skip value
                            $('#loadMoreBtn').data('skip', skip + response.documents.length);
                            btn.html(
                                    '<i class="fas fa-folder-open me-2"></i> Browse More Documents'
                                )
                                .prop('disabled', false);

                            // Hide the button when all are loaded
                            if ($('#documentList .resource-item').length >=
                                {{ $total_documents }}) {
                                btn.text('No more documents').attr('disabled', true);
                            }
                        } else {
                            btn.text('No more documents').attr('disabled', true);
                        }
                    },
                    error: function() {
                        alert('Error loading more documents.');
                        btn.html(
                                '<i class="fas fa-folder-open me-2"></i> Browse More Documents')
                            .prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
