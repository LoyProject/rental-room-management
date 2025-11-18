<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Block::with('site')->latest()->paginate(10);
        return view('blocks.index', compact('blocks'));
    }

    public function create()
    {
        $sites = \App\Models\Site::all();
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
        $sites = \App\Models\Site::all();
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
}
