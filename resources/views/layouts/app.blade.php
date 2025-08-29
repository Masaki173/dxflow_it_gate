<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '問い合わせ管理システム')</title>
    @vite('resources/css/app.css')  {{-- TailwindCSS --}}
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto p-4">
        @yield('content')
    </div>
</body>
</html>

