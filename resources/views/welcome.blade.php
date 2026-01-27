<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic Meta -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>ATTP ? African Think Tank Platform Administration | African Union</title>

    <meta name="description"
        content="ATTP (African Think Tank Platform Administration) is a pan-African knowledge and policy coordination platform supporting African Union institutions, think tanks, and development partners." />

    <meta name="keywords"
        content="ATTP, African Think Tank Platform, African Union policy, Africa governance, policy research Africa, AU think tanks, development policy Africa, public policy Africa, African institutions, research platform Africa" />

    <meta name="author" content="African Think Tank Platform Administration (ATTP)" />
    <meta name="robots" content="index, follow" />
    <meta name="language" content="en" />
    <meta name="theme-color" content="#0B4F6C" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/au3.jpg') }}" type="image/png" />

    <!-- Open Graph -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="ATTP ? African Think Tank Platform Administration" />
    <meta property="og:description"
        content="Strengthening Africa?s policy ecosystem through collaboration, research, and institutional coordination in support of the African Union." />
    <meta property="og:image" content="https://africathinktankplatform.africa/assets/images/au3.jpg" />
    <meta property="og:url" content="https://africathinktankplatform.africa/" />
    <meta property="og:site_name" content="ATTP" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="ATTP ? African Think Tank Platform Administration" />
    <meta name="twitter:description"
        content="A pan-African platform advancing policy research, governance, and institutional collaboration across Africa." />
    <meta name="twitter:image" content="https://africathinktankplatform.africa/assets/images/au.png" />
    <meta name="twitter:site" content="@ATTP_Africa" />

    <!-- Canonical URL -->
    <link rel="canonical" href="https://africathinktankplatform.africa/" />

    <!-- Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />

    <!-- Schema.org Markup -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "African Think Tank Platform Administration",
      "alternateName": "ATTP",
      "url": "https://africathinktankplatform.africa",
      "logo": "https://africathinktankplatform.africa/assets/images/au3.jpg",
      "description": "ATTP is a pan-African policy and research coordination platform supporting African Union institutions, think tanks, and development partners to strengthen governance and evidence-based decision-making across Africa.",
      "foundingLocation": {
        "@type": "Place",
        "name": "Africa"
      },
      "sameAs": [
        "https://www.linkedin.com/company/attp-africa",
        "https://twitter.com/ATTP_Africa"
      ]
    }
    </script>
</head>

<style>
    .annoucment {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
    }

    .annoucment .flow-card {
        width: calc(33.333% - 16px);
    }

    /* Tablet */
    @media (max-width: 992px) {
        .annoucment .flow-card {
            width: calc(50% - 12px);
        }
    }

    /* Mobile */
    @media (max-width: 576px) {
        .annoucment .flow-card {
            width: 100%;
        }
    }
</style>



<body>
    <!-- ====== NAVBAR ====== -->
    <header class="navbar">
        <div class="logo">
            {{-- 3pap<span>.africa</span> --}}
            <img src="{{ asset('assets/images/au.png ') }}" alt="ATTP" class="logo logo-sm">

        </div>
        <nav class="nav-links">
            <a href="{{ route('landing.index') }}">Home</a>
            <a href="#annoucements">Annoucements</a>
            <a href="{{ route('events') }}">Events / Webinars</a>
            {{-- <a href="#customization">Customization</a> --}}
            <a href="#contact">Contact</a>
            <a href="{{ route('careers.index') }}">Career</a>
        </nav>

        <div class="nav-actions">
            <a href="{{ route('login') }}" class="btn btn-login">Login</a>
            <a href="{{ route('public.procurement.index') }}" class="btn btn-primary">
                Policy Programs & Research
            </a>


        </div>
    </header>

    <!-- ====== HERO SECTION ====== -->
    <section class="hero">
        <div class="overlay"></div>

        <div class="slider">
            <div class="slide active" style="background-image: url('{{ asset('assets/images/au1.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('assets/images/au2.webp') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('assets/images/au3.jpg') }}');"></div>
        </div>

        <div class="hero-content">
            <br>
            <br>
            <h1 id="typewriter" class="typing-text"></h1>
            <p>
                Strengthening Africa's policy ecosystem by supporting African Union institutions,
                think tanks, and partners through coordinated governance and strategic insight.
            </p>

            <a href="{{ route('public.procurement.index') }}" class="cta-btn">
                Explore Policy Programs & Initiatives
            </a>
        </div>
    </section>

    <!-- ====== SYSTEM PROCESS FLOW ====== -->
    <!-- ====== SYSTEM PROCESS FLOW ====== -->
    <!-- ====== SYSTEM PROCESS FLOW ====== -->
    <section id="process" class="process-section">
        <h2>Institutional Process Flow</h2>
        <p>
            A comprehensive end-to-end framework supporting African Union programs,
            financial governance, procurement harmonization, compliance, and accountability.
        </p>

        <div class="process-flow">

            <div class="flow-card">
                <span>1</span>
                <h3>Strategic Policy Alignment</h3>
                <p>
                    Alignment of initiatives with African Union agendas, continental frameworks,
                    and approved policy priorities.
                </p>
            </div>

            <div class="flow-card">
                <span>2</span>
                <h3>Program & Project Identification</h3>
                <p>
                    Identification and definition of programs and projects based on strategic needs,
                    development goals, and institutional mandates.
                </p>
            </div>

            <div class="flow-card">
                <span>3</span>
                <h3>Budgetary Intelligence & Planning</h3>
                <p>
                    Financial analysis, cost estimation, and budget planning to support evidence-based
                    decision-making and fiscal sustainability.
                </p>
            </div>

            <div class="flow-card">
                <span>4</span>
                <h3>Budget Control & Authorization</h3>
                <p>
                    Validation, approval, and control of budget allocations to ensure compliance
                    with financial rules and expenditure limits.
                </p>
            </div>

            <div class="flow-card">
                <span>5</span>
                <h3>Procurement Standardization</h3>
                <p>
                    Application of harmonized procurement standards and procedures to promote
                    transparency, competition, and value for money.
                </p>
            </div>

            <div class="flow-card">
                <span>6</span>
                <h3>360? Evaluation & Due Diligence</h3>
                <p>
                    Comprehensive technical, financial, legal, and policy evaluations to ensure
                    full compliance and risk mitigation.
                </p>
            </div>

            <div class="flow-card">
                <span>7</span>
                <h3>Funds Commitment & Regulatory Approval</h3>
                <p>
                    Formal commitment of funds and regulatory clearance in accordance with
                    institutional, regional, and international regulations.
                </p>
            </div>

            <div class="flow-card">
                <span>8</span>
                <h3>Monitoring, Reporting & Audit</h3>
                <p>
                    Continuous performance monitoring, reporting, and audit readiness to ensure
                    accountability, transparency, and institutional learning.
                </p>
            </div>

        </div>
    </section>
    <section id="annoucements" class="process-section">
        <h2>ATTP Grants & Award Announcement</h2>
        <p>
            The African Think Tank Platform (ATTP) is pleased to officially announce the
            award of grants under the ATTP Call for Proposals.
        </p>

        <div class="annoucment">

            <div class="flow-card">
                <span>1</span>
                <h3>English (EN)</h3>
                <p>
                    Download the official ATTP Grants & Award Announcement document in English.
                </p>
                <a href="{{ asset('assets/award/ATTP_Award_Announcement_EN.pdf') }}" class="btn-view" target="_blank"
                    rel="noopener noreferrer">
                    Download English Version
                </a>
            </div>

            <div class="flow-card">
                <span>2</span>
                <h3>French (FR)</h3>
                <p>
                    Download the official ATTP Grants & Award Announcement document in French.
                </p>
                <a href="{{ asset('assets/award/ATTP_Award_Announcement_FR.pdf') }}" class="btn-view" target="_blank"
                    rel="noopener noreferrer">
                    Download French Version
                </a>
            </div>

            <div class="flow-card">
                <span>3</span>
                <h3>Arabic (AR)</h3>
                <p>
                    Download the official ATTP Grants & Award Announcement document in Arabic.
                </p>
                <a href="{{ asset('assets/award/ATTP_Award_Announcement_AR.pdf') }}" class="btn-view"
                    target="_blank" rel="noopener noreferrer">
                    Download Arabic Version
                </a>
            </div>

            <div class="flow-card">
                <span>4</span>
                <h3>Portuguese (PT)</h3>
                <p>
                    Download the official ATTP Grants & Award Announcement document in Portuguese.
                </p>
                <a href="{{ asset('assets/award/ATTP_Award_Announcement_PT.pdf') }}" class="btn-view"
                    target="_blank" rel="noopener noreferrer">
                    Download Portuguese Version
                </a>
            </div>

            <div class="flow-card">
                <span>5</span>
                <h3>Spanish (ES)</h3>
                <p>
                    Download the official ATTP Grants & Award Announcement document in Spanish.
                </p>
                <a href="{{ asset('assets/award/ATTP_Award_Announcement_ES.pdf') }}" class="btn-view"
                    target="_blank" rel="noopener noreferrer">
                    Download Spanish Version
                </a>
            </div>

            <div class="flow-card">
                <span>6</span>
                <h3>Swahili (SW)</h3>
                <p>
                    Download the official ATTP Grants & Award Announcement document in Swahili.
                </p>
                <a href="{{ asset('assets/award/ATTP_Award_Announcement_SW.pdf') }}" class="btn-view"
                    target="_blank" rel="noopener noreferrer">
                    Download Swahili Version
                </a>
            </div>

        </div>


    </section>





    <!-- ====== CUSTOMIZATION SECTION ====== -->
    <section id="customization" class="customization-section">
        <div class="content">
            <h2>Centralized Governance & Strategic Oversight</h2>
            <p>
                The ATTP platform provides a unified digital environment for centralizing
                institutional workflows, harmonizing reporting standards, and delivering
                real-time, bird?s-eye insight into funded programs and projects across Africa.
            </p>

            <ul>
                <li>End-to-end process flow centralization</li>
                <li>Harmonized reporting frameworks across institutions</li>
                <li>Executive-level visibility into funded programs and projects</li>
                <li>Consolidated dashboards for performance, finance, and compliance</li>
                <li>Secure, role-based access aligned with governance structures</li>
            </ul>
        </div>
    </section>



    <!-- ====== FOOTER ====== -->
    <footer id="contact" class="footer">
        <div class="footer-content">

            <div class="footer-logo">
                <h3>ATTP<span> Administration</span></h3>
                <p>
                    African Think Tank Platform Administration ? supporting African Union
                    institutions through centralized governance, policy coordination,
                    and strategic oversight of programs and funded initiatives.
                </p>
            </div>

            <div class="footer-links">
                <h4>Quick Links</h4>
                <a href="#">Home</a>
                <a href="#process">Institutional Process Flow</a>
                <a href="#customization">Centralized Oversight</a>
                <a href="#contact">Contact</a>
            </div>

            <div class="footer-contact">
                <h4>Contact</h4>
                <p>Email: attpinfo@africanunion.org</p>
                <p>? 2026 African Think Tank Platform Administration (ATTP)</p>
            </div>

        </div>

        <p style="margin-top: 10px; font-weight: 600; text-align: center;">
            Supporting African Union policy coordination, governance reform,
            and evidence-based decision-making across the continent.
        </p>

    </footer>



    <script src="{{ asset('assets/script.js') }}"></script>
    <!--Start of Tawk.to Script-->
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/6968b44f895de4198b902486/1jf0g0m8k';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
    <!--End of Tawk.to Script-->
</body>

</html>
