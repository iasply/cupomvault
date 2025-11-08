<?php

namespace App\Http\Controllers;

use App\DTO\CupomDTO;
use App\Models\Cupom;
use App\Models\CupomAssociado;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CupomController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1|max:100',
            'per_desconto' => 'required|integer|min:1|max:100',
            'dta_termino_cupom' => 'required|date|after_or_equal:today',
            'dta_inicio_cupom' => 'required|date|after_or_equal:today',
            'tit_cupom' => 'required|string|max:25',
        ]);
        $idPromo = DB::select("SELECT nextval('cupons_id_promo_seq') AS id")[0]->id;
        $cnpj = $request->session()->get('comercio')->cnpj_comercio;

        for ($i = 0; $i < $request->quantidade; $i++) {
            Cupom::create([
                'num_cupom' => strtoupper(Str::random(12)),
                'tit_cupom' => $request->tit_cupom,
                'cnpj_comercio' => $cnpj,
                'dta_emissao_cupom' => now(),
                'dta_inicio_cupom' => $request->dta_inicio_cupom,
                'dta_termino_cupom' => $request->dta_termino_cupom,
                'per_desc_cupom' => $request->per_desconto,
                'id_promo' => $idPromo,
            ]);
        }

        return redirect()->route('comercio.cupons')->with('success', 'Cupons criados com sucesso!');
    }

    public function listarCuponsComercio()
    {
        $comercio = session('comercio');

        // Busca os cupons com nome do comércio
        $query = DB::table('cupons as c')
            ->join('comercios as co', 'co.cnpj_comercio', '=', 'c.cnpj_comercio')
            ->select(
                'c.tit_cupom',
                'c.per_desc_cupom',
                'c.dta_inicio_cupom',
                'c.dta_termino_cupom',
                'c.dta_emissao_cupom',
                'c.id_promo',
                'co.nom_fantasia_comercio'
            )
            ->where('c.cnpj_comercio', $comercio->cnpj_comercio)
            ->groupBy(
                'c.tit_cupom',
                'c.per_desc_cupom',
                'c.dta_inicio_cupom',
                'c.dta_termino_cupom',
                'c.dta_emissao_cupom',
                'c.id_promo',
                'co.nom_fantasia_comercio'
            )
            ->orderBy('c.dta_emissao_cupom', 'desc');

        // Paginação manual para converter em DTOs
        $perPage = 10;
        $page = request('page', 1);

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        // Converte cada item para DTO
        $dtoCollection = $paginator->getCollection()->map(fn($item) => new CupomDTO($item));

        // Substitui a coleção paginada pelos DTOs
        $cupons = new LengthAwarePaginator(
            $dtoCollection,
            $paginator->total(),
            $paginator->perPage(),
            $paginator->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('cupomvault.comercio.cupons', compact('cupons'));
    }


    public function listarCuponsHome(Request $request)
    {
        $perPage = 10;
        $page = $request->input('page', 1);

        $query = DB::table('cupons as c')
            ->join('comercios as com', 'com.cnpj_comercio', '=', 'c.cnpj_comercio')
            ->select(
                'c.tit_cupom',
                'c.dta_inicio_cupom',
                'c.dta_termino_cupom',
                'com.nom_fantasia_comercio',
                'c.per_desc_cupom',
                'c.id_promo',
                'c.dta_emissao_cupom'
            )
            ->whereNotExists(function ($subquery) {
                $subquery->select(DB::raw(1))
                    ->from('cupom_associado as ca')
                    ->whereColumn('ca.num_cupom', 'c.num_cupom');
            });

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('c.tit_cupom', 'ilike', "%{$search}%")
                    ->orWhere('com.nom_fantasia_comercio', 'ilike', "%{$search}%");
            });
        }

        $query->groupBy(
            'c.tit_cupom',
            'c.dta_inicio_cupom',
            'c.dta_termino_cupom',
            'com.nom_fantasia_comercio',
            'c.per_desc_cupom',
            'c.id_promo',
            'c.dta_emissao_cupom'
        )->orderBy('c.dta_termino_cupom');

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        $dtoCollection = $paginator->getCollection()->map(fn($item) => new CupomDTO($item));

        $cupons = new LengthAwarePaginator(
            $dtoCollection,
            $paginator->total(),
            $paginator->perPage(),
            $paginator->currentPage(),
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return $cupons;
    }


    public function ativar(Request $request, $id)
    {
        $associado = session('associado');

        if (!$associado) {
            return redirect()
                ->route('login')
                ->with('error', 'Você precisa estar logado para ativar um cupom.');
        }

        $sql = "
        select *
        from cupons c
        where c.id_promo = ?
          and not exists (
              select 1
              from cupom_associado ca
              where ca.num_cupom = c.num_cupom
                 or ca.cpf_associado = ?
          )
        limit 1
    ";

        $cupom = collect(DB::select($sql, [$id, $associado->cpf_associado]))->first();

        if (!$cupom) {
            return redirect()
                ->route('cupomvault.associado.home')
                ->with('error', 'Nenhum cupom disponível ou já vinculado ao seu CPF.');
        }

        CupomAssociado::create([
            'num_cupom' => $cupom->num_cupom,
            'cpf_associado' => $associado->cpf_associado,
            'dta_cupom_associado' => now(),
            'dta_uso_cupom_associado' => null,
        ]);

        return redirect()
            ->route('cupomvault.associado.home')
            ->with('success', 'Cupom ativado com sucesso!');
    }
}
