<div id="media" class="our-blog section" style="padding-top: 100px; padding-bottom: 100px; background-color: #f8f9fa;">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-lg-8 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <div class="section-heading text-start">
                    <h6 class="text-success text-uppercase fw-bold mb-2" style="letter-spacing: 2px;">Berita & Artikel</h6>
                    <h2 class="mb-0 display-5 fw-bold">Kabar Terbaru <span style="color: #0e8433;">AMDK Santri</span></h2>
                    <p class="text-muted mt-3" style="font-size: 1.1rem;">Ikuti perkembangan terbaru dan informasi menarik seputar kegiatan kami.</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                <a href="{{ route('media.public') }}" class="btn btn-outline-success rounded-pill px-4 py-2 fw-bold d-none d-lg-inline-block">Lihat Semua Berita <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>

        <div class="row g-4">
            @forelse($medias as $media)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">
                    <div class="card h-100 border-0 shadow-sm media-card" style="border-radius: 20px; overflow: hidden; background: #fff;">
                        <!-- Image Container -->
                        <div class="media-image-wrapper position-relative overflow-hidden" style="height: 240px;">
                            <img src="{{ asset('storage/media/' . $media->media_image) }}" class="w-100 h-100 object-fit-cover transition-transform" alt="{{ $media->media_title }}">
                            
                            <!-- Category Badge -->
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-white text-success rounded-pill px-3 py-2 fw-bold shadow-sm" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                    {{ $media->media_category ?? 'Berita' }}
                                </span>
                            </div>

                            <!-- Overlay on Hover -->
                            <div class="media-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center opacity-0 transition-opacity">
                                <a href="{{ route('media.detail', $media->media_id) }}" class="btn btn-white text-success rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-4 d-flex flex-column">
                            <!-- Date -->
                            <div class="d-flex align-items-center text-muted mb-3" style="font-size: 0.9rem;">
                                <i class="far fa-calendar-alt text-success me-2"></i>
                                <span>{{ \Carbon\Carbon::parse($media->created_at)->format('d F Y') }}</span>
                            </div>

                            <!-- Title -->
                            <h4 class="card-title fw-bold mb-3">
                                <a href="{{ route('media.detail', $media->media_id) }}" class="text-decoration-none text-dark media-title-link">
                                    {{ Str::limit($media->media_title, 60) }}
                                </a>
                            </h4>

                            <!-- Excerpt -->
                            <p class="card-text text-muted mb-4 flex-grow-1" style="line-height: 1.6;">
                                {{ Str::limit(strip_tags($media->media_content), 100) }}
                            </p>

                            <!-- Read More Link -->
                            <div class="mt-auto pt-3 border-top border-light">
                                <a href="{{ route('media.detail', $media->media_id) }}" class="fw-bold text-success text-decoration-none read-more-link d-inline-flex align-items-center">
                                    Baca Selengkapnya
                                    <i class="fas fa-long-arrow-alt-right ms-2 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-white rounded-3 shadow-sm">
                        <i class="far fa-newspaper fa-3x text-muted mb-3"></i>
                        <p class="text-muted h5">Belum ada berita terbaru saat ini.</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        <div class="row mt-5 d-lg-none">
            <div class="col-12 text-center">
                <a href="{{ route('media.public') }}" class="btn btn-outline-success rounded-pill px-5 py-3 fw-bold shadow-sm">Lihat Semua Berita</a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Card Hover Effects */
    .media-card {
        transition: all 0.3s ease;
    }
    .media-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }

    /* Image Zoom Effect */
    .transition-transform {
        transition: transform 0.5s ease;
    }
    .media-card:hover .media-image-wrapper img {
        transform: scale(1.1);
    }

    /* Overlay Effect */
    .transition-opacity {
        transition: opacity 0.3s ease;
    }
    .media-overlay {
        background: rgba(14, 132, 51, 0.3);
    }
    .media-card:hover .media-overlay {
        opacity: 1 !important;
    }

    /* Title Link Hover */
    .media-title-link {
        background-image: linear-gradient(currentColor, currentColor);
        background-position: 0% 100%;
        background-repeat: no-repeat;
        background-size: 0% 2px;
        transition: background-size .3s;
    }
    .media-card:hover .media-title-link {
        color: #0e8433 !important;
        background-size: 100% 2px;
    }

    /* Read More Arrow Animation */
    .read-more-link:hover .fa-long-arrow-alt-right {
        transform: translateX(5px);
    }
</style>
