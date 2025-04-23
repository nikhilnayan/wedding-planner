<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Models\BudgetCategory;
use App\Models\BudgetItem;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Wedding $wedding)
    {
        $this->authorize('view', $wedding);

        $categories = $wedding->budgetCategories()->with('budgetItems')->get();

        $budgetSummary = [
            'total' => $wedding->budget_total,
            'allocated' => $categories->sum('allocated_amount'),
            'spent' => $categories->flatMap->budgetItems->sum('actual_cost'),
            'remaining' => $wedding->budget_total - $categories->flatMap->budgetItems->sum('actual_cost')
        ];

        return view('budget.index', compact('wedding', 'categories', 'budgetSummary'));
    }

    public function createCategory(Wedding $wedding)
    {
        $this->authorize('update', $wedding);
        return view('budget.create-category', compact('wedding'));
    }

    public function storeCategory(Request $request, Wedding $wedding)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'allocated_amount' => 'required|numeric|min:0',
        ]);

        $wedding->budgetCategories()->create($validated);

        return redirect()->route('budget.index', $wedding->id)
            ->with('success', 'Budget category added successfully!');
    }

    public function editCategory(Wedding $wedding, BudgetCategory $category)
    {
        $this->authorize('update', $wedding);
        return view('budget.edit-category', compact('wedding', 'category'));
    }

    public function updateCategory(Request $request, Wedding $wedding, BudgetCategory $category)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'allocated_amount' => 'required|numeric|min:0',
        ]);

        $category->update($validated);

        return redirect()->route('budget.index', $wedding->id)
            ->with('success', 'Budget category updated successfully!');
    }

    public function destroyCategory(Wedding $wedding, BudgetCategory $category)
    {
        $this->authorize('update', $wedding);

        $category->delete();

        return redirect()->route('budget.index', $wedding->id)
            ->with('success', 'Budget category removed successfully!');
    }

    public function createItem(Wedding $wedding, BudgetCategory $category)
    {
        $this->authorize('update', $wedding);
        return view('budget.create-item', compact('wedding', 'category'));
    }

    public function storeItem(Request $request, Wedding $wedding, BudgetCategory $category)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'estimated_cost' => 'required|numeric|min:0',
            'actual_cost' => 'nullable|numeric|min:0',
            'is_paid' => 'nullable|boolean',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $category->budgetItems()->create($validated);

        return redirect()->route('budget.index', $wedding->id)
            ->with('success', 'Budget item added successfully!');
    }

    public function editItem(Wedding $wedding, BudgetCategory $category, BudgetItem $item)
    {
        $this->authorize('update', $wedding);
        return view('budget.edit-item', compact('wedding', 'category', 'item'));
    }

    public function updateItem(Request $request, Wedding $wedding, BudgetCategory $category, BudgetItem $item)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'estimated_cost' => 'required|numeric|min:0',
            'actual_cost' => 'nullable|numeric|min:0',
            'is_paid' => 'nullable|boolean',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $item->update($validated);

        return redirect()->route('budget.index', $wedding->id)->with('success', 'Budget item updated successfully!');
    }
    public function destroyItem(Wedding $wedding, BudgetCategory $category, BudgetItem $item)
    {
        $this->authorize('update', $wedding);

        $item->delete();

        return redirect()->route('budget.index', $wedding->id)
            ->with('success', 'Budget item removed successfully!');
    }
}
