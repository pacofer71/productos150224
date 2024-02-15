<x-principal>
    <div class="flex w-full mb-1  items-center">
        <div class="w-3/4 flex-1">
            <x-input type="search" placeholder="Buscar..." wire:model.live="cadena" class="w-3/4" /><i class="mr-2 fas fa-search"></i>
        </div>
        <div class="">
            @livewire('create-product')
        </div>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    INFO
                </th>
                <th scope="col" class="px-6 py-3">
                    IMAGEN
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('nombre')">
                    NOMBRE<i class="ml-1 fas fa-sort"></i>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('disponible')">
                    DISPONIBLE<i class="ml-1 fas fa-sort"></i>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('stock')">
                    STOCK<i class="ml-1 fas fa-sort"></i>
                </th>

                <th scope="col" class="px-6 py-3">
                    ACCION
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $item)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <button>
                            <i class="fas fa-info text-lg hover:text-2xl"></i>
                        </button>
                    </td>
                    <th scope="row"
                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        <img class="w-24 h-24 rounded bg-center bg-cover" src="{{ Storage::url($item->imagen) }}"
                            alt="">

                    </th>
                    <td class="px-6 py-4">
                        {{ $item->nombre }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->disponible }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <button wire:click="bajarStock({{$item->id}})"
                                class="inline-flex items-center justify-center p-1 me-3 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                type="button">
                                <span class="sr-only">Quantity button</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 1h16" />
                                </svg>
                            </button>
                            <div>
                                <p @class([
                                    'bg-gray-50 w-14 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1',
                                    'text-red-500' => $item->stock < 10,
                                    'line-through font-bold' => $item->stock == 0,
                                    'text-green-500' => $item->stock >= 10,
                                ])>
                                    {{ $item->stock }}
                                </p>
                            </div>
                            <button  wire:click="subirStock({{$item->id}})"
                                class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                type="button">
                                <span class="sr-only">Quantity button</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                       <button wire:click="confirmarBorrado({{$item->id}})">
                        <i class="fas fa-trash text-red-500 hover:text-4xl"></i>
                       </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-1">
        {{ $productos->links() }}
    </div>
</x-principal>
