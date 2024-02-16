<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\In;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateProduct extends Form
{
    public ?Product $producto=null;
    public string $nombre="";
    public string $descripcion="";
    public int $stock=0;
    public float $pvp=0.0;
    public array $tags=[];
    public $imagen;

    public function setProducto(Product $p){
        $this->producto=$p;
        $this->nombre=$p->nombre;
        $this->descripcion=$p->descripcion;
        $this->pvp=$p->pvp;
        $this->stock=$p->stock;
        $this->tags=$p->getTagsId();
    }
    public function rules(): array{
        return [
            'nombre'=>['required', 'string', 'min:3', 'unique:products,nombre,'.$this->producto->id],
            'descripcion'=>['required', 'string', 'min:10'],
            'pvp'=>['required', 'decimal:0,2', 'min:0', 'max:9999.99'],
            'stock'=>['required', 'integer', 'min:0'],
            'imagen'=>['nullable', 'image', 'max:2048'],
            'tags'=>['required', 'array', 'min:1', 'exists:tags,id']
        ];
    }
    public function editarProducto(){
        $ruta=$this->producto->imagen;
        if($this->imagen){
            if(basename($this->producto->imagen)!='noimage.png'){
                Storage::delete($this->producto->imagen);
            }
            $ruta=$this->imagen->store('productos');
        }
        //Actualizamos el producto
        $this->producto->update([
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'imagen'=>$ruta,
            'pvp'=>$this->pvp,
            'stock'=>$this->stock,
            'disponible'=>($this->stock>0) ? "SI" : "NO",
            'user_id'=>auth()->user()->id,
        ]);
        //Actualizamos sus etiquetas;
        $this->producto->tags()->sync($this->tags);
    }
    public function limpiarCampos(){
        $this->reset(['producto', 'nombre', 'descripcion', 'tags', 'imagen', 'pvp', 'stock']);
    }
}
