<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Minha Aplicação')</title>
    @vite('resources/js/app.js')
</head>
<body>
    <header>
        <nav class="container">
            @auth
              <span>Olá, {{auth()->user()->name}}</span>
              <form action="/logout" method="POST">
                @csrf
                <button type="submit">Sair</button>
              </form>
            @endauth
          </nav>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        
    </footer>
</body>
</html>