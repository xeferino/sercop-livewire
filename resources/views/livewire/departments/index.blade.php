<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Departamentos') }}
    </h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (!$update)
            @include('livewire.departments.add')
        @else
            @include('livewire.departments.edit')
        @endif
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <div class="bg-white flex px-4 py-3 border-t border-gray-200 sm:px-6">
                                <input type="text" wire:model="search" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Buscar aqui">
                                <div class="form-input rounded-md mt-1 block ml-6">
                                    <select wire:model="perPage" class="outline-none text-gray-500 text-sm rounded-md">
                                        <option value="10">10 por pagina</option>
                                        <option value="15">15 por pagina</option>
                                        <option value="20">20 por pagina</option>
                                        <option value="30">30 por pagina</option>
                                        <option value="40">40 por pagina</option>
                                    </select>
                                </div>
                                @if ($search !== '')
                                    <button type="button" wire:click='clear' class="inline-flex ml-6 items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <!-- Heroicon name: outline/plus -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                            @if ($departments->count())
                                @include('livewire.departments.alerts')

                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                            <th scope="col" colspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($departments as $department)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $department->name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full  {{ ($department->status==1) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ ($department->status==1) ? 'Activo' : 'Inactivo' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <button type="button" wire:click='edit({{  $department->id }})' class="inline-flex ml-6 items-center p-2 border border-transparent rounded-full shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none">
                                                        <!-- Heroicon name: outline/plus -->
                                                        <svg  class="h-6 w-6"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" wire:click='destroy({{  $department->id }})' class="inline-flex ml-6 items-center p-2 border border-transparent rounded-full shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none">
                                                        <!-- Heroicon name: outline/plus -->
                                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    <!-- More items... -->
                                    </tbody>
                                </table>
                                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                                    {{ $departments->links() }}
                                </div>
                            @else
                                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 text-gray-500">
                                    No hay resulatados para la busqueda {{ $search }} en la pagina {{ $page }} al mostrar {{ $perPage }} por pagina
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
