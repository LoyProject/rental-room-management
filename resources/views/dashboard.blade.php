@extends('layouts.app')

@section('title', '​ទំព័រដើម')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Sites -->
                <div class="bg-white border rounded-lg p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-purple-50 text-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a1 1 0 001 1h16a1 1 0 001-1V7M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2" />
                            </svg>
                        </div>
                        <div class="ms-4">
                            <p class="text-sm font-medium text-gray-500">តំបន់សរុប</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalSites ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Blocks -->
                <div class="bg-white border rounded-lg p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-blue-50 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7v10a1 1 0 01-1 1H5a1 1 0 01-1-1V7m16 0L12 3 4 7" />
                            </svg>
                        </div>
                        <div class="ms-4">
                            <p class="text-sm font-medium text-gray-500">ទីតាំងសរុប</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalBlocks ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Customers -->
                <div class="bg-white border rounded-lg p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-green-50 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11c1.657 0 3-1.343 3-3S17.657 5 16 5s-3 1.343-3 3 1.343 3 3 3zM6 21v-1a4 4 0 014-4h4a4 4 0 014 4v1" />
                            </svg>
                        </div>
                        <div class="ms-4">
                            <p class="text-sm font-medium text-gray-500">អតិថិជនសរុប</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalCustomers ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Income -->
                <div class="bg-white border rounded-lg p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-yellow-50 text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-3.866 0-7 1.79-7 4s3.134 4 7 4 7-1.79 7-4-3.134-4-7-4zm0-4v4" />
                            </svg>
                        </div>
                        <div class="ms-4">
                            <p class="text-sm font-medium text-gray-500">ចំណូលសរុប</p>
                            <p class="text-2xl font-semibold text-gray-900">${{ number_format($totalIncomes ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">ចំណូលប្រចាំខែ</h3>

            <div class="bg-white border rounded-lg p-4 shadow-sm">
                <canvas id="monthlyRevenueChart" class="w-full" height="400"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function () {
            const labels = {!! json_encode($monthlyLabels ?? ['មករា','កុម្ភៈ','មីនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ']) !!};

            // Load Hanuman font from Google Fonts (if not already loaded) and apply to Chart.js and canvas
            (function () {
                const href = "https://fonts.googleapis.com/css2?family=Hanuman&display=swap";
                if (!document.querySelector('link[href="' + href + '"]')) {
                    const link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.href = href;
                    document.head.appendChild(link);
                }

                const fontFamily = "'Hanuman', 'Noto Sans Khmer', 'Khmer OS', sans-serif";

                // Set Chart.js default font (if Chart is available)
                if (window.Chart && Chart.defaults && Chart.defaults.font) {
                    Chart.defaults.font.family = fontFamily;
                }

                // Ensure the canvas uses the font
                const canvas = document.getElementById('monthlyRevenueChart');
                if (canvas) {
                    canvas.style.fontFamily = fontFamily;
                }
            })();
            const data = {!! json_encode(array_map('floatval', array_merge([500], array_slice($monthlyRevenueData ?? [300,500,690,400,340,900,320,770,11000,9000,200,950], 1)))) !!};

            const ctx = document.getElementById('monthlyRevenueChart');
            if (!ctx) return;

            new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue',
                        data: data,
                        fill: true,
                        backgroundColor: 'rgba(250, 204, 21, 0.12)',
                        borderColor: 'rgba(250, 204, 21, 1)',
                        pointBackgroundColor: 'rgba(250, 204, 21, 1)',
                        tension: 0.35,
                        pointRadius: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) { return '$' + value; }
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                    const val = (ctx.parsed && ctx.parsed.y !== undefined) ? ctx.parsed.y : ctx.parsed;
                                    return '$' + val;
                                }
                            }
                        }
                    }
                }
            });
        })();
    </script>
@endsection
