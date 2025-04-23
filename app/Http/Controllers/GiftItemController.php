<?php

namespace App\Http\Controllers;

use App\Models\GiftItem;
use App\Models\GiftRegistry;
use Illuminate\Http\Request;

class GiftItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GiftRegistry $registry)
    {
        $this->authorize('view', $registry);
        
        $giftItems = $registry->giftItems;
        
        return view('gift-items.index', compact('registry', 'giftItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(GiftRegistry $registry)
    {
        $this->authorize('update', $registry);
        return view('gift-items.create', compact('registry'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, GiftRegistry $registry)
    {
        $this->authorize('update', $registry);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'image_url' => 'nullable|url|max:255',
            'product_url' => 'nullable|url|max:255',
            'quantity_desired' => 'required|integer|min:1',
            'quantity_received' => 'nullable|integer|min:0',
            'is_purchased' => 'nullable|boolean',
            'purchased_by' => 'nullable|string|max:255',
        ]);

        // Create a new gift item in the specified registry
        $registry->giftItems()->create($validated);

        return redirect()->route('gift-items.index', $registry->id)
            ->with('success', 'Gift item added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(GiftItem $giftItem)
    {
        return view('gift-items.show', compact('giftItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GiftItem $giftItem)
    {
        $this->authorize('update', $giftItem->giftRegistry);
        return view('gift-items.edit', compact('giftItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GiftItem $giftItem)
    {
        $this->authorize('update', $giftItem->giftRegistry);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'image_url' => 'nullable|url|max:255',
            'product_url' => 'nullable|url|max:255',
            'quantity_desired' => 'required|integer|min:1',
            'quantity_received' => 'nullable|integer|min:0',
            'is_purchased' => 'nullable|boolean',
            'purchased_by' => 'nullable|string|max:255',
        ]);

        // Update the gift item details
        $giftItem->update($validated);

        return redirect()->route('gift-items.index', $giftItem->giftRegistry->id)
            ->with('success', 'Gift item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GiftItem $giftItem)
    {
        $this->authorize('update', $giftItem->giftRegistry);
        
        // Delete the gift item
        $giftItem->delete();

        return redirect()->route('gift-items.index', $giftItem->giftRegistry->id)
            ->with('success', 'Gift item removed successfully!');
    }
}
