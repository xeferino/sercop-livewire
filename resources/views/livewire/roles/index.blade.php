<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configuración de roles') }}
        </h2>
    </x-slot>

    @can('show-role')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <div class="bg-blue-50 p-4 w-full">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <!-- Heroicon name: solid/information-circle -->
                                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3 flex-1 md:flex md:justify-between">
                                                <p class="text-md text-blue-700">
                                                    Listado de roles en el sistema
                                                </p>
                                                @can('create-role')
                                                    <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center px-5 py-2 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-green-400 hover:bg-green-500 focus:outline-none">
                                                        Nuevo Rol
                                                    </a>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                    @if ($roles->count())
                                        @include('livewire.roles.alerts', ['action' => session()->get('action'), 'message' => session()->get('message')])
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                                    <th scope="col" colspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripci&oacute;n</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($roles as $role)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">
                                                                        <b>{{$role->name }}</b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">
                                                                        {{$role->description }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            @can('show-role')
                                                                <a href="{{ route('admin.roles.show', ['role' => $role->id]) }}" class="inline-flex ml-6 items-center p-2 border border-transparent rounded-full shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none">
                                                                    <!-- Heroicon name: outline/plus -->
                                                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                </a>
                                                            @endcan

                                                            @can('edit-role')
                                                                <a href="{{ route('admin.roles.edit', ['role' => $role->id]) }}" class="inline-flex ml-6 items-center p-2 border border-transparent rounded-full shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none">
                                                                    <!-- Heroicon name: outline/plus -->
                                                                    <svg  class="h-6 w-6"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                                    </svg>
                                                                </a>
                                                            @endcan

                                                            @can('delete-role')
                                                                <form class="inline-flex" action="{{ route('admin.roles.destroy', ['role' => $role->id]) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="ml-6 items-center p-2 border border-transparent rounded-full shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none">
                                                                        <!-- Heroicon name: outline/plus -->
                                                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            <!-- More items... -->
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 text-gray-500">
                                            No hay roles en el sistema
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
</x-app-layout>
