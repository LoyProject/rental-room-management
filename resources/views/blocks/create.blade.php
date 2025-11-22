@extends('layouts.app')

@section('title', 'ទីតាំងថ្មី')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 min-h-full">
        <form action="{{ route('blocks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <div class="{{ auth()->user()->isAdmin() ? '' : 'hidden' }}">
                    <label for="site_id" class="block mb-1 text-sm font-medium text-gray-700">ឈ្មោះតំបន់ <span class="text-red-600">*</span></label>
                    <select id="site_id" name="site_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" aria-hidden="false">
                        <option value="" disabled {{ old('site_id') ? '' : 'selected' }}>ជ្រើសរើសតំបន់​​</option>
                        @php $userSiteId = optional(auth()->user())->site_id; @endphp
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ (old('site_id') == $site->id) || (old('site_id') === null && $userSiteId == $site->id) ? 'selected' : '' }}>{{ $site->name }}</option>
                        @endforeach
                    </select>
                    @error('site_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">ឈ្មោះទីតាំង​ <span class="text-red-600">*</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">ពណ៌នា​</label>
                    <textarea id="description" name="description" rows="2"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="water_price" class="block text-sm font-medium text-gray-700">តម្លៃទឹក (រៀល) <span class="text-red-600">*</span></label>
                    <input id="water_price" name="water_price" type="number" step="10" min="0" value="{{ old('water_price') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('water_price')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="electric_container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="electric_source" class="block text-sm font-medium text-gray-700">ប្រភពអគ្គិសនី <span class="text-red-600">*</span>
                        </label>
                        <select id="electric_source" name="electric_source" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="P">ឯកជន</option>
                            <option value="S">រដ្ឋ</option>
                        </select>
                    </div>     
                    <div>
                        <label id="label_electric_price" for="electric_price" class="block text-sm font-medium text-gray-700">តម្លៃអគ្គិសនីអប្បបរមា (រៀល) <span class="text-red-600">*</span></label>
                        <input id="electric_price" name="electric_price" type="number" 
                            step="10" min="0" value="" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>                        
                    <div id="max_electric_container" class="hidden">
                        <label for="max_electric_price" class="block text-sm font-medium text-gray-700">តម្លៃអគ្គិសនីអតិបរមា (រៀល) <span class="text-red-600">*</span></label>
                        <input id="max_electric_price" name="max_electric_price" type="number" 
                            step="10" min="0" value="" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                    <div id="calculation_threshold_container" class="hidden">
                        <label for="calculation_threshold" class="block text-sm font-medium text-gray-700">ចំនួនការគណនាសម្រាប់តម្លៃអតិបរមា <span class="text-red-600">*</span></label>
                        <input id="calculation_threshold" name="calculation_threshold" type="number" 
                            min="1" value=""
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const electricContainer = document.getElementById('electric_container');
            const electricSource = document.getElementById('electric_source');
            const labelElectricPrice = document.getElementById('label_electric_price');
            const electricPrice = document.getElementById('electric_price');
            const maxElectricContainer = document.getElementById('max_electric_container');
            const maxElectricPrice = document.getElementById('max_electric_price');
            const calculationThresholdContainer = document.getElementById('calculation_threshold_container');
            const calculationThreshold = document.getElementById('calculation_threshold');

            $(document).ready(function() {
                $('#site_id').select2({
                    allowClear: false,
                    width: '100%'
                });
            });
            
            function togglePriceFields() {
                if (electricSource.value === 'P') {
                    electricContainer.classList.remove('md:grid-cols-4');
                    electricContainer.classList.add('md:grid-cols-2');
                    maxElectricContainer.classList.add('hidden');
                    calculationThresholdContainer.classList.add('hidden');
                    maxElectricPrice.value = '';
                    calculationThreshold.value = '';
                    labelElectricPrice.innerHTML = 'តម្លៃអគ្គិសនី (រៀល) <span class="text-red-600">*</span>';
                } else {
                    electricContainer.classList.remove('md:grid-cols-2');
                    electricContainer.classList.add('md:grid-cols-4');
                    maxElectricContainer.classList.remove('hidden');
                    calculationThresholdContainer.classList.remove('hidden');
                    labelElectricPrice.innerHTML = 'តម្លៃអគ្គិសនីអប្បបរមា (រៀល) <span class="text-red-600">*</span>';
                }
            }
            
            togglePriceFields();
            
            electricSource.addEventListener('change', togglePriceFields);
        });
    </script>
@endsection
