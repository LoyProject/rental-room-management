<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $query = Site::query();

        if (request('search')) {
            $searchTerm = '%' . request('search') . '%';
            $query->where('name', 'like', $searchTerm)
                ->orWhere('phone', 'like', $searchTerm)
                ->orWhere('address', 'like', $searchTerm);
        }

        $sites = $query->latest()->paginate(10)->withQueryString();

        return view('sites.index', compact('sites'));
    }

    public function create()
    {
        return view('sites.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'from_date' => 'required|string',
            'to_date' => 'required|string',
        ]);

        if ($request->from_date && $request->to_date) {
            $validated['from_date'] = Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d');
            $validated['to_date'] = Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d');
        }

        Site::create($validated);

        return redirect()->route('sites.index')->with('success', 'Site created successfully.');
    }

    public function edit(Site $site)
    {
        return view('sites.edit', compact('site'));
    }

    public function update(Request $request, Site $site)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'from_date' => 'required|string',
            'to_date' => 'required|string',
        ]);

        if ($request->from_date && $request->to_date) {
            $validated['from_date'] = Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d');
            $validated['to_date'] = Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d');
        }

        $site->update($validated);

        return redirect()->route('sites.index')->with('success', 'Site updated successfully.');
    }


    public function destroy(Site $site)
    {
        $site->delete();
        return redirect()->route('sites.index')->with('success', 'Site deleted successfully.');
    }
}
