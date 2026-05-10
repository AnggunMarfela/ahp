@extends('layouts.app')

@section('content')

<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

    <!-- HEADER -->
    <div class="p-8 flex justify-between items-center border-b border-slate-200">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Data Kriteria
            </h1>

            <p class="text-slate-500 mt-2">
                Daftar kriteria penilaian metode AHP
            </p>

        </div>

        <!-- BUTTON TAMBAH -->
     <a href="{{ route('kriteria.create') }}"
   class="inline-flex items-center gap-2
          bg-blue-600 hover:bg-blue-700
          text-white font-bold
          px-6 py-3 rounded-2xl
          shadow-lg transition-all duration-300">

    <span class="text-xl">+</span>

    Tambah Kriteria

</a>

    </div>

    <!-- ALERT -->
    @if(session('success'))

        <div class="mx-8 mt-6 bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-2xl">

            {{ session('success') }}

        </div>

    @endif

    <!-- TABLE -->
    <div class="overflow-x-auto">

        <table class="w-full">

            <!-- HEAD -->
            <thead class="bg-slate-100">

                <tr>

                    <th class="px-6 py-5 text-left text-sm font-bold text-slate-700">
                        No
                    </th>

                    <th class="px-6 py-5 text-left text-sm font-bold text-slate-700">
                        Kode
                    </th>

                    <th class="px-6 py-5 text-left text-sm font-bold text-slate-700">
                        Nama Kriteria
                    </th>

                    <th class="px-6 py-5 text-left text-sm font-bold text-slate-700">
                        Bobot
                    </th>

                    <th class="px-6 py-5 text-center text-sm font-bold text-slate-700">
                        Aksi
                    </th>

                </tr>

            </thead>

            <!-- BODY -->
            <tbody>

                @forelse($kriterias as $item)

                <tr class="border-t border-slate-200 hover:bg-slate-50 transition">

                    <!-- NO -->
                    <td class="px-6 py-5">

                        {{ $loop->iteration }}

                    </td>

                    <!-- KODE -->
                    <td class="px-6 py-5">

                        <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-semibold">

                            {{ $item->kode_kriteria }}

                        </span>

                    </td>

                    <!-- NAMA -->
                    <td class="px-6 py-5 font-semibold text-slate-700">

                        {{ $item->nama_kriteria }}

                    </td>

                    <!-- BOBOT -->
                    <td class="px-6 py-5">

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">

                            {{ $item->bobot }}

                        </span>

                    </td>

                    <!-- AKSI -->
                    <td class="px-6 py-5">

                        <div class="flex justify-center gap-3">

                            <!-- EDIT -->
                            <a href="{{ route('kriteria.edit', $item->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-xl text-sm font-semibold">

                                Edit

                            </a>

                            <!-- DELETE -->
                            <a href="{{ route('kriteria.delete', $item->id) }}"
                               onclick="return confirm('Yakin ingin menghapus data?')"
                               class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl text-sm font-semibold">

                                Hapus

                            </a>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="text-center py-10 text-slate-500">

                        Data kriteria belum tersedia

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection