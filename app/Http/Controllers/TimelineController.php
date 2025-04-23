<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Models\Timeline;
use App\Models\Task;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a list of timelines and upcoming tasks for the wedding.
     */
    public function index(Wedding $wedding)
    {
        $this->authorize('view', $wedding);

        $timelines = $wedding->timelines()->with('tasks')->get();

        // Filtering upcoming tasks for the wedding that are not completed
        $upcomingTasks = $wedding->timelines->flatMap->tasks->where('status', '!=', 'completed')
            ->where('due_date', '>=', now())
            ->sortBy('due_date');

        return view('timelines.index', compact('wedding', 'timelines', 'upcomingTasks'));
    }

    /**
     * Show the form to create a new timeline for the wedding.
     */
    public function create(Wedding $wedding)
    {
        $this->authorize('update', $wedding);
        return view('timelines.create', compact('wedding'));
    }

    /**
     * Store a new timeline for the wedding.
     */
    public function store(Request $request, Wedding $wedding)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $wedding->timelines()->create($validated);

        return redirect()->route('timelines.index', $wedding->id)
            ->with('success', 'Timeline created successfully!');
    }

    /**
     * Show the form to edit an existing timeline.
     */
    public function edit(Wedding $wedding, Timeline $timeline)
    {
        $this->authorize('update', $wedding);
        return view('timelines.edit', compact('wedding', 'timeline'));
    }

    /**
     * Update an existing timeline for the wedding.
     */
    public function update(Request $request, Wedding $wedding, Timeline $timeline)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $timeline->update($validated);

        return redirect()->route('timelines.index', $wedding->id)
            ->with('success', 'Timeline updated successfully!');
    }

    /**
     * Delete an existing timeline for the wedding.
     */
    public function destroy(Wedding $wedding, Timeline $timeline)
    {
        $this->authorize('update', $wedding);

        $timeline->delete();

        return redirect()->route('timelines.index', $wedding->id)
            ->with('success', 'Timeline removed successfully!');
    }

    /**
     * Show the form to create a task for the wedding timeline.
     */
    public function createTask(Wedding $wedding, Timeline $timeline)
    {
        $this->authorize('update', $wedding);
        return view('timelines.create-task', compact('wedding', 'timeline'));
    }

    /**
     * Store a new task in the timeline for the wedding.
     */
    public function storeTask(Request $request, Wedding $wedding, Timeline $timeline)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'nullable|string|max:255',
        ]);

        $timeline->tasks()->create($validated);

        return redirect()->route('timelines.index', $wedding->id)
            ->with('success', 'Task added successfully!');
    }

    /**
     * Show the form to edit an existing task for the wedding timeline.
     */
    public function editTask(Wedding $wedding, Timeline $timeline, Task $task)
    {
        $this->authorize('update', $wedding);
        return view('timelines.edit-task', compact('wedding', 'timeline', 'task'));
    }

    /**
     * Update an existing task for the wedding timeline.
     */
    public function updateTask(Request $request, Wedding $wedding, Timeline $timeline, Task $task)
    {
        $this->authorize('update', $wedding);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'nullable|string|max:255',
        ]);

        $task->update($validated);

        return redirect()->route('timelines.index', $wedding->id)
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Delete an existing task from the timeline.
     */
    public function destroyTask(Wedding $wedding, Timeline $timeline, Task $task)
    {
        $this->authorize('update', $wedding);

        $task->delete();

        return redirect()->route('timelines.index', $wedding->id)
            ->with('success', 'Task removed successfully!');
    }
}
