@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Wedding</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('weddings.update', $wedding->id) }}" method="POST" class="bg-white rounded-xl shadow-md p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="partner1_name" class="block text-gray-700 font-medium mb-2">Partner 1 Name</label>
            <input type="text" name="partner1_name" id="partner1_name"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 @error('partner1_name') border-red-500 @enderror"
                value="{{ old('partner1_name', $wedding->partner1_name) }}" required>
        </div>

        <div>
            <label for="partner2_name" class="block text-gray-700 font-medium mb-2">Partner 2 Name</label>
            <input type="text" name="partner2_name" id="partner2_name"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 @error('partner2_name') border-red-500 @enderror"
                value="{{ old('partner2_name', $wedding->partner2_name) }}" required>
        </div>

        <div>
            <label for="wedding_date" class="block text-gray-700 font-medium mb-2">Wedding Date</label>
            <input type="date" name="wedding_date" id="wedding_date"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 @error('wedding_date') border-red-500 @enderror"
                value="{{ old('wedding_date', $wedding->wedding_date->format('Y-m-d')) }}" required>
        </div>

        <div>
            <label for="venue" class="block text-gray-700 font-medium mb-2">Venue</label>
            <input type="text" name="venue" id="venue"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500"
                value="{{ old('venue', $wedding->venue) }}">
        </div>

        <div>
            <label for="venue_address" class="block text-gray-700 font-medium mb-2">Venue Address</label>
            <textarea name="venue_address" id="venue_address"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500">{{ old('venue_address', $wedding->venue_address) }}</textarea>
        </div>

        <div>
            <label for="guest_count" class="block text-gray-700 font-medium mb-2">Expected Guest Count</label>
            <input type="number" name="guest_count" id="guest_count"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500"
                value="{{ old('guest_count', $wedding->guest_count) }}">
        </div>

        <div>
            <label for="budget_total" class="block text-gray-700 font-medium mb-2">Total Budget</label>
            <input type="number" name="budget_total" id="budget_total"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500"
                value="{{ old('budget_total', $wedding->budget_total) }}">
        </div>

        <div>
            <label for="notes" class="block text-gray-700 font-medium mb-2">Notes</label>
            <textarea name="notes" id="notes"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500">{{ old('notes', $wedding->notes) }}</textarea>
        </div>

        <div>
            <button type="submit"
                class="w-full md:w-auto bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium py-2.5 px-6 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Update Wedding
            </button>
        </div>
    </form>
</div>
@endsection
