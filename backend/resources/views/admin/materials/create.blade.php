@extends('admin.layouts.app')

@section('title', 'Новый материал')

@section('content')
<div class="bg-white rounded-lg border border-gray-200 p-6 max-w-2xl">
    <form action="{{ route('admin.materials.store') }}" method="POST" class="space-y-6">
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
            <label for="hex_color" class="block text-sm font-medium text-gray-700">Цвет (HEX)</label>
            <div class="flex items-center gap-3">
                <input type="text" name="hex_color" id="hex_color" maxlength="7" value="{{ old('hex_color', '#000000') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">
                <div id="color-preview" class="w-10 h-10 rounded border border-gray-300 shrink-0" style="background-color: {{ old('hex_color', '#000000') }};"></div>
            </div>
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
            <label for="sort_order" class="block text-sm font-medium text-gray-700">Сортировка</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-stone-500 focus:border-stone-500">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300">
            <label for="is_active" class="text-sm font-medium text-gray-700">Активен</label>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-stone-800 text-white px-4 py-2 rounded hover:bg-stone-700">Сохранить</button>
            <a href="{{ route('admin.materials.index') }}" class="border border-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-50">Отмена</a>
        </div>
    </form>
</div>

<script>
document.getElementById('hex_color').addEventListener('input', function(e) {
    document.getElementById('color-preview').style.backgroundColor = e.target.value;
});
</script>
@endsection
