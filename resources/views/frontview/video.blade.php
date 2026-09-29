@extends('layouts.front')
@section('title', 'Video Lectures Library')
@section('content')

    <!-- Header -->
    <section class="py-5 text-white text-center" style="background: linear-gradient(90deg, #ff7b00, #ff4500);">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2" data-aos="fade-up">Resources & Media Library</h1>
            <p class="lead text-white-50" data-aos="fade-up" data-aos-delay="200">
                Explore our collection of lectures, podcasts, images, and reports — your one-stop hub for learning and
                community
                engagement.
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
                        <h3 class="fw-bold text-danger mb-4 text-center">🎥 Video Lectures Library</h3>
                        <p class="text-center text-muted mb-5">
                            Learn from our sessions on public health, research, and policy development.
                        </p>

                        <div class="row g-4" id="videoList">

                            @foreach ($videos as $video)
                                @php
                                    $url = $video->video_link;
                                    $embedUrl = '';

                                    // Detect and convert YouTube links
                                    if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                                        $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                    } elseif (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
                                        $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                    }
                                    // Detect Vimeo links
                                    elseif (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
                                        $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                                    }
                                    // Detect Facebook video links
                                    elseif (str_contains($url, 'facebook.com')) {
                                        $embedUrl =
                                            'https://www.facebook.com/plugins/video.php?href=' . urlencode($url);
                                    }
                                    // Detect direct MP4 or other video files
                                    elseif (preg_match('/\.(mp4|webm|ogg)$/i', $url)) {
                                        $embedUrl = $url; // Use direct video link
                                    }
                                    // Otherwise, just use original link (e.g. embed or live link)
                                    else {
                                        $embedUrl = $url;
                                    }
                                @endphp

                                <div class="col-md-4 resource-item" data-topic="health systems policy 2024"
                                    data-aos="zoom-in" data-aos-delay="100">
                                    <div class="video-card border rounded-4 shadow-sm overflow-hidden h-100">

                                        <div class="ratio ratio-16x9">
                                            @if (preg_match('/\.(mp4|webm|ogg)$/i', $embedUrl))
                                                {{-- Direct video file --}}
                                                <video width="100%" height="315" controls>
                                                    <source src="{{ $embedUrl }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else
                                                {{-- Embedded iframe (YouTube, Vimeo, Facebook, live links, etc.) --}}
                                                <iframe width="100%" height="315" src="{{ $embedUrl }}"
                                                    title="Video player" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen></iframe>
                                            @endif
                                        </div>

                                        <div class="p-3">
                                            <h6 class="fw-bold mb-2 text-dark">{{ $video->video_title }}</h6>
                                            {{--  <p class="text-muted small mb-0">
                                                An in-depth look at improving sustainability in health programs.
                                            </p>  --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        @if ($totalVideos > count($videos))
                            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="400">
                                <button id="loadMoreBtn" class="btn custom-btn-red px-4 py-2"
                                    data-skip="{{ count($videos) }}">
                                    <i class="fas fa-play-circle me-2"></i> Watch More Lectures
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

                $.ajax({
                    url: "{{ route('front.loadMoreVideos') }}",
                    method: 'GET',
                    data: {
                        skip: skip,
                        limit: limit
                    },
                    success: function(response) {
                        if (response.videos.length > 0) {
                            response.videos.forEach(function(video) {
                                var url = video.video_link;
                                var embedUrl = '';

                                // Convert YouTube, Vimeo, Facebook, etc.
                                if (url.match(/youtu\.be\/([a-zA-Z0-9_-]+)/)) {
                                    embedUrl = 'https://www.youtube.com/embed/' + RegExp
                                        .$1;
                                } else if (url.match(
                                        /youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/)) {
                                    embedUrl = 'https://www.youtube.com/embed/' + RegExp
                                        .$1;
                                } else if (url.match(/vimeo\.com\/(\d+)/)) {
                                    embedUrl = 'https://player.vimeo.com/video/' +
                                        RegExp.$1;
                                } else if (url.includes('facebook.com')) {
                                    embedUrl =
                                        'https://www.facebook.com/plugins/video.php?href=' +
                                        encodeURIComponent(url);
                                } else if (/\.(mp4|webm|ogg)$/i.test(url)) {
                                    embedUrl = url;
                                } else {
                                    embedUrl = url;
                                }

                                var videoHtml = `
                            <div class="col-md-4 resource-item" data-aos="zoom-in" data-aos-delay="100">
                                <div class="video-card border rounded-4 shadow-sm overflow-hidden h-100">
                                    <div class="ratio ratio-16x9">
                                        ${
                                            /\.(mp4|webm|ogg)$/i.test(embedUrl)
                                            ? `<video width="100%" height="315" controls>
                                                            <source src="${embedUrl}" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                           </video>`
                                            : `<iframe width="100%" height="315" src="${embedUrl}"
                                                            title="Video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>`
                                        }
                                    </div>
                                    <div class="p-3">
                                        <h6 class="fw-bold mb-2 text-dark">${video.video_title}</h6>
                                    </div>
                                </div>
                            </div>
                        `;

                                $('#videoList').append(videoHtml);
                            });

                            // Update skip for next load
                            $('#loadMoreBtn').data('skip', skip + response.videos.length);

                            // Hide button if all videos loaded
                            if ($('#videoList .resource-item').length >= {{ $totalVideos }}) {
                                $('#loadMoreBtn').text('No more videos').attr('disabled', true);
                            }

                        } else {
                            $('#loadMoreBtn').text('No more videos').attr('disabled', true);
                        }
                    },
                    error: function() {
                        alert('Error loading more videos.');
                    }
                });
            });
        });
    </script>
@endsection
