<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Block::query();

        if (request()->filled('site')) {
            if (!$user->isAdmin()) {
                abort(404, 'Not Found');
            }

            $query->where('site_id', request('site'));
        } else {
            if (!$user->isAdmin()) {
                $query->where('site_id', $user->site_id);
            }
        }

        if (request()->filled('search')) {
            $search = '%' . request('search') . '%';
            $numeric = '%' . str_replace(',', '', request('search')) . '%';

            $query->where(function ($q) use ($search, $numeric) {
                $q->where('name', 'like', $search)
                ->orWhere('description', 'like', $search)
                ->orWhereRaw('CAST(water_price AS CHAR) LIKE ?', [$search])
                ->orWhereRaw('CAST(water_price AS CHAR) LIKE ?', [$numeric])
                ->orWhereRaw('CAST(electric_price AS CHAR) LIKE ?', [$search])
                ->orWhereRaw('CAST(electric_price AS CHAR) LIKE ?', [$numeric])
                ->orWhereHas('site', function ($q2) use ($search) {
                    $q2->where('name', 'like', $search);
                });
            });
        }

        $sites = $user->isAdmin()
            ? Site::all()
            : Site::where('id', $user->site_id)->get();

        $blocks = $query->with('site')->latest()->paginate(10)->withQueryString();

        return view('blocks.index', compact('blocks', 'sites'));
    }

    public function create()
    {
        $user = auth()->user();
        
        $sites = $user->isAdmin() 
            ? Site::all() 
            : Site::where('id', $user->site_id)->get();
        
        return view('blocks.create', compact('sites'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'water_price' => 'required|numeric|min:0',
            'electric_source' => 'required|string',
            'electric_price' => 'required|numeric|min:0',
            'max_electric_price' => 'nullable|numeric|min:0',
            'calculation_threshold' => 'nullable|numeric|min:1',
        ]);

        $validated['max_electric_price'] = $validated['max_electric_price'] ?? 0;
        $validated['calculation_threshold'] = $validated['calculation_threshold'] ?? 0;

        Block::create($validated);

        return redirect()->route('blocks.index')->with('success', 'Block created successfully.');
    }

    public function edit(Block $block)
    {
        $user = auth()->user();
        
        $sites = $user->isAdmin() 
            ? Site::all() 
            : Site::where('id', $user->site_id)->get();

        return view('blocks.edit', compact('block', 'sites'));
    }

    public function update(Request $request, Block $block)
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'water_price' => 'required|numeric|min:0',
            'electric_source' => 'required|string',
            'electric_price' => 'required|numeric|min:0',
            'max_electric_price' => 'nullable|numeric|min:0',
            'calculation_threshold' => 'nullable|numeric|min:1',
        ]);

        $validated['max_electric_price'] = $validated['max_electric_price'] ?? 0;
        $validated['calculation_threshold'] = $validated['calculation_threshold'] ?? 0;

        $block->update($validated);

        return redirect()->route('blocks.index')->with('success', 'Block updated successfully.');
    }

    public function destroy(Block $block)
    {
        $block->delete();
        return redirect()->route('blocks.index')->with('success', 'Block deleted successfully.');
    }

    public function getBlockInfo($id)
    {
        $block = Block::find($id);

        if (!$block) {
            return response()->json(['error' => 'Block not found'], 404);
        }

        return response()->json([
            'water_unit_price' => $block->water_price,
            'electric_unit_price' => $block->electric_price,
            'electric_source' => $block->electric_source,
            'max_electric_unit_price' => $block->max_electric_price,
            'calculation_threshold' => $block->calculation_threshold,
        ]);
    }

    public function getBlocksBySite($siteId)
    {
        $blocks = Block::where('site_id', $siteId)->get();
        return response()->json($blocks);
    }
}
