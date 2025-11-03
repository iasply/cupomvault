<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CupomVault')</title>

    <style>
        /* ====== ESTILO GLOBAL ====== */
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --bg-color: #f4f6f8;
            --text-color: #333;
            --radius: 10px;
        }

        * {
            box-sizing: border-box;
            font-family: "Poppins", Arial, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            box-sizing: border-box; /* garante que padding e border não aumentem a largura */
            overflow-x: hidden; /* remove qualquer scroll horizontal */
        }

        *, *::before, *::after {
            box-sizing: inherit;
        }

        /* ====== CABEÇALHO ====== */
        header {
            background: var(--primary-color);
            color: #fff;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 1.5rem;
            margin: 0;
            letter-spacing: 1px;
        }

        nav a {
            color: #fff;
            margin-left: 20px;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.2s ease;
        }

        nav a:hover {
            opacity: 0.8;
        }

        /* ====== CONTEÚDO ====== */
        main {
            flex: 1;
            width: 100%;
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: var(--radius);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        h2 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 25px;
        }

        /* ====== ALERTAS ====== */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* ====== FORMULÁRIOS ====== */
        form label {
            display: block;
            font-weight: 600;
            margin-top: 15px;
            color: #444;
        }

        form input, form select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: border-color 0.2s ease;
        }

        form input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        button {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 20px;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* ====== RODAPÉ ====== */
        footer {
            text-align: center;
            padding: 15px;
            background: #fff;
            border-top: 1px solid #ddd;
            font-size: 0.9rem;
            color: #666;
            width: 100%;
        }

        @media (max-width: 600px) {
            main {
                margin: 20px;
                padding: 20px;
            }

            header {
                flex-direction: column;
                text-align: center;
            }

            nav {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>CupomVault</h1>
    <nav>
        <a href="{{ route('cupomvault.home') }}">Início</a>
        <a href="{{ route('comercio.login') }}">Comércios</a>
        <a href="{{ route('associado.login') }}">Associados</a>
    </nav>
</header>

<main>
    @yield('content')
</main>

<footer>
    &copy; {{ date('Y') }} CupomVault — Todos os direitos reservados.
</footer>

</body>
</html>
