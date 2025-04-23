<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Models\GiftRegistry;
use App\Models\GiftItem;
use Illuminate\Http\Request;

class GiftRegistryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Wedding $wedding)
    {
        $this->authorize('view', $wedding);

        // Fetch the gift registries for the wedding
        $registries = $wedding->giftRegistries()->with('giftItems')->get();

        // Pass the registries variable to the view
        return view('gift-registries.index', compact('wedding', 'registries'));
    }


    public function create(Wedding $wedding)
    {
        $this->authorize('update', $wedding);
        return view('gift-registries.create', compact('wedding'));
    }

    public function store(Request $request, Wedding $wedding)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'store_name' => 'nullable|string|max:255',
            'store_url' => 'nullable|url|max:255',
        ]);

        $wedding->giftRegistries()->create($validated);

        return redirect()->route('gift-registries.index', $wedding->id)
            ->with('success', 'Gift registry created successfully!');
    }

    public function edit(Wedding $wedding, GiftRegistry $registry)
    {
        $this->authorize('update', $wedding);
        return view('gift-registries.edit', compact('wedding', 'registry'));
    }

    public function update(Request $request, Wedding $wedding, GiftRegistry $registry)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'store_name' => 'nullable|string|max:255',
            'store_url' => 'nullable|url|max:255',
        ]);

        $registry->update($validated);

        return redirect()->route('gift-registries.index', $wedding->id)
            ->with('success', 'Gift registry updated successfully!');
    }

    public function destroy(Wedding $wedding, GiftRegistry $registry)
    {
        $this->authorize('update', $wedding);

        $registry->delete();

        return redirect()->route('gift-registries.index', $wedding->id)
            ->with('success', 'Gift registry removed successfully!');
    }

    public function createItem(Wedding $wedding, GiftRegistry $registry)
    {
        $this->authorize('update', $wedding);
        return view('gift-registries.create-item', compact('wedding', 'registry'));
    }

    public function storeItem(Request $request, Wedding $wedding, GiftRegistry $registry)
    {
        $this->authorize('update', $wedding);

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

        $registry->giftItems()->create($validated);

        return redirect()->route('gift-registries.index', $wedding->id)
            ->with('success', 'Gift item added successfully!');
    }

    public function editItem(Wedding $wedding, GiftRegistry $registry, GiftItem $item)
    {
        $this->authorize('update', $wedding);
        return view('gift-registries.edit-item', compact('wedding', 'registry', 'item'));
    }

    public function updateItem(Request $request, Wedding $wedding, GiftRegistry $registry, GiftItem $item)
    {
        $this->authorize('update', $wedding);

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

        $item->update($validated);

        return redirect()->route('gift-registries.index', $wedding->id)
            ->with('success', 'Gift item updated successfully!');
    }

    public function destroyItem(Wedding $wedding, GiftRegistry $registry, GiftItem $item)
    {
        $this->authorize('update', $wedding);

        $item->delete();

        return redirect()->route('gift-registries.index', $wedding->id)
            ->with('success', 'Gift item removed successfully!');
    }
}
