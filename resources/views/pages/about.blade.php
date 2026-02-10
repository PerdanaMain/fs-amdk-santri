@extends('layouts.app')

@section('title')
    About Us
@endsection

@section('content')
    <section id="about-us" class="container my-5">
        <div class="section-heading">
            <h2>About <em style="color: #0e8433">Us</em></h2>
        </div>

        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-6 wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.25s">
                    <img src="assets/images/logo-santri-bordered.jpg" alt="" style="max-width: 450px;">
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="about-text section-heading wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.25s">
                        <h2>Tentang <em style="color: #0e8433">Kami</em></h2>
                        <p>AMDK KOPONTREN SIDOGIRI adalah perusahaan yang memproduksi air mineral dengan merk “SANTRI”
                            merupakan air minum yang terbuat dari kemurnian alam.</p>
                        <p>SANTRI diambil langsung dari mata air Umbulan yang terkenal kejernihannya sebagai air yang
                            menghasilkan debit air besar, jernih, segar serta kandungan mineralnya stabil.</p>

                        <p>
                            SANTRI diproses melalui Sand Filter, Carbon Filter dan Filterasi, dan disterilkan dengan Ozon
                            (O3) dan sinar ultra violet dengan teknologi Water Treatment sesuai Standart Nasional Indonesia
                            (SNI).
                        </p>

                        <p>SANTRI diproses melalui mesin pengisian otomatis dengan quality control yang ketat serta
                            ditunjang dengan tenaga ahli yang berpengalaman di bidangnya sehingga menghasilkan air mineral
                            yang bermutu.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
