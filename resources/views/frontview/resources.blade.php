@extends('layouts.front')
@section('title', 'Resources')
@section('content')

    <!-- =======================
                     Smart Filter & Search
                ======================= -->
    <section class="py-5 bg-light border-bottom">
        <div class="container">
            <h4 class="fw-bold text-danger text-center mb-4">Find What You’re Looking For</h4>
            <form id="filterForm">
                <div class="row justify-content-center g-3 align-items-center">

                    <!-- Resource Type -->
                    <div class="col-md-3">
                        <select id="filterType" class="form-select">
                            <option value="all">All Resources</option>
                            <option value="video">Video Lectures</option>
                            <option value="podcast">Podcasts</option>
                            <option value="gallery">Gallery</option>
                            <option value="pdf">Documents / PDFs</option>
                        </select>
                    </div>

                    <!-- Year -->
                    <div class="col-md-3">
                        <select id="filterYear" class="form-select">
                            <option value="all">All Years</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Search by keyword (e.g., nutrition, policy, youth)...">
                    </div>

                    <!-- Search Button (Themed) -->
                    <div class="col-md-2 d-grid">
                        <button type="button" id="searchBtn" class="btn custom-btn-red fw-semibold">
                            <i class="fas fa-search me-2"></i> Search
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </section>


    <!-- =======================
                     1. Video Lectures Library
                ======================= -->
    <!-- Video Section -->
    <!-- =======================
                     1. Video Lectures Library (Fixed Embed)
                ======================= -->
    <section id="videos" class="py-5 bg-white resource-section" data-type="video" data-year="2024">
        <div class="container" data-aos="fade-up">
            <h3 class="fw-bold text-danger mb-4 text-center">🎥 Video Lectures Library</h3>
            <p class="text-center text-muted mb-5">
                Learn from our sessions on public health, research, and policy development.
            </p>

            <div class="row g-4" id="videoList">

                <!-- Video Card 1 -->
                <div class="col-md-4 resource-item" data-topic="health systems policy 2024" data-aos="zoom-in"
                    data-aos-delay="100">
                    <div class="video-card border rounded-4 shadow-sm overflow-hidden h-100">
                        <div class="ratio ratio-16x9">
                            <iframe width="100%" height="315"
                                src="https://www.youtube.com/embed/PiWzaz1X7gQ?si=Ud9WBWGST4qtZNk8"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="p-3">
                            <h6 class="fw-bold mb-2 text-dark">Health Systems Strengthening Workshop</h6>
                            <p class="text-muted small mb-0">
                                An in-depth look at improving sustainability in health programs.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Video Card 2 -->
                <div class="col-md-4 resource-item" data-topic="community engagement 2023" data-aos="zoom-in"
                    data-aos-delay="200">
                    <div class="video-card border rounded-4 shadow-sm overflow-hidden h-100">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                                title="Community Engagement & Public Health" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                        <div class="p-3">
                            <h6 class="fw-bold mb-2 text-dark">Community Engagement & Public Health</h6>
                            <p class="text-muted small mb-0">
                                Exploring innovative methods to connect with local communities.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Video Card 3 -->
                <div class="col-md-4 resource-item" data-topic="evidence-based medicine 2025" data-aos="zoom-in"
                    data-aos-delay="300">
                    <div class="video-card border rounded-4 shadow-sm overflow-hidden h-100">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/Z1LmpiIGYNs"
                                title="Evidence-Based Medicine in Practice" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                        <div class="p-3">
                            <h6 class="fw-bold mb-2 text-dark">Evidence-Based Medicine in Practice</h6>
                            <p class="text-muted small mb-0">
                                Using research evidence to inform clinical and community actions.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="400">
                <a href="#" class="btn custom-btn-red px-4 py-2">
                    <i class="fas fa-play-circle me-2"></i>Watch More Lectures
                </a>
            </div>
        </div>
    </section>



    <!-- =======================
                     2. Podcast Episodes
                ======================= -->
    <section id="podcasts" class="py-5 bg-light resource-section" data-type="podcast" data-year="2025">
        <div class="container">
            <h3 class="fw-bold text-danger mb-4 text-center">🎧 Podcast Library: Anviksha Talks</h3>
            <p class="text-center text-muted mb-5">Voices and stories from the world of public health and community change.
            </p>

            <div class="row g-4 justify-content-center">
                <div class="col-md-5 resource-item" data-topic="policy community voices 2025">
                    <div class="card shadow-sm rounded-3 border-0 p-3">
                        <h6 class="fw-bold">Episode 1 – Health for All</h6>
                        <p class="text-muted small">Guest: Dr. Meera Nair | Host: Dr. Rajesh Kumar</p>
                        <audio controls class="w-100 mt-2">
                            <source src="sample-podcast.mp3" type="audio/mpeg">
                        </audio>
                    </div>
                </div>

                <div class="col-md-5 resource-item" data-topic="youth preventive medicine 2024">
                    <div class="card shadow-sm rounded-3 border-0 p-3">
                        <h6 class="fw-bold">Episode 2 – Youth and Preventive Medicine</h6>
                        <p class="text-muted small">Guest: Dr. Anjali Patel | Host: Dr. Rajesh Kumar</p>
                        <audio controls class="w-100 mt-2">
                            <source src="sample-podcast.mp3" type="audio/mpeg">
                        </audio>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="#" class="btn custom-btn-red"><i class="fas fa-headphones me-2"></i>Listen to All
                    Episodes</a>
            </div>
        </div>
    </section>

    <!-- =======================
                     3. Gallery
                ======================= -->
    <section id="gallery" class="py-5 bg-white resource-section" data-type="gallery" data-year="2024">
        <div class="container">
            <h3 class="fw-bold text-danger mb-4 text-center">📸 Image & Community Gallery</h3>
            <p class="text-center text-muted mb-5">Snapshots from awareness campaigns, health drives, and youth engagement.
            </p>

            <div class="row g-3 justify-content-center">
                <div class="col-md-4 resource-item" data-topic="awareness campaign">
                    <img src="https://images.unsplash.com/photo-1584467735871-1c895e03b39a?auto=format&fit=crop&w=900&q=80"
                        class="img-fluid rounded-3 shadow-sm">
                </div>
                <div class="col-md-4 resource-item" data-topic="community health program">
                    <img src="https://images.unsplash.com/photo-1551836022-4c4c79ecde51?auto=format&fit=crop&w=900&q=80"
                        class="img-fluid rounded-3 shadow-sm">
                </div>
                <div class="col-md-4 resource-item" data-topic="youth nutrition">
                    <img src="https://images.unsplash.com/photo-1576765974039-6a381d3c7e05?auto=format&fit=crop&w=900&q=80"
                        class="img-fluid rounded-3 shadow-sm">
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="#" class="btn custom-btn-red"><i class="fas fa-images me-2"></i>View Full Gallery</a>
            </div>
        </div>
    </section>

    <!-- =======================
                     4. Documents & PDFs
                ======================= -->
    <section id="documents" class="py-5 bg-light resource-section" data-type="pdf" data-year="2025">
        <div class="container">
            <h3 class="fw-bold text-danger mb-4 text-center">📄 Documents & PDFs</h3>
            <p class="text-center text-muted mb-5">Research publications, policy briefs, and field insights.</p>

            <div class="row g-4 justify-content-center">
                <div class="col-md-4 resource-item" data-topic="maternal health policy 2025">
                    <div class="card p-3 shadow-sm border-0 rounded-3">
                        <h6 class="fw-bold mb-2"><i class="fas fa-file-pdf text-danger me-2"></i>Annual Health Report 2025
                        </h6>
                        <p class="text-muted small mb-3">Comprehensive summary of Anviksha's 2025 research initiatives.</p>
                        <a href="#" class="btn btn-outline-danger btn-sm"><i
                                class="fas fa-download me-2"></i>Download PDF</a>
                    </div>
                </div>

                <div class="col-md-4 resource-item" data-topic="nutrition policy brief 2024">
                    <div class="card p-3 shadow-sm border-0 rounded-3">
                        <h6 class="fw-bold mb-2"><i class="fas fa-file-alt text-danger me-2"></i>Policy Brief: Adolescent
                            Nutrition
                        </h6>
                        <p class="text-muted small mb-3">Guidelines and policy direction for youth nutrition in rural
                            India.</p>
                        <a href="#" class="btn btn-outline-danger btn-sm"><i
                                class="fas fa-download me-2"></i>Download PDF</a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="#" class="btn custom-btn-red"><i class="fas fa-folder-open me-2"></i>Browse All
                    Documents</a>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <!-- ======================= Script for Filtering & Search ======================= -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const typeSelect = document.getElementById('filterType');
            const yearSelect = document.getElementById('filterYear');
            const searchInput = document.getElementById('searchInput');
            const sections = document.querySelectorAll('.resource-section');

            function filterResources() {
                const type = typeSelect.value;
                const year = yearSelect.value;
                const search = searchInput.value.toLowerCase();

                sections.forEach(section => {
                    const matchesType = type === 'all' || section.dataset.type === type;
                    const matchesYear = year === 'all' || section.dataset.year === year;
                    const matchesSearch = search === '' || section.innerText.toLowerCase().includes(search);

                    section.style.display = (matchesType && matchesYear && matchesSearch) ? 'block' :
                        'none';
                });
            }

            typeSelect.addEventListener('change', filterResources);
            yearSelect.addEventListener('change', filterResources);
            searchInput.addEventListener('input', filterResources);
        });
    </script>
@endsection
