@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $vendor->name }}</h1>

    <p class="text-lg text-gray-700 mb-2"><strong>Category:</strong> {{ $vendor->category }}</p>
    <p class="text-lg text-gray-700 mb-2"><strong>Contact Person:</strong> {{ $vendor->contact_person ?? 'N/A' }}</p>
    <p class="text-lg text-gray-700 mb-2"><strong>Phone:</strong> {{ $vendor->phone ?? 'N/A' }}</p>
    <p class="text-lg text-gray-700 mb-2"><strong>Email:</strong> {{ $vendor->email ?? 'N/A' }}</p>
    <p class="text-lg text-gray-700 mb-2"><strong>Website:</strong> 
        <a href="{{ $vendor->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $vendor->website ?? 'N/A' }}</a>
    </p>
    <p class="text-lg text-gray-700 mb-2"><strong>Cost:</strong> ₹{{ number_format($vendor->cost, 2) }}</p>
    <p class="text-lg text-gray-700 mb-2"><strong>Deposit Amount:</strong> ₹{{ number_format($vendor->deposit_amount, 2) }}</p>
    <p class="text-lg text-gray-700 mb-2"><strong>Deposit Due Date:</strong> {{ $vendor->deposit_due_date ? \Carbon\Carbon::parse($vendor->deposit_due_date)->format('F j, Y') : 'N/A' }}</p>
    <p class="text-lg text-gray-700 mb-2"><strong>Payment Due Date:</strong> {{ $vendor->payment_due_date ? \Carbon\Carbon::parse($vendor->payment_due_date)->format('F j, Y') : 'N/A' }}</p>
    <p class="text-lg text-gray-700 mb-2"><strong>Status:</strong> 
        @if ($vendor->is_booked) <span class="text-green-600">Booked</span> @else <span class="text-red-600">Not Booked</span> @endif |
        @if ($vendor->is_paid) <span class="text-green-600">Paid</span> @else <span class="text-red-600">Not Paid</span> @endif
    </p>
    <p class="text-lg text-gray-700 mb-6"><strong>Notes:</strong> {{ $vendor->notes ?? 'N/A' }}</p>

    <div class="flex justify-between">
        <a href="{{ route('vendors.edit', [$wedding->id, $vendor->id]) }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Edit Vendor
        </a>
        
        <form action="{{ route('vendors.destroy', [$wedding->id, $vendor->id]) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                onclick="return confirm('Are you sure you want to delete this vendor?')">
                Delete
            </button>
        </form>
    </div>
</div>
@endsection
