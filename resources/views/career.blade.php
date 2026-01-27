<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Careers at 3pap – Join Africa’s Procurement Transformation</title>


    <meta name="description"
        content="Explore open career opportunities at 3pap and be part of Africa’s digital procurement transformation." />
    <meta name="keywords" content="3pap careers, vacancies, procurement jobs, Africa, technology, digital procurement" />
    <meta name="author" content="3pap Team" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/style.css" />

    <style>
        :root {
            --gold: #fbbc05;
            --orange: #e16435;
            --magenta: #a70d53;
            --wine: #522b39;
            --light: #f7f4f2;
        }

        body {
            font-family: "Inter", sans-serif;
            background: var(--light);
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* ===== HERO ===== */
        .career-hero {
            position: relative;
            height: 380px;
            background: url('{{ asset('assets/three.webp') }}') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
        }

        .career-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(82, 43, 57, 0.75);
        }

        .career-hero .content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 1rem;
        }

        .career-hero h1 {
            color: var(--gold);
            font-size: 2.6rem;
        }

        .career-hero p {
            margin-top: 1rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        /* ===== CULTURE ===== */
        .culture {
            max-width: 1100px;
            margin: 4rem auto;
            padding: 0 2rem;
        }

        .culture h2 {
            color: var(--wine);
        }

        .culture ul {
            margin-top: 1.5rem;
            line-height: 1.8;
        }

        /* ===== FILTER ===== */
        .filter-bar {
            background: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
            border-radius: 12px;
            max-width: 900px;
            margin: 0 auto 3rem;
            padding: 1.5rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .filter-bar input {
            padding: .8rem 1rem;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 260px;
        }

        .filter-bar button {
            background: var(--magenta);
            color: #fff;
            border: none;
            padding: .8rem 1.6rem;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
        }

        /* ===== VACANCIES GRID ===== */
        .vacancies {
            max-width: 1200px;
            margin: 0 auto 5rem;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .vacancy-card {
            background: #fff;
            border-radius: 15px;
            padding: 1.8rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
        }

        .vacancy-card h4 {
            color: var(--wine);
        }

        .vacancy-meta {
            font-size: .9rem;
            color: var(--magenta);
            margin-bottom: .8rem;
        }

        .apply-btn {
            display: inline-block;
            margin-top: 1rem;
            background: var(--magenta);
            color: #fff;
            padding: .6rem 1.4rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }

        .apply-btn:hover {
            background: var(--orange);
        }

        @media(max-width:768px) {
            .filter-bar {
                flex-direction: column;
            }

            .filter-bar input,
            .filter-bar button {
                width: 100%;
            }
        }

        /* ===== APPLY MODAL ===== */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 1rem;
        }

        .modal.active {
            display: flex;
        }

        /* Wider modal with scrollable content */
        .modal-box {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            width: 100%;
            max-width: 1000px;
            /* Wider width */
            max-height: 90vh;
            /* Limit height to viewport */
            overflow-y: auto;
            /* Scrollbar if content exceeds height */
            text-align: left;
            position: relative;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        /* Modal header */
        .modal-box h3 {
            color: var(--magenta);
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .modal-box p {
            margin-bottom: 1rem;
            color: #333;
        }

        /* Close button */
        .close-btn {
            position: absolute;
            top: 12px;
            right: 15px;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--magenta);
            transition: color 0.3s;
        }

        .close-btn:hover {
            color: var(--orange);
        }

        /* Form fields */
        .modal-box .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        .modal-box textarea.form-control {
            resize: vertical;
        }

        /* File inputs */
        .modal-box input[type="file"] {
            border: 1px solid #ccc;
            padding: 0.6rem;
            border-radius: 8px;
            width: 100%;
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        /* Labels for file inputs */
        .modal-box label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #333;
        }

        /* Submit button */
        .modal-box .apply-btn {
            background: var(--magenta);
            color: #fff;
            border: none;
            padding: 0.8rem 1.6rem;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .modal-box .apply-btn:hover {
            background: var(--orange);
        }

        @media(max-width:768px) {
            .modal-box {
                padding: 1.5rem;
                max-width: 95%;
                max-height: 95vh;
            }
        }

        /* ===== SUCCESS MODAL ===== */
        #successModal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }

        #successModal.active {
            opacity: 1;
            pointer-events: auto;
        }

        #successModal .modal-box {
            max-width: 500px;
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background: #fff;
            transform: scale(0.8);
            transition: transform 0.4s ease;
        }

        #successModal.active .modal-box {
            transform: scale(1);
            /* zoom effect on open */
        }

        #successModal h3 {
            color: var(--magenta);
            font-size: 1.6rem;
            margin-bottom: 1rem;
        }

        #successModal p {
            color: #333;
            margin-bottom: 1.5rem;
        }

        #successModal .apply-btn {
            width: 50%;
            margin: 0 auto;
        }
    </style>


</head>

<body>

    <!-- ===== NAVBAR ===== -->

    <header class="navbar">
        <div class="logo">
            <img src="{{ asset('assets/images/3pap.white.bg.africa.png') }}" class="logo logo-sm" alt="3pap">
        </div>

        ```
        <nav class="nav-links">
            <a href="/">Home</a>
            <a href="#culture">Our Culture</a>
            <a href="#vacancies">Vacancies</a>
            <a href="{{ route('events') }}">Events</a>
            <a href="{{ route('careers') }}" class="active">Careers</a>
            <a href="{{ route('applicants.faq') }}">FAQs</a>
        </nav>

        <div class="nav-actions">
            <a href="{{ route('login') }}" class="btn btn-login">Login</a>
            <a href="{{ route('applicants.create') }}" class="btn btn-primary">Call for Proposals</a>
        </div>
        ```

    </header>

    <!-- ===== HERO ===== -->

    <section class="career-hero">
        <div class="content">
            <h1>Build Your Career With 3pap</h1>
            <p>
                Join a purpose-driven team transforming public procurement across Africa through technology,
                transparency, and innovation.
            </p>
        </div>
    </section>

    <!-- ===== CULTURE ===== -->



    <!-- ===== FILTER ===== -->
    <br>
    <div class="filter-bar" id="vacancies">
        <input type="text" id="searchInput" placeholder="Search vacancies...">
        <button onclick="filterVacancies()">Search</button>
    </div>

    <!-- ===== VACANCIES ===== -->

    <section class="vacancies" id="vacanciesContainer">


        @forelse($vacancies as $vacancy)
            <div class="vacancy-card">
                <h4>{{ $vacancy->title }}</h4>
                <div class="vacancy-meta">
                    Location: {{ $vacancy->location ?? 'Remote / Africa' }}
                </div>
                <p>{{ Str::limit($vacancy->description, 150) }}</p>

                <button class="apply-btn" data-id="{{ $vacancy->id }}" data-title="{{ $vacancy->title }}"
                    data-description="{{ $vacancy->description }}"
                    data-location="{{ $vacancy->location ?? 'Remote / Africa' }}" onclick="openApplyModal(this)">
                    Apply Now
                </button>
            </div>
        @empty
            <p style="grid-column:1/-1; text-align:center;">No vacancies available at the moment.</p>
        @endforelse


        <!-- ===== APPLY MODAL ===== -->
        <div class="modal" id="applyModal">
            <div class="modal-box" style="max-width:700px;">
                <button class="close-btn" onclick="closeApplyModal()">&times;</button>

                <h3 id="modalTitle">Apply for Position</h3>
                <p id="modalLocation" style="color:#a70d53; font-weight:600;"></p>
                <p id="modalDescription" style="margin-bottom:1.5rem;"></p>

                <form method="POST" action="{{ route('vacancies.apply.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="vacancy_id" id="vacancy_id">

                    <input type="text" name="full_name" placeholder="Full Name" required class="form-control mb-3">
                    <input type="email" name="email" placeholder="Email Address" required class="form-control mb-3">
                    <input type="text" name="phone" placeholder="Phone Number" required class="form-control mb-3">
                    <input type="text" name="nationality" placeholder="Nationality (optional)"
                        class="form-control mb-3">

                    <label>Upload CV (PDF/DOC/DOCX)</label>
                    <input type="file" name="resume" accept=".pdf,.doc,.docx" required class="form-control mb-3">

                    <label>Upload Cover Letter (PDF/DOC/DOCX)</label>
                    <input type="file" name="cover_letter" accept=".pdf,.doc,.docx" required
                        class="form-control mb-3">

                    <button type="submit" class="apply-btn" style="width:100%;">Submit Application</button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="modal" id="successModal">
                <div class="modal-box">
                    <button class="close-btn" onclick="closeSuccessModal()">&times;</button>
                    <h3>Application Submitted!</h3>
                    <p>Your job application has been sent successfully. We will review it and get back to you soon.</p>
                    <button class="apply-btn" onclick="closeSuccessModal()">Close</button>
                </div>
            </div>
        @endif



        <!-- ===== MODAL JS ===== -->
        <script>
            function openApplyModal(button) {
                document.getElementById('applyModal').classList.add('active');

                document.getElementById('modalTitle').innerText = button.dataset.title;
                document.getElementById('modalLocation').innerText = button.dataset.location;
                document.getElementById('modalDescription').innerText = button.dataset.description;
                document.getElementById('vacancy_id').value = button.dataset.id;
            }

            function closeApplyModal() {
                document.getElementById('applyModal').classList.remove('active');
            }
        </script>


    </section>

    <!-- ===== SCRIPT ===== -->

    <script>
        function filterVacancies() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('.vacancy-card').forEach(card => {
                card.style.display = card.innerText.toLowerCase().includes(search) ? 'block' : 'none';
            });
        }
    </script>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const successModal = document.getElementById('successModal');
            if (successModal) {
                successModal.classList.add('active');

                // Optional: auto-close after 3 seconds
                setTimeout(() => {
                    successModal.classList.remove('active');
                }, 3000);
            }
        });

        function closeSuccessModal() {
            const successModal = document.getElementById('successModal');
            if (successModal) {
                successModal.classList.remove('active');
            }
        }
    </script>




    <!-- ====== FOOTER ====== -->
    <footer id="contact" class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <h3>3pap.<span>Africa</span></h3>
                <p>Digitalizing procurement across Africa — empowering organizations with transparency and efficiency.
                </p>

            </div>

            <div class="footer-links">
                <h4>Quick Links</h4>
                <a href="#">Home</a>
                <a href="#process">System Flow</a>
                <a href="#customization">Customization</a>
                <a href="#">Contact</a>
            </div>

            <div class="footer-contact">
                <h4>Contact</h4>
                <p>Email: info@3pap.africa</p>
                <p>© 2025 3pap. All Rights Reserved.</p>
            </div>

        </div>
        <p style="margin-top: 10px; font-weight: 600; text-align: center;">
            A product of NPCT ESG Global Consultancy, Pretoria, RSA.
        </p>

    </footer>

</body>

</html>
