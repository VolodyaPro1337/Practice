@extends('admin.layouts.app')

@section('title', 'Материалы')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-lg font-semibold text-gray-800">Все материалы</h2>
    <a href="{{ route('admin.materials.create') }}" class="bg-stone-800 text-white px-4 py-2 rounded hover:bg-stone-700 text-sm">Добавить материал</a>
</div>

<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <table class="w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Название</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Цвет</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Сортировка</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($materials as $material)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 text-sm text-gray-900">{{ $material->id }}</td>
                <td class="px-6 py-3 text-sm text-gray-900">{{ $material->name }}</td>
                <td class="px-6 py-3 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded border border-gray-300" style="background-color: {{ $material->hex_color }};"></div>
                        <span class="text-gray-500">{{ $material->hex_color }}</span>
                    </div>
                </td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $material->slug }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $material->sort_order }}</td>
                <td class="px-6 py-3 text-sm flex items-center gap-2">
                    <a href="{{ route('admin.materials.edit', $material->id) }}" class="text-stone-700 hover:text-stone-900 text-sm">Редактировать</a>
                    <form action="{{ route('admin.materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Удалить материал?')">
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
