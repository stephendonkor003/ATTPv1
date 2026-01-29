@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">ATTP Portal Dashboard</h5>
                    </div>
                </div>
                <div class="page-header-right ms-auto text-end">
                    <div class="d-flex align-items-center">
                        <div class="me-3 text-muted small">
                            Welcome, <strong>{{ Auth::user()->name }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            {{-- Admin Dashboard --}}
            @if (Auth::user()->user_type === 'admin')
                <!-- Admin cards + charts -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <i class="feather-users fs-3 text-primary"></i>
                                <h6 class="mt-3 fw-bold">Total Applicants</h6>
                                <p class="fs-5">{{ $totalApplicants }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <i class="feather-globe fs-3 text-info"></i>
                                <h6 class="mt-3 fw-bold">Countries Participating</h6>
                                <p class="fs-5">{{ $countriesCount }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <i class="feather-check-circle fs-3 text-success"></i>
                                <h6 class="mt-3 fw-bold">Reviewed Applications</h6>
                                <p class="fs-5">{{ $reviewedApplicants }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Applications Trend (Last 7 Days)</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="applicationsChart" height="100"></canvas>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Applicants by Country</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="countryChart" height="100"></canvas>
                    </div>
                </div>

                {{-- Applicant Dashboard --}}
            @elseif(Auth::user()->user_type === 'applicant')
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold text-primary">Welcome to the Think Tank Initiative</h5>
                        <p>
                            The African Think Tank Project is dedicated to empowering policy research organizations
                            and innovation hubs across Africa. As an applicant, you're part of a growing network of
                            institutions committed to shaping Africa’s development agenda through evidence-based research,
                            collaboration, and innovation.
                        </p>
                        <p class="text-danger fw-semibold">
                            Please note: You have until <strong>August 22, 2025</strong> to edit or update your application.
                        </p>
                        <div class="mt-3">
                            <h6 class="text-muted">Time remaining:</h6>
                            <div id="countdown" style="font-size: 1.5rem; font-weight: bold;"></div>
                        </div>
                    </div>
                </div>

                <script>
                    const deadline = new Date("August 22, 2025 23:59:59").getTime();
                    const timer = setInterval(function() {
                        const now = new Date().getTime();
                        const distance = deadline - now;

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        if (distance < 0) {
                            clearInterval(timer);
                            document.getElementById("countdown").innerHTML = "Deadline Passed";
                        } else {
                            document.getElementById("countdown").innerHTML =
                                `${days}d ${hours}h ${minutes}m ${seconds}s`;
                        }
                    }, 1000);
                </script>

                {{-- Financial Evaluator Dashboard --}}
                {{-- Financial Evaluator Dashboard --}}
                {{-- Financial Evaluator Dashboard --}}
            @elseif(Auth::user()->user_type === 'financial_evaluator' || Auth::user()->user_type === 'evaluator')
                <style>
                    /* Same height for video & images */
                    #africaVideo,
                    #aspirationCarousel .carousel-img {
                        height: 300px;
                        /* adjust height as needed */
                        object-fit: cover;
                        /* crop instead of stretch */
                        border-radius: 8px;
                    }

                    /* Dark overlay */
                    .carousel-overlay {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0, 0, 0, 0.5);
                        /* semi-dark layer */
                        border-radius: 8px;
                    }

                    /* Centered caption text */
                    .carousel-caption-center {
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        font-size: 1rem;
                        font-weight: bold;
                        color: #fff;
                        text-align: center;
                        padding: 0 10px;
                        text-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
                    }
                </style>

                <div class="row g-3 mb-4">
                    <!-- Africa Aspirations Video -->
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="fw-bold text-success">The Africa We Want</h6>
                                <video id="africaVideo" class="w-100 rounded mb-2" autoplay muted loop playsinline controls>
                                    <source src="{{ asset('assets/images/Agenda2063.mp4') }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <p class="small text-muted">
                                    This platform empowers Africa’s journey towards <strong>Agenda 2063</strong> —
                                    <em>The Africa We Want</em>.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Image Carousel -->
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="fw-bold text-primary text-center">Agenda 2063 Aspirations</h6>

                                <div id="aspirationCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active position-relative">
                                            <img src="{{ asset('assets/images/Aspiration1.png') }}"
                                                class="d-block w-100 carousel-img" alt="Aspiration 1">
                                            <div class="carousel-overlay"></div>
                                            <div class="carousel-caption-center">
                                                A prosperous Africa based on inclusive growth and sustainable development.
                                            </div>
                                        </div>
                                        <div class="carousel-item position-relative">
                                            <img src="{{ asset('assets/images/Aspiration2.png') }}"
                                                class="d-block w-100 carousel-img" alt="Aspiration 2">
                                            <div class="carousel-overlay"></div>
                                            <div class="carousel-caption-center">
                                                An integrated continent, politically united, and based on the ideals of
                                                Pan-Africanism.
                                            </div>
                                        </div>
                                        <div class="carousel-item position-relative">
                                            <img src="{{ asset('assets/images/Aspiration3.png') }}"
                                                class="d-block w-100 carousel-img" alt="Aspiration 3">
                                            <div class="carousel-overlay"></div>
                                            <div class="carousel-caption-center">
                                                An Africa of good governance, democracy, respect for human rights, justice
                                                and the rule of law.
                                            </div>
                                        </div>
                                        <div class="carousel-item position-relative">
                                            <img src="{{ asset('assets/images/Aspiration4.png') }}"
                                                class="d-block w-100 carousel-img" alt="Aspiration 4">
                                            <div class="carousel-overlay"></div>
                                            <div class="carousel-caption-center">
                                                A peaceful and secure Africa.
                                            </div>
                                        </div>
                                        <div class="carousel-item position-relative">
                                            <img src="{{ asset('assets/images/Aspiration5.png') }}"
                                                class="d-block w-100 carousel-img" alt="Aspiration 5">
                                            <div class="carousel-overlay"></div>
                                            <div class="carousel-caption-center">
                                                An Africa with a strong cultural identity, common heritage, values and
                                                ethics.
                                            </div>
                                        </div>
                                        <div class="carousel-item position-relative">
                                            <img src="{{ asset('assets/images/Aspiration6.png') }}"
                                                class="d-block w-100 carousel-img" alt="Aspiration 6">
                                            <div class="carousel-overlay"></div>
                                            <div class="carousel-caption-center">
                                                An Africa whose development is people-driven, especially by its women and
                                                youth.
                                            </div>
                                        </div>
                                        <div class="carousel-item position-relative">
                                            <img src="{{ asset('assets/images/Aspiration7.png') }}"
                                                class="d-block w-100 carousel-img" alt="Aspiration 7">
                                            <div class="carousel-overlay"></div>
                                            <div class="carousel-caption-center">
                                                Africa as a strong, united, resilient and influential global player and
                                                partner.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Controls -->
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#aspirationCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#aspirationCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Typing Effect -->
                <div class="card shadow-sm mt-4">
                    <div class="card-body text-center">
                        <h6 class="fw-bold text-primary">Aspirations of Agenda 2063</h6>
                        <p id="aspirationText" class="fs-5 fw-semibold text-dark"></p>
                    </div>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const aspirations = [
                            "A prosperous Africa based on inclusive growth and sustainable development.",
                            "An integrated continent, politically united, and based on the ideals of Pan-Africanism.",
                            "An Africa of good governance, democracy, respect for human rights, justice and the rule of law.",
                            "A peaceful and secure Africa.",
                            "An Africa with a strong cultural identity, common heritage, values and ethics.",
                            "An Africa whose development is people-driven, especially by its women and youth.",
                            "Africa as a strong, united, resilient and influential global player and partner."
                        ];

                        let index = 0;
                        let charIndex = 0;
                        const typingSpeed = 60;
                        const pauseBetween = 2000;
                        const element = document.getElementById("aspirationText");

                        function typeWriter() {
                            if (charIndex < aspirations[index].length) {
                                element.textContent += aspirations[index].charAt(charIndex);
                                charIndex++;
                                setTimeout(typeWriter, typingSpeed);
                            } else {
                                setTimeout(() => {
                                    element.textContent = "";
                                    charIndex = 0;
                                    index = (index + 1) % aspirations.length;
                                    typeWriter();
                                }, pauseBetween);
                            }
                        }

                        typeWriter();
                    });
                </script>
            @endif




        </div>
    </main>

    {{-- Admin-only charts --}}
    @if (Auth::user()->user_type === 'admin')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('applicationsChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($applicationDates) !!},
                    datasets: [{
                        label: 'Applications',
                        data: {!! json_encode($applicationCounts) !!},
                        borderColor: '#3e95cd',
                        backgroundColor: 'rgba(62, 149, 205, 0.4)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'No. of Applications'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });

            const ctx2 = document.getElementById('countryChart').getContext('2d');
            const chart2 = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(\App\Models\Applicant::select('country')->groupBy('country')->pluck('country')) !!},
                    datasets: [{
                        label: 'Applicants',
                        data: {!! json_encode(\App\Models\Applicant::selectRaw('count(*) as count')->groupBy('country')->pluck('count')) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: '#4bc0c0',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Applicants'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Country'
                            }
                        }
                    }
                }
            });
        </script>
    @endif
@endsection
