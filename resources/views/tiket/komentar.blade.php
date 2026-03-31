@extends('layouts.components-frontend.master')
@section('pageTitle', 'Daftar Tiket Saya')

@section('content')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">

    <!-- LineIcons CDN -->
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">

    <style>
        .rating-star {
            cursor: pointer;
            font-size: 3.5rem;
            color: #e0e0e0;
            transition: all 0.3s ease;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .rating-star:hover {
            transform: scale(1.2);
            color: #0052CC;
        }

        .rating-star.active {
            color: #0052CC;
            filter: drop-shadow(0 0 10px rgba(0, 82, 204, 0.8));
            transform: scale(1.1);
            animation: starPulse 0.3s ease;
        }

        @keyframes starPulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.3);
            }
            100% {
                transform: scale(1.1);
            }
        }

        @keyframes cardPulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 8px 16px rgba(0, 82, 204, 0.3);
            }
            100% {
                transform: scale(1);
            }
        }

        .card {
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .tipe-komentar-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
        }

        .tipe-komentar-card:hover {
            border-color: #0052CC;
            background-color: #f8f9ff;
            transform: translateY(-2px);
        }

        .tipe-komentar-card.selected {
            border-color: #0052CC;
            background-color: #e7f3ff;
        }

        .form-control:focus {
            border-color: #0052CC;
            box-shadow: 0 0 0 0.2rem rgba(0, 82, 204, 0.15);
        }

        .info-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            color: white;
        }

        #ratingText {
            font-weight: 600;
            font-size: 1.1rem;
            color: #0052CC;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
            min-height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    {{-- Include Navbar --}}
    @include('layouts.components-frontend.navbar')

    <div class="container-fluid px-4 py-4" style="min-height: calc(100vh - 200px);">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('tiket.index') }}">Tiket Saya</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tiket.show', $tiket->tiket_id) }}">Detail Tiket</a></li>
                <li class="breadcrumb-item active">Berikan Komentar</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                {{-- Header Card --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h3 class="fw-bold mb-2">
                                    <i class="lni lni-comments text-primary"></i> Berikan Komentar & Evaluasi
                                </h3>
                                <p class="text-muted mb-0">Bagaimana pengalaman Anda dengan penyelesaian tiket ini?</p>
                            </div>
                            <span class="badge bg-success px-3 py-2">
                                <i class="lni lni-checkmark-circle"></i> Tiket Selesai
                            </span>
                        </div>

                        {{-- Info Tiket --}}
                        <div class="info-box p-4 mt-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <small class="text-white-50 d-block mb-1">Kode Tiket</small>
                                    <div class="fw-bold">{{ $tiket->kode_tiket }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-white-50 d-block mb-1">Judul</small>
                                    <div class="fw-bold">{{ Str::limit($tiket->judul, 30) }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-white-50 d-block mb-1">Kategori</small>
                                    <div class="fw-bold">{{ $tiket->kategori->nama_kategori ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-white-50 d-block mb-1">Ditangani oleh</small>
                                    <div class="fw-bold">{{ $tiket->assignedTo->name ?? 'Tim Support' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Alert Messages --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="lni lni-warning me-2 fs-5"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Form Komentar --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('tiket.komentar.store', $tiket->tiket_id) }}" method="POST" id="komentarForm">
                            @csrf

                            {{-- Rating Section --}}
                            <div class="mb-5">
                                <label class="form-label fw-bold mb-3">
                                    <i class="lni lni-star text-warning"></i> Berikan Rating 
                                    <span class="text-danger">*</span>
                                </label>
                                <p class="text-muted small mb-3">Seberapa puas Anda dengan penyelesaian tiket ini?</p>
                                
                                <div class="d-flex justify-content-center gap-2 mb-3" id="ratingStars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="lni lni-star-filled rating-star" data-rating="{{ $i }}"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating') }}" required>
                                
                                <div class="text-center">
                                    <div id="ratingText" class="text-muted">Klik bintang untuk memberikan rating</div>
                                </div>

                                @error('rating')
                                    <div class="text-danger small mt-2 text-center">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tipe Komentar Section --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold mb-3">
                                    <i class="lni lni-tag text-info"></i> Tipe Komentar 
                                    <span class="text-danger">*</span>
                                </label>
                                
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="tipe-komentar-card p-3 rounded-3 h-100" data-tipe="feedback">
                                            <input type="radio" name="tipe_komentar" value="feedback" 
                                                class="d-none" id="tipe_feedback"
                                                {{ old('tipe_komentar', 'feedback') == 'feedback' ? 'checked' : '' }} required>
                                            <label for="tipe_feedback" class="cursor-pointer w-100 m-0">
                                                <div class="text-center mb-2">
                                                    <i class="lni lni-thumbs-up text-primary" style="font-size: 2rem;"></i>
                                                </div>
                                                <div class="fw-bold text-center mb-1">Feedback Positif</div>
                                                <small class="text-muted d-block text-center">Apresiasi dan saran perbaikan</small>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="tipe-komentar-card p-3 rounded-3 h-100" data-tipe="evaluasi">
                                            <input type="radio" name="tipe_komentar" value="evaluasi" 
                                                class="d-none" id="tipe_evaluasi"
                                                {{ old('tipe_komentar') == 'evaluasi' ? 'checked' : '' }}>
                                            <label for="tipe_evaluasi" class="cursor-pointer w-100 m-0">
                                                <div class="text-center mb-2">
                                                    <i class="lni lni-bar-chart text-success" style="font-size: 2rem;"></i>
                                                </div>
                                                <div class="fw-bold text-center mb-1">Evaluasi</div>
                                                <small class="text-muted d-block text-center">Penilaian objektif layanan</small>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="tipe-komentar-card p-3 rounded-3 h-100" data-tipe="complaint">
                                            <input type="radio" name="tipe_komentar" value="complaint" 
                                                class="d-none" id="tipe_complaint"
                                                {{ old('tipe_komentar') == 'complaint' ? 'checked' : '' }}>
                                            <label for="tipe_complaint" class="cursor-pointer w-100 m-0">
                                                <div class="text-center mb-2">
                                                    <i class="lni lni-warning text-danger" style="font-size: 2rem;"></i>
                                                </div>
                                                <div class="fw-bold text-center mb-1">Keluhan</div>
                                                <small class="text-muted d-block text-center">Ketidakpuasan yang perlu ditindaklanjuti</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                @error('tipe_komentar')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Komentar Text Area --}}
                            <div class="mb-4">
                                <label for="komentar" class="form-label fw-bold mb-2">
                                    <i class="lni lni-pencil text-info"></i> Komentar Anda 
                                    <span class="text-danger">*</span>
                                </label>
                                <p class="text-muted small mb-3">
                                    Ceritakan pengalaman Anda secara detail. Komentar Anda sangat berharga untuk meningkatkan kualitas layanan kami.
                                </p>
                                <textarea 
                                    name="komentar" 
                                    id="komentar" 
                                    rows="6" 
                                    class="form-control"
                                    placeholder="Tuliskan komentar Anda di sini (minimal 10 karakter)..."
                                    required
                                    maxlength="1000">{{ old('komentar') }}</textarea>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    @error('komentar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @else
                                        <small class="text-muted">Minimal 10 karakter</small>
                                    @enderror
                                    <small class="text-muted" id="charCount">0/1000</small>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <a href="{{ route('tiket.show', $tiket->tiket_id) }}" 
                                    class="btn btn-outline-secondary">
                                    <i class="lni lni-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="lni lni-checkmark-circle"></i> Kirim Komentar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Info Box --}}
                <div class="alert alert-info border-0 mt-4 d-flex align-items-start">
                    <i class="lni lni-information fs-4 me-3"></i>
                    <div>
                        <div class="fw-bold mb-2">Catatan Penting:</div>
                        <ul class="mb-0 small ps-3">
                            <li>Komentar Anda hanya dapat dikirim satu kali per tiket</li>
                            <li>Komentar akan dilihat oleh admin dan tim yang menangani tiket Anda</li>
                            <li>Feedback Anda akan membantu kami meningkatkan kualitas layanan</li>
                            <li>Semua komentar bersifat rahasia dan hanya digunakan untuk evaluasi internal</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Include Footer --}}
    <footer class="bg-light py-4 mt-5 border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">2025 © Helpdesk System</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">
                        Crafted with <span class="text-danger">❤️</span> by Your Team
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Rating Stars Handler
            const stars = document.querySelectorAll('.rating-star');
            const ratingInput = document.getElementById('ratingInput');
            const ratingText = document.getElementById('ratingText');
            const ratingTexts = {
                0: 'Klik bintang untuk memberikan rating',
            };

            // Set initial state if old value exists
            if (ratingInput.value) {
                const rating = parseInt(ratingInput.value);
                updateStars(rating);
                ratingText.textContent = ratingTexts[rating];
            }

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    ratingInput.value = rating;
                    updateStars(rating);
                    ratingText.textContent = ratingTexts[rating];
                    ratingText.style.color = '#0052CC';
                    
                    // Auto select tipe komentar based on rating
                    autoSelectTipeKomentar(rating);
                });

                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    highlightStars(rating);
                    
                    // Only show preview if rating already selected
                    if (ratingInput.value) {
                        ratingText.textContent = ratingTexts[rating];
                    }
                });
            });

            document.getElementById('ratingStars').addEventListener('mouseleave', function() {
                const currentRating = parseInt(ratingInput.value) || 0;
                updateStars(currentRating);
                
                // Restore original text or reset
                if (currentRating > 0) {
                    ratingText.textContent = ratingTexts[currentRating];
                    ratingText.style.color = '#0052CC';
                } else {
                    ratingText.textContent = ratingTexts[0];
                    ratingText.style.color = '#6c757d';
                }
            });

            function updateStars(rating) {
                stars.forEach((star, index) => {
                    star.classList.remove('active');
                    if (index < rating) {
                        star.classList.add('active');
                    }
                });
            }

            function highlightStars(rating) {
                stars.forEach((star, index) => {
                    star.classList.remove('active');
                    if (index < rating) {
                        star.classList.add('active');
                    }
                });
            }

            function resetStars() {
                stars.forEach(star => {
                    star.classList.remove('active');
                });
            }

            function autoSelectTipeKomentar(rating) {
                let tipeValue = '';
                
                // Rating 1-2: Keluhan (complaint)
                if (rating >= 1 && rating <= 2) {
                    tipeValue = 'complaint';
                }
                // Rating 3-4: Evaluasi
                else if (rating >= 3 && rating <= 4) {
                    tipeValue = 'evaluasi';
                }
                // Rating 5: Feedback Positif
                else if (rating === 5) {
                    tipeValue = 'feedback';
                }

                // Select the radio button
                const radioButton = document.getElementById(`tipe_${tipeValue}`);
                if (radioButton) {
                    radioButton.checked = true;
                    
                    // Update card visual
                    tipeCards.forEach(c => c.classList.remove('selected'));
                    const selectedCard = document.querySelector(`[data-tipe="${tipeValue}"]`);
                    if (selectedCard) {
                        selectedCard.classList.add('selected');
                        
                        // Add animation effect
                        selectedCard.style.animation = 'cardPulse 0.5s ease';
                        setTimeout(() => {
                            selectedCard.style.animation = '';
                        }, 500);
                    }
                }
            }

            // Tipe Komentar Handler
            const tipeCards = document.querySelectorAll('.tipe-komentar-card');
            
            // Set initial selected card
            const checkedRadio = document.querySelector('input[name="tipe_komentar"]:checked');
            if (checkedRadio) {
                const selectedCard = document.querySelector(`[data-tipe="${checkedRadio.value}"]`);
                if (selectedCard) selectedCard.classList.add('selected');
            }

            tipeCards.forEach(card => {
                card.addEventListener('click', function() {
                    tipeCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                    const radio = this.querySelector('input[type="radio"]');
                    radio.checked = true;
                });
            });

            // Character Counter
            const textarea = document.getElementById('komentar');
            const charCount = document.getElementById('charCount');
            
            textarea.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = `${length}/1000`;
                
                if (length > 1000) {
                    charCount.classList.add('text-danger');
                } else {
                    charCount.classList.remove('text-danger');
                }
            });
            
            // Update on page load
            if (textarea.value) {
                charCount.textContent = `${textarea.value.length}/1000`;
            }

            // Form Validation
            const form = document.getElementById('komentarForm');
            form.addEventListener('submit', function(e) {
                if (!ratingInput.value) {
                    e.preventDefault();
                    alert('Mohon berikan rating terlebih dahulu');
                    return false;
                }
                
                if (textarea.value.length < 10) {
                    e.preventDefault();
                    alert('Komentar minimal 10 karakter');
                    textarea.focus();
                    return false;
                }
            });
        });
    </script>

  @endsection