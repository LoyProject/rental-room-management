@extends('layouts.app')

@section('title', 'អំពីអ្នកប្រើប្រាស់')

@section('content')
    <x-success-alert />
    
    <div class="mb-4 p-4 bg-white shadow-md rounded-md flex flex-col sm:flex-row justify-between items-center gap-4">
        <form action="{{ route('users.index') }}" method="GET" class="w-full sm:max-w-md">
            <div class="flex flex-row items-center gap-2 w-full">
                @if (auth()->user()->isAdmin() && request('role'))
                    <input type="hidden" name="role" value="{{ request('role') }}">
                @endif
                <input type="text" name="search" placeholder="ស្វែងរកអ្នកប្រើប្រាស់..."
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"
                    value="{{ request('search') }}">
                <button type="submit" class="bg-gray-800 text-white px-6 py-2 hover:bg-gray-900 rounded-md">ស្វែងរក</button>
                <a href="{{ route('users.index') }}" class="font-semibold text-sm text-gray-600 hover:underline px-4 py-2 rounded-md">លុប</a>
            </div>
        </form>

        <div class="w-full lg:w-auto flex justify-end lg:flex-row flex-col lg:items-center gap-4">
            @if (auth()->user()->isAdmin())
                <div class="flex-grow lg:flex-grow-0 w-full lg:w-72 lg:min-w-[100px]">
                    <select id="roleFilter" name="role" class="w-full rounded-md shadow-sm border-gray-300">
                        <option value="">តួនាទីទាំងអស់</option>
                        <option value="admin" @selected(request('role') == 'admin')>Admin</option>
                        <option value="user" @selected(request('role') == 'user')>User</option>
                    </select>
                </div>
            @endif

            <a href="{{ route('users.create') }}" class="bg-blue-100 text-blue-700 px-4 py-2 rounded-md hover:bg-blue-700 hover:text-white w-full sm:w-auto text-center whitespace-nowrap">
                អ្នកប្រើប្រាស់ថ្មី
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg">
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">ល.រ</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">ឈ្មោះ</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">អ៊ីមែល</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">តួនាទី</th>
                        <th class="px-6 py-3 whitespace-nowrap text-left font-semibold text-gray-700">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @forelse ($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($user->role) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 mr-4">កែប្រែ</a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this user?')">លុប</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-4">មិនមានអ្នកប្រើប្រាស់ណាមួយទេ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-4">
        {{ $users->withQueryString()->links() }}
    </div>
    <script>
        $(document).ready(function() {
            $('#roleFilter').select2({
                allowClear: false,
                width: '100%'
            });

            $('#roleFilter').on('select2:select select2:clear', function() {
                let params = new URLSearchParams(window.location.search);

                let role = $('#roleFilter').val();
                let search = params.get('search');

                if (role) {
                    params.set('role', role);
                } else {
                    params.delete('role');
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