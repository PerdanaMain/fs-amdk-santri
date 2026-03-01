@extends('layouts.app')

@section('title')
    Tentang Kami - AMDK Santri
@endsection

@section('content')
    <div class="page-header" style="background-image: url('{{ asset('assets/images/about-bg.png') }}'); background-size: cover; padding: 150px 0 80px 0; text-align: center; color: white; position: relative;">
         <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(14, 132, 51, 0.9) 0%, rgba(46, 209, 108, 0.8) 100%);"></div>
         <div class="container position-relative">
             <h1 class="fw-bold display-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Tentang Kami</h1>
             <p class="lead fw-normal" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Mengenal lebih dekat AMDK Santri</p>
         </div>
    </div>

    <section id="about-us" class="py-5 bg-white">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.25s">
                    <div class="position-relative">
                         <img src="{{ asset('assets/images/logo-santri-bordered.jpg') }}" alt="Logo Santri" class="img-fluid rounded shadow-lg" style="max-width: 100%; border-radius: 20px;">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-text ps-lg-5 wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.25s">
                        <h6 class="text-success text-uppercase fw-bold mb-2">Profil Perusahaan</h6>
                        <h2 class="mb-4 fw-bold">Dedikasi Untuk <br><em style="color: #0e8433;">Kesehatan Negeri</em></h2>
                        
                        <p class="text-muted mb-3" style="font-size: 1.1rem; line-height: 1.8;">
                            <strong>AMDK KOPONTREN SIDOGIRI</strong> memproduksi air mineral dengan merk <strong>“SANTRI”</strong> yang berasal dari kemurnian alam terbaik. Kami percaya bahwa air yang sehat adalah kunci kehidupan yang berkualitas.
                        </p>
                        
                        <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.8;">
                            Air kami diambil langsung dari mata air Umbulan yang legendaris, dikenal akan kejernihan dan debit airnya yang melimpah serta kandungan mineral alami yang stabil dan menyehatkan.
                        </p>

                        <div class="d-flex align-items-start mb-3 mt-4">
                            <div class="me-3 text-success"><i class="fas fa-check-circle fa-2x"></i></div>
                            <div>
                                <h5 class="fw-bold mb-1">Teknologi Modern</h5>
                                <p class="small text-muted mb-0">Diproses dengan Sand Filter, Carbon Filter, Ozon (O3), dan UV Sterilizer.</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3 text-success"><i class="fas fa-check-circle fa-2x"></i></div>
                            <div>
                                <h5 class="fw-bold mb-1">Standar Nasional</h5>
                                <p class="small text-muted mb-0">Sesuai SNI dan melalui Quality Control ketat oleh tenaga ahli berpengalaman.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
