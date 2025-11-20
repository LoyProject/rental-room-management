<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Site;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        $query = Block::query();

        if (request('search')) {
            $searchTerm = '%' . request('search') . '%';
            $query->where('name', 'like', $searchTerm)
                ->orWhere('description', 'like', $searchTerm)
                ->orWhere('water_price', 'like', $searchTerm)
                ->orWhere('electric_price', 'like', $searchTerm)
                ->orWhereHas('site', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm);
                });
        }

        $blocks = $query->with('site')->latest()->paginate(10)->withQueryString();
        
        return view('blocks.index', compact('blocks'));
    }

    public function create()
    {
        $sites = Site::all();
        return view('blocks.create', compact('sites'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'water_price' => 'required|numeric|min:0',
            'electric_price' => 'required|numeric|min:0',
        ]);

        Block::create($validated);

        return redirect()->route('blocks.index')->with('success', 'Block created successfully.');
    }

    public function edit(Block $block)
    {
        $sites = Site::all();
        return view('blocks.edit', compact('block', 'sites'));
    }

    public function update(Request $request, Block $block)
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'water_price' => 'required|numeric|min:0',
            'electric_price' => 'required|numeric|min:0',
        ]);

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
        ]);
    }
}
