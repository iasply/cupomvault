@extends('layouts.app')

@section('title', 'Login do Associado')

@section('content')
    <h2>Login do Associado</h2>

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('associado.autenticar') }}">
        @csrf

        <label for="email_associado">E-mail</label>
        <input type="email" id="email_associado" name="email_associado" required>

        <label for="sen_associado">Senha</label>
        <input type="password" id="sen_associado" name="sen_associado" required>

        <button type="submit">Entrar</button>
    </form>

    <p style="text-align:center; margin-top: 15px;">
        <a href="{{ route('associado.create') }}">Cadastrar novo Associado</a>
    </p>
@endsection
