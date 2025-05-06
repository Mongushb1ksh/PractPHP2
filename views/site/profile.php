<h2>Мой профиль</h2>

<p>Имя: <?= htmlspecialchars(app()->auth::user()->name) ?></p>
<p>Фамилия: <?= htmlspecialchars(app()->auth::user()->lastName) ?></p>
<p>Ваша роль: <?= htmlspecialchars(app()->auth::user()->role) ?></p>
