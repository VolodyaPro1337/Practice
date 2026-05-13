@extends('admin.layouts.app')

@section('title', 'Профили')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-lg font-semibold text-gray-800">Все профили</h2>
    <a href="{{ route('admin.profiles.create') }}" class="bg-stone-800 text-white px-4 py-2 rounded hover:bg-stone-700 text-sm">Добавить профиль</a>
</div>

<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <table class="w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Название</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Макс. пролёт</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Хит продаж</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Сортировка</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($profiles as $profile)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 text-sm text-gray-900">{{ $profile->id }}</td>
                <td class="px-6 py-3 text-sm text-gray-900">{{ $profile->name }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $profile->slug }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $profile->max_span_mm }}</td>
                <td class="px-6 py-3 text-sm">
                    @if($profile->is_best_seller)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">Хит</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500">—</span>
                    @endif
                </td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $profile->sort_order }}</td>
                <td class="px-6 py-3 text-sm flex items-center gap-2">
                    <a href="{{ route('admin.profiles.edit', $profile->id) }}" class="text-stone-700 hover:text-stone-900 text-sm">Редактировать</a>
                    <form action="{{ route('admin.profiles.destroy', $profile->id) }}" method="POST" onsubmit="return confirm('Удалить профиль?')">
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
