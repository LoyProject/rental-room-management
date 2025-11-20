@extends('layouts.app')

@section('title', 'វិក័យប័ត្រ')

@section('content')
    <x-success-alert />

    <div class="mb-4 p-4 bg-white shadow-md rounded-md flex flex-col sm:flex-row justify-between items-center gap-4">
        <form action="{{ route('invoices.index') }}" method="GET" class="w-full sm:max-w-md">
            <div class="flex flex-row items-center gap-2 w-full">
                <input type="text" name="search" placeholder="ស្វែងរកវិក័យប័ត្រ..."
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"
                    value="{{ request('search') }}">
                <button type="submit" class="bg-gray-800 text-white px-6 py-2 hover:bg-gray-900 rounded-md">ស្វែងរក</button>
                <a href="{{ route('invoices.index') }}" class="font-semibold text-sm text-gray-600 hover:underline px-4 py-2 rounded-md">លុប</a>
            </div>
        </form>

        <div class="w-full sm:w-auto flex justify-end">
            <a href="{{ route('invoices.create') }}"
                class="bg-blue-100 text-blue-700 px-4 py-2 rounded-md hover:bg-blue-700 hover:text-white w-full sm:w-auto text-center break-keep">
                វិក័យប័ត្រថ្មី
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg">
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">ល.រ</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">កាលបរិច្ឆេទ</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">ប្លុក</th>
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
@endsection
