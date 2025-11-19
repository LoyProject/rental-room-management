@extends('layouts.app')

@section('title', 'Manage Sites')

@section('content')
    <x-success-alert />
    
    <div class="mb-4 p-4 bg-white shadow-md rounded-md flex flex-col sm:flex-row justify-between items-center gap-4">
        <form action="{{ route('sites.index') }}" method="GET" class="w-full sm:max-w-md">
            <div class="flex flex-row items-center gap-2 w-full">
                <input type="text" name="search" placeholder="Search sites..."
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"
                    value="{{ request('search') }}">
                <button type="submit" class="bg-gray-800 text-white px-6 py-2 hover:bg-gray-900 rounded-md">Search</button>
                <a href="{{ route('sites.index') }}" class="font-semibold text-sm text-gray-600 hover:underline px-4 py-2 rounded-md">Clear</a>
            </div>
        </form>

        <div class="w-full sm:w-auto flex justify-end">
            <a href="{{ route('sites.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full sm:w-auto text-center whitespace-nowrap">
                New Site
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg">
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Phone</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Address</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @forelse ($sites as $site)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $site->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $site->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $site->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $site->address ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('sites.edit', $site) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                <form action="{{ route('sites.destroy', $site) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this site?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-4">No sites found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $sites->links() }}
    </div>
@endsection