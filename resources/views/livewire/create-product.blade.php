<div>
    <x-button>
        <i class='fas fa-add mr-1'></i> NUEVO
    </x-button>
    <!-- Modal para crear -->
    <x-dialog-modal>
        <x-slot name="title">
            Crear Producto
        </x-slot>
        <x-slot name="content">
            <x-label for="nombre">
                Nombre
            </x-label>
            <x-input id="nombre" placeholder="Nombre..." class="w-full" wire:model="nombre" />
            <x-input-error for="nombre" />

            <x-label for="descripcion" class="mt-4">
                Descripción
            </x-label>
            <textarea id="descripcion" placeholder="Descripcion..." class="w-full" wire:model="descripcion"></textarea>
            <x-input-error for="descripcion" />

            <x-label for="stock" class="mt-4">
                Stock
            </x-label>
            <x-input type="number" id="stock" placeholder="Stock..." class="w-full" step=1 min="0"
                wire:model="stock" />
            <x-input-error for="stock" />

            <x-label for="pvp" class="mt-4">
                PVP (€)
            </x-label>
            <x-input type="number" id="pvp" placeholder="Pvp..." class="w-full" step='0.01' min="0"
                max="9999.99" wire:model="pvp" />
            <x-input-error for="pvp" />

            <x-label for="tags" class="mt-4">
                Etiquetas
            </x-label>
            <div class="flex flex-wrap">
                @foreach ($misTags as $tag)
                    <div class="flex items-center me-4">
                        <input id="{{ $tag->id }}" type="checkbox" value="{{ $tag->id }}" wire:model="tags"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="{{ $tag->id }}"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 p-2 rounded-xl"
                            style="background-color:{{ $tag->color }}">{{ $tag->nombre }}</label>
                    </div>
                @endforeach
            </div>
            <x-input-error for="tags" />

            <x-label for="imagenC" class="mt-4">
                Imagen
            </x-label>
            <div class="relative w-full h-72 bg-gray-200 rounded">
                <input type="file" wire:model="imagen" accept="image/*" hidden id="imagenC" />
                <label for="imagenC"
                    class="absolute bottom-2 end-2 bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    <i class="fa-solid fa-upload mr-2"></i>Subir
                </label>
                @if ($imagen)
                    <img src="{{ $imagen->temporaryUrl() }}"
                        class="p-1 rounded w-full h-full br-no-repeat bg-cover bg-center" />
                @endif

            </div>
            <x-input-error for="imagen" />


        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <button wire:click="store" wire:loading.attr="disabled"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save"></i> GUARDAR
                </button>

                <button wire:click="cancelarCrear"
                    class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-xmark"></i> CANCELAR
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
