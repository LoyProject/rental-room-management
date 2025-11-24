<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Block;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Invoice::query()->with(['block', 'customer']);

        if (request()->filled('block')) {
            $requestedBlockId = request('block');

            $block = Block::find($requestedBlockId);

            if (!$block) {
                abort(404, 'Block not found');
            }

            if (!$user->isAdmin()) {
                if ($block->site_id != $user->site_id) {
                    abort(404, 'You cannot access this block');
                }
            }

            $query->where('block_id', $requestedBlockId);

        } else {
            if (!$user->isAdmin()) {
                $query->whereHas('block', function ($q) use ($user) {
                    $q->where('site_id', $user->site_id);
                });
            }
        }

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $searchNumber = '%' . str_replace(',', '', $request->search) . '%';

            $query->where(function ($q) use ($searchTerm, $searchNumber) {
                $q->where('id', 'like', $searchTerm)
                ->orWhereRaw("DATE_FORMAT(invoice_date, '%d/%m/%Y') LIKE ?", [$searchTerm])
                ->orWhereHas('block', function ($b) use ($searchTerm) {
                    $b->where('name', 'like', $searchTerm);
                })
                ->orWhereHas('customer', function ($c) use ($searchTerm) {
                    $c->where('name', 'like', $searchTerm);
                })
                ->orWhereRaw('CAST(total_amount_water AS CHAR) LIKE ?', [$searchTerm])
                ->orWhereRaw('CAST(total_amount_water AS CHAR) LIKE ?', [$searchNumber])
                ->orWhereRaw('CAST(total_amount_electric AS CHAR) LIKE ?', [$searchTerm])
                ->orWhereRaw('CAST(total_amount_electric AS CHAR) LIKE ?', [$searchNumber])
                ->orWhere('total_amount_usd', 'like', $searchTerm)
                ->orWhereRaw('CAST(total_amount_khr AS CHAR) LIKE ?', [$searchTerm])
                ->orWhereRaw('CAST(total_amount_khr AS CHAR) LIKE ?', [$searchNumber]);
            });
        }


        $blocks = $user->isAdmin()
            ? Block::all()
            : Block::where('site_id', $user->site_id)->get();

        $invoices = $query->latest()->paginate(10)->withQueryString();

        return view('invoices.index', compact('invoices', 'blocks'));
    }

    public function create()
    {
        $user = auth()->user();

        $blocks = $user->isAdmin() 
                    ? Block::all()
                    : Block::where('site_id', $user->site_id)->get();
                    
        $customers = Customer::all();
        
        return view('invoices.create', compact('blocks', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_date'          => 'required|string',
            'block_id'              => 'required|exists:blocks,id',
            'customer_id'           => 'required|exists:customers,id',

            'from_date'             => 'required|string',
            'to_date'               => 'required|string',

            'house_price'           => 'required|numeric|min:0',
            'garbage_price'         => 'required|numeric|min:0',

            'old_water_number'      => 'required|numeric|min:0',
            'new_water_number'      => 'required|numeric|min:0|gte:old_water_number',
            'total_used_water'      => 'required|numeric|min:0',

            'old_electric_number'   => 'required|numeric|min:0',
            'new_electric_number'   => 'required|numeric|min:0|gte:old_electric_number',
            'total_used_electric'   => 'required|numeric|min:0',

            'water_unit_price'      => 'required|numeric|min:0',
            'electric_unit_price'   => 'required|numeric|min:0',

            'total_amount_water'    => 'required|numeric|min:0',
            'total_amount_electric' => 'required|numeric|min:0',

            'total_amount_usd'      => 'required|numeric|min:0',
            'total_amount_khr'      => 'required|numeric|min:0',
        ]);

        if ($request->invoice_date && $request->from_date && $request->to_date) {
            $validated['invoice_date'] = Carbon::createFromFormat('d/m/Y', $request->invoice_date)->format('Y-m-d');
            $validated['from_date'] = Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d');
            $validated['to_date'] = Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d');
        }

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
        $user = auth()->user();
        
        $blocks = $user->isAdmin() 
                    ? Block::all()
                    : Block::where('site_id', $user->site_id)->get();

        $customers = Customer::all();
        
        return view('invoices.edit', compact('invoice', 'blocks', 'customers'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'invoice_date'          => 'required|string',
            'block_id'              => 'required|exists:blocks,id',
            'customer_id'           => 'required|exists:customers,id',

            'from_date'             => 'required|string',
            'to_date'               => 'required|string',

            'house_price'           => 'required|numeric|min:0',
            'garbage_price'         => 'required|numeric|min:0',

            'old_water_number'      => 'required|numeric|min:0',
            'new_water_number'      => 'required|numeric|min:0|gte:old_water_number',
            'total_used_water'      => 'required|numeric|min:0',

            'old_electric_number'   => 'required|numeric|min:0',
            'new_electric_number'   => 'required|numeric|min:0|gte:old_electric_number',
            'total_used_electric'   => 'required|numeric|min:0',

            'water_unit_price'      => 'required|numeric|min:0',
            'electric_unit_price'   => 'required|numeric|min:0',

            'total_amount_water'    => 'required|numeric|min:0',
            'total_amount_electric' => 'required|numeric|min:0',

            'total_amount_usd'      => 'required|numeric|min:0',
            'total_amount_khr'      => 'required|numeric|min:0',
        ]);

        if ($request->invoice_date && $request->from_date && $request->to_date) {
            $validated['invoice_date'] = Carbon::createFromFormat('d/m/Y', $request->invoice_date)->format('Y-m-d');
            $validated['from_date'] = Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d');
            $validated['to_date'] = Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d');
        }

        $customer = Customer::find($validated['customer_id']);
        if (isset($validated['new_water_number'])) {
            $customer->old_water_number = $validated['new_water_number'];
        }
        if (isset($validated['new_electric_number'])) {
            $customer->old_electric_number = $validated['new_electric_number'];
        }

        $oldCustomer = Customer::find($invoice->customer_id);
        if ($oldCustomer->id !== $customer->id) {
            $oldCustomer->old_water_number = $invoice->old_water_number;
            $oldCustomer->old_electric_number = $invoice->old_electric_number;
            $oldCustomer->save();
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
        $customer = Customer::find($invoice->customer_id);

        if ($customer) {
            $customer->old_water_number = $invoice->old_water_number;
            $customer->old_electric_number = $invoice->old_electric_number;
            $customer->save();
        }

        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
