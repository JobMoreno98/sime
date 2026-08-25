<div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">

    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="closeModal()"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <div x-show="showModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

            <!-- MODO: Editar configuración del indicador -->
            <template x-if="modalMode === 'config'">
                <form :action="isEditing ? editUrl : '{{ route('indicadores.store') }}'" method="post">
                    @csrf
                    <input type="hidden" name="_method" :value="isEditing ? 'PUT' : 'POST'">

                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title"
                                    x-text="isEditing ? 'Editar Indicador' : 'Nuevo Indicador'"></h3>
                                <p class="text-sm text-gray-500 mt-1"
                                    x-text="isEditing ? 'Modifica la configuración del indicador.' : 'Ingresa los datos para registrar un nuevo indicador.'">
                                </p>

                                <div class="mt-6 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Código
                                            <span class="text-red-500">*</span></label>
                                        <input type="text" x-model="form.code" name="code"
                                            placeholder="Ej. IND-01" required :readonly="isEditing"
                                            :class="isEditing ? 'bg-gray-100 cursor-not-allowed text-gray-500' : ''"
                                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm px-3 py-2 border">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nombre del Indicador
                                            <span class="text-red-500">*</span></label>
                                        <input type="text" x-model="form.name" required name="name"
                                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm px-3 py-2 border">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Temática
                                            <span class="text-red-500">*</span></label>
                                        <select x-model="form.theme_code" required name="theme_code"
                                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm px-3 py-2 border">
                                            <option value="">Selecciona una temática</option>
                                            @foreach ($tematicas as $tematica)
                                                <option value="{{ $tematica->code }}">
                                                    {{ $tematica->code }} — {{ $tematica->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Responsable
                                            <span class="text-red-500">*</span></label>
                                        <select x-model="form.responsible_user_id" required
                                            name="responsible_user_id"
                                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm px-3 py-2 border">
                                            <option value="">Selecciona un responsable</option>
                                            @foreach ($usuarios as $usuario)
                                                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Meta (Corto
                                                Plazo) <span class="text-red-500">*</span></label>
                                            <input type="number" step="0.01" x-model="form.short_term_goal"
                                                required name="short_term_goal"
                                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm px-3 py-2 border">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Unidad
                                                <span class="text-red-500">*</span></label>
                                            <input type="text" x-model="form.measurement_unit" required
                                                name="measurement_unit" placeholder="%, alumnos, proyectos..."
                                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm px-3 py-2 border">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Frecuencia de
                                            Medición</label>
                                        <input type="text" x-model="form.measurement_frequency"
                                            name="measurement_frequency" placeholder="Mensual, Trimestral..."
                                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm px-3 py-2 border">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-xl bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-700 sm:w-auto transition-colors">
                            <span x-text="isEditing ? 'Guardar Cambios' : 'Crear Indicador'"></span>
                        </button>
                        <button type="button" @click="closeModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </template>

            <!-- MODO: Capturar avance -->
            <template x-if="modalMode === 'progress'">
                <form :action="progressUrl" method="post">
                    @csrf

                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-bold leading-6 text-gray-900">Capturar Avance</h3>
                            <p class="text-sm text-gray-500 mt-1" x-text="form.name"></p>

                            <div class="mt-6 space-y-4">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Año</label>
                                        <input type="number" x-model="progressForm.year" required name="year"
                                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm px-3 py-2 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Período
                                            (opcional)</label>
                                        <input type="text" x-model="progressForm.period_sub" name="period_sub"
                                            placeholder="Q1, Enero..."
                                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm px-3 py-2 border">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Valor real (Meta corto plazo: <span x-text="form.short_term_goal"></span> <span
                                            x-text="form.measurement_unit"></span>)
                                    </label>
                                    <input type="number" step="0.0001" x-model="progressForm.actual_value" required
                                        name="actual_value"
                                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm px-3 py-2 border">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Notas (opcional)</label>
                                    <textarea x-model="progressForm.notes" name="notes" rows="2"
                                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm px-3 py-2 border"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-xl bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-700 sm:w-auto transition-colors">
                            Guardar Avance
                        </button>
                        <button type="button" @click="closeModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>
</div>