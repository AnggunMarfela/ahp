<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Siswa</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Edit Siswa</h2>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/siswa/update/{{ $data->id }}" method="POST" class="space-y-4">
        @csrf

        {{-- NAMA --}}
        <div>
            <label class="block text-gray-600">Nama Siswa</label>
            <input type="text" name="nama_siswa" value="{{ $data->nama_siswa }}"
                class="w-full mt-1 p-2 border rounded-lg">
        </div>

        {{-- UMUR --}}
        <div>
            <label class="block text-gray-600">Umur</label>
            <input type="number" name="umur" value="{{ $data->umur }}"
                class="w-full mt-1 p-2 border rounded-lg">
        </div>

        {{-- JENIS KELAMIN --}}
        <div>
            <label class="block text-gray-600">Jenis Kelamin</label>
            <select name="jenis_kelamin"
                class="w-full mt-1 p-2 border rounded-lg">
                <option value="L" {{ $data->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $data->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        {{-- ALAMAT --}}
        <div>
            <label class="block text-gray-600">Alamat</label>
            <input type="text" name="alamat" value="{{ $data->alamat }}"
                class="w-full mt-1 p-2 border rounded-lg">
        </div>

        {{-- ORANG TUA --}}
        <div>
            <label class="block text-gray-600">Nama Orang Tua</label>
            <input type="text" name="nama_orang_tua" value="{{ $data->nama_orang_tua }}"
                class="w-full mt-1 p-2 border rounded-lg">
        </div>

        {{-- BUTTON --}}
        <button type="submit"
            class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
            Update
        </button>
    </form>

    <a href="/siswa"
        class="block text-center mt-4 text-blue-500 hover:underline">
        ← Kembali
    </a>
</div>

</body>
</html>