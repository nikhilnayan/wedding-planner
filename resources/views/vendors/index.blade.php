@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}'s Wedding - Vendors</h1>

    <a href="{{ route('vendors.create', $wedding->id) }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 mb-6">
        Add Vendor
    </a>

    @if ($vendors->isEmpty())
        <p class="text-gray-600">No vendors added yet.</p>
    @else
        @foreach ($vendorsByCategory as $category => $vendorsInCategory)
            <h3 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">{{ $category }}</h3>
            <ul class="space-y-4">
                @foreach ($vendorsInCategory as $vendor)
                    <li class="bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 transition duration-200">
                        <a href="{{ route('vendors.show', [$wedding->id, $vendor->id]) }}" class="text-indigo-600 hover:underline">
                            {{ $vendor->name }}
                        </a>
                        <span class="text-gray-500">- {{ $vendor->contact_person ?? 'No contact' }}</span>
                    </li>
                @endforeach
            </ul>
        @endforeach
    @endif
</div>
@endsection
