<x-app-layout>
    <x-principal>
        <!-- Mostraremos los productos disponbles en un grid -->
        <div class="w-full p-2 border-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($productos as $item)
            <article @class([
                'h-72 bg-cover bg-center bg-no-repeat',
                'md:col-span-2'=>$loop->first
            ]) 
            style="background-image: url({{Storage::url($item->imagen)}})">
            <div class="w-full h-full flex flex-col justify-around items-center p-2 bg-opacity-50">
                <div class="text-xl font-bold">
                    {{$item->nombre}}
                </div>
                <div class="italic">
                    {{$item->user->email}}
                </div>
                <div class="flex flex-wrap">
                    @foreach($item->tags as $tag)
                    <div class="p-1 rounded mr-1" style="background-color:{{$tag->color}} ">
                        {{$tag->nombre}}
                    </div>
                    @endforeach
                </div>
            </div>
            </article>
            @endforeach
        </div>
        <div class="mt-2">
            {{$productos->links()}}
        </div>
    </x-principal>
</x-app-layout>