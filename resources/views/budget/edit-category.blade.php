@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-1">Edit Budget Category</h1>
            <p class="text-gray-600">
                Wedding: 
                <a href="{{ route('weddings.dashboard', $wedding->id) }}" class="text-blue-600 hover:underline">
                    {{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}
                </a>
            </p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('budget.index', $wedding->id) }}" class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                Back to Budget
            </a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('budget.update-category', [$wedding->id, $category->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <input type="text" name="name" id="name"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                       value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="allocated_amount" class="block text-sm font-medium text-gray-700 mb-1">Allocated Amount</label>
                <input type="number" name="allocated_amount" id="allocated_amount" min="0"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('allocated_amount') border-red-500 @enderror"
                       value="{{ old('allocated_amount', $category->allocated_amount) }}" required>
                @error('allocated_amount')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-end">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
