<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'email'    => ['required', 'string', 'lowercase', 'email:rfc,dns', 'max:255', 'unique:' . User::class],
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'max:64',
                'regex:/[a-z]/',       // harus ada huruf kecil
                'regex:/[A-Z]/',       // harus ada huruf besar
                'regex:/[0-9]/',       // harus ada angka
            ],
        ], [
            'name.required'           => 'Nama lengkap wajib diisi.',
            'name.max'                => 'Nama lengkap tidak boleh lebih dari 100 karakter.',
            'name.regex'              => 'Nama hanya boleh berisi huruf dan spasi, tanpa angka atau simbol.',
            'email.required'          => 'Alamat email wajib diisi.',
            'email.email'             => 'Format alamat email tidak valid.',
            'email.unique'            => 'Alamat email ini sudah terdaftar, gunakan email lain.',
            'password.required'       => 'Kata sandi wajib diisi.',
            'password.min'            => 'Kata sandi minimal 8 karakter.',
            'password.max'            => 'Kata sandi maksimal 64 karakter.',
            'password.confirmed'      => 'Konfirmasi kata sandi tidak cocok.',
            'password.regex'          => 'Kata sandi harus mengandung huruf besar, huruf kecil, dan angka.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
