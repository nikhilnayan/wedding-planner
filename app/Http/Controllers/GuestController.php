<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Wedding;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Wedding $wedding)
    {
        $this->authorize('view', $wedding);
        
        // $guests = $wedding->guests;
        $guests = $wedding->guests()->distinct()->get();

        $guestStats = [
            'invited' => $guests->count(),
            'attending' => $guests->where('rsvp_status', 'attending')->count(),
            'declined' => $guests->where('rsvp_status', 'declined')->count(),
            'pending' => $guests->where('rsvp_status', 'pending')->count(),
            'total_attending' => $guests->where('rsvp_status', 'attending')->sum('party_size')
        ];
        
        return view('guests.index', compact('wedding', 'guests', 'guestStats'));
    }

    public function create(Wedding $wedding)
    {
        $this->authorize('update', $wedding);
        return view('guests.create', compact('wedding'));
    }

    public function store(Request $request, Wedding $wedding)
    {
        $this->authorize('update', $wedding);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'relationship' => 'nullable|string|max:255',
            'party_size' => 'required|integer|min:1',
            'rsvp_status' => 'required|in:pending,attending,declined',
            'invitation_sent' => 'nullable|boolean',
            'dietary_restrictions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $wedding->guests()->create($validated);

        return redirect()->route('guests.index', $wedding->id)
            ->with('success', 'Guest added successfully!');
    }

    public function edit(Wedding $wedding, Guest $guest)
    {
        $this->authorize('update', $wedding);
        return view('guests.edit', compact('wedding', 'guest'));
    }

    public function update(Request $request, Wedding $wedding, Guest $guest)
    {
        $this->authorize('update', $wedding);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'relationship' => 'nullable|string|max:255',
            'party_size' => 'required|integer|min:1',
            'rsvp_status' => 'required|in:pending,attending,declined',
            'invitation_sent' => 'nullable|boolean',
            'dietary_restrictions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $guest->update($validated);

        return redirect()->route('guests.index', $wedding->id)
            ->with('success', 'Guest updated successfully!');
    }

    public function destroy(Wedding $wedding, Guest $guest)
    {
        $this->authorize('update', $wedding);
        
        $guest->delete();

        return redirect()->route('guests.index', $wedding->id)
            ->with('success', 'Guest removed successfully!');
    }

    public function import(Wedding $wedding)
    {
        $this->authorize('update', $wedding);
        return view('guests.import', compact('wedding'));
    }

    public function processImport(Request $request, Wedding $wedding)
    {
        $this->authorize('update', $wedding);
        
        $request->validate([
            'guests_csv' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('guests_csv');
        $path = $file->getRealPath();
        $file = fopen($path, 'r');
        
        // Skip header row
        fgetcsv($file);
        
        $importCount = 0;
        
        while (($row = fgetcsv($file)) !== false) {
            // Assuming CSV columns: name, email, phone, relationship, party_size
            if (count($row) >= 1) {
                $guest = [
                    'name' => $row[0],
                    'email' => $row[1] ?? null,
                    'phone' => $row[2] ?? null,
                    'relationship' => $row[3] ?? null,
                    'party_size' => $row[4] ?? 1,
                    'rsvp_status' => 'pending',
                ];
                
                $wedding->guests()->create($guest);
                $importCount++;
            }
        }
        
        fclose($file);
        
        return redirect()->route('guests.index', $wedding->id)
            ->with('success', $importCount . ' guests imported successfully!');
    }
}