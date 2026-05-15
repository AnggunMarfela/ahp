@extends('layouts.app')
@section('page-title', 'Tambah Pengguna')
@section('page-subtitle', 'Daftarkan akun pengguna baru')

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

    <form method="POST" action="{{ route('pengguna.store') }}"
          style="display:flex;flex-direction:column;gap:14px">
        @csrf

        <div>
            <label style="display:block;font-size:12px;font-weight:500;
                          color:#475569;margin-bottom:5px">Nama lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   placeholder="Masukkan nama lengkap"
                   style="width:100%;border:0.5px solid {{ $errors->has('name') ? '#E24B4A' : '#e2e8f0' }};
                          border-radius:8px;padding:8px 12px;font-size:13px;color:#1e293b"
                   required>
        </div>

        <div>
            <label style="display:block;font-size:12px;font-weight:500;
                          color:#475569;margin-bottom:5px">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   placeholder="contoh@email.com"
                   style="width:100%;border:0.5px solid {{ $errors->has('email') ? '#E24B4A' : '#e2e8f0' }};
                          border-radius:8px;padding:8px 12px;font-size:13px;color:#1e293b"
                   required>
        </div>

        <div>
            <label style="display:block;font-size:12px;font-weight:500;
                          color:#475569;margin-bottom:5px">Role</label>
            <select name="role"
                    style="width:100%;border:0.5px solid {{ $errors->has('role') ? '#E24B4A' : '#e2e8f0' }};
                           border-radius:8px;padding:8px 12px;font-size:13px;color:#1e293b;background:white"
                    required>
                <option value="">-- Pilih role --</option>
                <option value="admin"     {{ old('role') === 'admin'     ? 'selected' : '' }}>Admin</option>
                <option value="guru"      {{ old('role') === 'guru'      ? 'selected' : '' }}>Guru / Wali Kelas</option>
                <option value="kepala_tk" {{ old('role') === 'kepala_tk' ? 'selected' : '' }}>Kepala TK</option>
            </select>
        </div>

        <div>
            <label style="display:block;font-size:12px;font-weight:500;
                          color:#475569;margin-bottom:5px">Password</label>
            <input type="password" name="password"
                   placeholder="Min. 8 karakter, huruf + angka"
                   style="width:100%;border:0.5px solid {{ $errors->has('password') ? '#E24B4A' : '#e2e8f0' }};
                          border-radius:8px;padding:8px 12px;font-size:13px;color:#1e293b"
                   required>
        </div>

        <div>
            <label style="display:block;font-size:12px;font-weight:500;
                          color:#475569;margin-bottom:5px">Konfirmasi password</label>
            <input type="password" name="password_confirmation"
                   placeholder="Ulangi password"
                   style="width:100%;border:0.5px solid #e2e8f0;
                          border-radius:8px;padding:8px 12px;font-size:13px;color:#1e293b"
                   required>
        </div>

        <div style="display:flex;gap:8px;padding-top:4px">
            <button type="submit"
                    style="flex:1;padding:9px;background:#4F46E5;color:#fff;border:none;
                           border-radius:8px;font-size:13px;font-weight:500;cursor:pointer">
                Simpan pengguna
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