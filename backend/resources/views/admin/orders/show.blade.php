@extends('admin.layouts.app')

@section('title', 'Заказ #' . $order->id)

@section('content')
@php
$statusColors = [
    'new' => 'bg-blue-100 text-blue-800',
    'processing' => 'bg-amber-100 text-amber-800',
    'contacted' => 'bg-purple-100 text-purple-800',
    'confirmed' => 'bg-green-100 text-green-800',
    'cancelled' => 'bg-red-100 text-red-800',
];
$statusLabels = [
    'new' => 'Новый',
    'processing' => 'В обработке',
    'contacted' => 'Связались',
    'confirmed' => 'Подтверждён',
    'cancelled' => 'Отменён',
];
@endphp

<div class="space-y-6 max-w-3xl">
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Информация о клиенте</h3>
        <dl class="grid grid-cols-2 gap-x-6 gap-y-3">
            <dt class="text-sm font-medium text-gray-500">Имя</dt>
            <dd class="text-sm text-gray-900">{{ $order->client_name }}</dd>
            <dt class="text-sm font-medium text-gray-500">Телефон</dt>
            <dd class="text-sm text-gray-900">{{ $order->client_phone }}</dd>
            <dt class="text-sm font-medium text-gray-500">Статус</dt>
            <dd class="text-sm">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">{{ $statusLabels[$order->status] ?? $order->status }}</span>
            </dd>
            <dt class="text-sm font-medium text-gray-500">Дата</dt>
            <dd class="text-sm text-gray-900">{{ $order->created_at->format('d.m.Y H:i') }}</dd>
        </dl>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Конфигурация</h3>
        @if($order->configuration)
        <dl class="grid grid-cols-2 gap-x-6 gap-y-3">
            <dt class="text-sm font-medium text-gray-500">Профиль</dt>
            <dd class="text-sm text-gray-900">{{ $order->configuration->profile->name ?? '—' }}</dd>
            <dt class="text-sm font-medium text-gray-500">Ширина (мм)</dt>
            <dd class="text-sm text-gray-900">{{ $order->configuration->width_mm }}</dd>
            <dt class="text-sm font-medium text-gray-500">Высота (мм)</dt>
            <dd class="text-sm text-gray-900">{{ $order->configuration->height_mm }}</dd>
            <dt class="text-sm font-medium text-gray-500">Материал</dt>
            <dd class="text-sm text-gray-900">{{ $order->configuration->material->name ?? '—' }}</dd>
        </dl>

        @if($order->configuration->automationOptions->count() > 0)
        <div class="mt-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Автоматика</h4>
            <ul class="space-y-2">
                @foreach($order->configuration->automationOptions as $option)
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
        </div>
        @endif
        @else
        <p class="text-sm text-gray-500">Конфигурация не найдена</p>
        @endif
    </div>

    @if($order->admin_note)
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-2">Заметка администратора</h3>
        <p class="text-sm text-gray-700">{{ $order->admin_note }}</p>
    </div>
    @endif

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.orders.edit', $order->id) }}" class="bg-stone-800 text-white px-4 py-2 rounded hover:bg-stone-700 text-sm">Изменить статус</a>
        <a href="{{ route('admin.orders.index') }}" class="border border-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-50">Назад к списку</a>
    </div>
</div>
@endsection
