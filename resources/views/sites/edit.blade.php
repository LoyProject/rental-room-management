@extends('layouts.app')

@section('title', 'Edit Site')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('sites.update', $site->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-600">*</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name', $site->name) }}" required autofocus
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone <span class="text-red-600">*</span></label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone', $site->phone) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea id="address" name="address" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('address', $site->address) }}</textarea>
                    @error('address')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 mt-4">
                    <a href="{{ route('sites.index') }}"
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