<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id')->get();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\s\-]+$/u'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['klient', 'moderator', 'admin'])],
            'phone' => ['nullable', 'regex:/^\d{9}$/'],
        ]);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Użytkownik został dodany.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\s\-]+$/u'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role' => ['required', Rule::in(['klient', 'moderator', 'admin'])],
            'phone' => ['nullable', 'regex:/^\d{9}$/'],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Dane użytkownika zostały zmienione.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['delete' => 'Nie możesz usunąć własnego konta.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Użytkownik został usunięty.');
    }
}
