@php
    use App\Enums\CategoriaComercio;

    $tiposComercio = collect(CategoriaComercio::cases())
        ->mapWithKeys(fn($c) => [$c->value => ucfirst(str_replace('_', ' ', strtolower($c->label())))]);
@endphp

@extends('layouts.app')

@section('title', 'Novo Comércio')

@section('content')
    <div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded-xl p-8">

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Cadastro de Comércio 🏪
        </h2>

        {{-- Sucesso --}}
        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        {{-- Erros --}}
        @if($errors->any())
            <div class="alert error mb-4">
                <ul class="list-disc ml-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ url('/cupomvault/comercio') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CNPJ</label>
                <x-input name="cnpj_comercio" value="{{ old('cnpj_comercio') }}" required/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Razão Social</label>
                <x-input name="raz_social_comercio" value="{{ old('raz_social_comercio') }}" required/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome Fantasia</label>
                <x-input name="nom_fantasia_comercio" value="{{ old('nom_fantasia_comercio') }}" required/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                <x-input name="end_comercio" value="{{ old('end_comercio') }}" required/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bairro</label>
                <x-input name="bai_comercio" value="{{ old('bai_comercio') }}" required/>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CEP</label>
                    <x-input name="cep_comercio" value="{{ old('cep_comercio') }}" required/>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">UF</label>
                    <x-input name="uf_comercio" value="{{ old('uf_comercio') }}" maxlength="2" required/>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
                <x-input name="cid_comercio" value="{{ old('cid_comercio') }}" required/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contato</label>
                <x-input name="con_comercio" value="{{ old('con_comercio') }}" required/>
            </div>

            <x-select
                label="Tipo de Comércio"
                name="id_categoria"
                :options="$tiposComercio"
            />

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                <x-input type="email" name="email_comercio" value="{{ old('email_comercio') }}" required/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                <x-input type="password" name="sen_comercio" required/>
            </div>


            <button
                type="submit"
                class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                Cadastrar
            </button>

            <p class="text-center mt-4 text-sm">
                Já possui cadastro?
                <a href="{{ route('comercio.login') }}" class="text-blue-600 hover:underline font-medium">
                    Clique aqui para fazer login
                </a>
            </p>
        </form>
    </div>
@endsection
