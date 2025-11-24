@extends('layouts.app')

@section('content')
    <x-container>
        <h2 class="text-xl mb-4 font-semibold">Defina sua nova senha</h2>

        <form method="POST" action="{{ route('senha.reset') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <input type="password" name="senha" required
                       class="w-full border px-3 py-2 rounded"
                       placeholder="Nova senha">
            </div>

            <div>
                <input type="password" name="senha_confirmation" required
                       class="w-full border px-3 py-2 rounded"
                       placeholder="Confirme a nova senha">
            </div>

            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Salvar nova senha
            </button>
        </form>
    </x-container>

@endsection
