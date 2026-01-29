<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Impact Map - AT

TP Africa</title>

    <meta name="description"
        content="Explore ATTP's impact across Africa with our interactive map showing funding partners and projects by country and region." />
    <meta name="keywords" content="ATTP impact, Africa projects, funding map, regional development, think tank projects" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />

    <!-- Leaflet CSS for mapping -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Chart.js for comparisons -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('assets/css/rtl.css') }}">
    @endif

    <style>
        :root {
            --gold: #fbbc05;
            --orange: #e16435;
            --magenta: #a70d53;
            --wine: #522b39;
            --light: #f7f4f2;
            --dark: #1a1a1a;
        }

        body {
            font-family: "Inter", sans-serif;
            background: var(--light);
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Hero Section */
        .impact-hero {
            position: relative;
            height: 280px;
            background: linear-gradient(135deg, var(--wine) 0%, var(--magenta) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            overflow: hidden;
        }

        .impact-hero::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(251, 188, 5, 0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .impact-hero .content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            padding: 1rem;
        }

        .impact-hero h1 {
            color: var(--gold);
            font-size: 2.4rem;
            margin-bottom: 0.5rem;
        }

        .impact-hero p {
            font-size: 1rem;
            line-height: 1.6;
            opacity: 0.95;
        }

        /* Main Container with Sidebar Layout */
        .impact-main {
            max-width: 1600px;
            margin: 2rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
        }

        /* Filter Sidebar */
        .filter-sidebar {
            background: #fff;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .filter-sidebar h3 {
            color: var(--wine);
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--gold);
        }

        .filter-section {
            margin-bottom: 2rem;
        }

        .filter-section h4 {
            color: var(--magenta);
            font-size: 0.95rem;
            margin-bottom: 0.8rem;
        }

        .filter-checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 0.6rem;
            cursor: pointer;
        }

        .filter-checkbox input[type="checkbox"] {
            margin-right: 0.5rem;
            cursor: pointer;
            accent-color: var(--magenta);
        }

        .filter-checkbox label {
            font-size: 0.9rem;
            cursor: pointer;
        }

        .filter-reset {
            background: var(--magenta);
            color: #fff;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
        }

        .filter-reset:hover {
            background: var(--wine);
        }

        /* Content Area */
        .content-area {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* Tabs */
        .tabs {
            background: #fff;
            border-radius: 15px;
            padding: 1rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .tab-buttons {
            display: flex;
            gap: 1rem;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 1.5rem;
        }

        .tab-button {
            padding: 0.8rem 1.5rem;
            background: none;
            border: none;
            color: #666;
            font-weight: 600;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }

        .tab-button.active {
            color: var(--magenta);
            border-bottom-color: var(--magenta);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Map Container */
        .map-container {
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        #africa-map {
            width: 100%;
            height: 600px;
            border-radius: 10px;
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        }

        /* Comparison Section */
        .comparison-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .comparison-card {
            background: linear-gradient(135deg, var(--wine) 0%, var(--magenta) 100%);
            color: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .comparison-card h4 {
            color: var(--gold);
            margin-bottom: 1rem;
        }

        .comparison-stat {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        /* Request Form */
        .request-form-section {
            background: #fff;
            border-radius: 15px;
            padding: 2.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .request-form-section h2 {
            color: var(--wine);
            margin-bottom: 1.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--wine);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--magenta);
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .submit-btn {
            background: var(--magenta);
            color: #fff;
            border: none;
            padding: 1rem 2rem;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .submit-btn:hover {
            background: var(--wine);
            transform: translateY(-2px);
        }

        /* Popup Styling */
        .leaflet-popup-content-wrapper {
            background: rgba(26, 26, 26, 0.95);
            color: #fff;
            border-radius: 12px;
            padding: 0;
        }

        .popup-content {
            padding: 1.5rem;
        }

        .popup-country {
            font-size: 1.3rem;
            font-weight: 700;
            color: #fbbc05;
            margin-bottom: 1rem;
            border-bottom: 2px solid #a70d53;
            padding-bottom: 0.5rem;
        }

        .popup-stat {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.6rem;
            font-size: 0.95rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .impact-main {
                grid-template-columns: 1fr;
            }

            .filter-sidebar {
                position: static;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Success Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .success-modal {
            background: #fff;
            border-radius: 20px;
            padding: 3rem 2.5rem;
            max-width: 500px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.4s ease;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #999;
            cursor: pointer;
            transition: color 0.3s;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            color: var(--magenta);
            background: rgba(167, 13, 83, 0.1);
        }

        .modal-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: bounce 0.6s ease;
        }

        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .modal-title {
            color: var(--wine);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .modal-message {
            color: #555;
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .modal-button {
            background: linear-gradient(135deg, var(--magenta) 0%, var(--wine) 100%);
            color: #fff;
            border: none;
            padding: 0.9rem 2.5rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(167, 13, 83, 0.3);
        }

        .modal-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(167, 13, 83, 0.4);
        }

        .modal-subtitle {
            color: var(--magenta);
            font-size: 0.95rem;
            margin-top: 1rem;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">
            <img src="{{ asset('assets/images/ATTP.white.bg.africa.png') }}" class="logo logo-sm" alt="ATTP">
        </div>

        <nav class="nav-links">
            <a href="{{ route('landing.index') }}">{{ __('navigation.home') }}</a>
            <a href="{{ route('events') }}">{{ __('navigation.events') }}</a>
            <a href="{{ route('impact.map') }}" class="active">{{ __('navigation.impact_map') }}</a>
            <a href="{{ route('careers.index') }}">{{ __('navigation.careers') }}</a>
            <a href="{{ route('applicants.faq') }}">{{ __('navigation.faqs') }}</a>
        </nav>

        <div class="nav-actions">
            <x-language-selector style="landing" />
            <a href="{{ route('login') }}" class="btn btn-login">{{ __('navigation.login') }}</a>
            <a href="{{ route('public.procurement.index') }}" class="btn btn-primary">
                {{ __('landing.policy_programs') }}
            </a>
        </div>
    </header>

    <!-- Hero -->
    <section class="impact-hero">
        <div class="content">
            <h1>ATTP Impact Analytics Dashboard</h1>
            <p>
                Comprehensive insights into funding partners, regional impact, and project distribution across Africa.
                Use filters and comparison tools to analyze our continental reach.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="impact-main">

        <!-- Filter Sidebar -->
        <aside class="filter-sidebar">
            <h3>Advanced Filters</h3>

            <!-- Funding Partners Filter -->
            <div class="filter-section">
                <h4>Funding Partners</h4>
                @foreach($impactData['funding_partners'] as $partner)
                    <div class="filter-checkbox">
                        <input type="checkbox" id="partner-{{ $partner['id'] }}" value="{{ $partner['id'] }}" class="filter-partner" checked>
                        <label for="partner-{{ $partner['id'] }}">{{ $partner['name'] }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Regional Blocks Filter -->
            <div class="filter-section">
                <h4>Regional Blocks</h4>
                @foreach(array_keys($impactData['regional_data']) as $region)
                    <div class="filter-checkbox">
                        <input type="checkbox" id="region-{{ str_replace(' ', '-', strtolower($region)) }}" value="{{ $region }}" class="filter-region" checked>
                        <label for="region-{{ str_replace(' ', '-', strtolower($region)) }}">{{ $region }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Countries Filter -->
            <div class="filter-section">
                <h4>Top Countries</h4>
                @foreach(array_keys($impactData['country_data']) as $country)
                    <div class="filter-checkbox">
                        <input type="checkbox" id="country-{{ str_replace(' ', '-', strtolower($country)) }}" value="{{ $country }}" class="filter-country" checked>
                        <label for="country-{{ str_replace(' ', '-', strtolower($country)) }}">{{ $country }}</label>
                    </div>
                @endforeach
            </div>

            <button class="filter-reset" onclick="resetFilters()">Reset All Filters</button>
        </aside>

        <!-- Content Area -->
        <div class="content-area">

            <!-- Tabs -->
            <div class="tabs">
                <div class="tab-buttons">
                    <button class="tab-button active" onclick="switchTab('map')">Interactive Map</button>
                    <button class="tab-button" onclick="switchTab('comparison')">Comparisons</button>
                    <button class="tab-button" onclick="switchTab('request')">Request Information</button>
                </div>

                <!-- Map Tab -->
                <div class="tab-content active" id="map-tab">
                    <div class="map-container">
                        <h2 style="color: var(--wine); margin-bottom: 1rem;">Africa Impact Map</h2>
                        <p style="margin-bottom: 1.5rem;">Hover over countries to view project details. Use filters to narrow down specific partners or regions.</p>
                        <div id="africa-map"></div>
                    </div>
                </div>

                <!-- Comparison Tab -->
                <div class="tab-content" id="comparison-tab">
                    <h2 style="color: var(--wine); margin-bottom: 1.5rem;">Comparative Analysis</h2>

                    <div style="margin-bottom: 3rem;">
                        <h3 style="color: var(--magenta); margin-bottom: 1rem;">Funding Partners Comparison</h3>
                        <div class="comparison-grid" id="partners-comparison">
                            <!-- Dynamically populated -->
                        </div>
                    </div>

                    <div style="margin-bottom: 3rem;">
                        <h3 style="color: var(--magenta); margin-bottom: 1rem;">Regional Blocks Comparison</h3>
                        <div class="comparison-grid" id="regions-comparison">
                            <!-- Dynamically populated -->
                        </div>
                    </div>

                    <div>
                        <h3 style="color: var(--magenta); margin-bottom: 1rem;">Top Countries Comparison</h3>
                        <div class="comparison-grid" id="countries-comparison">
                            <!-- Dynamically populated -->
                        </div>
                    </div>
                </div>

                <!-- Request Tab -->
                <div class="tab-content" id="request-tab">
                    <div class="request-form-section">
                        <h2>Request for Information</h2>
                        <p style="margin-bottom: 2rem;">Whether you're a researcher, academic, citizen, or organization, we're here to provide you with the information you need about ATTP's impact across Africa.</p>

                        <form id="request-form" onsubmit="submitRequest(event)">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="requester_type">I am a *</label>
                                    <select id="requester_type" name="requester_type" required>
                                        <option value="">Select your role</option>
                                        <option value="researcher">Researcher</option>
                                        <option value="academic">Academic</option>
                                        <option value="citizen">Citizen of Member State</option>
                                        <option value="organization">Organization</option>
                                        <option value="government">Government Official</option>
                                        <option value="media">Media/Press</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="full_name">Full Name *</label>
                                    <input type="text" id="full_name" name="full_name" required placeholder="Enter your full name">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" id="email" name="email" required placeholder="your.email@example.com">
                                </div>

                                <div class="form-group">
                                    <label for="country">Country *</label>
                                    <input type="text" id="country" name="country" required placeholder="Your country">
                                </div>

                                <div class="form-group full-width">
                                    <label for="organization">Organization/Institution (Optional)</label>
                                    <input type="text" id="organization" name="organization" placeholder="Enter organization name">
                                </div>

                                <div class="form-group full-width">
                                    <label for="request_type">Type of Information Requested *</label>
                                    <select id="request_type" name="request_type" required>
                                        <option value="">Select information type</option>
                                        <option value="funding_data">Funding Data & Statistics</option>
                                        <option value="project_details">Project Details</option>
                                        <option value="regional_impact">Regional Impact Reports</option>
                                        <option value="partnership">Partnership Opportunities</option>
                                        <option value="research_collaboration">Research Collaboration</option>
                                        <option value="general_inquiry">General Inquiry</option>
                                    </select>
                                </div>

                                <div class="form-group full-width">
                                    <label for="message">Detailed Request/Message *</label>
                                    <textarea id="message" name="message" rows="6" required placeholder="Please provide details about your information request..."></textarea>
                                </div>

                                <div class="form-group full-width">
                                    <button type="submit" class="submit-btn">Submit Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal-overlay" id="success-modal" onclick="closeSuccessModal(event)">
        <div class="success-modal" onclick="event.stopPropagation()">
            <button class="modal-close" onclick="closeSuccessModal()">&times;</button>
            <div class="modal-icon">✅✉️</div>
            <h2 class="modal-title">Request Submitted Successfully!</h2>
            <p class="modal-message">
                Thank you for reaching out to ATTP. We've received your information request and sent a confirmation email to your inbox.
                <br><br>
                Our team will review your request and respond within <strong>2-3 business days</strong>.
            </p>
            <p class="modal-subtitle">✨ Check your email for detailed acknowledgement</p>
            <button class="modal-button" onclick="closeSuccessModal()">Got it, Thanks!</button>
        </div>
    </div>

    <!-- Footer -->
    <footer id="contact" class="footer" style="margin-top: 4rem;">
        <div class="footer-content">
            <div class="footer-logo">
                <h3>ATTP<span> Administration</span></h3>
                <p>{{ __('landing.footer_description') }}</p>
            </div>

            <div class="footer-links">
                <h4>{{ __('landing.footer_links_title') }}</h4>
                <a href="{{ route('landing.index') }}">{{ __('landing.footer_link_home') }}</a>
                <a href="{{ route('impact.map') }}">{{ __('navigation.impact_map') }}</a>
                <a href="{{ route('careers.index') }}">{{ __('navigation.careers') }}</a>
                <a href="#contact">{{ __('navigation.contact') }}</a>
            </div>

            <div class="footer-contact">
                <h4>{{ __('landing.footer_contact_title') }}</h4>
                <p>{{ __('landing.footer_email') }}</p>
                <p>{{ __('landing.footer_copyright', ['year' => date('Y')]) }}</p>
            </div>
        </div>

        <p style="margin-top: 10px; font-weight: 600; text-align: center;">
            Supporting African Union policy coordination, governance reform,
            and evidence-based decision-making across the continent.
        </p>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Data from backend
        const impactData = @json($impactData);

        // Initialize the map
        const map = L.map('africa-map', {
            center: [0, 20],
            zoom: 3,
            minZoom: 3,
            maxZoom: 8,
            scrollWheelZoom: true,
            zoomControl: true,
            attributionControl: false
        });

        let geojsonLayer;

        // Fetch and display Africa map
        fetch('https://raw.githubusercontent.com/johan/world.geo.json/master/countries.geo.json')
            .then(response => response.json())
            .then(data => {
                const africanCountries = [
                    'Algeria', 'Angola', 'Benin', 'Botswana', 'Burkina Faso', 'Burundi',
                    'Cameroon', 'Cape Verde', 'Cabo Verde', 'Central African Republic', 'Chad', 'Comoros',
                    'Democratic Republic of the Congo', 'Republic of the Congo', 'Djibouti',
                    'Egypt', 'Equatorial Guinea', 'Eritrea', 'Ethiopia', 'Gabon', 'Gambia',
                    'Ghana', 'Guinea', 'Guinea-Bissau', 'Ivory Coast', 'Côte d\'Ivoire', 'Kenya', 'Lesotho',
                    'Liberia', 'Libya', 'Madagascar', 'Malawi', 'Mali', 'Mauritania',
                    'Mauritius', 'Morocco', 'Mozambique', 'Namibia', 'Niger', 'Nigeria',
                    'Rwanda', 'São Tomé and Príncipe', 'Sao Tome and Principe', 'Senegal', 'Seychelles', 'Sierra Leone',
                    'Somalia', 'South Africa', 'South Sudan', 'Sudan', 'Swaziland', 'Eswatini', 'Tanzania',
                    'Togo', 'Tunisia', 'Uganda', 'Zambia', 'Zimbabwe', 'Western Sahara'
                ];

                const africaGeoJSON = {
                    type: "FeatureCollection",
                    features: data.features.filter(feature => {
                        const countryName = feature.properties.name || feature.properties.NAME || feature.properties.ADMIN;
                        return africanCountries.some(african =>
                            countryName && (
                                countryName.toLowerCase() === african.toLowerCase() ||
                                countryName.toLowerCase().includes(african.toLowerCase())
                            )
                        );
                    })
                };

                addGeoJSONToMap(africaGeoJSON);
                populateComparisons();
            });

        function addGeoJSONToMap(africaGeoJSON) {
            function style(feature) {
                return {
                    fillColor: '#a70d53',
                    weight: 3,
                    opacity: 1,
                    color: '#ffffff',
                    fillOpacity: 0.95
                };
            }

            function getCountryName(feature) {
                return feature.properties.name || feature.properties.NAME || feature.properties.ADMIN || 'Unknown';
            }

            function highlightFeature(e) {
                const layer = e.target;
                const countryName = getCountryName(e.target.feature);
                const data = impactData.country_data[countryName];

                layer.setStyle({
                    weight: 4,
                    color: '#fbbc05',
                    fillColor: '#fbbc05',
                    fillOpacity: 1
                });

                layer.bringToFront();

                if (data) {
                    const popupContent = `
                        <div class="popup-content">
                            <div class="popup-country">${countryName}</div>
                            <div class="popup-stat">
                                <span style="color: #aaa;">Projects:</span>
                                <span style="font-weight: 600;">${data.projects}</span>
                            </div>
                            <div class="popup-stat">
                                <span style="color: #aaa;">Funding:</span>
                                <span style="font-weight: 600;">$${(data.funding / 1000000).toFixed(1)}M</span>
                            </div>
                            <div class="popup-stat">
                                <span style="color: #aaa;">Population:</span>
                                <span style="font-weight: 600;">${data.population}M</span>
                            </div>
                            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2);">
                                <strong>Key Sectors:</strong><br>${data.sector}
                            </div>
                        </div>
                    `;
                    layer.bindPopup(popupContent).openPopup();
                }
            }

            function resetHighlight(e) {
                geojsonLayer.resetStyle(e.target);
                e.target.closePopup();
            }

            function onEachFeature(feature, layer) {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight
                });
            }

            geojsonLayer = L.geoJSON(africaGeoJSON, {
                style: style,
                onEachFeature: onEachFeature
            }).addTo(map);

            map.fitBounds(geojsonLayer.getBounds(), {
                padding: [30, 30],
                maxZoom: 4,
                animate: true,
                duration: 1.5
            });
        }

        // Tab switching
        function switchTab(tabName) {
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            event.target.classList.add('active');
            document.getElementById(`${tabName}-tab`).classList.add('active');
        }

        // Populate comparisons
        function populateComparisons() {
            // Partners
            const partnersHtml = impactData.funding_partners.map(partner => `
                <div class="comparison-card">
                    <h4>${partner.name}</h4>
                    <div class="comparison-stat">
                        <span>Total Funding:</span>
                        <span>$${(partner.amount / 1000000).toFixed(1)}M</span>
                    </div>
                    <div class="comparison-stat">
                        <span>Projects:</span>
                        <span>${partner.projects}</span>
                    </div>
                    <div class="comparison-stat">
                        <span>Countries:</span>
                        <span>${partner.countries}</span>
                    </div>
                    <div class="comparison-stat">
                        <span>Focus Areas:</span>
                        <span>${partner.focus}</span>
                    </div>
                </div>
            `).join('');
            document.getElementById('partners-comparison').innerHTML = partnersHtml;

            // Regions
            const regionsHtml = Object.entries(impactData.regional_data).map(([region, data]) => `
                <div class="comparison-card">
                    <h4>${region}</h4>
                    <div class="comparison-stat">
                        <span>Total Funding:</span>
                        <span>$${(data.funding / 1000000).toFixed(1)}M</span>
                    </div>
                    <div class="comparison-stat">
                        <span>Projects:</span>
                        <span>${data.projects}</span>
                    </div>
                    <div class="comparison-stat">
                        <span>Partners:</span>
                        <span>${data.partners}</span>
                    </div>
                    <div class="comparison-stat">
                        <span>Member States:</span>
                        <span>${data.countries.length}</span>
                    </div>
                </div>
            `).join('');
            document.getElementById('regions-comparison').innerHTML = regionsHtml;

            // Countries
            const countriesHtml = Object.entries(impactData.country_data).map(([country, data]) => `
                <div class="comparison-card">
                    <h4>${country}</h4>
                    <div class="comparison-stat">
                        <span>Funding:</span>
                        <span>$${(data.funding / 1000000).toFixed(1)}M</span>
                    </div>
                    <div class="comparison-stat">
                        <span>Projects:</span>
                        <span>${data.projects}</span>
                    </div>
                    <div class="comparison-stat">
                        <span>Region:</span>
                        <span>${data.region}</span>
                    </div>
                    <div class="comparison-stat">
                        <span>Population:</span>
                        <span>${data.population}M</span>
                    </div>
                </div>
            `).join('');
            document.getElementById('countries-comparison').innerHTML = countriesHtml;
        }

        // Reset filters
        function resetFilters() {
            document.querySelectorAll('.filter-partner, .filter-region, .filter-country').forEach(cb => {
                cb.checked = true;
            });
        }

        // Submit request form
        function submitRequest(e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);

            fetch('{{ route('impact.request') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    e.target.reset();
                    showSuccessModal();
                } else {
                    alert('Error submitting request. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error submitting request. Please try again.');
            });
        }

        // Show success modal
        function showSuccessModal() {
            document.getElementById('success-modal').classList.add('show');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        // Close success modal
        function closeSuccessModal(event) {
            // Only close if clicking the overlay itself or the close button
            if (!event || event.target.id === 'success-modal' || event.target.classList.contains('modal-close') || event.target.classList.contains('modal-button')) {
                document.getElementById('success-modal').classList.remove('show');
                document.body.style.overflow = ''; // Restore scrolling
            }
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSuccessModal();
            }
        });
    </script>

</body>

</html>
