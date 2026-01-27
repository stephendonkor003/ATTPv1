<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic Meta -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>3pap – Digital Procurement Simplified Across Africa</title>
    <meta name="description"
        content="3pap is Africa’s leading digital procurement platform designed to streamline tender management, supplier registration, and contract execution for public and private organizations." />
    <meta name="keywords"
        content="3pap, procurement, tenders, e-procurement Africa, supplier portal, contract management, digital procurement Ghana, bid portal Africa, RFQ, RFP, supplier registration, tender platform" />
    <meta name="author" content="3pap Team" />
    <meta name="robots" content="index, follow" />
    <meta name="language" content="en" />
    <meta name="theme-color" content="#017C76" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="3pap – Africa’s Digital Procurement Platform" />
    <meta property="og:description"
        content="Transforming Africa’s procurement landscape with transparency, efficiency, and innovation. Join 3pap today." />
    <meta property="og:image" content="https://3pap.africa/assets/images/3papafrica.png />
    <meta property="og:url"
        content="https://3pap.africa/" />
    <meta property="og:site_name" content="3pap" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="3pap – Digital Procurement Simplified Across Africa" />
    <meta name="twitter:description"
        content="Discover Africa’s trusted platform for e-procurement, supplier management, and contract automation." />
    <meta name="twitter:image" content="https://3pap.africa/assets/images/3papafrica.png" />
    <meta name="twitter:site" content="@3pap" />

    <!-- Favicon -->
    <link rel="icon" href="https://3pap.africa/assets/images/3papafrica.png" type="image/png" />

    <!-- Canonical URL -->
    <link rel="canonical" href="https://3pap.africa/" />

    <!-- Preload Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/style.css" />

    <!-- Schema.org Markup for Google -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "3pap",
      "url": "https://3pap.africa",
      "logo": "https://3pap.africa/assets/images/3papafrica.png",
      "sameAs": [
        "https://www.facebook.com/3pap",
        "https://twitter.com/3pap",
        "https://linkedin.com/company/3pap"
      ],
      "description": "3pap is a digital procurement platform transforming how organizations manage tenders, suppliers, and contracts across Africa.",
      "founder": {
        "@type": "Person",
        "name": "Stephen Amoakoh Donkor"
      }
    }
    </script>
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

    <!-- ====== HERO SECTION ====== -->
    <section class="hero">
        <div class="overlay"></div>

        <div class="slider">
            <div class="slide active" style="background-image: url('assets/a4.png');"></div>
            <div class="slide" style="background-image: url('assets/au2.png');"></div>
            <div class="slide" style="background-image: url('assets/three.webp');"></div>
        </div>

        <div class="hero-content">
            <br>
            <br>
            <h1 id="typewriter" class="typing-text"></h1>
            <p>Driving smarter, transparent, and automated procurement systems across Africa’s public and private
                sectors.</p>
            <a href="{{ route('public.procurement.index') }}" class="cta-btn">Explore Procurement Opportunities</a>
        </div>
    </section>

    <!-- ====== SYSTEM PROCESS FLOW ====== -->
    <!-- ====== SYSTEM PROCESS FLOW ====== -->
    <!-- ====== SYSTEM PROCESS FLOW ====== -->
    <section id="process" class="process-section">
        <h2>System Process Flow</h2>
        <p>
            A simplified workflow from submission to reporting — designed for speed, accuracy, and transparency.
        </p>

        <div class="process-flow">
            <div class="flow-card">
                <span>1</span>
                <h3>Applications</h3>
                <p>Submit and track procurement requests in real time with digital records.</p>
            </div>

            <div class="flow-card">
                <span>2</span>
                <h3>Prescreening</h3>
                <p>Automatically verify eligibility and completeness before evaluation.</p>
            </div>

            <div class="flow-card">
                <span>3</span>
                <h3>Evaluations</h3>
                <p>Score and review applications digitally with full transparency.</p>
            </div>

            <div class="flow-card">
                <span>4</span>
                <h3>Reporting</h3>
                <p>Generate instant analytics and reports for management decisions.</p>
            </div>
        </div>
    </section>



    <!-- ====== CUSTOMIZATION SECTION ====== -->
    <section id="customization" class="customization-section">
        <div class="content">
            <h2>Built to Fit Your Organization</h2>
            <p>
                Built to adapt to your structure and workflows — from approval stages to reporting.
                Configure modules, automate tasks, and manage users effortlessly.
            </p>
            <ul>
                <li>🔧 Custom approval levels</li>
                <li>🧩 Flexible workflow setup</li>
                <li>📊 Smart analytics dashboard</li>
                <li>🛡️ Secure role-based access</li>
            </ul>
        </div>
    </section>


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


    <script src="assets/script.js"></script>
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
