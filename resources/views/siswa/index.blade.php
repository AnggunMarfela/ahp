
@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">
            Data Siswa
        </h2>

        <a href="/siswa/create"
           class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
           + Tambah
        </a>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3">No</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Umur</th>
                    <th class="p-3">Jenis Kelamin</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $index => $item)

                <tr class="border-t hover:bg-gray-50">

                    <td class="p-3">{{ $index + 1 }}</td>
                    <td class="p-3">{{ $item->nama_siswa }}</td>
                    <td class="p-3">{{ $item->umur }}</td>
                    <td class="p-3">{{ $item->jenis_kelamin }}</td>

                    <td class="p-3 flex gap-2">

                        <a href="/siswa/edit/{{ $item->id }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                           Edit
                        </a>

                        <a href="/siswa/delete/{{ $item->id }}"
                           class="bg-red-500 text-white px-3 py-1 rounded">
                           Hapus
                        </a>

                    </td>

                </tr>

                @endforeach
            </tbody>

        </table>

    </div>

</div>

@endsection