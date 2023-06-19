@extends('main')

@section('title', 'create page')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h3 class="text-gray-700 text-3xl font-medium">@if(!isset($service)) Добавить новую @else Редактировать @endif</h3>

        <div class="mt-8">

        </div>

        <div class="mt-8">
            <form enctype="multipart/form-data" class="space-y-5 mt-5" method="POST" action="{{ isset($service) ? route("service.update", $service->id) : route("service.store") }}">
                @csrf

                @if(isset($service))
                    @method("PUT")
                @endif

                <input name="title" type="text" class="w-full h-12 border border-gray-800 rounded px-3 @error('title') border-red-500 @enderror" value="{{ $service->title ?? "" }}" placeholder="Название" />

                @error('title')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                @if(!isset($service))
                <select name="category" class="w-full h-12 border border-gray-800 rounded px-3">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
                </select>
                <label class="text-gray-700 text-2xl font-small">Категория</label>

                <div id="users">
                </div>
                <p class="text-blue-700 hover:text-indigo-900 text-2xl font-small" onclick="addProduct()" style="cursor: pointer">Добавить исполнителей</p>
                @endif

                <input name="description" type="text" class="w-full h-12 border border-gray-800 rounded px-3 @error('description') border-red-500 @enderror" value="{{ $service->description ?? "" }}" placeholder="Описание" />

                @error('description')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                <button type="submit" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium">Сохранить</button>
            </form>
        </div>
    </div>
    @if(!isset($service))
    <script>

        var i = 0;
        function addProduct() {
            var str = '<div class="form-row">\n' +
                '          <select name="users[]" class="mt-4 w-full h-12 border border-gray-800 rounded px-3">\n' +
                '              @foreach($users as $user)<option value="{{$user->id}}">{{$user->name}}</option> @endforeach' +
                '          </select>\n' +
                '      </div>';
            document.getElementById("users").insertAdjacentHTML("beforeend", str);
            i++;
        }
    </script>
    @endif
@endsection
