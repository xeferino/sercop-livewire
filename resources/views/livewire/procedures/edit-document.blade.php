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
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
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
                                                        <b> {{ $section->name }} </b>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{ route('admin.procedures.update', ['procedure' => $procedure->id]) }}" method="POST" enctype="multipart/form-data" id="procedure-store">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="section" value="{{ $section->id }}">
                                            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                                                @include('livewire.procedures.alerts', ['action' => session()->get('action'), 'message' => session()->get('message')])
                                                <dl class="sm:divide-y sm:divide-gray-200">
                                                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                            <dt class="text-lg font-medium text-gray-500">
                                                                @foreach ($procedure->documents as $document)
                                                                    @if ($document->section_id == $section->id)
                                                                        <div class="rounded-md bg-gray-50 p-4">
                                                                            <div class="relative flex items-start">
                                                                                <div class="ml-3 text-sm">
                                                                                    <iframe
                                                                                        src="{{ asset($document->file_path.$document->file_name) }}"
                                                                                        class="relative flex items-start"
                                                                                        width="230"
                                                                                        frameborder="0">
                                                                                    </iframe>
                                                                                    <label class="font-medium text-gray-700"><b><a href="{{ route('admin.procedures.download.file', ['file' => $document->id]) }}">{{ $document->file_name }}</a></b></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </dt>
                                                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                                    <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                                                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                                                                <div class="w-0 flex-1 flex items-center">
                                                                                    <!-- Heroicon name: solid/paper-clip -->
                                                                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                                        <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                                                                    </svg>
                                                                                    <span class="ml-2 flex-1 w-0 truncate">
                                                                                        {{ $section->name }}
                                                                                    </span>
                                                                                    <span class="ml-2 flex-1 w-0 truncate">
                                                                                        @foreach ($procedure->documents as $document)
                                                                                            @if ($document->section_id == $section->id)
                                                                                                <select name="status" id="status" class="mt-1 block w-full py-2 px-3 border {{ $errors->has('status') ? ' border-red-500' : 'border-gray-300' }} bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                                                                    <option value="Borrador" {{ $document->status ==  'Borrador' ? 'selected' : '' }}>Borrador</option>
                                                                                                    <option value="Pendiente" {{ $document->status ==  'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                                                                    <option value="Publicado" {{ $document->status ==  'Publicado' ? 'selected' : '' }}>Publicado</option>
                                                                                                    <option value="Completado" {{ $document->status ==  'Completado' ? 'selected' : '' }}>Completado</option>
                                                                                                </select>
                                                                                            @endif
                                                                                        @endforeach

                                                                                        @if ($procedure->documents->where('section_id', $section->id)->count()<=0)
                                                                                            <input type="hidden" name="doc" value="new">
                                                                                            <select name="status" id="status" class="mt-1 block w-full py-2 px-3 border {{ $errors->has('status') ? ' border-red-500' : 'border-gray-300' }} bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                                                                <option value="Borrador">Borrador</option>
                                                                                                <option value="Pendiente">Pendiente</option>
                                                                                                <option value="Publicado">Publicado</option>
                                                                                                <option value="Completado">Completado</option>
                                                                                            </select>
                                                                                        @endif
                                                                                    </span>
                                                                                </div>
                                                                                <div class="ml-4 flex-shrink-0">
                                                                                    <input type="file" name="document" id="document" class="fileSection">
                                                                                </div>
                                                                            </li>
                                                                    </ul>
                                                                </dd>
                                                        </div>
                                                </dl>
                                            </div>
                                                @error('file')                               <!-- This example requires Tailwind CSS v2.0+ -->
                                                    <div class="bg-white px-4 sm:px-6 text-red-500">
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
                                                                    {{ $message }}
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @enderror
                                            <div class=" px-4 py-3 text-right sm:px-6">
                                                <button type="submit" id="store" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Actualizar
                                                </button>
                                                <a href="{{ route('admin.procedures.edit', ['procedure' => $procedure->id, 'stage' => $procedure->type->StageProcedures[0]['name']]) }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-red-500">
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
        </div>
    </div>
    <script>
        var stage = document.getElementById('tabs');
        function stageChange(){
            window.location=stage.value;
        }
    </script>
</x-app-layout>
