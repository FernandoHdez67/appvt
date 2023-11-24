<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    public $timestamps = false;
    protected $table="tbl_carrito";
    protected $primaryKey = 'idcarrito';
    protected $fillable = ['idproducto', 'idusuario','imagen', 'nombre', 'cantidad', 'precio','total'];

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idproducto');
    }
}
