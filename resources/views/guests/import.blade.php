@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Import Guests</h1>
    <p class="mb-2 text-gray-600">
        Wedding: 
        <a href="{{ route('weddings.dashboard', $wedding->id) }}" class="text-indigo-600 hover:underline">
            {{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}
        </a>
    </p>

    <p class="text-sm text-gray-700 mb-6">
        To import guests, upload a CSV file with the following columns: 
        <strong>Name, Party Size, Email (optional), Phone (optional), RSVP Status</strong>.
    </p>

    <form action="{{ route('guests.process-import', $wedding->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6 space-y-6">
        @csrf

        <div>
            <label for="guest_csv" class="block text-sm font-medium text-gray-700 mb-1">Choose CSV File</label>
            <input type="file" id="guest_csv" name="guest_csv" accept=".csv" required
                class="block w-full border @error('guest_csv') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('guest_csv')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('guests.index', $wedding->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                Back to Guest List
            </a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                Import Guests
            </button>
        </div>
    </form>

    @if (session('import_status'))
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 rounded">
            {{ session('import_status') }}
        </div>
    @endif
</div>
@endsection
