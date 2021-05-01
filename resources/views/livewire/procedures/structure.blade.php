<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
        <dl class="sm:divide-y sm:divide-gray-200">
            @foreach ($data as $item)
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-lg font-medium text-gray-500">
                       <b>{{ $item['stage'] }}</b>
                    </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($item['sections'] as $sec)
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <div class="w-0 flex-1 flex items-center">
                                            <!-- Heroicon name: solid/paper-clip -->
                                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="ml-2 flex-1 w-0 truncate">
                                                {{ $sec['name'] }}
                                            </span>
                                            <span class="ml-2 flex-1 w-0 truncate">
                                                <select name="status_document[]" id="status_document" class="mt-1 block w-full py-2 px-3 border {{ $errors->has('status') ? ' border-red-500' : 'border-gray-300' }} bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option value="Borrador" {{ old('status_document') ==  'Borrador' ? 'selected' : '' }}>Borrador</option>
                                                    <option value="Pendiente" {{ old('status_document') ==  'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                    <option value="Publicado" {{ old('status_document') ==  'Publicado' ? 'selected' : '' }}>Publicado</option>
                                                    <option value="Completado" {{ old('status_document') ==  'Completado' ? 'selected' : '' }}>Completado</option>
                                                </select>
                                            </span>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <input type="hidden" name="section[]" id="section" value="{{ $sec->id }}">
                                            <input type="file" name="document[]" id="document" class="fileSection">
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </dd>
                </div>
            @endforeach
        </dl>
    </div>
</div>
