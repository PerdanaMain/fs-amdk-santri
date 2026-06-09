@extends('layouts.app')

@section('title')
    Media & Berita - AMDK Santri
@endsection

@section('content')
    <div class="page-header" style="background-image: url('{{ asset('assets/images/about-bg.png') }}'); background-size: cover; padding: 150px 0 80px 0; text-align: center; color: white; position: relative;">
         <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(14, 132, 51, 0.9) 0%, rgba(46, 209, 108, 0.8) 100%);"></div>
         <div class="container position-relative">
             <h1 class="fw-bold display-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Media & Berita</h1>
             <p class="lead fw-normal" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Informasi terbaru seputar kegiatan dan perkembangan kami</p>
         </div>
    </div>

    <section id="media-list" class="py-5" style="background-color: #f9f9f9;">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @forelse($medias as $media)
                        <div class="card border-0 shadow-sm mb-4 overflow-hidden wow fadeInUp" data-wow-delay="0.1s" style="border-radius: 15px; transition: transform 0.3s;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div style="height: 250px; overflow: hidden;">
                                        <img src="{{ asset('storage/media/' . $media->media_image) }}" class="img-fluid w-100 h-100 object-fit-cover" alt="{{ $media->media_title }}" style="object-fit: cover;">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body p-4 d-flex flex-column h-100 justify-content-center">
                                        <div class="mb-2">
                                            <span class="badge bg-success rounded-pill mb-2">{{ $media->media_category ?? 'Berita' }}</span>
                                            <small class="text-muted ms-2"><i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($media->created_at)->format('d M Y') }}</small>
                                        </div>
                                        <h3 class="card-title fw-bold text-dark mb-3">
                                            <a href="{{ route('media.detail', $media->media_id) }}" class="text-decoration-none text-dark hover-success">{{ $media->media_title }}</a>
                                        </h3>
                                        <p class="card-text text-muted mb-4">{{ Str::limit(strip_tags($media->media_content), 150) }}</p>
                                        <a href="{{ route('media.detail', $media->media_id) }}" class="btn btn-outline-success rounded-pill px-4 fw-bold align-self-start">Baca Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="far fa-newspaper fa-4x text-muted"></i>
                            </div>
                            <h4 class="text-muted">Belum ada berita terbaru</h4>
                        </div>
                    @endforelse

                    <div class="d-flex justify-content-center mt-5">
                        {{ $medias->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .hover-success:hover {
            color: #0e8433 !important;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection
