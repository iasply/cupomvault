<?php

namespace App\Http\Controllers;

use App\DTO\CupomDTO;
use App\Models\Cupom;
use App\Models\CupomAssociado;
use App\View\PaginatorSearchRawSQL;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
class CupomController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1|max:100',
            'per_desconto' => 'required|integer|min:1|max:100',
            'dta_inicio_cupom' => ['required', 'date', function ($attribute, $value, $fail) {
                if (Carbon::parse($value)->startOfDay()->lt(Carbon::today())) {
                    $fail('A data de início não pode ser anterior a hoje.');
                }
            }],
            'dta_termino_cupom' => ['required', 'date', function ($attribute, $value, $fail) {
                if (Carbon::parse($value)->startOfDay()->lt(Carbon::today())) {
                    $fail('A data de término não pode ser anterior a hoje.');
                }
            }],
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

    public function listarCuponsComercio(Request $request)
    {
        $comercio = session('comercio');
        $bindings = ['cnpj' => $comercio->cnpj_comercio];

        $sql = "
        select
            c.tit_cupom,
            c.per_desc_cupom,
            c.dta_inicio_cupom,
            c.dta_termino_cupom,
            c.dta_emissao_cupom,
            c.id_promo,
            cm.nom_fantasia_comercio
        from cupons c
        join comercios cm on cm.cnpj_comercio = c.cnpj_comercio
        where c.cnpj_comercio = :cnpj
    ";

        $paginatorRaw = new PaginatorSearchRawSQL($sql, " group by
          c.tit_cupom,
            c.per_desc_cupom,
            c.dta_inicio_cupom,
            c.dta_termino_cupom,
            c.dta_emissao_cupom,
            c.id_promo,
            cm.nom_fantasia_comercio
            order by c.dta_emissao_cupom desc ", $bindings, $request);
        $rows = collect($paginatorRaw->execute())
            ->map(fn($r) => new CupomDTO($r));

        $cupons = $paginatorRaw->getPaginator($rows);

        return view('cupomvault.comercio.cupons', compact('cupons'));
    }


    public function listarCuponsHome(Request $request)
    {
        $associado = session('associado');
        $cpf = $associado->cpf_associado ?? null;

        $bindings = ['cpf' => $cpf];

        $sql = "
        select
            c.tit_cupom,
            c.dta_inicio_cupom,
            c.dta_termino_cupom,
            c.per_desc_cupom,
            c.id_promo,
            cm.nom_fantasia_comercio,
            c.dta_emissao_cupom
        from cupons c
        join comercios cm on cm.cnpj_comercio = c.cnpj_comercio
        where c.id_promo not in (
            select cp.id_promo
            from cupom_associado ca
            join cupons cp on cp.num_cupom = ca.num_cupom
            where ca.cpf_associado = :cpf
        )
    ";


        $paginatorRaw = new PaginatorSearchRawSQL($sql, " group by
            c.tit_cupom,
            c.dta_inicio_cupom,
            c.dta_termino_cupom,
            c.per_desc_cupom,
            c.id_promo,
            cm.nom_fantasia_comercio,
            c.dta_emissao_cupom
            order by c.dta_termino_cupom asc ", $bindings, $request);
        $rows = collect($paginatorRaw->execute())
            ->map(fn($r) => new CupomDTO($r));

        return $paginatorRaw->getPaginator($rows);
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


    public function cuponsUsuario(Request $request)
    {
        $associado = session('associado');

        if (!$associado) {
            return redirect()
                ->route('associado.login')
                ->with('error', 'Você precisa estar logado para visualizar seus cupons.');
        }

        $cpf = $associado->cpf_associado;

        $sqlBase = "
        select
            c.tit_cupom,
            c.dta_inicio_cupom,
            c.dta_termino_cupom,
            c.per_desc_cupom,
            c.id_promo,
            c.num_cupom,
            cm.nom_fantasia_comercio,
            cm.bai_comercio,
            cm.uf_comercio,
            cm.cep_comercio,
            cm.end_comercio,
            ca.dta_uso_cupom_associado
        from cupons c
        join comercios cm on cm.cnpj_comercio = c.cnpj_comercio
        join cupom_associado ca on ca.num_cupom = c.num_cupom
        where ca.cpf_associado = :cpf
    ";

        $bindings = ['cpf' => $cpf];

        $paginatorRaw = new PaginatorSearchRawSQL($sqlBase, " order by c.dta_termino_cupom desc ", $bindings, $request);

        $rows = collect($paginatorRaw->execute())
            ->map(fn($r) => new CupomDTO($r));

        $paginator = $paginatorRaw->getPaginator($rows);

        return view('cupomvault.associado.cupons', [
            'cupons' => $paginator,
        ]);

    }


    public function usar()
    {
        return view('cupomvault.comercio.usar');
    }

    public function confirmarUso(Request $request)
    {
        $comercio = session('comercio');

        if (!$comercio) {
            return back()->with('error', 'Nenhum comércio logado.');
        }

        $request->validate([
            'cpf' => 'required',
            'num_cupom' => 'required'
        ]);

        $cnpjComercio = $comercio->cnpj_comercio;
        $cpfAssociado = $request->cpf;
        $numeroCupom = $request->num_cupom;

        $registro = DB::table('cupom_associado as ca')
            ->join('cupons as c', 'ca.num_cupom', '=', 'c.num_cupom')
            ->join('comercios as co', 'co.cnpj_comercio', '=', 'c.cnpj_comercio')
            ->where('co.cnpj_comercio', $cnpjComercio)
            ->where('ca.num_cupom', $numeroCupom)
            ->where('ca.cpf_associado', $cpfAssociado)
            ->whereNull('ca.dta_uso_cupom_associado')
            ->first();

        if (!$registro) {
            return back()->with('error', 'Cupom inválido, não pertence a este comércio ou já foi usado.');
        }

        CupomAssociado::where('id_cupom_associado', $registro->id_cupom_associado)
            ->update(['dta_uso_cupom_associado' => now()]);

        return back()->with('success', 'Cupom ativado com sucesso!');
    }

    public function detalhes($id)
    {
        $sql = "
        select
            c.tit_cupom,
            c.num_cupom,
            c.per_desc_cupom,
            to_char(c.dta_termino_cupom, 'DD/MM/YYYY') as validade,
            c.id_promo,
            ca.dta_uso_cupom_associado as data_uso,
            case
                when ca.num_cupom is not null then 'utilizado'
                else 'não utilizado'
            end as status,
            sum(case when ca.num_cupom is not null then 1 else 0 end) over() as usados,
            count(*) over() - sum(case when ca.num_cupom is not null then 1 else 0 end) over() as faltam
        from cupons c
        left join cupom_associado ca
            on ca.num_cupom = c.num_cupom
        where c.id_promo = :id_promo
        order by ca.dta_uso_cupom_associado
    ";

        $cupons = DB::select($sql, ['id_promo' => $id]);

        return response()->json($cupons);
    }

    public function delete($id)
    {
        $comercio = session('comercio');

        if (!$comercio) {
            return redirect()
                ->route('comercio.cupons')
                ->with('error', 'Nenhum comércio logado.');
        }

        $sqlVerifica = "
        select 1
          from cupons c
          join cupom_associado ca
            on ca.num_cupom = c.num_cupom
         where c.id_promo = ?
    ";

        $existeUtilizado = !empty(DB::select($sqlVerifica, [$id]));

        if ($existeUtilizado) {
            return redirect()
                ->route('comercio.cupons')
                ->with('error', 'Não é possível excluir esta promoção porque já existem cupons utilizados.');
        }

        DB::table('cupons')
            ->where('id_promo', $id)
            ->delete();

        return redirect()
            ->route('comercio.cupons')
            ->with('success', 'Promoção excluída com sucesso.');
    }

}
