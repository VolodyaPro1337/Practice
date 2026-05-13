@extends('admin.layouts.app')

@section('title', 'Автоматика')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-lg font-semibold text-gray-800">Все опции автоматики</h2>
    <a href="{{ route('admin.automation-options.create') }}" class="bg-stone-800 text-white px-4 py-2 rounded hover:bg-stone-700 text-sm">Добавить опцию</a>
</div>

<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <table class="w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Название</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Иконка</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Сортировка</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($automationOptions as $option)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 text-sm text-gray-900">{{ $option->id }}</td>
                <td class="px-6 py-3 text-sm text-gray-900">{{ $option->name }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $option->slug }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $option->icon }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $option->sort_order }}</td>
                <td class="px-6 py-3 text-sm flex items-center gap-2">
                    <a href="{{ route('admin.automation-options.edit', $option->id) }}" class="text-stone-700 hover:text-stone-900 text-sm">Редактировать</a>
                    <form action="{{ route('admin.automation-options.destroy', $option->id) }}" method="POST" onsubmit="return confirm('Удалить опцию?')">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-3 py-1.5 rounded text-sm hover:bg-red-700">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
