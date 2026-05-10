@extends('layouts.app')
@section('page-title', 'AHP')
@section('page-subtitle', 'Matriks perbandingan berpasangan dan perhitungan bobot')

@section('content')

@if(session('success'))
<div style="margin-bottom:16px;padding:12px 16px;background:#EAF3DE;border:0.5px solid #97C459;
            border-radius:10px;font-size:13px;color:#3B6D11;display:flex;align-items:center;gap:8px">
    <i class="ti ti-circle-check" style="font-size:16px"></i> {{ session('success') }}
</div>
@endif

@if(session('warning'))
<div style="margin-bottom:16px;padding:12px 16px;background:#FAEEDA;border:0.5px solid #EF9F27;
            border-radius:10px;font-size:13px;color:#854F0B;display:flex;align-items:center;gap:8px">
    <i class="ti ti-alert-triangle" style="font-size:16px"></i> {{ session('warning') }}
</div>
@endif

@if($kriterias->isEmpty())
<div style="padding:20px;background:#FAEEDA;border:0.5px solid #EF9F27;border-radius:10px;
            font-size:13px;color:#854F0B">
    <i class="ti ti-alert-triangle"></i>
    Tambahkan kriteria terlebih dahulu.
    <a href="{{ route('kriteria.create') }}" style="color:#854F0B;font-weight:500;text-decoration:underline">
        Tambah kriteria
    </a>
</div>
@else

{{-- FORM MATRIKS PCM --}}
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-4">
    <div style="padding:14px 20px;border-bottom:0.5px solid #f1f5f9;
                display:flex;align-items:center;justify-content:space-between">
        <div>
            <p style="font-size:13px;font-weight:500;color:#1e293b">Matriks perbandingan berpasangan</p>
            <p style="font-size:11px;color:#94a3b8;margin-top:2px">
                Isi nilai skala Saaty 1–9. Nilai kebalikan dihitung otomatis.
            </p>
        </div>
        <div style="font-size:11px;color:#94a3b8">Skala: 1 = sama penting, 9 = mutlak lebih penting</div>
    </div>

    <form method="POST" action="{{ route('ahp.simpan') }}" style="padding:20px">
        @csrf
        <div style="overflow-x:auto">
        <table style="border-collapse:collapse;font-size:12px">
            <thead>
                <tr>
                    <th style="padding:8px 12px;background:#f8fafc;border:0.5px solid #e2e8f0;
                                font-size:11px;font-weight:500;color:#94a3b8;min-width:140px">
                        Kriteria
                    </th>
                    @foreach($kriterias as $k)
                    <th style="padding:8px 12px;background:#f8fafc;border:0.5px solid #e2e8f0;
                                font-size:11px;font-weight:500;color:#1e293b;text-align:center;min-width:80px">
                        <span style="display:inline-flex;padding:2px 8px;border-radius:99px;
                                     {{ $k->kode_kriteria === 'C3' ? 'background:#FAEEDA;color:#854F0B' : 'background:#EEEDFE;color:#3C3489' }}">
                            {{ $k->kode_kriteria }}
                        </span>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($kriterias as $i => $k1)
                <tr>
                    <td style="padding:8px 12px;border:0.5px solid #e2e8f0;
                                background:#f8fafc;font-size:11px;font-weight:500;color:#1e293b">
                        <span style="display:inline-flex;padding:2px 8px;border-radius:99px;margin-right:4px;
                                     {{ $k1->kode_kriteria === 'C3' ? 'background:#FAEEDA;color:#854F0B' : 'background:#EEEDFE;color:#3C3489' }}">
                            {{ $k1->kode_kriteria }}
                        </span>
                        {{ $k1->nama_kriteria }}
                    </td>

                    @foreach($kriterias as $j => $k2)
                    @php
                        $existing = $perbandingan->first(fn($p) =>
                            $p->kriteria_1 === $k1->id && $p->kriteria_2 === $k2->id
                        );
                    @endphp
                    <td style="padding:6px 8px;border:0.5px solid #e2e8f0;text-align:center">
                        @if($k1->id === $k2->id)
                            <span style="font-size:13px;font-weight:600;color:#94a3b8">1</span>
                        @elseif($i < $j)
                            <input type="number"
                                   name="nilai_{{ $k1->id }}_{{ $k2->id }}"
                                   value="{{ $existing ? number_format($existing->nilai, 3, '.', '') : '' }}"
                                   min="1" max="9" step="1"
                                   placeholder="1-9"
                                   style="width:60px;border:0.5px solid #e2e8f0;border-radius:6px;
                                          padding:5px 4px;font-size:12px;text-align:center;
                                          color:#1e293b;background:white"
                                   required>
                        @else
                            @php
                                $balik = $perbandingan->first(fn($p) =>
                                    $p->kriteria_1 === $k1->id && $p->kriteria_2 === $k2->id
                                );
                            @endphp
                            <span style="font-size:11px;color:#94a3b8">
                                {{ $balik ? number_format($balik->nilai, 3) : '1/n' }}
                            </span>
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>

        <div style="margin-top:16px">
            <button type="submit"
                    style="padding:8px 20px;background:#4F46E5;color:#fff;border:none;
                           border-radius:8px;font-size:12px;font-weight:500;cursor:pointer">
                <i class="ti ti-calculator" style="font-size:13px;vertical-align:-2px;margin-right:4px"></i>
                Simpan & hitung bobot
            </button>
        </div>
    </form>
</div>

{{-- HASIL AHP --}}
@if($hasil)
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">

    {{-- Bobot prioritas --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div style="padding:14px 20px;border-bottom:0.5px solid #f1f5f9">
            <p style="font-size:13px;font-weight:500;color:#1e293b">Bobot prioritas kriteria</p>
        </div>
        <div style="padding:16px 20px;display:flex;flex-direction:column;gap:12px">
            @foreach($hasil['kriteria'] as $k)
            @php $isUtama = $k->kode_kriteria === 'C3'; @endphp
            <div style="display:flex;align-items:center;gap:10px">
                <span style="font-size:11px;font-weight:500;width:130px;flex-shrink:0;color:#475569">
                    {{ $k->kode_kriteria }} — {{ $k->nama_kriteria }}
                </span>
                <div style="flex:1;height:6px;background:#f1f5f9;border-radius:99px;overflow:hidden">
                    <div style="height:100%;border-radius:99px;
                                width:{{ round($hasil['bobot'][$k->id] * 100) }}%;
                                background:{{ $isUtama ? '#BA7517' : '#534AB7' }}">
                    </div>
                </div>
                <span style="font-size:12px;font-weight:600;width:50px;text-align:right;
                             color:{{ $isUtama ? '#854F0B' : '#3C3489' }}">
                    {{ round($hasil['bobot'][$k->id] * 100, 1) }}%
                </span>
                <span style="font-size:11px;color:#94a3b8;width:54px;text-align:right">
                    {{ number_format($hasil['bobot'][$k->id], 4) }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Uji konsistensi --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div style="padding:14px 20px;border-bottom:0.5px solid #f1f5f9">
            <p style="font-size:13px;font-weight:500;color:#1e293b">Uji konsistensi</p>
        </div>
        <div style="padding:16px 20px">
            <table style="width:100%;border-collapse:collapse;font-size:12px">
                <tr style="border-bottom:0.5px solid #f1f5f9">
                    <td style="padding:8px 0;color:#64748b">Jumlah kriteria (n)</td>
                    <td style="padding:8px 0;text-align:right;font-weight:500;color:#1e293b">
                        {{ $hasil['n'] }}
                    </td>
                </tr>
                <tr style="border-bottom:0.5px solid #f1f5f9">
                    <td style="padding:8px 0;color:#64748b">λ max (Eigen maksimum)</td>
                    <td style="padding:8px 0;text-align:right;font-weight:500;color:#1e293b">
                        {{ number_format($hasil['lambdaMax'], 4) }}
                    </td>
                </tr>
                <tr style="border-bottom:0.5px solid #f1f5f9">
                    <td style="padding:8px 0;color:#64748b">CI (Consistency Index)</td>
                    <td style="padding:8px 0;text-align:right;font-weight:500;color:#1e293b">
                        {{ number_format($hasil['ci'], 4) }}
                    </td>
                </tr>
                <tr style="border-bottom:0.5px solid #f1f5f9">
                    <td style="padding:8px 0;color:#64748b">RI (Random Index, n={{ $hasil['n'] }})</td>
                    <td style="padding:8px 0;text-align:right;font-weight:500;color:#1e293b">
                        {{ $hasil['ri'] }}
                    </td>
                </tr>
                <tr style="border-bottom:0.5px solid #f1f5f9">
                    <td style="padding:8px 0;color:#64748b">CR = CI / RI</td>
                    <td style="padding:8px 0;text-align:right;font-weight:600;
                               color:{{ $hasil['konsisten'] ? '#3B6D11' : '#A32D2D' }}">
                        {{ number_format($hasil['cr'], 4) }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px 0;color:#64748b">Status</td>
                    <td style="padding:10px 0;text-align:right">
                        @if($hasil['konsisten'])
                        <span style="display:inline-flex;align-items:center;gap:4px;
                                     padding:4px 10px;border-radius:99px;font-size:11px;
                                     font-weight:500;background:#EAF3DE;color:#3B6D11">
                            <i class="ti ti-circle-check" style="font-size:13px"></i>
                            Konsisten (CR ≤ 0.1)
                        </span>
                        @else
                        <span style="display:inline-flex;align-items:center;gap:4px;
                                     padding:4px 10px;border-radius:99px;font-size:11px;
                                     font-weight:500;background:#FCEBEB;color:#A32D2D">
                            <i class="ti ti-alert-circle" style="font-size:13px"></i>
                            Tidak konsisten (CR > 0.1)
                        </span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

</div>

{{-- Tabel normalisasi --}}
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div style="padding:14px 20px;border-bottom:0.5px solid #f1f5f9">
        <p style="font-size:13px;font-weight:500;color:#1e293b">Tabel normalisasi matriks</p>
        <p style="font-size:11px;color:#94a3b8;margin-top:2px">
            Setiap elemen dibagi jumlah kolom, bobot = rata-rata baris
        </p>
    </div>
    <div style="overflow-x:auto;padding:0 0 4px">
    <table style="border-collapse:collapse;font-size:11px;width:100%">
        <thead>
            <tr style="background:#f8fafc">
                <th style="padding:8px 16px;border:0.5px solid #e2e8f0;font-weight:500;
                            color:#94a3b8;text-align:left">Kriteria</th>
                @foreach($hasil['kriteria'] as $k)
                <th style="padding:8px 12px;border:0.5px solid #e2e8f0;font-weight:500;
                            color:#1e293b;text-align:center">{{ $k->kode_kriteria }}</th>
                @endforeach
                <th style="padding:8px 12px;border:0.5px solid #e2e8f0;font-weight:600;
                            color:#4F46E5;text-align:center;background:#EEEDFE">Bobot</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil['kriteria'] as $k1)
            <tr style="{{ $k1->kode_kriteria === 'C3' ? 'background:#FFFDF7' : '' }}">
                <td style="padding:8px 16px;border:0.5px solid #e2e8f0;font-weight:500;color:#1e293b">
                    {{ $k1->kode_kriteria }} — {{ $k1->nama_kriteria }}
                </td>
                @foreach($hasil['kriteria'] as $k2)
                <td style="padding:8px 12px;border:0.5px solid #e2e8f0;text-align:center;color:#475569">
                    {{ number_format($hasil['normalisasi'][$k1->id][$k2->id], 4) }}
                </td>
                @endforeach
                <td style="padding:8px 12px;border:0.5px solid #e2e8f0;text-align:center;
                            font-weight:600;color:#4F46E5;background:#EEEDFE">
                    {{ number_format($hasil['bobot'][$k1->id], 4) }}
                </td>
            </tr>
            @endforeach
            <tr style="background:#f8fafc">
                <td style="padding:8px 16px;border:0.5px solid #e2e8f0;font-weight:500;
                            color:#94a3b8;font-size:10px">Jumlah kolom</td>
                @foreach($hasil['kriteria'] as $k)
                <td style="padding:8px 12px;border:0.5px solid #e2e8f0;text-align:center;
                            font-weight:500;color:#64748b">
                    {{ number_format($hasil['jumlahKolom'][$k->id], 4) }}
                </td>
                @endforeach
                <td style="padding:8px 12px;border:0.5px solid #e2e8f0;text-align:center;
                            font-weight:600;color:#3B6D11;background:#EAF3DE">
                    {{ number_format(array_sum($hasil['bobot']), 4) }}
                </td>
            </tr>
        </tbody>
    </table>
    </div>
</div>
@endif

@endif
@endsection