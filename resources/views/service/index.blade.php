@extends('main')

@section('title', 'main page')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h3 class="text-gray-700 text-3xl font-medium">Услуги</h3>

        <div class="mt-8">
            <a href="{{ route("service.create") }}" class="text-indigo-600 hover:text-indigo-900">Добавить услугу</a>
        </div>
{{--        <div style="text-align: center;">--}}
{{--            <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>--}}
{{--        </div>--}}

        <div class="flex flex-col mt-8">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div
                    class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead class="bg-gray-900 text-gray-100">
                        <tr>
                            <th scope="col">Услуга</th>
                            <th scope="col">Категория</th>
                            <th scope="col">Исполнители</th>
                            <th scope="col">Дата создания</th>
                            <th scope="col">Действие</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($services as $service)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-900">{{ $service->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-900">{{ $service->category->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <table class="min-w-full">
                                            <tbody class="bg-white">
                                                @foreach($service->users as $key => $user)
                                                    <tr>
                                                        <th scope="row">{{ $key +1 }}</th>
                                                        <td><a href="{{ route("users.index") }}" class="text-blue-700 hover:text-indigo-900">{{ $user->name }}</a></td>
                                                        <td class="text-blue-900">{{ $user->phone }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-900">{{ $service->created_at }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                        <a href="{{ route("service.edit", $service->id) }}" class="text-indigo-600 hover:text-indigo-900">Редактировать</a>
                                        <form action="{{ route("service.destroy", $service->id) }}" method="POST">
                                            @csrf

                                            @method('DELETE')

                                            <button type="submit" class="text-red-600 hover:text-red-900">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script type="module">
        const firebaseConfig = {
            apiKey: "AIzaSyA7QXpfQPntISacYjADHn4rdJUWu1KRK5k",
            authDomain: "nidge-test.firebaseapp.com",
            projectId: "nidge-test",
            storageBucket: "nidge-test.appspot.com",
            messagingSenderId: "667514607134",
            appId: "1:667514607134:web:9fe144a65863654710c00f"
        };

        let firebase;
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        function initFirebaseMessagingRegistration() {
            messaging
                .requestPermission()
                .then(function () {
                    return messaging.getToken()
                })
                .then(function(token) {
                    console.log(token);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '{{ route("save-token") }}',
                        type: 'POST',
                        data: {
                            token: token
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            alert('Token saved successfully.');
                        },
                        error: function (err) {
                            console.log('User Chat Token Error'+ err);
                        },
                    });

                }).catch(function (err) {
                console.log('User Chat Token Error'+ err);
            });
        }

        messaging.onMessage(function(payload) {
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(noteTitle, noteOptions);
        });
    </script>

@endsection
