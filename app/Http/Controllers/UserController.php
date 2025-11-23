<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Site;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = User::query();

        if (request()->filled('role') && $user->role === 'admin') {
            $query->where('role', request('role'));
        }

        if (request()->filled('search')) {
            $search = '%' . request('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                ->orWhere('email', 'like', $search);
            });
        }

        $users = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $sites = Site::all();
        return view('users.create', compact('sites'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'site_id'  => ['nullable', 'exists:sites,id'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', Rule::in(['user','admin'])],
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return redirect()->route('users.index')->with('success', "User {$user->name} created.");
    }

    public function edit(User $user)
    {
        $sites = Site::all();
        return view('users.edit', compact('user', 'sites'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'site_id'  => ['nullable', 'exists:sites,id'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', Rule::in(['user','admin'])],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        if ($data['role'] === 'admin') {
            $user->update(['site_id' => null]);
        }

        return redirect()->route('users.index')->with('success', "User {$user->name} updated.");
    }

    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();

        return redirect()->route('users.index')->with('success', "User {$name} deleted.");
    }
}