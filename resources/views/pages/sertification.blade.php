@extends('layouts.app')

@section('title')
    Sertifikasi - Jaminan Kualitas
@endsection

@section('content')
    <div class="page-header" style="background-image: url('{{ asset('assets/images/about-bg.png') }}'); background-size: cover; padding: 150px 0 80px 0; text-align: center; color: white; position: relative;">
         <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(14, 132, 51, 0.9) 0%, rgba(46, 209, 108, 0.8) 100%);"></div>
         <div class="container position-relative">
             <h1 class="fw-bold display-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Sertifikasi Resmi</h1>
             <p class="lead fw-normal" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Komitmen kami terhadap keamanan dan kualitas</p>
         </div>
    </div>

    <section id="sertificate" class="py-5" style="background-color: #f9f9f9;">
        <div class="container py-4">
            <div class="row g-4 justify-content-center">
                <!-- BPOM -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card border-0 shadow-sm h-100 p-0 overflow-hidden" style="border-radius: 20px;">
                        <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                            <h5 class="card-title fw-bold text-success mb-0">Sertifikat BPOM</h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <div class="mb-4 overflow-hidden rounded shadow-sm" style="height: 250px;">
                                <img src="{{ asset('assets/images/sertifikat-bpom-19liter.jpg') }}" class="img-fluid h-100 w-100 object-fit-cover" alt="BPOM">
                            </div>
                            <button class="btn btn-outline-success rounded-pill px-4 fw-bold w-100" data-bs-toggle="modal" data-bs-target="#sertificate-bpom">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- MUI -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="card border-0 shadow-sm h-100 p-0 overflow-hidden" style="border-radius: 20px;">
                        <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                            <h5 class="card-title fw-bold text-success mb-0">Sertifikat Halal MUI</h5>
                        </div>
                        <div class="card-body text-center p-4">
                             <div class="mb-4 overflow-hidden rounded shadow-sm" style="height: 250px;">
                                <img src="{{ asset('assets/images/sertifikat-halal-1.jpg') }}" class="img-fluid h-100 w-100 object-fit-cover" alt="MUI">
                            </div>
                            <button class="btn btn-outline-success rounded-pill px-4 fw-bold w-100" data-bs-toggle="modal" data-bs-target="#sertificate-mui">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- TKDN -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="card border-0 shadow-sm h-100 p-0 overflow-hidden" style="border-radius: 20px;">
                        <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                            <h5 class="card-title fw-bold text-success mb-0">Sertifikat TKDN</h5>
                        </div>
                        <div class="card-body text-center p-4">
                             <div class="mb-4 overflow-hidden rounded shadow-sm" style="height: 250px;">
                                <img src="{{ asset('assets/images/sertifikat-tkdn-19l.jpg') }}" class="img-fluid h-100 w-100 object-fit-cover" alt="TKDN">
                            </div>
                            <button class="btn btn-outline-success rounded-pill px-4 fw-bold w-100" data-bs-toggle="modal" data-bs-target="#sertificate-tkdn">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- bpom modal --}}
        <div class="modal fade" id="sertificate-bpom" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sertifikat BPOM</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-bpom-19liter.jpg" class="card-img-top border" alt="...">
                            </div>
                            <div class="col-md-4 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-bpom-120-240.jpg" class="card-img-top border" alt="...">
                            </div>
                            <div class="col-md-4 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-bpom-330-600-1500.jpg" class="card-img-top border" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- mui modal --}}
        <div class="modal fade" id="sertificate-mui" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sertifikat MUI</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-halal-1.jpg" class="card-img-top border" alt="...">
                            </div>
                            <div class="col-md-6 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-halal-2.jpg" class="card-img-top border" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- tkdn modal --}}
        <div class="modal fade" id="sertificate-tkdn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sertifikat TKDN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-tkdn-19l.jpg" class="card-img-top border" alt="...">
                            </div>
                            <div class="col-md-4 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-tkdn-120-240.jpg" class="card-img-top border" alt="...">
                            </div>
                            <div class="col-md-4 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-tkdn-330-600-1500.jpg" class="card-img-top border" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
