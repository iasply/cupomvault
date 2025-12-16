@php
    $comercio = session('comercio');

    $usuarioNome  = $comercio->nom_fantasia_comercio ?? 'Comércio';
    $usuarioEmail = $comercio->email_comercio ?? '';

    $logoutRoute = 'comercio.logout';

    $menu = [
        ['label' => 'Início', 'route' => 'comercio.home', 'icon' => '🏠'],
        ['label' => 'Meus Cupons', 'route' => 'comercio.cupons', 'icon' => '🎟️'],
        ['label' => 'Meu Perfil', 'route' => 'comercio.perfil', 'icon' => '👤'],
        ['label' => 'Ativar Cupom', 'route' => 'comercio.usar', 'icon' => '💸'],
    ];
@endphp

@extends('layouts.base')

@section('content')
    @yield('content')
@endsection
