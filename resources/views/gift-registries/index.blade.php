@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Gift Registries for {{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}
        </h1>
        <a href="{{ route('gift-registries.create', $wedding->id) }}"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Add New Registry
        </a>
    </div>

    @if($registries->isEmpty())
        <p class="text-gray-600">No gift registries found.</p>
    @else
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto text-left text-sm text-gray-700">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Description</th>
                        <th class="px-6 py-3">Store Name</th>
                        <th class="px-6 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($registries as $registry)
                        <tr>
                            <td class="px-6 py-4">{{ $registry->name }}</td>
                            <td class="px-6 py-4">{{ $registry->description }}</td>
                            <td class="px-6 py-4">{{ $registry->store_name }}</td>
                            <td class="px-6 py-4 text-end">
                                <a href="{{ route('gift-registries.edit', ['wedding' => $wedding->id, 'registry' => $registry->id]) }}"
                                   class="inline-block bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-xs">
                                    Edit
                                </a>
                                <form action="{{ route('gift-registries.destroy', ['wedding' => $wedding->id, 'registry' => $registry->id]) }}"
                                      method="POST" class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-xs"
                                            onclick="return confirm('Are you sure you want to delete this registry?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
