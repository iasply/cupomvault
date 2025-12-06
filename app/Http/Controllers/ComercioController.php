<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ComercioController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cnpj_comercio' => 'required|numeric|digits:14|unique:comercios,cnpj_comercio',
            'id_categoria' => 'required|exists:categorias,id_categoria',
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

        $validated['sen_comercio'] = bcrypt($validated['sen_comercio']);

        Comercio::create($validated);

        return redirect()->route('comercio.login')->with('success', 'Comércio cadastrado com sucesso!');

    }

    public function create()
    {
        return view('cupomvault.comercio.comercio');
    }

    public function login()
    {
        return view('cupomvault.comercio.login');
    }

    public function autenticar(Request $request)
    {
        $request->validate([
            'email_comercio' => 'required|email',
            'sen_comercio' => 'required|string',
        ]);

        $comercio = Comercio::where('email_comercio', $request->email_comercio)->first();

        if ($comercio && Hash::check($request->sen_comercio, $comercio->sen_comercio)) {
            // Armazena comércio logado na sessão
            $request->session()->put('comercio', $comercio);

            return redirect()->route('comercio.home')->with('success', 'Login realizado com sucesso!');
        }

        return back()->with('error', 'E-mail ou senha inválidos.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('comercio');
        return redirect()->route('cupomvault.home')->with('success', 'Logout realizado com sucesso!');
    }


    public function home()
    {
        return view('cupomvault.comercio.home');
    }

    public function perfil(Request $request)
    {
        $cnpj = $request->session()->get('comercio')->cnpj_comercio ?? null;

        if (!$cnpj) {
            return redirect()->route('comercio.login')->with('error', 'Você precisa estar logado.');
        }

        $comercio = Comercio::find($cnpj);

        return view('cupomvault.comercio.perfil', compact('comercio'));
    }


}
