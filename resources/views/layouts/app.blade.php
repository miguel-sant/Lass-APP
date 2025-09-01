<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lass</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity=""
        crossorigin="anonymous" />

    <style>
        body {
            background: #f7f8fb;
        }

        .card-compact {
            border-radius: .9rem;
            box-shadow: 0 6px 18px rgba(20, 20, 50, .06);
        }

        .avatar-small {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .duo-friend {
            display: flex;
            gap: .75rem;
            align-items: center;
        }
        
        /* NOVO CSS PARA OS GRÁFICOS DE TURNO */
        .meal-period-chart-container {
            position: relative;
            width: 80px;
            height: 80px;
            cursor: pointer;
        }
        .meal-period-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #e5e7eb;
            color: #4b5563;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        .meal-period-chart-container canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100% !important;
            height: 100% !important;
        }

        /* responsive tweaks */
        @media (max-width:767px) {
            #macrosChart {
                height: 220px !important;
            }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Lass</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Hoje</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Amigos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Ofensivas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Perfil</a></li>
                    <li class="nav-item ms-3">
                        <form method="POST" action="#"><button
                                class="btn btn-outline-secondary btn-sm">Sair</button></form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>