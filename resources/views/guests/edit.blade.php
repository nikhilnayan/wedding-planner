@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Guest</h1>
    <p class="mb-4 text-gray-600">
        Wedding: 
        <a href="{{ route('weddings.dashboard', $wedding->id) }}" class="text-indigo-600 hover:underline">
            {{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}
        </a>
    </p>

    <form action="{{ route('guests.update', [$wedding->id, $guest->id]) }}" method="POST" class="bg-white shadow-md rounded-lg p-6 space-y-6">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Guest Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $guest->name) }}" required
                class="block w-full border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Party Size -->
        <div>
            <label for="party_size" class="block text-sm font-medium text-gray-700 mb-1">Party Size</label>
            <input type="number" id="party_size" name="party_size" value="{{ old('party_size', $guest->party_size) }}" min="1" required
                class="block w-full border @error('party_size') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('party_size')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email (optional)</label>
            <input type="email" id="email" name="email" value="{{ old('email', $guest->email) }}"
                class="block w-full border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone (optional)</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $guest->phone) }}"
                class="block w-full border @error('phone') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('phone')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- RSVP Status -->
        <div>
            <label for="rsvp_status" class="block text-sm font-medium text-gray-700 mb-1">RSVP Status</label>
            <select name="rsvp_status" id="rsvp_status" required
                class="block w-full border @error('rsvp_status') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="pending" {{ old('rsvp_status', $guest->rsvp_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="attending" {{ old('rsvp_status', $guest->rsvp_status) == 'attending' ? 'selected' : '' }}>Attending</option>
                <option value="declined" {{ old('rsvp_status', $guest->rsvp_status) == 'declined' ? 'selected' : '' }}>Declined</option>
            </select>
            @error('rsvp_status')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex justify-between items-center">
            <a href="{{ route('guests.index', $wedding->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                Back to Guest List
            </a>
            <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                Update Guest
            </button>
        </div>
    </form>
</div>
@endsection
