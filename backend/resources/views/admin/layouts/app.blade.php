<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Админ-панель') — Kretmann & Roskarniz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .sidebar-link { transition: all 0.2s; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(255,255,255,0.1); color: #fff; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-stone-900 text-stone-300 flex flex-col shrink-0">
            <div class="px-6 py-5 border-b border-stone-800">
                <div class="text-lg font-bold tracking-widest uppercase text-stone-100">K&R Admin</div>
                <div class="text-xs text-stone-500 mt-1">Kretmann & Roskarniz</div>
            </div>
            <nav class="flex-1 px-3 py-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded text-sm {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="text-base">&#9632;</span> Дашборд
                </a>
                <a href="{{ route('admin.orders.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded text-sm {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <span class="text-base">&#9993;</span> Заказы
                </a>
                <a href="{{ route('admin.categories.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded text-sm {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <span class="text-base">&#9776;</span> Категории
                </a>
                <a href="{{ route('admin.products.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded text-sm {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <span class="text-base">&#9733;</span> Продукты
                </a>
                <a href="{{ route('admin.profiles.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded text-sm {{ request()->routeIs('admin.profiles.*') ? 'active' : '' }}">
                    <span class="text-base">&#9608;</span> Профили
                </a>
                <a href="{{ route('admin.materials.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded text-sm {{ request()->routeIs('admin.materials.*') ? 'active' : '' }}">
                    <span class="text-base">&#9673;</span> Материалы
                </a>
                <a href="{{ route('admin.automation-options.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded text-sm {{ request()->routeIs('admin.automation-options.*') ? 'active' : '' }}">
                    <span class="text-base">&#9881;</span> Автоматика
                </a>
                <a href="{{ route('admin.configurations.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded text-sm {{ request()->routeIs('admin.configurations.*') ? 'active' : '' }}">
                    <span class="text-base">&#9878;</span> Конфигурации
                </a>
            </nav>
            <div class="px-6 py-4 border-t border-stone-800">
                <a href="/" class="text-xs text-stone-500 hover:text-stone-300 transition-colors">&#8592; На сайт</a>
            </div>
        </aside>

        <main class="flex-1 flex flex-col">
            <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Админ-панель')</h1>
                <div class="flex items-center gap-4">
                    @if(session('success'))
                        <span class="text-sm text-green-600 bg-green-50 px-3 py-1 rounded">{{ session('success') }}</span>
                    @endif
                </div>
            </header>

            <div class="flex-1 p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
