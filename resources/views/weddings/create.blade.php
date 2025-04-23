@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div class="w-full md:w-2/3 mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800 relative after:content-[''] after:absolute after:left-0 after:-bottom-2 after:w-24 after:h-1 after:bg-gradient-to-r after:from-pink-500 after:to-purple-600 after:rounded-full">Create Wedding</h1>
        </div>
        <div class="w-full md:w-1/3 text-center md:text-right">
            <a href="{{ route('weddings.index') }}" class="inline-block bg-gradient-to-r from-gray-500 to-gray-600 text-white px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium">Back to Weddings</a>
        </div>
    </div>

    <form action="{{ route('weddings.store') }}" method="POST">
        @csrf

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="mb-6">
                    <label for="partner1_name" class="block text-gray-700 font-medium mb-2">Partner 1 Name</label>
                    <input type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-colors duration-200 @error('partner1_name') border-red-500 @enderror" id="partner1_name" name="partner1_name" value="{{ old('partner1_name') }}" required>
                    @error('partner1_name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="partner2_name" class="block text-gray-700 font-medium mb-2">Partner 2 Name</label>
                    <input type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-colors duration-200 @error('partner2_name') border-red-500 @enderror" id="partner2_name" name="partner2_name" value="{{ old('partner2_name') }}" required>
                    @error('partner2_name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="wedding_date" class="block text-gray-700 font-medium mb-2">Wedding Date</label>
                    <input type="date" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-colors duration-200 @error('wedding_date') border-red-500 @enderror" id="wedding_date" name="wedding_date" value="{{ old('wedding_date') }}">
                    @error('wedding_date')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="location" class="block text-gray-700 font-medium mb-2">Location</label>
                    <input type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-colors duration-200 @error('location') border-red-500 @enderror" id="location" name="location" value="{{ old('location') }}">
                    @error('location')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="budget" class="block text-gray-700 font-medium mb-2">Budget</label>
                    <input type="number" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-colors duration-200 @error('budget') border-red-500 @enderror" id="budget" name="budget" value="{{ old('budget') }}" min="0">
                    @error('budget')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium py-2.5 px-8 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Create Wedding</button>
            </div>
        </div>
    </form>
</div>
@endsection