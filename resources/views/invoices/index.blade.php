@extends('layouts.app')

@section('title', 'វិក័យប័ត្រ')

@section('content')
    <x-success-alert />

    <div class="mb-4 p-4 bg-white shadow-md rounded-md flex flex-col gap-4">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
            <form action="{{ route('invoices.index') }}" method="GET" class="w-full lg:max-w-md">
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full">
                    @if (auth()->user()->isAdmin() && request('site'))
                        <input type="hidden" name="site" value="{{ request('site') }}">
                    @endif
                    <input type="hidden" name="block" value="{{ request('block') }}">
                    <input type="hidden" name="from_date" value="{{ request('from_date') }}">
                    <input type="hidden" name="to_date" value="{{ request('to_date') }}">

                    <input type="text" name="search" placeholder="ស្វែងរកវិក្កយបត្រ..." class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" value="{{ request('search') }}">
                    
                    <button type="submit"
                        class="bg-gray-800 text-white px-6 py-2 rounded-md hover:bg-gray-900 w-full sm:w-auto">
                        ស្វែងរក
                    </button>

                    <a href="{{ route('invoices.index') }}"
                        class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 w-full sm:w-auto text-center">
                        លុប
                    </a>
                </div>
            </form>

            <div class="lg:self-end w-full lg:w-auto">
                <a href="{{ route('invoices.create') }}"
                    class="bg-blue-100 text-blue-700 px-4 py-2 rounded-md hover:bg-blue-700 hover:text-white w-full sm:w-auto block text-center whitespace-nowrap">
                    វិក្កយបត្រថ្មី
                </a>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-4 w-full">
            @if (auth()->user()->isAdmin())
                <div class="w-full lg:w-1/4 min-w-[150px]">
                    <!-- <label class="text-sm text-gray-600 mb-1 block">តំបន់</label> -->
                    <select id="siteFilter" name="site" class="w-full rounded-md shadow-sm border-gray-300">
                        <option value="">តំបន់ទាំងអស់</option>
                        @foreach ($sites as $site)
                            <option value="{{ $site->id }}" @selected(request('site') == $site->id)>
                                {{ $site->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="w-full {{ auth()->user()->isAdmin() ? 'lg:w-1/4' : 'lg:w-1/3' }} min-w-[150px]">
                <!-- <label class="text-sm text-gray-600 mb-1 block">ទីតាំង</label> -->
                <select id="blockFilter" name="block" class="w-full rounded-md shadow-sm border-gray-300">
                    <option value="">ទីតាំងទាំងអស់</option>
                    @foreach ($blocks as $block)
                        <option value="{{ $block->id }}" @selected(request('block') == $block->id)>
                            {{ $block->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full {{ auth()->user()->isAdmin() ? 'lg:w-1/4' : 'lg:w-1/3' }} min-w-[150px]">
                <!-- <label class="text-sm text-gray-600 mb-1 block">ពីថ្ងៃ</label> -->
                <input type="text" id="from_date" name="from_date" placeholder="ពីថ្ងៃ" value="{{ request('from_date') }}" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-600" autocomplete="off">
            </div>

            <div class="w-full {{ auth()->user()->isAdmin() ? 'lg:w-1/4' : 'lg:w-1/3' }} min-w-[150px]">
                <!-- <label class="text-sm text-gray-600 mb-1 block">ដល់ថ្ងៃ</label> -->
                <input type="text" id="to_date" name="to_date" placeholder="ដល់ថ្ងៃ" value="{{ request('to_date') }}" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-600" autocomplete="off">
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg">
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">ល.រ</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">កាលបរិច្ឆេទ</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">ទីតាំង</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">អតិថិជន</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">ទឹក (រៀល)</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">អគ្គិសនី (រៀល)</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">សរុប (ដុល្លារ)</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">សរុប (រៀល)</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @forelse ($invoices as $invoice)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $invoice->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $invoice->block->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $invoice->customer->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($invoice->total_amount_water, 0, '.', ',') }} រៀល</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($invoice->total_amount_electric, 0, '.', ',') }} រៀល</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($invoice->total_amount_usd, 2, '.', ',') }} ដុល្លារ</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($invoice->total_amount_khr, 0, '.', ',') }} រៀល</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('invoices.print', $invoice) }}" class="text-green-600 hover:text-green-900 mr-3">បោះពុម្ព</a>
                                <a href="{{ route('invoices.edit', $invoice) }}" class="text-blue-600 hover:text-blue-900 mr-3">កែប្រែ</a>
                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure to delete?')"
                                        class="text-red-600 hover:text-red-900">លុប</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center px-6 py-4">មិនមានវិក្កយបត្រទេ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $invoices->links() }}
    </div>

    <script>
        flatpickr("#from_date", {
            dateFormat: "d/m/Y",
            allowInput: true,
        });

        flatpickr("#to_date", {
            dateFormat: "d/m/Y",
            allowInput: true,
        });

        $(document).ready(function () {

            function updateFilters() {
                let params = new URLSearchParams(window.location.search);

                let site      = $('#siteFilter').val();
                let block     = $('#blockFilter').val();
                let fromDate  = $('#from_date').val();
                let toDate    = $('#to_date').val();
                let search    = params.get('search');

                if (site) params.set('site', site);
                else params.delete('site');

                if (block) params.set('block', block);
                else params.delete('block');

                if (fromDate) params.set('from_date', fromDate);
                else params.delete('from_date');
                
                if (toDate) params.set('to_date', toDate);
                else params.delete('to_date');

                if (search) params.set('search', search);
                else params.delete('search');

                params.delete('page');

                let query = params.toString();
                window.location.href = window.location.pathname + (query ? '?' + query : '');
            }

            $('#siteFilter, #blockFilter').select2({
                allowClear: false,
                width: '100%'
            });

            $('#siteFilter').on('select2:select select2:clear', updateFilters);
            $('#blockFilter').on('select2:select select2:clear', updateFilters);

            $('#from_date, #to_date').on('change', updateFilters);
        });
    </script>
@endsection
