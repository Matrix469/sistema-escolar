<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --accent-color: #ec4899;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Figtree', sans-serif;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }

        /* Neumorphic Card Style */
        .neu-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 8px 8px 16px rgba(0, 0, 0, 0.1),
                        -8px -8px 16px rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
        }

        .neu-card:hover {
            box-shadow: 12px 12px 24px rgba(0, 0, 0, 0.15),
                        -12px -12px 24px rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
        }

        /* Event Cards */
        .event-card-container {
            margin-bottom: 2rem;
        }

        .event-card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .event-card-body {
            padding: 0.5rem;
        }

        .event-desc {
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .event-date {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .event-participants {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Progress Card */
        .progress-main-card {
            margin-bottom: 2rem;
            position: relative;
        }

        .progress-info-items {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .info-item {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .progress-circle-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto;
        }

        .progress-ring {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(
                var(--primary-color) 0%,
                var(--primary-color) 50%,
                var(--bg-color) 50%,
                var(--bg-color) 100%
            );
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .progress-ring::before {
            content: '';
            width: 110px;
            height: 110px;
            background: white;
            border-radius: 50%;
            position: absolute;
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 10;
        }

        .progress-text span {
            display: block;
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .progress-text strong {
            font-size: 2rem;
            color: var(--primary-color);
            font-weight: 700;
        }

        /* Small Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .small-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .small-card:hover {
            transform: translateY(-4px);
        }

        .card-icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
        }

        .icon-athena {
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
        }

        .icon-const {
            background: linear-gradient(135deg, #f59e0b, #ef4444);
        }

        .icon-projects {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .icon-teams {
            background: linear-gradient(135deg, #ec4899, #be185d);
        }

        .card-content-box h4 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .card-content-box p {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* Left and Right Columns */
        .left-col, .right-col {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="dashboard-container">
            @yield('content')
        </main>
    </div>
</body>
</html>