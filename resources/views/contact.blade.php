<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>African Union - Bid</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <!-- CSS Files -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Covered+By+Your+Grace&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel='stylesheet' href='assets/css/bootstrap-datepicker.css'>
    <link rel='stylesheet' href='assets/css/jquery-ui.css'>
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/icons/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/meanmenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/niceselect.css">
    <link rel="stylesheet" href="assets/css/YouTubePopUp.css">
    <link rel="stylesheet" href="assets/css/scroll-up.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>


<body>

    <!-- Start Preloader -->
    <div class="preloader_wrap" onload="preloader()">
        <div class="preloaderstyle_wrap"><span class="preloaderStyle"></span></div>
        <div class="preloader_logo"><img src="assets/img/preloader.svg" alt=""></div>
    </div>
    <!-- End Preloader -->

    <!-- Offcanvas Area Start -->
    <div class="fix-area">
        <div class="offcanvas__info">
            <div class="offcanvas__wrapper">
                <div class="offcanvas__content">
                    <div class="offcanvas__top d-flex justify-content-between align-items-center">
                        <div class="offcanvas__logo">
                            <a href="index.html">
                                <img src="assets/img/logo.svg" alt="edutec">
                            </a>
                        </div>
                        <div class="offcanvas__close">
                            <button>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mobile-menu fix mb-3"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas__overlay"></div>
    <!-- Start Header -->

    <!-- Start Header Top -->
    <header class="header_top">
        <div class="container-xxl container-fluid">
            <div class="row">
                <div class="col-md-6 col-12 mb-md-0 mb-sm-2 text-center text-md-start">
                    <span class="align-self-center"><i class="ph ph-map-pin"></i> Addis , Ethiopia</span>
                    <div class="hline align-self-center"></div>
                    <span class="align-self-center tnumber"><a href=" "><i class="ph ph-phone"></i> Africa
                        </a></span>
                </div>

                <div class="col-md-6 col-12 text-center text-md-end">
                    <span class="align-self-center"><a href="{{ route('login') }}"><i class="ph ph-user-circle"></i>
                            Sign in or
                            Register</a></span>
                    <div class="hline align-self-center"></div>
                    <ul class="align-self-center">
                        <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!-- End Header Top -->

    <!-- Start Header -->
    <header id="tr_header">
        <div class="container-xxl container-fluid">
            <div class="row">
                <div
                    class="col-xl-7 col-md-3 col-12 gap-3 d-lg-flex d-block text-md-start text-center align-self-center">
                    <div class="site_logo d-inline-block">
                        <a href="#"><img src="assets/img/au.png" alt="Tourin"></a>
                    </div>

                    <nav class="main-menu align-self-center">
                        <ul>
                            <ul>
                                <li><a href="{{ route('landing.index') }}">Home</a></li>

                                <li>
                                    <a href="https://au.int/" target="_blank" rel="noopener noreferrer">
                                        AU Website
                                    </a>
                                </li>

                                <li><a href="{{ route('applicants.create') }}">Apply</a></li>

                                <li><a href="{{ route('landing.contact') }}">Contact Us</a></li>

                                <li>
                                    <a href="{{ asset('assets/au_application_materials.zip') }}" download>
                                        Download Materials
                                    </a>
                                </li>
                            </ul>


                        </ul>
                    </nav>
                </div><!-- End Col -->

                <div class="col-xl-5 col-md-9 col-12">
                    <div class="header_right d-flex justify-content-lg-end justify-content-center">



                        <a href="{{ route('applicants.create') }}"
                            class="yellow_btn d-none d-md-block align-self-center"><span>Apply
                                Now</span></a>

                        <div class="header__hamburger d-xl-none my-auto">
                            <div class="sidebar__toggle">
                                <i class="ph ph-list"></i>
                            </div>
                        </div>
                    </div>
                </div><!-- End Col -->
            </div>
        </div>
    </header>
    <!-- End Header -->

    <!-- Start Main Banner -->
    <section class="main_banner" style="background-image: url(assets/img/bg/cont.png);">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>Reach Us </h1>
                    <p><a href="#">Home</a> / Contact</p>
                </div>
            </div>
        </div>
    </section>
    <!-- End Main Banner -->

    <!-- Start Contact -->
    <section class="contact-area section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 col-12 wow fadeInUp">
                    <div class="cinfo-item">
                        <i class="ph ph-map-pin-area"></i>
                        <div class="cinfo_content">
                            <h3>Our Location</h3>
                            <p>
                                African Union Headquarters<br>
                                Roosevelt Street, W21K19<br>
                                PO Box 3243, Addis Ababa, Ethiopia
                            </p>
                        </div>
                    </div>
                </div><!-- End Col -->

                <div class="col-lg-4 col-md-6 col-12 wow fadeInUp">
                    <div class="cinfo-item">
                        <i class="ph ph-envelope-simple"></i>
                        <div class="cinfo_content">
                            <h3>Email Us</h3>
                            <p>Reach US via the Mail below:</br>
                                <a href="mailto:attpinfo@africanunion.org">attpinfo@africanunion.org</a>
                            </p>
                        </div>
                    </div>
                </div><!-- End Col -->

                <div class="col-lg-4 col-md-6 col-12 wow fadeInUp">
                    <div class="cinfo-item">
                        <i class="ph ph-user"></i>
                        <div class="cinfo_content">
                            <h3>Project Coordinator</h3>
                            <p>
                                Dr. Themba Chirwa<br>
                                Africa Think Tank Platform (ATTP)<br>
                                Partnerships & Resource Mobilization Directorate
                            </p>
                        </div>
                    </div>
                </div><!-- End Col -->


            </div><!-- End Row -->

            <div class="row mt-70">
                <div class="col-lg-12 col-12 mb-4 mb-lg-0 align-self-center wow fadeInUp">
                    <div class="contact_map">
                        <iframe height="600" width="100%" frameborder="0" style="border:0"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.1049582364684!2d38.763441874995764!3d9.012338090972498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b8547ec59c6b3%3A0x31973a3b2fdf0a9f!2sAfrican%20Union%20Headquarters!5e0!3m2!1sen!2set!4v1718545472054!5m2!1sen!2set"
                            allowfullscreen>
                        </iframe>

                    </div>
                </div><!-- End Col -->



            </div>

            <section id="faq" class="py-5 bg-light">
                <div class="container">
                    <div class="section-title text-center mb-5">
                        <h2>FREQUENTLY ASKED QUESTIONS (FAQ)</h2>
                    </div>

                    <div class="accordion" id="faqAccordion">

                        <!-- Project Overview -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-heading-a1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapse-a1">
                                    A. Project Overview & Background
                                </button>
                            </h2>
                            <div id="faq-collapse-a1" class="accordion-collapse collapse show"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <strong>1. What is the primary objective of the Africa Think Tank Platform (ATTP)
                                        project?</strong><br>
                                    The ATTP project aims to strengthen the capacity of the African Union Commission
                                    (AUC) for policymaking and implementation by harnessing resources from national and
                                    continental think tanks. It focuses on translating the ambitions of Agenda 2063 into
                                    tangible development outcomes for the continent, fostering an integrated,
                                    prosperous, and peaceful Africa. Ultimately, this initiative is intended to operate
                                    as a sustainable policymaking tool.
                                    <br><br>
                                    <strong>2. Who are the beneficiaries of the ATTP project?</strong><br>
                                    The direct and immediate beneficiaries are the relevant stakeholders who will
                                    benefit from support for strong policy-making capacity. This includes regional
                                    entities such as the AUC, its specialized agencies and RECs, African governments,
                                    think tanks, and Africans as the ultimate beneficiaries. Participating think tanks
                                    will receive various benefits, including support for research and analytical work on
                                    cross-boundary policy issues, policy engagement, policy adoption, and institutional
                                    capacity building. It is expected that approximately 15, or 1 percent, of the 1,300
                                    think tanks on the continent will directly benefit from the project.
                                </div>
                            </div>
                        </div>

                        <!-- Financial Management -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-heading-b1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapse-b1">
                                    B. Financial Management
                                </button>
                            </h2>
                            <div id="faq-collapse-b1" class="accordion-collapse collapse"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <strong>3. How is the ATTP project financed, and what is the total funding
                                        amount?</strong><br>
                                    The ATTP project is financed through an International Development Association (IDA)
                                    grant from the World Bank amounting to US$50 million. This funding is allocated for
                                    both regional and African initiatives within the project. The project life cycle is
                                    from July 2024 to June 2028.
                                    <br><br>

                                    <strong>4. What are the key components of financial management within the ATTP
                                        project?</strong><br>
                                    Financial Management (FM) for the project involves several crucial aspects,
                                    including budgetary controls, clearly defined procedures, managed fund
                                    flows/disbursements, a robust accounting system, qualified FM staffing, effective
                                    information/accounting systems, internal controls, financial reporting, auditing
                                    arrangements, adherence to FM covenants, and a detailed FM Action Plan. This
                                    includes actions such as ensuring that Annual Work Plans and budgets (AWP&B) are
                                    submitted for the Bank's No Objection and closely following up on budget
                                    utilization. A finance officer is to be recruited or assigned to the program, and
                                    necessary account codes are maintained in the AUC’s Systems, Applications, and
                                    Processing (SAP) for this program.
                                    <br><br>

                                    <strong>5. What procurement guidelines and procedures must be followed within the
                                        ATTP project?</strong><br>
                                    Procurement within the ATTP project must adhere to the World Bank's "Procurement
                                    Regulations for Investment Project Financing (IPF) Borrowers," specifically the
                                    Fourth Edition, November 2020. This includes preparing a detailed procurement plan,
                                    utilizing World Bank standard bidding documents, following up on solicitation
                                    documents with the Bank, and adhering to guidelines for international competitive
                                    bidding (ICB), bid evaluation, and contract award procedures. The Operations Support
                                    Services Directorate (OSSD/SCMD) is responsible for consolidating procurement plans
                                    and submitting them to the World Bank for review and approval through the World
                                    Bank’s internal procurement approval system, Systematic Tracking of Exchanges in
                                    Procurement (STEP).
                                    <br><br>

                                    <strong>6. What are the requirements for handling complaints related to procurement
                                        under the ATTP project?</strong><br>
                                    Complaints arising from national procurement procedures when approaching the
                                    national market may be handled in accordance with the Borrower’s national
                                    procurement complaints review procedures, if those provisions are acceptable to the
                                    Bank. However, for contracts following national procurement procedures that are
                                    identified to be prior reviewed by the Bank, paragraphs 3.2 to 3.5 of Annex III of
                                    the Procurement Regulations shall also apply. Complaints arising under contracts
                                    where Bank SPDs are required will be handled in accordance with Annex III of the
                                    Procurement Regulations.
                                    <br><br>

                                    <strong>7. What role does the Project Procurement Strategy for Development (PPSD)
                                        play in the ATTP project?</strong><br>
                                    The PPSD is a crucial document of AUC that outlines how procurement activities will
                                    support the development objectives of the ATTP project and deliver the best Value
                                    for Money (VfM) under a risk-based approach. It justifies the selection methods in
                                    the Procurement Plan and ensures that procurement decisions are strategically
                                    aligned with project goals.
                                    <br><br>

                                    <strong>8. What are the conditions for the disbursement of funds to selected think
                                        tanks?</strong><br>
                                    Disbursement of funds to the successful think tanks will only occur after the AU has
                                    internally approved the submitted agreed deliverables. The AUC will establish each
                                    winning think tank as a vendor in the AUC SAP system and assign a vendor ID. The
                                    think tank will submit an invoice to the ATTP project secretariat for processing
                                    after approval of the submitted deliverable. The AUC Finance will process the
                                    payment for each submitted deliverable by the think tank within 30 working days.
                                    <br><br>

                                    <strong>9. What are the conditions for disbursement of funds related to the
                                        Endowment Fund within the ATTP project?</strong><br>
                                    Disbursement to the Endowment Fund will only occur after the AU has internally
                                    approved and established the Endowment Fund through its internal policy organs and
                                    appointed a Fund Manager, all in a manner satisfactory to the AUC.
                                    <br><br>

                                    <strong>10. What measures are in place to address fraud, corruption, and conflicts
                                        of interest during procurement in the ATTP project?</strong><br>
                                    The ATTP project incorporates measures to prevent and address fraud, corruption, and
                                    conflicts of interest. The Bank can reject proposals, sanction firms or individuals,
                                    and require audits to ensure transparency and accountability. Firms or individuals
                                    declared ineligible or sanctioned by the Bank are excluded from participation.
                                    Bidders are required to permit the Bank to inspect all accounts, records, and other
                                    documents relating to the procurement process.
                                </div>
                            </div>
                        </div>


                        <!-- Project Governance -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-heading-c1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapse-c1">
                                    C. Project Governance
                                </button>
                            </h2>
                            <div id="faq-collapse-c1" class="accordion-collapse collapse"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <strong>11. What is the governance mechanism of the Project, and what is its
                                        role?</strong><br>
                                    The main governance body of the ATTP is the Think Tank Platform Steering Committee
                                    (TTPSC). The TTPSC's role is to provide strategic guidance and oversight for project
                                    implementation, ensuring effective coordination and collaboration among
                                    participating AUC departments and directorates.
                                    <br><br>

                                    <strong>12. What is the composition of the TTPSC?</strong><br>
                                    The TTPSC will comprise 12 members and have pan-African representation, including
                                    representatives from the AUC, AU organs, and specialized agencies, as well as
                                    representatives of relevant regional bodies (Regional Economic Communities, the
                                    private sector, academia), and development partners supporting the AUC.
                                    <br><br>

                                    <strong>13. What are the frequency and modality of TTPSC meetings?</strong><br>
                                    The TTPSC is expected to meet twice a year. This may include a meeting at the
                                    beginning of the year to discuss and approve work plans and budgets, and one at the
                                    end of the year to review annual reports. However, additional meetings may be
                                    required, for example, during the selection of think tanks and addressing other
                                    implementation issues as they arise. Meetings may be conducted in person or
                                    virtually, depending on the circumstances.
                                    <br><br>

                                    <strong>14. How are decisions made during TTPSC meetings?</strong><br>
                                    Decision-making will be made through majority vote. That requires support from more
                                    than 50% of the members who attend the meeting if there is a quorum. In the event of
                                    a tie, the Chair of the TTPSC will cast the decisive vote.
                                </div>
                            </div>
                        </div>


                        <!-- Think Tank Consortium Selection -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-heading-d1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapse-d1">
                                    D. Think Tank Consortium Selection
                                </button>
                            </h2>
                            <div id="faq-collapse-d1" class="accordion-collapse collapse"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <strong>15. How is the call for proposals linked to the ATTP Project?</strong><br>
                                    The project serves as a critical enabler of Africa's economic transformation by
                                    promoting and accelerating the uptake of relevant policies identified by think
                                    tanks. African think tanks will be invited to submit proposals that present
                                    practical solutions, highlight evidence, demonstrate strong potential for impact,
                                    and align with the project's objectives. The project will be executed in three
                                    components:
                                    <ul>
                                        <li>Component I: Establish capacity to operate a sustainable policymaking
                                            platform.</li>
                                        <li>Component II: Strengthen the quality, relevance, and uptake of policy
                                            research on priority issues.</li>
                                        <li>Component III: Support the sustainability of the regional platform.</li>
                                    </ul>
                                    The call for proposals responds to Component II. Visit the ATTP project portal on
                                    the World Bank Website for more.
                                    <br><br>

                                    <strong>16. What are the priority thematic areas covered under the
                                        project?</strong><br>
                                    The project initially targets six themes aligned with Agenda 2063, SDGs, and IDA
                                    priorities:
                                    <ol>
                                        <li>Economic transformation and governance</li>
                                        <li>Climate change and energy transition</li>
                                        <li>Regional trade and AfCFTA</li>
                                        <li>Food security</li>
                                        <li>Human capital development</li>
                                        <li>Digitalization</li>
                                    </ol>
                                    <br>

                                    <strong>17. What are the key areas for which the think tank consortia are expected
                                        to implement activities?</strong><br>
                                    <ol>
                                        <li><strong>Collaborative policy research:</strong> High-quality research
                                            addressing continental priorities and gaps in the policy cycle.</li>
                                        <li><strong>Effective policy engagement:</strong> Engagement strategies to
                                            influence policy formulation and ensure research uptake by stakeholders.
                                        </li>
                                        <li><strong>Institutional capacity building:</strong> Activities to improve
                                            sustainability, research strength, and talent development.</li>
                                        <li><strong>Female policy professional inclusion:</strong> Programs that mentor
                                            and elevate women in policy spaces.</li>
                                    </ol>
                                    Note: Activities must demonstrate regional relevance and potential positive
                                    externalities.
                                    <br><br>

                                    <strong>18. What are the key eligibility criteria that will be used for the
                                        selection of the think tanks?</strong><br>
                                    <ul>
                                        <li>Apply as a consortium of 3–5 African think tanks, with a lead.</li>
                                        <li>Minimum 3 years of legal operation, registration, board, and financial
                                            records.</li>
                                        <li>Cover at least 4 of the 6 priority themes.</li>
                                        <li>Commitment to regional integration.</li>
                                        <li>Signed commitment letter from all consortium members.</li>
                                    </ul>
                                    <br>

                                    <strong>19. How are think tanks and a consortium of think tanks defined in the
                                        context of the ATTP Project?</strong><br>
                                    A consortium is a group of African think tanks collaborating under one proposal.
                                    <ul>
                                        <li><strong>Lead Think Tank:</strong> Coordinates the consortium, provides
                                            strategic direction, and ensures goal delivery.</li>
                                        <li><strong>Consortium Member Think Tanks:</strong> Execute research, policy
                                            engagement, capacity building, and contribute technical expertise under
                                            thematic guidance.</li>
                                    </ul>
                                    <br>

                                    <strong>20. How is the selection process of the Think Tanks and the Consortium of
                                        Think Tanks conducted?</strong><br>
                                    The selection is a 3-step process:
                                    <ol>
                                        <li><strong>Screening:</strong> AUC staff checks eligibility and compliance.
                                        </li>
                                        <li><strong>Peer Review:</strong> ICE evaluates eligible proposals based on
                                            quality, team capacity, and budget.</li>
                                        <li><strong>Site Visits:</strong> ICE, AUC, and observers assess on-site
                                            readiness before final selection.</li>
                                    </ol>
                                    <br>

                                    <strong>21. How will funds be allocated to the selected consortium of Think
                                        Tanks?</strong><br>
                                    <ul>
                                        <li>2–4 consortia expected to be funded.</li>
                                        <li>Each consortium may receive up to $15 million over 4 years.</li>
                                        <li>Funding capped at 30% of annual operating budget per think tank.</li>
                                    </ul>
                                    <br>

                                    <strong>22. What are the key timeline of the selection process?</strong><br>
                                    <ul>
                                        <li>Proposal deadline: 22 August 2025</li>
                                        <li>Screening: 29 August 2025</li>
                                        <li>Evaluation: 12 September 2025</li>
                                        <li>Award notification: 3 October 2025</li>
                                        <li>Disbursement: 14 November 2025</li>
                                    </ul>
                                    <br>

                                    <strong>23. What languages does the application support?</strong><br>
                                    Proposals should be submitted in English. Applicants may also attach a version in
                                    another AU working language: Arabic, French, Portuguese, Spanish, or Kiswahili.
                                    <br><br>

                                    <strong>24. How many proposals can be submitted per consortium?</strong><br>
                                    Only one proposal per consortium is allowed. Only complete applications will be
                                    reviewed.
                                    <br><br>

                                    <strong>25. How will the applications be submitted?</strong><br>
                                    Applicants must use the provided templates and submit via the application portal:
                                    <em>[DAVID PLEASE PROVIDE A LINK TO THE SUBMISSION PAGE]</em> by the deadline.
                                    <br><br>

                                    <strong>26. How will the consortium's performance be monitored and measured under
                                        the ATTP Project?</strong><br>
                                    Performance is tracked annually against the Project Results Framework. Key points
                                    include:
                                    <ul>
                                        <li>10% of next year’s funding may be withheld if targets are not met but funds
                                            are used appropriately.</li>
                                        <li>Mid-term reviews may lead to fund reallocation based on performance.</li>
                                        <li>Less than 75% performance after 2 years = 10% reduction (unless
                                            exceptional).</li>
                                        <li>Less than 50% fund usage = 10% reduction of the excess unspent amount.</li>
                                    </ul>
                                    Sanctions and rewards are based on realistic targets, fund utilization, and
                                    adherence to the result framework.
                                    <br><br>

                                    <strong>27. How are disputes under the project settled?</strong><br>
                                    Disputes are referred to the TTPSC. Their decision is final.
                                    <br><br>

                                    <strong>28. Will the ATTP Secretariat organize an informational session for
                                        potential applicants?</strong><br>
                                    Yes. The AUC will organize sessions to educate applicants about the ATTP project,
                                    proposal development, and submission guidelines.
                                    <br><br>

                                    <strong>29. Who and how to contact the ATTP Secretariat if the applicants have
                                        additional questions or requests for clarification?</strong><br>
                                    Contact: <a href="mailto:attpinfo@africanunion.org">attpinfo@africanunion.org</a>
                                </div>
                            </div>
                        </div>


                        <!-- Roles & Responsibilities -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-heading-e1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapse-e1">
                                    E. Roles and Responsibilities
                                </button>
                            </h2>
                            <div id="faq-collapse-e1" class="accordion-collapse collapse"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <strong>30. What are the roles and responsibilities of the various institutions in
                                        relation to the project implementation arrangement?</strong><br><br>

                                    <strong>African Union Commission (AUC)</strong><br>
                                    <u>Coordinating Office – Partnerships Management & Resource Mobilization
                                        Directorate:</u>
                                    <ul>
                                        <li>Overall management and ensuring the achievement of project goals and
                                            objectives</li>
                                        <li>Manage secretariat support to the Think Tank Platform Steering Committee
                                            (TTPSC)</li>
                                        <li>Coordinate activities, organize meetings, and facilitate communication among
                                            implementing bodies</li>
                                        <li>Facilitate meetings, workshops, and conferences related to the project</li>
                                        <li>Manage the competitive selection process of think tanks</li>
                                        <li>Act as secretariat for TTPSC meetings</li>
                                        <li>Manage the general fund and establish an endowment fund</li>
                                        <li>Lead on environmental and social risk management (including grievance
                                            redress mechanism), monitoring & evaluation, and project-level reporting
                                            (financial and progress) to the World Bank</li>
                                    </ul>

                                    <u>AUC Thematic Departments (priority areas):</u>
                                    <ul>
                                        <li>Provide intellectual leadership on research related to regional economic
                                            priorities</li>
                                        <li>Oversee think tank work plans and proposal implementation</li>
                                        <li>Facilitate policy engagement, including collaboration with Technical TTs and
                                            Specialized Technical Committees (STCs)</li>
                                    </ul>

                                    <u>Directorate of Finance:</u>
                                    <ul>
                                        <li>Responsible for financial management of the project</li>
                                    </ul>

                                    <u>Operations Support Services Directorate:</u>
                                    <ul>
                                        <li>Responsible for procurement processes and compliance</li>
                                    </ul>

                                    <strong>African Capacity Building Foundation (ACBF)</strong>
                                    <ul>
                                        <li>Organize forums and knowledge exchange between researchers and policymakers
                                        </li>
                                        <li>Coordinate fellowships and secondment programs</li>
                                        <li>Lead training and capacity building for policymakers, civil society, and key
                                            stakeholders</li>
                                        <li>Strengthen think tanks in areas such as research quality, communications,
                                            resource mobilization, partnerships, and twinning arrangements</li>
                                        <li>Create a database of African and global think tanks</li>
                                        <li>Develop an online African Knowledge Repository</li>
                                        <li>Establish a peer network for female professionals</li>
                                        <li>Conduct a study on best practices to enhance female participation in policy
                                            research</li>
                                        <li>Lead policy community surveys</li>
                                    </ul>

                                    <strong>African Union Development Agency (AUDA-NEPAD)</strong>
                                    <ul>
                                        <li>Provide technical advisory support to think tanks’ research in priority
                                            areas</li>
                                        <li>Promote national adoption of research-informed policies and encourage
                                            collaboration on research activities</li>
                                        <li>Contribute to the development of the policy research agenda through
                                            engagement with think tanks, thematic directorates, and STCs</li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </section>

        </div>
    </section>
    <!-- End Contact -->





    <!-- Start progress-wrap -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- End progress-wrap -->

    <!-- JS Script -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src='assets/js/datepicker.min.js'></script>
    <script src='assets/js/swiper-bundle.min.js'></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.meanmenu.min.js"></script>
    <script src="assets/js/jquery.inview.min.js"></script>
    <script src="assets/js/mixitup.min.js"></script>
    <script src="assets/js/nicesellect.js"></script>
    <script src="assets/js/wow.js"></script>
    <script src="assets/js/YouTubePopUp.jquery.js"></script>
    <script src="assets/js/yvpopup-active.js"></script>
    <script src="assets/js/scroll-up.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/contact.js"></script>
    <script src="assets/js/search.js"></script>
    <script src="assets/js/newsletter.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1"></script>

</body>

</html>
