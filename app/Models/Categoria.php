<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $primaryKey = 'id_categoria';

    public $timestamps = false;

    protected $fillable = [
        'nom_categoria',
    ];

    public function comercios(): HasMany
    {
        return $this->hasMany(Comercio::class, 'id_categoria', 'id_categoria');
    }
}
