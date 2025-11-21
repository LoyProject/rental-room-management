@extends('layouts.app')

@section('title', 'Print Invoice')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Invoice #{{ $invoice->id }}</h2>
            <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}</div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <h3 class="font-medium">Customer</h3>
                <div class="text-sm">{{ $invoice->customer->name ?? 'N/A' }}</div>
                <div class="text-sm text-gray-600">{{ $invoice->customer->phone ?? '' }}</div>
            </div>
            <div>
                <h3 class="font-medium">Block</h3>
                <div class="text-sm">{{ $invoice->block->name ?? 'N/A' }}</div>
                <div class="text-sm text-gray-600">{{ $invoice->block->address ?? '' }}</div>
            </div>
        </div>

        <div class="mb-4">
            <h4 class="font-medium">Charges</h4>
            <table class="w-full mt-2 table-auto">
                <tbody>
                    <tr>
                        <td class="py-2">House (USD)</td>
                        <td class="py-2 text-right">{{ number_format($invoice->house_price, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2">Garbage (KHR)</td>
                        <td class="py-2 text-right">{{ number_format($invoice->garbage_price) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2">Water used (m³)</td>
                        <td class="py-2 text-right">{{ number_format($invoice->total_used_water) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2">Water amount (KHR)</td>
                        <td class="py-2 text-right">{{ number_format($invoice->total_amount_water) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2">Electric used (kWh)</td>
                        <td class="py-2 text-right">{{ number_format($invoice->total_used_electric) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2">Electric amount (KHR)</td>
                        <td class="py-2 text-right">{{ number_format($invoice->total_amount_electric) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end gap-6 mt-6 text-lg font-semibold">
            <div class="text-right">
                <div>Total (USD): {{ number_format($invoice->total_amount_usd, 2) }}</div>
                <div>Total (KHR): {{ number_format($invoice->total_amount_khr) }}</div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button onclick="window.print()" class="px-4 py-2 bg-green-600 text-white rounded-md">Print</button>
            <a href="{{ route('invoices.index') }}" class="px-4 py-2 bg-gray-200 rounded-md text-gray-700">Back</a>
        </div>
    </div>
@endsection
