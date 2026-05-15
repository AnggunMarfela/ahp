

<tbody>

    @forelse ($hasil as $item)

    <tr style="border-bottom:0.5px solid #f1f5f9"
        class="hover:bg-slate-50 transition">

        <!-- NAMA SISWA -->
        <td style="padding:9px 20px">

            <div style="display:flex;align-items:center;gap:8px">

                <!-- ICON -->
                <div style="width:28px;
                            height:28px;
                            border-radius:50%;
                            background:#EEF2FF;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-size:10px;
                            font-weight:600;
                            color:#4F46E5;
                            flex-shrink:0">

                    {{ strtoupper(substr($item['siswa'], 0, 2)) }}

                </div>

                <!-- NAMA -->
                <span style="font-size:12px;
                             font-weight:500;
                             color:#334155">

                    {{ $item['siswa'] }}

                </span>

            </div>

        </td>

        <!-- NILAI KRITERIA -->
        @foreach ($kriterias as $k)

        <td style="text-align:center;
                   font-size:12px;
                   color:#475569;
                   padding:9px 12px">

            {{ $item['nilai'][$k->id] ?? '-' }}

        </td>

        @endforeach

        <!-- SKOR -->
        <td style="text-align:center;padding:9px 12px">

            <span style="font-size:12px;
                         font-weight:600;
                         color:#1e293b">

                {{ number_format($item['skor'], 3) }}

            </span>

        </td>

        <!-- STATUS -->
        <td style="text-align:center;padding:9px 12px">

            @if($item['status'] === 'Layak')

                <span style="display:inline-block;
                             padding:2px 8px;
                             border-radius:99px;
                             font-size:10px;
                             font-weight:500;
                             background:#EAF3DE;
                             color:#3B6D11">

                    Layak

                </span>

            @elseif($item['status'] === 'Perlu Bimbingan')

                <span style="display:inline-block;
                             padding:2px 8px;
                             border-radius:99px;
                             font-size:10px;
                             font-weight:500;
                             background:#FAEEDA;
                             color:#854F0B">

                    Bimbingan

                </span>

            @else

                <span style="display:inline-block;
                             padding:2px 8px;
                             border-radius:99px;
                             font-size:10px;
                             font-weight:500;
                             background:#FCEBEB;
                             color:#A32D2D">

                    Tidak Layak

                </span>

            @endif

        </td>

        <!-- AKSI -->
        <td style="text-align:center;padding:9px 12px">

            <a href="#"
               style="font-size:14px;
                      color:#94a3b8;
                      cursor:pointer">

                <i class="ti ti-eye"></i>

            </a>

        </td>

    </tr>

    @empty

    <tr>

        <td colspan="9"
            style="text-align:center;
                   padding:48px;
                   font-size:13px;
                   color:#94a3b8">

            <i class="ti ti-database-off"
               style="font-size:24px;
                      display:block;
                      margin-bottom:8px"></i>

            Belum ada data penilaian

        </td>

    </tr>

    @endforelse

</tbody>