@extends('admin.layouts.app')

@section('title', 'Конфигурация #' . $configuration->id)

@section('content')
<div class="space-y-6 max-w-3xl">
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Профиль</h3>
        <dl class="grid grid-cols-2 gap-x-6 gap-y-3">
            <dt class="text-sm font-medium text-gray-500">Название</dt>
            <dd class="text-sm text-gray-900">{{ $configuration->profile->name ?? '—' }}</dd>
            <dt class="text-sm font-medium text-gray-500">Slug</dt>
            <dd class="text-sm text-gray-900">{{ $configuration->profile->slug ?? '—' }}</dd>
        </dl>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Размеры</h3>
        <dl class="grid grid-cols-2 gap-x-6 gap-y-3">
            <dt class="text-sm font-medium text-gray-500">Ширина (мм)</dt>
            <dd class="text-sm text-gray-900">{{ $configuration->width_mm }}</dd>
            <dt class="text-sm font-medium text-gray-500">Высота (мм)</dt>
            <dd class="text-sm text-gray-900">{{ $configuration->height_mm }}</dd>
        </dl>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Материал</h3>
        <dl class="grid grid-cols-2 gap-x-6 gap-y-3">
            <dt class="text-sm font-medium text-gray-500">Название</dt>
            <dd class="text-sm text-gray-900">{{ $configuration->material->name ?? '—' }}</dd>
            <dt class="text-sm font-medium text-gray-500">Цвет</dt>
            <dd class="text-sm text-gray-900 flex items-center gap-2">
                <div class="w-4 h-4 rounded border border-gray-300" style="background-color: {{ $configuration->material->hex_color ?? '#ccc' }};"></div>
                {{ $configuration->material->hex_color ?? '—' }}
            </dd>
        </dl>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Автоматика</h3>
        @if($configuration->automationOptions->count() > 0)
        <ul class="space-y-2">
            @foreach($configuration->automationOptions as $option)
            <li class="flex items-center justify-between text-sm px-3 py-2 bg-gray-50 rounded">
                <span class="text-gray-900">{{ $option->name }}</span>
                @if($option->pivot->is_enabled)
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Вкл</span>
                @else
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Выкл</span>
                @endif
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-sm text-gray-500">Нет опций автоматики</p>
        @endif
    </div>

    @if($configuration->orders->count() > 0)
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Связанные заказы</h3>
        <table class="w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Клиент</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($configuration->orders as $order)
                <tr>
                    <td class="px-4 py-2 text-sm"><a href="{{ route('admin.orders.show', $order->id) }}" class="text-stone-700 hover:text-stone-900">#{{ $order->id }}</a></td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $order->client_name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $order->status }}</td>
                    <td class="px-4 py-2 text-sm text-gray-500">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div>
        <a href="{{ route('admin.configurations.index') }}" class="border border-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-50">Назад к списку</a>
    </div>
</div>
@endsection
