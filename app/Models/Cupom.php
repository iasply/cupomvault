<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cupom extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'cupons';
    protected $primaryKey = 'num_cupom';
    protected $keyType = 'string';
    protected $fillable = [
        'num_cupom',
        'tit_cupom',
        'cnpj_comercio',
        'dta_emissao_cupom',
        'dta_inicio_cupom',
        'dta_termino_cupom',
        'per_desc_cupom',
        'id_promo',
    ];

    protected $dates = [
        'dta_emissao_cupom',
        'dta_inicio_cupom',
        'dta_termino_cupom',
    ];
    protected $casts = [
        'dta_emissao_cupom' => 'datetime',
        'dta_inicio_cupom' => 'datetime',
        'dta_termino_cupom' => 'datetime',
    ];

    /**
     * Relacionamento com o comércio.
     */
    public function comercio(): BelongsTo
    {
        return $this->belongsTo(Comercio::class, 'cnpj_comercio', 'cnpj_comercio');
    }
}
