@extends('layouts.app')

@section('title', 'បង្កើតវិក្កយបត្រថ្មី')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 min-h-full">
        <x-loading-overlay />
        
        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-4">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="block_id" class="mb-1 block text-sm font-medium text-gray-700">ទីតាំង <span class="text-red-600">*</span></label>
                        <select id="block_id" name="block_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring-blue-200">
                            <option value="" disabled {{ old('block_id') ? '' : 'selected' }}>ជ្រើសរើសទីតាំង</option>
                            @foreach($blocks as $block)
                                <option value="{{ $block->id }}" {{ old('block_id') == $block->id ? 'selected' : '' }}>{{ $block->name }}</option>
                            @endforeach
                        </select>
                        @error('block_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="customer_id" class="mb-1 block text-sm font-medium text-gray-700">អតិថិជន <span class="text-red-600">*</span></label>
                        <select id="customer_id" name="customer_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring-blue-200">
                            <option value="" disabled {{ old('customer_id') ? '' : 'selected' }}>ជ្រើសរើសអតិថិជន</option>
                        </select>
                        @error('customer_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="invoice_date" class="block text-sm font-medium text-gray-700">កាលបរិច្ឆេទវិក្កយបត្រ <span class="text-red-600">*</span></label>
                        <input type="text" id="invoice_date" name="invoice_date" class="mt-1 block w-full rounded-md border-gray-300"
                            placeholder="dd/mm/yyyy" required>
                        @error('invoice_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="from_date" class="block text-sm font-medium text-gray-700">ពីថ្ងៃ <span class="text-red-600">*</span></label>
                        <input type="text" id="from_date" name="from_date" class="mt-1 block w-full border-gray-300 rounded-md" 
                           placeholder="dd/mm/yyyy" required>
                        @error('from_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="to_date" class="block text-sm font-medium text-gray-700">ដល់ថ្ងៃ <span class="text-red-600">*</span></label>
                        <input type="text" id="to_date" name="to_date" class="mt-1 block w-full border-gray-300 rounded-md"
                           placeholder="dd/mm/yyyy" required>
                        @error('to_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="house_price" class="block text-sm font-medium">តម្លៃផ្ទះ (ដុល្លារ) <span class="text-red-600">*</span></label>
                        <input type="number" id="house_price" name="house_price" value="{{ old('house_price') }}" step="0.01" min="0" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('house_price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="garbage_price" class="block text-sm font-medium">សំរាម (រៀល) <span class="text-red-600">*</span></label>
                        <input type="number" id="garbage_price" name="garbage_price" value="{{ old('garbage_price') }}" step="100"  min="0" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('garbage_price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">ចំនួនទឹក (ចាស់ / ថ្មី / សរុប) <span class="text-red-600">*</span></label>
                        <div class="grid grid-cols-3 gap-2">
                            <input type="number" id="old_water_number" name="old_water_number" value="{{ old('old_water_number') }}" min="0"
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md" required readonly>
                            <input type="number" id="new_water_number" name="new_water_number" value="{{ old('new_water_number') }}" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md" required>

                            <input type="number" id="total_used_water" name="total_used_water" value="{{ old('total_used_water') }}"
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md" readonly>
                        </div>
                        @error('old_water_number')
                            <p class="text-red-500 text-xs mt-1 col-span-3">{{ $message }}</p>
                        @enderror
                        @error('new_water_number')
                            <p class="text-red-500 text-xs mt-1 col-span-3">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">ចំនួនអគ្គិសនី (ចាស់ / ថ្មី / សរុប) <span class="text-red-600">*</span></label>
                        <div class="grid grid-cols-3 gap-2">
                            <input type="number" id="old_electric_number" name="old_electric_number" min="0" value="{{ old('old_electric_number') }}"
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md" required readonly>
                            <input type="number" id="new_electric_number" name="new_electric_number" min="0" value="{{ old('new_electric_number') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md" required>

                            <input type="number" id="total_used_electric" name="total_used_electric" value="{{ old('total_used_electric') }}"
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md" readonly>
                        </div>
                        @error('old_electric_number')
                            <p class="text-red-500 text-xs mt-1 col-span-3">{{ $message }}</p>
                        @enderror
                        @error('new_electric_number')
                            <p class="text-red-500 text-xs mt-1 col-span-3">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">តម្លៃទឹក / ១ m³ (រៀល) <span class="text-red-600">*</span></label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" id="water_unit_price" name="water_unit_price" min="0" step="10" value="{{ old('water_unit_price') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md" required>

                            <input type="number" id="total_amount_water" name="total_amount_water" value="{{ old('total_amount_water') }}"
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md" readonly>
                        </div>
                        @error('water_unit_price')
                            <p class="text-red-500 text-xs mt-1 col-span-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">តម្លៃអគ្គិសនី / ១ kWh (រៀល) <span class="text-red-600">*</span></label>
                        <div class="grid grid-cols-2 gap-2">
                            <input id="min_electric_unit_price" name="min_electric_unit_price" value="{{ old('min_electric_unit_price') }}" class="hidden" readonly disabled>
                            <input id="max_electric_unit_price" name="max_electric_unit_price" value="{{ old('max_electric_unit_price') }}" class="hidden" readonly disabled>
                            <input id="calculation_threshold" name="calculation_threshold" value="{{ old('calculation_threshold') }}" class="hidden" readonly disabled>
                            <input id="electric_source" name="electric_source" value="{{ old('electric_source') }}" class="hidden" readonly disabled>

                            <input type="number" id="electric_unit_price" name="electric_unit_price" min="0" step="10" value="{{ old('electric_unit_price') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md" required>

                            <input type="number" id="total_amount_electric" name="total_amount_electric" value="{{ old('total_amount_electric') }}"
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md" readonly>
                        </div>
                        @error('electric_unit_price')
                            <p class="text-red-500 text-xs mt-1 col-span-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t pt-4 mt-4">
                    <div>
                        <label for="total_amount_usd" class="block text-base font-bold">ចំនួនទឹកប្រាក់សរុប (ដុល្លារ)</label>
                        <input type="number" id="total_amount_usd" name="total_amount_usd" value="{{ old('total_amount_usd') }}"
                            class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md text-lg font-bold text-green-600" readonly> 
                    </div>
                    <div>
                        <label for="total_amount_khr" class="block text-base font-bold">ចំនួនទឹកប្រាក់សរុប (រៀល)</label>
                        <input type="number" id="total_amount_khr" name="total_amount_khr" value="{{ old('total_amount_khr') }}"
                            class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md text-lg font-bold text-green-600" readonly> 
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <a href="{{ route('invoices.index') }}"
                        class="text-sm text-gray-600 hover:underline px-3 py-2">បោះបង់</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-sm text-white rounded-md hover:bg-blue-500">
                        បង្កើតថ្មី
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
        $('#block_id').select2({
            allowClear: false,
            width: '100%'
        });

        $('#customer_id').select2({
            allowClear: false,
            width: '100%'
        });

        flatpickr("#invoice_date", {
            dateFormat: "d/m/Y",
            defaultDate: new Date(),
            allowInput: true,
            onClose: function(selectedDates, dateStr, instance) {
                if (dateStr === "") {
                    instance.input.setCustomValidity("This field is required.");
                } else {
                    instance.input.setCustomValidity("");
                }
            }
        });

        flatpickr("#from_date", {
            dateFormat: "d/m/Y",
            defaultDate: new Date(new Date().getFullYear(), new Date().getMonth(), 1),
            allowInput: true,
            onClose: function(selectedDates, dateStr, instance) {
                if (dateStr === "") {
                    instance.input.setCustomValidity("This field is required.");
                } else {
                    instance.input.setCustomValidity("");
                }
            }
        });

        flatpickr("#to_date", {
            dateFormat: "d/m/Y",
            defaultDate: new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0),
            allowInput: true,
            onClose: function(selectedDates, dateStr, instance) {
                if (dateStr === "") {
                    instance.input.setCustomValidity("This field is required.");
                } else {
                    instance.input.setCustomValidity("");
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const loadingOverlay = document.getElementById('loading-overlay');

            $('#customer_id').on('change', function () {
                let customerId = $(this).val();
                if (!customerId) return;

                loadingOverlay.classList.remove('hidden');

                $.ajax({
                    url: `/customer-info/${customerId}`,
                    method: 'GET',
                    dataType: 'json'
                }).done(function(data) {
                    $('input[name="house_price"]').val(data.house_price ?? '');
                    $('input[name="garbage_price"]').val(data.garbage_price ?? '');
                    $('input[name="old_water_number"]').val(data.old_water_number ?? '');
                    $('input[name="old_electric_number"]').val(data.old_electric_number ?? '');

                    $('#house_price,#garbage_price,#old_water_number,#old_electric_number').trigger('input');
                }).fail(function() {
                    console.error('Failed to load customer info for', customerId);
                }).always(function() {
                    loadingOverlay.classList.add('hidden');
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const loadingOverlay = document.getElementById('loading-overlay');

            $('#block_id').on('change', function () {
                let blockId = $(this).val();
                if (!blockId) return;

                loadingOverlay.classList.remove('hidden');

                let customersAjax = $.ajax({
                    url: `/customers-by-block/${blockId}?month={{ date('m') }}&year={{ date('Y') }}`,
                    method: 'GET',
                    dataType: 'json'
                }).done(function (data) {
                    let $customer = $('#customer_id');
                    $customer.empty().append('<option value="" disabled selected>ជ្រើសរើសអតិថិជន</option>');
                    $.each(data, function (_, customer) {
                        $customer.append($('<option>').val(customer.id).text(customer.name));
                    });
                    $customer.trigger('change.select2');

                    $('#old_water_number, #old_electric_number, #house_price, #garbage_price, #new_water_number, #new_electric_number, #water_unit_price, #electric_unit_price, #total_used_water, #total_used_electric, #total_amount_water, #total_amount_electric, #total_amount_usd, #total_amount_khr').val('');

                }).fail(function () {
                    console.error('Failed to load customers for block', blockId);
                });

                let blockInfoAjax = $.ajax({
                    url: `/block-info/${blockId}`,
                    method: 'GET',
                    dataType: 'json'
                }).done(function (data) {
                    $('#customer_id').data('blockInfo', data);     
                    $('#customer_id').off('change.blockinfo').on('change.blockinfo', function () {
                        let blockInfo = $(this).data('blockInfo');
                        if (blockInfo) {
                            $('input[name="water_unit_price"]').val(blockInfo.water_unit_price ?? '');
                            $('input[name="electric_unit_price"]').val(blockInfo.electric_unit_price ?? '');
                            $('input[name="min_electric_unit_price"]').val(blockInfo.electric_unit_price ?? '');
                            $('input[name="max_electric_unit_price"]').val(blockInfo.max_electric_unit_price ?? '');
                            $('input[name="calculation_threshold"]').val(blockInfo.calculation_threshold ?? '');
                            $('input[name="electric_source"]').val(blockInfo.electric_source ?? '');
                            
                            $('#water_unit_price, #electric_unit_price').trigger('input');
                        }
                    });
                }).fail(function () {
                    console.error('Failed to load block info for', blockId);
                });

                $.when(customersAjax, blockInfoAjax).always(function () {
                    loadingOverlay.classList.add('hidden');
                });
            });
            
            @if(old('block_id'))
                const oldBlockId = '{{ old('block_id') }}';
                const oldCustomerId = '{{ old('customer_id') }}';
                
                const oldValues = {
                    house_price: '{{ old('house_price') }}',
                    garbage_price: '{{ old('garbage_price') }}',
                    old_water_number: '{{ old('old_water_number') }}',
                    new_water_number: '{{ old('new_water_number') }}',
                    old_electric_number: '{{ old('old_electric_number') }}',
                    new_electric_number: '{{ old('new_electric_number') }}',
                    water_unit_price: '{{ old('water_unit_price') }}',
                    electric_unit_price: '{{ old('electric_unit_price') }}',
                    min_electric_unit_price: '{{ old('min_electric_unit_price') }}',
                    max_electric_unit_price: '{{ old('max_electric_unit_price') }}',
                    calculation_threshold: '{{ old('calculation_threshold') }}',
                    electric_source: '{{ old('electric_source') }}'
                };
                
                if (oldBlockId) {
                    $('#block_id').val(oldBlockId).trigger('change');             
                    setTimeout(function() {
                        if (oldCustomerId) {
                            $('#customer_id').val(oldCustomerId).trigger('change');
                        }
                        
                        setTimeout(function() {
                            Object.keys(oldValues).forEach(function(key) {
                                if (oldValues[key]) {
                                    $(`input[name="${key}"]`).val(oldValues[key]);
                                }
                            });
                            
                            $('#house_price').trigger('input');
                        }, 500);
                    }, 1200);
                }
            @endif
        });

        document.addEventListener('DOMContentLoaded', function() {
            function calculateInvoice() {
                let oldWater = parseFloat(document.getElementById('old_water_number').value) || 0;
                let newWater = parseFloat(document.getElementById('new_water_number').value) || 0;
                let oldElectric = parseFloat(document.getElementById('old_electric_number').value) || 0;
                let newElectric = parseFloat(document.getElementById('new_electric_number').value) || 0;

                let waterUnit = parseFloat(document.getElementById('water_unit_price').value) || 0;
                let minElectricUnit = parseFloat(document.getElementById('min_electric_unit_price').value) || 0;
                let maxElectricUnit = parseFloat(document.getElementById('max_electric_unit_price').value) || 0;
                let calculationThreshold = parseFloat(document.getElementById('calculation_threshold').value) || 0;
                let electricSource = document.getElementById('electric_source').value || '';

                let housePrice = parseFloat(document.getElementById('house_price').value) || 0;
                let garbagePrice = parseFloat(document.getElementById('garbage_price').value) || 0;

                let totalUsedWater = Math.max(newWater - oldWater, 0);
                let totalUsedElectric = Math.max(newElectric - oldElectric, 0);

                let electricUnit;
                if (electricSource === 'S' && totalUsedElectric >= calculationThreshold) {
                    document.getElementById('electric_unit_price').value = maxElectricUnit;
                    electricUnit = parseFloat(maxElectricUnit) || 0;
                } else {
                    document.getElementById('electric_unit_price').value = minElectricUnit;
                    electricUnit = parseFloat(minElectricUnit) || 0;
                }

                let totalWater = totalUsedWater * waterUnit;
                let totalElectric = totalUsedElectric * electricUnit;

                let totalUsd = housePrice;
                let totalKhr = Math.ceil((garbagePrice + totalWater + totalElectric) / 500) * 500;

                document.getElementById('total_used_water').value = totalUsedWater;
                document.getElementById('total_used_electric').value = totalUsedElectric;
                document.getElementById('total_amount_water').value = totalWater;
                document.getElementById('total_amount_electric').value = totalElectric;

                document.getElementById('total_amount_usd').value = totalUsd;
                document.getElementById('total_amount_khr').value = totalKhr;
            }

            ['old_water_number', 'new_water_number', 'old_electric_number', 'new_electric_number', 'water_unit_price', 'electric_unit_price', 'house_price', 'garbage_price', 'min_electric_unit_price', 'max_electric_unit_price', 'calculation_threshold', 'electric_source']
            .forEach(id => {
                let el = document.getElementById(id);
                if(el) el.addEventListener('input', calculateInvoice);
            });
        });
    </script>
@endsection
