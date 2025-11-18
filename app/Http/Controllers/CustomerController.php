<?php

namespace App\Http\Controllers;

use App\Models\Customer;
<<<<<<< HEAD
=======
use App\Models\Block;
>>>>>>> 90aeabddc124acde0b37061f1f9383da8c503bcc
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

<<<<<<< HEAD
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
=======
    public function create()
    {
        $blocks = Block::all();
        return view('customers.create', compact('blocks'));
    }

>>>>>>> 90aeabddc124acde0b37061f1f9383da8c503bcc
    public function show(Customer $customer)
    {
        //
    }

<<<<<<< HEAD
    /**
     * Show the form for editing the specified resource.
     */
=======
>>>>>>> 90aeabddc124acde0b37061f1f9383da8c503bcc
    public function edit(Customer $customer)
    {
        //
    }

<<<<<<< HEAD
    /**
     * Update the specified resource in storage.
     */
=======
>>>>>>> 90aeabddc124acde0b37061f1f9383da8c503bcc
    public function update(Request $request, Customer $customer)
    {
        //
    }

<<<<<<< HEAD
    /**
     * Remove the specified resource from storage.
     */
=======
>>>>>>> 90aeabddc124acde0b37061f1f9383da8c503bcc
    public function destroy(Customer $customer)
    {
        //
    }
}
