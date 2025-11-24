<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SenhaController extends Controller
{
    public function form()
    {
        return view('cupomvault.senha.email');
    }

    public function send(Request $request)
    {
        $email = $request->email;

        $comercio = DB::table('comercios')->where('email_comercio', $email)->first();
        $associado = DB::table('associados')->where('email_associado', $email)->first();

        $returstate = back()->with('success', 'Um link de redefinição foi enviado para seu e-mail caso ele esteja cadastrado na nossa base');
        if (!$comercio && !$associado) {
            return $returstate;
        }

        $token = Str::random(64);

        DB::table('password_resets')->where('email', $email)->delete();

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()
        ]);

        Mail::send('cupomvault.senha.mail', ['token' => $token], function ($message) use ($email) {
            $message->to($email)->subject('Redefinição de Senha');
        });

        return $returstate;
    }

    public function resetForm($token)
    {
        return view('cupomvault.senha.reset', compact('token'));
    }

    public function reset(Request $request)
    {
        $request->validate([
            'senha' => 'required|min:6|confirmed'
        ]);

        $registro = DB::table('password_resets')
            ->where('token', $request->token)
            ->first();

        if (!$registro) {
            return back()->with('error', 'Token inválido ou expirado.');
        }

        $email = $registro->email;

        $comercio = DB::table('comercios')
            ->where('email_comercio', $email)
            ->first();

        $associado = DB::table('associados')
            ->where('email_associado', $email)
            ->first();

        if ($comercio) {
            DB::table('comercios')
                ->where('email_comercio', $email)
                ->update([
                    'sen_comercio' => Hash::make($request->senha)
                ]);

        } elseif ($associado) {
            DB::table('associados')
                ->where('email_associado', $email)
                ->update([
                    'sen_associado' => Hash::make($request->senha)
                ]);

        } else {
            return back()->with('error', 'Usuário não encontrado.');
        }

        DB::table('password_resets')
            ->where('email', $email)
            ->delete();

        return redirect()
            ->route('cupomvault.home')
            ->with('success', 'Senha redefinida com sucesso.');
    }

}
