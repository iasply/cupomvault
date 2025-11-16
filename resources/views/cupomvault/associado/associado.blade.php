@extends('layouts.app')

@section('title', 'Novo Associado')

@section('content')
    <x-container>

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Cadastro de Associado 🧑
        </h2>

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert error mb-4">
                <ul class="list-disc ml-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('associado.save') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                <x-input name="cpf_associado" value="{{ old('cpf_associado') }}" required/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                <x-input name="nom_associado" value="{{ old('nom_associado') }}" required/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data de Nascimento</label>
                <x-input type="date" name="dtn_associado" value="{{ old('dtn_associado') }}"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                <x-input name="end_associado" value="{{ old('end_associado') }}" required/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bairro</label>
                <x-input name="bai_associado" value="{{ old('bai_associado') }}" required/>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CEP</label>
                    <x-input name="cep_associado" value="{{ old('cep_associado') }}" required/>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">UF</label>
                    <x-input name="uf_associado" maxlength="2" value="{{ old('uf_associado') }}" required/>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
                <x-input name="cid_associado" value="{{ old('cid_associado') }}" required/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Celular</label>
                <x-input name="cel_associado" value="{{ old('cel_associado') }}" required/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                <x-input type="email" name="email_associado" value="{{ old('email_associado') }}" required/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                <x-input type="password" name="sen_associado" required/>
            </div>

            <button
                type="submit"
                class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                Cadastrar
            </button>

            <p class="text-center mt-4 text-sm">
                Já possui cadastro?
                <a href="{{ route('associado.login') }}" class="text-blue-600 hover:underline font-medium">
                    Clique aqui para fazer login
                </a>
            </p>
        </form>

</x-container>
@endsection
