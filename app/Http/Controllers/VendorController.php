<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Wedding;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a list of vendors for the specified wedding.
     */
    public function index(Wedding $wedding)
    {
        $this->authorize('view', $wedding);

        $vendors = $wedding->vendors;
        $vendorsByCategory = $vendors->groupBy('category');

        return view('vendors.index', compact('wedding', 'vendors', 'vendorsByCategory'));
    }

    /**
     * Show the form to create a new vendor.
     */
    public function create(Wedding $wedding)
    {
        $this->authorize('update', $wedding);

        $categories = [
            'Venue',
            'Catering',
            'Photography',
            'Videography',
            'Florist',
            'DJ/Band',
            'Cake',
            'Officiant',
            'Transportation',
            'Rentals',
            'Decor',
            'Hair & Makeup',
            'Wedding Planner',
            'Other'
        ];

        return view('vendors.create', compact('wedding', 'categories'));
    }

    /**
     * Store a new vendor for the wedding.
     */
    public function store(Request $request, Wedding $wedding)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'cost' => 'nullable|numeric|min:0',
            'deposit_amount' => 'nullable|numeric|min:0',
            'deposit_due_date' => 'nullable|date',
            'payment_due_date' => 'nullable|date',
            'is_booked' => 'nullable|boolean',
            'is_paid' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_booked'] = $request->has('is_booked'); // Will be true if checked, false otherwise
        $validated['is_paid'] = $request->has('is_paid');

        $wedding->vendors()->create($validated);

        return redirect()->route('vendors.index', $wedding->id)
            ->with('success', 'Vendor added successfully!');
    }

    /**
     * Show the details of a specific vendor.
     */
    public function show(Wedding $wedding, Vendor $vendor)
    {
        $this->authorize('view', $wedding);
        return view('vendors.show', compact('wedding', 'vendor'));
    }

    /**
     * Show the form to edit an existing vendor.
     */
    public function edit(Wedding $wedding, Vendor $vendor)
    {
        $this->authorize('update', $wedding);

        $categories = [
            'Venue',
            'Catering',
            'Photography',
            'Videography',
            'Florist',
            'DJ/Band',
            'Cake',
            'Officiant',
            'Transportation',
            'Rentals',
            'Decor',
            'Hair & Makeup',
            'Wedding Planner',
            'Other'
        ];

        return view('vendors.edit', compact('wedding', 'vendor', 'categories'));
    }

    /**
     * Update an existing vendor.
     */
    public function update(Request $request, Wedding $wedding, Vendor $vendor)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'cost' => 'nullable|numeric|min:0',
            'deposit_amount' => 'nullable|numeric|min:0',
            'deposit_due_date' => 'nullable|date',
            'payment_due_date' => 'nullable|date',
            'is_booked' => 'nullable|boolean',
            'is_paid' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        $vendor->update($validated);

        return redirect()->route('vendors.index', $wedding->id)
            ->with('success', 'Vendor updated successfully!');
    }

    /**
     * Delete a vendor from the wedding.
     */
    public function destroy(Wedding $wedding, Vendor $vendor)
    {
        $this->authorize('update', $wedding);

        $vendor->delete();

        return redirect()->route('vendors.index', $wedding->id)
            ->with('success', 'Vendor removed successfully!');
    }
}
