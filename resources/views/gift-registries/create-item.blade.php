@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6">Add Item to Gift Registry for {{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}</h1>

    <form action="{{ route('gift-registries.store-item', ['wedding' => $wedding->id, 'registry' => $registry->id]) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Item Name</label>
            <input type="text" name="name" id="name" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('name') }}" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
            <input type="number" name="price" id="price" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('price') }}" step="0.01">
        </div>

        <div class="mb-4">
            <label for="quantity_desired" class="block text-sm font-medium text-gray-700">Quantity Desired</label>
            <input type="number" name="quantity_desired" id="quantity_desired" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('quantity_desired') }}" required>
        </div>

        <div class="mb-4 text-right">
            <button type="submit" class="btn btn-success px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">Add Item</button>
        </div>
    </form>
</div>
@endsection
