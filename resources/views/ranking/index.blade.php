@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6">
        Hasil Ranking
    </h2>

    <table class="w-full">

        <thead class="bg-gray-200">

            <tr>
                <th class="p-3">Ranking</th>
                <th class="p-3">Nama Siswa</th>
                <th class="p-3">Nilai Akhir</th>
                <th class="p-3">Status</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($hasil as $index => $item)

            <tr class="border-t hover:bg-gray-50">

                <td class="p-3">
                    {{ $index + 1 }}
                </td>

                <td class="p-3">
                    {{ $item['nama'] }}
                </td>

                <td class="p-3">
                    {{ number_format($item['skor'], 2) }}
                </td>

                <td class="p-3">

                    @if($item['status'] == 'Layak')

                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                            Layak
                        </span>

                    @elseif($item['status'] == 'Perlu Bimbingan')

                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm">
                            Perlu Bimbingan
                        </span>

                    @else

                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm">
                            Tidak Layak
                        </span>

                    @endif

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection