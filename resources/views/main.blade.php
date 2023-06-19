<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <div>
            <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
                <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>

                <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
                    <div class="flex items-center justify-center mt-8">
                    </div>

                    <nav class="mt-10">
                        <a class="flex items-center py-2 px-6 bg-gray-700 bg-opacity-25 text-gray-100" href="{{ route("service.index") }}">
                            <span class="mx-3">Услуги</span>
                        </a>
                    </nav>
                    <nav class="">
                        <a class="flex items-center py-2 px-6 bg-gray-700 bg-opacity-25 text-gray-100" href="{{ route("category.index") }}">
                            <span class="mx-3">Категории</span>
                        </a>
                    </nav>
                    <nav class="">
                        <a class="flex items-center py-2 px-6 bg-gray-700 bg-opacity-25 text-gray-100" href="{{ route("users.index") }}">
                            <span class="mx-3">Пользователи</span>
                        </a>
                    </nav>
                </div>

                <div class="flex-1 flex flex-col overflow-hidden">
                    <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-indigo-600">
                        <div class="flex items-center">
                            <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="flex items-center">
                            <div x-data="{ dropdownOpen: false }" class="relative">
                                <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"
                                     style="display: none;"></div>

                                <div x-show="dropdownOpen"
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10"
                                     style="display: none;">
                                    <a href="{{ route("logout") }}"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Выйти</a>
                                </div>
                            </div>
                        </div>
                    </header>

                    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>

        <script src="https://cdn.tailwindcss.com"></script>
    </body>
</html>
