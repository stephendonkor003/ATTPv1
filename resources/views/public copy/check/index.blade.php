<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Think Tank Consortium Lookup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ====== BOOTSTRAP ====== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ====== ICONS ====== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- ====== STYLES ====== -->
    <style>
        body {
            font-family: "Inter", sans-serif;
            background: linear-gradient(135deg, #198754, #0d6efd);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .lookup-container {
            background: #ffffff;
            color: #212529;
            border-radius: 1.2rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            width: 95%;
            max-width: 550px;
            padding: 40px 35px;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
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

        h3 {
            font-weight: 700;
            color: #198754;
        }

        p.subtitle {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 0.6rem;
            height: 50px;
            font-size: 1rem;
        }

        .btn-search {
            border-radius: 0.6rem;
            height: 50px;
            font-size: 1rem;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: #fff;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-search:hover {
            opacity: 0.9;
            transform: scale(1.03);
        }

        .alert {
            border-radius: 0.6rem;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <main class="lookup-container">

        <!-- HEADER -->
        <div class="mb-4">
            <h3><i class="bi bi-search me-2"></i>Consortium Evaluation Lookup</h3>
            <p class="subtitle">Enter your consortium name to check prescreening and evaluation progress.</p>
        </div>

        <!-- ALERTS -->
        @if (session('error'))
            <div class="alert alert-danger text-start mb-3">
                <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success text-start mb-3">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- SEARCH FORM -->
        <form id="lookupForm" method="POST" action="{{ route('public.check.search') }}">
            @csrf
            <div class="input-group input-group-lg mb-3">
                <input type="text" name="consortium_name" id="consortiumName" class="form-control"
                    placeholder="Enter Consortium Name" required>
                <button class="btn btn-search" type="submit">
                    <i class="bi bi-arrow-right-circle me-1"></i> Search
                </button>
            </div>
        </form>

        <p class="text-muted small mt-3">
            🔒 Please type the full consortium name as used in your submission.<br>
            You will see all prescreening and evaluation results instantly.
        </p>

        <footer>
            <p class="mt-4 mb-0">&copy; {{ date('Y') }} Think Tank Evaluation Portal — All Rights Reserved.</p>
        </footer>
    </main>

    <!-- ====== JAVASCRIPT ====== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("lookupForm");
            const input = document.getElementById("consortiumName");

            // Smooth input focus animation
            input.addEventListener("focus", () => input.style.boxShadow = "0 0 5px #0d6efd");
            input.addEventListener("blur", () => input.style.boxShadow = "none");

            // Simple validation before submit
            form.addEventListener("submit", function(e) {
                if (!input.value.trim()) {
                    e.preventDefault();
                    alert("Please enter a consortium name before searching.");
                }
            });
        });
    </script>
</body>

</html>
