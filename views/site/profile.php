<h2>Мой профиль</h2>

<p>Имя: <?= htmlspecialchars(app()->auth::user()->name) ?></p>
<p>Фамилия: <?= htmlspecialchars(app()->auth::user()->lastName) ?></p>
<p>Ваша роль: <?= htmlspecialchars(app()->auth::user()->role) ?></p>


<style>
        h2 {
        margin-top: 10%;
        color: #2c3e50;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e9ecef;
        font-weight: 600;
    }
</style>