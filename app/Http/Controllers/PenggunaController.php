<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PenggunaController extends Controller
{
    /**
     * Menampilkan daftar pengguna
     */
    public function index()
    {
        $penggunas = User::orderBy('name', 'ASC')->get();

        return view('pengguna.index', compact('penggunas'));
    }

    /**
     * Menampilkan form tambah pengguna
     */
    public function create()
    {
        return view('pengguna.create');
    }

    /**
     * Menyimpan data pengguna baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],

            'role' => [
                'required',
                'in:admin,guru,kepala_sekolah'
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers()
            ],

        ], [

            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'role.required' => 'Role wajib dipilih.',

            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit pengguna
     */
    public function edit(User $pengguna)
    {
        return view('pengguna.edit', compact('pengguna'));
    }

    /**
     * Update data pengguna
     */
    public function update(Request $request, User $pengguna)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email,' . $pengguna->id
            ],

            'role' => [
                'required',
                'in:admin,guru,kepala_sekolah'
            ],

            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers()
            ],

        ], [

            'name.required' => 'Nama wajib diisi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan pengguna lain.',

            'role.required' => 'Role wajib dipilih.',

            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Jika password diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna
     */
    public function destroy(User $pengguna)
    {
        // Mencegah user menghapus akun sendiri
        if ($pengguna->id == auth()->id()) {

            return redirect()
                ->route('pengguna.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $pengguna->delete();

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}