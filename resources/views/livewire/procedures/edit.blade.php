<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Procedimiento '.$procedure->number ) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-10  sm:mt-0">
                <div class="grid grid-cols-1 md:grid-cols-1 pb-8">
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            @include('livewire.procedures.alerts', ['action' => session()->get('action'), 'message' => session()->get('message')])

                            <form action="{{ route('admin.procedures.update.single', ['procedure' => $procedure->id]) }}" method="POST" enctype="multipart/form-data" id="procedure-store">
                                @csrf
                                @method('PUT')
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="rounded-md bg-green-50 p-4 msg_succes hidden">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                            <!-- Heroicon name: solid/x-circle -->
                                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-green-800">
                                                    Procedimiento registrado exitosamente.
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="number" class="block text-sm font-medium text-gray-700">Numero Sercop</label>
                                            <input type="text" name="number" autocomplete="number" value="{{ old('number', $procedure->number) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('number') ? ' border-red-500' : 'border-gray-300' }}" readonly>
                                            @error('number')
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="year" class="block text-sm font-medium text-gray-700">A&ntilde;o</label>
                                            <input type="text" name="year" autocomplete="year" value="{{ old('year', $procedure->year) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('year') ? ' border-red-500' : 'border-gray-300' }}" readonly>
                                            @error('year')
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="type" class="block text-sm font-medium text-gray-700 ">Tipo de procedimiento</label>
                                            <input type="text" name="type" autocomplete="type" value="{{ old('type', $procedure->type->name) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('type') ? ' border-red-500' : 'border-gray-300' }}" readonly>

                                            @error('type')
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="department" class="block text-sm font-medium text-gray-700">Departamento</label>
                                            <input type="text" name="department" autocomplete="department" value="{{ old('department', $procedure->department->name) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('department') ? ' border-red-500' : 'border-gray-300' }}" readonly>

                                            @error('department')
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                                            <select name="status" id="status" class="mt-1 block w-full py-2 px-3 border {{ $errors->has('status') ? ' border-red-500' : 'border-gray-300' }} bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="Pendiente" {{ ($procedure->status == 'Pendiente') ? 'selected' : '' }}>Pendiente</option>
                                                <option value="Completado" {{ ($procedure->status == 'Completado') ? 'selected' : '' }}>Completado</option>
                                            </select>
                                            @error("status")
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="created_at" class="block text-sm font-medium text-gray-700">Fecha creacion</label>
                                            <input type="text" name="created_at" autocomplete="created_at" value="{{ $procedure->created_at }}" readonly class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('created_at') ? ' border-red-500' : 'border-gray-300' }}">
                                        </div>
                                    </div>
                                    <div class="grid py-3 grid-cols-1 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Descripci&oacute;n</label>
                                            <textarea name="description" id="description" autocomplete="given-description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('description') ? ' border-red-500' : 'border-gray-300' }}">{{ old('number', $procedure->description) }}</textarea>
                                            @error('description')
                                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>                               <!-- This example requires Tailwind CSS v2.0+ -->
                                    <div class=" px-4 py-3 text-right sm:px-6">
                                        <button type="submit" id="store" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Actualizar Procedimiento
                                        </button>
                                        <a href="{{ route('admin.procedures.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-red-500">
                                            Cancelar
                                        </a>
                                    </div>
                                </div>
                            </form>

                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                    <div class="px-4 sm:px-0">
                                      <h2 class="text-lg font-medium text-gray-900">Etapas</h2>

                                      <!-- Tabs -->
                                      <div class="sm:hidden">
                                        <label for="tabs" class="sr-only">Select a tab</label>
                                        <select onchange="stageChange()" id="tabs" name="tabs" class="mt-4 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                                            @foreach ($stages as $item)
                                                <option value="{{ route('admin.procedures.edit', ['procedure' => $item['procedure'], 'stage' => $item['stage']]) }}" {{ (\Request::get('stage') == $item['stage'])  ? 'selected' : ''}}>{{ $item['stage'] }}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                      <div class="hidden sm:block">
                                        <div class="border-b border-gray-200">
                                          <nav class="mt-2 -mb-px flex space-x-8" aria-label="Tabs">
                                            <!-- Current: "border-purple-500 text-purple-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200" -->
                                            @foreach ($stages as $item)
                                                <a href="{{ route('admin.procedures.edit', ['procedure' => $item['procedure'], 'stage' => $item['stage']]) }}" class="{{ (\Request::get('stage') == $item['stage']) ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500'}} hover:text-gray-700 hover:border-gray-200 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                                    {{ $item['stage'] }}
                                                <!-- Current: "bg-purple-100 text-purple-600", Default: "bg-gray-100 text-gray-900" -->
                                                </a>
                                            @endforeach

                                          </nav>
                                        </div>
                                      </div>
                                    </div>

                                    <!-- Stacked list -->
                                    <ul class="mt-5 border-t border-gray-200 divide-y divide-gray-200 sm:mt-0 sm:border-t-0" role="list">
                                        @foreach ($stages as $item)
                                            @if (\Request::get('stage') == $item['stage'])
                                                @foreach ($item['sections'] as $sec)
                                                    <li>
                                                        <p class="group block">
                                                        <div class="flex items-center py-5 px-4 sm:py-6 sm:px-0">
                                                            <div class="min-w-0 flex-1 flex items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixqx=pUCGhKic6A&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                                                </div>
                                                                <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                                                    <div>
                                                                        <p class="text-sm font-medium text-purple-600 truncate">{{ $sec['name'] }}</p>
                                                                        <p class="mt-2 flex items-center text-sm text-gray-500">
                                                                            <!-- Heroicon name: solid/mail -->

                                                                            @foreach ($documents as $doc)
                                                                                @if ($doc->section_id == $sec['id'])
                                                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                                                                    </svg>
                                                                                    <span class="truncate"><a href="{{ route('admin.procedures.download.file', ['file' => $doc->id]) }}">{{ $doc->file_name }}</a></span>
                                                                                @endif
                                                                            @endforeach
                                                                        </p>
                                                                    </div>
                                                                    <div class="hidden md:block">
                                                                        @foreach ($documents as $doc)
                                                                            @if ($doc->section_id == $sec['id'])
                                                                                <div>
                                                                                    <p class="text-sm text-gray-900">
                                                                                    Fecha
                                                                                        @if ($doc->status == 'Borrador')
                                                                                            <time>{{ $doc->date_draft }}</time>
                                                                                        @endif
                                                                                        @if ($doc->status == 'Pendiente')
                                                                                            <time>{{ $doc->date_pending }}</time>
                                                                                        @endif
                                                                                        @if ($doc->status == 'Publicado')
                                                                                            <time>{{ $doc->date_published }}</time>
                                                                                        @endif
                                                                                        @if ($doc->status == 'Completado')
                                                                                            <time>{{ $doc->date_completed }}</time>
                                                                                        @endif
                                                                                    </p>
                                                                                    <p class="mt-2 flex items-center text-sm text-gray-500">
                                                                                        @if ($doc->status == 'Borrador')
                                                                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                            </svg>
                                                                                        @endif
                                                                                        @if ($doc->status == 'Pendiente')
                                                                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-black-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                                                                                            </svg>
                                                                                        @endif
                                                                                        @if ($doc->status == 'Publicado')
                                                                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                                                            </svg>
                                                                                        @endif
                                                                                        @if ($doc->status == 'Completado')
                                                                                            <!-- Heroicon name: solid/check-circle -->
                                                                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                                            </svg>
                                                                                        @endif
                                                                                        {{ $doc->status }}
                                                                                    </p>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('admin.procedures.edit', ['procedure' => $procedure->id, 'section' => $sec['id']]) }}">
                                                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                                    </svg>
                                                                </a>

                                                                {{-- <a href="">
                                                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                </a> --}}
                                                            </div>
                                                        </div>
                                                        </p>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endforeach

                                      <!-- More candidates... -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var stage = document.getElementById('tabs');
        function stageChange(){
            window.location=stage.value;
        }
    </script>
</x-app-layout>
