<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Block;
use App\Models\Customer;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::query()->with(['block', 'customer']);

        if ($request->search) {
            $searchTerm = '%' . $request->search . '%';

            $query->where('id', 'like', $searchTerm)
                ->orWhere('invoice_date', 'like', $searchTerm)
                ->orWhere('total_amount_usd', 'like', $searchTerm)
                ->orWhere('total_amount_khr', 'like', $searchTerm)
                ->orWhereHas('customer', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm);
                })
                ->orWhereHas('block', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm);
                });
        }

        $invoices = $query->latest()->paginate(10)->withQueryString();

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $blocks = Block::all();
        $customers = Customer::all();
        
        return view('invoices.create', compact('blocks', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_date'          => 'required|date',
            'block_id'              => 'required|exists:blocks,id',
            'customer_id'           => 'required|exists:customers,id',

            'from_date'             => 'nullable|date',
            'to_date'               => 'nullable|date',

            'house_price'           => 'nullable|numeric|min:0',
            'wifi_price'            => 'nullable|numeric|min:0',
            'garbage_price'         => 'nullable|numeric|min:0',

            'old_water_number'      => 'nullable|numeric|min:0',
            'new_water_number'      => 'nullable|numeric|min:0',
            'total_used_water'      => 'nullable|numeric|min:0',

            'old_electric_number'   => 'nullable|numeric|min:0',
            'new_electric_number'   => 'nullable|numeric|min:0',
            'total_used_electric'   => 'nullable|numeric|min:0',

            'water_unit_price'      => 'nullable|numeric|min:0',
            'electric_unit_price'   => 'nullable|numeric|min:0',

            'total_amount_water'    => 'nullable|numeric|min:0',
            'total_amount_electric' => 'nullable|numeric|min:0',

            'total_amount_usd'      => 'nullable|numeric|min:0',
            'total_amount_khr'      => 'nullable|numeric|min:0',
        ]);

        $customer = Customer::find($validated['customer_id']);
        if (isset($validated['new_water_number'])) {
            $customer->old_water_number = $validated['new_water_number'];
        }
        if (isset($validated['new_electric_number'])) {
            $customer->old_electric_number = $validated['new_electric_number'];
        }

        $customer->save();
        $invoice = Invoice::create($validated);

        return redirect()->route('invoices.print', $invoice->id)->with('success', 'Invoice created successfully.');
    }

    public function edit(Invoice $invoice)
    {
        $blocks = Block::all();
        $customers = Customer::all();
        
        return view('invoices.edit', compact('invoice', 'blocks', 'customers'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'invoice_date'          => 'required|date',
            'block_id'              => 'required|exists:blocks,id',
            'customer_id'           => 'required|exists:customers,id',

            'from_date'             => 'nullable|date',
            'to_date'               => 'nullable|date',

            'house_price'           => 'nullable|numeric|min:0',
            'wifi_price'            => 'nullable|numeric|min:0',
            'garbage_price'         => 'nullable|numeric|min:0',

            'old_water_number'      => 'nullable|numeric|min:0',
            'new_water_number'      => 'nullable|numeric|min:0',
            'total_used_water'      => 'nullable|numeric|min:0',

            'old_electric_number'   => 'nullable|numeric|min:0',
            'new_electric_number'   => 'nullable|numeric|min:0',
            'total_used_electric'   => 'nullable|numeric|min:0',

            'water_unit_price'      => 'nullable|numeric|min:0',
            'electric_unit_price'   => 'nullable|numeric|min:0',

            'total_amount_water'    => 'nullable|numeric|min:0',
            'total_amount_electric' => 'nullable|numeric|min:0',

            'total_amount_usd'      => 'nullable|numeric|min:0',
            'total_amount_khr'      => 'nullable|numeric|min:0',
        ]);

        $customer = Customer::find($validated['customer_id']);
        if (isset($validated['new_water_number'])) {
            $customer->old_water_number = $validated['new_water_number'];
        }
        if (isset($validated['new_electric_number'])) {
            $customer->old_electric_number = $validated['new_electric_number'];
        }
        
        $customer->save();
        $invoice->update($validated);

        return redirect()->route('invoices.print', $invoice->id)->with('success', 'Invoice updated successfully.');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['block', 'customer']);

        return view('invoices.print', compact('invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
