<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Models\BudgetCategory;
use Illuminate\Http\Request;

class BudgetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Wedding $wedding)
    {
        $this->authorize('view', $wedding);

        $categories = $wedding->budgetCategories()->get();

        return view('budget-categories.index', compact('wedding', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Wedding $wedding)
    {
        $this->authorize('update', $wedding);
        return view('budget-categories.create', compact('wedding'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Wedding $wedding)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'allocated_amount' => 'required|numeric|min:0',
        ]);

        $wedding->budgetCategories()->create($validated);

        return redirect()->route('budget.index', $wedding->id)
            ->with('success', 'Budget category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wedding $wedding, BudgetCategory $budgetCategory)
    {
        $this->authorize('view', $wedding);

        return view('budget-categories.show', compact('wedding', 'budgetCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wedding $wedding, BudgetCategory $budgetCategory)
    {
        $this->authorize('update', $wedding);

        return view('budget-categories.edit', compact('wedding', 'budgetCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wedding $wedding, BudgetCategory $budgetCategory)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'allocated_amount' => 'required|numeric|min:0',
        ]);

        $budgetCategory->update($validated);

        return redirect()->route('budget.index', $wedding->id)
            ->with('success', 'Budget category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wedding $wedding, BudgetCategory $budgetCategory)
    {
        $this->authorize('update', $wedding);

        $budgetCategory->delete();

        return redirect()->route('budget.index', $wedding->id)
            ->with('success', 'Budget category deleted successfully!');
    }
}
