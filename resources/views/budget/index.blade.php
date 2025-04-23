@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-3xl font-semibold">Budget Management</h1>
            <p class="text-gray-600">Wedding: 
                <a href="{{ route('weddings.dashboard', $wedding->id) }}" class="text-blue-600 hover:underline">
                    {{ $wedding->partner1_name }} & {{ $wedding->partner2_name }}
                </a>
            </p>
        </div>
        <a href="{{ route('budget.create-category', $wedding->id) }}" class="mt-4 md:mt-0 inline-block bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700 transition">
            Add Category
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @foreach (['Total Budget' => 'total', 'Allocated Budget' => 'allocated', 'Spent' => 'spent', 'Remaining' => 'remaining'] as $label => $key)
        <div class="bg-white shadow rounded-lg p-4 text-center">
            <h3 class="text-2xl font-bold text-gray-800">₹{{ number_format($budgetSummary[$key], 2) }}</h3>
            <p class="text-sm text-gray-500">{{ $label }}</p>
        </div>
        @endforeach
    </div>

    @php
    $totalBudget = $budgetSummary['total'] > 0 ? $budgetSummary['total'] : 1;
    $spentPercentage = min(($budgetSummary['spent'] / $totalBudget) * 100, 100);
    @endphp

    <div class="w-full bg-gray-200 h-8 rounded-full overflow-hidden mb-6">
        <div class="h-full text-white text-sm flex items-center justify-center 
            {{ $spentPercentage > 90 ? 'bg-red-600' : 'bg-green-500' }}"
            style="width: {{ $spentPercentage }}%">
            {{ number_format($spentPercentage, 1) }}% of Budget
        </div>
    </div>

    @if($categories->count() > 0)
    <div class="space-y-4">
        @foreach($categories as $category)
        <div class="border border-gray-200 rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-4 py-3 flex justify-between items-center cursor-pointer"
                x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }"
                @click="open = !open">
                <div class="font-semibold">{{ $category->name }}</div>
                <div class="text-sm text-gray-600">₹{{ number_format($category->allocated_amount, 2) }}</div>
            </div>

            <div x-show="open" class="p-4 bg-white">
                @php
                $totalSpent = $category->budgetItems->sum('actual_cost');
                $allocatedAmount = $category->allocated_amount;
                $remaining = $allocatedAmount - $totalSpent;
                $percentage = $allocatedAmount > 0 ? ($totalSpent / $allocatedAmount) * 100 : 0;
                @endphp

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-2">
                    <p>
                        <strong>Allocated:</strong> ₹{{ number_format($allocatedAmount, 2) }} |
                        <strong>Spent:</strong> ₹{{ number_format($totalSpent, 2) }} |
                        <strong>Remaining:</strong> ₹{{ number_format($remaining, 2) }}
                    </p>
                    <div class="flex gap-2">
                        <a href="{{ route('budget.edit-category', [$wedding->id, $category->id]) }}" class="btn btn-sm border px-3 py-1 rounded text-blue-600 border-blue-600 hover:bg-blue-50">
                            Edit
                        </a>
                        <a href="{{ route('budget.create-item', [$wedding->id, $category->id]) }}" class="btn btn-sm border px-3 py-1 rounded text-green-600 border-green-600 hover:bg-green-50">
                            Add Item
                        </a>
                        <button data-bs-toggle="modal" data-bs-target="#deleteCategoryModal{{ $category->id }}" class="btn btn-sm border px-3 py-1 rounded text-red-600 border-red-600 hover:bg-red-50">
                            Delete
                        </button>
                    </div>
                </div>

                <div class="w-full bg-gray-200 h-2 rounded mb-4">
                    <div class="h-full rounded {{ $percentage > 100 ? 'bg-red-600' : 'bg-green-500' }}" style="width: {{ min($percentage, 100) }}%"></div>
                </div>

                @if($category->budgetItems->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto text-sm text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600">
                                <th class="px-4 py-2 font-medium">Item</th>
                                <th class="px-4 py-2 font-medium">Estimated Cost</th>
                                <th class="px-4 py-2 font-medium">Actual Cost</th>
                                <th class="px-4 py-2 font-medium">Paid</th>
                                <th class="px-4 py-2 font-medium">Payment Date</th>
                                <th class="px-4 py-2 font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($category->budgetItems as $item)
                            <tr>
                                <td class="px-4 py-2">{{ $item->name }}</td>
                                <td class="px-4 py-2">₹{{ number_format($item->estimated_cost, 2) }}</td>
                                <td class="px-4 py-2">₹{{ number_format($item->actual_cost ?? 0, 2) }}</td>
                                <td class="px-4 py-2">
                                    @if($item->is_paid)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                    @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $item->payment_date ? \Carbon\Carbon::parse($item->payment_date)->format('M j, Y') : '—' }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex gap-2">
                                        <a href="{{ route('budget.edit-item', [$wedding->id, $category->id, $item->id]) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <button data-bs-toggle="modal" data-bs-target="#deleteItemModal{{ $item->id }}" class="text-red-600 hover:underline">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center text-gray-500">No budget items. 
                    <a href="{{ route('budget.create-item', [$wedding->id, $category->id]) }}" class="text-blue-600 hover:underline">Add your first item</a>.
                </p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white shadow rounded-lg p-8 text-center">
        <h3 class="text-xl font-semibold mb-2">No budget categories found</h3>
        <p class="text-gray-500 mb-4">Set up your wedding budget by creating categories and allocating funds.</p>
        <a href="{{ route('budget.create-category', $wedding->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
            Add Your First Category
        </a>
    </div>
    @endif
</div>
@endsection
