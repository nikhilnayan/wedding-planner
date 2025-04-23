@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <div class="text-2xl font-semibold">
            <h1>Weddings</h1>
        </div>
        <div class="text-right">
            <a href="{{ route('weddings.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-all duration-300">Create Wedding</a>
        </div>
    </div>

    @if($weddings->count() > 0)
    <div class="space-y-4">
        @foreach($weddings as $wedding)
        <div class="p-4 border border-gray-200 rounded-lg shadow-md">
            <a href="{{ route('weddings.show', $wedding->id) }}" class="block hover:bg-gray-100 transition-all duration-300">
                <h5 class="text-xl font-bold text-gray-800">{{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}</h5>
                <p class="text-gray-600">{{ $wedding->wedding_date ? \Carbon\Carbon::parse($wedding->wedding_date)->format('M j, Y') : 'No date set' }}</p>
            </a>

            <div class="flex space-x-2 mt-4">
                <a href="{{ route('weddings.dashboard', $wedding->id) }}" class="bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-all duration-300">Go to Dashboard</a>

                <form action="{{ route('weddings.destroy', $wedding) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition-all duration-300">Delete Wedding</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    @else
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mt-4 rounded-lg shadow-md">
        No weddings found. Please create a new wedding.
    </div>
    @endif
</div>
@endsection
