<?php

namespace App\DTO;

use Carbon\Carbon;

class CupomDTO
{
    public string $tit_cupom;
    public ?string $nom_fantasia_comercio;
    public ?Carbon $dta_emissao_cupom;
    public ?Carbon $dta_inicio_cupom;
    public ?Carbon $dta_termino_cupom;
    public ?int $per_desc_cupom;
    public ?int $id_promo;

    public function __construct(object $item)
    {
        $this->tit_cupom = $item->tit_cupom ?? '';
        $this->nom_fantasia_comercio = $item->nom_fantasia_comercio ?? 'Comércio não informado';
        $this->dta_emissao_cupom = isset($item->dta_emissao_cupom) ? new Carbon($item->dta_emissao_cupom) : null;
        $this->dta_inicio_cupom = isset($item->dta_inicio_cupom) ? new Carbon($item->dta_inicio_cupom) : null;
        $this->dta_termino_cupom = isset($item->dta_termino_cupom) ? new Carbon($item->dta_termino_cupom) : null;
        $this->per_desc_cupom = $item->per_desc_cupom ?? null;
        $this->id_promo = $item->id_promo ?? 0;
    }
}
