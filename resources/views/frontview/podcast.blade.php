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
                        <div class="row g-3 justify-content-center"></div>
                        <h3 class="fw-bold text-danger mb-4 text-center">🎧 Podcast Library: Anviksha Talks</h3>
                        <p class="text-center text-muted mb-5">Voices and stories from the world of public health and
                            community change.</p>

                        <div class="row g-4 justify-content-center">

                            @foreach ($podcast_episodes as $podcast_episode)
                                <div class="col-md-4 resource-item" data-topic="policy community voices 2025">
                                    <div class="card shadow-sm rounded-3 border-0 p-3">
                                        <h6 class="fw-bold">{{ $podcast_episode->podcast_title }}</h6>
                                        <p class="text-muted small">Guest: Dr. Meera Nair | Host: Dr. Rajesh Kumar</p>
                                        <audio controls class="w-100 mt-2 custom-audio">
                                            <source
                                                src="https://transistor.nyc3.digitaloceanspaces.com/tracks/mystery-funk.mp3"
                                                type="audio/mpeg">
                                        </audio>
                                    </div>
                                </div>
                            @endforeach

                        </div>


                        @if ($totalPodcast_episode > 1)
                            <div class="text-center mt-4">
                                <button id="loadMoreBtn" class="btn custom-btn-red px-4 py-2" data-skip="1">
                                    <i class="fas fa-headphones me-2"></i>Listen More Episodes
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
                var limit = 6;

                var btn = $(this);
                btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Loading...').prop('disabled', true);

                $.ajax({
                    url: "{{ route('front.loadMorePodcasts') }}",
                    method: 'GET',
                    data: {
                        skip: skip,
                        limit: limit
                    },
                    success: function(response) {
                        if (response.podcasts.length > 0) {
                            response.podcasts.forEach(function(podcast) {
                                var podcastHtml = `
                            <div class="col-md-4 resource-item" data-aos="zoom-in" data-aos-delay="100">
                                <div class="card shadow-sm rounded-3 border-0 p-3 h-100">
                                    <h6 class="fw-bold">${podcast.podcast_title}</h6>
                                    <p class="text-muted small">
                                        Guest: ${podcast.guest ?? 'Unknown'} | Host: ${podcast.host ?? 'Unknown'}
                                    </p>
                                    <audio controls class="w-100 mt-2 custom-audio">
                                        <source src="${podcast.audio_link}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            </div>
                        `;
                                $('#podcastList').append(podcastHtml);
                            });

                            // Update skip count
                            $('#loadMoreBtn').data('skip', skip + response.podcasts.length);
                            btn.html(
                                '<i class="fas fa-headphones me-2"></i>Listen More Episodes'
                                ).prop('disabled', false);

                            // Hide button if all are loaded
                            if ($('#podcastList .resource-item').length >=
                                {{ $totalPodcast_episode }}) {
                                btn.text('No more episodes').attr('disabled', true);
                            }
                        } else {
                            btn.text('No more episodes').attr('disabled', true);
                        }
                    },
                    error: function() {
                        alert('Error loading more episodes.');
                        btn.html('<i class="fas fa-headphones me-2"></i>Listen More Episodes')
                            .prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
