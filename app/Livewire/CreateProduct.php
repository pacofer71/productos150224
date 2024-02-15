<?php

namespace App\Livewire;

use App\Models\Tag;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use WithFileUploads;
    
    #[Validate(['nullable', 'image', 'max:2048'])]
    public $imagen;

    #[Validate(['required', 'string', 'min:3', 'unique:products,nombre'])]
    public string $nombre="";

    #[Validate(['required', 'string', 'min:10'])]
    public string $descripcion="";

    #[Validate(['required', 'integer', 'min:0'])]
    public int $stock;

    #[Validate(['required', 'decimal:0,2', 'min:0', 'max:9999.99'])]
    public float $pvp;

    #[Validate(['required', 'array', 'min:1', 'exists:tags,id'])]
    public array $tags=[];

    public function render()
    {
        $misTags=Tag::select("id", "nombre", "color")->orderBy("nombre")->get();
        return view('livewire.create-product', compact('misTags'));
    }

    public function store(){
        $this->validate();
    }









}
