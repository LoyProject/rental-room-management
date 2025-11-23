@extends('layouts.app')

@section('title', 'កែសម្រួលតំបន់')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 min-h-full">
        <form action="{{ route('sites.update', $site->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">ឈ្មោះ<span class="text-red-600">*</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name', $site->name) }}" required autofocus
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">ទូរស័ព្ទ</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone', $site->phone) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">អាសយដ្ឋាន</label>
                    <textarea id="address" name="address" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('address', $site->address) }}</textarea>
                    @error('address')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 mt-4">
                    <a href="{{ route('sites.index') }}"
                    class="w-full sm:w-auto text-center sm:text-left text-sm text-gray-600 hover:underline px-3 py-2 rounded-md">
                        បោះបង់
                    </a>

                    <button type="submit"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-200">
                        ​យល់ព្រម
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection