<?php

namespace App\View;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class PaginatorSearchRawSQL
{
    public int $pageLimit = 10;
    private int $page;
    private ?string $busca;
    private array $bindings;
    private string $rawSql;
    private ?string $status;
    private Request $request;
    private int $total;
    private ?string $groupAndOrder;
    private ?int $comercio;

    public function __construct(string $rawSql, ?string $groupAndOrder, array $bindings, Request $request)
    {
        $this->request = $request;
        $this->rawSql = $rawSql;
        $this->bindings = $bindings;
        $this->page = max((int)$request->get('page', 1), 1);
        $this->busca = $request->get('busca');
        $this->status = $request->get('status');
        $this->comercio = $request->get('comercio');

        $this->groupAndOrder = $groupAndOrder;
    }

    private function getOffset(): int
    {
        return ($this->page - 1) * $this->pageLimit;
    }

    private function getStatusRaw(): string
    {
        $statusRaw = "";
        switch ($this->status) {
            case 'utilizado':
                $statusRaw  .= " and ca.dta_uso_cupom_associado is not null ";
                break;
            case 'nao_utilizado':
                $statusRaw  .= " and ca.dta_uso_cupom_associado is null ";
                break;
            case 'vencido':
                $statusRaw  .= " and c.dta_termino_cupom < current_date ";
                break;
            case 'ativo':
                $statusRaw  .= " and c.dta_inicio_cupom <= current_date and c.dta_termino_cupom >= current_date ";
                break;
        }

        return $statusRaw;
    }

    private function getBuscaRaw(): string
    {
        $buscaRaw = "";
        if (!empty($this->busca)) {
            $buscaRaw .= " and (lower(c.tit_cupom) like lower(:busca) or lower(cm.nom_fantasia_comercio) like lower(:busca)) ";
        }
        return $buscaRaw;
    }

    private function getPaginatedRaw(): string
    {
        $groupAndOrder = $this->groupAndOrder ?? '';
        return "
            select *
            from (
                select t.*,
                       count(*) over() as total_count,
                       row_number() over(order by 1) as rn
                from (
                    {$this->rawSql}
                    {$this->getStatusRaw()}
                    {$this->getBuscaRaw()}
                    {$this->getComercioRaw()}
                    {$groupAndOrder}
                    ) t
            ) sub
            where rn between :offset + 1 and :offset + :limit
        ";
    }

    public function execute(): Collection
    {
        if (!empty($this->busca)) {
            $this->bindings['busca'] = "%{$this->busca}%";
        }
        if (!empty($this->comercio)) {
            $this->bindings['comercio'] = $this->comercio;
        }
        $bindings = array_merge(
            $this->bindings,
            [
                'offset' => $this->getOffset(),
                'limit' => $this->pageLimit
            ]
        );
        // dd($this->getPaginatedRaw());
        $results = collect(DB::select($this->getPaginatedRaw(), $bindings));
        $this->total = $results->first()->total_count ?? 0;

        return $results;
    }

    public function getPaginator(Collection $list): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            $list,
            $this->total,
            $this->pageLimit,
            $this->page,
            ['path' => $this->request->url(), 'query' => $this->request->query()]
        );
    }
    private function getComercioRaw(): string
    {
        $comercioRaw = "";

        if (!empty($this->comercio)) {
            $comercioRaw .= " and cm.id_categoria = :comercio ";
        }

        return $comercioRaw;
    }

}
