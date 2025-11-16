<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AssociadoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cpf_associado' => 'required|numeric|unique:associados,cpf_associado',
            'nom_associado' => 'required|string|max:40',
            'dtn_associado' => 'nullable|date',
            'end_associado' => 'required|string|max:40',
            'bai_associado' => 'required|string|max:30',
            'cep_associado' => 'required|string|max:8',
            'cid_associado' => 'required|string|max:40',
            'uf_associado' => 'required|string|size:2',
            'cel_associado' => 'required|string|max:15',
            'email_associado' => 'required|email|max:50|unique:associados,email_associado',
            'sen_associado' => 'required|string|max:64',
        ]);

        $validated['sen_associado'] = bcrypt($validated['sen_associado']);

        Associado::create($validated);

        return redirect()
            ->route('associado.login')
            ->with('success', 'Associado cadastrado com sucesso!');
    }

    public function create()
    {
        return view('cupomvault.associado.associado');
    }

    public function login()
    {
        return view('cupomvault.associado.login');
    }

    public function autenticar(Request $request)
    {
        $request->validate([
            'email_associado' => 'required|email',
            'sen_associado' => 'required|string',
        ]);

        $associado = Associado::where('email_associado', $request->email_associado)->first();

        if ($associado && Hash::check($request->sen_associado, $associado->sen_associado)) {
            $request->session()->put('associado', $associado);

            return redirect()->route('associado.home')->with('success', 'Login realizado com sucesso!');
        }

        return back()->with('error', 'E-mail ou senha inválidos.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('associado');
        return redirect()->route('cupomvault.home')->with('success', 'Logout realizado com sucesso!');
    }


    public function home(Request $request)
    {
        $cupomController = new CupomController();
        $cupons = $cupomController->listarCuponsHome($request);

        return view('cupomvault.associado.home', compact('cupons'));
    }

    public function perfil(Request $request)
    {
        $associado = $request->session()->get('associado');

        if (!$associado) {
            return redirect()->route('associado.login')->with('error', 'Faça login primeiro.');
        }

        return view('cupomvault.associado.perfil', compact('associado'));
    }

}
