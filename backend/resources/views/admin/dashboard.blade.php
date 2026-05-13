@extends('admin.layouts.app')

@section('title', 'Дашборд')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="text-sm text-gray-500 uppercase tracking-wide">Заказы</div>
        <div class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['orders'] }}</div>
        <div class="text-sm text-amber-600 mt-1">{{ $stats['new_orders'] }} новых</div>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="text-sm text-gray-500 uppercase tracking-wide">Конфигурации</div>
        <div class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['configurations'] }}</div>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="text-sm text-gray-500 uppercase tracking-wide">Продукты</div>
        <div class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['products'] }}</div>
        <div class="text-sm text-gray-400 mt-1">{{ $stats['categories'] }} категорий</div>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="text-sm text-gray-500 uppercase tracking-wide">Компоненты</div>
        <div class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['profiles'] + $stats['materials'] + $stats['automation_options'] }}</div>
        <div class="text-sm text-gray-400 mt-1">{{ $stats['profiles'] }} профилей / {{ $stats['materials'] }} материалов / {{ $stats['automation_options'] }} автоматик</div>
    </div>
</div>

<div class="bg-white rounded-lg border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="font-semibold text-gray-800">Последние заказы</h2>
    </div>
    @if($recentOrders->count())
    <table class="w-full">
        <thead>
            <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                <th class="px-6 py-3">ID</th>
                <th class="px-6 py-3">Клиент</th>
                <th class="px-6 py-3">Телефон</th>
                <th class="px-6 py-3">Профиль</th>
                <th class="px-6 py-3">Статус</th>
                <th class="px-6 py-3">Дата</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($recentOrders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 text-sm text-gray-800">#{{ $order->id }}</td>
                <td class="px-6 py-3 text-sm text-gray-800">{{ $order->client_name }}</td>
                <td class="px-6 py-3 text-sm text-gray-600">{{ $order->client_phone }}</td>
                <td class="px-6 py-3 text-sm text-gray-600">{{ $order->configuration?->profile?->name ?? '—' }}</td>
                <td class="px-6 py-3">
                    @php
                        $colors = ['new' => 'bg-blue-100 text-blue-700', 'processing' => 'bg-amber-100 text-amber-700', 'contacted' => 'bg-purple-100 text-purple-700', 'confirmed' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700'];
                        $labels = ['new' => 'Новый', 'processing' => 'В обработке', 'contacted' => 'Связались', 'confirmed' => 'Подтверждён', 'cancelled' => 'Отменён'];
                    @endphp
                    <span class="px-2 py-1 rounded text-xs font-medium {{ $colors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">{{ $labels[$order->status] ?? $order->status }}</span>
                </td>
                <td class="px-6 py-3 text-sm text-gray-400">{{ $order->created_at->format('d.m.Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="px-6 py-8 text-center text-gray-400">Заказов пока нет</div>
    @endif
</div>
@endsection
