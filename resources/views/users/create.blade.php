@extends('main')

@section('title', 'create page')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h3 class="text-gray-700 text-3xl font-medium">Добавить пользователя</h3>

        <div class="mt-8">

        </div>

        <div class="mt-8">
            <form enctype="multipart/form-data" class="space-y-5 mt-5" method="user" action="{{ isset($user) ? route("users.update", $user->id) : route("users.store") }}">
                @csrf

                @if(isset($user))
                    @method("PUT")
                @endif

                <input name="name" type="text" class="w-full h-12 border border-gray-800 rounded px-3 @error('title') border-red-500 @enderror" value="{{ $user->name ?? "" }}" placeholder="Название" />

                @error('title')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                <input name="email" type="email" class="w-full h-12 border border-gray-800 rounded px-3 @error('preview') border-red-500 @enderror" value="{{ $user->mail ?? "" }}" placeholder="Описание" />

                @error('preview')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                <input name="phone" type="text" class="w-full h-12 border border-gray-800 rounded px-3 @error('description') border-red-500 @enderror" value="{{ $user->phone ?? "" }}" placeholder="Описание" />

                @error('description')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                <input name="image" type="file" class="w-full h-12" placeholder="Обложка" />

                @error('image')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                <button type="submit" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
