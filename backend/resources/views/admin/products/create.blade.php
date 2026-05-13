@extends('admin.layouts.app')

@section('title', 'Новый продукт')

@section('content')
<div class="bg-white rounded-lg border border-gray-200 p-6 max-w-2xl">
    <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Категория</label>
            <select name="category_id" id="category_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">
                <option value="">— Выберите категорию —</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

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
            <label for="short_description" class="block text-sm font-medium text-gray-700">Краткое описание</label>
            <textarea name="short_description" id="short_description" rows="2" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">{{ old('short_description') }}</textarea>
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Изображение</label>
            <input type="text" name="image" id="image" value="{{ old('image') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">
        </div>

        <div>
            <label for="system_code" class="block text-sm font-medium text-gray-700">Код системы</label>
            <input type="text" name="system_code" id="system_code" value="{{ old('system_code') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">
        </div>

        <div>
            <label for="accent_color" class="block text-sm font-medium text-gray-700">Акцентный цвет</label>
            <input type="text" name="accent_color" id="accent_color" value="{{ old('accent_color') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">
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
            <a href="{{ route('admin.products.index') }}" class="border border-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-50">Отмена</a>
        </div>
    </form>
</div>
@endsection
