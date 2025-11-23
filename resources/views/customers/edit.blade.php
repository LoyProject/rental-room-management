@extends('layouts.app')

@section('title', 'កែប្រែអតិថិជន')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 min-h-full">
        <x-loading-overlay />

        <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid flex-col sm:grid-cols-2 gap-6">
                <div class="grid grid-cols-1 {{ Auth::user()->isAdmin() ? 'md:grid-cols-2' : 'md:grid-cols-1' }} gap-6">
                    <div class="{{ Auth::user()->isAdmin() ? '' : 'hidden' }}">
                        <label class="block mb-1 text-sm font-medium text-gray-700">តំបន់ <span class="text-red-600">*</span></label>
                        <select id="site_id" name="site_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="" disabled selected>ជ្រើសរើសតំបន់</option>
                            @foreach($sites as $site)
                                <option value="{{ $site->id }}"
                                    {{ $customer->block->site_id == $site->id ? 'selected' : '' }}>
                                    {{ $site->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">ទីតាំង <span class="text-red-600">*</span></label>
                        <select id="block_id" name="block_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="" disabled selected>ជ្រើសរើសទីតាំង</option>
                            @if(!Auth::user()->isAdmin())
                                @foreach($blocks as $block)
                                    <option value="{{ $block->id }}" 
                                        {{ $customer->block_id == $block->id ? 'selected' : '' }}>
                                        {{ $block->name }}
                                    </option>
                                @endforeach
                            @else
                                @foreach($blocks as $block)
                                    <option value="{{ $block->id }}" 
                                        {{ $customer->block_id == $block->id ? 'selected' : '' }}>
                                        {{ $block->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('block_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ឈ្មោះអតិថិជន <span class="text-red-600">*</span></label>
                        <input type="text" id="name" name="name" value="{{ $customer->name }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ទូរស័ព្ទ</label>
                        <input type="tel" id="phone" name="phone" value="{{ $customer->phone }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">តម្លៃផ្ទះ (ដុល្លារ) <span class="text-red-600">*</span></label>
                        <input type="number" id="house_price" name="house_price" step="0.01" min="0" value="{{ $customer->house_price }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">តម្លៃសំរាម (រៀល) <span class="text-red-600">*</span></label>
                        <input type="number" id="garbage_price" name="garbage_price" step="100" min="0" value="{{ $customer->garbage_price }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">កុងទ័រចាស់ (ទឹក) (m³)</label>
                        <input type="number" id="old_water_number" name="old_water_number" min="0"
                            value="{{ $customer->old_water_number }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">កុងទ័រចាស់ (អគ្គិសនី) (kWh)</label>
                        <input type="number" id="old_electric_number" name="old_electric_number" min="0"
                            value="{{ $customer->old_electric_number }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 mt-4">
                <a href="{{ route('customers.index') }}" class="w-full sm:w-auto text-center text-sm text-gray-600 hover:underline px-3 py-2">
                    បោះបង់
                </a>
                <button type="submit"
                    class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-blue-600 rounded-md font-semibold text-sm text-white hover:bg-blue-500">
                    កែប្រែ
                </button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#site_id').select2({ width: '100%' });
            $('#block_id').select2({ width: '100%' });

            const loadingOverlay = document.getElementById('loading-overlay');

            $('#site_id').on('change', function () {
                let siteId = $(this).val();
                if (!siteId) return;

                loadingOverlay.classList.remove('hidden');

                $.ajax({
                    url: '/blocks-by-site/' + siteId,
                    type: 'GET',
                    success: function (data) {
                        let blockSelect = $('#block_id');
                        blockSelect.empty();
                        blockSelect.append('<option value="" disabled selected>ជ្រើសរើសទីតាំង</option>');

                        $.each(data, function (i, block) {
                            blockSelect.append(`<option value="${block.id}">${block.name}</option>`);
                        });

                        blockSelect.val('').trigger('change');
                    },
                    complete: function () {
                        loadingOverlay.classList.add('hidden');
                    }
                });
            });
        });
    </script>
@endsection
