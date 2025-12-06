@extends('layouts.app')

@section('title', 'Login do Associado')

@section('content')
    <x-container>

        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">
            Login do Associado
        </h2>


        <form method="POST" action="{{ route('associado.autenticar') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    E-mail
                </label>
                <x-input
                    type="email"
                    name="email_associado"
                    required
                />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Senha
                </label>
                <x-input
                    type="password"
                    name="sen_associado"
                    required
                />
            </div>

            <button
                type="submit"
                class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
            >
                Entrar
            </button>
        </form>

        <p class="text-center mt-4">
            <a href="{{ route('associado.create') }}" class="text-blue-600 hover:underline">
                Cadastrar novo Associado
            </a>
        </p>


    </x-container>

@endsection
