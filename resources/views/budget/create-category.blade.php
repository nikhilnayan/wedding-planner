@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-1">Create Budget Category</h1>
            <p class="text-gray-600">Wedding: 
                <a href="{{ route('weddings.dashboard', $wedding->id) }}" class="text-blue-500 hover:underline">
                    {{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}
                </a>
            </p>
        </div>
        <a href="{{ route('budget.index', $wedding->id) }}" 
           class="inline-block mt-4 md:mt-0 bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
            Back to Budget
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('budget.store-category', $wedding->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <input type="text" name="name" id="name"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                       value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="allocated_amount" class="block text-sm font-medium text-gray-700 mb-1">Allocated Amount</label>
                <input type="number" name="allocated_amount" id="allocated_amount" min="0"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('allocated_amount') border-red-500 @enderror"
                       value="{{ old('allocated_amount') }}" required>
                @error('allocated_amount')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-right">
                <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
