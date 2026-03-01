@extends('layouts.app')

@section('title')
    {{ $media->media_title }} - AMDK Santri
@endsection

@section('content')
    <div class="page-header" style="background-image: url('{{ asset('assets/images/about-bg.png') }}'); background-size: cover; padding: 150px 0 80px 0; text-align: center; color: white; position: relative;">
         <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(14, 132, 51, 0.9) 0%, rgba(46, 209, 108, 0.8) 100%);"></div>
         <div class="container position-relative">
             <div class="row justify-content-center">
                 <div class="col-lg-8">
                    <h1 class="fw-bold display-5 mb-3" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">{{ $media->media_title }}</h1>
                    <div class="d-flex justify-content-center align-items-center text-white-50">
                        <span class="me-3"><i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($media->created_at)->format('d F Y') }}</span>
                        <span class="badge bg-white text-success rounded-pill px-3 py-2 fw-bold">{{ $media->media_category ?? 'Berita' }}</span>
                    </div>
                 </div>
             </div>
         </div>
    </div>

    <section id="media-detail" class="py-5 bg-white">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-5">
                        <div class="position-relative" style="padding-bottom: 56.25%; overflow: hidden;">
                             <img src="{{ asset('storage/media/' . $media->media_image) }}" class="position-absolute w-100 h-100 object-fit-cover" alt="{{ $media->media_title }}" style="object-fit: cover; top: 0; left: 0;">
                        </div>
                        <div class="card-body p-4 p-lg-5">
                            <div class="content-body" style="font-size: 1.1rem; line-height: 1.8; color: #444;">
                                {!! $media->media_content !!}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-top pt-4">
                        <a href="{{ route('media.public') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="fas fa-arrow-left me-2"></i> Kembali ke Berita</a>
                        
                        <div class="share-buttons">
                            <span class="me-2 text-muted">Bagikan:</span>
                            <a href="#" class="btn btn-sm btn-outline-success rounded-circle me-1"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-success rounded-circle me-1"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-success rounded-circle"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="sticky-top" style="top: 100px;">
                        <h4 class="fw-bold mb-4 text-success ps-3 border-start border-4 border-success">Berita Terbaru</h4>
                        
                        <div class="list-group list-group-flush border-0">
                            @foreach($recentMedias as $recent)
                            <a href="{{ route('media.detail', $recent->media_id) }}" class="list-group-item list-group-item-action border-0 py-3 ps-0 d-flex align-items-center">
                                <div class="flex-shrink-0 me-3 rounded overflow-hidden" style="width: 80px; height: 80px;">
                                    <img src="{{ asset('storage/media/' . $recent->media_image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $recent->media_title }}" style="object-fit: cover;">
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark hover-success-text" style="line-height: 1.4;">{{ Str::limit($recent->media_title, 50) }}</h6>
                                    <small class="text-muted"><i class="far fa-clock me-1"></i> {{ \Carbon\Carbon::parse($recent->created_at)->diffForHumans() }}</small>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .hover-success-text:hover {
            color: #0e8433 !important;
        }
    </style>
@endsection
