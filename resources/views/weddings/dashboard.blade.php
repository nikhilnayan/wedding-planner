@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="flex flex-col md:flex-row justify-between mb-4">
        <div class="w-full md:w-2/3 mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800">{{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}</h1>
            <h4 class="text-xl text-gray-600">Wedding Date: {{ \Carbon\Carbon::parse($wedding->wedding_date)->format('F j, Y') }}</h4>
            <p class="text-gray-500">Days Until Wedding: {{ \Carbon\Carbon::parse($wedding->wedding_date)->diffInDays(now()) }}</p>
        </div>
        <div class="w-full md:w-1/3 text-center md:text-right">
            <div class="space-x-4">
                <a href="{{ route('weddings.show', $wedding->id) }}" class="inline-block bg-blue-500 text-white px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">Details</a>
                <a href="{{ route('weddings.edit', $wedding->id) }}" class="inline-block bg-gray-500 text-white px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">Edit</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <!-- Guest List Card -->
        <div class="bg-white rounded-xl shadow-lg">
            <div class="bg-blue-500 text-white p-4 rounded-t-xl">
                <h5 class="text-lg font-semibold">Guest List</h5>
            </div>
            <div class="p-6">
                <h3 class="text-2xl text-center font-semibold">{{ $guests->count() }}</h3>
                <p class="text-center text-gray-600">Total Guests</p>
                <div class="mt-4 text-center">
                    <a href="{{ route('guests.index', $wedding->id) }}" class="inline-block bg-blue-500 text-white py-2 px-6 rounded-lg shadow-md hover:bg-blue-600 transition-all duration-300">Manage Guests</a>
                </div>
            </div>
        </div>

        <!-- Budget Card -->
        <div class="bg-white rounded-xl shadow-lg">
            <div class="bg-green-500 text-white p-4 rounded-t-xl">
                <h5 class="text-lg font-semibold">Budget</h5>
            </div>
            <div class="p-6">
                <h3 class="text-2xl text-center font-semibold">₹{{ number_format($budgetSummary['total'], 2) }}</h3>
                <p class="text-center text-gray-600">Total Budget</p>
                <div class="progress-bar h-2 bg-gray-200 mt-4 rounded-full">
                    @php
                    $percentage = $budgetSummary['total'] > 0 ? ($budgetSummary['spent'] / $budgetSummary['total']) * 100 : 0;
                    @endphp
                    <div class="bg-green-500 rounded-full" style="width: {{ min($percentage, 100) }}%;"></div>
                </div>
                <p class="text-center mt-2 text-gray-600">
                    ₹{{ number_format($budgetSummary['spent'], 2) }} spent
                    <br>
                    ₹{{ number_format($budgetSummary['remaining'], 2) }} remaining
                </p>
                <div class="mt-4 text-center">
                    <a href="{{ route('budget.index', $wedding->id) }}" class="inline-block bg-green-500 text-white py-2 px-6 rounded-lg shadow-md hover:bg-green-600 transition-all duration-300">Manage Budget</a>
                </div>
            </div>
        </div>

        <!-- Vendors Card -->
        <div class="bg-white rounded-xl shadow-lg">
            <div class="bg-teal-500 text-white p-4 rounded-t-xl">
                <h5 class="text-lg font-semibold">Vendors</h5>
            </div>
            <div class="p-6">
                <h3 class="text-2xl text-center font-semibold">{{ $wedding->vendors->count() }}</h3>
                <p class="text-center text-gray-600">Total Vendors</p>
                <div class="mt-4 text-center">
                    <a href="{{ route('vendors.index', $wedding->id) }}" class="inline-block bg-teal-500 text-white py-2 px-6 rounded-lg shadow-md hover:bg-teal-600 transition-all duration-300">Manage Vendors</a>
                </div>
            </div>
        </div>

        <!-- Registry Card -->
        <div class="bg-white rounded-xl shadow-lg">
            <div class="bg-yellow-500 text-white p-4 rounded-t-xl">
                <h5 class="text-lg font-semibold">Registry</h5>
            </div>
            <div class="p-6">
                <h3 class="text-2xl text-center font-semibold">{{ $wedding->giftRegistries->count() }}</h3>
                <p class="text-center text-gray-600">Gift Registries</p>
                <div class="mt-4 text-center">
                    <a href="{{ route('gift-registries.index', $wedding->id) }}" class="inline-block bg-yellow-500 text-white py-2 px-6 rounded-lg shadow-md hover:bg-yellow-600 transition-all duration-300">Manage Registry</a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Upcoming Tasks Card -->
        <div class="bg-white rounded-xl shadow-lg">
            <div class="bg-red-500 text-white p-4 rounded-t-xl">
                <h5 class="text-lg font-semibold">Upcoming Tasks</h5>
            </div>
            <div class="p-6">
                @if($upcomingTasks->count() > 0)
                <ul class="space-y-4">
                    @foreach($upcomingTasks as $task)
                    <li class="flex justify-between items-center">
                        <div>
                            <span class="badge {{ $task->priority === 'high' ? 'bg-red-500' : ($task->priority === 'medium' ? 'bg-yellow-500' : 'bg-blue-500') }} text-white p-1 rounded-md mr-2">{{ ucfirst($task->priority) }}</span>
                            {{ $task->title }}
                        </div>
                        <small class="text-gray-500">{{ \Carbon\Carbon::parse($task->due_date)->format('M j') }}</small>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-center text-gray-600">No upcoming tasks.</p>
                @endif
                <div class="mt-4 text-center">
                    <a href="{{ route('timelines.index', $wedding->id) }}" class="inline-block bg-red-500 text-white py-2 px-6 rounded-lg shadow-md hover:bg-red-600 transition-all duration-300">View All Tasks</a>
                </div>
            </div>
        </div>

        <!-- Quick Links Card -->
        <div class="bg-white rounded-xl shadow-lg">
            <div class="bg-gray-700 text-white p-4 rounded-t-xl">
                <h5 class="text-lg font-semibold">Quick Links</h5>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('guests.create', $wedding->id) }}" class="inline-block bg-blue-500 text-white py-2 px-6 rounded-lg shadow-md hover:bg-blue-600 transition-all duration-300">Add Guest</a>
                    <a href="{{ route('vendors.create', $wedding->id) }}" class="inline-block bg-teal-500 text-white py-2 px-6 rounded-lg shadow-md hover:bg-teal-600 transition-all duration-300">Add Vendor</a>
                    <a href="{{ route('timelines.create-task', [$wedding->id, $wedding->timelines->first()->id]) }}" class="inline-block bg-red-500 text-white py-2 px-6 rounded-lg shadow-md hover:bg-red-600 transition-all duration-300">Add Task</a>
                    <a href="{{ route('budget.create-item', [$wedding->id, $wedding->budgetCategories->first()->id]) }}" class="inline-block bg-green-500 text-white py-2 px-6 rounded-lg shadow-md hover:bg-green-600 transition-all duration-300">Add Budget Item</a>
                    <a href="{{ route('gift-registries.create', $wedding->id) }}" class="inline-block bg-yellow-500 text-white py-2 px-6 rounded-lg shadow-md hover:bg-yellow-600 transition-all duration-300">Add Registry</a>
                    <a href="{{ route('guests.import', $wedding->id) }}" class="inline-block bg-gray-500 text-white py-2 px-6 rounded-lg shadow-md hover:bg-gray-600 transition-all duration-300">Import Guests</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection