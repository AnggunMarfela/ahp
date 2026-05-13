@extends('layouts.guest')

@section('content')

<div class="min-h-screen flex items-center justify-center
            bg-gradient-to-br from-indigo-100 via-white to-blue-100 px-4">

    <div class="w-full max-w-md">

        <!-- CARD -->
        <div class="bg-white rounded-[32px] shadow-2xl border border-slate-100 overflow-hidden">

            <!-- HEADER -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 p-8 text-center">

                <div class="w-24 h-24 bg-white/20 backdrop-blur
                            rounded-full flex items-center justify-center
                            mx-auto mb-4 border border-white/30">

                    <i class="ti ti-user-plus text-white text-5xl"></i>

                </div>

                <h1 class="text-3xl font-bold text-white">

                    Daftar Akun

                </h1>

                <p class="text-indigo-100 mt-2 text-sm">

                    Buat akun admin baru

                </p>

            </div>

            <!-- FORM -->
            <div class="p-8">

                <form method="POST" action="{{ route('register') }}">

                    @csrf

                    <!-- NAME -->
                    <div class="mb-5">

                        <label class="block text-sm font-semibold text-slate-700 mb-2">

                            Nama

                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autofocus

                               class="w-full px-4 py-3 rounded-2xl
                                      border border-slate-300
                                      focus:outline-none
                                      focus:ring-2
                                      focus:ring-indigo-500">

                        @error('name')

                            <p class="text-red-500 text-xs mt-2">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>

                    <!-- EMAIL -->
                    <div class="mb-5">

                        <label class="block text-sm font-semibold text-slate-700 mb-2">

                            Email

                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required

                               class="w-full px-4 py-3 rounded-2xl
                                      border border-slate-300
                                      focus:outline-none
                                      focus:ring-2
                                      focus:ring-indigo-500">

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

                        <input type="password"
                               name="password"
                               required

                               class="w-full px-4 py-3 rounded-2xl
                                      border border-slate-300
                                      focus:outline-none
                                      focus:ring-2
                                      focus:ring-indigo-500">

                        @error('password')

                            <p class="text-red-500 text-xs mt-2">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>

                    <!-- KONFIRMASI PASSWORD -->
                    <div class="mb-6">

                        <label class="block text-sm font-semibold text-slate-700 mb-2">

                            Konfirmasi Password

                        </label>

                        <input type="password"
                               name="password_confirmation"
                               required

                               class="w-full px-4 py-3 rounded-2xl
                                      border border-slate-300
                                      focus:outline-none
                                      focus:ring-2
                                      focus:ring-indigo-500">

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

    DAFTAR

</button>

                </form>

                <!-- LOGIN -->
                <div class="mt-6 text-center">

                    <p class="text-sm text-slate-500">

                        Sudah punya akun?

                        <a href="{{ route('login') }}"
                           class="text-indigo-600 hover:text-indigo-700 font-semibold">

                            Login

                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection