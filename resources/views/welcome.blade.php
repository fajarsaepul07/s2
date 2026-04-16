@extends('layouts.components-frontend.master')

@section('pageTitle', 'Web Helpdesk – Platform Support Client & Vendor')

@section('content')
    <!-- ========================= MAIN CONTENT ========================= -->
    
    <!-- Hero Section -->
    <section id="home" class="hero-section-wrapper-5">
        <div class="hero-section hero-style-5 img-bg" 
             style="background-image: url('{{ asset('user/img/hero/hero-5/hero-bg.svg') }}')">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="hero-content-wrapper">
                            <h2 class="mb-30 wow fadeInUp" data-wow-delay=".2s">
                                Web Helpdesk Platform
                            </h2>
                            <p class="mb-30 wow fadeInUp" data-wow-delay=".4s">
                                Satu pintu untuk seluruh tiket client & vendor. Dilengkapi SLA otomatis dan dashboard real-time.
                            </p>
                            <a href="{{ route('tiket.create') }}" 
                               class="button button-lg radius-50 wow fadeInUp" 
                               data-wow-delay=".6s">
                                Buat Tiket Baru <i class="lni lni-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 align-self-end">
                        <div class="hero-image wow fadeInUp" data-wow-delay=".5s">
                            <img src="{{ asset('user/img/hero/hero-5/hero-img.svg') }}" 
                                 alt="Dashboard Helpdesk">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Section -->
    <section id="feature" class="feature-section feature-style-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-5 col-lg-7 col-md-8">
                    <div class="section-title text-center mb-60">
                        <h3 class="mb-15 wow fadeInUp" data-wow-delay=".2s">
                            Fitur Unggulan Kami
                        </h3>
                        <p class="wow fadeInUp" data-wow-delay=".4s">
                            Sistem tiket modern yang membantu Anda mengelola keluhan dan permintaan support dengan lebih cepat dan terorganisir.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".2s">
                        <div class="icon">
                            <i class="lni lni-ticket"></i>
                            <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h5>Pengelolaan Tiket</h5>
                            <p>Buat, pantau, dan kelola tiket support dengan mudah dan terstruktur.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".4s">
                        <div class="icon">
                            <i class="lni lni-users"></i>
                            <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h5>Penugasan Tim</h5>
                            <p>Tiket dapat ditugaskan ke tim teknisi atau tim konten secara cepat.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".6s">
                        <div class="icon">
                            <i class="lni lni-bar-chart"></i>
                            <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h5>Dashboard Real-time</h5>
                            <p>Pantau status tiket dan laporan secara langsung melalui dashboard.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".2s">
                        <div class="icon">
                            <i class="lni lni-files"></i>
                            <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h5>Laporan Masalah</h5>
                            <p>Buat laporan masalah dengan mudah dan lengkap beserta lampiran.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".4s">
                        <div class="icon">
                            <i class="lni lni-bell"></i>
                            <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h5>Notifikasi Real-time</h5>
                            <p>Dapatkan pemberitahuan langsung saat status tiket berubah.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".6s">
                        <div class="icon">
                            <i class="lni lni-star"></i>
                            <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h5>Evaluasi & Feedback</h5>
                            <p>Berikan rating dan komentar setelah tiket selesai untuk peningkatan layanan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section about-style-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-5 col-lg-6">
                    <div class="about-content-wrapper">
                        <div class="section-title mb-30">
                            <h3 class="mb-25 wow fadeInUp" data-wow-delay=".2s">
                                Masa depan layanan support dimulai di sini
                            </h3>
                            <p class="wow fadeInUp" data-wow-delay=".3s">
                                Kelola semua tiket dan laporan dari client serta vendor dalam satu platform yang modern dan efisien.
                            </p>
                        </div>
                        <ul>
                            <li class="wow fadeInUp" data-wow-delay=".35s">
                                <i class="lni lni-checkmark-circle"></i>
                                Sistem tiket terintegrasi dengan SLA otomatis
                            </li>
                            <li class="wow fadeInUp" data-wow-delay=".4s">
                                <i class="lni lni-checkmark-circle"></i>
                                Penugasan tim teknisi dan konten yang cepat
                            </li>
                            <li class="wow fadeInUp" data-wow-delay=".45s">
                                <i class="lni lni-checkmark-circle"></i>
                                Notifikasi real-time dan riwayat lengkap
                            </li>
                        </ul>
                        <a href="{{ route('tiket.create') }}" 
                           class="button button-lg radius-10 wow fadeInUp" 
                           data-wow-delay=".5s">
                            Buat Tiket Sekarang
                        </a>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6">
                    <div class="about-image text-lg-right wow fadeInUp" data-wow-delay=".5s">
                        <img src="{{ asset('user/img/about/about-4/about-img.svg')}}" alt="Helpdesk System">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section contact-style-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-5 col-lg-7 col-md-10">
                    <div class="section-title text-center mb-50">
                        <h3 class="mb-15">Hubungi Kami</h3>
                        <p>Butuh bantuan atau ada pertanyaan? Silakan hubungi tim support kami.</p>
                    </div>
                </div>
            </div>
            <!-- Form kontak tetap sama, hanya teks yang diubah -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="contact-form-wrapper">
                        <form action="" method="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <input type="text" id="name" name="name" class="form-input" placeholder="Nama Lengkap">
                                        <i class="lni lni-user"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <input type="email" id="email" name="email" class="form-input" placeholder="Email">
                                        <i class="lni lni-envelope"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <input type="text" id="number" name="number" class="form-input" placeholder="Nomor Telepon">
                                        <i class="lni lni-phone"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <input type="text" id="subject" name="subject" class="form-input" placeholder="Subjek">
                                        <i class="lni lni-text-format"></i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="single-input">
                                        <textarea name="message" id="message" class="form-input" placeholder="Pesan Anda" rows="6"></textarea>
                                        <i class="lni lni-comments-alt"></i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-button">
                                        <button type="submit" class="button">
                                            <i class="lni lni-telegram-original"></i> Kirim Pesan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="left-wrapper">
                        <div class="row">
                            <div class="col-lg-12 col-md-6">
                                <div class="single-item">
                                    <div class="icon"><i class="lni lni-phone"></i></div>
                                    <div class="text">
                                        <p>0812-3456-7890</p>
                                        <p>021-1234567</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="single-item">
                                    <div class="icon"><i class="lni lni-envelope"></i></div>
                                    <div class="text">
                                        <p>support@helpdesk.com</p>
                                        <p>admin@helpdesk.com</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="single-item">
                                    <div class="icon"><i class="lni lni-map-marker"></i></div>
                                    <div class="text">
                                        <p>Jl. Contoh No. 123, Jakarta, Indonesia</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Clients Logo -->
    <section class="clients-logo-section pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="client-logo wow fadeInUp" data-wow-delay=".2s">
                        <img src="{{ asset('user/img/clients/brands.svg') }}" 
                             alt="Client Helpdesk" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.components-frontend.footer')

@endsection