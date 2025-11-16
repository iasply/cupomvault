@extends('layouts.app')

@section('title', 'Login do Comércio')

@section('content')
<x-container>

        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">
            Login do Comércio
        </h2>

        @if(session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('comercio.autenticar') }}" class="space-y-5">
            @csrf

            {{-- E-mail --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    E-mail
                </label>
                <x-input
                    type="email"
                    name="email_comercio"
                    required
                />
            </div>

            {{-- Senha --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Senha
                </label>
                <x-input
                    type="password"
                    name="sen_comercio"
                    required
                />
            </div>

            {{-- Botão --}}
            <button
                type="submit"
                class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
            >
                Entrar
            </button>
        </form>

        <p class="text-center mt-4">
            <a href="{{ route('comercio.create') }}" class="text-blue-600 hover:underline">
                Cadastrar novo comércio
            </a>
        </p>
</x-container>

@endsection
