@php
    $associado = session('associado');

    $usuarioNome = $associado->nom_associado ?? 'Associado';
    $usuarioEmail = $associado->email_associado ?? '';

    $logoutRoute = 'associado.logout';

    $menu = [
        ['label' => 'Início', 'route' => 'associado.home', 'icon' => '🏠'],
        ['label' => 'Meus Cupons', 'route' => 'associado.cupons', 'icon' => '🎟️'],
        ['label' => 'Meu Perfil', 'route' => 'associado.perfil', 'icon' => '👤'],
    ];
@endphp

@extends('layouts.base')
