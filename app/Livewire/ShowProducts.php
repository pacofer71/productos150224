<?php

namespace App\Livewire;

use App\Livewire\Forms\UpdateProduct;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowProducts extends Component
{
    use WithPagination;
    use WithFileUploads;

    

    public UpdateProduct $form;
    public bool $openEdit=false;

    public Product $producto;
    public bool $openShow=false;

    public string $campo="id";
    public string $orden="desc";
    public string $cadena="";

    #[On('producto-creado')]
    public function render()
    {
        $productos=Product::where('user_id', auth()->user()->id)
        ->where(function($q){
            $q->where('nombre', 'like', '%'.$this->cadena.'%')
            ->orWhere('disponible', 'like', '%'.$this->cadena.'%');
        })
        ->orderBy($this->campo, $this->orden)
        ->paginate(5);

        $misTags = Tag::select('id', 'nombre', 'color')->orderBy('nombre')->get();
        return view('livewire.show-products', compact('productos', 'misTags'));
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
        $this->authorize('delete', $producto);
        $this->dispatch("confirmarBorrar", $producto->id);
    }
    #[On("borrarOk")]
    public function borrar(Product $product){
        $this->authorize('delete', $product);
        //Compruebo que la imagen no es la imagen 'noimage.png' para borrarla o NO
        if(basename($product->imagen)!='noimage.png'){
            Storage::delete($product->imagen);
        }
        $product->delete();
        $this->dispatch("mensaje", "Se ha borrado el producto");
    }
    //Esto para actualizar
    public function edit(Product $producto){
        $this->authorize('update', $producto);
        $this->form->setProducto($producto);
        $this->openEdit=true;
    }
    public function update(){
        $this->form->editarProducto();
        $this->cancelarUpdate();
        $this->dispatch('mensaje', 'Producto actualizado');
    }
    public function cancelarUpdate(){
        $this->openEdit=false;
        $this->form->limpiarCampos();
    }

    //----------------------------- Para detalle
    public function detalle(Product $producto){
        $this->producto=$producto;
        $this->openShow=true;
    }
    public function cerrarDetalle(){
        $this->reset(['producto', 'openShow']);

    }


}
