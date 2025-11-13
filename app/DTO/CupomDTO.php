<?php

namespace App\DTO;

use Carbon\Carbon;

class CupomDTO
{
    public string $tit_cupom;
    public ?string $nom_fantasia_comercio;
    public ?string $bai_comercio;
    public ?string $uf_comercio;
    public ?string $cep_comercio;
    public ?string $end_comercio;
    public ?string $num_cupom;
    public ?Carbon $dta_emissao_cupom;
    public ?Carbon $dta_inicio_cupom;
    public ?Carbon $dta_termino_cupom;
    public ?Carbon $dta_uso_cupom_associado;
    public ?int $per_desc_cupom;
    public ?int $id_promo;
    public function __construct(object $item)
    {
        $this->tit_cupom = $item->tit_cupom ?? '';
        $this->nom_fantasia_comercio = $item->nom_fantasia_comercio ?? 'Comércio não informado';
        $this->bai_comercio = $item->bai_comercio ?? null;
        $this->uf_comercio = $item->uf_comercio ?? null;
        $this->cep_comercio = $item->cep_comercio ?? null;
        $this->end_comercio = $item->end_comercio ?? null;
        $this->num_cupom = $item->num_cupom ?? null;

        $this->dta_emissao_cupom = isset($item->dta_emissao_cupom) ? new Carbon($item->dta_emissao_cupom) : null;
        $this->dta_inicio_cupom = isset($item->dta_inicio_cupom) ? new Carbon($item->dta_inicio_cupom) : null;
        $this->dta_termino_cupom = isset($item->dta_termino_cupom) ? new Carbon($item->dta_termino_cupom) : null;
        $this->dta_uso_cupom_associado = isset($item->dta_uso_cupom_associado) ? new Carbon($item->dta_uso_cupom_associado) : null;

        $this->per_desc_cupom = $item->per_desc_cupom ?? null;
        $this->id_promo = $item->id_promo ?? 0;
    }
}
