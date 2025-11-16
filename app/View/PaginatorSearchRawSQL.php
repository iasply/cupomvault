<?php

namespace App\View;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PaginatorSearchRawSQL
{
    public int $pageLimit = 10;
    private int $page;
    private ?string $busca;
    private array $bindings;
    private string $rawSql;
    private $status;
    private Request $request;
    private int $total;
    private string $groupAndOrder;

    public function __construct(string $rawSql, string $groupAndOrder, array $bindings, Request $request)
    {
        $this->request = $request;
        $this->rawSql = $rawSql;
        $this->bindings = $bindings;
        $this->page = max((int)$request->get('page', 1), 1);
        $this->busca = $request->get('busca');
        $this->status = $request->get('status');
        $this->groupAndOrder = $groupAndOrder;
    }

    private function getOffset(): int
    {
        return ($this->page - 1) * $this->pageLimit;
    }

    private function getStatusRaw(): string
    {
        return "
            and (
             case ?
                 when 'utilizado' then (ca.dta_uso_cupom_associado is not null)
                when 'nao_utilizado' then (ca.dta_uso_cupom_associado is null)
                when 'vencido' then (c.dta_termino_cupom < current_date)
                when 'ativo' then (c.dta_inicio_cupom <= current_date and c.dta_termino_cupom >= current_date)
                else true
             end
            )
        ";
    }

    private function getBuscaRaw(): string
    {
        return "
            and (
                :busca is null
                or lower(c.tit_cupom) like lower(concat('%', :busca, '%'))
                or lower(cm.nom_fantasia_comercio) like lower(concat('%', :busca, '%'))
            )
        ";
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
                    {$groupAndOrder}
                    ) t
            ) sub
            where rn between :offset + 1 and :offset + :limit
        ";
    }

    public function execute(): array
    {
        $bindings = array_merge(
            $this->bindings,
            [
                'busca' => $this->busca,
                'status' => $this->status,
                'offset' => $this->getOffset(),
                'limit' => $this->pageLimit
            ]
        );

        $results = DB::select($this->getPaginatedRaw(), $bindings);

        $this->total = $results[0]->total_count ?? 0;

        return $results;
    }

    public function getPaginator(array $list): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            $list,
            $this->total,
            $this->pageLimit,
            $this->page,
            ['path' => $this->request->url(), 'query' => $this->request->query()]
        );
    }
}
