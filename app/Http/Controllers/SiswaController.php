<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaController extends Controller
{
    // tampil semua data siswa
    public function index()
    {
        $data = Siswa::all();
        return view('siswa.index', compact('data'));
    }

    // tampil form tambah siswa
    public function create()
    {
        return view('siswa.create');
    }

    // simpan data siswa
    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'umur' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        Siswa::create([
            'nama_siswa' => $request->nama_siswa,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'nama_orang_tua' => $request->nama_orang_tua,
        ]);

        return redirect('/siswa')->with('success', 'Data berhasil ditambahkan');
    }

    // 🔥 EDIT
    public function edit($id)
    {
        $data = Siswa::findOrFail($id);
        return view('siswa.edit', compact('data'));
    }

    // 🔥 UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'umur' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        $data = Siswa::findOrFail($id);

        $data->update([
            'nama_siswa' => $request->nama_siswa,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'nama_orang_tua' => $request->nama_orang_tua,
        ]);

        return redirect('/siswa')->with('success', 'Data berhasil diupdate');
    }

    // 🔥 DELETE
    public function destroy($id)
    {
        $data = Siswa::findOrFail($id);
        $data->delete();

        return redirect('/siswa')->with('success', 'Data berhasil dihapus');
    }
}