@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan penilaian kesiapan anak TK masuk SD')

@section('content')

{{-- STAT CARDS --}}
<div class="grid grid-cols-4 gap-3 mb-4">

    <div class="bg-white border border-slate-200 rounded-xl p-4">
        <p class="text-xs text-slate-400 mb-2">Total siswa</p>
        <p class="text-2xl font-semibold text-slate-800">{{ $totalSiswa }}</p>
        <p class="text-xs text-slate-400 mt-2 flex items-center gap-1">
            <i class="ti ti-users" style="font-size:12px"></i> Tahun ajaran ini
        </p>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl p-4">
        <p class="text-xs text-slate-400 mb-2">Layak masuk SD</p>
        <p class="text-2xl font-semibold" style="color:#3B6D11">{{ $totalLayak }}</p>
        <p class="text-xs mt-2 flex items-center gap-1" style="color:#3B6D11">
            <i class="ti ti-arrow-up" style="font-size:10px"></i>
            {{ $totalSiswa > 0 ? round(($totalLayak / $totalSiswa) * 100) : 0 }}% dari total
        </p>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl p-4">
        <p class="text-xs text-slate-400 mb-2">Perlu bimbingan</p>
        <p class="text-2xl font-semibold" style="color:#854F0B">{{ $totalBimbingan }}</p>
        <p class="text-xs mt-2 flex items-center gap-1" style="color:#BA7517">
            <i class="ti ti-alert-triangle" style="font-size:10px"></i>
            {{ $totalSiswa > 0 ? round(($totalBimbingan / $totalSiswa) * 100) : 0 }}% dari total
        </p>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl p-4">
        <p class="text-xs text-slate-400 mb-2">Tidak layak</p>
        <p class="text-2xl font-semibold" style="color:#A32D2D">{{ $totalTidakLayak }}</p>
        <p class="text-xs mt-2 flex items-center gap-1" style="color:#E24B4A">
            <i class="ti ti-x" style="font-size:10px"></i>
            {{ $totalSiswa > 0 ? round(($totalTidakLayak / $totalSiswa) * 100) : 0 }}% dari total
        </p>
    </div>

</div>

{{-- ROW 2: GRAFIK + DISTRIBUSI --}}
<div class="grid gap-3 mb-4" style="grid-template-columns: 1fr 200px">

    {{-- Rata-rata per kriteria --}}
    <div class="bg-white border border-slate-200 rounded-xl p-4">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-semibold text-slate-700">Rata-rata nilai per kriteria</p>
            <span class="text-xs text-slate-400">Tahun {{ date('Y') }}</span>
        </div>

        @php
            $colors = ['#534AB7','#7F77DD','#AFA9EC','#CECBF6','#E0DEFC'];
        @endphp

        <div class="space-y-3">
            @foreach ($rataKriteria as $idx => $k)
            <div class="flex items-center gap-2">
                <p class="text-xs text-slate-500 flex-shrink-0" style="width:140px">{{ $k['nama'] }}</p>
                <div class="flex-1 rounded-full overflow-hidden" style="height:8px;background:#f1f5f9">
                    <div style="width:{{ min($k['rata'],100) }}%;height:100%;border-radius:99px;background:{{ $colors[$idx] ?? '#534AB7' }}"></div>
                </div>
                <p class="text-xs font-semibold text-slate-700 text-right" style="width:28px">
                    {{ round($k['rata']) }}
                </p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Distribusi hasil --}}
    <div class="bg-white border border-slate-200 rounded-xl p-4">
        <p class="text-sm font-semibold text-slate-700 mb-3">Distribusi hasil</p>

        @php
            $total  = $totalSiswa ?: 1;
            $pL     = ($totalLayak    / $total) * 100;
            $pB     = ($totalBimbingan/ $total) * 100;
            $pT     = ($totalTidakLayak/$total) * 100;
            $circ   = 2 * M_PI * 15.9;
            $segL   = ($pL / 100) * $circ;
            $segB   = ($pB / 100) * $circ;
            $segT   = ($pT / 100) * $circ;
            $offL   = $circ * 0.25;
            $offB   = $offL - $segL;
            $offT   = $offB - $segB;
        @endphp

        <div class="flex flex-col items-center gap-3">
            <svg width="100" height="100" viewBox="0 0 36 36">
                <circle cx="18" cy="18" r="15.9" fill="none" stroke="#EAF3DE" stroke-width="3.8"/>
                <circle cx="18" cy="18" r="15.9" fill="none" stroke="#3B6D11" stroke-width="3.8"
                        stroke-dasharray="{{ $segL }} {{ $circ - $segL }}"
                        stroke-dashoffset="{{ $offL }}" stroke-linecap="round"/>
                <circle cx="18" cy="18" r="15.9" fill="none" stroke="#BA7517" stroke-width="3.8"
                        stroke-dasharray="{{ $segB }} {{ $circ - $segB }}"
                        stroke-dashoffset="{{ $offB }}" stroke-linecap="round"/>
                <circle cx="18" cy="18" r="15.9" fill="none" stroke="#E24B4A" stroke-width="3.8"
                        stroke-dasharray="{{ $segT }} {{ $circ - $segT }}"
                        stroke-dashoffset="{{ $offT }}" stroke-linecap="round"/>
                <text x="18" y="19.5" text-anchor="middle" font-size="5" font-weight="500" fill="#1e293b">
                    {{ $totalSiswa }}
                </text>
                <text x="18" y="23.5" text-anchor="middle" font-size="3" fill="#94a3b8">siswa</text>
            </svg>

            <div class="w-full space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:#3B6D11"></span>
                        <span class="text-xs text-slate-500">Layak</span>
                    </div>
                    <span class="text-xs font-semibold" style="color:#3B6D11">
                        {{ $totalLayak }} <span class="text-slate-400 font-normal">({{ round($pL) }}%)</span>
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:#BA7517"></span>
                        <span class="text-xs text-slate-500">Bimbingan</span>
                    </div>
                    <span class="text-xs font-semibold" style="color:#854F0B">
                        {{ $totalBimbingan }} <span class="text-slate-400 font-normal">({{ round($pB) }}%)</span>
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:#E24B4A"></span>
                        <span class="text-xs text-slate-500">Tidak layak</span>
                    </div>
                    <span class="text-xs font-semibold" style="color:#A32D2D">
                        {{ $totalTidakLayak }} <span class="text-slate-400 font-normal">({{ round($pT) }}%)</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- TABEL PENILAIAN TERBARU --}}
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden">

    <div class="flex items-center justify-between px-5 py-3 border-b border-slate-100">
        <p class="text-sm font-semibold text-slate-700">Data penilaian siswa terbaru</p>
        <a href="/hasil"
           class="text-xs text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-1">
            Lihat ranking <i class="ti ti-arrow-right" style="font-size:12px"></i>
        </a>
    </div>

    <table class="w-full" style="border-collapse:collapse">
        <thead>
            <tr style="background:#f8fafc;border-bottom:0.5px solid #e2e8f0">
                <th style="text-align:left;font-size:11px;font-weight:500;color:#94a3b8;padding:8px 20px">Nama siswa</th>
                <th style="text-align:center;font-size:11px;font-weight:500;color:#94a3b8;padding:8px 12px">C1</th>
                <th style="text-align:center;font-size:11px;font-weight:500;color:#94a3b8;padding:8px 12px">C2</th>
                <th style="text-align:center;font-size:11px;font-weight:500;color:#94a3b8;padding:8px 12px">C3</th>
                <th style="text-align:center;font-size:11px;font-weight:500;color:#94a3b8;padding:8px 12px">C4</th>
                <th style="text-align:center;font-size:11px;font-weight:500;color:#94a3b8;padding:8px 12px">C5</th>
                <th style="text-align:center;font-size:11px;font-weight:500;color:#94a3b8;padding:8px 12px">Skor AHP</th>
                <th style="text-align:center;font-size:11px;font-weight:500;color:#94a3b8;padding:8px 12px">Status</th>
                <th style="text-align:center;font-size:11px;font-weight:500;color:#94a3b8;padding:8px 12px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hasil as $item)
            <tr style="border-bottom:0.5px solid #f1f5f9" class="hover:bg-slate-50 transition">
                <td style="padding:9px 20px">
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="width:28px;height:28px;border-radius:50%;background:#EEF2FF;
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:10px;font-weight:600;color:#4F46E5;flex-shrink:0">
                            {{ strtoupper(substr($item['siswa']->nama_siswa, 0, 2)) }}
                        </div>
                        <span style="font-size:12px;font-weight:500;color:#334155">
                            {{ $item['siswa']->nama_siswa }}
                        </span>
                    </div>
                </td>

                @php $kriteriaIds = $kriterias->pluck('id'); @endphp
                @foreach ($kriterias as $k)
                <td style="text-align:center;font-size:12px;color:#475569;padding:9px 12px">
                    {{ $item['nilai'][$k->id] ?? '-' }}
                </td>
                @endforeach

                <td style="text-align:center;padding:9px 12px">
                    <span style="font-size:12px;font-weight:600;color:#1e293b">
                        {{ number_format($item['skor'], 3) }}
                    </span>
                </td>

                <td style="text-align:center;padding:9px 12px">
                    @if($item['status'] === 'Layak')
                        <span style="display:inline-block;padding:2px 8px;border-radius:99px;
                                     font-size:10px;font-weight:500;background:#EAF3DE;color:#3B6D11">
                            Layak
                        </span>
                    @elseif($item['status'] === 'Bimbingan')
                        <span style="display:inline-block;padding:2px 8px;border-radius:99px;
                                     font-size:10px;font-weight:500;background:#FAEEDA;color:#854F0B">
                            Bimbingan
                        </span>
                    @else
                        <span style="display:inline-block;padding:2px 8px;border-radius:99px;
                                     font-size:10px;font-weight:500;background:#FCEBEB;color:#A32D2D">
                            Tidak layak
                        </span>
                    @endif
                </td>

                <td style="text-align:center;padding:9px 12px">
                    <a href="/penilaian/{{ $item['siswa']->id }}/edit"
                       style="font-size:14px;color:#94a3b8;cursor:pointer">
                        <i class="ti ti-eye"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center;padding:48px;font-size:13px;color:#94a3b8">
                    <i class="ti ti-database-off" style="font-size:24px;display:block;margin-bottom:8px"></i>
                    Belum ada data penilaian
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection