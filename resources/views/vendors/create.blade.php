@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Add New Vendor for {{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}</h1>

    <form action="{{ route('vendors.store', $wedding->id) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-lg font-medium text-gray-700">Vendor Name</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('name') }}" required>
        </div>

        <div class="mb-4">
            <label for="category" class="block text-lg font-medium text-gray-700">Category</label>
            <select name="category" id="category" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="contact_person" class="block text-lg font-medium text-gray-700">Contact Person</label>
            <input type="text" name="contact_person" id="contact_person" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('contact_person') }}">
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-lg font-medium text-gray-700">Phone</label>
            <input type="text" name="phone" id="phone" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('phone') }}">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('email') }}">
        </div>

        <div class="mb-4">
            <label for="website" class="block text-lg font-medium text-gray-700">Website</label>
            <input type="url" name="website" id="website" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('website') }}">
        </div>

        <div class="mb-4">
            <label for="cost" class="block text-lg font-medium text-gray-700">Cost</label>
            <input type="number" name="cost" id="cost" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('cost') }}" step="0.01">
        </div>

        <div class="mb-4">
            <label for="deposit_amount" class="block text-lg font-medium text-gray-700">Deposit Amount</label>
            <input type="number" name="deposit_amount" id="deposit_amount" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('deposit_amount') }}" step="0.01">
        </div>

        <div class="mb-4">
            <label for="deposit_due_date" class="block text-lg font-medium text-gray-700">Deposit Due Date</label>
            <input type="date" name="deposit_due_date" id="deposit_due_date" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('deposit_due_date') }}">
        </div>

        <div class="mb-4">
            <label for="payment_due_date" class="block text-lg font-medium text-gray-700">Payment Due Date</label>
            <input type="date" name="payment_due_date" id="payment_due_date" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('payment_due_date') }}">
        </div>

        <div class="mb-4">
            <label for="is_booked" class="inline-flex items-center text-lg font-medium text-gray-700">Is Booked?</label>
            <input type="checkbox" name="is_booked" id="is_booked" class="ml-2" {{ old('is_booked') ? 'checked' : '' }}>
        </div>

        <div class="mb-4">
            <label for="is_paid" class="inline-flex items-center text-lg font-medium text-gray-700">Is Paid?</label>
            <input type="checkbox" name="is_paid" id="is_paid" class="ml-2" {{ old('is_paid') ? 'checked' : '' }}>
        </div>

        <div class="mb-4">
            <label for="notes" class="block text-lg font-medium text-gray-700">Notes</label>
            <textarea name="notes" id="notes" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
        </div>

        <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">Save Vendor</button>

        @if ($errors->any())
        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </form>
</div>
@endsection
