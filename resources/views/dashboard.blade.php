@extends('layouts.app')

@section('title', '​ទំព័រដើម')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
            <div class="{{ auth()->user()->isAdmin() ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6' : 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6' }}">
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
                    $totalExpenseKHR = auth()->user()->isAdmin() ? Invoice::sum('total_amount_khr') : Invoice::whereHas('customer.block', function ($q) {
                                        $q->where('site_id', auth()->user()->site_id);
                                    })->sum('total_amount_khr');
                @endphp

                <!-- Total Sites -->
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('sites.index') }}" class="lg:col-span-1">
                        <div class="bg-white border rounded-lg p-3 sm:p-4 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-center">
                                <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-md bg-purple-50 text-purple-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a1 1 0 001 1h16a1 1 0 001-1V7M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2" />
                                    </svg>
                                </div>
                                <div class="ms-3 sm:ms-4 min-w-0 flex-1 flex flex-col justify-center">
                                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">តំបន់សរុប</p>
                                    <p class="text-xl sm:text-2xl font-semibold text-gray-900 truncate leading-tight">{{ $totalSites ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif

                <!-- Total Blocks -->
                <a href="{{ route('blocks.index') }}" class="lg:col-span-1">
                    <div class="bg-white border rounded-lg p-3 sm:p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-center">
                            <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-md bg-blue-50 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7v10a1 1 0 01-1 1H5a1 1 0 01-1-1V7m16 0L12 3 4 7" />
                                </svg>
                            </div>
                            <div class="ms-3 sm:ms-4 min-w-0 flex-1 flex flex-col justify-center">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">ទីតាំងសរុប</p>
                                <p class="text-xl sm:text-2xl font-semibold text-gray-900 truncate leading-tight">{{ $totalBlocks ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Total Customers -->
                <a href="{{ route('customers.index') }}" class="lg:col-span-1">
                    <div class="bg-white border rounded-lg p-3 sm:p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-center">
                            <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-md bg-green-50 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11c1.657 0 3-1.343 3-3S17.657 5 16 5s-3 1.343-3 3 1.343 3 3 3zM6 21v-1a4 4 0 014-4h4a4 4 0 014 4v1" />
                                </svg>
                            </div>
                            <div class="ms-3 sm:ms-4 min-w-0 flex-1 flex flex-col justify-center">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">អតិថិជនសរុប</p>
                                <p class="text-xl sm:text-2xl font-semibold text-gray-900 truncate leading-tight">{{ $totalCustomers ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Combined Income & Expense -->
                <a href="{{ route('invoices.index') }}" class="lg:col-span-2">
                    <div class="bg-white border rounded-lg p-3 sm:p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-center">
                            <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-md bg-yellow-50 text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ms-3 sm:ms-4 min-w-0 flex-1 flex flex-col justify-center truncate">
                                <div class="flex items-center justify-between space-x-4">
                                    <div class="text-center min-w-0 flex-1 flex flex-col justify-center">
                                        <p class="text-xs sm:text-sm font-medium text-green-600 truncate">ចំណូលសរុប</p>
                                        <p class="text-xl sm:text-2xl font-semibold text-gray-900 truncate leading-tight">${{ number_format($totalIncomesUSD ?? 0, 2) }}</p>
                                    </div>
                                    <div class="h-8 w-px bg-gray-300 truncate"></div>
                                    <div class="text-center min-w-0 flex-1 flex flex-col justify-center">
                                        <p class="text-xs sm:text-sm font-medium text-red-600 truncate">ចំណាយសរុប</p>
                                        <p class="text-xl sm:text-2xl font-semibold text-gray-900 truncate leading-tight">៛{{ number_format($totalExpenseKHR ?? 0, 0) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">ចំណូលប្រចាំខែ (ដុល្លារ)</h3>

            <div class="bg-white border rounded-lg p-4 shadow-sm">
                <div class="flex gap-3 mb-4 justify-end">
                    <select id="filterMonth" class="block min-w-0 w-[150px] rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">ខែទាំងអស់</option>
                        @php
                            $khmerMonths = [
                                1 => 'មករា',
                                2 => 'កុម្ភៈ',
                                3 => 'មីនា',
                                4 => 'មេសា',
                                5 => 'ឧសភា',
                                6 => 'មិថុនា',
                                7 => 'កក្កដា',
                                8 => 'សីហា',
                                9 => 'កញ្ញា',
                                10 => 'តុលា',
                                11 => 'វិច្ឆិកា',
                                12 => 'ធ្នូ'
                            ];
                        @endphp
                        
                        @foreach($khmerMonths as $key => $month)
                            <option value="{{ $key }}">{{ $month }}</option>
                        @endforeach
                    </select>

                    <select id="filterYear" class="block min-w-0 w-[150px] rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @for($y = 2025; $y <= date('Y') + 1; $y++)
                            <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div style="position: relative; height: 400px;">
                    <canvas id="monthlyRevenueChart"></canvas>
                </div>
            </div>
        </div>
        <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">ចំណាយប្រចាំខែ (រៀល)</h3>

            <div class="bg-white border rounded-lg p-4 shadow-sm">
                <div class="flex gap-3 mb-4 justify-end">
                    <select id="filterMonthExpense" class="block min-w-0 w-[150px] rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">ខែទាំងអស់</option>
                        @php
                            $khmerMonths = [
                                1 => 'មករា',
                                2 => 'កុម្ភៈ',
                                3 => 'មីនា',
                                4 => 'មេសា',
                                5 => 'ឧសភា',
                                6 => 'មិថុនា',
                                7 => 'កក្កដា',
                                8 => 'សីហា',
                                9 => 'កញ្ញា',
                                10 => 'តុលា',
                                11 => 'វិច្ឆិកា',
                                12 => 'ធ្នូ'
                            ];
                        @endphp
                        
                        @foreach($khmerMonths as $key => $month)
                            <option value="{{ $key }}">{{ $month }}</option>
                        @endforeach
                    </select>

                    <select id="filterYearExpense" class="block min-w-0 w-[150px] rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @for($y = 2025; $y <= date('Y') + 1; $y++)
                            <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div style="position: relative; height: 400px;">
                    <canvas id="monthlyExpenseChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function () {
            const labels = {!! json_encode($monthlyLabels) !!};
            const initialData = {!! json_encode($monthlyRevenueData) !!};
            
            const ctx = document.getElementById('monthlyRevenueChart').getContext('2d');

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue',
                        data: initialData,
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
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { callback: value => '$' + value.toLocaleString() }
                        }
                    }
                }
            });

            function reloadChart() {
                let year = document.getElementById('filterYear').value;
                let month = document.getElementById('filterMonth').value;

                fetch(`/dashboard/filter-revenue?year=${year}&month=${month}`)
                    .then(res => res.json())
                    .then(result => {
                        chart.data.datasets[0].data = result.data;
                        chart.update();
                    });
            }

            document.getElementById('filterMonth').addEventListener('change', reloadChart);
            document.getElementById('filterYear').addEventListener('change', reloadChart);
        })();

        (function () {
            const labels = {!! json_encode($monthlyLabels) !!};
            const expenseData = {!! json_encode($monthlyExpenseData) !!};
            
            const ctx = document.getElementById('monthlyExpenseChart').getContext('2d');

            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'ភ្លើង',
                            data: expenseData.electric,
                            backgroundColor: 'rgba(239, 68, 68, 0.8)',
                            borderColor: 'rgba(239, 68, 68, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'ទឹក',
                            data: expenseData.water,
                            backgroundColor: 'rgba(59, 130, 246, 0.8)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'ផ្សេងៗ',
                            data: expenseData.garbage,
                            backgroundColor: 'rgba(34, 197, 94, 0.8)',
                            borderColor: 'rgba(34, 197, 94, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { 
                                callback: value => '៛' + value.toLocaleString() 
                            },
                        },
                    }
                }
            });

            function reloadChart() {
                let year = document.getElementById('filterYearExpense').value;
                let month = document.getElementById('filterMonthExpense').value;

                fetch(`/dashboard/filter-expense?year=${year}&month=${month}`)
                    .then(res => res.json())
                    .then(result => {
                        chart.data.datasets[0].data = result.data.electric;
                        chart.data.datasets[1].data = result.data.water;
                        chart.data.datasets[2].data = result.data.garbage;
                        chart.update();
                    });
            }

            document.getElementById('filterMonthExpense').addEventListener('change', reloadChart);
            document.getElementById('filterYearExpense').addEventListener('change', reloadChart);
        })();
    </script>
@endsection
