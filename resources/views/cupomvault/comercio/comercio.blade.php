@extends('layouts.app')

@section('title', 'Novo Comércio')

@section('content')
    <div class="container">
        <h2>Cadastro de Comércio 🏪</h2>

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

        <form action="{{ url('/cupomvault/comercio') }}" method="post" class="form-box">
            @csrf

            <div class="form-group">
                <label for="cnpj_comercio">CNPJ</label>
                <input type="text" id="cnpj_comercio" name="cnpj_comercio" value="{{ old('cnpj_comercio') }}" required>
            </div>

            <div class="form-group">
                <label for="raz_social_comercio">Razão Social</label>
                <input type="text" id="raz_social_comercio" name="raz_social_comercio"
                       value="{{ old('raz_social_comercio') }}" required>
            </div>

            <div class="form-group">
                <label for="nom_fantasia_comercio">Nome Fantasia</label>
                <input type="text" id="nom_fantasia_comercio" name="nom_fantasia_comercio"
                       value="{{ old('nom_fantasia_comercio') }}" required>
            </div>

            <div class="form-group">
                <label for="end_comercio">Endereço</label>
                <input type="text" id="end_comercio" name="end_comercio" value="{{ old('end_comercio') }}" required>
            </div>

            <div class="form-group">
                <label for="bai_comercio">Bairro</label>
                <input type="text" id="bai_comercio" name="bai_comercio" value="{{ old('bai_comercio') }}" required>
            </div>

            <div class="form-row">
                <div class="form-group small">
                    <label for="cep_comercio">CEP</label>
                    <input type="text" id="cep_comercio" name="cep_comercio" value="{{ old('cep_comercio') }}" required>
                </div>

                <div class="form-group small">
                    <label for="uf_comercio">UF</label>
                    <input type="text" id="uf_comercio" name="uf_comercio" value="{{ old('uf_comercio') }}"
                           maxlength="2" required>
                </div>
            </div>

            <div class="form-group">
                <label for="cid_comercio">Cidade</label>
                <input type="text" id="cid_comercio" name="cid_comercio" value="{{ old('cid_comercio') }}" required>
            </div>

            <div class="form-group">
                <label for="con_comercio">Contato</label>
                <input type="text" id="con_comercio" name="con_comercio" value="{{ old('con_comercio') }}" required>
            </div>

            <div class="form-group">
                <label for="email_comercio">Email</label>
                <input type="email" id="email_comercio" name="email_comercio" value="{{ old('email_comercio') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="sen_comercio">Senha</label>
                <input type="password" id="sen_comercio" name="sen_comercio" required>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>

            <p class="login-option">
                Já possui cadastro?
                <a href="{{ route('comercio.login') }}">Clique aqui para fazer login</a>
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
            align-items: flex-start;
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
