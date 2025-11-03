<?php

namespace App\Http\Controllers;

use App\DTO\CupomDTO;
use App\Models\Comercio;
use App\Models\Cupom;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CupomController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cnpj_comercio' => 'required|numeric|digits:14|unique:comercios,cnpj_comercio',
            'id_categoria' => 'nullable|exists:categorias,id_categoria',
            'raz_social_comercio' => 'required|string|max:50',
            'nom_fantasia_comercio' => 'required|string|max:30',
            'end_comercio' => 'required|string|max:40',
            'bai_comercio' => 'required|string|max:30',
            'cep_comercio' => 'required|string|size:8',
            'cid_comercio' => 'required|string|max:40',
            'uf_comercio' => 'required|string|size:2',
            'con_comercio' => 'required|string|max:15',
            'email_comercio' => 'required|email|max:50|unique:comercios,email_comercio',
            'sen_comercio' => 'required|string|min:6|max:64',
        ]);

        // Criptografa a senha
        $validated['sen_comercio'] = bcrypt($validated['sen_comercio']);

        Comercio::create($validated);

        return redirect()->route('comercio.login')->with('success', 'Comércio cadastrado com sucesso!');

    }

    public function create(Request $request)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1|max:100',
            'per_desconto' => 'required|integer|min:1|max:100',
            'dta_termino_cupom' => 'required|date|after_or_equal:today',
            'dta_inicio_cupom' => 'required|date|after_or_equal:today',
            'tit_cupom' => 'required|string|max:25',
        ]);

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
            ]);
        }

        return redirect()->route('comercio.cupons')->with('success', 'Cupons criados com sucesso!');
    }

    public function listarCuponsComercio()
    {
        $comercio = session('comercio');

        $cupons = Cupom::where('cnpj_comercio', $comercio->cnpj_comercio)
            ->orderBy('dta_emissao_cupom', 'desc')
            ->paginate(10);

        return view('cupomvault.comercio.cupons', compact('cupons'));
    }

    public function listarCuponsAssociado()
    {

        $associado = session('associado');


    }



    public function listarCuponsHome(Request $request)
    {
        $perPage = 10;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        $sql = '
    select c.tit_cupom,
           c.dta_emissao_cupom,
           c.dta_inicio_cupom,
           c.dta_termino_cupom,
           com.nom_fantasia_comercio,
           c.per_desc_cupom
    from cupons c
    join comercios com on c.cnpj_comercio = com.cnpj_comercio
    where not exists (
        select 1
        from cupom_associado ca
        where ca.num_cupom = c.num_cupom
    )
';

        $bindings = [];

        if ($search = $request->input('search')) {
            $sql .= ' and (c.tit_cupom ilike ? or com.nom_fantasia_comercio ilike ?)';
            $bindings[] = "%{$search}%";
            $bindings[] = "%{$search}%";
        }

        $sql .= '
    group by c.tit_cupom,
             c.dta_emissao_cupom,
             c.dta_inicio_cupom,
             c.dta_termino_cupom,
             com.nom_fantasia_comercio,
             c.per_desc_cupom
';

// Total de resultados para paginação
        $countSql = "select count(*) as total from ({$sql}) as sub";
        $total = DB::selectOne($countSql, $bindings)->total;

// Ordenação e limite
        $sql .= ' order by c.dta_termino_cupom';
        $sql .= ' limit ? offset ?';
        $bindings[] = $perPage;
        $bindings[] = $offset;

        $results = DB::select($sql, $bindings);


        $cuponsDTO = collect($results)->map(function ($item) {
            return new CupomDTO($item);
        });

        $paginated = new LengthAwarePaginator(
            $cuponsDTO,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return $paginated;
    }



}
