{{-- resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AHP SD</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <div class="w-64 bg-white border-r border-slate-200 flex flex-col">

        <!-- BRAND -->
        <div class="p-6 border-b border-slate-200">

            <h1 class="text-lg font-bold text-slate-800">
                SPK Kesiapan Anak
            </h1>

            <p class="text-sm text-slate-500">
                Metode AHP
            </p>

        </div>

        <!-- MENU -->
        <div class="p-4 space-y-2 flex-1">

            <!-- DASHBOARD -->
            <a href="/dashboard"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition

               {{ request()->is('dashboard') 
                    ? 'bg-indigo-100 text-indigo-700 font-semibold'
                    : 'text-slate-600 hover:bg-slate-100'
               }}">

                <span>🏠</span>
                <span>Dashboard</span>

            </a>

            @if(auth()->user()->isAdmin())
<a href="/pengguna"
   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition
          {{ request()->is('pengguna*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
    <i class="ti ti-user text-base"></i>
    Pengguna
</a>
@endif

            <!-- SISWA -->
            <a href="/siswa"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition

               {{ request()->is('siswa*') 
                    ? 'bg-indigo-100 text-indigo-700 font-semibold'
                    : 'text-slate-600 hover:bg-slate-100'
               }}">

                <span>👦</span>
                <span>Data Siswa</span>

            </a>

            <!-- KRITERIA -->
            <a href="/kriteria"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition

               {{ request()->is('kriteria*') 
                    ? 'bg-indigo-100 text-indigo-700 font-semibold'
                    : 'text-slate-600 hover:bg-slate-100'
               }}">

                <span>📋</span>
                <span>Kriteria</span>

            </a>

            <!-- PENILAIAN -->
            <a href="/penilaian"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition

               {{ request()->is('penilaian*') 
                    ? 'bg-indigo-100 text-indigo-700 font-semibold'
                    : 'text-slate-600 hover:bg-slate-100'
               }}">

                <span>📝</span>
                <span>Penilaian</span>

            </a>

            <!-- AHP -->
            <a href="/ahp"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition

               {{ request()->is('ahp*') 
                    ? 'bg-indigo-100 text-indigo-700 font-semibold'
                    : 'text-slate-600 hover:bg-slate-100'
               }}">

                <span>📊</span>
                <span>Hasil AHP</span>

            </a>

            <!-- RANKING -->
            <a href="/ranking"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition

               {{ request()->is('ranking*') 
                    ? 'bg-indigo-100 text-indigo-700 font-semibold'
                    : 'text-slate-600 hover:bg-slate-100'
               }}">

                <span>🏆</span>
                <span>Ranking</span>

            </a>

        </div>

        <!-- USER -->
        <div class="p-4 border-t border-slate-200">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-700">
                    A
                </div>

                <div>

                    <p class="font-semibold text-sm text-slate-700">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-slate-500">
                        Administrator
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- MAIN -->
    <div class="flex-1">

        <!-- TOPBAR -->
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex justify-between items-center">

            <h2 class="text-xl font-bold text-slate-800">
                Dashboard
            </h2>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                    Logout
                </button>

            </form>

        </div>

        <!-- CONTENT -->
        <div class="p-8">

            @yield('content')

        </div>

    </div>

</div>

</body>
</html>