<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Block::latest()->paginate(10);
        return view('blocks.index', compact('blocks'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Block $block)
    {
        //
    }

    public function edit(Block $block)
    {
        //
    }

    public function update(Request $request, Block $block)
    {
        //
    }

    public function destroy(Block $block)
    {
        //
    }
}
