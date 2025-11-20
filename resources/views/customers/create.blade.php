@extends('layouts.app')

@section('title', 'អតិថិជនថ្មី')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="block_id" class="block text-sm font-medium text-gray-700">ប្លុក <span class="text-red-600">*</span></label>
                    <select id="block_id" name="block_id" required autofocus
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">​ជ្រើសរើសប្លុក</option>
                        @foreach($blocks as $block)
                            <option value="{{ $block->id }}" {{ old('block_id') == $block->id ? 'selected' : '' }}>{{ $block->name }}</option>
                        @endforeach
                    </select>
                    @error('block_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">ឈ្នោះអតិថិជន<span class="text-red-600">*</span></label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">ទូរស័ព្ទ <span class="text-red-600">*</span></label>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('phone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="house_price" class="block text-sm font-medium text-gray-700"> តម្លៃផ្ទះ (ដុល្លារ) <span class="text-red-600">*</span></label>
                        <input id="house_price" name="house_price" type="number" step="0.01" min="0" value="{{ old('house_price') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('house_price')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="wifi_price" class="block text-sm font-medium text-gray-700">តម្លៃអ៊ីនធឺណិត (ដុល្លារ) <span class="text-red-600">*</span></label>
                        <input id="wifi_price" name="wifi_price" type="number" step="0.01" min="0" value="{{ old('wifi_price') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('wifi_price')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="garbage_price" class="block text-sm font-medium text-gray-700">តម្លៃសំរាម (រៀល) <span class="text-red-600">*</span></label>
                        <input id="garbage_price" name="garbage_price" type="number" step="100" min="0" value="{{ old('garbage_price') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('garbage_price')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="old_water_number" class="block text-sm font-medium text-gray-700">កុងទ័រចាស់(ទឹក) (m³)</label>
                        <input id="old_water_number" name="old_water_number" type="number" min="0" value="{{ old('old_water_number') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('old_water_number')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="old_electric_number" class="block text-sm font-medium text-gray-700">កុងទ័រចាស់(អគ្គិសនី) (kWh)</label>
                        <input id="old_electric_number" name="old_electric_number" type="number" min="0" value="{{ old('old_electric_number') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('old_electric_number')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 mt-4">
                    <a href="{{ route('customers.index') }}"
                    class="w-full sm:w-auto text-center sm:text-left text-sm text-gray-600 hover:underline px-3 py-2 rounded-md">
                        បោះបង់
                    </a>

                    <button type="submit"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-200">
                        បង្កើតថ្មី
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
