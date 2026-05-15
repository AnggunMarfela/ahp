@extends('layouts.app')
@section('page-title', 'Edit Pengguna')
@section('page-subtitle', 'Ubah data akun pengguna')

@section('content')
<div style="max-width:480px">
<div style="background:white;border:0.5px solid #e2e8f0;border-radius:12px;padding:20px">

    @if($errors->any())
    <div style="margin-bottom:14px;padding:12px 14px;background:#FCEBEB;
                border:0.5px solid #F09595;border-radius:8px;font-size:12px;color:#A32D2D">
        <ul style="list-style:none;display:flex;flex-direction:column;gap:4px">
            @foreach($errors->all() as $e)
            <li style="display:flex;align-items:center;gap:6px">
                <i class="ti ti-point" style="font-size:8px"></i> {{ $e }}
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('pengguna.update', $pengguna) }}"
          style="display:flex;flex-direction:column;gap:14px">
        @csrf @method('PUT')

        <div>
            <label style="display:block;font-size:12px;font-weight:500;
                          color:#475569;margin-bottom:5px">Nama lengkap</label>
            <input type="text" name="name"
                   value="{{ old('name', $pengguna->name) }}"
                   style="width:100%;border:0.5px solid #e2e8f0;
                          border-radius:8px;padding:8px 12px;font-size:13px;color:#1e293b"
                   required>
        </div>

        <div>
            <label style="display:block;font-size:12px;font-weight:500;
                          color:#475569;margin-bottom:5px">Email</label>
            <input type="email" name="email"
                   value="{{ old('email', $pengguna->email) }}"
                   style="width:100%;border:0.5px solid #e2e8f0;
                          border-radius:8px;padding:8px 12px;font-size:13px;color:#1e293b"
                   required>
        </div>

        <div>
            <label style="display:block;font-size:12px;font-weight:500;
                          color:#475569;margin-bottom:5px">Role</label>
            <select name="role"
                    style="width:100%;border:0.5px solid #e2e8f0;
                           border-radius:8px;padding:8px 12px;font-size:13px;
                           color:#1e293b;background:white"
                    {{ $pengguna->id === auth()->id() ? 'disabled' : '' }}>
                <option value="admin"     {{ old('role', $pengguna->role) === 'admin'     ? 'selected' : '' }}>Admin</option>
                <option value="guru"      {{ old('role', $pengguna->role) === 'guru'      ? 'selected' : '' }}>Guru / Wali Kelas</option>
                <option value="kepala_tk" {{ old('role', $pengguna->role) === 'kepala_tk' ? 'selected' : '' }}>Kepala TK</option>
            </select>
            @if($pengguna->id === auth()->id())
            <input type="hidden" name="role" value="{{ $pengguna->role }}">
            <p style="font-size:11px;color:#94a3b8;margin-top:4px">
                Tidak bisa mengubah role akun sendiri.
            </p>
            @endif
        </div>

        <div>
            <label style="display:block;font-size:12px;font-weight:500;
                          color:#475569;margin-bottom:5px">
                Password baru
                <span style="font-weight:400;color:#94a3b8">(kosongkan jika tidak diubah)</span>
            </label>
            <input type="password" name="password"
                   placeholder="Min. 8 karakter, huruf + angka"
                   style="width:100%;border:0.5px solid #e2e8f0;
                          border-radius:8px;padding:8px 12px;font-size:13px;color:#1e293b">
        </div>

        <div>
            <label style="display:block;font-size:12px;font-weight:500;
                          color:#475569;margin-bottom:5px">Konfirmasi password baru</label>
            <input type="password" name="password_confirmation"
                   placeholder="Ulangi password baru"
                   style="width:100%;border:0.5px solid #e2e8f0;
                          border-radius:8px;padding:8px 12px;font-size:13px;color:#1e293b">
        </div>

        <div style="display:flex;gap:8px;padding-top:4px">
            <button type="submit"
                    style="flex:1;padding:9px;background:#4F46E5;color:#fff;border:none;
                           border-radius:8px;font-size:13px;font-weight:500;cursor:pointer">
                Perbarui
            </button>
            <a href="{{ route('pengguna.index') }}"
               style="flex:1;padding:9px;border:0.5px solid #e2e8f0;border-radius:8px;
                      font-size:13px;color:#64748b;text-decoration:none;text-align:center">
                Batal
            </a>
        </div>

    </form>
</div>
</div>
@endsection