<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuario - '.$user->name. ' ' .$user->surname) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-10  sm:mt-0">
                <div class="grid grid-cols-1 md:grid-cols-1 pb-8">
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="bg-white flex px-4 py-3  sm:px-6">
                                <!-- This example requires Tailwind CSS v2.0+ -->
                                <div class="rounded-lg bg-white w-full overflow-hidden shadow">
                                    <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>
                                    <div class="bg-white p-6">
                                    <div class="sm:flex sm:items-center sm:justify-between">
                                        <div class="sm:flex sm:space-x-5">
                                        <div class="flex-shrink-0">
                                            <img class="mx-auto h-20 w-20 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                                        </div>
                                        <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                                            <p class="text-xl font-bold text-gray-900 sm:text-2xl">{{ $user->name. ' ' .$user->surname }}</p>
                                            <p class="text-sm font-medium text-gray-600">{{ $user->email }}</p>
                                        </div>
                                        </div>
                                        <div class="mt-5 flex justify-center sm:mt-0">
                                        <a href="#" class="flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                            {{ $user->department->name ?? 'Departamento'}}
                                        </a>
                                        </div>
                                    </div>
                                    </div>
                                    {{-- <div class="border-t border-gray-200 bg-gray-50 grid grid-cols-1 divide-y divide-gray-200 sm:grid-cols-3 sm:divide-y-0 sm:divide-x">
                                        <div class="px-6 py-5 text-sm font-medium text-center">
                                            <span class="text-gray-900">12</span>
                                            <span class="text-gray-600">Vacation days left</span>
                                        </div>

                                        <div class="px-6 py-5 text-sm font-medium text-center">
                                            <span class="text-gray-900">4</span>
                                            <span class="text-gray-600">Sick days left</span>
                                        </div>

                                        <div class="px-6 py-5 text-sm font-medium text-center">
                                            <span class="text-gray-900">2</span>
                                            <span class="text-gray-600">Personal days left</span>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="bg-white flex px-4 py-3 sm:px-6">
                                <div class="rounded-md bg-blue-50 p-4 w-full">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <!-- Heroicon name: solid/information-circle -->
                                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3 flex-1 md:flex md:justify-between">
                                            <p class="text-md text-blue-700">
                                                Listado de permisos en el sistema para el rol <b>{{ $user->getRoleNames()->join('') }}</b>.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white px-4 py-3 grid grid-cols-3 gap-4 sm:px-6">
                                @foreach ($permissions as $key => $item)
                                    <div class="rounded-md bg-gray-50 p-4">
                                        <div class="relative flex items-start">
                                            <div class="ml-3 text-sm">
                                                <label for="syncPermissions-{{ $item->id }}" class="font-medium text-gray-700"><b>{{ $item->name }}</b></label>
                                                <p class="text-gray-500">{{ $item->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="px-4 py-3 text-right sm:px-6">
                                <a href="{{ route('admin.users.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Regresar
                                </a>
                            </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
