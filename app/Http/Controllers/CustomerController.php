<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Block;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $query = Customer::query();

        if (request('search')) {
            $searchTerm = '%' . request('search') . '%';
            $query->where('name', 'like', $searchTerm)
                ->orWhere('phone', 'like', $searchTerm)
                ->orWhere('house_price', 'like', $searchTerm)
                ->orWhere('garbage_price', 'like', $searchTerm)
                ->orWhere('old_water_number', 'like', $searchTerm)
                ->orWhere('old_electric_number', 'like', $searchTerm)
                ->orWhereHas('block', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm);
                });
        }

        $customers = $query->with('block')->latest()->paginate(10)->withQueryString();

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
            'phone' => 'nullable|string|max:25',
            'house_price' => 'required|numeric|min:0',
            'garbage_price' => 'required|integer|min:0',
            'old_water_number' => 'nullable|integer|min:0',
            'old_electric_number' => 'nullable|integer|min:0',
        ]);

        $validated['old_water_number'] = $validated['old_water_number'] ?? 0;
        $validated['old_electric_number'] = $validated['old_electric_number'] ?? 0;

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
            'phone' => 'nullable|string|max:25',
            'house_price' => 'required|numeric|min:0',
            'garbage_price' => 'required|integer|min:0',
            'old_water_number' => 'nullable|integer|min:0',
            'old_electric_number' => 'nullable|integer|min:0',
        ]);

        $validated['old_water_number'] = $validated['old_water_number'] ?? 0;
        $validated['old_electric_number'] = $validated['old_electric_number'] ??

        $customer->update($validated);
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
   
    public function getByBlock($block_id)
    {
        $month = request()->month;
        $year  = request()->year;

        $customers = Customer::where('block_id', $block_id)
            ->whereDoesntHave('invoices', function ($query) use ($month, $year) {
                $query->whereYear('invoice_date', $year)
                    ->whereMonth('invoice_date', $month);
            })
            ->get();

        return response()->json($customers);
    }

    
    public function getCustomerInfo($id)
    {
        $customer = Customer::find($id);

        return response()->json([
            'house_price' => $customer->house_price,
            'garbage_price' => $customer->garbage_price,
            'old_water_number' => $customer->old_water_number,
            'old_electric_number' => $customer->old_electric_number,
        ]);
    }
}
