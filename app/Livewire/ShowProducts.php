<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProducts extends Component
{
    use WithPagination;

    public Product $producto;

    public string $campo="id";
    public string $orden="desc";
    public string $cadena="";

    public function render()
    {
        $productos=Product::where('user_id', auth()->user()->id)
        ->where('nombre', 'like', '%'.$this->cadena.'%')
        ->orderBy($this->campo, $this->orden)
        ->paginate(5);
        return view('livewire.show-products', compact('productos'));
    }
    public function updatingCadena(){
        $this->resetPage();
    }

    public function subirStock(Product $product){
       // $this->producto=$product;
        $stock=($product->stock)+1;
        $product->update([
            'stock'=>$stock,
            'disponible'=>($stock>0) ? "SI": "NO",
        ]);
    }

    public function bajarStock(Product $product){
        if($product->stock==0) return;
        $stock=($product->stock)-1;
        $product->update([
            'stock'=>$stock,
            'disponible'=>($stock>0) ? "SI": "NO",
        ]);
    }

    public function ordenar(string $campo){
        $this->orden=($this->orden=='desc') ? 'asc' : 'desc';
        $this->campo=$campo;
    }

    //Esto para borrar
    public function confirmarBorrado(Product $producto){
        $this->authorize('update', $producto);
        $this->dispatch("confirmarBorrar", $producto->id);
    }
    #[On("borrarOk")]
    public function borrar(Product $product){
        $this->authorize('update', $product);
        //Compruebo que la imagen no es la imagen 'noimage.png' para borrarla o NO
        if(basename($product->imagen)!='noimage.png'){
            Storage::delete($product->imagen);
        }
        $product->delete();
        $this->dispatch("mensaje", "Se ha borrado el producto");
    }
}
