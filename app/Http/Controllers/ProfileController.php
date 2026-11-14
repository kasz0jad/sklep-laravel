<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\s\-]+$/u'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'regex:/^\d{9}$/'],
            'password' => 'nullable|string|min:8|confirmed',

            // adres jest opcjonalny, ale jeśli podasz część, musisz podać wymagane pola
            'street' => ['nullable', 'string', 'max:255', 'regex:/^[\p{L}0-9\s\.\-]+$/u'],
            'house_number' => ['nullable', 'required_with:street,postcode,city', 'regex:/^\d{1,4}[A-Za-z]?(\/\d{1,4}[A-Za-z]?)?$/'],
            'postcode' => ['nullable', 'required_with:street,house_number,city', 'regex:/^\d{2}-\d{3}$/', 'not_in:00-000'],
            'city' => ['nullable', 'required_with:street,house_number,postcode', 'string', 'max:100', 'regex:/^[\p{L}\s\.\-]+$/u'],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return back()->with('success', 'Twoje dane zostały zapisane.');
    }
}