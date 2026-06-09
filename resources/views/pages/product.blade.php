@extends('layouts.app')

@section('title')
    Produk Santri - Segar & Alami
@endsection

@section('content')
    <div class="page-header" style="background-image: url('{{ asset('assets/images/about-bg.png') }}'); background-size: cover; padding: 150px 0 80px 0; text-align: center; color: white; position: relative;">
         <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(14, 132, 51, 0.9) 0%, rgba(46, 209, 108, 0.8) 100%);"></div>
         <div class="container position-relative">
             <h1 class="fw-bold display-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Produk Kami</h1>
             <p class="lead fw-normal" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Pilihan tepat untuk kesegaran setiap saat</p>
         </div>
    </div>

    <section id="product-list" class="py-5" style="background-color: #f9f9f9;">
        <div class="container py-4">
            <div class="row g-4 justify-content-center">
                @php
                    $products = [
                        ['img' => 'santri-120.png', 'title' => '120 ml', 'desc' => 'Kemasan mini yang praktis, cocok untuk acara dan pertemuan singkat.'],
                        ['img' => 'santri-240.png', 'title' => '240 ml', 'desc' => 'Ukuran gelas standar, ideal untuk jamuan tamu dan acara keluarga.'],
                        ['img' => 'santri-330.png', 'title' => '330 ml', 'desc' => 'Botol kecil yang pas di genggaman, teman setia aktivitas harian.'],
                        ['img' => 'santri-600.png', 'title' => '600 ml', 'desc' => 'Ukuran paling populer untuk menghilangkan dahaga saat bepergian.'],
                        ['img' => 'santri-1500.png', 'title' => '1500 ml', 'desc' => 'Botol besar untuk kebutuhan seharian atau berbagi bersama teman.'],
                        ['img' => 'santri-galon.png', 'title' => '19 Liter', 'desc' => 'Kemasan galon untuk persediaan air minum sehat di rumah Anda.'],
                    ];
                @endphp

                @foreach ($products as $index => $product)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.2 + ($index * 0.1) }}s">
                    <div class="card border-0 shadow-sm h-100 p-4 text-center santri-card" style="border-radius: 20px; transition: transform 0.3s;">
                        <div style="height: 220px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                             <img src="{{ asset('assets/images/' . $product['img']) }}" class="img-fluid" style="max-height: 200px;" alt="{{ $product['title'] }}">
                        </div>
                        <h4 class="fw-bold text-success mb-2">{{ $product['title'] }}</h4>
                        <p class="text-muted">{{ $product['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
