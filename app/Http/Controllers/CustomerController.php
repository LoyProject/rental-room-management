<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Block;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('block')->latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        $blocks = Block::all();
        return view('customers.create', compact('blocks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:25',
            'house_price' => 'required|numeric|min:0',
            'wifi_price' => 'required|numeric|min:0',
            'garbage_price' => 'required|integer|min:0',
            'old_water_number' => 'nullable|integer|min:0',
            'old_electric_number' => 'nullable|integer|min:0',
            
        ]);

        Customer::create($validated);
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function edit(Customer $customer)
    {
        $blocks = Block::all();
        return view('customers.edit', compact('customer', 'blocks'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:25',
            'house_price' => 'required|numeric|min:0',
            'wifi_price' => 'required|numeric|min:0',
            'garbage_price' => 'required|integer|min:0',
            'old_water_number' => 'nullable|integer|min:0',
            'old_electric_number' => 'nullable|integer|min:0',
        ]);

        $customer->update($validated);
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
