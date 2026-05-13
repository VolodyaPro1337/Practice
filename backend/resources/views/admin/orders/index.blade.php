@extends('admin.layouts.app')

@section('title', 'Заказы')

@section('content')
<div class="mb-6">
    <h2 class="text-lg font-semibold text-gray-800">Все заказы</h2>
</div>

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

<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <table class="w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Клиент</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Телефон</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Профиль</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 text-sm text-gray-900">{{ $order->id }}</td>
                <td class="px-6 py-3 text-sm text-gray-900">{{ $order->client_name }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $order->client_phone }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $order->configuration->profile->name ?? '—' }}</td>
                <td class="px-6 py-3 text-sm">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">{{ $statusLabels[$order->status] ?? $order->status }}</span>
                </td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                <td class="px-6 py-3 text-sm flex items-center gap-2">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-stone-700 hover:text-stone-900 text-sm">Просмотр</a>
                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-stone-700 hover:text-stone-900 text-sm">Статус</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
