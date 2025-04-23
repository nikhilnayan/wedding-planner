@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Budget Item</h1>

    <form action="{{ route('budget.update-item', [$wedding->id, $category->id, $item->id]) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
            <input type="text" name="name" id="name"
                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   value="{{ $item->name }}" required>
        </div>

        <div class="mb-4">
            <label for="estimated_cost" class="block text-sm font-medium text-gray-700 mb-1">Estimated Cost</label>
            <input type="number" name="estimated_cost" id="estimated_cost" step="0.01"
                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   value="{{ $item->estimated_cost }}" required>
        </div>

        <div class="mb-6">
            <label for="actual_cost" class="block text-sm font-medium text-gray-700 mb-1">Actual Cost</label>
            <input type="number" name="actual_cost" id="actual_cost" step="0.01"
                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   value="{{ $item->actual_cost }}">
        </div>

        <div class="flex justify-start space-x-3">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition">
                Update Item
            </button>
            <a href="{{ route('budget.index', $wedding->id) }}"
               class="bg-gray-200 text-gray-800 px-5 py-2 rounded-md hover:bg-gray-300 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
