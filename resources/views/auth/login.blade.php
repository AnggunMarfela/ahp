@extends('layouts.guest')

@section('content')

<div class="min-h-screen flex items-center justify-center
            bg-gradient-to-br from-indigo-100 via-white to-blue-100 px-4">

    <div class="w-full max-w-md">

        <!-- CARD LOGIN -->
        <div class="bg-white rounded-[32px] shadow-2xl border border-slate-100 overflow-hidden">

            <!-- TOP -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 p-8 text-center">

                <div class="w-24 h-24 bg-white/20 backdrop-blur
                            rounded-full flex items-center justify-center
                            mx-auto mb-4 border border-white/30">

                    <i class="ti ti-school text-white text-5xl"></i>

                </div>

                <h1 class="text-3xl font-bold text-white">

                    SPK Kesiapan SD

                </h1>

                <p class="text-indigo-100 mt-2 text-sm">

                    Sistem Pendukung Keputusan Metode AHP

                </p>

            </div>

            <!-- FORM -->
            <div class="p-8">

                <!-- SESSION STATUS -->
                @if (session('status'))

                    <div class="mb-4 text-sm text-green-600">

                        {{ session('status') }}

                    </div>

                @endif

                <form method="POST" action="{{ route('login') }}">

                    @csrf

                    <!-- EMAIL -->
                    <div class="mb-5">

                        <label class="block text-sm font-semibold text-slate-700 mb-2">

                            Email

                        </label>

                        <div class="relative">

                            <span class="absolute left-4 top-3.5 text-slate-400">

                                <i class="ti ti-mail"></i>

                            </span>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   autocomplete="username"

                                   class="w-full pl-11 pr-4 py-3 rounded-2xl
                                          border border-slate-300
                                          focus:outline-none
                                          focus:ring-2
                                          focus:ring-indigo-500
                                          focus:border-indigo-500">

                        </div>

                        @error('email')

                            <p class="text-red-500 text-xs mt-2">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-5">

                        <label class="block text-sm font-semibold text-slate-700 mb-2">

                            Password

                        </label>

                        <div class="relative">

                            <span class="absolute left-4 top-3.5 text-slate-400">

                                <i class="ti ti-lock"></i>

                            </span>

                            <input type="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"

                                   class="w-full pl-11 pr-4 py-3 rounded-2xl
                                          border border-slate-300
                                          focus:outline-none
                                          focus:ring-2
                                          focus:ring-indigo-500
                                          focus:border-indigo-500">

                        </div>

                        @error('password')

                            <p class="text-red-500 text-xs mt-2">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>

                    <!-- REMEMBER -->
                    <div class="flex items-center justify-between mb-6">

                        <label class="flex items-center gap-2 text-sm text-slate-600">

                            <input type="checkbox"
                                   name="remember"
                                   class="rounded border-slate-300 text-indigo-600 shadow-sm">

                            Remember me

                        </label>

                    </div>

                    <!-- BUTTON -->
          <button type="submit"

    style="
        width:100%;
        background:linear-gradient(to right,#4f46e5,#3b82f6);
        color:white;
        font-size:18px;
        font-weight:700;
        padding:14px;
        border:none;
        border-radius:18px;
        margin-top:24px;
        cursor:pointer;
        box-shadow:0 10px 20px rgba(79,70,229,0.25);
    ">

    LOGIN

</button>
<!-- REGISTER -->
<div style="text-align:center;margin-top:20px;">

    <span style="font-size:14px;color:#64748b;">

        Belum punya akun?

    </span>

    <a href="{{ route('register') }}"
       style="
            color:#4f46e5;
            font-weight:600;
            text-decoration:none;
            margin-left:4px;
       ">

        Daftar

    </a>

</div>

                </form>

            </div>

        </div>

        <!-- FOOTER -->
        <p class="text-center text-xs text-slate-500 mt-6">

            © {{ date('Y') }} SPK Kesiapan Anak Masuk SD

        </p>

    </div>

</div>

@endsection