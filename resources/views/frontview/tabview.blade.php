<ul class="list-unstyled d-grid gap-3">
    <li>
        <a href="{{ route('front.video') }}"
            class="btn btn-outline-danger fw-semibold w-100 text-start
        {{ Route::is('front.video') ? 'btn-danger text-white' : 'btn-outline-danger' }}">
            <i class="fas fa-video me-2"></i> Video Lectures Library
        </a>
    </li>
    <li>
        <a href="{{ route('front.podcast') }}"
            class="btn btn-outline-danger fw-semibold w-100 text-start
        {{ Route::is('front.podcast') ? 'btn-danger text-white' : 'btn-outline-danger' }}">
            <i class="fas fa-podcast me-2"></i> Podcast Library
        </a>
    </li>
    <li>
        <a href="{{ route('front.gallery') }}"
            class="btn btn-outline-danger fw-semibold w-100 text-start
        {{ Route::is('front.gallery') ? 'btn-danger text-white' : 'btn-outline-danger' }}">
            <i class="fas fa-images me-2"></i> Image & Community Gallery
        </a>
    </li>
    <li>
        <a href="{{ route('front.document') }}"
            class="btn btn-outline-danger fw-semibold w-100 text-start
        {{ Route::is('front.document') ? 'btn-danger text-white' : 'btn-outline-danger' }}">
            <i class="fas fa-file-pdf me-2"></i> Documents & PDFs
        </a>
    </li>
</ul>
