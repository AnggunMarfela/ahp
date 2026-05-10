@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-10">

        <!-- HEADER -->
        <div class="mb-8">

            <h1 class="text-4xl font-bold text-slate-800">
                Tambah Kriteria
            </h1>

            <p class="text-slate-500 mt-2 text-lg">
                Input data kriteria penilaian
            </p>

        </div>

        <!-- ERROR -->
        @if ($errors->any())

            <div class="bg-red-100 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6">

                <ul class="list-disc pl-5">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <!-- FORM -->
        <form action="{{ route('kriteria.store') }}" method="POST">

            @csrf

            <!-- KODE KRITERIA -->
            <div class="mb-6">

                <label class="block text-lg font-semibold text-slate-700 mb-3">

                    Kode Kriteria

                </label>

                <input type="text"
                       name="kode_kriteria"
                       value="{{ old('kode_kriteria') }}"
                       placeholder="Contoh: C1"
                       class="w-full border border-slate-300 rounded-2xl px-5 py-4 text-lg
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       required>

            </div>

            <!-- NAMA KRITERIA -->
            <div class="mb-8">

                <label class="block text-lg font-semibold text-slate-700 mb-3">

                    Nama Kriteria

                </label>

                <input type="text"
                       name="nama_kriteria"
                       value="{{ old('nama_kriteria') }}"
                       placeholder="Contoh: Kognitif"
                       class="w-full border border-slate-300 rounded-2xl px-5 py-4 text-lg
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       required>

            </div>
            <!-- BOBOT -->
<div class="mb-6">

    <label class="block text-lg font-semibold text-slate-700 mb-3">

        Bobot AHP

    </label>

    <input type="number"
           step="0.01"
           name="bobot"
           value="{{ old('bobot') }}"
           placeholder="Contoh: 0.40"
           class="w-full border border-slate-300 rounded-2xl px-5 py-4 text-lg
                  focus:outline-none focus:ring-2 focus:ring-indigo-500"
           required>

</div>

            <!-- BUTTON -->
            <div class="flex gap-4">

                <!-- SIMPAN -->
                <button type="submit"
        class="bg-blue-600 hover:bg-blue-700
               text-white font-bold
               px-8 py-4 rounded-2xl
               shadow-lg transition duration-300">

    Simpan</button>

                <!-- KEMBALI -->
                <a href="{{ route('kriteria.index') }}"
                   class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-8 py-4 rounded-2xl text-lg font-semibold transition duration-300">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection