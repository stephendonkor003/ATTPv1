<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>3pap Events – Empowering Africa’s Procurement Future</title>
    <meta name="description"
        content="Explore upcoming 3pap events, workshops, and procurement innovation forums across Africa." />
    <meta name="keywords"
        content="3pap events, procurement forums, Africa, digital procurement, workshops, training, conferences" />
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

        /* ===== Header Section ===== */
        .events-header {
            position: relative;
            background: url('/assets/three.webp') center/cover no-repeat;
            height: 380px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
        }

        .events-header::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(82, 43, 57, 0.7);
        }

        .events-header .header-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 0 1rem;
        }

        .events-header h1 {
            font-size: 2.5rem;
            color: var(--gold);
        }

        .events-header p {
            margin-top: 1rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        /* ===== Filter Section ===== */
        .filter-bar {
            background: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
            border-radius: 12px;
            max-width: 1100px;
            margin: -60px auto 2rem;
            padding: 1.5rem 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }

        .filter-bar input,
        .filter-bar select {
            padding: .8rem 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            width: 240px;
        }

        .filter-bar button {
            background: var(--magenta);
            color: #fff;
            border: none;
            padding: .9rem 1.6rem;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        .filter-bar button:hover {
            background: var(--orange);
        }

        /* ===== Events Grid ===== */
        .events-container {
            max-width: 1200px;
            margin: 0 auto 5rem;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .event-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
            transition: transform .3s ease;
        }

        .event-card:hover {
            transform: translateY(-5px);
        }

        .event-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .event-card .card-body {
            padding: 1.2rem;
        }

        .event-card h4 {
            color: var(--wine);
            margin-bottom: .5rem;
        }

        .event-card p {
            color: #555;
            font-size: .95rem;
            margin-bottom: 1rem;
        }

        .event-date {
            color: var(--magenta);
            font-weight: 600;
            font-size: .9rem;
        }

        .btn-view {
            background: var(--magenta);
            color: #fff;
            padding: .6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: .3s;
        }

        .btn-view:hover {
            background: var(--orange);
        }

        /* ===== Modal ===== */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 100;
        }

        .modal.active {
            display: flex;
        }

        .modal-box {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            max-width: 600px;
            text-align: center;
            position: relative;
        }

        .modal-box h3 {
            color: var(--magenta);
        }

        .close-btn {
            position: absolute;
            top: 12px;
            right: 15px;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--magenta);
        }

        /* ===== Footer ===== */
        /* .footer {
            background: var(--wine);
            color: #fff;
            padding: 3rem 1rem;
            text-align: center;
        }

        .footer a {
            color: var(--gold);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media(max-width:768px) {
            .filter-bar {
                flex-direction: column;
            }

            .filter-bar input,
            .filter-bar select,
            .filter-bar button {
                width: 100%;
            }
        } */
    </style>
</head>

<body>
    <!-- ====== NAVBAR ====== -->
    <header class="navbar">
        <div class="logo">
            {{-- 3pap<span>.africa</span> --}}
            <img src="{{ asset('assets/images/3pap.white.bg.africa.png') }}" alt="" class="logo logo-sm">

        </div>
        <nav class="nav-links">
            <a href="{{ route('landing.index') }}">Home</a>
            <a href="#process">System Flow</a>
            <a href="#customization">Customization</a>
            <a href="#contact">Contact</a>
            <a href="{{ route('events') }}">Events</a>
            <a href="{{ route('careers.index') }}">Career</a>
        </nav>

        <div class="nav-actions">
            <a href="{{ route('login') }}" class="btn btn-login">Login</a>
            <a href="{{ route('public.procurement.index') }}" class="btn btn-primary">Procurement Opportunities</a>

        </div>
    </header>

    <!-- ====== APPLICATION DESCRIPTION ====== -->
    <section class="application-header">
        <div class="overlay"></div>
        <div class="header-content">
            </br>
            <h1>Webinars and Events </h1>
            <p>
                Submit your organization’s details to begin digitalizing your procurement process.
                This Platform ensures automation, compliance, and real-time visibility across every stage of
                procurement.
            </p>
        </div>
    </section>
    <!-- ====== HEADER ====== -->
    <br>
    <br>
    <br>
    <br>
    <br>
    <!-- ====== FILTER BAR ====== -->


    <!-- ====== WEBINARS FILTER BAR ====== -->
    <div class="filter-bar">
        <input type="text" placeholder="Search by keyword..." id="searchInput" />
        <button onclick="filterEvents()">Search</button>
    </div>

    <!-- ====== WEBINARS GRID ====== -->
    <section class="events-container" id="eventsContainer">
        <div class="event-card">
            <img src="{{ asset('assets/three.webp') }}" alt="Webinar 1">
            <div class="card-body">
                <h4>July 24, 2025: Launch of 3pap Call for Proposals</h4>
                <p class="event-date">Status: Completed</p>
                <p>
                    This webinar introduced the call for proposals and provided an overview of the eligibility criteria,
                    submission
                    guidelines, and key objectives of the 3pap initiative.
                </p>
                <p><strong>Recording:</strong> <a href="#" class="btn-view">View Recording</a></p>
            </div>
        </div>

        <div class="event-card">
            <img src="{{ asset('assets/three.webp') }}" alt="Webinar 2">
            <div class="card-body">
                <h4>August 5, 2025: Follow-up Webinar</h4>
                <p class="event-date">Time: 2:00 pm EAT | Status: Completed</p>
                <p>
                    This webinar provided an overview of the 3pap Consortium Application Form and guided participants on
                    navigating
                    the 3pap website. It clarified eligibility requirements and consortium formation.
                </p>
                <p><strong>Recording:</strong> <a href="#" class="btn-view">View Recording</a></p>
            </div>
        </div>

        <div class="event-card">
            <img src="{{ asset('assets/1.jpg') }}" alt="Webinar 3">
            <div class="card-body">
                <h4>August 26, 2025: Follow-up Webinar</h4>
                <p class="event-date">Time: 2:00 pm EAT | Status: Completed</p>
                <p>
                    This session provided detailed guidance on proposal development—covering the budget and timeline
                    template,
                    eligible expenses, CV Template, Past Research and Experience Template, and Commitment Letter.
                </p>
                <p><strong>Recording:</strong> <a href="#" class="btn-view">View Recording</a></p>
            </div>
        </div>

        <div class="event-card">
            <img src="{{ asset('assets/2.jpeg') }}" alt="Webinar 4">
            <div class="card-body">
                <h4>September 8, 2025: Follow-up Webinar</h4>
                <p class="event-date">Time: 2:00 pm EAT | Status: Completed</p>
                <p>
                    This webinar was conducted to address key topics for applicants and offer additional clarity on
                    submission
                    readiness.
                </p>
                <p><strong>Recording:</strong> <a href="#" class="btn-view">View Recording</a></p>
            </div>
        </div>

        <div class="event-card">
            <img src="{{ asset('assets/3.png') }}" alt="Webinar 5">
            <div class="card-body">
                <h4>September 23, 2025: Final Follow-up Webinar</h4>
                <p class="event-date">Time: 2:00 pm EAT | Status: Completed</p>
                <p>
                    This webinar addressed final participant questions and helped applicants prepare for the submission
                    deadline on
                    September 24, 2025.
                </p>
                <p><strong>Recording:</strong> <a href="#" class="btn-view">View Recording</a></p>
            </div>
        </div>

        <div class="event-card">
            <img src="{{ asset('assets/one.webp') }}" alt="How to Apply Video">
            <div class="card-body">
                <h4>Watch Our Step-By-Step Guide on How to Apply</h4>
                <ul style="list-style: disc; padding-left: 20px;">

                    {{-- <li>Watch our <strong>How to Apply Video </strong>: <br><a href="#" class="btn-view">View
                            Video</a></li> --}}
                    {{-- <li>Watch our <strong>How to Apply Video (French)</strong>: <a href="#" class="btn-view">View
                            French Video</a></li> --}}
                </ul>
            </div>
        </div>

        <div class="event-card">
            <img src="{{ asset('assets/three.webp') }}" alt="FAQ">
            <div class="card-body">
                <h4>Response to Clarification Questions</h4>
                <p>
                    For all clarification questions asked, please refer to the updated Frequently Asked Questions on the
                    FAQ page.
                    You can access it here:
                </p>
                <p><a href="https://3pap.africa/faq" class="btn-view">Visit 3pap FAQ Page</a></p>
            </div>
        </div>
    </section>

    <!-- ====== STYLING FOR 3-COLUMN GRID ====== -->
    <style>
        .events-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto 5rem;
            padding: 0 2rem;
        }

        @media (max-width: 992px) {
            .events-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .events-container {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        function filterEvents() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.event-card');
            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                card.style.display = text.includes(search) ? 'block' : 'none';
            });
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



    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/69204852eba156195f5dae48/1jaj1l0r8';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->


</body>

</html>
