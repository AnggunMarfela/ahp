@extends('layouts.app')
@section('page-title', 'Kelola Pengguna')
@section('page-subtitle', 'Manajemen akun pengguna sistem')

@section('content')

@if(session('success'))
<div style="margin-bottom:14px;padding:12px 16px;background:#EAF3DE;
            border:0.5px solid #97C459;border-radius:10px;
            font-size:13px;color:#3B6D11;display:flex;align-items:center;gap:8px">
    <i class="ti ti-circle-check" style="font-size:15px"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="margin-bottom:14px;padding:12px 16px;background:#FCEBEB;
            border:0.5px solid #F09595;border-radius:10px;
            font-size:13px;color:#A32D2D;display:flex;align-items:center;gap:8px">
    <i class="ti ti-alert-circle" style="font-size:15px"></i>
    {{ session('error') }}
</div>
@endif

<div style="background:white;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden">

    <div style="padding:14px 20px;border-bottom:0.5px solid #f1f5f9;
                display:flex;align-items:center;justify-content:space-between">
        <div>
            <p style="font-size:13px;font-weight:500;color:#1e293b">Daftar pengguna</p>
            <p style="font-size:11px;color:#94a3b8;margin-top:2px">
                {{ $penggunas->count() }} pengguna terdaftar
            </p>
        </div>
        <a href="{{ route('pengguna.create') }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;
                  background:#4F46E5;color:#fff;border-radius:8px;font-size:12px;
                  font-weight:500;text-decoration:none">
            <i class="ti ti-plus" style="font-size:14px"></i> Tambah pengguna
        </a>
    </div>

    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="background:#f8fafc;border-bottom:0.5px solid #e2e8f0">
                <th style="text-align:left;font-size:11px;font-weight:500;color:#94a3b8;padding:10px 20px">Nama</th>
                <th style="text-align:left;font-size:11px;font-weight:500;color:#94a3b8;padding:10px 12px">Email</th>
                <th style="text-align:center;font-size:11px;font-weight:500;color:#94a3b8;padding:10px 12px">Role</th>
                <th style="text-align:center;font-size:11px;font-weight:500;color:#94a3b8;padding:10px 20px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penggunas as $user)
            <tr style="border-bottom:0.5px solid #f1f5f9"
                onmouseover="this.style.background='#f8fafc'"
                onmouseout="this.style.background='white'">

                <td style="padding:12px 20px">
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="width:28px;height:28px;border-radius:50%;
                                    background:#EEEDFE;display:flex;align-items:center;
                                    justify-content:center;font-size:10px;font-weight:600;
                                    color:#3C3489;flex-shrink:0">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p style="font-size:12px;font-weight:500;color:#1e293b">
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                <span style="font-size:10px;color:#94a3b8;font-weight:400">(kamu)</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </td>

                <td style="padding:12px;font-size:12px;color:#475569">{{ $user->email }}</td>

                <td style="text-align:center;padding:12px">
                    @if($user->role === 'admin')
                        <span style="display:inline-block;padding:3px 10px;border-radius:99px;
                                     font-size:10px;font-weight:500;background:#EEEDFE;color:#3C3489">
                            Admin
                        </span>
                    @elseif($user->role === 'kepala_tk')
                        <span style="display:inline-block;padding:3px 10px;border-radius:99px;
                                     font-size:10px;font-weight:500;background:#FAEEDA;color:#854F0B">
                            Kepala TK
                        </span>
                    @else
                        <span style="display:inline-block;padding:3px 10px;border-radius:99px;
                                     font-size:10px;font-weight:500;background:#E1F5EE;color:#085041">
                            Guru
                        </span>
                    @endif
                </td>

                <td style="text-align:center;padding:12px 20px">
                    <div style="display:flex;align-items:center;justify-content:center;gap:6px">
                        <a href="{{ route('pengguna.edit', $user) }}"
                           style="display:inline-flex;align-items:center;gap:4px;
                                  padding:5px 10px;border:0.5px solid #c7d2fe;
                                  border-radius:7px;font-size:11px;font-weight:500;
                                  color:#4F46E5;text-decoration:none;background:#EEF2FF">
                            <i class="ti ti-edit" style="font-size:13px"></i> Edit
                        </a>

                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('pengguna.destroy', $user) }}"
                              onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="display:inline-flex;align-items:center;gap:4px;
                                           padding:5px 10px;border:0.5px solid #fca5a5;
                                           border-radius:7px;font-size:11px;font-weight:500;
                                           color:#A32D2D;background:#FCEBEB;cursor:pointer">
                                <i class="ti ti-trash" style="font-size:13px"></i> Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;padding:48px;font-size:13px;color:#94a3b8">
                    <i class="ti ti-users" style="font-size:28px;display:block;margin-bottom:8px"></i>
                    Belum ada pengguna
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection