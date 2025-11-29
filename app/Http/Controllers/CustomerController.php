<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Block;
use App\Models\Site;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Customer::query()->with('block');

        if ($user->isAdmin()) {
            if (request()->filled('site')) {
                $query->whereHas('block', function ($q) {
                    $q->where('site_id', request('site'));
                });
            }
        } else {
            if (request()->filled('site') && request('site') != $user->site_id) {
                abort(404, 'You cannot access this site');
            }
            
            $query->whereHas('block', function ($q) use ($user) {
                $q->where('site_id', $user->site_id);
            });
        }

        if (request()->filled('block')) {
            $blockId = request('block');

            $block = Block::find($blockId);
            if (!$block) {
                abort(404, "Block not found");
            }

            if (!$user->isAdmin() && $block->site_id != $user->site_id) {
                abort(404, "You cannot access this block");
            }

            $query->where('block_id', $blockId);
        }

        if (request()->filled('search')) {
            $search = '%' . request('search') . '%';

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                    ->orWhere('phone', 'like', $search)
                    ->orWhere('house_price', 'like', $search)
                    ->orWhere('garbage_price', 'like', $search)
                    ->orWhere('old_water_number', 'like', $search)
                    ->orWhere('old_electric_number', 'like', $search)
                    ->orWhereHas('block', function ($b) use ($search) {
                        $b->where('name', 'like', $search);
                    });
            });
        }

        $sites = $user->isAdmin()
                    ? Site::all()
                    : Site::where('id', $user->site_id)->get();

        $blocks = $user->isAdmin()
                    ? Block::all()
                    : Block::where('site_id', $user->site_id)->get();

        $customers = $query->latest()->paginate(10)->withQueryString();

        return view('customers.index', compact('customers', 'sites', 'blocks'));
    }

    public function create()
    {
        $user = auth()->user();
        
        $sites = $user->isAdmin() 
            ? Site::all() 
            : Site::where('id', $user->site_id)->get();
        
        $blocks = Block::when(!$user->isAdmin(), function ($query) use ($user) {
            $query->where('site_id', $user->site_id);
        })->get();

        return view('customers.create', compact('blocks', 'sites'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:25',
            'house_price' => 'required|numeric|min:0',
            'label_value'   => 'required|string|max:255',
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
        $user = auth()->user();

        $sites = $user->isAdmin()
            ? Site::all()
            : Site::where('id', $user->site_id)->get();

        $customerSiteId = $customer->block->site_id;

        $blocks = $user->isAdmin()
            ? Block::where('site_id', $customerSiteId)->get()
            : Block::where('site_id', $user->site_id)->get();

        return view('customers.edit', compact('customer', 'blocks', 'sites'));
    }

    public function update(Request $request, Customer $customer)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'site_id' => $user->isAdmin() ? 'required|exists:sites,id' : '',
            'block_id' => 'required|exists:blocks,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:25',
            'house_price' => 'required|numeric|min:0',
            'label_value'   => 'required|string|max:255',
            'garbage_price' => 'required|integer|min:0',
            'old_water_number' => 'nullable|integer|min:0',
            'old_electric_number' => 'nullable|integer|min:0',
        ]);

        if ($user->isAdmin()) {
            $block = Block::find($validated['block_id']);

            if ($block->site_id != $validated['site_id']) {
                return back()
                    ->withErrors(['block_id' => 'The selected block does not belong to the selected site.'])
                    ->withInput();
            }
        } else {
            $block = Block::find($validated['block_id']);
            if ($block->site_id != $user->site_id) {
                return back()
                    ->withErrors(['block_id' => 'You cannot assign a customer to a block outside your site.'])
                    ->withInput();
            }
        }

        $validated['old_water_number'] = $validated['old_water_number'] ?? 0;
        $validated['old_electric_number'] = $validated['old_electric_number'] ?? 0;

        $customer->update([
            'block_id' => $validated['block_id'],
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'house_price' => $validated['house_price'],
            'label_value' => $validated['label_value'],
            'garbage_price' => $validated['garbage_price'],
            'old_water_number' => $validated['old_water_number'],
            'old_electric_number' => $validated['old_electric_number'],
        ]);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer updated successfully.');
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
            'label_value' => $customer->label_value,
            'garbage_price' => $customer->garbage_price,
            'old_water_number' => $customer->old_water_number,
            'old_electric_number' => $customer->old_electric_number,
        ]);
    }
}
