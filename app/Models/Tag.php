<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;
    protected $fillable=['nombre', 'color'];

    //Relacion N_M con productos
    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class);
    }
    //Accesor y Muttators
    public function nombre(): Attribute{
        return Attribute::make(
            set: fn($v)=>strtolower("#$v"),
        );
    }
}
