@extends('layouts.app')

@section('content')
    <x-container>
        <h2 class="text-xl mb-4 font-semibold">Redefinir Senha</h2>

        <form method="POST" action="{{ route('senha.send') }}" class="space-y-4">
            @csrf

            <input type="email" name="email" required
                   class="w-full border px-3 py-2 rounded"
                   placeholder="Seu e-mail">

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Enviar link de redefinição
            </button>
        </form>
    </x-container>
@endsection
