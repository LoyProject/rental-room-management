<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::latest()->paginate(10);
        return view('sites.index', compact('sites'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Site $site)
    {
        //
    }

    public function edit(Site $site)
    {
        //
    }

    public function update(Request $request, Site $site)
    {
        //
    }


    public function destroy(Site $site)
    {
        //
    }
}
