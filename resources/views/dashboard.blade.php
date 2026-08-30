{{-- Halaman Home / Dashboard Utama --}}
@extends('layouts.app')

@section('title', 'Home - Hotel Booking System')

@section('content')

    {{-- Hero Banner Home --}}
    <div class="hero-banner shadow-sm mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <h1 class="display-5 fw-bold mb-2">Selamat Datang di Hotel Booking System</h1>
                <p class="lead mb-4">Nikmati kenyamanan menginap terbaik dengan pilihan kamar Standard, Deluxe, dan Suite berfasilitas lengkap.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('rooms.index') }}" class="btn btn-light btn-lg text-primary fw-bold px-4">
                        <i class="bi bi-door-open me-1"></i> Lihat Semua Kamar
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-person-plus me-1"></i> Daftar Akun Tamu
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <i class="bi bi-building display-1 text-white opacity-75"></i>
            </div>
        </div>
    </div>

    {{-- Status Login User --}}
    @auth
        <div class="alert alert-info border-0 shadow-sm d-flex justify-content-between align-items-center mb-4">
            <div>
                <i class="bi bi-person-check-fill fs-5 me-2"></i>
                Anda sedang login sebagai <strong>{{ Auth::user()->name }}</strong>
                @if(Auth::user()->isAdmin())
                    <span class="badge bg-danger ms-1">Mode Administrator</span>
                @else
                    <span class="badge bg-primary ms-1">Mode Tamu</span>
                @endif
            </div>
            <div>
                <a href="{{ route('bookings.index') }}" class="btn btn-sm btn-info text-white">
                    <i class="bi bi-journal-bookmark me-1"></i> Lihat Booking Saya
                </a>
            </div>
        </div>
    @endauth

    {{-- Statistik Hotel (Cards) --}}
    <div class="row g-4 mb-5">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="display-4 text-primary mb-2">
                        <i class="bi bi-building"></i>
                    </div>
                    <h5 class="card-title text-muted">Total Kamar</h5>
                    <p class="display-6 fw-bold mb-0">{{ $totalRooms }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="display-4 text-success mb-2">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h5 class="card-title text-muted">Kamar Tersedia</h5>
                    <p class="display-6 fw-bold mb-0">{{ $availableRooms }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="display-4 text-warning mb-2">
                        <i class="bi bi-journal-bookmark"></i>
                    </div>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <h5 class="card-title text-muted">Total Booking Aktif</h5>
                            <p class="display-6 fw-bold mb-0">{{ $activeBookings }}</p>
                        @else
                            <h5 class="card-title text-muted">Booking Aktif Saya</h5>
                            <p class="display-6 fw-bold mb-0">{{ $myBookings }}</p>
                        @endif
                    @else
                        <h5 class="card-title text-muted">Total Booking Aktif</h5>
                        <p class="display-6 fw-bold mb-0">{{ $activeBookings }}</p>
                    @endauth
                </div>
            </div>
        </div>

    </div>

    {{-- Preview Kamar Tersedia --}}
    @if(isset($sampleRooms) && $sampleRooms->count() > 0)
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold mb-0"><i class="bi bi-star text-warning me-2"></i>Pilihan Kamar Siap Huni</h3>
                <a href="{{ route('rooms.index') }}" class="text-decoration-none fw-bold">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="row g-4">
                @foreach($sampleRooms as $room)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary fs-6">Kamar {{ $room->room_number }}</span>
                                    <span class="badge bg-success">Tersedia</span>
                                </div>
                                <h4 class="fw-bold">{{ $room->room_type }}</h4>
                                <p class="text-primary fw-bold fs-5 mb-3">
                                    Rp {{ number_format($room->price, 0, ',', '.') }} <small class="text-muted fs-6">/ malam</small>
                                </p>
                                @auth
                                    <a href="{{ route('bookings.create', $room) }}" class="btn btn-outline-primary w-100">
                                        <i class="bi bi-journal-plus me-1"></i> Booking Kamar ini
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Login untuk Booking
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@endsection
