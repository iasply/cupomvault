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

        $perPage = 10;
        $page = request('page', 1);

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        $dtoCollection = $paginator->getCollection()->map(fn($item) => new CupomDTO($item));

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
        $associado = session('associado');
        $cpf = $associado->cpf_associado ?? null;

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
            ->whereNotIn('c.id_promo', function ($subquery) use ($cpf) {
                $subquery->select('cp.id_promo')
                    ->from('cupom_associado as ca')
                    ->join('cupons as cp', 'cp.num_cupom', '=', 'ca.num_cupom')
                    ->where('ca.cpf_associado', $cpf);
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
        )->orderBy('c.dta_termino_cupom', 'asc');


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
                ->route('associado.login')
                ->with('error', 'Você precisa estar logado para ativar um cupom.');
        }

        $sql = "
                  select 1
            from cupom_associado ca,
                 cupons c
            where 1 = 1
              and c.id_promo = ?
              and ca.cpf_associado = ?
              and c.num_cupom = ca.num_cupom
                ";

        $existe = !empty(DB::select($sql, [$id, $associado->cpf_associado]));


        if ($existe) {
            return redirect()
                ->route('associado.home')
                ->with('error', 'Nenhum cupom disponível ou já vinculado ao seu CPF.');
        }

        $cupom = Cupom::where('id_promo', $id)
            ->whereNotExists(function ($sub) use ($associado) {
                $sub->select(DB::raw(1))
                    ->from('cupom_associado as ca')
                    ->whereColumn('ca.num_cupom', 'cupons.num_cupom')
                    ->where('ca.cpf_associado', $associado->cpf_associado);
            })
            ->first();
        CupomAssociado::create([
            'num_cupom' => $cupom->num_cupom,
            'cpf_associado' => $associado->cpf_associado,
            'dta_cupom_associado' => now(),
            'dta_uso_cupom_associado' => null,
        ]);

        return redirect()
            ->route('associado.home')
            ->with('success', 'Cupom ativado com sucesso!');
    }


    public function cuponsUsuario(Request $request){
        $associado = session('associado');

        if (!$associado) {
            return redirect()
                ->route('associado.login')
                ->with('error', 'Você precisa estar logado para ativar um cupom.');
        }



    }
}
