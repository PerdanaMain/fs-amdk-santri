@extends('layouts.app')

@section('title')
    Sertificates
@endsection

@section('content')
    <section id="sertificate" style="padding-top: 120px; margin-bottom:20px;">
        <div class="container">
            <div class="section-heading">
                <h2>Our <em style="color: #0e8433">Sertificates</em></h2>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 my-3 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header text-center">
                            <h5 class="card-title text-center" style="font-weight: bold;">Sertifikat BPOM</h5>
                        </div>
                        <div class="card-body d-block">
                            <img src="assets/images/sertifikat-bpom-19liter.jpg" class="card-img-top" alt="...">
                            <button class="btn btn-primary mt-3" data-bs-toggle="modal"
                                data-bs-target="#sertificate-bpom">Lihat
                                Sertifikat</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 my-3 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header text-center">
                            <h5 class="card-title text-center" style="font-weight: bold;">Sertifikat MUI</h5>
                        </div>
                        <div class="card-body d-block">
                            <img src="assets/images/sertifikat-halal-1.jpg" class="card-img-top" alt="...">
                            <button class="btn btn-primary mt-3" data-bs-toggle="modal"
                                data-bs-target="#sertificate-mui">Lihat
                                Sertifikat</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 my-3 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header text-center">
                            <h5 class="card-title text-center" style="font-weight: bold;">Sertifikat TKDN</h5>
                        </div>
                        <div class="card-body d-block">
                            <img src="assets/images/sertifikat-tkdn-19l.jpg" class="card-img-top" alt="...">
                            <button class="btn btn-primary mt-3" data-bs-toggle="modal"
                                data-bs-target="#sertificate-tkdn">Lihat
                                Sertifikat</button>
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
                                <img src="assets/images/sertifikat-bpom-19liter.jpg" class="card-img-top border"
                                    alt="...">
                            </div>
                            <div class="col-md-4 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-bpom-120-240.jpg" class="card-img-top border"
                                    alt="...">
                            </div>
                            <div class="col-md-4 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-bpom-330-600-1500.jpg" class="card-img-top border"
                                    alt="...">
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
                                <img src="assets/images/sertifikat-halal-1.jpg" class="card-img-top border"
                                    alt="...">
                            </div>
                            <div class="col-md-6 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-halal-2.jpg" class="card-img-top border"
                                    alt="...">
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
        <div class="modal fade" id="sertificate-tkdn" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sertifikat TKDN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-tkdn-19l.jpg" class="card-img-top border"
                                    alt="...">
                            </div>
                            <div class="col-md-4 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-tkdn-120-240.jpg" class="card-img-top border"
                                    alt="...">
                            </div>
                            <div class="col-md-4 col-sm-12 my-3">
                                <img src="assets/images/sertifikat-tkdn-330-600-1500.jpg" class="card-img-top border"
                                    alt="...">
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
