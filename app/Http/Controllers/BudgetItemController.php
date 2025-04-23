<?php

namespace App\Http\Controllers;

use App\Models\BudgetItem;
use Illuminate\Http\Request;

class BudgetItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all budget items
        $budgetItems = BudgetItem::all();

        // Return a view with the budget items
        return view('budget-items.index', compact('budgetItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a view with the form to create a new budget item
        return view('budget-items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create a new budget item with validated data
        BudgetItem::create($validated);

        // Redirect to the index page with a success message
        return redirect()->route('budget-items.index')
            ->with('success', 'Budget item created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BudgetItem $budgetItem)
    {
        // Show a single budget item
        return view('budget-items.show', compact('budgetItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BudgetItem $budgetItem)
    {
        // Return a view with the form to edit the budget item
        return view('budget-items.edit', compact('budgetItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BudgetItem $budgetItem)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update the budget item with validated data
        $budgetItem->update($validated);

        // Redirect to the index page with a success message
        return redirect()->route('budget-items.index')
            ->with('success', 'Budget item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BudgetItem $budgetItem)
    {
        // Delete the budget item
        $budgetItem->delete();

        // Redirect to the index page with a success message
        return redirect()->route('budget-items.index')
            ->with('success', 'Budget item deleted successfully!');
    }
}
