@extends('admin.layouts.app')

@section('title', 'Новый профиль')

@section('content')
<div class="bg-white rounded-lg border border-gray-200 p-6 max-w-2xl">
    <form action="{{ route('admin.profiles.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Название</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">
        </div>

        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
            <textarea name="description" id="description" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">{{ old('description') }}</textarea>
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Изображение</label>
            <input type="text" name="image" id="image" value="{{ old('image') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">
        </div>

        <div>
            <label for="max_span_mm" class="block text-sm font-medium text-gray-700">Макс. пролёт (мм)</label>
            <input type="number" name="max_span_mm" id="max_span_mm" value="{{ old('max_span_mm') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">
        </div>

        <div>
            <label for="tags_string" class="block text-sm font-medium text-gray-700">Теги (через запятую)</label>
            <input type="text" name="tags_string" id="tags_string" value="{{ old('tags_string') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_best_seller" id="is_best_seller" value="1" {{ old('is_best_seller') ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300">
            <label for="is_best_seller" class="text-sm font-medium text-gray-700">Хит продаж</label>
        </div>

        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700">Сортировка</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300">
            <label for="is_active" class="text-sm font-medium text-gray-700">Активен</label>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-stone-800 text-white px-4 py-2 rounded hover:bg-stone-700">Сохранить</button>
            <a href="{{ route('admin.profiles.index') }}" class="border border-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-50">Отмена</a>
        </div>
    </form>
</div>
@endsection
