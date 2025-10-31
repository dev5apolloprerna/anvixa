<nav class="navbar navbar-expand-lg custom-navbar-orange sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('front.index') }}">
            <img src="{{ asset('assets/front/img/Anviksha_logo final.png') }}" alt="Anviksha Logo" height="70">
        </a>
        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link custom-nav-link" href="{{ route('front.index') }}">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle custom-nav-link active" href="#" id="servicesDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                    <ul class="dropdown-menu custom-dropdown-menu" aria-labelledby="servicesDropdown">
                        <li><a class="dropdown-item custom-dropdown-item"
                                href="{{ route('front.services') }}#video">Video
                                Lectures</a></li>
                        <li><a class="dropdown-item custom-dropdown-item"
                                href="{{ route('front.services') }}#podcast">Podcast –
                                Anviksha Talks</a></li>
                        <li><a class="dropdown-item custom-dropdown-item"
                                href="{{ route('front.services') }}#research">Research
                                Consultancy</a></li>
                        <li><a class="dropdown-item custom-dropdown-item"
                                href="{{ route('front.services') }}#community">Community
                                Activities</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link custom-nav-link" href="{{ route('front.about') }}">About Us</a>
                </li>
                <li class="nav-item"><a class="nav-link custom-nav-link" href="video.html">Resources</a></li>
                <li class="nav-item"><a class="nav-link custom-nav-link"
                        href="{{ route('front.contact_us') }}">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
