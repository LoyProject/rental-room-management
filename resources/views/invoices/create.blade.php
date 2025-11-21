@extends('layouts.app')

@section('title', 'បង្កើតវិក្ក័យបត្រថ្មី')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <x-loading-overlay />
        
        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="block_id" class="block text-sm font-medium text-gray-700">
                        ប្លុក <span class="text-red-600">*</span>
                    </label>
                    <select id="block_id" name="block_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring-blue-200">
                        <option value="" disabled selected>ជ្រើសរើសប្លុក</option>
                        @foreach($blocks as $block)
                            <option value="{{ $block->id }}">{{ $block->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">
                        អតិថិជន <span class="text-red-600">*</span>
                    </label>
                    <select id="customer_id" name="customer_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring-blue-200">
                        <option value="" disabled selected>ជ្រើសរើសអតិថិជន</option>  
                    </select>
                </div>

                <div>
                    <label for="invoice_date" class="block text-sm font-medium text-gray-700">
                        កាលបរិច្ឆេទវិក្កយបត្រ <span class="text-red-600">*</span>
                    </label>
                    <input type="date" id="invoice_date" name="invoice_date" required
                        class="mt-1 block w-full rounded-md border-gray-300">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="from_date" class="block text-sm font-medium text-gray-700">ពីថ្ងៃ <span class="text-red-600">*</span></label>
                        <input type="date" name="from_date" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="to_date" class="block text-sm font-medium text-gray-700">ដល់ថ្ងៃ <span class="text-red-600">*</span></label>
                        <input type="date" name="to_date" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="house_price" class="block text-sm font-medium">តម្លៃផ្ទះ (ដុល្លារ) <span class="text-red-600">*</span></label>
                        <input type="number" id="house_price" name="house_price" step="0.01" min="0" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="wifi_price" class="block text-sm font-medium">តម្លៃអ៊ីនធឺណិត (ដុល្លារ) <span class="text-red-600">*</span></label>
                        <input type="number" id="wifi_price" name="wifi_price" step="0.01" min="0" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="garbage_price" class="block text-sm font-medium">សំរាម (រៀល) <span class="text-red-600">*</span></label>
                        <input type="number" id="garbage_price" name="garbage_price" step="100"  min="0" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">ទឹក (ចាស់ / ថ្មី) <span class="text-red-600">*</span></label>
                        <div class="grid grid-cols-3 gap-2">
                            <input type="number" id="old_water_number" name="old_water_number" min="0" placeholder="ចំនួនចាស់"
                                class="mt-1 block w-full border-gray-300 rounded-md" required>
                            <input type="number" id="new_water_number" name="new_water_number" min="0" placeholder="ចំនួនថ្មី"
                                class="mt-1 block w-full border-gray-300 rounded-md" required>

                            <input type="number" id="total_used_water" name="total_used_water" 
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md" readonly>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">អគ្គិសនី (ចាស់ / ថ្មី) <span class="text-red-600">*</span></label>
                        <div class="grid grid-cols-3 gap-2">
                            <input type="number" id="old_electric_number" name="old_electric_number" min="0" placeholder="ចំនួនចាស់"
                                class="mt-1 block w-full border-gray-300 rounded-md" required>
                            <input type="number" id="new_electric_number" name="new_electric_number" min="0" placeholder="ចំនួនថ្មី"
                                class="mt-1 block w-full border-gray-300 rounded-md" required>

                            <input type="number" id="total_used_electric" name="total_used_electric" 
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md" readonly>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">តម្លៃទឹក / ១ ខ្នាត (រៀល) <span class="text-red-600">*</span></label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" id="water_unit_price" name="water_unit_price" min="0" 
                                class="mt-1 block w-full border-gray-300 rounded-md" required>

                            <input type="number" id="total_amount_water" name="total_amount_water" 
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md" readonly>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">តម្លៃអគ្គិសនី / ១ ខ្នាត (រៀល) <span class="text-red-600">*</span></label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" id="electric_unit_price" name="electric_unit_price" min="0" 
                                class="mt-1 block w-full border-gray-300 rounded-md" required>

                            <input type="number" id="total_amount_electric" name="total_amount_electric" 
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md" readonly>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="total_amount_usd" class="block text-sm font-medium">ចំនួនទឹកប្រាក់សរុប (ដុល្លារ)</label>
                        <input type="number" id="total_amount_usd" name="total_amount_usd" 
                            class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md" readonly> 
                    </div>
                    <div>
                        <label for="total_amount_khr" class="block text-sm font-medium">ចំនួនទឹកប្រាក់សរុប (រៀល)</label>
                        <input type="number" id="total_amount_khr" name="total_amount_khr" 
                            class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md" readonly> 
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
        document.getElementById('invoice_date').value = new Date().toISOString().slice(0, 10);

        document.addEventListener('DOMContentLoaded', function() {
            const loadingOverlay = document.getElementById('loading-overlay');

            document.getElementById('customer_id').addEventListener('change', function () {
                let customerId = this.value;
                if(!customerId) return;

                loadingOverlay.classList.remove('hidden');

                const customerInfoPromise = fetch(`/customer-info/${customerId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.querySelector('input[name="house_price"]').value = data.house_price ?? '';
                        document.querySelector('input[name="wifi_price"]').value = data.wifi_price ?? '';
                        document.querySelector('input[name="garbage_price"]').value = data.garbage_price ?? '';
                        document.querySelector('input[name="old_water_number"]').value = data.old_water_number ?? '';
                        document.querySelector('input[name="old_electric_number"]').value = data.old_electric_number ?? '';
                    });

                Promise.all([customerInfoPromise])
                    .finally(() => {
                        loadingOverlay.classList.add('hidden');
                    });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const loadingOverlay = document.getElementById('loading-overlay');

            document.getElementById('block_id').addEventListener('change', function () {
                let blockId = this.value;
                if(!blockId) return;

                loadingOverlay.classList.remove('hidden');

                const customersPromise = fetch(`/customers-by-block/${blockId}?month={{ date('m') }}&year={{ date('Y') }}`)
                    .then(res => res.json())
                    .then(data => {
                        let customerSelect = document.getElementById('customer_id');
                        customerSelect.innerHTML = '<option value="" disabled selected>ជ្រើសរើសអតិថិជន</option>';

                        data.forEach(customer => {
                            customerSelect.innerHTML += `<option value="${customer.id}">${customer.name}</option>`;
                        });
                    });

                const blockInfoPromise = fetch(`/block-info/${blockId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.querySelector('input[name="water_unit_price"]').value = data.water_unit_price ?? '';
                        document.querySelector('input[name="electric_unit_price"]').value = data.electric_unit_price ?? '';
                    });

                Promise.all([customersPromise, blockInfoPromise])
                    .finally(() => {
                        loadingOverlay.classList.add('hidden');
                    });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            function calculateInvoice() {
                let oldWater = parseFloat(document.getElementById('old_water_number').value) || 0;
                let newWater = parseFloat(document.getElementById('new_water_number').value) || 0;
                let oldElectric = parseFloat(document.getElementById('old_electric_number').value) || 0;
                let newElectric = parseFloat(document.getElementById('new_electric_number').value) || 0;

                let waterUnit = parseFloat(document.getElementById('water_unit_price').value) || 0;
                let electricUnit = parseFloat(document.getElementById('electric_unit_price').value) || 0;

                let housePrice = parseFloat(document.getElementById('house_price').value) || 0;
                let wifiPrice = parseFloat(document.getElementById('wifi_price').value) || 0;
                let garbagePrice = parseFloat(document.getElementById('garbage_price').value) || 0;

                let totalUsedWater = Math.max(newWater - oldWater, 0);
                let totalUsedElectric = Math.max(newElectric - oldElectric, 0);

                let totalWater = totalUsedWater * waterUnit;
                let totalElectric = totalUsedElectric * electricUnit;

                let totalUsd = housePrice + wifiPrice;
                let totalKhr = Math.ceil((garbagePrice + totalWater + totalElectric) / 500) * 500;

                document.getElementById('total_used_water').value = totalUsedWater;
                document.getElementById('total_used_electric').value = totalUsedElectric;
                document.getElementById('total_amount_water').value = totalWater;
                document.getElementById('total_amount_electric').value = totalElectric;

                document.getElementById('total_amount_usd').value = totalUsd;
                document.getElementById('total_amount_khr').value = totalKhr;
            }

            ['old_water_number','new_water_number','old_electric_number','new_electric_number',
            'water_unit_price','electric_unit_price','house_price','wifi_price','garbage_price']
            .forEach(id => {
                let el = document.getElementById(id);
                if(el) el.addEventListener('input', calculateInvoice);
            });

        });
    </script>
@endsection
