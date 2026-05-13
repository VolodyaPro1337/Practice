@extends('admin.layouts.app')

@section('title', 'Конфигурации')

@section('content')
<div class="mb-6">
    <h2 class="text-lg font-semibold text-gray-800">Все конфигурации</h2>
</div>

<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <table class="w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Профиль</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Размеры</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Материал</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Автоматика</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($configurations as $configuration)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 text-sm text-gray-900">{{ $configuration->id }}</td>
                <td class="px-6 py-3 text-sm text-gray-900">{{ $configuration->profile->name ?? '—' }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $configuration->width_mm }} x {{ $configuration->height_mm }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $configuration->material->name ?? '—' }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $configuration->automationOptions->count() }}</td>
                <td class="px-6 py-3 text-sm text-gray-500">{{ $configuration->created_at->format('d.m.Y H:i') }}</td>
                <td class="px-6 py-3 text-sm">
                    <a href="{{ route('admin.configurations.show', $configuration->id) }}" class="text-stone-700 hover:text-stone-900 text-sm">Просмотр</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
