@extends('layouts.app')

@section('title', 'Novo Associado')

@section('content')
    <div class="container">
        <h2>Cadastro de Associado 🧑</h2>

        {{-- Mensagens de sucesso --}}
        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        {{-- Exibição de erros --}}
        @if($errors->any())
            <div class="alert error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('associado.save') }}" method="post" class="form-box">
            @csrf

            <div class="form-group">
                <label for="cpf_associado">CPF</label>
                <input type="text" id="cpf_associado" name="cpf_associado" value="{{ old('cpf_associado') }}" required>
            </div>

            <div class="form-group">
                <label for="nom_associado">Nome Completo</label>
                <input type="text" id="nom_associado" name="nom_associado" value="{{ old('nom_associado') }}" required>
            </div>

            <div class="form-group">
                <label for="dtn_associado">Data de Nascimento</label>
                <input type="date" id="dtn_associado" name="dtn_associado" value="{{ old('dtn_associado') }}">
            </div>

            <div class="form-group">
                <label for="end_associado">Endereço</label>
                <input type="text" id="end_associado" name="end_associado" value="{{ old('end_associado') }}" required>
            </div>

            <div class="form-group">
                <label for="bai_associado">Bairro</label>
                <input type="text" id="bai_associado" name="bai_associado" value="{{ old('bai_associado') }}" required>
            </div>

            <div class="form-row">
                <div class="form-group small">
                    <label for="cep_associado">CEP</label>
                    <input type="text" id="cep_associado" name="cep_associado" value="{{ old('cep_associado') }}"
                           required>
                </div>

                <div class="form-group small">
                    <label for="uf_associado">UF</label>
                    <input type="text" id="uf_associado" name="uf_associado" value="{{ old('uf_associado') }}"
                           maxlength="2" required>
                </div>
            </div>

            <div class="form-group">
                <label for="cid_associado">Cidade</label>
                <input type="text" id="cid_associado" name="cid_associado" value="{{ old('cid_associado') }}" required>
            </div>

            <div class="form-group">
                <label for="cel_associado">Celular</label>
                <input type="text" id="cel_associado" name="cel_associado" value="{{ old('cel_associado') }}" required>
            </div>

            <div class="form-group">
                <label for="email_associado">Email</label>
                <input type="email" id="email_associado" name="email_associado" value="{{ old('email_associado') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="sen_associado">Senha</label>
                <input type="password" id="sen_associado" name="sen_associado" required>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>

            <p class="login-option">
                Já possui cadastro?
                <a href="{{ route('associado.login') }}">Clique aqui para fazer login</a>
            </p>
        </form>
    </div>

    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        .alert {
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-box {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #34495e;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            transition: border-color 0.2s ease;
        }

        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .form-row .form-group.small {
            flex: 1;
        }

        .btn {
            display: block;
            width: 100%;
            text-align: center;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .login-option {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .login-option a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .login-option a:hover {
            text-decoration: underline;
        }
    </style>
@endsection
