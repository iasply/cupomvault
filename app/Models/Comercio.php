<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comercio extends Model
{
public $incrementing = false;
    protected $table = 'comercios'; // chave primária
protected $primaryKey = 'cnpj_comercio'; // porque não é auto-increment
    protected $keyType = 'string'; // a chave é string

    protected $fillable = [
        'cnpj_comercio',
        'id_categoria',
        'raz_social_comercio',
        'nom_fantasia_comercio',
        'end_comercio',
        'bai_comercio',
        'cep_comercio',
        'cid_comercio',
        'uf_comercio',
        'con_comercio',
        'email_comercio',
        'sen_comercio',
    ];
}
