@extends('layouts.app')

@section('title', 'Print Invoice')

@section('content')
    <div class="items-center">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg p-8 print:p-6 invoice-print" style="border-radius:12px;">
            <div class="text-4xl font-bold text-gray-400 tracking-wide text-center mb-8">វិក្កយបត្រ
                
            </div>
            <style>
                /* Print: hide everything except the invoice container to remove app header/footer */
                @media print {
                    html, body { height: auto !important; }
                    body * { visibility: hidden !important; }
                    .invoice-print, .invoice-print * { visibility: visible !important; }
                    .invoice-print { position: absolute !important; left: 0; top: 0; width: 100% !important; }
                    .no-print { display: none !important; }
                    @page { size: A5 portrait; margin: 10mm; }
                }
            </style>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 items-start">
                <div>
                    <h4 class="text-sm font-semibold mb-2">ឈ្មោះ​អតិថិជន:</h4>
                    <div class="text-sm font-semibold">{{ $invoice->customer->name ?? 'ឈ្មោះ​អតិថិជន' }}</div>
                    @php
                        $site = $invoice->site->name ?? $invoice->site_name ?? null;
                        $block = $invoice->block->name ?? $invoice->block_name ?? null;
                    @endphp
                    <div class="text-sm text-gray-600">
                        {{ $site && $block ? $site . ' + ' . $block : ($site ?? $block ?? 'អាសយដ្ឋាន​អតិថិជន') }}
                    </div>
                    <div class="text-sm text-gray-600">{{ $invoice->customer->phone ?? '' }}</div>
                    <div class="text-sm text-gray-600">{{ $invoice->customer->email ?? '' }}</div>
                </div>

                <div class="text-sm text-right">
                    <div>លេខវិក្កយបត្រ: <span class="font-semibold">#{{ $invoice->id }}</span></div>
                    <div>កាលបរិច្ឆេទ: {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}</div>
                    <div>កាលបរិច្ឆេទផុតកំណត់: {{ \Carbon\Carbon::parse($invoice->invoice_date)->addDays(30)->format('Y-m-d') }}</div>
                </div>
            </div>

            <div class="border border-gray-200">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left px-5 py-3 border-b">ពណ៌នា</th>
                            <th class="text-center px-5 py-3 border-b">បរិមាណ</th>
                            <th class="text-right px-5 py-3 border-b">តម្លៃ</th>
                            <th class="text-right px-5 py-3 border-b">សរុប</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="border-b">
                            <td class="px-5 py-4">ជួលបន្ទប់ (USD)</td>
                            <td class="text-center px-5 py-4">1</td>
                            <td class="text-right px-5 py-4">{{ number_format($invoice->house_price ?? 0, 2) }} USD</td>
                            <td class="text-right px-5 py-4">{{ number_format($invoice->house_price ?? 0, 2) }} USD</td>
                        </tr>

                        @php
                            $electric_usge = ($invoice->new_electric_number ?? 0) - ($invoice->old_electric_number ?? 0);
                        @endphp

                        <tr class="border-b">
                            <td class="px-5 py-4">ការប្រើប្រាស់​អគ្គិសនី {{ $electric_usge ?? 0}}kwh</td>
                            <td class="text-center px-5 py-4">1</td>
                            <td class="text-right px-5 py-4">{{ number_format($invoice->total_amount_electric ?? 0) }} KHR</td>
                            <td class="text-right px-5 py-4">{{ number_format($invoice->total_amount_electric ?? 0) }} KHR</td>
                        </tr>

                        @php
                            $water_usge = ($invoice->new_water_number ?? 0) - ($invoice->old_water_number ?? 0);
                        @endphp

                        <tr class="border-b">
                            <td class="px-5 py-4">ការប្រើទឹក {{$water_usge}}m³</td>
                            <td class="text-center px-5 py-4">1</td>
                            <td class="text-right px-5 py-4">{{ number_format($invoice->total_amount_water ?? 0) }} KHR</td>
                            <td class="text-right px-5 py-4">{{ number_format($invoice->total_amount_water ?? 0) }} KHR</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-5 py-4">សំរាម (KHR)</td>
                            <td class="text-center px-5 py-4">1</td>
                            <td class="text-right px-5 py-4">{{ number_format($invoice->garbage_price ?? 0) }} KHR</td>
                            <td class="text-right px-5 py-4">{{ number_format($invoice->garbage_price ?? 0) }} KHR</td> 
                        </tr>

                        @php
                            $subtotal_khr = ($invoice->garbage_price ?? 0) + ($invoice->total_amount_water ?? 0) + ($invoice->total_amount_electric ?? 0) + ($invoice->internet_fee ?? 0);
                        @endphp

                        <tr>
                            <td colspan="3" class="text-right px-5 py-3 font-semibold border-t">សរុប​ (USD)</td>
                            <td class="text-right px-5 py-3 font-semibold border-t">{{ number_format($invoice->house_price ?? 0, 2) }} USD</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right px-5 py-3 font-semibold">សរុប​ (KHR)</td>
                            <td class="text-right px-5 py-3 font-semibold">{{ number_format($subtotal_khr ?? 0) }} KHR</td>
                        </tr>

                        <tr class="bg-gray-50">
                            <td colspan="3" class="text-right px-5 py-3 font-bold">ប្រាក់ត្រូវបង់សរុប</td>
                            <td class="text-right px-5 py-3 font-bold">{{ number_format($invoice->total_amount_usd ?? 0, 2) }} USD / {{ number_format($invoice->total_amount_khr ?? 0) }} KHR</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end gap-4 no-print mt-4 mb-4">
                <a href="{{ route('invoices.index') }}"
                       class="inline-flex items-center px-3 py-2 rounded-md bg-white border border-gray-200 text-gray-600 text-sm hover:bg-gray-50">
                        ត្រឡប់
                    </a>

                    <button id="printBtn" type="button" onclick="printA5()"
                            class="inline-flex items-center px-3 py-2 rounded-md bg-blue-600 text-white text-sm hover:bg-blue-500">
                        បោះពុម្ព
                    </button>
            </div>

            <script>
                // Convert millimeters to CSS pixels (approx at 96dpi)
                function mmToPx(mm) { return mm * (96 / 25.4); }

                function printA5() {
                    const invoiceEl = document.querySelector('.invoice-print');
                    if (!invoiceEl) { window.print(); return; }

                    // A5 portrait dimensions: 148 x 210 mm. Use 10mm margins by default.
                    const pageHeightMM = 210;
                    const marginMM = 10;
                    const printableHeightPx = mmToPx(pageHeightMM - (marginMM * 2));

                    // measure current invoice height
                    const rect = invoiceEl.getBoundingClientRect();
                    const contentHeight = rect.height;

                    // compute scale to fit into printable height (do not upscale)
                    const scale = Math.min(1, printableHeightPx / contentHeight);

                    // apply transform and force reflow
                    const prevTransform = invoiceEl.style.transform || '';
                    const prevTransformOrigin = invoiceEl.style.transformOrigin || '';
                    const prevHtmlHeight = document.documentElement.style.height || '';
                    const prevBodyHeight = document.body.style.height || '';

                    invoiceEl.style.transformOrigin = 'top left';
                    invoiceEl.style.transform = 'scale(' + scale + ')';
                    document.documentElement.style.height = (printableHeightPx) + 'px';
                    document.body.style.height = (printableHeightPx) + 'px';

                    // Ensure print styles are applied, then print
                    setTimeout(function() {
                        function cleanup() {
                            invoiceEl.style.transform = prevTransform;
                            invoiceEl.style.transformOrigin = prevTransformOrigin;
                            document.documentElement.style.height = prevHtmlHeight;
                            document.body.style.height = prevBodyHeight;
                            window.removeEventListener('afterprint', cleanup);
                            window.removeEventListener('focus', onFocusCleanup);
                        }
                        function onFocusCleanup() { setTimeout(cleanup, 300); }

                        window.addEventListener('afterprint', cleanup);
                        window.addEventListener('focus', onFocusCleanup);

                        window.print();
                    }, 120);
                }
            </script>
        </div>
    </div>
@endsection
