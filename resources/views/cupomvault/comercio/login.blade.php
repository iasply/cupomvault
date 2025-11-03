@extends('layouts.app')

@section('title', 'Login do Comércio')

@section('content')
    <h2>Login do Comércio</h2>

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('comercio.autenticar') }}">
        @csrf

        <label for="email_comercio">E-mail</label>
        <input type="email" id="email_comercio" name="email_comercio" required>

        <label for="sen_comercio">Senha</label>
        <input type="password" id="sen_comercio" name="sen_comercio" required>

        <button type="submit">Entrar</button>
    </form>

    <p style="text-align:center; margin-top: 15px;">
        <a href="{{ route('comercio.create') }}">Cadastrar novo comércio</a>
    </p>
@endsection
