@extends('layouts.app')

@section('page-title', 'Edit Kriteria')
@section('page-subtitle', 'Edit data kriteria')

@section('content')

<div class="max-w-2xl">

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">

        <!-- HEADER -->
        <div class="mb-6">

            <h1 class="text-2xl font-bold text-slate-800">
                Edit Kriteria
            </h1>

            <p class="text-slate-500 mt-1">
                Perbarui data kriteria penilaian
            </p>

        </div>

        <!-- ERROR -->
        @if ($errors->any())

            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5">

                <ul class="list-disc pl-5">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <!-- FORM -->
        <form method="POST"
              action="{{ route('kriteria.update', $kriteria->id) }}"
              class="space-y-5">

            @csrf
            @method('PUT')

            <!-- KODE KRITERIA -->
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">

                    Kode Kriteria

                </label>

                <input type="text"
                       name="kode_kriteria"
                       value="{{ old('kode_kriteria', $kriteria->kode_kriteria) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3
                              focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       required>

            </div>

            <!-- NAMA KRITERIA -->
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">

                    Nama Kriteria

                </label>

                <input type="text"
                       name="nama_kriteria"
                       value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3
                              focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       required>

            </div>

            <!-- BOBOT -->
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">

                    Bobot AHP

                </label>

                <input type="number"
                       step="0.01"
                       name="bobot"
                       value="{{ old('bobot', $kriteria->bobot) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3
                              focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       required>

            </div>

            <!-- BUTTON -->
            <div class="flex gap-3 pt-4">

                <!-- UPDATE -->
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl font-semibold shadow transition">

                    Perbarui

                </button>

                <!-- BATAL -->
                <a href="{{ route('kriteria.index') }}"
                   class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-3 rounded-xl font-semibold transition">

                    Batal

                </a>

            </div>

        </form>

    </div>

</div>

@endsection