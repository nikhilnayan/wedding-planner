@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 border-b border-gray-200 pb-6">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent mb-4 md:mb-0">{{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}'s Wedding</h1>
        <a href="{{ route('weddings.dashboard', $wedding->id) }}" class="bg-gradient-to-r from-gray-600 to-gray-800 text-white py-2.5 px-6 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium">Go to Dashboard</a>
    </div>

    <div class="bg-white shadow-xl rounded-2xl p-6 md:p-8 border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-gray-50 rounded-xl p-6 shadow-inner">
                <h2 class="text-2xl font-bold text-gray-700 mb-4">Wedding Details</h2>
                <p class="text-lg mb-2"><span class="font-semibold text-gray-700">Date:</span> <span class="text-gray-600">{{ $wedding->wedding_date->format('F j, Y') }}</span></p>
                @if ($wedding->venue)
                <p class="text-lg mb-2"><span class="font-semibold text-gray-700">Venue:</span> <span class="text-gray-600">{{ $wedding->venue }}</span></p>
                <p class="text-lg"><span class="font-semibold text-gray-700">Address:</span> <span class="text-gray-600">{{ $wedding->venue_address }}</span></p>
                @endif
            </div>
            
            <div class="bg-green-50 rounded-xl p-6 shadow-inner">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Budget Overview</h3>
                <ul class="space-y-2">
                    @foreach ($budgetCategories as $category)
                    <li class="flex justify-between items-center border-b border-green-100 pb-2">
                        <span class="font-medium text-gray-700">{{ $category->name }}:</span>
                        <span class="text-green-700 font-semibold">₹{{ number_format($category->allocated_amount, 2) }}</span>
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('budget.index', $wedding->id) }}" class="inline-block mt-5 bg-gradient-to-r from-green-500 to-green-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium">View Full Budget</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-blue-50 rounded-xl p-6 shadow-inner">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Guest List <span class="bg-blue-100 text-blue-800 ml-2 px-2.5 py-0.5 rounded-full text-sm">{{ $guests->count() }}</span></h3>
                <div class="max-h-64 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-blue-200 scrollbar-track-blue-50">
                    <ul class="space-y-2">
                        @forelse ($guests ?? [] as $guest)
                        <li class="flex items-center border-b border-blue-100 pb-2">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                            <span>{{ $guest->name }} - <span class="text-gray-500">{{ $guest->email ?? 'No email' }}</span></span>
                        </li>
                        @empty
                        <p class="text-gray-500 italic">No guests added yet.</p>
                        @endforelse
                    </ul>
                </div>
                <a href="{{ route('guests.index', $wedding->id) }}" class="inline-block mt-5 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium">View Guest List</a>
            </div>
            
            <div class="bg-purple-50 rounded-xl p-6 shadow-inner">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Vendors</h3>
                <div class="max-h-64 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-purple-200 scrollbar-track-purple-50">
                    <ul class="space-y-2">
                        @forelse ($vendors as $vendor)
                        <li class="flex items-center border-b border-purple-100 pb-2">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                            <span>{{ $vendor->name }} - <span class="text-gray-500">{{ $vendor->service_type }}</span></span>
                        </li>
                        @empty
                        <p class="text-gray-500 italic">No vendors added yet.</p>
                        @endforelse
                    </ul>
                </div>
                <a href="{{ route('vendors.index', $wedding->id) }}" class="inline-block mt-5 bg-gradient-to-r from-purple-500 to-purple-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium">View Vendors List</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-yellow-50 rounded-xl p-6 shadow-inner">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Timeline & Tasks</h3>
                <div class="max-h-64 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-yellow-200 scrollbar-track-yellow-50">
                    @forelse ($timelines as $timeline)
                    <div class="mb-4">
                        <h5 class="text-lg font-bold text-yellow-700 mb-2">{{ $timeline->title }}</h5>
                        <ul class="space-y-2 pl-6">
                            @foreach ($timeline->tasks as $task)
                            <li class="flex items-start border-b border-yellow-100 pb-2">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2 mt-2"></span>
                                <div>
                                    <span class="font-medium">{{ $task->title }}</span>
                                    <div class="text-sm text-gray-500">
                                        Due: {{ \Carbon\Carbon::parse($task->due_date)->format('F j, Y') }}
                                        <span class="ml-1 inline-block px-2 py-0.5 rounded-full text-xs 
                                            {{ $task->priority == 'high' ? 'bg-red-100 text-red-800' : 
                                               ($task->priority == 'medium' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @empty
                    <p class="text-gray-500 italic">No timeline yet.</p>
                    @endforelse
                </div>
            </div>
            
            <div class="bg-red-50 rounded-xl p-6 shadow-inner">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Gift Registry</h3>
                <div class="max-h-64 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-red-200 scrollbar-track-red-50">
                    <ul class="space-y-2">
                        @forelse ($giftRegistries as $gift)
                        <li class="flex justify-between items-center border-b border-red-100 pb-2">
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                {{ $gift->name }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs 
                                {{ $gift->status == 'purchased' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($gift->status) }}
                            </span>
                        </li>
                        @empty
                        <p class="text-gray-500 italic">No gifts registered yet.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('weddings.edit', $wedding) }}" class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white px-6 py-3 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium text-center">Edit Wedding</a>
            <form action="{{ route('weddings.destroy', $wedding) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this wedding?')" class="sm:inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-3 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-medium">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection