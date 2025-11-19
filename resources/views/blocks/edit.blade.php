@extends('layouts.app')

@section('title', 'Edit Block')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('blocks.update', $block) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="site_id" class="block text-sm font-medium text-gray-700">Site Name <span class="text-red-600">*</span></label>
                    <select id="site_id" name="site_id" required autofocus
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select a site</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ (old('site_id', $block->site_id) == $site->id) ? 'selected' : '' }}>{{ $site->name }}</option>
                        @endforeach
                    </select>
                    @error('site_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Block Name <span class="text-red-600">*</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name', $block->name) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description', $block->description) }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="water_price" class="block text-sm font-medium text-gray-700">Water Price (KHR) <span class="text-red-600">*</span></label>
                    <input id="water_price" name="water_price" type="number" step="100" min="0" value="{{ old('water_price', $block->water_price) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('water_price')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="electric_price" class="block text-sm font-medium text-gray-700">Electric Price (KHR) <span class="text-red-600">*</span></label>
                    <input id="electric_price" name="electric_price" type="number" step="100" min="0" value="{{ old('electric_price', $block->electric_price) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('electric_price')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 mt-4">
                    <a href="{{ route('blocks.index') }}"
                    class="w-full sm:w-auto text-center sm:text-left text-gray-600 hover:underline px-3 py-2 rounded-md">
                        Cancel
                    </a>

                    <button type="submit"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-200">
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
