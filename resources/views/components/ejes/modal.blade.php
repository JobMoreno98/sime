<!-- Fondo oscuro y contenedor del modal -->
<div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">

    <!-- Backdrop -->
    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="closeModal()"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <!-- Panel del Modal -->
        <div x-show="showModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            <form :action="isEditing ? editUrl : '{{ route('ejes.store') }}'" method="post">
                @csrf
                <input type="hidden" name="_method" :value="isEditing ? 'PUT' : 'POST'">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">

                            <!-- Título Dinámico -->
                            <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title"
                                x-text="isEditing ? 'Editar Eje Estratégico' : 'Nuevo Eje Estratégico'"></h3>
                            <p class="text-sm text-gray-500 mt-1"
                                x-text="isEditing ? 'Modifica los datos del eje seleccionado.' : 'Ingresa los datos para registrar un nuevo eje.'">
                            </p>

                            <!-- Formulario -->
                            <div class="mt-6 space-y-4">
                                <!-- Código -->
                                <div>
                                    <label for="code" class="block text-sm font-medium text-gray-700">
                                        Código del Eje
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="code" x-model="form.axis_number"
                                        placeholder="Ej. EJE 1" name="axis_number"
                                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm px-3 py-2 border">
                                </div>

                                <!-- Nombre -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Eje
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" id="name" x-model="form.name" required name="name"
                                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm px-3 py-2 border">
                                </div>

                                <!-- Responsable -->
                                <div>
                                    <label for="responsible"
                                        class="block text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea id="description" x-model="form.description" name="description" rows="1"
                                        placeholder="Ej. Secretaría General" x-ref="description" x-init="$nextTick(() => {
                                            $refs.description.style.height = 'auto';
                                            $refs.description.style.height = $refs.description.scrollHeight + 'px'
                                        })"
                                        @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                        class="mt-1 block w-full min-h-[44px] resize-none overflow-hidden rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 shadow-sm placeholder:text-gray-400 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                                    </textarea>
                                </div>
                                <div>
                                    <label for="responsible" class="block text-sm font-medium text-gray-700">
                                        Color</label>
                                    <input type="color" id="responsible" x-model="form.color" name="color"
                                        class="mt-1 block w-full h-12 p-1 rounded-xl border border-gray-300 bg-white shadow-sm cursor-pointer focus:border-purple-500 focus:ring-purple-500" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-xl bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-700 sm:w-auto transition-colors">
                        <span x-text="isEditing ? 'Guardar Cambios' : 'Crear Eje'"></span>
                    </button>
                    <button type="button" @click="closeModal()"
                        class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
