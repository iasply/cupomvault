<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Associado extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'associados';
    protected $primaryKey = 'cpf_associado';
    protected $keyType = 'string';
    protected $fillable = [
        'cpf_associado',
        'nom_associado',
        'dtn_associado',
        'end_associado',
        'bai_associado',
        'cep_associado',
        'cid_associado',
        'uf_associado',
        'cel_associado',
        'email_associado',
        'sen_associado'
    ];
    protected $hidden = [
        'sen_associado',
    ];
}
