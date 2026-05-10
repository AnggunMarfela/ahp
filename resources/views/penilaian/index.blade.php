@extends('layouts.app')
@section('page-title', 'Penilaian')
@section('page-subtitle', 'Input nilai semua siswa per kriteria')

@section('content')

@if(session('success'))
<div style="margin-bottom:16px;padding:12px 16px;background:#EAF3DE;border:0.5px solid #97C459;
            border-radius:10px;font-size:13px;color:#3B6D11;display:flex;align-items:center;gap:8px">
    <i class="ti ti-circle-check" style="font-size:16px"></i>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">

    {{-- Header --}}
    <div style="padding:14px 20px;border-bottom:0.5px solid #f1f5f9;
                display:flex;align-items:center;justify-content:space-between">
        <div>
            <p style="font-size:13px;font-weight:500;color:#1e293b">Input penilaian siswa</p>
            <p style="font-size:11px;color:#94a3b8;margin-top:2px">
                Isi nilai 0–100 untuk setiap kriteria. Skor AHP dihitung otomatis.
            </p>
        </div>
        <div style="display:flex;align-items:center;gap:6px">
            <span style="font-size:10px;color:#94a3b8">{{ $siswas->count() }} siswa</span>
            <span style="width:1px;height:14px;background:#e2e8f0"></span>
            <span style="font-size:10px;color:#94a3b8">{{ $kriterias->count() }} kriteria</span>
        </div>
    </div>

    <form method="POST" action="{{ route('penilaian.store') }}" id="form-penilaian">
    @csrf

    <div style="overflow-x:auto">
    <table style="width:100%;border-collapse:collapse;min-width:700px">
        <thead>
            <tr style="background:#f8fafc;border-bottom:0.5px solid #e2e8f0">

                {{-- Kolom nama --}}
                <th style="text-align:left;font-size:11px;font-weight:500;color:#94a3b8;
                            padding:10px 20px;width:200px;position:sticky;left:0;background:#f8fafc">
                    Nama siswa
                </th>

                {{-- Kolom per kriteria --}}
                @foreach($kriterias as $k)
                @php $isUtama = $k->kode_kriteria === 'C3'; @endphp
                <th style="text-align:center;font-size:11px;font-weight:500;color:#94a3b8;
                            padding:10px 12px;min-width:120px">
                    <div style="display:inline-flex;padding:2px 8px;border-radius:99px;
                                font-size:10px;font-weight:500;margin-bottom:3px;
                                {{ $isUtama ? 'background:#FAEEDA;color:#854F0B' : 'background:#EEEDFE;color:#3C3489' }}">
                        {{ $k->kode_kriteria }}
                    </div>
                    <div style="font-size:11px;color:#475569;font-weight:500">
                        {{ $k->nama_kriteria }}
                    </div>
                    <div style="font-size:10px;color:#94a3b8;margin-top:1px">
                        bobot {{ $k->bobot ? round($k->bobot * 100, 1) . '%' : '-' }}
                    </div>
                </th>
                @endforeach

                {{-- Kolom skor --}}
                <th style="text-align:center;font-size:11px;font-weight:500;color:#94a3b8;
                            padding:10px 12px;min-width:100px">
                    Skor AHP
                </th>

                {{-- Kolom status --}}
                <th style="text-align:center;font-size:11px;font-weight:500;color:#94a3b8;
                            padding:10px 12px;min-width:100px">
                    Status
                </th>

            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $siswa)
            <tr style="border-bottom:0.5px solid #f1f5f9" class="hover:bg-slate-50 transition"
                data-siswa="{{ $siswa->id }}">

                {{-- Nama siswa --}}
                <td style="padding:12px 20px;position:sticky;left:0;background:white">
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="width:28px;height:28px;border-radius:50%;background:#EEEDFE;
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:10px;font-weight:600;color:#3C3489;flex-shrink:0">
                            {{ strtoupper(substr($siswa->nama_siswa, 0, 2)) }}
                        </div>
                        <div>
                            <p style="font-size:12px;font-weight:500;color:#1e293b">
                                {{ $siswa->nama_siswa }}
                            </p>
                            <p style="font-size:10px;color:#94a3b8">
                                {{ $siswa->umur }} th
                            </p>
                        </div>
                    </div>
                </td>

                {{-- Input per kriteria --}}
                @foreach($kriterias as $k)
                @php
                    $existing = $siswa->penilaians->firstWhere('kriteria_id', $k->id);
                    $nilaiLama = $existing ? $existing->nilai : '';
                    $isUtama = $k->kode_kriteria === 'C3';
                @endphp
                <td style="padding:10px 12px;text-align:center">
                    <input type="number"
                           name="nilai[{{ $siswa->id }}][{{ $k->id }}]"
                           id="inp_{{ $siswa->id }}_{{ $k->id }}"
                           value="{{ old("nilai.{$siswa->id}.{$k->id}", $nilaiLama) }}"
                           min="0" max="100" step="1"
                           placeholder="–"
                           data-siswa="{{ $siswa->id }}"
                           data-bobot="{{ $k->bobot ?? 0 }}"
                           oninput="hitungBaris({{ $siswa->id }})"
                           style="width:68px;border:0.5px solid {{ $isUtama ? '#EF9F27' : '#e2e8f0' }};
                                  border-radius:8px;padding:6px 4px;font-size:12px;
                                  text-align:center;color:#1e293b;background:white"
                           required>
                </td>
                @endforeach

                {{-- Skor AHP --}}
                <td style="text-align:center;padding:10px 12px">
                    <span id="skor_{{ $siswa->id }}"
                          style="font-size:13px;font-weight:600;color:#94a3b8">
                        @php
                            $skorAwal = 0;
                            $allFilled = true;
                            foreach($kriterias as $k) {
                                $p = $siswa->penilaians->firstWhere('kriteria_id', $k->id);
                                if ($p && $k->bobot) $skorAwal += ($p->nilai / 100) * $k->bobot;
                                else $allFilled = false;
                            }
                        @endphp
                        {{ $allFilled ? number_format($skorAwal, 3) : '–' }}
                    </span>
                </td>

                {{-- Status --}}
                <td style="text-align:center;padding:10px 12px">
                    @php
                        $statusAwal = '';
                        $bgAwal = '#f1f5f9'; $clrAwal = '#94a3b8';
                        if ($allFilled) {
                            if ($skorAwal >= 0.75) { $statusAwal = 'Layak'; $bgAwal = '#EAF3DE'; $clrAwal = '#3B6D11'; }
                            elseif ($skorAwal >= 0.50) { $statusAwal = 'Bimbingan'; $bgAwal = '#FAEEDA'; $clrAwal = '#854F0B'; }
                            else { $statusAwal = 'Tidak layak'; $bgAwal = '#FCEBEB'; $clrAwal = '#A32D2D'; }
                        }
                    @endphp
                    <span id="status_{{ $siswa->id }}"
                          style="display:inline-flex;padding:2px 8px;border-radius:99px;
                                 font-size:10px;font-weight:500;
                                 background:{{ $bgAwal }};color:{{ $clrAwal }}">
                        {{ $statusAwal ?: '–' }}
                    </span>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    {{-- Footer tombol --}}
    <div style="padding:14px 20px;border-top:0.5px solid #f1f5f9;background:#f8fafc;
                display:flex;align-items:center;justify-content:space-between">
        <p style="font-size:11px;color:#94a3b8">
            <i class="ti ti-info-circle" style="font-size:13px;vertical-align:-2px"></i>
            Layak ≥ 0.75 &nbsp;&middot;&nbsp; Bimbingan 0.50–0.74 &nbsp;&middot;&nbsp; Tidak layak &lt; 0.50
        </p>
        <div style="display:flex;gap:8px">
            <a href="{{ route('penilaian.index') }}"
               style="padding:7px 16px;border:0.5px solid #e2e8f0;border-radius:8px;
                      font-size:12px;color:#64748b;text-decoration:none">
                Batal
            </a>
            <button type="submit"
                    style="padding:7px 20px;background:#4F46E5;color:#fff;border:none;
                           border-radius:8px;font-size:12px;font-weight:500;cursor:pointer">
                <i class="ti ti-device-floppy" style="font-size:13px;vertical-align:-2px;margin-right:4px"></i>
                Simpan semua penilaian
            </button>
        </div>
    </div>

    </form>
</div>

<script>
const bobots = @json($kriterias->pluck('bobot', 'id'));

function hitungBaris(siswaId) {
    const inputs = document.querySelectorAll(`input[data-siswa="${siswaId}"]`);
    let total = 0;
    let allFilled = true;

    inputs.forEach(inp => {
        const v = parseFloat(inp.value);
        const b = parseFloat(inp.dataset.bobot) || 0;
        if (inp.value === '' || isNaN(v)) { allFilled = false; return; }
        total += (Math.min(100, Math.max(0, v)) / 100) * b;
    });

    const skorEl  = document.getElementById('skor_'  + siswaId);
    const statEl  = document.getElementById('status_'+ siswaId);

    if (!allFilled) {
        skorEl.textContent = '–';
        skorEl.style.color = '#94a3b8';
        statEl.textContent = '–';
        statEl.style.background = '#f1f5f9';
        statEl.style.color = '#94a3b8';
        return;
    }

    skorEl.textContent = total.toFixed(3);

    let label, bg, color;
    if (total >= 0.75) {
        label = 'Layak'; bg = '#EAF3DE'; color = '#3B6D11';
    } else if (total >= 0.50) {
        label = 'Bimbingan'; bg = '#FAEEDA'; color = '#854F0B';
    } else {
        label = 'Tidak layak'; bg = '#FCEBEB'; color = '#A32D2D';
    }

    skorEl.style.color      = color;
    statEl.textContent      = label;
    statEl.style.background = bg;
    statEl.style.color      = color;
}
</script>

@endsection