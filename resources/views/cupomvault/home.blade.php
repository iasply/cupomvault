@extends('layouts.app')

@section('title', 'Cupom Vault - Home')

@section('content')
    <div class="container">
        <h2>Bem-vindo ao Cupom Vault 🎟️</h2>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <p>Escolha uma opção para continuar:</p>

        <div class="menu-home">
            <a href="{{ route('comercio.login') }}" class="btn btn-primary">Acessar como Comércio</a>
            <a href="{{ route('associado.login') }}" class="btn btn-secondary">Acessar como Associado</a>
        </div>
    </div>

    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
            background-color: #f7f9fc;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .menu-home {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            color: #fff;
            transition: background-color 0.2s ease;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

        .btn-secondary {
            background-color: #6f42c1;
        }

        .btn-secondary:hover {
            background-color: #5936a3;
        }

        .success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
@endsection
