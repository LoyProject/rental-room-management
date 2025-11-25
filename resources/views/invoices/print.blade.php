@extends('layouts.app')

@section('title', 'Print Invoice')

@section('content')
    <div class="items-center">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg p-8 print:p-6 invoice-print" style="border-radius:12px;">
            <div class="text-4xl font-bold text-blue-500 tracking-wide text-center mb-8">វិក្កយបត្រ បន្ទប់ជួល</div>
            <div class="flex justify-between mb-4">
                <div class="text-sm">
                    <div class="text-blue-500 font-bold">បន្ទប់លេខ: {{ $invoice->room_number ?? '.........................' }}</div>
                    <div>ចាប់​ពី​ថ្ងៃទី​: {{$invoice->from_date ??'......'}}</div>
                    <div>ដល់​ថ្ងៃទី​: {{$invoice->to_date ??'......'}}</div>
                </div>
                <div class="text-sm">
                    <div class="text-blue-500 font-bold">លេខទំនាក់ទំនង</div>
                    <div>096 56 49 666</div>
                    <div>086 22 00 96</div>
                    <div>010 88 77 00</div>
                </div>
            </div>

            <div class="border border-blue-200">
                <table class="w-full table-auto">
                    @php
                        $electric_usge = ($invoice->new_electric_number ?? 0) - ($invoice->old_electric_number ?? 0);
                    @endphp
                    <thead>
                        <tr class="bg-gray-50 text-blue-500 font-bold">
                            <th class="text-left px-5 py-3 border-b">លេខ</th>
                            <th class="text-center px-5 py-3 border-b">កុងទ័រ</th>
                            <th class="text-right px-5 py-3 border-b">ចំនួន</th>
                            <th class="text-right px-5 py-3 border-b">តម្លៃរាយ</th>
                            <th class="text-right px-5 py-3 border-b">តម្លៃសរុប</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="border-b">
                            <td class="px-5 py-4">ភ្លើង​ ​ថ្មី</td>
                            <td class="text-center px-5 py-4">{{ $invoice->new_electric_number ?? 0}} kw</td>
                            <td class="text-right px-5 py-4">--</td>
                            <td class="text-right px-5 py-4">--</td>
                            <td class="text-right px-5 py-4">--</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-5 py-4">ភ្លើង​ ​ចាស់</td>
                            <td class="text-center px-5 py-4">{{ $invoice->old_electric_number ?? 0}} kw</td>
                            <td class="text-right px-5 py-4">--</td>
                            <td class="text-right px-5 py-4">--</td>
                            <td class="text-right px-5 py-4">--</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-5 py-4">ការប្រើប្រាស់</td>
                            <td class="text-center px-5 py-4">{{$invoice->total_used_electric}} kw</td>
                            <td class="text-right px-5 py-4">--</td>
                            <td class="text-right font-bold px-5 py-4">{{$invoice->electric_unit_price}} រៀល</td>
                            <td class="text-right font-bold px-5 py-4">{{$invoice->total_used_electric * $invoice->electric_unit_price}} រៀល</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-5 py-4"></td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-5 py-4">ទឹក​ ​ថ្មី</td>
                            <td class="text-center px-5 py-4">{{ $invoice->new_water_number ?? 0}} m³</td>
                            <td class="text-right px-5 py-4">--</td>
                            <td class="text-right px-5 py-4">--</td>
                            <td class="text-right px-5 py-4">--</td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-5 py-4">ទឹក​ ចាស់</td>
                            <td class="text-center px-5 py-4">{{ $invoice->old_water_number ?? 0}} m³</td>
                            <td class="text-right px-5 py-4">--</td>
                            <td class="text-right px-5 py-4">--</td>
                            <td class="text-right px-5 py-4">--</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-5 py-4">ការប្រើប្រាស់</td>
                            <td class="text-center px-5 py-4">{{$invoice->total_used_water}} m³</td>
                            <td class="text-right px-5 py-4">--</td>
                            <td class="text-right font-bold px-5 py-4">{{$invoice->water_unit_price}} រៀល</td>
                            <td class="text-right font-bold px-5 py-4">{{($invoice->total_used_water) * ($invoice->water_unit_price)}} រៀល</td>
                        </tr>

                        <tr>
                            <td colspan="3">1. ហាមផឹកស៊ី ឡូឡារំខានអ្នកជិតខាង</td>
                            <td class="text-right font-bold px-5 py-4">សំរាម</td>
                            <td class="text-right font-bold px-5 py-4">{{$invoice->garbage_price ?? 0}} រៀល</td>
                        </tr>

                        <tr>
                            <td colspan="3">2. ហាមលក់ និងប្រើប្រាស់គ្រឿងញៀន</td>
                            <td class="text-right font-bold px-5 py-4">សរុប</td>
                            <td class="text-right font-bold text-green-500 px-5 py-4">{{$invoice->total_amount_khr}} រៀល</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td colspan="3">3. ឈប់ជួល​ត្រូវផ្តល់ដំណឹង១ខែមុន​បើពុំនោះទេប្រាក់កក់ទុកជាអាសាបង់​</td>
                            <td class="text-right font-bold px-5 py-4">តម្លៃបន្ទប់</td>
                            <td class="text-right font-bold px-5 py-4 text-red-500">{{number_format($invoice->total_amount_usd ?? 0, 2)}} ដុល្លា</td>
                        </tr>
                    </tbody>
                </table>
            </div>

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
                function mmToPx(mm) { return mm * (96 / 25.4); }

                function printA5() {
                    const invoiceEl = document.querySelector('.invoice-print');
                    if (!invoiceEl) { window.print(); return; }
                        const pageWidthMM = 148;
                        const pageHeightMM = 210;
                        const marginMM = 0.5;
                        const printableHeightPx = mmToPx(pageHeightMM - (marginMM * 2));
                        const printableWidthPx = mmToPx(pageWidthMM - (marginMM * 2));

                        const rect = invoiceEl.getBoundingClientRect();
                        const contentHeight = rect.height;
                        const contentWidth = rect.width;

                        const scaleY = printableHeightPx / contentHeight;
                        const scaleX = printableWidthPx / contentWidth;
                        const scale = Math.min(1, scaleX, scaleY);

                    const prevTransform = invoiceEl.style.transform || '';
                    const prevTransformOrigin = invoiceEl.style.transformOrigin || '';
                    const prevHtmlHeight = document.documentElement.style.height || '';
                    const prevBodyHeight = document.body.style.height || '';

                    invoiceEl.style.transformOrigin = 'top left';
                    invoiceEl.style.transform = 'scale(' + scale + ')';
                    document.documentElement.style.height = (printableHeightPx) + 'px';
                    document.body.style.height = (printableHeightPx) + 'px';

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
