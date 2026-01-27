<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Consortium Evaluation Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ====== BOOTSTRAP + ICONS ====== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- ====== CHART & PDF ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        body {
            font-family: "Inter", sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)),
                url('{{ asset('assets/images/Aspiration2.png') }}') center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 60px 20px;
        }

        .report-box {
            background: rgba(255, 255, 255, 0.97);
            border-radius: 1.2rem;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.3);
            max-width: 1100px;
            width: 100%;
            padding: 50px 60px;
            animation: fadeIn 1s ease-in-out;
            backdrop-filter: blur(10px);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            font-weight: 800;
            color: #198754;
            text-align: center;
        }

        h5.section-title {
            font-weight: 700;
            color: #0d6efd;
            border-left: 4px solid #0d6efd;
            padding-left: 10px;
            margin-top: 40px;
        }

        .summary-card {
            text-align: center;
            border-radius: .8rem;
            padding: 18px;
            background: #f8f9fa;
            transition: .3s;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
        }

        .summary-card:hover {
            transform: scale(1.05);
        }

        .btn-download {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border: none;
            color: #fff;
            padding: 12px 30px;
            border-radius: 50px;
            transition: .3s;
            font-weight: 600;
        }

        .btn-download:hover {
            opacity: .9;
            transform: scale(1.05);
        }

        .email-alert {
            position: fixed;
            top: 30px;
            right: 30px;
            background: #fff;
            border-left: 6px solid;
            padding: 15px 20px;
            border-radius: .6rem;
            box-shadow: 0 5px 25px rgba(0, 0, 0, .2);
            display: none;
            z-index: 9999;
            min-width: 260px;
            font-weight: 500;
        }

        .email-alert.success {
            border-color: #198754;
            color: #198754;
        }

        .email-alert.error {
            border-color: #dc3545;
            color: #dc3545;
        }

        table th {
            background: #e9f2ff !important;
        }
    </style>
</head>

<body>
    <div class="report-box" id="report-section">
        <h2>📘 Consortium Evaluation Report</h2>
        <p class="text-center text-muted mb-5">Comprehensive summary of your consortium’s prescreening and evaluation
            outcome.</p>

        <!-- Consortium Info -->
        <section>
            <h5 class="section-title">Consortium Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Consortium Name:</strong> {{ $consortium->consortium_name }}</p>
                    <p><strong>Think Tank:</strong> {{ $consortium->think_tank_name }}</p>
                    <p><strong>Email:</strong> {{ $consortium->email }}</p>
                </div>

                <div class="col-md-6">
                    <p><strong>Country:</strong> {{ $consortium->country ?? 'N/A' }}</p>

                    <p><strong>Region:</strong>
                        @php
                            $region = $consortium->sub_region;

                            // Handle if it's JSON, array, or plain text
if (is_string($region)) {
    $decoded = json_decode($region, true);
    echo $decoded ? implode(', ', $decoded) : e($region);
} elseif (is_array($region)) {
    echo implode(', ', $region);
} else {
    echo e($region ?? 'N/A');
                            }
                        @endphp
                    </p>

                    <p><strong>Covered Countries:</strong>
                        @php
                            $countries = $consortium->covered_countries;

                            if (is_string($countries)) {
                                $decoded = json_decode($countries, true);
                                echo $decoded ? implode(', ', $decoded) : e($countries);
                            } elseif (is_array($countries)) {
                                echo implode(', ', $countries);
                            } else {
                                echo e($countries ?? 'N/A');
                            }
                        @endphp
                    </p>

                </div>
            </div>
        </section>


        <!-- Prescreening -->
        <section>
            <h5 class="section-title">Prescreening</h5>
            <div class="card border-0 bg-light p-3">
                <p><strong>Eligibility:</strong>
                    @if (strtolower($prescreening->eligible ?? '') == 'yes')
                        <span class="badge bg-success">Eligible</span>
                    @elseif (strtolower($prescreening->eligible ?? '') == 'no')
                        <span class="badge bg-danger">Not Eligible</span>
                    @else
                        <span class="badge bg-secondary">Pending</span>
                    @endif
                </p>
                <p><strong>Remarks:</strong> {{ $prescreening->remarks ?? 'No remarks available.' }}</p>
            </div>
        </section>

        <!-- Evaluation -->
        <section>
            <h5 class="section-title">Evaluation Results</h5>
            <div class="table-responsive">
                <table class="table table-hover text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Evaluator</th>
                            <th>Proposal</th>
                            <th>Personnel</th>
                            <th>Budget</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($analysis as $index => $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>Evaluator {{ $loop->iteration }}</td>
                                <td>{{ $row['proposal'] }}</td>
                                <td>{{ $row['personnel'] }}</td>
                                <td>{{ $row['budget'] }}</td>
                                <td><strong>{{ $row['total'] }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted">No evaluation records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Summary -->
        <section>
            <h5 class="section-title">Performance Summary</h5>
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <div class="summary-card">
                        <h6>Avg. Proposal</h6>
                        <h4 class="text-primary">{{ $summary['avg_proposal'] }}</h4>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="summary-card">
                        <h6>Avg. Personnel</h6>
                        <h4 class="text-warning">{{ $summary['avg_personnel'] }}</h4>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="summary-card">
                        <h6>Avg. Budget</h6>
                        <h4 class="text-success">{{ $summary['avg_budget'] }}</h4>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="summary-card">
                        <h6>Overall Avg</h6>
                        <h4 class="text-danger">{{ $summary['avg_total'] }}</h4>
                    </div>
                </div>
            </div>
        </section>

        <!-- Chart -->
        <section class="mt-5">
            <h5 class="section-title">Evaluator Score Comparison</h5>
            <canvas id="evaluationChart" height="100"></canvas>
        </section>

        <!-- Email Request -->
        <section class="mt-5">
            <h5 class="section-title">Request Full Report via Email</h5>
            <form id="emailForm" method="POST" action="{{ route('public.check.email') }}">
                @csrf
                <input type="hidden" name="consortium_id" value="{{ $consortium->id }}">
                <div class="row g-3 align-items-center">
                    <div class="col-md-8">
                        <input type="email" name="email" id="emailInput" class="form-control form-control-lg"
                            placeholder="Enter registered email" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success w-100 py-2">
                            <i class="bi bi-send me-1"></i> Send Report
                        </button>
                    </div>
                </div>
                <p class="text-muted mt-2 small">Only the email used during submission will receive this report.</p>
            </form>
        </section>

        <div class="text-center mt-4">
            <button class="btn btn-download" onclick="downloadPDF()">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Download Full PDF Report
            </button>
        </div>
    </div>

    <!-- Alert Popup -->
    <div id="emailAlert" class="email-alert"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Chart
            const ctx = document.getElementById("evaluationChart");
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode(collect($analysis)->map(fn($row, $i) => 'Evaluator ' . ($i + 1))) !!},
                        datasets: [{
                                label: "Proposal",
                                data: {!! json_encode(collect($analysis)->pluck('proposal')) !!},
                                backgroundColor: "#0d6efd"
                            },
                            {
                                label: "Personnel",
                                data: {!! json_encode(collect($analysis)->pluck('personnel')) !!},
                                backgroundColor: "#fd7e14"
                            },
                            {
                                label: "Budget",
                                data: {!! json_encode(collect($analysis)->pluck('budget')) !!},
                                backgroundColor: "#198754"
                            }
                        ]
                    },
                    options: {
                        plugins: {
                            legend: {
                                position: "bottom"
                            }
                        }
                    }
                });
            }

            // PDF Download
            window.downloadPDF = function() {
                const el = document.getElementById("report-section");
                const opt = {
                    margin: 0.2,
                    filename: 'Consortium_Report.pdf',
                    html2canvas: {
                        scale: 4,
                        useCORS: true
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'a4',
                        orientation: 'portrait'
                    }
                };
                html2pdf().set(opt).from(el).save();
            };

            // AJAX Email Submit
            const form = document.getElementById("emailForm");
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const email = document.getElementById("emailInput").value;
                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: new FormData(form)
                    })
                    .then(res => res.text())
                    .then(data => {
                        showEmailAlert("✅ Report successfully sent to " + email, "success");
                    })
                    .catch(err => {
                        showEmailAlert("❌ Email not found or invalid. Please use the submission email.",
                            "error");
                    });
            });

            function showEmailAlert(msg, type) {
                const alertBox = document.getElementById("emailAlert");
                alertBox.textContent = msg;
                alertBox.className = "email-alert " + type;
                alertBox.style.display = "block";
                setTimeout(() => alertBox.style.display = "none", 4000);
            }
        });
    </script>

</body>

</html>
