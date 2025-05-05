<h2>Административная панель</h2>
<div>
    <h4>Пользователи системы</h4>
    <table>
        <thead>
           <tr>
               <th>ID</th>
               <th>Логин</th>
               <th>Роль</th>
               <th>Дата создания</th>
               <th>Действия</th>
           </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= htmlspecialchars($user->login) ?></td>
                <td>
                    <span class="badge bg-<?= $user->role === 'admin' ? 'danger' : 'primary' ?>">
                        <?= $user->role ?>
                    </span>
                </td>
                <td><?= date('d.m.Y', strtotime($user->created_at)) ?></td>
                <td>
                    <a href="/users/<?= $user->id ?>/edit" class="btn btn-sm btn-warning">Изменить</a>
                    <a href="/users/<?= $user->id ?>/delete" class="btn btn-sm btn-danger">Удалить</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>