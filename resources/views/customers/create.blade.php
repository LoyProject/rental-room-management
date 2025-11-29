@extends('layouts.app')

@section('title', 'អតិថិជនថ្មី')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 min-h-full">
        <x-loading-overlay />

        <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid flex-col sm:grid-cols-2 gap-6">
                <div class="grid grid-cols-1 {{ Auth::user()->isAdmin() ? 'md:grid-cols-2' : 'md:grid-cols-1' }} gap-6">
                    <div class="{{ Auth::user()->isAdmin() ? '' : 'hidden' }}">
                        <label for="site_id" class="block mb-1 text-sm font-medium text-gray-700">តំបន់ <span class="text-red-600">*</span></label>
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
                        <label for="block_id" class="mb-1 block text-sm font-medium text-gray-700">ទីតាំង <span class="text-red-600">*</span></label>
                        <select id="block_id" name="block_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" aria-hidden="false">
                            <option value="" disabled {{ old('block_id') ? '' : 'selected' }}>​ជ្រើសរើសទីតាំង</option>
                            @if(Auth::user()->isAdmin() == false)
                                @foreach($blocks as $block)
                                    <option value="{{ $block->id }}" {{ old('block_id') == $block->id ? 'selected' : '' }}>{{ $block->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('block_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
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
                        <label for="phone" class="block text-sm font-medium text-gray-700">ទូរស័ព្ទ</label>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('phone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="house_price" class="block text-sm font-medium text-gray-700"> តម្លៃផ្ទះ (ដុល្លារ) <span class="text-red-600">*</span></label>
                        <input id="house_price" name="house_price" type="number" step="0.01" min="0" value="{{ old('house_price') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('house_price')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label id="editableLabel" for="garbage_price" class="cursor-pointer block text-sm font-medium text-gray-700">តម្លៃសំរាម (រៀល) <span class="text-red-600">*</span></label>
                        <input type="hidden" id="label_value" name="label_value" value="សំរាម">
                        <input id="garbage_price" name="garbage_price" type="number" step="100" min="0" value="{{ old('garbage_price') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('garbage_price')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 mt-4">
                <a href="{{ route('customers.index') }}"
                class="w-full sm:w-auto text-center sm:text-left text-sm text-gray-600 hover:underline px-3 py-2 rounded-md">
                    បោះបង់
                </a>

                <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-200">
                    បង្កើតថ្មី
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                    success: function(data) {
                        let blockSelect = $('#block_id');
                        blockSelect.empty();
                        blockSelect.append('<option value="" disabled selected>ជ្រើសរើសទីតាំង</option>');
                        $.each(data, function(i, block) {
                            blockSelect.append(
                                `<option value="${block.id}">${block.name}</option>`
                            );
                        });
                        blockSelect.val('').trigger('change');
                    },
                    complete: function () {
                        loadingOverlay.classList.add('hidden');
                    }
                });
            });
        });

        document.getElementById('editableLabel').onclick = () => {
            let currentText = document.getElementById('editableLabel').innerText;
            let base = "តម្លៃ";
            let suffix = " (រៀល) *";
            let middle = currentText.replace(base, "").replace("(រៀល) *", "").trim();
            let newWord = prompt("បញ្ចូលឈ្មោះជំនួស:", middle);
            if (newWord !== null && newWord.trim() !== "") {
                document.getElementById('editableLabel').innerHTML = `${base}${newWord} (រៀល) <span class="text-red-600">*</span>`;
                document.getElementById('label_value').value = newWord.trim();
            }
        };
    </script>
@endsection
