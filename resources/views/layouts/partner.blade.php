<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Partner Portal') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Feather Icons -->
    <link href="{{ asset('admin/assets/css/feather.css') }}" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom Partner Portal CSS -->
    <link href="{{ asset('admin/assets/css/partner-portal.css') }}" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="{{ asset('admin/assets/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/datatables/css/buttons.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/datatable-custom.css') }}" rel="stylesheet">

    @if(app()->getLocale() == 'ar')
        <link href="{{ asset('assets/css/rtl.css') }}" rel="stylesheet">
    @endif

    @stack('styles')
</head>
<body class="partner-portal-body">
    <main class="nxl-container apps-container">
        <!-- Partner Sidebar -->
        @include('layouts.partials.partner-sidebar')

        <!-- Main Content Area -->
        <div class="nxl-content">
            <!-- Partner Header -->
            <div class="main-header partner-header agenda-2063-header">
                <!-- Row 1: Main Navigation -->
                <div class="header-row-1">
                    <div class="header-wrapper">
                        <div class="header-left d-flex align-items-center gap-4">
                            <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse">
                                <div class="hamburger hamburger--arrowturn">
                                    <div class="hamburger-box">
                                        <div class="hamburger-inner"></div>
                                    </div>
                                </div>
                            </a>

                            <!-- Branding -->
                            <div class="d-flex align-items-center gap-3">
                                <div class="au-logo-container">
                                    <img src="{{ asset('assets/images/au.png') }}" alt="African Union" class="au-header-logo">
                                </div>
                                <div class="brand-text">
                                    <h4 class="mb-0 fw-bold text-white organization-name">{{ auth()->user()->funderPortal->name ?? 'Partner Portal' }}</h4>
                                    <p class="mb-0 agenda-subtitle">
                                        <i class="feather-star me-1"></i>
                                        <span>Building The Africa We Want</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="header-right ms-auto">
                            <div class="d-flex align-items-center gap-3">
                                <!-- Language Selector -->
                                @include('components.language-selector')

                                <!-- User Profile -->
                                <div class="dropdown nxl-h-item">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" class="avatar-text avatar-md bg-white text-primary">
                                        <i class="feather-user"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <div class="dropdown-item">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-text avatar-md bg-primary text-white">
                                                    <i class="feather-user"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                                                    <small class="text-muted">{{ auth()->user()->email }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="feather-log-out me-2"></i>
                                                {{ __('partner.logout') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Rotating Agenda 2063 Messages -->
                <div class="header-row-2 agenda-marketing-banner">
                    <div class="container-fluid">
                        <div class="marketing-slider">
                            <div class="marketing-slide active" data-slide="1">
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <i class="feather-award fs-4 text-warning"></i>
                                    <div>
                                        <strong>Aspiration 1:</strong> A Prosperous Africa based on inclusive growth and sustainable development
                                    </div>
                                </div>
                            </div>
                            <div class="marketing-slide" data-slide="2">
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <i class="feather-users fs-4 text-warning"></i>
                                    <div>
                                        <strong>Aspiration 2:</strong> An integrated continent, politically united based on Pan-Africanism
                                    </div>
                                </div>
                            </div>
                            <div class="marketing-slide" data-slide="3">
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <i class="feather-shield fs-4 text-warning"></i>
                                    <div>
                                        <strong>Aspiration 3:</strong> An Africa of good governance, democracy, respect for human rights
                                    </div>
                                </div>
                            </div>
                            <div class="marketing-slide" data-slide="4">
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <i class="feather-globe fs-4 text-warning"></i>
                                    <div>
                                        <strong>Aspiration 4:</strong> A peaceful and secure Africa living in harmony
                                    </div>
                                </div>
                            </div>
                            <div class="marketing-slide" data-slide="5">
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <i class="feather-book fs-4 text-warning"></i>
                                    <div>
                                        <strong>Aspiration 5:</strong> An Africa with strong cultural identity, common heritage and values
                                    </div>
                                </div>
                            </div>
                            <div class="marketing-slide" data-slide="6">
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <i class="feather-trending-up fs-4 text-warning"></i>
                                    <div>
                                        <strong>Aspiration 6:</strong> An Africa whose development is people-driven, relying on potential of African people
                                    </div>
                                </div>
                            </div>
                            <div class="marketing-slide" data-slide="7">
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <i class="feather-flag fs-4 text-warning"></i>
                                    <div>
                                        <strong>Aspiration 7:</strong> Africa as a strong, united, resilient and influential global player
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            @yield('content')

            <!-- Footer -->
            <footer class="partner-footer">
                <p class="fs-11 text-uppercase text-muted mb-0">
                    &copy; {{ date('Y') }} Africa Think Tank Platform. All Rights Reserved.
                </p>
            </footer>
        </div>
    </main>

    <!-- jQuery -->
    <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap Bundle -->
    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Feather Icons -->
    <script src="{{ asset('admin/assets/js/feather.min.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('admin/assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/datatables/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/datatables/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/datatables/js/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/datatables/js/vfs_fonts.js') }}"></script>

    <!-- DataTable Config -->
    <script src="{{ asset('admin/assets/js/datatable-config.js') }}"></script>

    <!-- Welcome Modal for First-Time Login -->
    @if(session('first_time_partner_login'))
    <div class="modal fade" id="welcomeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content agenda-welcome-modal">
                <!-- Slide 1: Welcome Video -->
                <div class="welcome-slide active" data-slide="1">
                    <button type="button" class="btn-close-custom" onclick="skipWelcome()">
                        <i class="feather-x"></i>
                    </button>
                    <div class="slide-content text-center">
                        <div class="au-logo-large mb-4">
                            <img src="{{ asset('assets/images/au.png') }}" alt="African Union" style="height: 100px; filter: brightness(0) invert(1);">
                        </div>
                        <h2 class="text-white fw-bold mb-3">Welcome to the Africa We Want!</h2>
                        <p class="text-white-50 fs-5 mb-4">{{ auth()->user()->funderPortal->name ?? 'Dear Partner' }}</p>

                        <div class="video-container mb-4">
                            <video id="welcomeVideo" controls autoplay muted style="width: 100%; max-width: 800px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
                                <source src="{{ asset('assets/videos/agenda2063-intro.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>

                        <p class="text-white fs-6">
                            <i class="feather-heart text-danger me-2"></i>
                            Thank you for your invaluable contribution to Agenda 2063
                        </p>
                    </div>
                    <div class="slide-footer">
                        <div class="slide-indicators">
                            <span class="indicator active"></span>
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                        </div>
                        <button class="btn btn-light btn-lg" onclick="nextSlide()">
                            Next <i class="feather-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Slide 2: Aspiration 1 & 2 -->
                <div class="welcome-slide" data-slide="2">
                    <button type="button" class="btn-close-custom" onclick="skipWelcome()">
                        <i class="feather-x"></i>
                    </button>
                    <div class="slide-content">
                        <h3 class="text-white fw-bold mb-4 text-center">The Seven Aspirations</h3>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="aspiration-card">
                                    <img src="{{ asset('assets/images/aspirations/aspiration-1.jpg') }}" alt="Aspiration 1" class="aspiration-image">
                                    <div class="aspiration-overlay">
                                        <div class="aspiration-number">01</div>
                                        <h4>Prosperous Africa</h4>
                                        <p>Based on inclusive growth and sustainable development</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="aspiration-card">
                                    <img src="{{ asset('assets/images/aspirations/aspiration-2.jpg') }}" alt="Aspiration 2" class="aspiration-image">
                                    <div class="aspiration-overlay">
                                        <div class="aspiration-number">02</div>
                                        <h4>Integrated Continent</h4>
                                        <p>Politically united based on Pan-Africanism</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-footer">
                        <div class="slide-indicators">
                            <span class="indicator"></span>
                            <span class="indicator active"></span>
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                        </div>
                        <button class="btn btn-light btn-lg" onclick="nextSlide()">
                            Next <i class="feather-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Slide 3: Aspiration 3 & 4 -->
                <div class="welcome-slide" data-slide="3">
                    <button type="button" class="btn-close-custom" onclick="skipWelcome()">
                        <i class="feather-x"></i>
                    </button>
                    <div class="slide-content">
                        <h3 class="text-white fw-bold mb-4 text-center">Governance & Peace</h3>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="aspiration-card">
                                    <img src="{{ asset('assets/images/aspirations/aspiration-3.jpg') }}" alt="Aspiration 3" class="aspiration-image">
                                    <div class="aspiration-overlay">
                                        <div class="aspiration-number">03</div>
                                        <h4>Good Governance</h4>
                                        <p>Democracy, respect for human rights, justice and the rule of law</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="aspiration-card">
                                    <img src="{{ asset('assets/images/aspirations/aspiration-4.jpg') }}" alt="Aspiration 4" class="aspiration-image">
                                    <div class="aspiration-overlay">
                                        <div class="aspiration-number">04</div>
                                        <h4>Peaceful & Secure</h4>
                                        <p>A peaceful and secure Africa living in harmony</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-footer">
                        <div class="slide-indicators">
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                            <span class="indicator active"></span>
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                        </div>
                        <button class="btn btn-light btn-lg" onclick="nextSlide()">
                            Next <i class="feather-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Slide 4: Aspiration 5, 6 & 7 -->
                <div class="welcome-slide" data-slide="4">
                    <button type="button" class="btn-close-custom" onclick="skipWelcome()">
                        <i class="feather-x"></i>
                    </button>
                    <div class="slide-content">
                        <h3 class="text-white fw-bold mb-4 text-center">Culture, People & Global Influence</h3>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="aspiration-card">
                                    <img src="{{ asset('assets/images/aspirations/aspiration-5.jpg') }}" alt="Aspiration 5" class="aspiration-image">
                                    <div class="aspiration-overlay">
                                        <div class="aspiration-number">05</div>
                                        <h4>Cultural Identity</h4>
                                        <p>Common heritage & values</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="aspiration-card">
                                    <img src="{{ asset('assets/images/aspirations/aspiration-6.jpg') }}" alt="Aspiration 6" class="aspiration-image">
                                    <div class="aspiration-overlay">
                                        <div class="aspiration-number">06</div>
                                        <h4>People-Driven</h4>
                                        <p>Relying on African potential</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="aspiration-card">
                                    <img src="{{ asset('assets/images/aspirations/aspiration-7.jpg') }}" alt="Aspiration 7" class="aspiration-image">
                                    <div class="aspiration-overlay">
                                        <div class="aspiration-number">07</div>
                                        <h4>Global Player</h4>
                                        <p>Strong & influential Africa</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-footer">
                        <div class="slide-indicators">
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                            <span class="indicator active"></span>
                            <span class="indicator"></span>
                        </div>
                        <button class="btn btn-light btn-lg" onclick="nextSlide()">
                            Next <i class="feather-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Slide 5: Final Message with Countdown -->
                <div class="welcome-slide" data-slide="5">
                    <div class="slide-content text-center">
                        <div class="au-logo-large mb-4">
                            <img src="{{ asset('assets/images/au.png') }}" alt="African Union" style="height: 120px; filter: brightness(0) invert(1);">
                        </div>
                        <h2 class="text-white fw-bold mb-4">Together, We Build The Africa We Want!</h2>
                        <p class="text-white fs-5 mb-4">Your partnership drives continental transformation</p>

                        <div class="gratitude-message mb-5">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="appreciation-card">
                                        <i class="feather-award fs-1 text-warning mb-3"></i>
                                        <h4 class="text-white mb-3">Deep Gratitude</h4>
                                        <p class="text-white-50">
                                            On behalf of the African Union and 1.3 billion Africans, we express our profound gratitude
                                            for your commitment to Agenda 2063. Your support empowers programs that transform lives,
                                            build institutions, and shape Africa's prosperous future.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="countdown-container">
                            <p class="text-white-50 mb-3">Your portal opens in</p>
                            <div class="countdown-number" id="countdownNumber">3</div>
                        </div>
                    </div>
                    <div class="slide-footer">
                        <div class="slide-indicators">
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                            <span class="indicator"></span>
                            <span class="indicator active"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        // Initialize Feather Icons
        $(document).ready(function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });

        // Mobile menu toggle
        $(document).on('click', '#mobile-collapse', function() {
            $('.partner-sidebar').toggleClass('active');
        });

        // Toggle Submenu Function for Drill-Down Navigation
        function toggleSubmenu(element) {
            const $link = $(element);
            const $submenu = $link.next('.au-submenu');

            // Toggle the expanded class on the link
            $link.toggleClass('au-expanded');

            // Toggle the show class on the submenu
            $submenu.toggleClass('au-show');

            // Re-initialize Feather icons after DOM change
            setTimeout(function() {
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }, 50);
        }

        // Rotating Agenda 2063 messages in header
        let currentMarketingSlide = 1;
        const totalMarketingSlides = 7;

        function rotateMarketingMessages() {
            $('.marketing-slide').removeClass('active');
            currentMarketingSlide = currentMarketingSlide >= totalMarketingSlides ? 1 : currentMarketingSlide + 1;
            $(`.marketing-slide[data-slide="${currentMarketingSlide}"]`).addClass('active');

            // Re-initialize Feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        // Rotate every 5 seconds
        setInterval(rotateMarketingMessages, 5000);

        // Welcome Modal Management
        @if(session('first_time_partner_login'))
        let currentSlide = 1;
        const totalSlides = 5;
        let autoAdvanceInterval;
        let countdownInterval;
        let isAutoAdvancing = true;

        // Show modal on page load
        $(document).ready(function() {
            $('#welcomeModal').modal('show');
            startAutoAdvance();
        });

        function startAutoAdvance() {
            if (currentSlide < 5) {
                autoAdvanceInterval = setTimeout(() => {
                    if (isAutoAdvancing) {
                        nextSlide();
                    }
                }, 5000);
            }
        }

        function nextSlide() {
            if (currentSlide >= totalSlides) return;

            // Pause video if on first slide
            if (currentSlide === 1) {
                const video = document.getElementById('welcomeVideo');
                if (video) video.pause();
            }

            clearTimeout(autoAdvanceInterval);

            $('.welcome-slide').removeClass('active');
            currentSlide++;
            $(`.welcome-slide[data-slide="${currentSlide}"]`).addClass('active');

            if (currentSlide === 5) {
                // Start countdown on final slide
                startCountdown();
            } else {
                startAutoAdvance();
            }
        }

        function startCountdown() {
            let count = 3;
            $('#countdownNumber').text(count);

            countdownInterval = setInterval(() => {
                count--;
                if (count > 0) {
                    $('#countdownNumber').text(count);
                } else {
                    clearInterval(countdownInterval);
                    $('#countdownNumber').text('0');
                    setTimeout(() => {
                        closeWelcome();
                    }, 500);
                }
            }, 1000);
        }

        function skipWelcome() {
            isAutoAdvancing = false;
            clearTimeout(autoAdvanceInterval);
            clearInterval(countdownInterval);
            closeWelcome();
        }

        function closeWelcome() {
            $('#welcomeModal').modal('hide');
            // Mark welcome as seen
            $.post('{{ route("partner.welcome.seen") }}');
        }

        // Pause auto-advance when user interacts
        $('.welcome-slide').on('click', 'button', function() {
            clearTimeout(autoAdvanceInterval);
        });
        @endif
    </script>

    @stack('scripts')
</body>
</html>
