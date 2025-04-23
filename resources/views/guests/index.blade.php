@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Guest List</h1>
            <p class="text-sm text-gray-600">
                Wedding: <a href="{{ route('weddings.dashboard', $wedding->id) }}" class="text-indigo-600 hover:underline">{{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}</a>
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('guests.create', $wedding->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Add Guest</a>
            <a href="{{ route('guests.import', $wedding->id) }}" class="px-4 py-2 border border-indigo-600 text-indigo-600 rounded hover:bg-indigo-50">Import Guests</a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white shadow rounded-lg p-4 text-center">
            <h3 class="text-xl font-bold">{{ $guestStats['invited'] }}</h3>
            <p class="text-sm text-gray-500">Total Invited</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4 text-center">
            <h3 class="text-xl font-bold">{{ $guestStats['attending'] }}</h3>
            <p class="text-sm text-gray-500">Confirmed Attending</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4 text-center">
            <h3 class="text-xl font-bold">{{ $guestStats['declined'] }}</h3>
            <p class="text-sm text-gray-500">Declined</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4 text-center">
            <h3 class="text-xl font-bold">{{ $guestStats['total_attending'] }}</h3>
            <p class="text-sm text-gray-500">Total Guests Attending</p>
        </div>
    </div>

    <!-- Guest Tabs -->
    <div class="bg-white rounded-lg shadow">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-4 p-4" aria-label="Tabs">
                @foreach (['all', 'attending', 'pending', 'declined'] as $status)
                    <button 
                        class="px-3 py-2 text-sm font-medium rounded-md 
                            {{ request('tab', 'all') === $status ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600' }}"
                        onclick="showTab('{{ $status }}')">
                        {{ ucfirst($status) }} ({{ $status === 'all' ? $guests->count() : $guestStats[$status] }})
                    </button>
                @endforeach
            </nav>
        </div>

        <div class="p-4">
            @foreach(['all', 'attending', 'pending', 'declined'] as $status)
                @php
                    $filteredGuests = $status === 'all' 
                        ? $guests 
                        : $guests->filter(fn($guest) => $guest->rsvp_status === $status);
                @endphp

                <div class="tab-content {{ request('tab', 'all') === $status ? '' : 'hidden' }}" id="tab-{{ $status }}">
                    @if ($filteredGuests->count())
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="border-b text-gray-600">
                                        <th class="px-4 py-2">Name</th>
                                        <th class="px-4 py-2">Party Size</th>
                                        <th class="px-4 py-2">Email</th>
                                        <th class="px-4 py-2">Phone</th>
                                        <th class="px-4 py-2">RSVP Status</th>
                                        <th class="px-4 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($filteredGuests as $guest)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-2">{{ $guest->name }}</td>
                                            <td class="px-4 py-2">{{ $guest->party_size }}</td>
                                            <td class="px-4 py-2">{{ $guest->email ?? '—' }}</td>
                                            <td class="px-4 py-2">{{ $guest->phone ?? '—' }}</td>
                                            <td class="px-4 py-2">
                                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded 
                                                    {{ $guest->rsvp_status === 'attending' ? 'bg-green-100 text-green-800' : ($guest->rsvp_status === 'declined' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($guest->rsvp_status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 space-x-2">
                                                <a href="{{ route('guests.edit', [$wedding->id, $guest->id]) }}" class="text-indigo-600 hover:underline">Edit</a>
                                                <form action="{{ route('guests.destroy', [$wedding->id, $guest->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center py-6 text-gray-500">No guests found. <a href="{{ route('guests.create', $wedding->id) }}" class="text-indigo-600 hover:underline">Add your first guest</a>.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function showTab(tab) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.getElementById(`tab-${tab}`).classList.remove('hidden');
    }

    // Set default active tab
    document.addEventListener('DOMContentLoaded', function () {
        const defaultTab = "{{ request('tab', 'all') }}";
        showTab(defaultTab);
    });
</script>
@endsection
