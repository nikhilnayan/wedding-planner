@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Create a New Budget Item for <span class="text-blue-600">{{ $category->name }}</span>
    </h1>

    <form action="{{ route('budget.store-item', [$wedding->id, $category->id]) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
            <input type="text" name="name" id="name" required
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="estimated_cost" class="block text-sm font-medium text-gray-700 mb-1">Estimated Cost</label>
            <input type="number" name="estimated_cost" id="estimated_cost" step="0.01" required
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="actual_cost" class="block text-sm font-medium text-gray-700 mb-1">Actual Cost</label>
            <input type="number" name="actual_cost" id="actual_cost" step="0.01"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-6">
            <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-1">Payment Date</label>
            <input type="date" name="payment_date" id="payment_date"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="text-end">
            <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition">
                Save Item
            </button>
        </div>
    </form>
</div>
@endsection
