@extends('layouts.app')
@section('page-title', 'Ranking')
@section('page-subtitle', 'Peringkat kesiapan anak masuk SD berdasarkan skor AHP')

@section('content')

@if(session('success'))
<div style="margin-bottom:16px;padding:12px 16px;background:#EAF3DE;
            border:0.5px solid #97C459;border-radius:10px;
            font-size:13px;color:#3B6D11;display:flex;align-items:center;gap:8px">
    <i class="ti ti-circle-check" style="font-size:16px"></i>
    {{ session('success') }}
</div>
@endif

<div style="background:white;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden">

    {{-- Header --}}
    <div style="padding:14px 20px;border-bottom:0.5px solid #f1f5f9;
                display:flex;align-items:center;justify-content:space-between">
        <div>
            <p style="font-size:13px;font-weight:500;color:#1e293b">Hasil peringkat siswa</p>
            <p style="font-size:11px;color:#94a3b8;margin-top:2px">
                Diurutkan dari skor AHP tertinggi
            </p>
        </div>
        <div style="display:flex;align-items:center;gap:8px">
            <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 8px;
                         border-radius:99px;font-size:10px;font-weight:500;
                         background:#EAF3DE;color:#3B6D11">
                Layak ≥ 0.75
            </span>
            <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 8px;
                         border-radius:99px;font-size:10px;font-weight:500;
                         background:#FAEEDA;color:#854F0B">
                Bimbingan 0.50–0.74
            </span>
            <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 8px;
                         border-radius:99px;font-size:10px;font-weight:500;
                         background:#FCEBEB;color:#A32D2D">
                Tidak Layak &lt; 0.50
            </span>
        </div>
    </div>

    {{-- Tabel --}}
    <div style="overflow-x:auto">
    <table style="width:100%;border-collapse:collapse;min-width:600px">
        <thead>
            <tr style="background:#f8fafc;border-bottom:0.5px solid #e2e8f0">
                <th style="text-align:center;font-size:11px;font-weight:500;
                            color:#94a3b8;padding:10px 12px;width:50px">Rank</th>
                <th style="text-align:left;font-size:11px;font-weight:500;
                            color:#94a3b8;padding:10px 20px">Nama siswa</th>

                @foreach($kriterias as $k)
                <th style="text-align:center;font-size:11px;font-weight:500;
                            color:#94a3b8;padding:10px 10px;
                            {{ $k->kode_kriteria === 'C3' ? 'color:#854F0B' : '' }}">
                    {{ $k->kode_kriteria }}
                    <div style="font-size:10px;font-weight:400;color:#94a3b8;margin-top:1px">
                        {{ $k->bobot ? round($k->bobot * 100, 1) . '%' : '-' }}
                    </div>
                </th>
                @endforeach

                <th style="text-align:center;font-size:11px;font-weight:500;
                            color:#94a3b8;padding:10px 12px">Skor AHP</th>
                <th style="text-align:center;font-size:11px;font-weight:500;
                            color:#94a3b8;padding:10px 12px">Status</th>
                <th style="text-align:center;font-size:11px;font-weight:500;
                            color:#94a3b8;padding:10px 12px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasil as $rank => $item)
            <tr style="border-bottom:0.5px solid #f1f5f9"
                onmouseover="this.style.background='#f8fafc'"
                onmouseout="this.style.background='white'">

                {{-- Rank badge --}}
                <td style="text-align:center;padding:12px 12px">
                    @if($rank === 0)
                        <span style="display:inline-flex;width:24px;height:24px;border-radius:50%;
                                     align-items:center;justify-content:center;font-size:11px;
                                     font-weight:700;background:#FEF3C7;color:#92400E">1</span>
                    @elseif($rank === 1)
                        <span style="display:inline-flex;width:24px;height:24px;border-radius:50%;
                                     align-items:center;justify-content:center;font-size:11px;
                                     font-weight:700;background:#F1F5F9;color:#475569">2</span>
                    @elseif($rank === 2)
                        <span style="display:inline-flex;width:24px;height:24px;border-radius:50%;
                                     align-items:center;justify-content:center;font-size:11px;
                                     font-weight:700;background:#FFEDD5;color:#9A3412">3</span>
                    @else
                        <span style="font-size:12px;color:#94a3b8">{{ $rank + 1 }}</span>
                    @endif
                </td>

                {{-- Nama siswa --}}
                <td style="padding:12px 20px">
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="width:28px;height:28px;border-radius:50%;
                                    background:#EEEDFE;display:flex;align-items:center;
                                    justify-content:center;font-size:10px;font-weight:600;
                                    color:#3C3489;flex-shrink:0">
                            {{ strtoupper(substr($item['siswa'], 0, 2)) }}
                        </div>
                        <div>
                            <p style="font-size:12px;font-weight:500;color:#1e293b">
                                {{ $item['siswa'] }}
                            </p>
                        </div>
                    </div>
                </td>

                {{-- Nilai per kriteria --}}
                @foreach($kriterias as $k)
                <td style="text-align:center;font-size:12px;color:#475569;padding:12px 10px">
                    {{ isset($item['nilai'][$k->id]) ? number_format($item['nilai'][$k->id], 0) : '-' }}
                </td>
                @endforeach

                {{-- Skor AHP --}}
                <td style="text-align:center;padding:12px 12px">
                    <span style="font-size:13px;font-weight:700;
                                 color:{{ $item['status'] === 'Layak' ? '#3B6D11' : ($item['status'] === 'Perlu Bimbingan' ? '#854F0B' : '#A32D2D') }}">
                        {{ number_format($item['skor'], 3) }}
                    </span>
                </td>

                {{-- Status --}}
                <td style="text-align:center;padding:12px 12px">
                    @if($item['status'] === 'Layak')
                        <span style="display:inline-block;padding:3px 10px;border-radius:99px;
                                     font-size:10px;font-weight:500;
                                     background:#EAF3DE;color:#3B6D11">
                            Layak
                        </span>
                    @elseif($item['status'] === 'Perlu Bimbingan')
                        <span style="display:inline-block;padding:3px 10px;border-radius:99px;
                                     font-size:10px;font-weight:500;
                                     background:#FAEEDA;color:#854F0B">
                            Bimbingan
                        </span>
                    @else
                        <span style="display:inline-block;padding:3px 10px;border-radius:99px;
                                     font-size:10px;font-weight:500;
                                     background:#FCEBEB;color:#A32D2D">
                            Tidak Layak
                        </span>
                    @endif
                </td>

                {{-- Aksi --}}
                <td style="text-align:center;padding:12px 12px">
                    <a href="{{ route('penilaian.edit', $item['siswa_id']) }}"
                       style="display:inline-flex;align-items:center;gap:4px;
                              padding:4px 10px;border:0.5px solid #e2e8f0;
                              border-radius:7px;font-size:11px;color:#64748b;
                              text-decoration:none;background:#f8fafc">
                        <i class="ti ti-eye" style="font-size:13px"></i> Detail
                    </a>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="{{ $kriterias->count() + 5 }}"
                    style="text-align:center;padding:48px;font-size:13px;color:#94a3b8">
                    <i class="ti ti-trophy"
                       style="font-size:28px;display:block;margin-bottom:8px"></i>
                    Belum ada data ranking — pastikan bobot AHP dan penilaian siswa sudah diisi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    {{-- Footer --}}
    @if(count($hasil) > 0)
    <div style="padding:10px 20px;border-top:0.5px solid #f1f5f9;background:#f8fafc;
                display:flex;align-items:center;justify-content:space-between">
        <p style="font-size:11px;color:#94a3b8">
            Menampilkan {{ count($hasil) }} siswa yang sudah dinilai
        </p>
        <p style="font-size:11px;color:#94a3b8">
            C3 Sosial Emosional = bobot tertinggi (prioritas utama)
        </p>
    </div>
    @endif

</div>

@endsection