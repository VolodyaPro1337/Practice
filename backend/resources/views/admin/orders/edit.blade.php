@extends('admin.layouts.app')

@section('title', 'Редактирование заказа #' . $order->id)

@section('content')
<div class="bg-white rounded-lg border border-gray-200 p-6 max-w-2xl">
    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-6">
        @method('PUT')
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Клиент</label>
            <p class="mt-1 text-sm text-gray-900">{{ $order->client_name }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Телефон</label>
            <p class="mt-1 text-sm text-gray-900">{{ $order->client_phone }}</p>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Статус</label>
            <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">
                <option value="new" {{ old('status', $order->status) === 'new' ? 'selected' : '' }}>Новый</option>
                <option value="processing" {{ old('status', $order->status) === 'processing' ? 'selected' : '' }}>В обработке</option>
                <option value="contacted" {{ old('status', $order->status) === 'contacted' ? 'selected' : '' }}>Связались</option>
                <option value="confirmed" {{ old('status', $order->status) === 'confirmed' ? 'selected' : '' }}>Подтверждён</option>
                <option value="cancelled" {{ old('status', $order->status) === 'cancelled' ? 'selected' : '' }}>Отменён</option>
            </select>
        </div>

        <div>
            <label for="admin_note" class="block text-sm font-medium text-gray-700">Заметка администратора</label>
            <textarea name="admin_note" id="admin_note" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">{{ old('admin_note', $order->admin_note) }}</textarea>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-stone-800 text-white px-4 py-2 rounded hover:bg-stone-700">Сохранить</button>
            <a href="{{ route('admin.orders.show', $order->id) }}" class="border border-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-50">Отмена</a>
        </div>
    </form>
</div>
@endsection
