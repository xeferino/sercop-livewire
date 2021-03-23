<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar rol'.' - '.$role->name) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-10  sm:mt-0">
                <div class="grid grid-cols-1 md:grid-cols-1 pb-8">
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <form action="{{ route('admin.roles.update',['role' => $role->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <input type="text" name="name" autocomplete="name" value="{{ old('name', $role->name) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('name') ? ' border-red-500' : 'border-gray-300' }}">
                                    @error('name')
                                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Descripci&oacute;n</label>
                                    <textarea name="description" autocomplete="description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('description') ? ' border-red-500' : 'border-gray-300' }}">{{ old('description', $role->description) }}</textarea>
                                        @error('description')
                                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                        @enderror
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
                                                Listado de permisos en el sistema. Aca puede asignar los accesos al rol que esta creando.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('syncPermissions')
                                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 text-red-500">
                                    <div class="rounded-md bg-red-50 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                            <!-- Heroicon name: solid/x-circle -->
                                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-red-800">
                                                    Debe seleccionar al menos un permiso.
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @enderror

                            <div class="bg-white px-4 py-3 grid grid-cols-3 gap-4 sm:px-6">
                                @foreach ($permissions as $key => $item)
                                    <div class="rounded-md bg-gray-50 p-4">
                                        <div class="relative flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="syncPermissions-{{ $item->id }}" name="syncPermissions[]" value="{{ $item->id }}"  {{ (in_array($item->id , old('syncPermissions', $syncPermissions))) ? ' checked' : '' }} type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="syncPermissions-{{ $item->id }}" class="font-medium text-gray-700">{{ $item->name }}</label>
                                                <p class="text-gray-500">{{ $item->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="px-4 py-3 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Actualizar
                                </button>
                                <a href="{{ route('admin.roles.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-red-500">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
