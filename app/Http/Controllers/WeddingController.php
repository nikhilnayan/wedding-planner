<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeddingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a list of weddings.
     */
    public function index()
    {
        $weddings = Auth::user()->weddings;
        return view('weddings.index', compact('weddings'));
    }

    /**
     * Show the form to create a new wedding.
     */
    public function create()
    {
        return view('weddings.create');
    }

    /**
     * Store a new wedding.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'partner1_name' => 'required|string|max:255',
            'partner2_name' => 'required|string|max:255',
            'wedding_date' => 'required|date',
            'venue' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string|max:255',
            'guest_count' => 'nullable|integer|min:0',
            'budget_total' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Add the authenticated user's ID to the validated data
        $validated['user_id'] = auth::id();  // Automatically get the currently authenticated user's ID

        // Create a new wedding with the validated data, including user_id
        $wedding = Wedding::create($validated);

        // Create default budget categories
        $defaultCategories = [
            'Venue' => 40,
            'Catering' => 15,
            'Photography' => 10,
            'Attire' => 8,
            'Decorations' => 7,
            'Music' => 5,
            'Flowers' => 5,
            'Invitations' => 2,
            'Miscellaneous' => 8
        ];

        foreach ($defaultCategories as $category => $percentage) {
            $wedding->budgetCategories()->create([
                'name' => $category,
                'allocated_amount' => $wedding->budget_total * ($percentage / 100),
            ]);
        }

        // Create default timeline
        $timeline = $wedding->timelines()->create([
            'title' => 'Wedding Timeline'
        ]);

        // Create common tasks
        $commonTasks = [
            ['title' => 'Set wedding date', 'due_date' => now()->addDays(7), 'priority' => 'high'],
            ['title' => 'Book venue', 'due_date' => now()->addDays(30), 'priority' => 'high'],
            ['title' => 'Create guest list', 'due_date' => now()->addDays(45), 'priority' => 'medium'],
            ['title' => 'Send save-the-dates', 'due_date' => now()->addDays(60), 'priority' => 'medium'],
            ['title' => 'Book photographer', 'due_date' => now()->addDays(90), 'priority' => 'medium'],
            ['title' => 'Book caterer', 'due_date' => now()->addDays(90), 'priority' => 'medium'],
            ['title' => 'Shop for attire', 'due_date' => now()->addDays(120), 'priority' => 'medium'],
            ['title' => 'Send invitations', 'due_date' => now()->addDays(180), 'priority' => 'high'],
        ];

        foreach ($commonTasks as $task) {
            $timeline->tasks()->create($task);
        }

        \Log::info('New Wedding ID: ' . $wedding->id); // Check the logs for the ID
        return redirect()->route('weddings.show', $wedding->id)
            ->with('success', 'Wedding created successfully!');
    }

    /**
     * Show a specific wedding.
     */
    public function show(Wedding $wedding)
    {
        $this->authorize('view', $wedding);

        $guests = $wedding->guests;
        $vendors = $wedding->vendors;
        $budgetCategories = $wedding->budgetCategories;
        $timelines = $wedding->timelines;
        $giftRegistries = $wedding->giftRegistries;

        return view('weddings.show', compact(
            'wedding',
            'guests',
            'vendors',
            'budgetCategories',
            'timelines',
            'giftRegistries'
        ));
    }

    /**
     * Show the form to edit an existing wedding.
     */
    public function edit(Wedding $wedding)
    {
        $this->authorize('update', $wedding);
        return view('weddings.edit', compact('wedding'));
    }

    /**
     * Update a wedding.
     */
    public function update(Request $request, Wedding $wedding)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'partner1_name' => 'required|string|max:255',
            'partner2_name' => 'required|string|max:255',
            'wedding_date' => 'required|date',
            'venue' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string|max:255',
            'guest_count' => 'nullable|integer|min:0',
            'budget_total' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $wedding->update($validated);

        return redirect()->route('weddings.show', $wedding->id)
            ->with('success', 'Wedding updated successfully!');
    }

    /**
     * Delete a wedding.
     */
    public function destroy(Wedding $wedding)
    {
        $this->authorize('delete', $wedding);

        $wedding->delete();

        return redirect()->route('weddings.index')
            ->with('success', 'Wedding deleted successfully!');
    }

    /**
     * Display the wedding dashboard with overview data.
     */
    public function dashboard(Wedding $wedding)
    {
        $this->authorize('view', $wedding);

        $guests = $wedding->guests;
        $pendingTasks = $wedding->timelines->flatMap->tasks->where('status', '!=', 'completed');
        $upcomingTasks = $pendingTasks->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(30))
            ->sortBy('due_date')
            ->take(5);

        $budgetSummary = [
            'total' => $wedding->budget_total,
            'spent' => $wedding->budgetCategories->flatMap->budgetItems->sum('actual_cost'),
            'remaining' => $wedding->budget_total - $wedding->budgetCategories->flatMap->budgetItems->sum('actual_cost')
        ];

        return view('weddings.dashboard', compact(
            'wedding',
            'guests',
            'upcomingTasks',
            'budgetSummary'
        ));
    }
}
