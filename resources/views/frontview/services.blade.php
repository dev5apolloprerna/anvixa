@extends('layouts.front')
@section('title', 'Services')
@section('content')

    <!-- Services Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Video Lectures -->
            <div class="row align-items-center mb-5" id="video">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <img src="https://cdn.prod.website-files.com/65e89895c5a4b8d764c0d70e/671f609afb2bddf96eaa518a_e49f04c1-ab78-4f34-9680-73fefb69127a.jpeg"
                        class="img-fluid rounded-4 shadow-lg" alt="Video Lectures">
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <h3 class="fw-bold text-danger mb-3">🎬 Video Lectures</h3>
                    <p class="lead text-muted">Interactive sessions on public health and research methods, designed for
                        medical
                        faculty, PG students, and healthcare professionals.</p>
                    <ul class="mb-4">
                        <li>Comprehensive training on public health & research methodology</li>
                        <li>Tailored content for faculty and practitioners</li>
                        <li>Blended learning – live & recorded sessions</li>
                    </ul>
                    <a href="{{ route('front.video') }}" class="btn btn-primary custom-btn-red">Watch Now →</a>
                </div>
            </div>

            <hr class="my-5">

            <!-- Podcast -->
            <div class="row align-items-center mb-5 flex-lg-row-reverse" id="podcast">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-left">
                    <img src="https://media.istockphoto.com/id/1330934437/photo/radio-interview-podcast-recording-business-people-talking-in-broadcasting-studio.jpg?s=612x612&w=0&k=20&c=q_PyqMSyaa4yIk0LKYQt4vISuEBrNLRIMgfXwG4F_nQ="
                        class="img-fluid rounded-4 shadow-lg" alt="Podcast">
                </div>
                <div class="col-lg-6" data-aos="fade-right">
                    <h3 class="fw-bold text-warning mb-3">🎧 Podcast – Anviksha Talks</h3>
                    <p class="lead text-muted">Conversations on health, policy, and community voices featuring guest experts
                        and
                        field stories — amplifying lived experiences that shape better systems.</p>
                    <ul class="mb-4">
                        <li>Engaging discussions on healthcare, policy & innovation</li>
                        <li>Guest speakers and real-world case insights</li>
                        <li>Available across all major platforms</li>
                    </ul>
                    <a href="{{ route('front.video') }}" class="btn btn-outline-light custom-btn-outline-orange">Listen Now
                        →</a>
                </div>
            </div>

            <hr class="my-5">

            <!-- Research Consultancy -->
            <div class="row align-items-center mb-5" id="research">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <img src="https://cdn.pixabay.com/photo/2016/11/19/14/00/research-1839406_1280.jpg"
                        class="img-fluid rounded-4 shadow-lg" alt="Research Consultancy">
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <h3 class="fw-bold text-primary mb-3">🔬 Research Consultancy (Health Sector)</h3>
                    <p class="lead text-muted">Providing expert guidance on proposal writing, grant development, and
                        monitoring &
                        evaluation frameworks for public health research initiatives.</p>
                    <ul class="mb-4">
                        <li>Proposal & grant development support</li>
                        <li>Evidence synthesis & policy briefs</li>
                        <li>Monitoring & Evaluation framework design</li>
                    </ul>
                    <a href="{{ route('front.contact_us') }}" class="btn btn-primary custom-btn-red">Request Support →</a>
                </div>
            </div>

            <hr class="my-5">

            <!-- Community Activities -->
            <div class="row align-items-center flex-lg-row-reverse" id="community">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-left">
                    <img src="https://www.apple.com/newsroom/images/product/services/standard/Apple-Community-Education-Initiative-students-thumbs-up_big.jpg.large.jpg"
                        class="img-fluid rounded-4 shadow-lg" alt="Community Activities">
                </div>
                <div class="col-lg-6" data-aos="fade-right">
                    <h3 class="fw-bold text-success mb-3">🤝 Community Activities</h3>
                    <p class="lead text-muted">From health screenings to youth engagement — we conduct awareness programs
                        and
                        preventive health drives across diverse communities.</p>
                    <ul class="mb-4">
                        <li>Health screenings & awareness campaigns</li>
                        <li>Nutrition & adolescent well-being programs</li>
                        <li>Community engagement for preventive health</li>
                    </ul>
                    <a href="{{ route('front.video') }}" class="btn btn-outline-light custom-btn-outline-orange">Join Us
                        →</a>
                </div>
            </div>

        </div>
    </section>

@endsection
