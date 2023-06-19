@extends('main')

@section('title', 'create page')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h3 class="text-gray-700 text-3xl font-medium">Добавить новую</h3>

        <div class="mt-8">

        </div>

        <div class="mt-8">
            <form enctype="multipart/form-data" class="space-y-5 mt-5" method="POST" action="{{ isset($category) ? route("category.update", $category->id) : route("category.store") }}">
                @csrf

                @if(isset($category))
                    @method("PUT")
                @endif

                <input name="title" type="text" class="w-full h-12 border border-gray-800 rounded px-3 @error('title') border-red-500 @enderror" value="{{ $category->title ?? "" }}" placeholder="Название" />

                @error('title')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                <input name="description" type="text" class="w-full h-12 border border-gray-800 rounded px-3 @error('description') border-red-500 @enderror" value="{{ $category->description ?? "" }}" placeholder="Описание" />

                @error('description')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                <button type="submit" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
