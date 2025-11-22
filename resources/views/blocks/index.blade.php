@extends('layouts.app')

@section('title', 'អំពីទីតាំង')

@section('content')
    <x-success-alert />
    
    <div class="mb-4 p-4 bg-white shadow-md rounded-md flex flex-col lg:flex-row justify-between items-center gap-4">

        <form action="{{ route('blocks.index') }}" method="GET" class="w-full lg:max-w-md">
            <div class="flex flex-row items-center gap-2 w-full">
                @if (auth()->user()->isAdmin() && request('site'))
                    <input type="hidden" name="site" value="{{ request('site') }}">
                @endif
                <input type="text" name="search" placeholder="ស្វែងរកទីតាំង..."
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"
                    value="{{ request('search') }}">
                <button type="submit"
                    class="bg-gray-800 text-white px-6 py-2 hover:bg-gray-900 rounded-md">ស្វែងរក</button>
                <a href="{{ route('blocks.index') }}"
                    class="font-semibold text-sm text-gray-600 hover:underline px-4 py-2 rounded-md">លុប</a>
            </div>
        </form>

        <div class="w-full lg:w-auto flex justify-end lg:flex-row flex-col lg:items-center gap-4">
            @if (auth()->user()->isAdmin())
                <div class="flex-grow lg:flex-grow-0 w-full lg:w-72 lg:min-w-[100px]">
                    <select id="siteFilter" name="site" class="w-full rounded-md shadow-sm border-gray-300">
                        <option value="">ទីតាំងទាំងអស់</option>
                        @foreach ($sites as $site)
                            <option value="{{ $site->id }}" @selected(request('site') == $site->id)>
                                {{ $site->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <a href="{{ route('blocks.create') }}"
                class="bg-blue-100 text-blue-700 px-4 py-2 rounded-md hover:bg-blue-700 hover:text-white w-full sm:w-auto text-center whitespace-nowrap">
                ទីតាំងថ្មី
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg">
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">ល.រ</th>
                        @if (auth()->user()->isAdmin())
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">ឈ្មោះតំបន់</th>
                        @endif
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">ឈ្មោះទីតាំង</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">តម្លៃទឹក</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">តម្លៃអគ្គិសនី</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">ពណ៌នា</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @forelse ($blocks as $block)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $block->id }}</td>
                            @if (auth()->user()->isAdmin())
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $block->site->name }}</td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $block->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($block->water_price, 0, '.', ',') }} រៀល</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($block->electric_price, 0, '.', ',') }} រៀល</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $block->description ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('blocks.edit', $block) }}" class="text-blue-600 hover:text-blue-900 mr-4">កែប្រែ</a>
                                <form action="{{ route('blocks.destroy', $block) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this block?')">លុប</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}" class="text-center px-6 py-4">មិនមានទីតាំងណាមួយទេ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $blocks->links() }}
    </div>
    
    <script>
        $(document).ready(function() {
            $('#siteFilter').select2({
                allowClear: false,
                width: '100%'
            });

            $('#siteFilter').on('select2:select select2:clear', function() {
                let params = new URLSearchParams(window.location.search);

                let site = $('#siteFilter').val();
                let search = params.get('search');

                if (site) {
                    params.set('site', site);
                } else {
                    params.delete('site');
                }

                if (search) {
                    params.set('search', search);
                }

                params.delete('page');

                let queryString = params.toString();
                window.location.href = window.location.pathname + (queryString ? '?' + queryString : '');
            });
        });
    </script>
@endsection
