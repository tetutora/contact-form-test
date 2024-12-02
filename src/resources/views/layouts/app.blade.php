<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashionably Late</title>
    <link rel="stylesheet" href="{{asset ('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{asset ('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="/" class="header__logo">Fashionably Late</a>
            <!-- 新規登録ページの時のみナビゲーションを表示 -->
            @if (request()->is('register'))
                <nav class="login-nav">
                    <ul class="header-nav">
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/login">login</a>
                        </li>
                    </ul>
                </nav>
            @endif
            <!-- 新規登録ページの時のみナビゲーションを表示 -->
            @if (request()->is('login'))
                <nav class="login-nav">
                    <ul class="header-nav">
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/register">register</a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </header>

    <main>
        @yield('content')
    </main>


</body>
</html>