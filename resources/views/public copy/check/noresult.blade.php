<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>No Consortium Found - Think Tank Lookup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ====== BOOTSTRAP ====== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ====== ICONS ====== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- ====== STYLES ====== -->
    <style>
        body {
            font-family: "Inter", sans-serif;
            background: linear-gradient(135deg, #0d6efd, #198754);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .noresult-container {
            background: #ffffff;
            color: #212529;
            border-radius: 1.2rem;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.2);
            width: 95%;
            max-width: 500px;
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
            color: #dc3545;
        }

        p.subtitle {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 25px;
        }

        .btn-back {
            border-radius: 0.6rem;
            height: 50px;
            font-size: 1rem;
            background: linear-gradient(135deg, #198754, #0f5132);
            color: #fff;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            transform: scale(1.05);
        }

        .icon-wrapper {
            background: #ffe5e9;
            color: #dc3545;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 20px auto;
            box-shadow: 0 0 10px rgba(220, 53, 69, 0.4);
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
    <main class="noresult-container">

        <!-- ERROR ICON -->
        <div class="icon-wrapper">
            <i class="bi bi-exclamation-octagon"></i>
        </div>

        <!-- HEADER -->
        <h3>No Consortium Found</h3>
        <p class="subtitle">
            Sorry, we couldn’t find any consortium matching your search.<br>
            Please double-check the spelling or try again using your full consortium name.
        </p>

        <!-- BACK BUTTON -->
        <a href="{{ route('public.check') }}" class="btn btn-back w-100">
            <i class="bi bi-arrow-left-circle me-1"></i> Back to Search
        </a>

        <footer>
            <p class="mt-4 mb-0">&copy; {{ date('Y') }} Think Tank Evaluation Portal — All Rights Reserved.</p>
        </footer>
    </main>

    <!-- ====== JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
