<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CupomAssociado extends Model
{
    use HasFactory;

    protected $table = 'cupom_associado';
    protected $primaryKey = 'id_cupom_associado';
    public $timestamps = false;

    protected $fillable = [
        'num_cupom',
        'cpf_associado',
        'dta_cupom_associado',
        'dta_uso_cupom_associado',
    ];

    protected $dates = [
        'dta_cupom_associado',
        'dta_uso_cupom_associado',
    ];


    public function cupom()
    {
        return $this->belongsTo(Cupom::class, 'num_cupom', 'num_cupom');
    }

    public function associado()
    {
        return $this->belongsTo(Associado::class, 'cpf_associado', 'cpf_associado');
    }
}
