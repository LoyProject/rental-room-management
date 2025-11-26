@extends('layouts.app')

@section('title', 'Print Invoice')

@section('content')
<div class="items-center">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg p-8 print:p-6 invoice-print"
        style="border-radius:12px;">

        <div class="mb-6" style="text-align: center; font-family: Khmer OS Muol Light; font-size: 24px;">វិក័យប័ត្រ
            បន្ទប់ជួល</div>

        <div class="flex justify-between mb-4">
            <div class="text-lg font-semibold">
                <div style="font-size: 22px;">បន្ទប់លេខ:  {{ $invoice->customer->name ??'..............' }}</div>
                <div>តំបន់: {{ $invoice->block->name ?? '..............' }}</div>
            </div>
            <div class="font-semibold" style="white-space: pre-line;">ទំនាក់ទំនង:
                {{ $invoice->block->site->phone ?? '096 56 49 666' }}
            </div>
        </div>

        <div class="w-full grid grid-cols-2 md:grid-cols-2 gap-2 text-xl mb-2">
            <div class="text-left">
                ចាប់ពីថ្ងៃទី {{ \Carbon\Carbon::parse($invoice->from_date)->format('d') }}
                ខែ {{ \Carbon\Carbon::parse($invoice->from_date)->format('m') }}
                ឆ្នាំ {{ \Carbon\Carbon::parse($invoice->from_date)->format('Y') }}
            </div>
            <div class="text-right">
                ដល់ថ្ងៃទី {{ \Carbon\Carbon::parse($invoice->to_date)->format('d') }}
                ខែ {{ \Carbon\Carbon::parse($invoice->to_date)->format('m') }}
                ឆ្នាំ {{ \Carbon\Carbon::parse($invoice->to_date)->format('Y') }}
            </div>
        </div>

        <table class="w-full border-collapse text-sm">
            <tr class="bg-gray-200">
                <td class="border border-blue-100 text-center text-blue-500 font-bold">លេខ</td>
                <td class="border border-blue-100 text-center text-blue-500 font-bold">កុងទ័រ</td>
                <td class="border border-blue-100 text-center text-blue-500 font-bold">ចំនួន</td>
                <td class="border border-blue-100 text-center text-blue-500 font-bold">តម្លៃរាយ</td>
                <td class="border border-blue-100 text-center text-blue-500 font-bold">តម្លៃសរុប</td>
            </tr>
            <tr>
                <td class="border border-blue-100 text-center">ភ្លើង ថ្មី</td>
                <td class="border border-blue-100 text-center">{{ $invoice->new_electric_number }} km³</td>
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center"></td>
            </tr>
            <tr>
                <td class="border border-blue-100 text-center">ភ្លើង ចាស់</td>
                <td class="border border-blue-100 text-center">{{ $invoice->old_electric_number }} km³</td>
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center"></td>
            </tr>
            <tr>
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center">{{ $invoice->total_used_electric }} km³</td>
                <td class="border border-blue-100 text-center">{{ $invoice->total_used_electric }} km³</td>
                <td class="border border-blue-100 text-center">{{ number_format($invoice->electric_unit_price) ?? 0 }} រៀល</td>
                <td class="border border-blue-100 text-center">{{ number_format($invoice->total_amount_electric) ?? 0 }} រៀល</td>
            </tr>
            <tr height="30px">
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center"></td>
            </tr>
            <tr>
                <td class="border border-blue-100 text-center">ទឹក ថ្មី</td>
                <td class="border border-blue-100 text-center">{{ $invoice->new_water_number }} m³</td>
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center"></td>
            </tr>
            <tr>
                <td class="border border-blue-100 text-center">ទឹក ចាស់</td>
                <td class="border border-blue-100 text-center">{{ $invoice->old_water_number }} m³</td>
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center"></td>
            </tr>
            <tr>
                <td class="border border-blue-100 text-center"></td>
                <td class="border border-blue-100 text-center">{{ $invoice -> total_used_water }} m³</td>
                <td class="border border-blue-100 text-center">{{ $invoice -> total_used_water }} m³</td>
                <td class="border border-blue-100 text-center">{{ number_format($invoice->water_unit_price) ?? 0 }} រៀល</td>
                <td class="border border-blue-100 text-center">{{ number_format($invoice->total_amount_water) ?? 0 }} រៀល</td>
            </tr>
            <tr>
                <td colspan="3" rowspan="3" class="border border-blue-100 p-2">១. ហាមផឹកស៊ី ឡូឡារំខានអ្នកជិតខាង។<br>២.
                    ហាមលក់ និងប្រើប្រាស់គ្រឿងញៀន។<br>៣. ឈប់ជួលត្រូវឲ្យដំណឹង១ខែមុខ បើពុំនោះទេ ប្រាក់កក់ ទុកជាអាសាបង់។
                </td>
                <td class="border border-blue-100 p-2 text-center">សម្រាម</td>
                <td class="border border-blue-100 p-2 text-center">{{ number_format($invoice->garbage_price ?? 0) }} រៀល
                </td>
            </tr>
            <tr>
                <td class="border border-blue-100 p-2 text-center">សរុប</td>
                <td class="border border-blue-100 p-2 text-center">{{ number_format($invoice->total_amount_khr ?? 0) }}
                    រៀល</td>
            </tr>
            <tr>
                <td class="border border-blue-100 p-2 text-center">តម្លៃបន្ទប់</td>
                <td class="border border-blue-100 p-2 text-center text-blue-500 font-bold">
                    {{ number_format($invoice->total_amount_usd ?? 0, 2) }}
                    ដុល្លារ</td>
            </tr>
        </table>


        <div class="flex justify-end gap-4 no-print mt-4 mb-4">
            <a href="{{ route('invoices.index') }}"
                class="inline-flex items-center px-3 py-2 rounded-md bg-white border border-gray-200 text-gray-600 text-sm hover:bg-gray-50">
                បោះបង់
            </a>

            <button id="printBtn" type="button" onclick="printA5()"
                class="inline-flex items-center px-3 py-2 rounded-md bg-green-600 text-white text-sm hover:bg-green-500">
                បោះពុម្ព
            </button>
        </div>

        <script>
        // Convert millimeters to CSS pixels (approx at 96dpi)
        function mmToPx(mm) {
            return mm * (96 / 25.4);
        }

        function printA5() {
            const invoiceEl = document.querySelector('.invoice-print');
            if (!invoiceEl) {
                window.print();
                return;
            }

            // A5 portrait dimensions: 148 x 210 mm. Use 10mm margins by default.
            const pageWidthMM = 148;
            const pageHeightMM = 210;
            const marginMM = 0.5;
            const printableHeightPx = mmToPx(pageHeightMM - (marginMM * 2));
            const printableWidthPx = mmToPx(pageWidthMM - (marginMM * 2));

            // measure current invoice dimensions
            const rect = invoiceEl.getBoundingClientRect();
            const contentHeight = rect.height;
            const contentWidth = rect.width;

            // compute scale to fit into printable area (do not upscale)
            const scaleY = printableHeightPx / contentHeight;
            const scaleX = printableWidthPx / contentWidth;
            const scale = Math.min(1, scaleX, scaleY);

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

                function onFocusCleanup() {
                    setTimeout(cleanup, 300);
                }

                window.addEventListener('afterprint', cleanup);
                window.addEventListener('focus', onFocusCleanup);

                window.print();
            }, 120);
        }
        </script>
    </div>
</div>
@endsection