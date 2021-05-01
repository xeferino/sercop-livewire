<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex-1 relative z-0 overflow-y-auto focus:outline-none" tabindex="0" x-data="" x-init="$el.focus()">
                    <!-- Page title & actions -->
                    <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
                      <div class="flex-1 min-w-0">
                        <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                          Informaci&oacute;n
                        </h1>
                      </div>
                    </div>

                    <!-- Pinned projects -->
                    <div class="px-4 mt-6 sm:px-6 lg:px-8">
                      <h2 class="text-gray-500 text-xs font-medium uppercase tracking-wide">Indicadores</h2>
                      <ul class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 xl:grid-cols-4 mt-3" x-max="1">

                          <li class="relative col-span-1 flex shadow-sm rounded-md">
                            <div class="flex-shrink-0 flex items-center justify-center w-16 bg-red-600 text-white text-sm font-medium rounded-l-md">
                              P
                            </div>
                            <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                              <div class="flex-1 px-4 py-2 text-sm truncate">
                                <a href="#" class="text-gray-900 font-medium uppercase hover:text-gray-600">
                                  pendientes
                                </a>
                                <p class="text-gray-500">Proyectos {{ $procject_pending }}</p>
                              </div>
                            </div>
                          </li>

                          <li class="relative col-span-1 flex shadow-sm rounded-md">
                            <div class="flex-shrink-0 flex items-center justify-center w-16 bg-green-600 text-white text-sm font-medium rounded-l-md">
                              C
                            </div>
                            <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                              <div class="flex-1 px-4 py-2 text-sm truncate">
                                <a href="#" class="text-gray-900 font-medium uppercase hover:text-gray-600">
                                  completdos
                                </a>
                                <p class="text-gray-500">Proyectos {{ $procject_completed }}</p>
                              </div>
                            </div>
                          </li>
                      </ul>
                    </div>

                    <!-- Projects list (only on smallest breakpoint) -->
                    <div class="mt-10 sm:hidden">
                      <div class="px-4 sm:px-6">
                        <h2 class="text-gray-500 text-xs font-medium uppercase tracking-wide">Projects</h2>
                      </div>
                      <ul class="mt-3 border-t border-gray-200 divide-y divide-gray-100" x-max="1">
                        @foreach ($procedures as $item)
                            <li>
                                <a href="#" class="group flex items-center justify-between px-4 py-4 hover:bg-gray-50 sm:px-6">
                                <span class="flex items-center truncate space-x-3">
                                    <span class="font-medium truncate text-sm leading-6">
                                   {{ $item->number }}
                                    <!-- space -->
                                    <span class="truncate font-normal text-gray-500"> {{ $item->department->name }} </span>
                                    </span>
                                </span>
                                </a>
                            </li>
                        @endforeach
                      </ul>
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $procedures->links() }}
                        </div>
                    </div>

                    <!-- Projects table (small breakpoint and up) -->
                    <div class="hidden mt-8 sm:block">
                      <div class="align-middle inline-block min-w-full border-b border-gray-200">
                        <table class="min-w-full">
                          <thead>
                            <tr class="border-t border-gray-200">
                              <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span class="lg:pl-2">Proyectos</span>
                              </th>
                              <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Usuarios
                              </th>
                              <th class="hidden md:table-cell px-6 py-3 border-b border-gray-200 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                F. Ultima Mod.
                              </th>
                              <th class="pr-6 py-3 border-b border-gray-200 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-100" x-max="1">
                            @foreach ($procedures as $item)
                                <tr>
                                    <td class="px-6 py-3 max-w-0 w-full whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="flex items-center space-x-3 lg:pl-2">
                                        <a href="#" class="truncate hover:text-gray-600">
                                            <span>
                                                {{ $item->number }}
                                            <!-- space -->
                                            <span class="text-gray-500 font-normal">{{ $item->department->name }}</span>
                                            </span>
                                        </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-500 font-medium">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex flex-shrink-0 -space-x-1">
                                                {{ $item->user->name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-3 whitespace-nowrap text-sm text-gray-500 text-right">
                                        {{ $item->updated_at }}
                                    </td>
                                </tr>
                            @endforeach
                          </tbody>
                        </table>
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $procedures->links() }}
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</x-app-layout>
