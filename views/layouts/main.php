<!doctype html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link href="public/assets/css/styles.css" rel="stylesheet">
   <title>Pop it MVC</title>
</head>
<body>
<header>
<nav>
    <?php if(app()->auth::check() && app()->auth::user()->role === 'admin'): ?>
        <a href="<?= app()->route->getUrl('/admin/dashboard') ?>">Административная панель</a>
    <?php endif; ?>

    <?php if (!app()->auth::check()): ?>
        <a href="<?= app()->route->getUrl('/') ?>">Вход</a>
        <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
    <?php else: ?>
        <a href="<?= app()->route->getUrl('/dashboard') ?>">Дашборд отдела кадров</a>
        <a href="<?= app()->route->getUrl('/profile') ?>">Профиль</a>
        <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= htmlspecialchars(app()->auth::user()->name) ?>)</a>
    <?php endif; ?>
</nav>
</header>
<main>
   <?= $content ?? '' ?>
</main>

</body>
</html>


<style>
    *{
        margin: 0;
        padding: 0;
    }
    header{
        display: flex;
        justify-content: end;
        align-items: center;
        height: 70px;
        background: #2C7EAF;
    }
    header>nav{
        display: flex;
        gap: 10%;
        justify-content: end;
        align-items: center;
        margin: 0 10%;

    }
    header>nav>a{
        text-decoration: none;
        color: white;

    }

    main{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

</style>
