@extends('layouts.app')

@section('title', 'ប្លុកថ្មី')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('blocks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="site_id" class="block text-sm font-medium text-gray-700">ឈ្មោះតំបន់ <span class="text-red-600">*</span></label>
                    <select id="site_id" name="site_id" required autofocus
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="" disabled {{ old('site_id') ? '' : 'selected' }}>ជ្រើសរើសតំបន់​​</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ old('site_id') == $site->id ? 'selected' : '' }}>{{ $site->name }}</option>
                        @endforeach
                    </select>
                    @error('site_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">ឈ្មោះប្លុក​ <span class="text-red-600">*</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">ពណ៌នា​</label>
                    <textarea id="description" name="description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="water_price" class="block text-sm font-medium text-gray-700">តម្លៃទឹក (រៀល) <span class="text-red-600">*</span></label>
                    <input id="water_price" name="water_price" type="number" step="100" min="0" value="{{ old('water_price') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('water_price')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="electric_price" class="block text-sm font-medium text-gray-700">តម្លៃអគ្គិសនី (រៀល) <span class="text-red-600">*</span></label>
                    <input id="electric_price" name="electric_price" type="number" step="100" min="0" value="{{ old('electric_price') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('electric_price')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 mt-4">
                    <a href="{{ route('blocks.index') }}"
                    class="w-full sm:w-auto text-center sm:text-left text-sm text-gray-600 hover:underline px-3 py-2 rounded-md">
                        បោះបង់
                    </a>

                    <button type="submit"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-200">
                        បង្កើតថ្មី
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
