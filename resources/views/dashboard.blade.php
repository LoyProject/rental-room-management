@extends('layouts.app')

@section('title', '​ទំព័រដើម')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
            <div class="{{ auth()->user()->isAdmin() ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6' : 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6' }}">
                @php
                    use App\Models\Site;
                    use App\Models\Block;
                    use App\Models\Customer;
                    use App\Models\Invoice;
                    use App\Models\User;

                    $totalSites = auth()->user()->isAdmin() ? Site::count() : Site::where('id', auth()->user()->site_id)->count();
                    $totalBlocks = auth()->user()->isAdmin() ? Block::count() : Block::where('site_id', auth()->user()->site_id)->count();
                    $totalCustomers = auth()->user()->isAdmin() ? Customer::count() : Customer::query()
                                    ->whereHas('block', function ($q) {
                                        $q->where('site_id', auth()->user()->site_id);
                                    })->count();
                    $totalIncomesUSD = auth()->user()->isAdmin() ? Invoice::sum('total_amount_usd') : Invoice::whereHas('customer.block', function ($q) {
                                        $q->where('site_id', auth()->user()->site_id);
                                    })->sum('total_amount_usd');
                    $totalIncomesKHR = auth()->user()->isAdmin() ? Invoice::sum('total_amount_khr') : Invoice::whereHas('customer.block', function ($q) {
                                        $q->where('site_id', auth()->user()->site_id);
                                    })->sum('total_amount_khr');
                @endphp

                <!-- Total Sites -->
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('sites.index') }}">
                        <div class="bg-white border rounded-lg p-3 sm:p-4 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-center">
                                <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-md bg-purple-50 text-purple-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a1 1 0 001 1h16a1 1 0 001-1V7M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2" />
                                    </svg>
                                </div>
                                <div class="ms-3 sm:ms-4 min-w-0 flex-1 flex flex-col justify-center">
                                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">តំបន់សរុប</p>
                                    <p class="text-xl sm:text-2xl font-semibold text-gray-900 leading-tight">{{ $totalSites ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif

                <!-- Total Blocks -->
                <a href="{{ route('blocks.index') }}">
                    <div class="bg-white border rounded-lg p-3 sm:p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-center">
                            <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-md bg-blue-50 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7v10a1 1 0 01-1 1H5a1 1 0 01-1-1V7m16 0L12 3 4 7" />
                                </svg>
                            </div>
                            <div class="ms-3 sm:ms-4 min-w-0 flex-1 flex flex-col justify-center">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">ទីតាំងសរុប</p>
                                <p class="text-xl sm:text-2xl font-semibold text-gray-900 leading-tight">{{ $totalBlocks ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Total Customers -->
                <a href="{{ route('customers.index') }}">
                    <div class="bg-white border rounded-lg p-3 sm:p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-center">
                            <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-md bg-green-50 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11c1.657 0 3-1.343 3-3S17.657 5 16 5s-3 1.343-3 3 1.343 3 3 3zM6 21v-1a4 4 0 014-4h4a4 4 0 014 4v1" />
                                </svg>
                            </div>
                            <div class="ms-3 sm:ms-4 min-w-0 flex-1 flex flex-col justify-center">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">អតិថិជនសរុប</p>
                                <p class="text-xl sm:text-2xl font-semibold text-gray-900 leading-tight">{{ $totalCustomers ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Total Income -->
                <a href="{{ route('invoices.index') }}">
                    <div class="bg-white border rounded-lg p-3 sm:p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-md bg-yellow-50 text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-3.866 0-7 1.79-7 4s3.134 4 7 4 7-1.79 7-4-3.134-4-7-4zm0-4v4" />
                                </svg>
                            </div>
                            <div class="ms-3 sm:ms-4 min-w-0 flex-1">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">ចំណូលសរុប</p>
                                <p class="text-base sm:text-lg lg:text-xl font-semibold text-gray-900 truncate">$ {{ number_format($totalIncomesUSD ?? 0, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">ចំណូលប្រចាំខែ</h3>

            <div class="bg-white border rounded-lg p-4 shadow-sm">
                <div style="position: relative; height: 400px;">
                    <canvas id="monthlyRevenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function () {
            const labels = {!! json_encode($monthlyLabels ?? ['មករា','កុម្ភៈ','មីនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ']) !!};

            // Load Hanuman font from Google Fonts
            (function () {
                const href = "https://fonts.googleapis.com/css2?family=Hanuman&display=swap";
                if (!document.querySelector('link[href="' + href + '"]')) {
                    const link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.href = href;
                    document.head.appendChild(link);
                }

                const fontFamily = "'Hanuman', 'Noto Sans Khmer', 'Khmer OS', sans-serif";

                if (window.Chart && Chart.defaults && Chart.defaults.font) {
                    Chart.defaults.font.family = fontFamily;
                }

                const canvas = document.getElementById('monthlyRevenueChart');
                if (canvas) {
                    canvas.style.fontFamily = fontFamily;
                }
            })();
            
            const data = {!! json_encode($monthlyRevenueData ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!};

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
                    maintainAspectRatio: false, // Keep this to allow container to control height
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) { 
                                    return '$' + value.toLocaleString(); 
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                    const val = ctx.parsed.y;
                                    return '$' + val.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        })();
    </script>
@endsection
