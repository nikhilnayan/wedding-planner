@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h1 class="text-3xl font-bold mb-8 text-gray-800 border-b pb-4">Edit Gift Registry for {{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}</h1>
    
    <form action="{{ route('gift-registries.update', ['wedding' => $wedding->id, 'registry' => $registry->id]) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Registry Name</label>
            <input type="text" name="name" id="name" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" value="{{ old('name', $registry->name) }}" required>
        </div>
        
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" id="description" rows="4" class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">{{ old('description', $registry->description) }}</textarea>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="store_name" class="block text-sm font-medium text-gray-700 mb-1">Store Name</label>
                <input type="text" name="store_name" id="store_name" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" value="{{ old('store_name', $registry->store_name) }}">
            </div>
            
            <div>
                <label for="store_url" class="block text-sm font-medium text-gray-700 mb-1">Store URL</label>
                <input type="url" name="store_url" id="store_url" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" value="{{ old('store_url', $registry->store_url) }}">
            </div>
        </div>
        
        <div class="flex justify-between items-center mt-8">
            <a href="{{ route('gift-registries.index', $wedding) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">← Back to Registries</a>
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out shadow-sm">
                Update Registry
            </button>
        </div>
    </form>
</div>
@endsection